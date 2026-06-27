<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CaterFlow PRO - Unified Catering Matrix')</title>
    <meta name="description" content="CaterFlow PRO is a unified catering operations console and real-time restaurant matrix.">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Premium Global Styling - CaterFlow Light Theme -->
    <style>
        :root {
            --primary: #4f46e5; /* CaterFlow Indigo */
            --primary-hover: #3730a3;
            --primary-light: #e0e7ff;
            --bg-body: #f8fafc; /* Very light gray-blue body */
            --bg-header: #ffffff; /* White header */
            --bg-card: #ffffff; /* White cards */
            --text-main: #0f172a; /* Dark slate text */
            --text-muted: #64748b; /* Gray text */
            --accent: #4f46e5;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --border-light: #edf2f7;
            --shadow-premium: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.025);
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', 'Outfit', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* CaterFlow Top Bar */
        header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: var(--bg-header);
            border-bottom: 1px solid var(--border-light);
            padding: 0.85rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--text-main);
        }

        .logo-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--primary), #6366f1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.2rem;
            color: #fff;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }

        .logo-text-group {
            display: flex;
            flex-direction: column;
        }

        .logo-text-title {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .logo-text {
            font-family: 'Outfit', sans-serif;
            font-size: 1.45rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #1e293b;
        }

        .logo-badge {
            background: #4f46e5;
            color: #fff;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 0.15rem 0.4rem;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .logo-sub {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: #94a3b8;
            text-transform: uppercase;
            margin-top: -1px;
        }

        /* Center Nav links */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .nav-links a:hover {
            color: #4f46e5;
            background: #f1f5f9;
        }

        /* Dashboard Active pill style */
        .nav-links a.active-dashboard {
            background: #e0e7ff;
            color: #4f46e5;
            border: 1px solid rgba(79, 70, 229, 0.15);
        }

        /* Red Laravel Source style */
        .nav-links a.laravel-source-link {
            color: #ef4444;
        }
        .nav-links a.laravel-source-link:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        /* Right Header Actions */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-profile-section {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .user-text-meta {
            display: flex;
            flex-direction: column;
            text-align: right;
        }

        .user-name-bold {
            font-size: 0.9rem;
            font-weight: 700;
            color: #1e293b;
        }

        .user-role-sub {
            font-size: 0.7rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .user-avatar-container {
            position: relative;
            width: 38px;
            height: 38px;
        }

        .user-avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #f1f5f9;
            border: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            color: #4f46e5;
        }

        .user-avatar-badge {
            position: absolute;
            bottom: -2px;
            right: -4px;
            background: #ffb800;
            color: #fff;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
            border: 1px solid #fff;
        }

        .logout-btn-icon {
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .logout-btn-icon:hover {
            color: #ef4444;
        }

        /* Buttons styling */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.65rem 1.25rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: var(--transition);
            gap: 0.5rem;
        }

        .btn-primary {
            background: #4f46e5;
            color: #fff;
        }

        .btn-primary:hover {
            background: #4338ca;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #0f172a;
            color: #fff;
        }

        .btn-secondary:hover {
            background: #1e293b;
            transform: translateY(-1px);
        }

        .btn-sm {
            padding: 0.45rem 0.9rem;
            font-size: 0.8rem;
            border-radius: 6px;
        }

        /* Main Container */
        main {
            flex: 1;
            padding: 2.5rem 3rem;
            max-width: 1440px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
        }

        /* Alerts Styling */
        .alert {
            padding: 0.85rem 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 500;
            font-size: 0.9rem;
            animation: fadeIn 0.3s ease;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .alert-close {
            background: none;
            border: none;
            color: inherit;
            font-size: 1.1rem;
            cursor: pointer;
        }

        /* Glass / Light Panel */
        .glass-panel {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.75rem;
            box-shadow: var(--shadow-premium);
        }

        /* Footer */
        footer {
            margin-top: auto;
            padding: 1.5rem;
            border-top: 1px solid var(--border-light);
            text-align: center;
            color: var(--text-muted);
            font-size: 0.8rem;
            background: #ffffff;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }
            main {
                padding: 1.5rem 1rem;
            }
        }
    </style>
    @yield('styles')
</head>
<body>


    <main>
        @if(session('success'))
            <div class="alert alert-success">
                <span>{{ session('success') }}</span>
                <button class="alert-close" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <span>{{ session('error') }}</span>
                <button class="alert-close" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} CaterFlow PRO Matrix. Built in Laravel & PHP for high-throughput catering logistics.</p>
    </footer>

    @yield('scripts')
</body>
</html>
