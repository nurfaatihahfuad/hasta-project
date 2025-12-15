<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\StudentCustomer;
use App\Models\StaffCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CustomerRegistrationController extends Controller
{
    // Show registration form
    public function create()
    {
        // Get faculties and departments for dropdowns
        $faculties = [
            'Faculty of Engineering',
            'Faculty of Science',
            'Faculty of Medicine',
            'Faculty of Business',
            'Faculty of Arts',
            'Faculty of Law',
            'Faculty of Education',
            'Faculty of Computing',
            'Faculty of Architecture',
            'Faculty of Pharmacy'
        ];

        $residentialColleges = [
            'KTDI',
            'KTHO',
            'KTF',
            'KTR'
        ];

        $bankTypes = [
            'Maybank',
            'CIMB',
            'Public Bank',
            'RHB',
            'Hong Leong Bank',
            'Ambank',
            'HSBC Malaysia',
            'OCBC Malaysia',
            'Bank Rakyat',
            'Bank Islam',
            'Affin Bank',
            'Alliance Bank',
            'BSN'
        ];
        

        return view('customers.register', compact('faculties','residentialColleges','bankTypes'));
    }

    // Handle registration submission
    public function store(Request $request)
    {
        // Trim all inputs
        $request->merge(array_map('trim', $request->all()));

        // Base validation rules for all users
        $validationRules = [
            // User information
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:user',
            'password' => 'required|string|min:8|confirmed',
            'noHP' => 'required|string|max:20',
            'noIC' => 'required|string|max:20|unique:user',
            
            // Customer type
            'customerType' => 'required|in:student,staff',
            
            // Customer information
            'referralCode' => 'nullable|string|max:50|unique:customer,referralCode',
            'accountNumber' => 'required|string|max:50',
            'bankType' => 'required|string|max:50|in:Maybank,CIMB,Public Bank,RHB,Hong Leong Bank,Ambank,HSBC Malaysia,OCBC Malaysia,Bank Rakyat,Bank Islam,Affin Bank,Alliance Bank,BSN',
            
            // Terms acceptance
            'terms' => 'required|accepted',
        ];

        // Add conditional validation based on customer type
        if ($request->customerType === 'student') {
            $validationRules['matricNo'] = 'required|string|max:50|unique:studentcustomer,matricNo';
            $validationRules['faculty'] = 'required|string|max:100';
            $validationRules['residentialCollege'] = 'required|string|max:100';
        } else {
            $validationRules['staffNo'] = 'required|string|max:50|unique:staffcustomer,staffNo';
        }

        // Validate the request
        $validated = $request->validate($validationRules);

        // Start database transaction
        DB::beginTransaction();

        try {
            // 1. Create User
            $user = User::create([
                'password' => Hash::make($validated['password']),
                'name' => $validated['name'],
                'noHP' => $validated['noHP'],
                'email' => $validated['email'],
                'noIC' => $validated['noIC'],
                'userType' => 'customer',
            ]);

            // 2. Generate referral code if not provided
            $referralCode = $validated['referralCode'] ?? $this->generateReferralCode();

            // 3. Create Customer
            $customer = Customer::create([
                'userID' => $user->userID,
                'referralCode' => $referralCode,
                'accountNumber' => $validated['accountNumber'],
                'bankType' => $validated['bankType'],
                'customerType' => $validated['customerType'],
            ]);

            // 4. Create specific customer type record
            if ($validated['customerType'] === 'student') {
                StudentCustomer::create([
                    'userID' => $user->userID,
                    'matricNo' => $validated['matricNo'],
                    'faculty' => $validated['faculty'],
                    'residentialCollege' => $validated['residentialCollege']
                ]);
            } else {
                StaffCustomer::create([
                    'userID' => $user->userID,
                    'staffNo' => $validated['staffNo']
                ]);
            }

            // Commit transaction
            DB::commit();

            // Log the user in automatically
            auth()->login($user);

            // Redirect to success page
            return redirect()->route('dashboard.index')->with('success', 'Login successful!');

        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            // Log the error
            \Log::error('Customer registration failed: ' . $e->getMessage());

            // Return with error message
            return back()
                ->withErrors(['error' => 'Registration failed. Please try again. If the problem persists, contact support.'])
                ->withInput()
                ->with('error_details', $e->getMessage());
        }
    }

    // check error
    /*public function store(Request $request)
    {
        // Debug: Show what we're receiving
        echo "<pre>";
        echo "Form Data Received:\n";
        print_r($request->all());
        echo "</pre>";
        
        try {
            // Test 1: Try to create user only
            echo "<h2>Test 1: Creating User</h2>";
            
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'noHP' => $request->noHP,
                'noIC' => $request->noIC,
                'userType' => 'customer',
            ]);
            
            echo "✅ User created! ID: " . $user->userID . "<br>";
            
            // Test 2: Check if customer table exists
            echo "<h2>Test 2: Checking customer table</h2>";
            $tableExists = DB::select("SHOW TABLES LIKE 'customer'");
            if (empty($tableExists)) {
                echo "❌ customer table doesn't exist!<br>";
            } else {
                echo "✅ customer table exists<br>";
            }
            
            // Test 3: Try to insert into customer
            echo "<h2>Test 3: Inserting into customer</h2>";
            $customerData = [
                'userID' => $user->userID,
                'referralCode' => 'TEST' . rand(1000, 9999),
                'accountNumber' => '1234567890',
                'bankType' => 'Maybank',
                'customerType' => 'student',
            ];
            
            DB::table('customer')->insert($customerData);
            echo "✅ Customer record inserted!<br>";
            
            return "✅ All tests passed!";
            
        } catch (\Exception $e) {
            echo "<h2 style='color: red;'>❌ ERROR:</h2>";
            echo "<p><strong>" . $e->getMessage() . "</strong></p>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
            die();
        }
    }*/

    // Generate unique referral code
    private function generateReferralCode()
    {
        do {
            $code = Str::upper(Str::random(8));
        } while (Customer::where('referralCode', $code)->exists());

        return $code;
    }

    // Show success page (optional)
    public function success()
    {
        return view('customers.success');
    }
}