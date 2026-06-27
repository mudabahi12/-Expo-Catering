<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expo Catering - Centralized Operations</title>
    <meta name="description" content="Expo Catering - Centralized catering ERP, ordering kiosk, and operations matrix.">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #e65f2b; /* Cream-orange primary brand color */
            --primary-hover: #cf4f20;
            --bg-cream: #fbfbf8; /* Cream base */
            --bg-card: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --grid-color: rgba(230, 95, 43, 0.04);
            --border-light: rgba(226, 232, 240, 0.8);
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 10px 25px -5px rgba(230, 95, 43, 0.05), 0 8px 10px -6px rgba(0,0,0,0.01);
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-cream);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
            background-image: 
                linear-gradient(to right, var(--grid-color) 1px, transparent 1px),
                linear-gradient(to bottom, var(--grid-color) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        /* Glowing Radial Blur Elements */
        .radial-blur-orange {
            position: absolute;
            top: -10%;
            right: -10%;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(230, 95, 43, 0.12) 0%, rgba(230, 95, 43, 0) 70%);
            filter: blur(40px);
            pointer-events: none;
            z-index: 0;
        }

        .radial-blur-cream {
            position: absolute;
            bottom: -10%;
            left: -15%;
            width: 700px;
            height: 700px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(230, 95, 43, 0.06) 0%, rgba(230, 95, 43, 0) 70%);
            filter: blur(50px);
            pointer-events: none;
            z-index: 0;
        }

        header {
            position: relative;
            z-index: 10;
            padding: 1.5rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-light);
            background: rgba(251, 251, 248, 0.8);
            backdrop-filter: blur(10px);
        }

        .logo-group {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
            color: var(--text-dark);
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.15rem;
            font-weight: 800;
            font-family: 'Outfit', sans-serif;
            box-shadow: 0 4px 10px rgba(230, 95, 43, 0.2);
        }

        .logo-text {
            font-family: 'Outfit', sans-serif;
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .btn-staff-login {
            background: #0f172a;
            color: white;
            padding: 0.65rem 1.25rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border: 1px solid #1e293b;
        }

        .btn-staff-login:hover {
            background: #1e293b;
            transform: translateY(-1px);
        }

        main {
            position: relative;
            z-index: 5;
            flex: 1;
            padding: 4rem 3rem 6rem;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .hero-section {
            max-width: 750px;
            margin-bottom: 4rem;
        }

        .badge-system {
            background: rgba(230, 95, 43, 0.08);
            border: 1px solid rgba(230, 95, 43, 0.15);
            color: var(--primary);
            padding: 0.35rem 0.85rem;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            display: inline-block;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
        }

        .hero-title {
            font-family: 'Outfit', sans-serif;
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            color: var(--text-dark);
            letter-spacing: -1px;
            margin-bottom: 1.5rem;
        }

        .hero-title span {
            color: var(--primary);
        }

        .hero-desc {
            font-size: 1.15rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 2.5rem;
            font-weight: 450;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            padding: 0.8rem 1.75rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(230, 95, 43, 0.2);
            transition: var(--transition);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: white;
            color: var(--text-dark);
            border: 1px solid var(--border-light);
            padding: 0.8rem 1.75rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .btn-secondary:hover {
            background: #fafafa;
            border-color: #cbd5e1;
        }

        /* Stats Row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2.5rem;
            width: 100%;
            max-width: 900px;
            margin-bottom: 5rem;
            background: white;
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-md);
        }

        .stat-card {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .stat-number {
            font-family: 'Outfit', sans-serif;
            font-size: 3rem;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.1;
        }

        .stat-number.primary-color {
            color: var(--primary);
        }

        .stat-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 0.5rem;
        }

        /* Features Section */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            width: 100%;
            max-width: 950px;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.75rem;
            }
            .stats-row {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            .features-grid {
                grid-template-columns: 1fr;
            }
            header {
                padding: 1rem 1.5rem;
            }
            main {
                padding: 2rem 1.5rem 4rem;
            }
        }

        .feature-card {
            background: white;
            border: 1px solid var(--border-light);
            border-radius: 12px;
            padding: 2rem;
            text-align: left;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .feature-card:hover {
            transform: translateY(-3px);
            border-color: rgba(230, 95, 43, 0.2);
            box-shadow: var(--shadow-md);
        }

        .feature-icon-wrapper {
            width: 44px;
            height: 44px;
            background: rgba(230, 95, 43, 0.08);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.25rem;
            margin-bottom: 0.25rem;
        }

        .feature-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .feature-desc {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        footer {
            position: relative;
            z-index: 10;
            padding: 2rem;
            border-top: 1px solid var(--border-light);
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
            background: rgba(251, 251, 248, 0.8);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
    <div class="radial-blur-orange"></div>
    <div class="radial-blur-cream"></div>

    <header>
        <a href="/" class="logo-group">
            <div class="logo-icon">E</div>
            <span class="logo-text">Expo Catering</span>
        </a>
        <nav>
            <a href="#features" class="nav-link">Features</a>
            <a href="/restaurant" class="nav-link" style="color: var(--primary); font-weight:700;">Customer Order Page</a>
            <a href="/login" class="btn-staff-login">Staff Login</a>
        </nav>
    </header>

    <main>
        <div class="hero-section">
            <span class="badge-system">Catering Operations Platform</span>
            <h1 class="hero-title">Catering.<br><span>Centralized.</span></h1>
            <p class="hero-desc">
                From kitchen prep sheets to live ordering and corporate accounts directory. Expo Catering consolidates your entire catering matrix into a single dashboard.
            </p>
            <div class="hero-actions">
                <a href="/restaurant" class="btn-primary">Order Screen</a>
                @auth
                    <a href="/admin/dashboard" class="btn-secondary">Open Console</a>
                @else
                    <a href="/login" class="btn-secondary">Staff Console</a>
                @endauth
            </div>
        </div>

        <!-- Stats Row -->
        <div class="stats-row">
            <div class="stat-card">
                <span class="stat-number primary-color">∞</span>
                <span class="stat-label">Orders</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">0</span>
                <span class="stat-label">Paper Tickets</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">1</span>
                <span class="stat-label">System</span>
            </div>
        </div>

        <!-- Features Grid -->
        <div id="features" class="features-grid">
            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h3 class="feature-title">Smart Orders</h3>
                <p class="feature-desc">Real-time ordering system equipped with an AI conversational assistant and automated checkout queues.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                </div>
                <h3 class="feature-title">Print Tickets</h3>
                <p class="feature-desc">Generate beautifully formatted printing templates and PDF bills instantly from the dispatch console.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3 class="feature-title">Pharma Reps</h3>
                <p class="feature-desc">Store medical/pharma accounts, corporate profiles, contacts and designated delivery locations.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon-wrapper">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                </div>
                <h3 class="feature-title">AR & Reports</h3>
                <p class="feature-desc">Track client receivables, unpaid billing invoices, sales metrics, and daily production sheets.</p>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Expo Catering. All Rights Reserved. Built in Laravel & PHP.</p>
    </footer>
</body>
</html>
