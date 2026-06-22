<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Travel To Tunisia') }} - @yield('title', 'Dashboard')</title>

    {{-- Premium Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.jsx'])

    <style>
        /* ============================================
           TUNISIAN LUXURY DESIGN SYSTEM
           ============================================ */
        :root {
            --tunisia-red: #C1121F;
            --tunisia-red-dark: #780000;
            --tunisia-gold: #D4AF37;
            --tunisia-gold-light: #F4E4B1;
            --med-blue: #1D3557;
            --deep-teal: #2A4B4C;
            --sand: #F4EADB;
            --sand-light: #FBF7F0;
            --cream: #FFFDF7;
            --white: #FFFFFF;
            --charcoal: #1E1E24;
            --text-primary: #1A1C1E;
            --text-secondary: #5B5E64;
            --text-muted: #8B8E94;
            --border-light: #E1DFD8;
            --border-lighter: #F0EEE7;
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.02), 0 1px 2px rgba(0, 0, 0, 0.03);
            --shadow-md: 0 6px 14px rgba(0, 0, 0, 0.04), 0 2px 6px rgba(0, 0, 0, 0.03);
            --shadow-lg: 0 12px 28px rgba(0, 0, 0, 0.06), 0 4px 12px rgba(0, 0, 0, 0.04);
            --shadow-xl: 0 20px 40px rgba(0, 0, 0, 0.08), 0 8px 20px rgba(0, 0, 0, 0.04);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --radius-xl: 32px;
            --transition: 0.25s cubic-bezier(0.33, 1, 0.68, 1);
            --transition-slow: 0.4s cubic-bezier(0.33, 1, 0.68, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--cream);
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 30 L60 30 L60 0 L30 0 Z' fill='%23f4eadb' fill-opacity='0.3'/%3E%3Cpath d='M0 0 L30 0 L30 30 L0 30 Z' fill='%23f4eadb' fill-opacity='0.15'/%3E%3C/svg%3E");
        }

        /* ========== TOP UTILITY BAR ========== */
        .top-bar {
            background: var(--tunisia-red);
            color: white;
            font-size: 0.8rem;
            padding: 0.4rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .top-bar .left,
        .top-bar .right {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .top-bar a {
            color: white;
            text-decoration: none;
            opacity: 0.9;
            transition: opacity var(--transition);
        }

        .top-bar a:hover {
            opacity: 1;
        }

        .top-bar i {
            margin-right: 0.4rem;
        }

        /* ========== MAIN HEADER (Sticky) ========== */
        .tunisia-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(200, 200, 180, 0.3);
            transition: background var(--transition), box-shadow var(--transition);
        }

        .tunisia-header.scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: var(--shadow-md);
        }

        .header-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0.8rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .logo-wrapper a {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            background: var(--tunisia-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--tunisia-red-dark);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
        }

        .logo-text {
            font-family: 'Cinzel', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--tunisia-red);
            letter-spacing: 0.5px;
            line-height: 1;
        }

        .logo-text span {
            color: var(--med-blue);
        }

        /* Desktop Navigation */
        .desktop-nav {
            display: flex;
            gap: 0.3rem;
            align-items: center;
        }

        .nav-link {
            text-decoration: none;
            font-weight: 500;
            color: var(--text-secondary);
            padding: 0.6rem 1rem;
            border-radius: var(--radius-sm);
            transition: all var(--transition);
            font-size: 0.9rem;
            position: relative;
        }

        .nav-link:hover {
            color: var(--tunisia-red);
            background: rgba(193, 18, 31, 0.04);
        }

        .nav-link.active {
            color: var(--tunisia-red);
            background: rgba(193, 18, 31, 0.08);
            font-weight: 600;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--tunisia-gold);
            transition: width 0.3s ease, left 0.3s ease;
        }

        .nav-link:hover::after {
            width: 50%;
            left: 25%;
        }

        /* User dropdown */
        .user-menu {
            position: relative;
        }

        .user-trigger {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--sand);
            border: 1px solid var(--border-light);
            padding: 0.5rem 1.2rem;
            border-radius: 30px;
            font-weight: 600;
            color: var(--text-primary);
            cursor: pointer;
            transition: all var(--transition);
            font-size: 0.9rem;
        }

        .user-trigger:hover {
            background: white;
            border-color: var(--tunisia-gold);
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
        }

        .user-dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 0.8rem);
            background: white;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-xl);
            min-width: 220px;
            padding: 0.5rem 0;
            border: 1px solid var(--border-light);
            opacity: 0;
            visibility: hidden;
            transform: translateY(8px);
            transition: opacity 0.2s, transform 0.3s cubic-bezier(0.33, 1, 0.68, 1), visibility 0.2s;
            z-index: 200;
        }

        .user-menu:hover .user-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .user-dropdown a,
        .user-dropdown form button {
            display: block;
            width: 100%;
            text-align: left;
            padding: 0.7rem 1.4rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
            text-decoration: none;
            background: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
            transition: background var(--transition), color var(--transition);
        }

        .user-dropdown a:hover,
        .user-dropdown form button:hover {
            background: var(--sand-light);
            color: var(--tunisia-red);
        }

        /* ---------- MOBILE HAMBURGER ---------- */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.8rem;
            color: var(--text-primary);
            cursor: pointer;
            z-index: 200;
            position: relative;
        }

        .hamburger-line {
            display: block;
            width: 28px;
            height: 2.5px;
            background: var(--text-primary);
            margin: 6px 0;
            transition: all 0.3s;
            border-radius: 2px;
        }

        .mobile-toggle.open .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(5px, 6px);
        }

        .mobile-toggle.open .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        .mobile-toggle.open .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -6px);
        }

        /* Full‑screen overlay for mobile */
        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.4s, visibility 0.4s;
            z-index: 150;
        }

        .mobile-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            right: 0;
            width: 320px;
            max-width: 85vw;
            height: 100vh;
            background: white;
            padding: 2rem 1.5rem;
            box-shadow: var(--shadow-xl);
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.33, 1, 0.68, 1);
            z-index: 160;
            display: flex;
            flex-direction: column;
            border-left: 1px solid var(--border-lighter);
        }

        .mobile-menu.show {
            transform: translateX(0);
        }

        .mobile-menu a,
        .mobile-menu button {
            display: block;
            width: 100%;
            text-align: left;
            padding: 0.8rem 1rem;
            border-radius: var(--radius-sm);
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 1rem;
            transition: background var(--transition), color var(--transition);
            border: none;
            background: none;
            cursor: pointer;
            font-family: inherit;
        }

        .mobile-menu a:hover,
        .mobile-menu button:hover {
            background: var(--sand-light);
            color: var(--tunisia-red);
        }

        .mobile-menu .gold-divider {
            width: 50px;
            height: 4px;
            background: var(--tunisia-gold);
            margin: 0.8rem 0 1.2rem;
            border-radius: 2px;
        }

        .mobile-menu .user-section {
            margin-top: auto;
            border-top: 1px solid var(--border-lighter);
            padding-top: 1.5rem;
        }

        .mobile-menu .user-name {
            font-weight: 600;
            color: var(--med-blue);
            margin-bottom: 0.5rem;
        }

        .mobile-menu .user-email {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        @media (max-width: 960px) {
            .desktop-nav {
                display: none;
            }

            .mobile-toggle {
                display: block;
            }
        }

        /* ========== HERO / PAGE HEADER ========== */
        .page-hero {
            background: linear-gradient(135deg, var(--med-blue) 0%, #0D2636 60%);
            position: relative;
            padding: 3.5rem 2rem 2.8rem;
            overflow: hidden;
            color: white;
            text-align: center;
        }

        .page-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M20 20 L40 20 L40 40 L20 40 Z' fill='%23d4af37' fill-opacity='0.08'/%3E%3Cpath d='M0 0 L20 0 L20 20 L0 20 Z' fill='%23d4af37' fill-opacity='0.04'/%3E%3Cpath d='M60 60 L80 60 L80 80 L60 80 Z' fill='%23d4af37' fill-opacity='0.06'/%3E%3C/svg%3E");
            opacity: 0.6;
        }

        .page-hero .hero-inner {
            position: relative;
            z-index: 1;
            max-width: 700px;
            margin: 0 auto;
        }

        .page-hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            line-height: 1.2;
            margin-bottom: 0.8rem;
        }

        .page-hero .gold-line {
            width: 80px;
            height: 5px;
            background: var(--tunisia-gold);
            margin: 0 auto 1rem;
            border-radius: 4px;
        }

        .page-hero p {
            font-size: 1rem;
            opacity: 0.9;
            max-width: 500px;
            margin: 0 auto;
        }

        /* ========== MAIN CONTENT ========== */
        .content-area {
            max-width: 1280px;
            margin: 2.5rem auto;
            padding: 0 2rem;
        }

        /* ---- Reusable card ---- */
        .tn-card {
            background: white;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-lighter);
            transition: all var(--transition);
            overflow: hidden;
        }

        .tn-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        /* ---- Buttons ---- */
        .btn-gold {
            background: linear-gradient(135deg, var(--tunisia-gold) 0%, #E5B73B 100%);
            color: var(--charcoal);
            padding: 0.7rem 1.8rem;
            border-radius: 40px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
            transition: all var(--transition);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.25);
            letter-spacing: 0.3px;
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(212, 175, 55, 0.4);
        }

        .btn-red {
            background: var(--tunisia-red);
            color: white;
            padding: 0.7rem 1.8rem;
            border-radius: 40px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all var(--transition);
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(193, 18, 31, 0.2);
        }

        .btn-red:hover {
            background: var(--tunisia-red-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(193, 18, 31, 0.35);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--border-light);
            color: var(--text-primary);
            padding: 0.65rem 1.8rem;
            border-radius: 40px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all var(--transition);
        }

        .btn-outline:hover {
            background: var(--sand);
            border-color: var(--tunisia-gold);
        }

        /* ---- Table ---- */
        .table-wrapper {
            overflow-x: auto;
            border-radius: var(--radius-md);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th {
            text-align: left;
            padding: 1rem 1.5rem;
            background: var(--sand-light);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-light);
        }

        td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-lighter);
            color: var(--text-primary);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: rgba(244, 234, 219, 0.3);
        }

        /* ---- Alert ---- */
        .alert-box {
            padding: 1rem 1.5rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 0.9rem;
            border: 1px solid;
        }

        .alert-success {
            background: #EDF7ED;
            color: #2B5E22;
            border-color: #B8E0B8;
        }

        .alert-error {
            background: #FFEAEA;
            color: #A6342A;
            border-color: #F5C6C0;
        }

        /* ---- Footer ---- */
        .tn-footer {
            background: var(--charcoal);
            color: rgba(255, 255, 255, 0.7);
            padding: 3rem 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .tn-footer h4 {
            color: var(--tunisia-gold);
            margin-bottom: 1rem;
            font-family: 'Cinzel', serif;
            font-size: 1rem;
        }

        .tn-footer ul {
            list-style: none;
        }

        .tn-footer ul li {
            margin-bottom: 0.5rem;
        }

        .tn-footer a {
            color: inherit;
            text-decoration: none;
            transition: color var(--transition);
        }

        .tn-footer a:hover {
            color: var(--tunisia-gold);
        }

        .footer-bottom {
            text-align: center;
            padding: 1.5rem;
            background: #111;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.8rem;
        }

        @media (max-width: 768px) {
            .top-bar {
                padding: 0.4rem 1rem;
                flex-direction: column;
                text-align: center;
            }

            .header-inner {
                padding: 0.8rem 1rem;
            }

            .content-area {
                padding: 0 1rem;
            }
        }
    </style>
</head>

<body>
    {{-- Top bar --}}
    <div class="top-bar">
        <div class="left">
            <a href="tel:+216XXXXXXXX"><i class="fas fa-phone-alt"></i> +216 XX XXX XXX</a>
            <a href="mailto:contact@traveltotunisia.com"><i class="fas fa-envelope"></i> contact@traveltotunisia.com</a>
        </div>
        <div class="right">
            <span>🇹🇳 Discover the beauty of Tunisia</span>
        </div>
    </div>

    {{-- Sticky header --}}
    <header class="tunisia-header" id="mainHeader">
        <div class="header-inner">
            <div class="logo-wrapper">
                <a href="{{ route('home') }}">
                    <div class="logo-icon">🇹🇳</div>
                    <div class="logo-text">Travel<span>ToTunisia</span></div>
                </a>
            </div>

            <!-- Desktop nav -->
            <nav class="desktop-nav" id="desktopNav">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('trips.index') }}"
                    class="nav-link {{ request()->routeIs('trips.*') ? 'active' : '' }}">Trips</a>
                <a href="{{ route('destinations.index') }}"
                    class="nav-link {{ request()->routeIs('destinations.*') ? 'active' : '' }}">Destinations</a>
                <a href="{{ route('activities.index') }}"
                    class="nav-link {{ request()->routeIs('activities.*') ? 'active' : '' }}">Activities</a>
                <a href="{{ route('blog.index') }}"
                    class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>
                <a href="{{ route('directory.index') }}"
                    class="nav-link {{ request()->routeIs('directory.*') ? 'active' : '' }}">Directory</a>
                <a href="{{ route('transport.index') }}"
                    class="nav-link {{ request()->routeIs('transport.*') ? 'active' : '' }}">Transport</a>
                <a href="{{ route('planner') }}"
                    class="nav-link {{ request()->routeIs('planner') ? 'active' : '' }}">Trip Planner</a>
                <a href="{{ route('explore-map') }}"
                    class="nav-link {{ request()->routeIs('explore-map') ? 'active' : '' }}">Explore Map</a>

                @auth
                    <div class="user-menu">
                        <button class="user-trigger">
                            {{ Auth::user()->name }} <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="user-dropdown">
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.blogs.index') }}">Manage Blogs</a>
                                <a href="{{ route('admin.destinations.index') }}">Manage Destinations</a>
                                <a href="{{ route('admin.activities.index') }}">Manage Activities</a>
                                <a href="{{ route('admin.establishments.index') }}">Manage Directory</a>
                                <a href="{{ route('admin.transport.index') }}">Manage Transport</a>
                                <hr style="border-color: var(--border-light); margin: 0.3rem 0;">
                            @endif
                            <a href="{{ route('saved-itineraries') }}">My Itineraries</a>
                            <a href="{{ route('profile.edit') }}">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="btn-gold"
                        style="padding: 0.5rem 1.5rem; font-size:0.85rem;">Register</a>
                @endauth
            </nav>

            <!-- Mobile hamburger -->
            <button class="mobile-toggle" id="mobileToggle" aria-label="Menu">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </div>
    </header>

    <!-- Mobile overlay and menu -->
    <div class="mobile-overlay" id="mobileOverlay"></div>
    <div class="mobile-menu" id="mobileMenu">
        <div class="gold-divider"></div>
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
        <a href="{{ route('trips.index') }}" class="{{ request()->routeIs('trips.*') ? 'active' : '' }}">Trips</a>
        <a href="{{ route('destinations.index') }}"
            class="{{ request()->routeIs('destinations.*') ? 'active' : '' }}">Destinations</a>
        <a href="{{ route('activities.index') }}"
            class="{{ request()->routeIs('activities.*') ? 'active' : '' }}">Activities</a>
        <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>
        <a href="{{ route('directory.index') }}"
            class="{{ request()->routeIs('directory.*') ? 'active' : '' }}">Directory</a>
        <a href="{{ route('transport.index') }}"
            class="{{ request()->routeIs('transport.*') ? 'active' : '' }}">Transport</a>
        <a href="{{ route('planner') }}" class="{{ request()->routeIs('planner') ? 'active' : '' }}">Trip Planner</a>
        <a href="{{ route('explore-map') }}" class="{{ request()->routeIs('explore-map') ? 'active' : '' }}">Explore
            Map</a>

        <div class="user-section">
            @auth
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-email">{{ Auth::user()->email }}</div>
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.blogs.index') }}">Manage Blogs</a>
                    <a href="{{ route('admin.destinations.index') }}">Manage Destinations</a>
                    <a href="{{ route('admin.activities.index') }}">Manage Activities</a>
                    <a href="{{ route('admin.establishments.index') }}">Manage Directory</a>
                    <a href="{{ route('admin.transport.index') }}">Manage Transport</a>
                @endif
                <a href="{{ route('saved-itineraries') }}">My Itineraries</a>
                <a href="{{ route('profile.edit') }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}" style="margin-top:0.5rem;">
                    @csrf
                    <button type="submit" class="btn-outline"
                        style="width:100%; text-align:center; justify-content:center;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-outline"
                    style="margin-bottom:0.5rem; text-align:center; justify-content:center; display:flex;">Login</a>
                <a href="{{ route('register') }}" class="btn-gold"
                    style="text-align:center; justify-content:center; display:flex;">Register</a>
            @endauth
        </div>
    </div>

    {{-- Hero / Page header --}}
    @if (isset($header))
        <section class="page-hero">
            <div class="hero-inner">
                <h1>{{ $header }}</h1>
                <div class="gold-line"></div>
                <p>Your gateway to an unforgettable Tunisian experience</p>
            </div>
        </section>
    @endif

    {{-- Main content slot --}}
    <main class="content-area">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="tn-footer">
        <div>
            <h4>Travel To Tunisia</h4>
            <p>Curating authentic Tunisian travel experiences with expert local knowledge.</p>
        </div>
        <div>
            <h4>Explore</h4>
            <ul>
                <li><a href="{{ route('trips.index') }}">Trips</a></li>
                <li><a href="{{ route('destinations.index') }}">Destinations</a></li>
                <li><a href="{{ route('activities.index') }}">Activities</a></li>
            </ul>
        </div>
        <div>
            <h4>Information</h4>
            <ul>
                <li><a href="{{ route('blog.index') }}">Blog</a></li>
                <li><a href="{{ route('transport.index') }}">Transport</a></li>
                <li><a href="{{ route('directory.index') }}">Directory</a></li>
            </ul>
        </div>
        <div>
            <h4>Contact</h4>
            <ul>
                <li><i class="fas fa-map-marker-alt"></i> Tunisia</li>
                <li><i class="fas fa-phone-alt"></i> +216 XX XXX XXX</li>
                <li><i class="fas fa-envelope"></i> contact@traveltotunisia.com</li>
            </ul>
        </div>
    </footer>
    <div class="footer-bottom">
        © {{ date('Y') }} Travel To Tunisia. All rights reserved.
    </div>

    <script>
        // Mobile menu logic
        const toggle = document.getElementById('mobileToggle');
        const overlay = document.getElementById('mobileOverlay');
        const menu = document.getElementById('mobileMenu');

        toggle.addEventListener('click', () => {
            toggle.classList.toggle('open');
            overlay.classList.toggle('show');
            menu.classList.toggle('show');
            document.body.style.overflow = menu.classList.contains('show') ? 'hidden' : '';
        });

        overlay.addEventListener('click', () => {
            toggle.classList.remove('open');
            overlay.classList.remove('show');
            menu.classList.remove('show');
            document.body.style.overflow = '';
        });

        // Add shadow on scroll
        window.addEventListener('scroll', () => {
            document.getElementById('mainHeader').classList.toggle('scrolled', window.scrollY > 20);
        });
    </script>
</body>

</html>