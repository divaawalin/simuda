<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMUDA</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #048E8E;
            --secondary-color: #5FC6D7;
            --white: #FFFFFF;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .login-header {
            padding: 50px 40px 30px;
            text-align: center;
        }

        .login-header .logo-box {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 2rem;
            box-shadow: 0 10px 20px rgba(4, 142, 142, 0.2);
        }

        .login-header h1 {
            font-weight: 800;
            color: #1A252F;
            font-size: 1.75rem;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .login-header p {
            color: #7F8C8D;
            font-size: 0.95rem;
        }

        .login-body {
            padding: 0 40px 50px;
        }

        .form-label {
            font-weight: 600;
            color: #2C3E50;
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 18px;
            border: 1px solid #E0E0E0;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(4, 142, 142, 0.1);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            color: white;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s;
            box-shadow: 0 10px 20px rgba(4, 142, 142, 0.2);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(4, 142, 142, 0.3);
            color: white;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .alert {
            border-radius: 12px;
            font-size: 0.9rem;
            border: none;
        }

        .forgot-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #7F8C8D;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .forgot-link:hover {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="logo-box">
                <i class="fas fa-users"></i>
            </div>
            <h1>SIMUDA</h1>
            <p>Sistem Manajemen Organisasi</p>
        </div>
        
        <div class="login-body">
            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success mb-4">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-4">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="position-relative">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
                    </div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="form-label mb-0">Password</label>
                    </div>
                    <div class="position-relative">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                        <span class="position-absolute top-50 end-0 translate-middle-y me-3" style="cursor: pointer;" onclick="togglePassword('password')">
                            <i class="fas fa-eye text-muted"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted small" for="remember">
                            Biarkan saya tetap masuk
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-login">
                    Masuk ke Sistem <i class="fas fa-arrow-right ms-2"></i>
                </button>

                <a class="forgot-link" href="{{ route('password.request') }}">
                    Lupa password? <span style="color: var(--primary-color); font-weight: 600;">Reset di sini</span>
                </a>
            </form>
        </div>
    </div>
</body>
</html>