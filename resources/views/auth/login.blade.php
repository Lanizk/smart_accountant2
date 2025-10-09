@include('layouts.header')
<body class="inner_page login">
    <div class="full_container">
        <div class="container">
            <div class="center verticle_center full_height">
                <div class="login_section">
                    {{-- Logo Section --}}
                    <div class="logo_login">
                        
                        <h3 class="text-center mt-3 mb-1" style="color: #2c3e50; font-weight: 600;">School Accounting System</h3>
                        <p class="text-center text-muted" style="font-size: 14px;">Sign in to access your dashboard</p>
                    </div>

                    {{-- Login Form --}}
                    <div class="login_form">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-left: 4px solid #dc3545; border-radius: 8px; margin-bottom: 20px;">
                                <div class="d-flex align-items-start">
                                    <i class="fa fa-exclamation-circle me-2 mt-1" style="font-size: 18px;"></i>
                                    <div class="flex-grow-1">
                                        <strong>Login Failed!</strong>
                                        <ul class="mb-0 mt-1 ps-3">
                                            @foreach ($errors->all() as $error)
                                                <li style="font-size: 13px;">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <fieldset>
                                {{-- Email Field --}}
                                <div class="field mb-3">
                                    <label for="email" class="label_field" style="font-weight: 600; color: #495057; margin-bottom: 8px;">
                                        <i class="fa fa-envelope me-2 text-primary"></i>Email Address
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text" style="background: #f8f9fa; border-right: none; border-radius: 8px 0 0 8px;">
                                            <i class="fa fa-user text-muted"></i>
                                        </span>
                                        <input type="email" 
                                               id="email" 
                                               name="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               placeholder="Enter your email address"
                                               value="{{ old('email') }}"
                                               style="border-left: none; border-radius: 0 8px 8px 0; padding: 12px 16px; font-size: 14px;"
                                               required 
                                               autofocus />
                                    </div>
                                    @error('email')
                                        <small class="text-danger" style="font-size: 13px;">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Password Field --}}
                                <div class="field mb-3">
                                    <label for="password" class="label_field" style="font-weight: 600; color: #495057; margin-bottom: 8px;">
                                        <i class="fa fa-lock me-2 text-success"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text" style="background: #f8f9fa; border-right: none; border-radius: 8px 0 0 8px;">
                                            <i class="fa fa-key text-muted"></i>
                                        </span>
                                        <input type="password" 
                                               id="password" 
                                               name="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               placeholder="Enter your password"
                                               style="border-left: none; border-radius: 0 8px 8px 0; padding: 12px 16px; font-size: 14px;"
                                               required />
                                        <button type="button" 
                                                class="btn btn-outline-secondary" 
                                                id="togglePassword"
                                                style="border-radius: 0 8px 8px 0; border-left: none;">
                                            <i class="fa fa-eye" id="eyeIcon"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <small class="text-danger" style="font-size: 13px;">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Remember Me & Forgot Password --}}
                                <div class="field mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   class="form-check-input" 
                                                   id="remember" 
                                                   name="remember"
                                                   style="cursor: pointer; width: 18px; height: 18px;">
                                            <label class="form-check-label" for="remember" style="cursor: pointer; font-size: 14px; color: #6c757d; margin-left: 5px;">
                                                Remember Me
                                            </label>
                                        </div>
                                        <a href="{" class="forgot" style="font-size: 14px; color: #36a9e2; text-decoration: none;">
                                            <i class="fa fa-question-circle me-1"></i>Forgot Password?
                                        </a>
                                    </div>
                                </div>

                                {{-- Submit Buttons --}}
                                <div class="field mb-3">
                                    <button type="submit" class="btn btn-primary w-100 mb-3" style="padding: 14px; font-size: 16px; font-weight: 600; border-radius: 8px; background: linear-gradient(135deg, #36a9e2 0%, #1e88c7 100%); border: none;">
                                        <i class="fa fa-sign-in-alt me-2"></i>Sign In
                                    </button>
                                </div>

                                {{-- Sign Up Link --}}
                                <div class="text-center mt-4" style="padding-top: 20px; border-top: 1px solid #e8eaed;">
                                    <p style="font-size: 14px; color: #6c757d; margin-bottom: 10px;">
                                        Don't have an account?
                                    </p>
                                    <a href="{{ route('register') }}" class="btn btn-outline-success w-100" style="padding: 12px; font-size: 15px; font-weight: 600; border-radius: 8px; border: 2px solid #79c347; color: #79c347;">
                                        <i class="fa fa-user-plus me-2"></i>Create New Account
                                    </a>
                                </div>
                            </fieldset>
                        </form>
                    </div>

                    {{-- Footer Text --}}
                    <div class="text-center mt-4">
                        <p style="font-size: 13px; color: #9ca3af;">
                            <i class="fa fa-shield-alt me-1"></i>
                            Secure login • All data encrypted
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Login Page Styles */
        .login_section {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            padding: 40px;
            max-width: 480px;
            margin: 0 auto;
        }

        .login_form {
            margin-top: 30px;
        }

        /* Input Focus Effects */
        .form-control:focus {
            border-color: #36a9e2;
            box-shadow: 0 0 0 0.2rem rgba(54, 169, 226, 0.15);
        }

        .input-group:focus-within .input-group-text {
            border-color: #36a9e2;
            background: #e3f2fd;
        }

        .input-group-text {
            transition: all 0.3s ease;
        }

        /* Button Hover Effects */
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(54, 169, 226, 0.4);
        }

        .btn-outline-success:hover {
            background: #79c347;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(121, 195, 71, 0.3);
        }

        /* Link Hover */
        .forgot:hover {
            color: #1e88c7;
            text-decoration: underline;
        }

        /* Checkbox Styling */
        .form-check-input:checked {
            background-color: #36a9e2;
            border-color: #36a9e2;
        }

        /* Password Toggle Button */
        #togglePassword {
            border: 1px solid #e0e0e0;
        }

        #togglePassword:hover {
            background: #f8f9fa;
        }

        /* Alert Styling */
        .alert {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .login_section {
                padding: 30px 20px;
                margin: 15px;
            }

            .logo_login img {
                width: 180px;
            }

            .btn {
                padding: 12px !important;
                font-size: 14px !important;
            }
        }

        /* Background Following System Theme */
        body.login {
            background: #f5f7fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        body.login::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 300px;
            background: linear-gradient(135deg, #36a9e2 0%, #1e88c7 100%);
            z-index: 0;
        }

        .full_container {
            position: relative;
            z-index: 1;
        }
    </style>

    <script>
        // Toggle Password Visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>

    @include('layouts.footer')