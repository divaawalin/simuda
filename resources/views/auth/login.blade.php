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
             --primary-dark: #037676;
             --secondary-color: #5FC6D7;
             --accent-color: #6DD5D5;
             --dark-color: #1A252F;
             --text-muted: #7F8C8D;
             --white: #FFFFFF;
             --border-radius: 16px;
             --card-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
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

         /* Decorative background elements */
         body::before {
             content: '';
             position: fixed;
             top: -50%;
             left: -50%;
             width: 200%;
             height: 200%;
             background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.1) 0%, transparent 50%),
                         radial-gradient(circle at 70% 70%, rgba(255,255,255,0.08) 0%, transparent 50%);
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
             position: relative;
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
             transition: transform 0.3s;
         }

         .login-card:hover .login-header .logo-box {
             transform: scale(1.05) rotate(3deg);
         }

         .login-header h1 {
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
             font-weight: 500;
         }

         .login-body {
             padding: 0 40px 50px;
         }

         .form-label {
             font-weight: 600;
             color: var(--dark-color);
             font-size: 0.85rem;
             margin-bottom: 8px;
             letter-spacing: 0.3px;
         }

         .form-control {
             border-radius: var(--border-radius);
             padding: 14px 20px;
             border: 2px solid #E8EEF2;
             font-size: 0.95rem;
             transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
             background: #FAFBFC;
         }

         .form-control:focus {
             border-color: var(--primary-color);
             box-shadow: 0 0 0 5px rgba(4, 142, 142, 0.12);
             background: var(--white);
             transform: translateY(-1px);
         }

         .form-control::placeholder {
             color: #BDC8D0;
         }

         .input-group {
             position: relative;
         }

         .input-group-text {
             background: transparent;
             border: 2px solid #E8EEF2;
             border-left: none;
             padding: 0 16px;
             color: var(--text-muted);
         }

         .form-control:focus + .input-group-text,
         .form-control:focus ~ .input-group-text {
             border-color: var(--primary-color);
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
             transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

         .btn-login:active {
             transform: translateY(-1px);
         }

         .form-check-input:checked {
             background-color: var(--primary-color);
             border-color: var(--primary-color);
         }

         .form-check-label {
             color: var(--text-muted);
             font-size: 0.9rem;
         }

         .alert {
             border-radius: var(--border-radius);
             font-size: 0.9rem;
             border: none;
             animation: shake 0.5s ease-in-out;
         }

         @keyframes shake {
             0%, 100% { transform: translateX(0); }
             25% { transform: translateX(-5px); }
             75% { transform: translateX(5px); }
         }

         .forgot-link {
             display: block;
             text-align: center;
             margin-top: 28px;
             color: var(--text-muted);
             text-decoration: none;
             font-size: 0.9rem;
             font-weight: 500;
             transition: all 0.3s;
         }

         .forgot-link:hover {
             color: var(--primary-color);
             transform: translateY(-1px);
         }

         .login-footer {
             text-align: center;
             padding: 0 40px 30px;
         }

         .login-footer p {
             color: var(--text-muted);
             font-size: 0.85rem;
         }

         .login-footer a {
             color: var(--primary-color);
             text-decoration: none;
             font-weight: 600;
         }

         .login-footer a:hover {
             text-decoration: underline;
         }

         /* Responsive adjustments */
         @media (max-width: 480px) {
             .login-header {
                 padding: 40px 25px 25px;
             }

             .login-body {
                 padding: 0 25px 40px;
             }

             .login-footer {
                 padding: 0 25px 25px;
             }

             .login-header h1 {
                 font-size: 1.6rem;
             }
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
            </form>
        </div>
    </div>
    
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            if (!input) return;
            let icon = null;
            const nextSibling = input.nextElementSibling;
            if (nextSibling && nextSibling.tagName === 'SPAN' && nextSibling.querySelector('i')) {
                icon = nextSibling.querySelector('i');
            } else if (input.parentElement) {
                icon = input.parentElement.querySelector('i');
            }
            if (!icon) return;

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