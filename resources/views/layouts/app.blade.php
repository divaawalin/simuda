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
            --primary-dark: #037676;
            --secondary-color: #5FC6D7;
            --accent-color: #6DD5D5;
            --dark-color: #1A252F;
            --dark-light: #2C3E50;
            --light-bg: #F8F9FC;
            --white: #FFFFFF;
            --text-dark: #2C3E50;
            --text-muted: #6c757d;
            --sidebar-width: 280px;
            --border-radius: 16px;
            --border-radius-sm: 10px;
            --card-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            --card-shadow-hover: 0 12px 40px rgba(0, 0, 0, 0.12);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, var(--light-bg) 0%, #f0f4f8 100%);
            background-attachment: fixed;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        #sidebar {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: var(--white);
            color: var(--text-dark);
            transition: var(--transition-slow);
            min-height: 100vh;
            position: sticky;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 30px rgba(0, 0, 0, 0.04);
            border-right: 1px solid rgba(0, 0, 0, 0.04);
            z-index: 100;
        }

        #sidebar.active {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        #sidebar .sidebar-header {
            padding: 32px 28px;
            text-align: left;
            position: relative;
            overflow: hidden;
        }

        #sidebar .sidebar-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 150px;
            height: 150px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            transform: translate(50%, -50%);
            opacity: 0.05;
            z-index: 0;
        }

        #sidebar .sidebar-header h3 {
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
            letter-spacing: -1.5px;
            font-size: 1.75rem;
            position: relative;
            z-index: 1;
        }

        #sidebar .sidebar-header .logo-icon {
            position: relative;
            z-index: 1;
        }

        #sidebar ul.components {
            padding: 20px 15px;
            flex-grow: 1;
            overflow-y: auto;
        }

        #sidebar ul li {
            margin-bottom: 4px;
            position: relative;
        }

        #sidebar ul li a {
            padding: 14px 24px;
            font-size: 0.95rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: var(--border-radius-sm);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        #sidebar ul li a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 0;
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            border-radius: 0 4px 4px 0;
            transition: var(--transition);
        }

        #sidebar ul li a:hover::before {
            height: 70%;
        }

        #sidebar ul li a:hover {
            color: var(--primary-color);
            background: rgba(4, 142, 142, 0.06);
            transform: translateX(3px);
        }

        #sidebar ul li a i {
            width: 26px;
            font-size: 1.1rem;
            transition: var(--transition);
            color: var(--text-muted);
        }

        #sidebar ul li a:hover i {
            color: var(--primary-color);
        }

        #sidebar ul li.active > a {
            color: var(--white);
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 8px 24px rgba(4, 142, 142, 0.25);
            font-weight: 600;
        }

        #sidebar ul li.active > a::before {
            display: none;
        }

        #sidebar ul li.active > a i {
            color: var(--white);
        }

        #sidebar ul li.active > a:hover {
            transform: translateX(0);
        }

        /* Sidebar Footer */
        #sidebar .sidebar-footer {
            padding: 20px 28px;
            border-top: 1px solid rgba(0, 0, 0, 0.04);
            background: rgba(248, 249, 252, 0.3);
        }

        #sidebar .user-profile-mini {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        #sidebar .user-profile-mini img,
        #sidebar .user-profile-mini .avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            object-fit: cover;
        }

        #sidebar .user-info h6 {
            margin: 0;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        #sidebar .user-info small {
            font-size: 0.75rem;
            color: var(--text-muted);
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

        /* Enhanced Navbar */
        .navbar {
            padding: 18px 36px;
            background: var(--white);
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
            position: sticky;
            top: 0;
            z-index: 99;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -1px;
        }

        .page-title {
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            font-size: 1.35rem;
        }

        /* User Profile Dropdown */
        .user-dropdown {
            position: relative;
        }

        .user-profile-btn {
            background: none;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: var(--transition);
            border-radius: 12px;
            padding: 8px 12px;
        }

        .user-profile-btn:hover {
            background: rgba(4, 142, 142, 0.06);
        }

        .user-profile-btn .avatar {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        .user-profile-btn .avatar-placeholder {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            border: 2px solid var(--primary-color);
        }

        .user-profile-btn .user-details {
            text-align: left;
        }

        .user-profile-btn .name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-dark);
            display: block;
            margin-bottom: 2px;
        }

        .user-profile-btn .role-badge {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            background: rgba(4, 142, 142, 0.1);
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .dropdown-menu {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow-hover);
            padding: 10px;
            min-width: 220px;
            margin-top: 8px;
        }

        .dropdown-item {
            padding: 10px 16px;
            border-radius: var(--border-radius-sm);
            font-weight: 500;
            color: var(--text-dark);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-item:hover {
            background: rgba(4, 142, 142, 0.08);
            color: var(--primary-color);
        }

        .dropdown-item i {
            width: 20px;
            color: var(--text-muted);
        }

        .dropdown-item:hover i {
            color: var(--primary-color);
        }

        .dropdown-divider {
            border-color: rgba(0, 0, 0, 0.06);
            margin: 6px 0;
        }

        /* Logout Button */
        .logout-btn {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            border: none;
            padding: 10px 24px;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            color: white;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3);
            background: linear-gradient(135deg, #dc3545, #e74c3c);
        }

        /* Main Container */
        .main-container {
            padding: 30px;
            flex-grow: 1;
        }

        /* Card Customization - Enhanced */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            background: var(--white);
            margin-bottom: 28px;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            padding: 24px 28px;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h6, .card-header h5 {
            margin: 0;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 28px;
        }

        /* Buttons - Enhanced */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 10px 24px;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(4, 142, 142, 0.2);
            transition: var(--transition);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(4, 142, 142, 0.3);
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        .btn-success {
            background: linear-gradient(135deg, #2ECC71, #27ae60);
            border: none;
            padding: 10px 24px;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.2);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(46, 204, 113, 0.3);
        }

        .btn-info {
            background: linear-gradient(135deg, #017a9a, #17a2b8);
            border: none;
            padding: 8px 18px;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            color: white;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(23, 162, 184, 0.2);
        }

        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
            background: linear-gradient(135deg, #017a9a, #17a2b8);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
            border: none;
            padding: 8px 18px;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            color: white;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.2);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 8px 20px;
            border-radius: var(--border-radius-sm);
            font-weight: 600;
            transition: var(--transition);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(4, 142, 142, 0.2);
        }

        /* Stats Cards */
        .stat-card {
            padding: 30px;
            border-radius: var(--border-radius);
            position: relative;
            overflow: hidden;
            border: none;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--card-shadow-hover);
        }

        .stat-card .icon {
            position: absolute;
            right: 25px;
            bottom: 15px;
            font-size: 4.5rem;
            opacity: 0.08;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .stat-card:hover .icon {
            opacity: 0.12;
            transform: scale(1.1);
        }

        /* Tables Customization - Enhanced */
        .table {
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .table thead th {
            border: none;
            color: var(--text-muted);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 18px 25px;
            background: rgba(248, 249, 252, 0.8);
        }

        .table tbody tr {
            background: var(--white);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            border-radius: var(--border-radius-sm);
            transition: var(--transition);
        }

        .table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            background: var(--white);
        }

        .table tbody td {
            padding: 22px 25px;
            border: none;
            vertical-align: middle;
        }

        .table tbody tr td:first-child {
            border-top-left-radius: var(--border-radius-sm);
            border-bottom-left-radius: var(--border-radius-sm);
        }

        .table tbody tr td:last-child {
            border-top-right-radius: var(--border-radius-sm);
            border-bottom-right-radius: var(--border-radius-sm);
        }

        /* Badges - Enhanced */
        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
            letter-spacing: 0.3px;
        }

        .bg-success-subtle {
            background: rgba(46, 204, 113, 0.12) !important;
            color: #27ae60 !important;
        }

        .bg-primary-subtle {
            background: rgba(4, 142, 142, 0.12) !important;
            color: var(--primary-color) !important;
        }

        .bg-info-subtle {
            background: rgba(23, 162, 184, 0.12) !important;
            color: #17a2b8 !important;
        }

        .bg-warning-subtle {
            background: rgba(255, 193, 7, 0.15) !important;
            color: #f39c12 !important;
        }

        .bg-danger-subtle {
            background: rgba(220, 53, 69, 0.12) !important;
            color: #dc3545 !important;
        }

        .bg-secondary-subtle {
            background: rgba(108, 117, 125, 0.12) !important;
            color: #6c757d !important;
        }

        /* Alerts - Enhanced */
        .alert {
            border-radius: var(--border-radius-sm);
            border: none;
            padding: 16px 24px;
            font-weight: 500;
            box-shadow: var(--card-shadow);
        }

        .alert-success {
            background: rgba(46, 204, 113, 0.1);
            color: #27ae60;
            border-left: 4px solid #2ECC71;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border-left: 4px solid #dc3545;
        }

        .alert-warning {
            background: rgba(255, 193, 7, 0.1);
            color: #f39c12;
            border-left: 4px solid #f39c12;
        }

        .alert-info {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
            border-left: 4px solid #17a2b8;
        }

        /* Form Styling - Enhanced */
        .form-control {
            border-radius: var(--border-radius-sm);
            padding: 12px 18px;
            border: 1.5px solid rgba(0, 0, 0, 0.1);
            font-size: 0.95rem;
            transition: var(--transition);
            background: var(--white);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(4, 142, 142, 0.1);
            background: var(--white);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.85rem;
            margin-bottom: 8px;
        }

        /* Form Check */
        .form-check-input {
            border-radius: 6px;
            border: 1.5px solid rgba(0, 0, 0, 0.1);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--light-bg);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* Smooth transitions for page content */
        #content > .main-container > * {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Dropdown animation */
        .dropdown-menu {
            animation: slideDown 0.2s ease-out;
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

        /* Card title with icon */
        .card-header h6 i,
        .card-header h5 i {
            font-size: 1.1rem;
        }

        /* Smooth transitions for page content */
        #content > .main-container > * {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Dashboard specific animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 5px rgba(4, 142, 142, 0.2); }
            50% { box-shadow: 0 0 20px rgba(4, 142, 142, 0.4); }
        }

        .float-animation i {
            animation: float 3s ease-in-out infinite;
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        /* Card hover effects */
        .hover-lift {
            transition: var(--transition);
        }

        .hover-lift:hover {
            transform: translateY(-6px);
            box-shadow: var(--card-shadow-hover);
        }

        /* Gradient backgrounds for icons */
        .gradient-icon-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-bg-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        /* Decorative corner accents */
        .corner-decoration {
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            filter: blur(60px);
            z-index: 0;
            pointer-events: none;
        }

        .corner-tl {
            top: -50px;
            left: -50px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            opacity: 0.1;
        }

        .corner-br {
            bottom: -50px;
            right: -50px;
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            opacity: 0.1;
        }

        /* Activity feed styling enhancements */
        .activity-item {
            transition: var(--transition);
        }

        .activity-item:hover {
            background-color: rgba(4, 142, 142, 0.03);
            transform: translateX(5px);
        }

        /* Stats number styling */
        .stats-number {
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Quick action button hover effect */
        .quick-action-btn {
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .quick-action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .quick-action-btn:hover::before {
            left: 100%;
        }

        /* Notification item styling */
        .notification-item {
            transition: var(--transition);
        }

        .notification-item:hover {
            background-color: rgba(4, 142, 142, 0.04);
            padding-left: 1rem;
        }

        /* Chevron animation */
        .chevron-animation {
            transition: var(--transition);
        }

        .notification-item:hover .chevron-animation {
            transform: translateX(5px);
        }

        /* Card header gradient line */
        .card-header-gradient {
            position: relative;
        }

        .card-header-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--primary-color));
            background-size: 200% 100%;
            animation: gradientMove 3s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Success indicator pulse */
        .pulse-indicator {
            position: relative;
        }

        .pulse-indicator::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.3;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: translate(-50%, -50%) scale(0.8); opacity: 0.5; }
            100% { transform: translate(-50%, -50%) scale(2); opacity: 0; }
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
                position: fixed;
                left: 0;
                top: 0;
            }

            #sidebar.active {
                margin-left: 0;
            }

            .navbar {
                padding: 16px 20px;
            }

            .main-container {
                padding: 20px;
            }

            .user-profile-btn .user-details {
                display: none;
            }

            .page-title {
                font-size: 1.1rem;
            }

            /* Adjust dashboard for mobile */
            .display-6 {
                font-size: 2rem;
            }

            .card-body .row.g-3 .col-md-4 {
                margin-bottom: 1rem;
            }
        }

            #sidebar.active {
                margin-left: 0;
            }

            .navbar {
                padding: 16px 20px;
            }

            .main-container {
                padding: 20px;
            }

            .user-profile-btn .user-details {
                display: none;
            }

            .page-title {
                font-size: 1.1rem;
            }

            /* Adjust dashboard for mobile */
            .display-6 {
                font-size: 2rem;
            }

            .card-body .row.g-3 .col-md-4 {
                margin-bottom: 1rem;
            }
        }

        /* Notification badge */
        .notification-badge {
            position: relative;
        }

        .notification-badge::after {
            content: '';
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background: #dc3545;
            border-radius: 50%;
            border: 2px solid var(--white);
        }

        /* Action buttons group */
        .action-btns {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .action-btn {
            width: 34px;
            height: 34px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: none;
            transition: var(--transition);
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        /* Empty state styling */
        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }

        .empty-state i {
            font-size: 4rem;
            opacity: 0.15;
            margin-bottom: 20px;
        }

        .empty-state p {
            color: var(--text-muted);
        }

        /* Dashboard Decorative Elements */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }

        .gradient-icon {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        /* Activity feed styling */
        .activity-feed .list-group-item-action:hover {
            background-color: rgba(4, 142, 142, 0.04);
        }

        /* Stats number animation */
        .display-6 {
            font-size: 2.5rem;
            font-weight: 700;
        }

        /* Letter spacing for uppercase */
        .letter-spacing-1 {
            letter-spacing: 1px;
        }

        /* Backdrop blur for decorative elements */
        .backdrop-blur {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Progress bar gradient override */
        .progress-bar {
            transition: width 1s ease-out;
        }

        /* Card footer link styling */
        .card-footer a:hover {
            transform: translateX(5px);
            display: inline-block;
            transition: var(--transition);
        }

        /* List group item hover */
        .list-group-item-action {
            transition: var(--transition);
        }

        .list-group-item-action:hover i.fa-chevron-right {
            transform: translateX(3px);
            display: inline-block;
            transition: var(--transition);
        }

        /* Decorative pattern background */
        .pattern-bg {
            background-image: radial-gradient(circle at 20% 50%, rgba(4, 142, 142, 0.08) 0%, transparent 50%),
                              radial-gradient(circle at 80% 80%, rgba(95, 198, 215, 0.08) 0%, transparent 50%);
        }

        /* Enhanced shadow for stat cards */
        .stat-card {
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            transition: var(--transition);
        }

        .stat-card:hover {
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
        }

        .notification-badge::after {
            content: '';
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background: #dc3545;
            border-radius: 50%;
            border: 2px solid var(--white);
        }

        /* Action buttons group */
        .action-btns {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .action-btn {
            width: 34px;
            height: 34px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: none;
            transition: var(--transition);
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        /* Empty state styling */
        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }

        .empty-state i {
            font-size: 4rem;
            opacity: 0.15;
            margin-bottom: 20px;
        }

        .empty-state p {
            color: var(--text-muted);
            font-size: 0.95rem;
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
                     <li class="{{ request()->routeIs('anggota.konten.*') ? 'active' : '' }}">
                         <a href="{{ route('anggota.konten.index') }}"><i class="fas fa-layer-group me-2"></i> Konten</a>
                     </li>
                     <li class="{{ request()->routeIs('anggota.profile*') ? 'active' : '' }}">
                         <a href="{{ route('anggota.profile') }}"><i class="fas fa-user-circle me-2"></i> Profile</a>
                     </li>
                 @endif
             </ul>

             @auth
             <div class="sidebar-footer">
                 <div class="user-profile-mini">
                     @if(auth()->user()->foto_profile)
                         <img src="{{ route('storage.profiles', auth()->user()->foto_profile) }}" class="avatar" alt="Profile">
                     @else
                         <div class="avatar-placeholder">
                             {{ substr(auth()->user()->name, 0, 1) }}
                         </div>
                     @endif
                     <div class="user-info">
                         <h6 title="{{ auth()->user()->name }}">{{ auth()->user()->name }}</h6>
                         <small>{{ strtoupper(auth()->user()->role) }}</small>
                     </div>
                 </div>
             </div>
             @endauth
         </nav>
         @endauth

        <!-- Page Content -->
        <div id="content">
            @auth
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <h5 class="mb-0 fw-bold page-title">@yield('page-title', 'Overview')</h5>
                    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ms-auto align-items-center">
                            <li class="nav-item dropdown">
                                <button class="user-profile-btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if(auth()->user()->foto_profile)
                                        <img src="{{ route('storage.profiles', auth()->user()->foto_profile) }}" class="avatar" alt="Profile">
                                    @else
                                        <div class="avatar-placeholder">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="user-details d-none d-md-block">
                                        <span class="name">{{ auth()->user()->name }}</span>
                                        <span class="role-badge">{{ strtoupper(auth()->user()->role) }}</span>
                                    </div>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li>
                                        <span class="dropdown-item-text">
                                            <small class="text-muted d-block mb-2">Masuk sebagai</small>
                                            <strong>{{ auth()->user()->email }}</strong>
                                        </span>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ auth()->user()->role === 'anggota' ? route('anggota.profile') : route('admin.profile') }}">
                                            <i class="fas fa-user-circle"></i> My Profile
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger logout-btn w-100 text-start">
                                                <i class="fas fa-sign-out-alt"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
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
            let icon = null;
            // Try to find the icon in the immediate next sibling span of the input
            const nextSibling = input.nextElementSibling;
            if (nextSibling && nextSibling.tagName === 'SPAN' && nextSibling.querySelector('i')) {
                icon = nextSibling.querySelector('i');
            } else if (input.parentElement) {
                // Fallback: search for any i within the parent container
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
