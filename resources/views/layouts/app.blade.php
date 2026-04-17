<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SIMUDA') }}</title>
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
            --dark-color: #1A252F;
            --light-bg: #F8F9FA;
            --text-dark: #2C3E50;
            --text-muted: #7F8C8D;
            --white: #FFFFFF;
            --sidebar-width: 280px;
            --border-radius: 12px;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        /* Sidebar Styling */
        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: var(--white);
            color: var(--text-dark);
            transition: var(--transition);
            min-height: 100vh;
            border-right: 1px solid rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.02);
        }

        #sidebar .sidebar-header {
            padding: 30px 25px;
            text-align: left;
        }

        #sidebar .sidebar-header h3 {
            font-weight: 800;
            color: var(--primary-color);
            margin: 0;
            letter-spacing: -1px;
            font-size: 1.5rem;
        }

        #sidebar ul.components {
            padding: 10px 15px;
            flex-grow: 1;
        }

        #sidebar ul li {
            margin-bottom: 5px;
        }

        #sidebar ul li a {
            padding: 12px 20px;
            font-size: 0.95rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        #sidebar ul li a i {
            width: 25px;
            font-size: 1.1rem;
            transition: var(--transition);
        }

        #sidebar ul li a:hover {
            color: var(--primary-color);
            background: rgba(4, 142, 142, 0.05);
        }

        #sidebar ul li.active > a {
            color: var(--white);
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 4px 15px rgba(4, 142, 142, 0.2);
        }

        #sidebar ul li.active > a i {
            color: var(--white);
        }

        /* Content Styling */
        #content {
            width: 100%;
            padding: 0;
            min-height: 100vh;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .navbar {
            padding: 15px 40px;
            background: var(--white);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: none;
        }

        .main-container {
            padding: 40px;
            flex-grow: 1;
        }

        /* Card Customization */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            background: var(--white);
            margin-bottom: 25px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 20px 25px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .card-body {
            padding: 25px;
        }

        /* Buttons Customization */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(4, 142, 142, 0.2);
            transition: var(--transition);
        }

        .btn-primary:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 20px rgba(4, 142, 142, 0.3);
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .btn-success {
            background-color: #2ECC71;
            border: none;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
        }

        /* Stats Cards */
        .stat-card {
            padding: 25px;
            border-radius: var(--border-radius);
            position: relative;
            overflow: hidden;
        }

        .stat-card .icon {
            position: absolute;
            right: 20px;
            bottom: 10px;
            font-size: 4rem;
            opacity: 0.1;
            color: var(--primary-color);
        }

        /* Tables Customization */
        .table {
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table thead th {
            border: none;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 15px 25px;
        }

        .table tbody tr {
            background: var(--white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .table tbody td {
            padding: 20px 25px;
            border: none;
            vertical-align: middle;
        }

        .table tbody tr td:first-child {
            border-top-left-radius: var(--border-radius);
            border-bottom-left-radius: var(--border-radius);
        }

        .table tbody tr td:last-child {
            border-top-right-radius: var(--border-radius);
            border-bottom-right-radius: var(--border-radius);
        }

        /* Badges */
        .badge {
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .bg-success-subtle {
            background-color: rgba(46, 204, 113, 0.1) !important;
            color: #2ECC71 !important;
        }

        .bg-primary-subtle {
            background-color: rgba(4, 142, 142, 0.1) !important;
            color: var(--primary-color) !important;
        }

        .alert {
            border-radius: var(--border-radius);
            border: none;
            padding: 15px 25px;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--light-bg);
        }
        ::-webkit-scrollbar-thumb {
            background: #DDD;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #CCC;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        @auth
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>SIMUDA</h3>
            </div>

            <ul class="list-unstyled components">
                @if(auth()->user()->role !== 'anggota')
                    <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-th me-2"></i> Dashboard</a>
                    </li>
                    <li class="{{ request()->routeIs('kegiatan.*') ? 'active' : '' }}">
                        <a href="{{ route('kegiatan.index') }}"><i class="fas fa-calendar-alt me-2"></i> Kegiatan</a>
                    </li>
                    <li class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}">
                        <a href="{{ route('anggota.index') }}"><i class="fas fa-users me-2"></i> Anggota</a>
                    </li>
                    <li class="{{ request()->routeIs('absensi.*') ? 'active' : '' }}">
                        <a href="{{ route('absensi.index') }}"><i class="fas fa-clipboard-check me-2"></i> Absensi</a>
                    </li>
                    <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}"><i class="fas fa-user-shield me-2"></i> Admins</a>
                    </li>
                    <li class="{{ request()->routeIs('konten.*') ? 'active' : '' }}">
                        <a href="{{ route('konten.index') }}"><i class="fas fa-layer-group me-2"></i> Konten</a>
                    </li>
                    <li class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                        <a href="{{ route('admin.profile') }}"><i class="fas fa-user-circle me-2"></i> Profile</a>
                    </li>
                @else
                    <li class="{{ request()->routeIs('anggota.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('anggota.dashboard') }}"><i class="fas fa-house me-2"></i> Dashboard</a>
                    </li>
                    <li class="{{ request()->routeIs('anggota.absensi.*') ? 'active' : '' }}">
                        <a href="{{ route('anggota.absensi.index') }}"><i class="fas fa-fingerprint me-2"></i> Absensi</a>
                    </li>
                    <li class="{{ request()->routeIs('anggota.profile') ? 'active' : '' }}">
                        <a href="{{ route('anggota.profile') }}"><i class="fas fa-user-circle me-2"></i> Profile</a>
                    </li>
                @endif
            </ul>
        </nav>
        @endauth

        <!-- Page Content -->
        <div id="content">
            @auth
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <h5 class="mb-0 fw-bold">@yield('page-title', 'Overview')</h5>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ms-auto align-items-center">
                            <li class="nav-item me-3">
                                <div class="d-flex align-items-center">
                                    <div class="text-end me-3">
                                        <p class="mb-0 fw-bold small">{{ auth()->user()->name }}</p>
                                        <p class="mb-0 text-muted smaller" style="font-size: 0.7rem;">{{ strtoupper(auth()->user()->role) }}</p>
                                    </div>
                                    @if(auth()->user()->foto_profile)
                                        <img src="{{ route('storage.profiles', auth()->user()->foto_profile) }}" class="rounded-circle shadow-sm" width="40" height="40" style="object-fit: cover;">
                                    @else
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" width="40" height="40" style="width: 40px; height: 40px;">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm border-0 rounded-circle" title="Logout">
                                        <i class="fas fa-power-off"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            @endauth

            <div class="main-container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Show/Hide Password Toggle - Global function
        window.togglePassword = function(inputId) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const icon = input.parentElement.querySelector('i');
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
        };

        $(document).ready(function() {
            // Session Success Alert
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: {!! json_encode(session('success')) !!},
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            // Session Error Alert
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: {!! json_encode(session('error')) !!},
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            // Global Confirmation for Delete/Important Actions
            $('.confirm-dialog').on('click', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');
                let text = $(this).data('text') || 'Tindakan ini tidak dapat dibatalkan!';
                let confirmButtonText = $(this).data('confirm-button') || 'Ya, Hapus!';
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Logout Confirmation
            $('.logout-btn').on('click', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');
                
                Swal.fire({
                    title: 'Konfirmasi Logout',
                    text: "Apakah Anda yakin ingin keluar?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#048E8E',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
