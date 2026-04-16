<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SIMUDA') }}</title>
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            display: flex;
            height: 100vh;
            background-color: #f4f7f6;
            color: #333;
        }
        .sidebar {
            width: 260px;
            background-color: #2c3e50;
            color: white;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }
        .sidebar-header {
            padding: 20px;
            text-align: center;
            background-color: #1a252f;
        }
        .sidebar-header h2 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 1px;
        }
        .sidebar-menu {
            flex: 1;
            padding: 10px 0;
            overflow-y: auto;
        }
        .sidebar-menu a {
            color: #bdc3c7;
            text-decoration: none;
            padding: 12px 25px;
            display: block;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        .sidebar-menu a:hover {
            background-color: #34495e;
            color: white;
        }
        .sidebar-menu a.active {
            background-color: #34495e;
            color: white;
            border-left: 4px solid #3498db;
        }
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .topbar {
            height: 60px;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            z-index: 10;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .role-badge {
            background-color: #3498db;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
            text-transform: uppercase;
        }
        .btn-logout {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }
        .btn-logout:hover {
            background-color: #c0392b;
        }
        .content {
            padding: 30px;
            overflow-y: auto;
            flex: 1;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        /* Dashboard Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            text-align: center;
        }
        .stat-card h3 {
            margin: 0;
            color: #7f8c8d;
            font-size: 14px;
            text-transform: uppercase;
        }
        .stat-card p {
            margin: 10px 0 0;
            font-size: 32px;
            font-weight: bold;
            color: #2c3e50;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }
        tr:last-child td {
            border-bottom: none;
        }

        /* Forms */
        .card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-control:focus {
            outline: none;
            border-color: #3498db;
        }
        
        /* Buttons */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: background 0.3s;
        }
        .btn-primary {
            background-color: #3498db;
            color: white;
        }
        .btn-primary:hover {
            background-color: #2980b9;
        }
        .btn-success {
            background-color: #2ecc71;
            color: white;
        }
        .btn-success:hover {
            background-color: #27ae60;
        }
        .btn-warning {
            background-color: #f1c40f;
            color: white;
        }
        .btn-warning:hover {
            background-color: #f39c12;
        }
        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        /* Badges */
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .badge-info { background-color: #3498db; color: white; }
        .badge-success { background-color: #2ecc71; color: white; }
        .badge-secondary { background-color: #95a5a6; color: white; }
    </style>
</head>
<body>
    @auth
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>SIMUDA</h2>
        </div>
        <div class="sidebar-menu">
            @if(auth()->user()->role !== 'anggota')
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('kegiatan.index') }}" class="{{ request()->routeIs('kegiatan.*') ? 'active' : '' }}">Manajemen Kegiatan</a>
                <a href="{{ route('anggota.index') }}" class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}">Manajemen Anggota</a>
                <a href="{{ route('absensi.index') }}" class="{{ request()->routeIs('absensi.*') ? 'active' : '' }}">Manajemen Absensi</a>
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">Users Admin</a>
                <a href="{{ route('konten.index') }}" class="{{ request()->routeIs('konten.*') ? 'active' : '' }}">Manajemen Konten</a>
                <a href="{{ route('admin.profile') }}" class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}">Profile</a>
            @else
                <a href="{{ route('anggota.dashboard') }}" class="{{ request()->routeIs('anggota.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('anggota.absensi.index') }}" class="{{ request()->routeIs('anggota.absensi.*') ? 'active' : '' }}">Absensi</a>
                <a href="{{ route('anggota.profile') }}" class="{{ request()->routeIs('anggota.profile') ? 'active' : '' }}">Profile</a>
            @endif
        </div>
    </div>
    <div class="main-content">
        <div class="topbar">
            <div class="user-info">
                <span>Selamat Datang, <strong>{{ auth()->user()->name }}</strong></span>
                <span class="role-badge">{{ auth()->user()->role }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
        <div class="content">
    @else
        <div class="main-content" style="width: 100%;">
        <div class="content">
    @endauth
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>
@auth
    </div>
@endauth
</body>
</html>
