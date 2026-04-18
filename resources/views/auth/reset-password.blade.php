<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SIMUDA</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #048E8E;
            --primary-dark: #037676;
            --secondary-color: #5FC6D7;
            --dark-color: #1A252F;
            --text-muted: #7F8C8D;
            --white: #FFFFFF;
            --border-radius: 16px;
            --card-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: var(--card-shadow);
            width: 100%;
            max-width: 450px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.4);
            position: relative;
            z-index: 1;
            animation: slideUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            padding: 50px 40px 30px;
            text-align: center;
        }

        .login-header .logo-box {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 2.2rem;
            box-shadow: 0 12px 30px rgba(4, 142, 142, 0.3);
        }

        .login-header h2 {
            font-weight: 800;
            background: linear-gradient(135deg, var(--dark-color), #2C3E50);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.9rem;
            margin-bottom: 8px;
            letter-spacing: -1px;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .login-body {
            padding: 0 40px 50px;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: var(--border-radius);
            padding: 14px 50px 14px 20px;
            border: 2px solid #E8EEF2;
            font-size: 0.95rem;
            transition: var(--transition);
            background: #FAFBFC;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 5px rgba(4, 142, 142, 0.12);
            background: var(--white);
            transform: translateY(-1px);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 14px;
            border-radius: var(--border-radius);
            font-weight: 700;
            color: white;
            width: 100%;
            margin-top: 10px;
            transition: var(--transition);
            box-shadow: 0 10px 30px rgba(4, 142, 142, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(4, 142, 142, 0.4);
            color: white;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-muted);
            transition: var(--transition);
            z-index: 10;
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .alert {
            border-radius: var(--border-radius);
            font-size: 0.9rem;
            border: none;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border-left: 4px solid #dc3545;
        }

        @media (max-width: 480px) {
            .login-header { padding: 40px 25px 25px; }
            .login-body { padding: 0 25px 40px; }
            .login-header h2 { font-size: 1.6rem; }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="logo-box">
                <i class="fas fa-unlock-alt"></i>
            </div>
            <h2>RESET PASSWORD</h2>
            <p>Masukkan password baru Anda.</p>
        </div>
        
        <div class="login-body">
            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i> 
                    @foreach($errors->all() as $error)
                        <p class="mb-1">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ url('/reset-password/'.$token) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="password" class="form-label">Password Baru</label>
                    <div class="position-relative">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" required placeholder="Masukkan password baru">
                        <span class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div class="position-relative">
                        <input id="password_confirmation" type="password" class="form-control" 
                               name="password_confirmation" required placeholder="Ulangi password baru">
                        <span class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="fas fa-save me-2"></i>Reset Password
                </button>
            </form>
            
            <div class="auth-links">
                <a href="{{ route('login') }}">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const icon = input.nextElementSibling.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
