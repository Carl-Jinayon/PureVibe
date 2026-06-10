<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Grocery Self-Checkout</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 1rem;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            color: white;
        }

        .brand-logo {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 32px;
            color: white;
            box-shadow: 0 10px 15px -3px rgba(124, 58, 237, 0.3);
        }

        .brand-title {
            text-align: center;
            font-weight: 700;
            margin-bottom: 2rem;
            font-size: 1.5rem;
            letter-spacing: -0.025em;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 12px;
            padding-left: 2.8rem;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #7c3aed;
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(124, 58, 237, 0.25);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 5;
            display: flex;
            align-items: center;
            padding-left: 1rem;
        }

        .form-check-input {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .form-check-input:checked {
            background-color: #7c3aed;
            border-color: #7c3aed;
        }

        .btn-login {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none;
            border-radius: 12px;
            padding: 0.8rem;
            font-weight: 600;
            color: white;
            width: 100%;
            margin-top: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(124, 58, 237, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(124, 58, 237, 0.4);
            color: white;
        }

        .invalid-feedback {
            color: #fca5a5;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }
        
        .alert-danger {
            background: rgba(220, 38, 38, 0.2);
            border: 1px solid rgba(220, 38, 38, 0.3);
            color: #fca5a5;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="glass-card">
            <div class="brand-logo">
                <i class="bi bi-cart3"></i>
            </div>
            <h1 class="brand-title">Admin Login</h1>

            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="username" class="form-label text-light" style="opacity: 0.8; font-size: 0.9rem;">Username</label>
                    <div class="position-relative">
                        <div class="input-group-text"><i class="bi bi-person"></i></div>
                        <input type="text" class="form-control py-2 @error('username') is-invalid @enderror" id="username" name="username" placeholder="Enter username" value="{{ old('username') }}" autofocus>
                    </div>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-light" style="opacity: 0.8; font-size: 0.9rem;">Password</label>
                    <div class="position-relative">
                        <div class="input-group-text"><i class="bi bi-lock"></i></div>
                        <input type="password" class="form-control py-2 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter password">
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-light" for="remember" style="opacity: 0.8; font-size: 0.9rem;">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="btn btn-login">
                    Sign In <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
