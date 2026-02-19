@extends('layouts.auth')

@section('content')
    <style>
        /* Custom Animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        .gradient-bg {
            background: linear-gradient(-45deg, #667eea, #764ba2, #6b8cff, #a855f7);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        .slide-in {
            animation: slideIn 0.5s ease forwards;
        }

        /* Modern Card Styles */
        .glass-morphism {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        /* Input Styles */
        .modern-input {
            border: 2px solid #eef2f6;
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            background: #f8fafc;
            width: 100%;
        }

        .modern-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: white;
            outline: none;
        }

        .modern-input.error {
            border-color: #ef4444;
        }

        /* Button Styles */
        .gradient-button {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            padding: 14px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .gradient-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .gradient-button:hover::before {
            left: 100%;
        }

        .gradient-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.3);
        }

        /* Select Input Styling */
        .modern-select {
            border: 2px solid #eef2f6;
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            background: #f8fafc;
            width: 100%;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
        }

        .modern-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: white;
            outline: none;
        }

        /* Checkbox Styling */
        .modern-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid #eef2f6;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .modern-checkbox:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        /* Feature Badge */
        .feature-badge {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 30px;
            padding: 8px 16px;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Progress Steps */
        .progress-step {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        .step-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
        }

        /* Label Style */
        .form-label-custom {
            display: block;
            color: #1f2937;
            font-weight: 500;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .form-label-custom span.required {
            color: #ef4444;
            margin-left: 4px;
        }

        /* Password Strength Meter */
        .password-strength {
            height: 4px;
            background: #eef2f6;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
        }

        .password-strength-bar.weak { width: 33.33%; background: #ef4444; }
        .password-strength-bar.medium { width: 66.66%; background: #f59e0b; }
        .password-strength-bar.strong { width: 100%; background: #10b981; }

        /* Error Message */
        .error-message {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Success Animation */
        .success-checkmark {
            width: 80px;
            height: 80px;
            margin: 0 auto;
        }

        .check-icon {
            width: 80px;
            height: 80px;
            position: relative;
            border-radius: 50%;
            box-sizing: content-box;
            border: 4px solid #4CAF50;
        }

        /* Tooltip */
        .info-tooltip {
            position: relative;
            display: inline-block;
            margin-left: 4px;
            color: #94a3b8;
            cursor: help;
        }

        .info-tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        .tooltip-text {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #1f2937;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 12px;
            white-space: nowrap;
            transition: all 0.3s ease;
            z-index: 10;
        }
    </style>

    <!-- Sign Up Area Start -->
    <section class="min-vh-100 d-flex align-items-center gradient-bg py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="glass-morphism">
                        <div class="row g-0">
                            <!-- Left Side - Branding & Features -->
                            <div class="col-lg-5 p-5 text-white position-relative overflow-hidden"
                                 style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.95) 0%, rgba(118, 75, 162, 0.95) 100%);">

                                <!-- Decorative Elements -->
                                <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10">
                                    <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
                                        <circle cx="10" cy="10" r="80" fill="white" opacity="0.1"/>
                                        <circle cx="90" cy="90" r="60" fill="white" opacity="0.1"/>
                                        <circle cx="20" cy="80" r="40" fill="white" opacity="0.1"/>
                                    </svg>
                                </div>

                                <div class="position-relative" style="z-index: 2;">
                                    <!-- Logo -->
                                    <div class="mb-5">
                                        <a href="{{ route('main.index') }}" class="d-inline-block">
                                            <img src="{{getImageFile(get_option('app_logo'))}}"
                                                 alt="logo"
                                                 class="img-fluid"
                                                 style="max-height: 50px; filter: brightness(0) invert(1);">
                                        </a>
                                    </div>

                                    <!-- Welcome Message -->
                                    <div class="mb-5">
                                        <h2 class="text-white fw-bold mb-3 slide-in" style="font-size: 2.5rem;">
                                            {{ __('Join Us Today!') }}
                                        </h2>
                                        <p class="text-white-50 mb-4 slide-in" style="animation-delay: 0.1s;">
                                            {{ __(get_option('sign_up_left_text')) }}
                                        </p>
                                    </div>

                                    <!-- Features List -->
                                    <div class="mb-5">
                                        <div class="progress-step slide-in" style="animation-delay: 0.2s;">
                                            <div class="step-number">1</div>
                                            <div class="step-text">{{ __('Create your account') }}</div>
                                        </div>
                                        <div class="progress-step slide-in" style="animation-delay: 0.3s;">
                                            <div class="step-number">2</div>
                                            <div class="step-text">{{ __('Explore our courses') }}</div>
                                        </div>
                                        <div class="progress-step slide-in" style="animation-delay: 0.4s;">
                                            <div class="step-number">3</div>
                                            <div class="step-text">{{ __('Start learning') }}</div>
                                        </div>
                                    </div>

                                    <!-- Stats -->
                                    <div class="d-flex gap-4 slide-in" style="animation-delay: 0.5s;">
                                        <div>
                                            <div class="feature-badge">
                                                <i class="fas fa-users"></i>
                                                <span>10,000+ {{ __('Students') }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="feature-badge">
                                                <i class="fas fa-book-open"></i>
                                                <span>500+ {{ __('Courses') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Left Image -->
                                    @if(get_option('sign_up_left_image'))
                                        <div class="sign-up-bottom-img mt-5 text-center slide-in" style="animation-delay: 0.6s;">
                                            <img src="{{getImageFile(get_option('sign_up_left_image'))}}"
                                                 alt="hero"
                                                 class="img-fluid rounded-3 shadow-lg"
                                                 style="max-height: 200px;">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Right Side - Sign Up Form -->
                            <div class="col-lg-7 p-5 bg-white">
                                <div class="h-100 d-flex flex-column">
                                    <!-- Header -->
                                    <div class="text-end mb-4">
                                    <span class="badge bg-light text-dark px-3 py-2 rounded-pill">
                                        <i class="fas fa-rocket me-2 text-primary"></i>{{ __('Get Started Free') }}
                                    </span>
                                    </div>

                                    <!-- Form -->
                                    <form method="POST" action="{{route('store.sign-up')}}" class="flex-grow-1">
                                        @csrf

                                        <!-- Title -->
                                        <h3 class="fw-bold mb-2">{{ __('Create an Account') }}</h3>
                                        <p class="text-muted mb-4">
                                            {{ __('Already have an account?') }}
                                            <a href="{{route('login')}}" class="text-primary text-decoration-none fw-medium">
                                                {{ __('Sign In') }} <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </p>

                                        <!-- Email -->
                                        <div class="mb-4">
                                            <label class="form-label-custom" for="email">
                                                <i class="fas fa-envelope me-2 text-primary"></i>{{ __('Email') }}
                                                <span class="required">*</span>
                                                <span class="info-tooltip">
                                                <i class="fas fa-info-circle"></i>
                                                <span class="tooltip-text">{{ __('We\'ll never share your email') }}</span>
                                            </span>
                                            </label>
                                            <input type="email"
                                                   name="email"
                                                   id="email"
                                                   value="{{old('email')}}"
                                                   class="modern-input @error('email') error @enderror"
                                                   placeholder="Enter your email address"
                                                   required>
                                            @error('email')
                                            <span class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </span>
                                            @enderror
                                        </div>

                                        <!-- Phone Code and Number -->
                                        <div class="row mb-4">
                                            <div class="col-md-4">
                                                <label class="form-label-custom" for="area_code">
                                                    <i class="fas fa-globe me-2 text-primary"></i>{{ __('Code') }}
                                                </label>
                                                <select class="modern-select" name="area_code" id="area_code">
                                                    <option value="">{{ __('Select Code') }}</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->phonecode }}"
                                                                @if(old('area_code')==$country->phonecode) selected @endif>
                                                            {{ $country->short_name.' ('.$country->phonecode.')' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('area_code')
                                                <span class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label-custom" for="mobile_number">
                                                    <i class="fas fa-phone me-2 text-primary"></i>{{ __('Phone Number') }}
                                                </label>
                                                <input type="text"
                                                       name="mobile_number"
                                                       id="mobile_number"
                                                       value="{{old('mobile_number')}}"
                                                       class="modern-input @error('mobile_number') error @enderror"
                                                       placeholder="Enter your phone number">
                                                @error('mobile_number')
                                                <span class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- First Name and Last Name -->
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <label class="form-label-custom" for="first_name">
                                                    <i class="fas fa-user me-2 text-primary"></i>{{ __('First Name') }}
                                                    <span class="required">*</span>
                                                </label>
                                                <input type="text"
                                                       name="first_name"
                                                       id="first_name"
                                                       value="{{old('first_name')}}"
                                                       class="modern-input @error('first_name') error @enderror"
                                                       placeholder="Enter first name"
                                                       required>
                                                @error('first_name')
                                                <span class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label-custom" for="last_name">
                                                    <i class="fas fa-user me-2 text-primary"></i>{{ __('Last Name') }}
                                                    <span class="required">*</span>
                                                </label>
                                                <input type="text"
                                                       name="last_name"
                                                       id="last_name"
                                                       value="{{old('last_name')}}"
                                                       class="modern-input @error('last_name') error @enderror"
                                                       placeholder="Enter last name"
                                                       required>
                                                @error('last_name')
                                                <span class="error-message">
                                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                            </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Password -->
                                        <div class="mb-4">
                                            <label class="form-label-custom" for="password">
                                                <i class="fas fa-lock me-2 text-primary"></i>{{ __('Password') }}
                                                <span class="required">*</span>
                                            </label>
                                            <div class="position-relative">
                                                <input type="password"
                                                       name="password"
                                                       id="password"
                                                       value="{{old('password')}}"
                                                       class="modern-input password @error('password') error @enderror"
                                                       placeholder="Create a strong password"
                                                       required>
                                                <span class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3 text-muted cursor-pointer">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                            </div>
                                            <!-- Password Strength Meter -->
                                            <div class="password-strength mt-2">
                                                <div class="password-strength-bar" id="passwordStrength"></div>
                                            </div>
                                            <small class="text-muted" id="passwordHint">
                                                {{ __('Use at least 8 characters with letters and numbers') }}
                                            </small>
                                            @error('password')
                                            <span class="error-message">
                                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </span>
                                            @enderror
                                        </div>

                                        <!-- Terms and Conditions -->
                                        <div class="mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input modern-checkbox"
                                                       type="checkbox"
                                                       id="termsCheck"
                                                       checked
                                                       required>
                                                <label class="form-check-label text-muted" for="termsCheck">
                                                    {{ __('By clicking Create account, I agree that I have read and accepted the') }}
                                                    <a href="{{ route('terms-conditions') }}"
                                                       class="text-primary text-decoration-underline">Terms of Use</a>
                                                    {{ __('and') }}
                                                    <a href="{{ route('privacy-policy') }}"
                                                       class="text-primary text-decoration-underline">Privacy Policy.</a>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit" class="gradient-button mb-4" id="submitBtn">
                                            <i class="fas fa-user-plus me-2"></i>{{ __('Create Account') }}
                                        </button>

                                        <!-- Alternative Sign Up -->
                                        <div class="text-center">
                                            <p class="text-muted small mb-0">
                                                {{ __('By signing up, you agree to our') }}
                                                <a href="{{ route('terms-conditions') }}" class="text-primary">Terms</a>
                                                {{ __('and') }}
                                                <a href="{{ route('privacy-policy') }}" class="text-primary">Privacy Policy</a>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Sing Up Area End -->

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-body text-center p-5">
                    <div class="success-checkmark mb-4">
                        <div class="check-icon">
                            <span class="icon-check"></span>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-3">{{ __('Account Created Successfully!') }}</h4>
                    <p class="text-muted mb-4">{{ __('Please check your email to verify your account.') }}</p>
                    <a href="{{ route('login') }}" class="gradient-button" style="width: auto; padding: 12px 30px;">
                        <i class="fas fa-sign-in-alt me-2"></i>{{ __('Go to Login') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict"

        // Password Toggle
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.closest('.position-relative').querySelector('input');
                const iconElement = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    iconElement.classList.remove('fa-eye');
                    iconElement.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    iconElement.classList.remove('fa-eye-slash');
                    iconElement.classList.add('fa-eye');
                }
            });
        });

        // Password Strength Checker
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('passwordStrength');
        const passwordHint = document.getElementById('passwordHint');

        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;

                // Check length
                if (password.length >= 8) strength++;
                if (password.length >= 12) strength++;

                // Check for numbers
                if (/\d/.test(password)) strength++;

                // Check for special characters
                if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;

                // Check for uppercase
                if (/[A-Z]/.test(password)) strength++;

                // Update strength bar
                strengthBar.className = 'password-strength-bar';
                if (strength <= 2) {
                    strengthBar.classList.add('weak');
                    passwordHint.innerHTML = '{{ __("Weak password. Use stronger combination.") }}';
                } else if (strength <= 4) {
                    strengthBar.classList.add('medium');
                    passwordHint.innerHTML = '{{ __("Medium password. Add more variety.") }}';
                } else {
                    strengthBar.classList.add('strong');
                    passwordHint.innerHTML = '{{ __("Strong password!") }}';
                }
            });
        }

        // Form Submission Animation
        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submitBtn');

        if (form) {
            form.addEventListener('submit', function(e) {
                if (form.checkValidity()) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>{{ __("Creating Account...") }}';
                    submitBtn.disabled = true;
                }
            });
        }

        // Phone Number Formatting
        const phoneInput = document.getElementById('mobile_number');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = this.value.replace(/\D/g, '');
                if (value.length > 10) value = value.slice(0, 10);
                this.value = value;
            });
        }

        // Check if registration was successful (you can trigger this from controller)
        @if(session('success'))
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
        @endif

        // Floating labels effect
        document.querySelectorAll('.modern-input').forEach(input => {
            if (input.value) {
                input.classList.add('filled');
            }

            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
                if (this.value) {
                    this.classList.add('filled');
                } else {
                    this.classList.remove('filled');
                }
            });
        });

        // Smooth scroll to errors
        @if($errors->any())
        const firstError = document.querySelector('.error-message');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        @endif
    </script>
@endpush