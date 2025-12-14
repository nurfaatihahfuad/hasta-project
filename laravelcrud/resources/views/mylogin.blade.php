{{-- resources/views/mylogin.blade.php --}}
@extends('layouts.app')

@section('title', 'Login - HASTA Booking System')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/mylogin.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    /* Additional styles for HASTA theme */
    :root {
        --hasta-red: #9E122C;
        --hasta-light-red: #CB3737;
        --hasta-beige: #FCECDF;
    }
    
    .login-wrapper {
        background: linear-gradient(135deg, var(--hasta-red) 0%, var(--hasta-light-red) 100%);
    }
    
    .login-box {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    
    .login-icon {
        background: linear-gradient(135deg, var(--hasta-red), var(--hasta-light-red));
        color: white;
    }
    
    button[type="submit"] {
        background: linear-gradient(135deg, var(--hasta-red), var(--hasta-light-red));
        border: none;
    }
    
    button[type="submit"]:hover {
        background: linear-gradient(135deg, var(--hasta-light-red), var(--hasta-red));
        transform: translateY(-2px);
    }
    
    .forgot-password, .signup-text a {
        color: var(--hasta-red);
    }
    
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }
</style>
@endsection

@section('content')
<div class="login-wrapper">
    <div class="login-box">
      
      <!-- HASTA Logo -->
      <div class="text-center mb-4">
        <img src="{{ asset('img/hasta.jpeg') }}" alt="HASTA Logo" width="150" class="mb-3">
      </div>
      
      <!-- Icon -->
      <div class="login-icon">
        <i class="fas fa-lock"></i>
      </div>
      
      <!-- Title -->
      <h1 class="text-danger">Welcome Back!</h1>
      <p class="subtitle">Log in to your HASTA Booking account</p>
      
      <!-- Display Success Message -->
      @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
      @endif
      
      <!-- Display Error Message -->
      @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
      @endif
      
      <!-- Display Validation Errors -->
      @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif
      
      <!-- Login Form -->
      <form method="POST" action="{{ route('login.submit') }}" class="form-container">
        @csrf
        
        <div class="input-group">
          <label for="username" class="form-label">
            <i class="fas fa-user text-danger"></i> Username
          </label>
          <input type="text" id="username" name="username" 
                 class="form-control"
                 placeholder="Enter your username" 
                 value="{{ old('username') }}"
                 required
                 autofocus>
        </div>
        
        <div class="input-group">
          <label for="password" class="form-label">
            <i class="fas fa-lock text-danger"></i> Password
          </label>
          <input type="password" id="password" name="password" 
                 class="form-control"
                 placeholder="Enter your password" 
                 required>
        </div>
        
        <div class="options">
          <div class="remember-me">
            <input type="checkbox" id="remember" name="remember" class="form-check-input">
            <label for="remember" class="form-check-label">Remember me</label>
          </div>
          <a href="#" class="forgot-password">
            <i class="fas fa-key"></i> Forgot Password?
          </a>
        </div>
        
        <button type="submit" class="btn btn-login">
          <i class="fas fa-sign-in-alt"></i> LOGIN TO DASHBOARD
        </button>
      </form>
      
      <!-- Test Credentials -->
      <div class="test-credentials mt-4 p-3 bg-light rounded">
        <p class="mb-2"><strong><i class="fas fa-vial text-danger"></i> Test Credentials:</strong></p>
        <div class="row">
          <div class="col-6">
            <small class="text-muted">
              <i class="fas fa-crown text-warning"></i> Admin<br>
              <code>admin</code> / <code>admin123</code>
            </small>
          </div>
          <div class="col-6">
            <small class="text-muted">
              <i class="fas fa-user text-primary"></i> User<br>
              <code>user</code> / <code>password123</code>
            </small>
          </div>
        </div>
      </div>
      
      <!-- Sign up link -->
      <p class="signup-text mt-4">
        Don't have an account?
        <a href="#" class="fw-bold">
          <i class="fas fa-user-plus"></i> Sign up now
        </a>
      </p>
      
      <!-- Back to home -->
      <div class="text-center mt-3">
        <a href="{{ url('/') }}" class="text-decoration-none">
          <i class="fas fa-arrow-left"></i> Back to Homepage
        </a>
      </div>
      
    </div> <!-- end .login-box -->
    
    <!-- Terms text -->
    <p class="terms-text">
      <i class="fas fa-shield-alt"></i> By logging in, you agree to 
      <a href="#" class="text-white">HASTA Terms of Use</a> and 
      <a href="#" class="text-white">Privacy Policy</a>.
    </p>
    
    <!-- Get help button -->
    <div class="help-container">
      <a href="mailto:hastatraveltours@gmail.com" class="help-link">
        <span><i class="fas fa-life-ring"></i> Get help</span>
        <span class="help-icon">?</span>
      </a>
    </div>
    
  </div> <!-- end .login-wrapper -->
@endsection

@section('scripts')
<script>
    // Add some interactivity
    document.addEventListener('DOMContentLoaded', function() {
        // Focus on username field
        document.getElementById('username').focus();
        
        // Add animation to login button
        const loginBtn = document.querySelector('.btn-login');
        loginBtn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 8px 20px rgba(158, 18, 44, 0.4)';
        });
        
        loginBtn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = 'none';
        });
        
        // Show/hide password (optional feature)
        const togglePassword = document.createElement('span');
        togglePassword.innerHTML = '<i class="fas fa-eye"></i>';
        togglePassword.className = 'password-toggle';
        togglePassword.style.cssText = 'position: absolute; right: 15px; top: 40px; cursor: pointer; color: #666;';
        
        const passwordField = document.getElementById('password');
        passwordField.parentNode.style.position = 'relative';
        passwordField.parentNode.appendChild(togglePassword);
        
        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
    });
</script>
@endsection