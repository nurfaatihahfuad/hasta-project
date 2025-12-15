<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .required:after {
            content: " *";
            color: #ef4444;
        }
        .customer-fields {
            transition: all 0.3s ease;
        }
        .tab-active {
            background-color: #3b82f6;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 text-white py-6 px-8">
                <h2 class="text-3xl font-bold text-center">Customer Registration</h2>
                <p class="text-center text-blue-100 mt-2">Create your customer account</p>
            </div>

            <!-- Form -->
            <div class="p-8">
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    Please fix the following errors:
                                </p>
                                <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('customer.register') }}" class="space-y-8">
                    @csrf

                    <!-- Customer Type Selection -->
                    <div class="border-b border-gray-200">
                        <div class="flex space-x-4 mb-6">
                            <button type="button" 
                                    onclick="selectCustomerType('student')" 
                                    id="studentTab" 
                                    class="tab-btn px-6 py-3 rounded-lg font-medium transition-all duration-300 tab-active">
                                <i class="fas fa-graduation-cap mr-2"></i>Student Customer
                            </button>
                            <button type="button" 
                                    onclick="selectCustomerType('staff')" 
                                    id="staffTab" 
                                    class="tab-btn px-6 py-3 rounded-lg font-medium transition-all duration-300 bg-gray-100 text-gray-700 hover:bg-gray-200">
                                <i class="fas fa-briefcase mr-2"></i>Staff Customer
                            </button>
                        </div>
                        
                        <input type="hidden" name="customerType" id="customerType" value="student">
                    </div>

                    <!-- Basic Information Section -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-user-circle mr-2 text-blue-500"></i> Basic Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <label for="name" class="block text-gray-700 font-medium mb-2 required">Full Name</label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Enter your full name">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-gray-700 font-medium mb-2 required">Email Address</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Enter your email">
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="noHP" class="block text-gray-700 font-medium mb-2 required">Phone Number</label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500">
                                        +60
                                    </span>
                                    <input type="text" 
                                           id="noHP" 
                                           name="noHP" 
                                           value="{{ old('noHP') }}"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                           placeholder="123456789">
                                </div>
                            </div>

                            <!-- IC Number -->
                            <div>
                                <label for="noIC" class="block text-gray-700 font-medium mb-2 required">IC Number</label>
                                <input type="text" 
                                       id="noIC" 
                                       name="noIC" 
                                       value="{{ old('noIC') }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="e.g., 901231011234">
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-gray-700 font-medium mb-2 required">Password</label>
                                <div class="relative">
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                           placeholder="Minimum 8 characters">
                                    <button type="button" 
                                            onclick="togglePassword('password')"
                                            class="absolute right-3 top-3 text-gray-500 hover:text-gray-700">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Must be at least 8 characters</p>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-gray-700 font-medium mb-2 required">Confirm Password</label>
                                <div class="relative">
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                           placeholder="Confirm your password">
                                    <button type="button" 
                                            onclick="togglePassword('password_confirmation')"
                                            class="absolute right-3 top-3 text-gray-500 hover:text-gray-700">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Banking Information Section -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-university mr-2 text-green-500"></i> Banking Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Account Number -->
                            <div>
                                <label for="accountNumber" class="block text-gray-700 font-medium mb-2 required">Account Number</label>
                                <input type="text" 
                                       id="accountNumber" 
                                       name="accountNumber" 
                                       value="{{ old('accountNumber') }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Enter your bank account number">
                            </div>

                            <!-- Bank Type -->
                            <div>
                                <label for="bankType" class="block text-gray-700 font-medium mb-2 required">Bank Type</label>
                                <select id="bankType" 
                                        name="bankType" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                                    <option value="">Select Bank</option>
                                    @foreach($bankTypes as $bankType)
                                        <option value="{{ $bankType }}" {{ old('bankType') == $bankType ? 'selected' : '' }}>
                                            {{ $bankType }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Referral Code (Optional) -->
                            <div class="md:col-span-2">
                                <label for="referralCode" class="block text-gray-700 font-medium mb-2">Referral Code (Optional)</label>
                                <input type="text" 
                                       id="referralCode" 
                                       name="referralCode" 
                                       value="{{ old('referralCode') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Enter referral code if any">
                                <p class="mt-1 text-sm text-gray-500">If you have a referral code from an existing customer</p>
                            </div>
                        </div>
                    </div>

                    <!-- Student Customer Fields -->
                    <div id="studentFields" class="customer-fields bg-blue-50 p-6 rounded-lg border border-blue-200">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-graduation-cap mr-2 text-blue-600"></i> Student Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Matric Number -->
                            <div>
                                <label for="matricNo" class="block text-gray-700 font-medium mb-2 required">Matric Number</label>
                                <input type="text" 
                                       id="matricNo" 
                                       name="matricNo" 
                                       value="{{ old('matricNo') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="e.g., A12345">
                            </div>

                            <!-- Faculty -->
                            <div>
                                <label for="faculty" class="block text-gray-700 font-medium mb-2 required">Faculty</label>
                                <select id="faculty" 
                                        name="faculty" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                                    <option value="">Select Faculty</option>
                                    @foreach($faculties as $faculty)
                                        <option value="{{ $faculty }}" {{ old('faculty') == $faculty ? 'selected' : '' }}>
                                            {{ $faculty }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Residential College -->
                            <div>
                                <label for="residentialCollege" class="block text-gray-700 font-medium mb-2 required">Residential College</label>
                                <select id="residentialCollege" 
                                        name="residentialCollege" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                                    <option value="">Select Residential College</option>
                                    @foreach($residentialColleges as $residentialCollege)
                                        <option value="{{ $residentialCollege }}" {{ old('residentialCollege') == $residentialCollege ? 'selected' : '' }}>
                                            {{ $residentialCollege }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> 
                        </div>
                    </div>

                    <!-- Staff Customer Fields -->
                    <div id="staffFields" class="customer-fields hidden bg-purple-50 p-6 rounded-lg border border-purple-200">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-briefcase mr-2 text-purple-600"></i> Staff Information
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Staff Number -->
                            <div>
                                <label for="staffNo" class="block text-gray-700 font-medium mb-2 required">Staff Number</label>
                                <input type="text" 
                                       id="staffNo" 
                                       name="staffNo" 
                                       value="{{ old('staffNo') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="e.g., STF12345">
                            </div>

                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                                            <input type="checkbox" 
                                           id="terms" 
                                           name="terms" 
                                           required
                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                        </div>
                        <label for="terms" class="ml-2 text-sm text-gray-700">
                            I agree to the 
                            <a href="#" class="text-blue-600 hover:text-blue-800 hover:underline">Terms of Service</a> 
                            and 
                            <a href="#" class="text-blue-600 hover:text-blue-800 hover:underline">Privacy Policy</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white font-bold py-4 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition duration-300 flex items-center justify-center">
                            <i class="fas fa-user-plus mr-2"></i> Register Now
                        </button>
                    </div>

                    <!-- Login Link 
                    <div class="text-center">
                        <p class="text-gray-600">
                            Already have an account? 
                            <a href="" class="text-blue-600 font-semibold hover:text-blue-800 hover:underline">
                                Sign in here
                            </a>
                        </p>
                    </div>-->
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle between student and staff tabs
        function selectCustomerType(type) {
            // Update hidden input
            document.getElementById('customerType').value = type;
            
            // Update tab styles
            const tabs = document.querySelectorAll('.tab-btn');
            tabs.forEach(tab => {
                if (tab.id === type + 'Tab') {
                    tab.classList.add('tab-active', 'bg-blue-600', 'text-white');
                    tab.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                } else {
                    tab.classList.remove('tab-active', 'bg-blue-600', 'text-white');
                    tab.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                }
            });
            
            // Show/hide fields
            if (type === 'student') {
                document.getElementById('studentFields').classList.remove('hidden');
                document.getElementById('staffFields').classList.add('hidden');
                
                // Set required for student fields
                document.getElementById('matricNo').required = true;
                document.getElementById('faculty').required = true;
                document.getElementById('residentialCollege').required = true;
                
                // Remove required from staff fields
                document.getElementById('staffNo').required = false;
            } else {
                document.getElementById('studentFields').classList.add('hidden');
                document.getElementById('staffFields').classList.remove('hidden');
                
                // Set required for staff fields
                document.getElementById('staffNo').required = true;
                
                // Remove required from student fields
                document.getElementById('matricNo').required = false;
                document.getElementById('faculty').required = false;
                document.getElementById('residentialCollege').required = false;
            }
        }
        
        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
            field.setAttribute('type', type);
        }
        
        // Form validation before submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const customerType = document.getElementById('customerType').value;
            
            if (customerType === 'student') {
                const requiredFields = ['matricNo', 'faculty', 'residentialCollege'];
                for (let field of requiredFields) {
                    if (!document.getElementById(field).value.trim()) {
                        e.preventDefault();
                        alert(`Please fill in all student information fields.`);
                        document.getElementById(field).focus();
                        return;
                    }
                }
            } else {
                const requiredFields = ['staffNo'];
                for (let field of requiredFields) {
                    if (!document.getElementById(field).value.trim()) {
                        e.preventDefault();
                        alert(`Please fill in all staff information fields.`);
                        document.getElementById(field).focus();
                        return;
                    }
                }
            }
        });
        
        // Initialize based on old input or default
        document.addEventListener('DOMContentLoaded', function() {
            const oldType = "{{ old('customerType', 'student') }}";
            selectCustomerType(oldType);
        });
    </script>
</body>
</html>