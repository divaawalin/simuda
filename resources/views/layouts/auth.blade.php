<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Autentikasi') - {{ config('app.name', 'SIMUDA') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #048e8e;
            --primary-dark: #026e6e;
            --secondary-color: #5fc6d7;
            --accent-color: #d8fff4;
            --ink: #16333b;
            --ink-soft: #60737d;
            --surface: rgba(255, 255, 255, 0.9);
            --surface-strong: #ffffff;
            --line: rgba(22, 51, 59, 0.1);
            --shadow-xl: 0 32px 80px rgba(6, 34, 42, 0.22);
            --shadow-lg: 0 18px 48px rgba(6, 34, 42, 0.14);
            --radius-xl: 32px;
            --radius-lg: 22px;
            --radius-md: 16px;
            --transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 15% 20%, rgba(216, 255, 244, 0.65), transparent 28%),
                radial-gradient(circle at 85% 15%, rgba(95, 198, 215, 0.28), transparent 22%),
                radial-gradient(circle at 80% 85%, rgba(4, 142, 142, 0.18), transparent 26%),
                linear-gradient(135deg, #f6fbfc 0%, #eef7f8 45%, #e9f1f5 100%);
            overflow-x: hidden;
            position: relative;
        }

        body::before,
        body::after {
            content: '';
            position: fixed;
            border-radius: 999px;
            pointer-events: none;
            filter: blur(12px);
            opacity: 0.8;
            z-index: 0;
        }

        body::before {
            width: 240px;
            height: 240px;
            top: -60px;
            right: -50px;
            background: linear-gradient(135deg, rgba(4, 142, 142, 0.28), rgba(95, 198, 215, 0.08));
        }

        body::after {
            width: 300px;
            height: 300px;
            bottom: -120px;
            left: -80px;
            background: linear-gradient(135deg, rgba(95, 198, 215, 0.16), rgba(216, 255, 244, 0.42));
        }

        .auth-shell {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
        }

        .auth-stage {
            width: min(1120px, 100%);
            display: grid;
            grid-template-columns: 1.02fr 0.98fr;
            border-radius: var(--radius-xl);
            overflow: hidden;
            background: rgba(255, 255, 255, 0.56);
            border: 1px solid rgba(255, 255, 255, 0.62);
            box-shadow: var(--shadow-xl);
            backdrop-filter: blur(18px);
        }

        .auth-aside {
            position: relative;
            padding: 46px;
            min-height: 720px;
            background:
                radial-gradient(circle at top left, rgba(255, 255, 255, 0.22), transparent 32%),
                radial-gradient(circle at bottom right, rgba(216, 255, 244, 0.26), transparent 28%),
                linear-gradient(155deg, #0a8c8b 0%, #0b7f84 42%, #5fc6d7 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
        }

        .auth-aside::before,
        .auth-aside::after {
            content: '';
            position: absolute;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.1);
            filter: blur(2px);
        }

        .auth-aside::before {
            width: 260px;
            height: 260px;
            top: -90px;
            right: -70px;
        }

        .auth-aside::after {
            width: 180px;
            height: 180px;
            bottom: -50px;
            left: -35px;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(10px);
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            font-size: 0.78rem;
        }

        .brand-badge i {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.18);
        }

        .auth-copy {
            position: relative;
            z-index: 1;
            max-width: 420px;
        }

        .auth-copy h1 {
            margin: 22px 0 14px;
            font-size: clamp(2.4rem, 4.8vw, 4rem);
            line-height: 0.98;
            font-weight: 800;
            letter-spacing: -0.06em;
        }

        .auth-copy p {
            margin: 0;
            color: rgba(255, 255, 255, 0.86);
            font-size: 1rem;
            line-height: 1.75;
            max-width: 360px;
        }

        .auth-points {
            display: grid;
            gap: 14px;
            margin-top: 34px;
        }

        .auth-point {
            display: flex;
            gap: 14px;
            padding: 16px 18px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.16);
            backdrop-filter: blur(10px);
        }

        .auth-point i {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.16);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .auth-point strong,
        .auth-point span {
            display: block;
        }

        .auth-point strong {
            font-size: 0.95rem;
            margin-bottom: 4px;
        }

        .auth-point span {
            color: rgba(255, 255, 255, 0.76);
            font-size: 0.88rem;
            line-height: 1.55;
        }

        .aside-metrics {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .aside-metric {
            padding: 16px 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.14);
            text-align: center;
        }

        .aside-metric strong {
            display: block;
            font-size: 1.2rem;
            font-weight: 800;
            margin-bottom: 2px;
        }

        .aside-metric span {
            color: rgba(255, 255, 255, 0.74);
            font-size: 0.76rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .auth-panel {
            position: relative;
            padding: 42px;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(255, 255, 255, 0.9)),
                linear-gradient(120deg, rgba(255, 255, 255, 0.98), rgba(248, 252, 252, 0.88));
        }

        .auth-panel::before {
            content: '';
            position: absolute;
            inset: 28px;
            border-radius: 28px;
            border: 1px solid rgba(4, 142, 142, 0.08);
            pointer-events: none;
        }

        .auth-form-wrap {
            position: relative;
            z-index: 1;
            max-width: 430px;
            margin: 0 auto;
        }

        .auth-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(4, 142, 142, 0.08);
            color: var(--primary-color);
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .auth-icon {
            width: 74px;
            height: 74px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 24px 0 18px;
            border-radius: 24px;
            color: #fff;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 18px 40px rgba(4, 142, 142, 0.24);
            font-size: 1.8rem;
        }

        .auth-form-wrap h2 {
            margin: 0 0 10px;
            font-size: clamp(1.8rem, 3vw, 2.4rem);
            line-height: 1.04;
            font-weight: 800;
            letter-spacing: -0.05em;
        }

        .auth-form-wrap > p {
            color: var(--ink-soft);
            margin-bottom: 28px;
            line-height: 1.72;
        }

        .auth-card {
            padding: 28px;
            border-radius: 26px;
            background: rgba(248, 252, 252, 0.96);
            border: 1px solid rgba(4, 142, 142, 0.08);
            box-shadow: var(--shadow-lg);
        }

        .form-label {
            font-weight: 700;
            font-size: 0.84rem;
            color: var(--ink);
            margin-bottom: 8px;
            letter-spacing: 0.02em;
        }

        .form-control {
            min-height: 56px;
            border-radius: 18px;
            border: 1.5px solid rgba(22, 51, 59, 0.1);
            background: #fff;
            padding: 14px 18px;
            font-size: 0.96rem;
            transition: var(--transition);
            box-shadow: none;
        }

        .form-control:focus {
            border-color: rgba(4, 142, 142, 0.55);
            box-shadow: 0 0 0 5px rgba(4, 142, 142, 0.1);
        }

        .input-shell {
            position: relative;
        }

        .field-icon,
        .password-toggle {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #93a4ab;
        }

        .field-icon {
            left: 18px;
            pointer-events: none;
        }

        .input-shell .form-control.with-icon {
            padding-left: 50px;
        }

        .password-toggle {
            right: 18px;
            cursor: pointer;
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--primary-color);
        }

        .btn-auth {
            min-height: 56px;
            border: none;
            width: 100%;
            border-radius: 18px;
            font-weight: 800;
            letter-spacing: 0.01em;
            color: #fff;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 16px 36px rgba(4, 142, 142, 0.24);
            transition: var(--transition);
        }

        .btn-auth:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 22px 40px rgba(4, 142, 142, 0.3);
        }

        .auth-links {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 18px;
            justify-content: space-between;
            margin-top: 22px;
        }

        .auth-links a {
            color: var(--ink-soft);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .auth-links a:hover {
            color: var(--primary-color);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--ink-soft);
            font-size: 0.92rem;
        }

        .alert {
            border: none;
            border-radius: 18px;
            padding: 14px 16px;
            font-size: 0.92rem;
            margin-bottom: 18px;
        }

        .alert-success {
            background: rgba(39, 174, 96, 0.12);
            color: #228654;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.12);
            color: #b5263d;
        }

        .invalid-feedback,
        .text-danger.small {
            font-size: 0.8rem;
            margin-top: 6px;
        }

        @media (max-width: 991.98px) {
            .auth-stage {
                grid-template-columns: 1fr;
            }

            .auth-aside {
                min-height: unset;
                padding: 30px;
                gap: 26px;
            }

            .aside-metrics {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 575.98px) {
            .auth-shell {
                padding: 16px;
            }

            .auth-panel,
            .auth-aside {
                padding: 24px 20px;
            }

            .auth-card {
                padding: 20px;
            }

            .aside-metrics {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="auth-shell">
        <div class="auth-stage">
            <aside class="auth-aside">
                <div class="auth-copy">
                    <div class="brand-badge">
                        <i class="fas fa-sparkles"></i>
                        {{ config('app.name', 'SIMUDA') }}
                    </div>
                    <h1>Sistem organisasi yang terasa modern.</h1>
                    <p>Kelola anggota, kegiatan, absensi, dan distribusi konten dari satu tempat dengan tampilan yang lebih rapi, cepat, dan nyaman dipakai.</p>

                    <div class="auth-points">
                        <div class="auth-point">
                            <i class="fas fa-shield-check"></i>
                            <div>
                                <strong>Akses lebih aman</strong>
                                <span>Alur autentikasi disusun lebih jelas dengan fokus pada kenyamanan pengguna.</span>
                            </div>
                        </div>
                        <div class="auth-point">
                            <i class="fas fa-grid-2"></i>
                            <div>
                                <strong>Interface lebih bersih</strong>
                                <span>Visual sistem dipusatkan pada keterbacaan, ritme ruang, dan decorative elements yang terkontrol.</span>
                            </div>
                        </div>
                        <div class="auth-point">
                            <i class="fas fa-bolt"></i>
                            <div>
                                <strong>Alur kerja tetap cepat</strong>
                                <span>Komponen form, tombol, dan feedback dibuat lebih kuat tanpa mengorbankan fungsi.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="aside-metrics">
                    <div class="aside-metric">
                        <strong>Admin</strong>
                        <span>Kontrol penuh</span>
                    </div>
                    <div class="aside-metric">
                        <strong>Anggota</strong>
                        <span>Akses terarah</span>
                    </div>
                    <div class="aside-metric">
                        <strong>Konten</strong>
                        <span>Terdistribusi</span>
                    </div>
                </div>
            </aside>

            <main class="auth-panel">
                <div class="auth-form-wrap">
                    <span class="auth-eyebrow">@yield('eyebrow', 'Autentikasi')</span>
                    <div class="auth-icon">
                        <i class="@yield('auth_icon', 'fas fa-user-lock')"></i>
                    </div>
                    <h2>@yield('heading', 'Masuk ke sistem')</h2>
                    <p>@yield('subtitle', 'Lanjutkan ke sistem menggunakan akun yang sudah terdaftar.')</p>

                    <div class="auth-card">
                        @yield('auth_content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);

            if (!input) {
                return;
            }

            const toggle = input.parentElement.querySelector('.password-toggle i');

            if (input.type === 'password') {
                input.type = 'text';
                if (toggle) {
                    toggle.classList.remove('fa-eye');
                    toggle.classList.add('fa-eye-slash');
                }
            } else {
                input.type = 'password';
                if (toggle) {
                    toggle.classList.remove('fa-eye-slash');
                    toggle.classList.add('fa-eye');
                }
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
