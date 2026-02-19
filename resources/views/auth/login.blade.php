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

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        .soft-gradient-bg {
            background: linear-gradient(-45deg, #f8f9ff, #f0f2fe, #e8ebfa, #f5f0ff);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        /* Modern Card Styles - Balanced */
        .light-glass-morphism {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 28px;
            box-shadow: 0 35px 70px rgba(0, 0, 0, 0.05), 0 0 0 1px rgba(0, 0, 0, 0.02);
        }

        /* Input Styles - Balanced */
        .modern-input-light {
            border: 1.8px solid #e9ebf0;
            border-radius: 16px !important;
            padding: 16px 22px !important;
            transition: all 0.3s ease;
            background: #ffffff;
            font-size: 1rem !important;
        }

        .modern-input-light:focus {
            border-color: #7c8cff;
            box-shadow: 0 0 0 5px rgba(124, 140, 255, 0.08);
            background: white;
            outline: none;
        }

        .modern-input-light:hover {
            border-color: #b5c0ff;
        }

        /* Button Styles - Balanced */
        .soft-gradient-button {
            background: linear-gradient(45deg, #7c8cff, #9d7bf5);
            border: none;
            border-radius: 16px !important;
            padding: 16px !important;
            color: white;
            font-weight: 600;
            font-size: 1.1rem !important;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 18px rgba(124, 140, 255, 0.2);
        }

        .soft-gradient-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        .soft-gradient-button:hover::before {
            left: 100%;
        }

        .soft-gradient-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(124, 140, 255, 0.3);
        }

        /* Social Login Buttons - Balanced */
        .social-btn-light {
            border-radius: 16px;
            padding: 14px;
            transition: all 0.3s ease;
            border: 1.8px solid #e9ebf0;
            background: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #4a5568;
            font-weight: 500;
            font-size: 1rem;
        }

        .social-btn-light:hover {
            transform: translateY(-2px);
            border-color: #7c8cff;
            background: #fafbff;
            box-shadow: 0 10px 22px rgba(124, 140, 255, 0.1);
        }

        /* Credential Cards - Balanced */
        .credential-card-light {
            background: #ffffff;
            border-radius: 14px;
            padding: 14px !important;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1.8px solid #f0f2f7;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.02);
        }

        .credential-card-light:hover {
            transform: translateY(-3px);
            background: #fafbff;
            border-color: #c5ceff;
            box-shadow: 0 15px 25px rgba(124, 140, 255, 0.12);
        }

        /* Password Toggle - Balanced */
        .password-wrapper-light {
            position: relative;
        }

        .toggle-password-light {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #a0aec0;
            transition: color 0.3s ease;
            font-size: 1.2rem !important;
        }

        .toggle-password-light:hover {
            color: #7c8cff;
        }

        /* Left Side - Balanced */
        .left-side-light {
            background: linear-gradient(135deg, #fafcff 0%, #f5f3ff 100%);
            border-radius: 28px 0 0 28px;
            position: relative;
            overflow: hidden;
            padding: 3rem !important;
        }

        .left-side-light::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(124, 140, 255, 0.03) 0%, transparent 70%);
            animation: rotate 30s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Stats Cards - Balanced */
        .stat-card-light {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(5px);
            border-radius: 20px !important;
            padding: 20px !important;
            border: 1px solid rgba(124, 140, 255, 0.1);
        }

        /* Badge - Balanced */
        .badge-light {
            background: #f0f2fe;
            color: #4c5c9e;
            padding: 10px 20px !important;
            border-radius: 30px;
            font-size: 0.95rem !important;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        /* Links - Balanced */
        .link-light {
            color: #7c8cff;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 1rem !important;
        }

        .link-light:hover {
            color: #9d7bf5;
            text-decoration: underline;
        }

        /* Checkbox - Balanced */
        .checkbox-custom {
            width: 20px !important;
            height: 20px !important;
            border: 2px solid #e2e8f0;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkbox-custom:checked {
            background-color: #7c8cff;
            border-color: #7c8cff;
        }

        /* Divider - Balanced */
        .divider-light {
            position: relative;
            text-align: center;
            margin: 25px 0;
        }

        .divider-light::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1.5px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
        }

        .divider-light span {
            background: white;
            padding: 0 20px;
            color: #94a3b8;
            font-size: 0.95rem;
            position: relative;
        }

        /* Container width - Balanced */
        .container {
            max-width: 1300px !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .left-side-light {
                border-radius: 28px 28px 0 0 !important;
                padding: 2rem !important;
            }

            .modern-input-light {
                padding: 14px 18px !important;
            }

            .soft-gradient-button {
                padding: 14px !important;
            }
        }
    </style>

    <!-- Sign In Area Start -->
    <section class="min-vh-100 d-flex align-items-center soft-gradient-bg py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row g-0 light-glass-morphism overflow-hidden">
                        <!-- Left Side - Clean Branding - BALANCED -->
                        <div class="col-md-5 left-side-light">
                            <div class="h-100 d-flex flex-column position-relative" style="z-index: 1;">
                                <!-- Logo - Balanced -->
                                <div class="mb-4">
                                    <a href="{{ route('main.index') }}">
                                        <img src="{{getImageFile(get_option('app_logo'))}}" alt="logo" class="img-fluid" style="max-height: 188px !important; width: auto;">
                                    </a>
                                </div>

                                <div class="flex-grow-1 d-flex flex-column justify-content-center">
                                    <!-- Heading - Balanced -->
                                    <h2 class="mb-3 fw-bold" style="color: #2d3a5e; font-size: 2.5rem !important; line-height: 1.2;">{{ __('Welcome Back!') }}</h2>

                                    <!-- Text - Balanced -->
                                    <p class="text-muted mb-4" style="color: #5a6a8a !important; line-height: 1.6; font-size: 1.1rem !important;">
                                        {{ __(get_option('sign_up_left_text')) }}
                                    </p>

                                    <!-- Stats Cards - Balanced -->
                                    <div class="mt-auto">
                                        <div class="d-flex gap-3">
                                            <div class="stat-card-light text-center">
                                                <h4 class="mb-1 fw-bold" style="color: #4c5c9e; font-size: 1.8rem !important;">500+</h4>
                                                <small class="text-muted" style="font-size: 0.95rem !important;">{{ __('Students') }}</small>
                                            </div>
                                            <div class="stat-card-light text-center">
                                                <h4 class="mb-1 fw-bold" style="color: #4c5c9e; font-size: 1.8rem !important;">100+</h4>
                                                <small class="text-muted" style="font-size: 0.95rem !important;">{{ __('Courses') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer - Balanced -->
                                <div class="mt-4 text-center">
                                    <small class="text-muted" style="font-size: 0.9rem !important;">&copy; {{ date('Y') }} {{ get_option('app_name') }}. {{ __('All rights reserved.') }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side - Login Form - BALANCED -->
                        <div class="col-md-7 p-5 bg-white">
                            <div class="h-100 d-flex flex-column">
                                <!-- Badge - Balanced -->
                                <div class="text-end mb-3">
                                    <span class="badge-light">
                                        <i class="fas fa-shield-alt" style="color: #7c8cff;"></i>
                                        {{ __('Secure Login') }}
                                    </span>
                                </div>

                                <form method="POST" action="{{ route('login') }}" class="flex-grow-1">
                                    @csrf

                                    <!-- Heading - Balanced -->
                                    <h3 class="fw-bold mb-2" style="color: #2d3a5e; font-size: 2rem !important;">{{ __('Sign In') }}</h3>

                                    <!-- Subtext - Balanced -->
                                    <p class="text-muted mb-4" style="font-size: 1rem !important;">{{ __('New User') }}?
                                        <a href="{{ route('sign-up') }}" class="link-light">
                                            {{ __('Create an Account') }} <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                    </p>

                                    <!-- Email Input - Balanced -->
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold mb-2" style="color: #4a5568; font-size: 1rem !important;">
                                            <i class="fas fa-envelope me-2" style="color: #7c8cff;"></i>{{ __('Email or Phone') }}
                                        </label>
                                        <input type="text"
                                               name="email"
                                               value="{{old('email')}}"
                                               class="form-control modern-input-light"
                                               placeholder="Enter your email or phone number">
                                        @if ($errors->has('email'))
                                            <span class="text-danger small mt-2 d-block" style="font-size: 0.9rem !important;">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $errors->first('email') }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Password Input - Balanced -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label fw-semibold mb-0" style="color: #4a5568; font-size: 1rem !important;">
                                                <i class="fas fa-lock me-2" style="color: #7c8cff;"></i>{{ __('Password') }}
                                            </label>
                                            <a href="{{ route('forget-password') }}" class="link-light small">
                                                {{ __('Forgot Password') }}?
                                            </a>
                                        </div>
                                        <div class="password-wrapper-light">
                                            <input class="form-control modern-input-light password"
                                                   name="password"
                                                   placeholder="Enter your password"
                                                   type="password">
                                            <span class="toggle-password-light fas fa-eye"></span>
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="text-danger small mt-2 d-block" style="font-size: 0.9rem !important;">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $errors->first('password') }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Remember Me - Balanced -->
                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input checkbox-custom" type="checkbox" name="remember" id="remember">
                                            <label class="form-check-label text-muted" for="remember" style="font-size: 1rem !important; padding-left: 8px;">
                                                {{ __('Remember me') }}
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Submit Button - Balanced -->
                                    <button type="submit" class="soft-gradient-button w-100 mb-4">
                                        <i class="fas fa-sign-in-alt me-2"></i>{{ __('Sign In') }}
                                    </button>

                                    <!-- Demo Credentials - Balanced -->
                                    @if(env('LOGIN_HELP') == 'active')
                                        <div class="mt-4">
                                            <div class="d-flex align-items-center gap-2 mb-3">
                                                <i class="fas fa-flask" style="color: #7c8cff; font-size: 1.2rem;"></i>
                                                <span class="fw-semibold" style="color: #2d3a5e; font-size: 1.1rem;">{{ __('Demo Credentials') }}</span>
                                                <span class="badge" style="background: #f0f2fe; color: #7c8cff; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem;">{{ __('Click to fill') }}</span>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="credential-card-light" id="adminCredentialShow">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <i class="fas fa-crown" style="color: #ffb347; font-size: 1.3rem;"></i>
                                                            <div>
                                                                <div class="fw-semibold" style="color: #2d3a5e; font-size: 1rem;">{{ __('Admin') }}</div>
                                                                <small class="text-muted" style="font-size: 0.85rem;">admin@gmail.com | 123456</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="credential-card-light" id="instructorCredentialShow">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <i class="fas fa-chalkboard-teacher" style="color: #5a9fd4; font-size: 1.3rem;"></i>
                                                            <div>
                                                                <div class="fw-semibold" style="color: #2d3a5e; font-size: 1rem;">{{ __('Instructor') }}</div>
                                                                <small class="text-muted" style="font-size: 0.85rem;">instructor@gmail.com | 123456</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="credential-card-light" id="studentCredentialShow">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <i class="fas fa-user-graduate" style="color: #6cba7a; font-size: 1.3rem;"></i>
                                                            <div>
                                                                <div class="fw-semibold" style="color: #2d3a5e; font-size: 1rem;">{{ __('Student') }}</div>
                                                                <small class="text-muted" style="font-size: 0.85rem;">student@gmail.com | 123456</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="credential-card-light" id="affiliatorCredentialShow">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <i class="fas fa-hand-holding-usd" style="color: #ff8a8a; font-size: 1.3rem;"></i>
                                                            <div>
                                                                <div class="fw-semibold" style="color: #2d3a5e; font-size: 1rem;">{{ __('Affiliator') }}</div>
                                                                <small class="text-muted" style="font-size: 0.85rem;">affiliator@gmail.com | 123456</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="credential-card-light" id="organizationCredentialShow">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <i class="fas fa-building" style="color: #9b9bb3; font-size: 1.3rem;"></i>
                                                            <div>
                                                                <div class="fw-semibold" style="color: #2d3a5e; font-size: 1rem;">{{ __('Organization') }}</div>
                                                                <small class="text-muted" style="font-size: 0.85rem;">organization@gmail.com | 123456</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Sign In Area End -->
@endsection

@push('script')
    <script>
        "use strict"

        // Password toggle functionality
        document.querySelectorAll('.toggle-password-light').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });
        });

        // Credential click handlers with animation
        const credentialCards = {
            adminCredentialShow: { email: 'admin@gmail.com', password: '123456' },
            instructorCredentialShow: { email: 'instructor@gmail.com', password: '123456' },
            studentCredentialShow: { email: 'student@gmail.com', password: '123456' },
            affiliatorCredentialShow: { email: 'affiliator@gmail.com', password: '123456' },
            organizationCredentialShow: { email: 'organization@gmail.com', password: '123456' }
        };

        Object.keys(credentialCards).forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.addEventListener('click', function() {
                    const credentials = credentialCards[id];

                    // Add click animation
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 200);

                    // Fill credentials
                    const emailInput = document.querySelector('input[name="email"]');
                    const passwordInput = document.querySelector('input[name="password"]');

                    if (emailInput && passwordInput) {
                        emailInput.value = credentials.email;
                        passwordInput.value = credentials.password;

                        // Add success effect
                        this.style.backgroundColor = '#f0f2fe';
                        setTimeout(() => {
                            this.style.backgroundColor = '';
                        }, 200);
                    }
                });
            }
        });

        // Input focus effects
        document.querySelectorAll('.modern-input-light').forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'translateY(-1px)';
            });

            input.addEventListener('blur', function() {
                this.style.transform = '';
            });
        });
    </script>
@endpush