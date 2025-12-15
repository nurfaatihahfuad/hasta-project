<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold text-blue-600">Customer Portal</h1>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-700 mr-4">Welcome, {{ auth()->user()->Name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Your Dashboard</h2>
                    
                    @php
                        $user = auth()->user();
                        $customer = $user->customer;
                    @endphp
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- User Info -->
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-800 mb-4">Personal Information</h3>
                            <p><strong>Name:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Phone:</strong> {{ $user->noHP }}</p>
                            <p><strong>Customer Type:</strong> {{ ucfirst($customer->customerType) }}</p>
                        </div>
                        
                        <!-- Account Info -->
                        <div class="bg-green-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800 mb-4">Account Information</h3>
                            <p><strong>Account Number:</strong> {{ $customer->accountNumber }}</p>
                            <p><strong>Bank Type:</strong> {{ $customer->bankType }}</p>
                            <p><strong>Referral Code:</strong> {{ $customer->referralCode }}</p>
                        </div>
                        
                        <!-- Type Specific Info -->
                        <div class="md:col-span-2 bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                {{ ucfirst($customer->customerType) }} Details
                            </h3>
                            
                            @if($customer->customerType === 'student' && $user->studentCustomer)
                                <p><strong>Matric Number:</strong> {{ $user->studentCustomer->matricNo }}</p>
                                <p><strong>Faculty:</strong> {{ $user->studentCustomer->faculty }}</p>
                                <p><strong>Residential College:</strong> Year {{ $user->studentCustomer->residentialCollege }}</p>
                            @elseif($customer->customerType === 'staff' && $user->staffCustomer)
                                <p><strong>Staff Number:</strong> {{ $user->staffCustomer->staffNo }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>