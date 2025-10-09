@include('layouts.header')
<body class="inner_page login">
    <div class="full_container">
        <div class="container">
            <div class="center verticle_center full_height">
                <div class="login_section register_section">
                    {{-- Logo Section --}}
                    <div class="logo_login">
                        
                        <h3 class="text-center mt-3 mb-1" style="color: #2c3e50; font-weight: 600;">School Accounting System</h3>
                        <p class="text-center text-muted" style="font-size: 14px;">Create your school account</p>
                    </div>

                    {{-- Registration Form --}}
                    <div class="login_form">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-left: 4px solid #dc3545; border-radius: 8px; margin-bottom: 20px;">
                                <div class="d-flex align-items-start">
                                    <i class="fa fa-exclamation-circle me-2 mt-1" style="font-size: 18px;"></i>
                                    <div class="flex-grow-1">
                                        <strong>Registration Failed!</strong>
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

                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <fieldset>
                                {{-- School Information Section --}}
                                <div class="form-section-header mb-3">
                                    <h6 style="color: #2c3e50; font-weight: 600; font-size: 14px; display: flex; align-items: center;">
                                        <i class="fa fa-school me-2" style="color: #79c347;"></i>
                                        School Information
                                    </h6>
                                </div>

                                {{-- School Name --}}
                                <div class="field mb-3">
                                    <label for="school_name" class="label_field" style="font-weight: 600; color: #495057; margin-bottom: 8px;">
                                        <i class="fa fa-building me-2 text-success"></i>School Name
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text" style="background: #f8f9fa; border-right: none; border-radius: 8px 0 0 8px;">
                                            <i class="fa fa-school text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               id="school_name" 
                                               name="school_name" 
                                               class="form-control @error('school_name') is-invalid @enderror" 
                                               placeholder="Enter school name"
                                               value="{{ old('school_name') }}"
                                               style="border-left: none; border-radius: 0 8px 8px 0; padding: 12px 16px; font-size: 14px;"
                                               required />
                                    </div>
                                    @error('school_name')
                                        <small class="text-danger" style="font-size: 13px;">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="field mb-3">
                                    <label for="email" class="label_field" style="font-weight: 600; color: #495057; margin-bottom: 8px;">
                                        <i class="fa fa-envelope me-2 text-primary"></i>Email Address
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text" style="background: #f8f9fa; border-right: none; border-radius: 8px 0 0 8px;">
                                            <i class="fa fa-at text-muted"></i>
                                        </span>
                                        <input type="email" 
                                               id="email" 
                                               name="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               placeholder="school@example.com"
                                               value="{{ old('email') }}"
                                               style="border-left: none; border-radius: 0 8px 8px 0; padding: 12px 16px; font-size: 14px;"
                                               required />
                                    </div>
                                    @error('email')
                                        <small class="text-danger" style="font-size: 13px;">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Phone Number --}}
                                <div class="field mb-3">
                                    <label for="phone" class="label_field" style="font-weight: 600; color: #495057; margin-bottom: 8px;">
                                        <i class="fa fa-phone me-2 text-info"></i>Phone Number
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text" style="background: #f8f9fa; border-right: none; border-radius: 8px 0 0 8px;">
                                            <i class="fa fa-mobile-alt text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               id="phone" 
                                               name="phone" 
                                               class="form-control @error('phone') is-invalid @enderror" 
                                               placeholder="+254 XXX XXX XXX"
                                               value="{{ old('phone') }}"
                                               style="border-left: none; border-radius: 0 8px 8px 0; padding: 12px 16px; font-size: 14px;"
                                               required />
                                    </div>
                                    @error('phone')
                                        <small class="text-danger" style="font-size: 13px;">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Address --}}
                                <div class="field mb-4">
                                    <label for="address" class="label_field" style="font-weight: 600; color: #495057; margin-bottom: 8px;">
                                        <i class="fa fa-map-marker-alt me-2 text-warning"></i>Address
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text" style="background: #f8f9fa; border-right: none; border-radius: 8px 0 0 8px;">
                                            <i class="fa fa-location-arrow text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               id="address" 
                                               name="address" 
                                               class="form-control @error('address') is-invalid @enderror" 
                                               placeholder="Enter school address"
                                               value="{{ old('address') }}"
                                               style="border-left: none; border-radius: 0 8px 8px 0; padding: 12px 16px; font-size: 14px;"
                                               required />
                                    </div>
                                    @error('address')
                                        <small class="text-danger" style="font-size: 13px;">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Admin Information Section --}}
                                <div class="form-section-header mb-3 mt-4" style="padding-top: 20px; border-top: 1px solid #e8eaed;">
                                    <h6 style="color: #2c3e50; font-weight: 600; font-size: 14px; display: flex; align-items: center;">
                                        <i class="fa fa-user-shield me-2" style="color: #36a9e2;"></i>
                                        Administrator Details
                                    </h6>
                                </div>

                                {{-- Admin Name --}}
                                <div class="field mb-3">
                                    <label for="admin_name" class="label_field" style="font-weight: 600; color: #495057; margin-bottom: 8px;">
                                        <i class="fa fa-user me-2 text-primary"></i>Admin Name
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text" style="background: #f8f9fa; border-right: none; border-radius: 8px 0 0 8px;">
                                            <i class="fa fa-user-tie text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               id="admin_name" 
                                               name="admin_name" 
                                               class="form-control @error('admin_name') is-invalid @enderror" 
                                               placeholder="Enter administrator name"
                                               value="{{ old('admin_name') }}"
                                               style="border-left: none; border-radius: 0 8px 8px 0; padding: 12px 16px; font-size: 14px;"
                                               required />
                                    </div>
                                    @error('admin_name')
                                        <small class="text-danger" style="font-size: 13px;">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div class="field mb-4">
                                    <label for="password" class="label_field" style="font-weight: 600; color: #495057; margin-bottom: 8px;">
                                        <i class="fa fa-lock me-2 text-danger"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text" style="background: #f8f9fa; border-right: none; border-radius: 8px 0 0 8px;">
                                            <i class="fa fa-key text-muted"></i>
                                        </span>
                                        <input type="password" 
                                               id="password" 
                                               name="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               placeholder="Create a strong password"
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
                                    <small class="text-muted" style="font-size: 12px; display: block; margin-top: 5px;">
                                        <i class="fa fa-info-circle me-1"></i>Must be at least 8 characters
                                    </small>
                                </div>

                                {{-- Submit Button --}}
                                <div class="field mb-3">
                                    <button type="submit" class="btn btn-success w-100" style="padding: 14px; font-size: 16px; font-weight: 600; border-radius: 8px; background: linear-gradient(135deg, #79c347 0%, #5fa732 100%); border: none;">
                                        <i class="fa fa-check-circle me-2"></i>Create Account
                                    </button>
                                </div>

                                {{-- Sign In Link --}}
                                <div class="text-center mt-4" style="padding-top: 20px; border-top: 1px solid #e8eaed;">
                                    <p style="font-size: 14px; color: #6c757d; margin-bottom: 10px;">
                                        Already have an account?
                                    </p>
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary w-100" style="padding: 12px; font-size: 15px; font-weight: 600; border-radius: 8px; border: 2px solid #36a9e2; color: #36a9e2;">
                                        <i class="fa fa-sign-in-alt me-2"></i>Sign In
                                    </a>
                                </div>
                            </fieldset>
                        </form>
                    </div>

                    {{-- Footer Text --}}
                    <div class="text-center mt-4">
                        <p style="font-size: 13px; color: #9ca3af;">
                            <i class="fa fa-shield-alt me-1"></i>
                            By registering, you agree to our Terms of Service
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Registration Page Styles */
        .register_section {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            padding: 40px;
            max-width: 550px;
            margin: 0 auto;
        }

        .login_form {
            margin-top: 30px;
        }

        /* Input Focus Effects */
        .form-control:focus {
            border-color: #79c347;
            box-shadow: 0 0 0 0.2rem rgba(121, 195, 71, 0.15);
        }

        .input-group:focus-within .input-group-text {
            border-color: #79c347;
            background: #e8f5e9;
        }

        .input-group-text {
            transition: all 0.3s ease;
        }

        /* Button Hover Effects */
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(121, 195, 71, 0.4);
        }

        .btn-outline-primary:hover {
            background: #36a9e2;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(54, 169, 226, 0.3);
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

        /* Section Headers */
        .form-section-header h6 {
            padding-bottom: 10px;
            border-bottom: 2px solid #e8eaed;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .register_section {
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
            padding: 20px 0;
        }

        body.login::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 300px;
            background: linear-gradient(135deg, #79c347 0%, #5fa732 100%);
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

