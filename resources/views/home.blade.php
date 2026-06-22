<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Travel To Tunisia — Official Travel Guide</title>

    {{-- Premium Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

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
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.02), 0 1px 2px rgba(0,0,0,0.03);
            --shadow-md: 0 8px 20px rgba(0,0,0,0.06), 0 2px 6px rgba(0,0,0,0.03);
            --shadow-lg: 0 16px 32px rgba(0,0,0,0.08), 0 4px 12px rgba(0,0,0,0.04);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --radius-xl: 32px;
            --transition: 0.25s cubic-bezier(0.33, 1, 0.68, 1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--cream);
            color: var(--text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
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
        .top-bar .left, .top-bar .right {
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
        .top-bar a:hover { opacity: 1; }
        .top-bar i { margin-right: 0.4rem; }

        /* ========== MAIN HEADER (Sticky) ========== */
        .tunisia-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(200,200,180,0.3);
            transition: background var(--transition), box-shadow var(--transition);
        }
        .tunisia-header.scrolled {
            background: rgba(255,255,255,0.95);
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
            width: 44px; height: 44px;
            background: var(--tunisia-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--tunisia-red-dark);
            box-shadow: 0 4px 12px rgba(212,175,55,0.3);
        }
        .logo-text {
            font-family: 'Cinzel', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--tunisia-red);
            letter-spacing: 0.5px;
            line-height: 1;
        }
        .logo-text span { color: var(--med-blue); }

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
        .nav-link:hover { color: var(--tunisia-red); background: rgba(193,18,31,0.04); }
        .nav-link.active {
            color: var(--tunisia-red);
            background: rgba(193,18,31,0.08);
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
        .nav-link:hover::after { width: 50%; left: 25%; }

        .btn-outline {
            border: 1px solid var(--tunisia-red);
            padding: 0.5rem 1.5rem;
            border-radius: 40px;
            background: transparent;
            color: var(--tunisia-red);
            font-weight: 600;
            text-decoration: none;
            transition: all var(--transition);
        }
        .btn-outline:hover { background: var(--tunisia-red); color: white; }
        .btn-gold-sm {
            background: var(--tunisia-gold);
            color: var(--charcoal);
            padding: 0.5rem 1.5rem;
            border-radius: 40px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all var(--transition);
            box-shadow: 0 4px 12px rgba(212,175,55,0.25);
        }
        .btn-gold-sm:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(212,175,55,0.4); }

        /* ---------- MOBILE HAMBURGER ---------- */
        .mobile-toggle {
            display: none;
            background: none; border: none;
            font-size: 1.8rem; color: var(--text-primary); cursor: pointer;
            z-index: 200; position: relative;
        }
        .hamburger-line {
            display: block; width: 28px; height: 2.5px;
            background: var(--text-primary); margin: 6px 0;
            transition: all 0.3s;
            border-radius: 2px;
        }
        .mobile-toggle.open .hamburger-line:nth-child(1) { transform: rotate(45deg) translate(5px, 6px); }
        .mobile-toggle.open .hamburger-line:nth-child(2) { opacity: 0; }
        .mobile-toggle.open .hamburger-line:nth-child(3) { transform: rotate(-45deg) translate(5px, -6px); }

        /* Full‑screen overlay for mobile */
        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            opacity: 0; visibility: hidden;
            transition: opacity 0.4s, visibility 0.4s;
            z-index: 150;
        }
        .mobile-overlay.show { opacity: 1; visibility: visible; }

        .mobile-menu {
            position: fixed;
            top: 0; right: 0;
            width: 320px; max-width: 85vw;
            height: 100vh;
            background: white;
            padding: 2rem 1.5rem;
            box-shadow: var(--shadow-xl);
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.33, 1, 0.68, 1);
            z-index: 160;
            display: flex; flex-direction: column;
            border-left: 1px solid var(--border-lighter);
        }
        .mobile-menu.show { transform: translateX(0); }

        .mobile-menu a, .mobile-menu button {
            display: block; width: 100%; text-align: left;
            padding: 0.8rem 1rem; border-radius: var(--radius-sm);
            font-weight: 500; color: var(--text-secondary); text-decoration: none;
            font-size: 1rem; transition: background var(--transition), color var(--transition);
            border: none; background: none; cursor: pointer; font-family: inherit;
        }
        .mobile-menu a:hover, .mobile-menu button:hover { background: var(--sand-light); color: var(--tunisia-red); }

        .mobile-menu .gold-divider {
            width: 50px; height: 4px;
            background: var(--tunisia-gold); margin: 0.8rem 0 1.2rem;
            border-radius: 2px;
        }

        .mobile-menu .user-section {
            margin-top: auto;
            border-top: 1px solid var(--border-lighter);
            padding-top: 1.5rem;
        }

        @media (max-width: 960px) {
            .desktop-nav { display: none; }
            .mobile-toggle { display: block; }
        }

        /* ========== HERO WITH VIDEO BACKGROUND ========== */
        .hero {
            position: relative;
            min-height: 90vh;
            display: flex;
            align-items: center;
            text-align: center;
            color: white;
            overflow: hidden; /* Ensures video doesn't bleed out */
        }

        .hero-video {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        /* Dark overlay on top of video */
        .hero-overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(0,0,0,0.45), rgba(0,0,0,0.3));
            z-index: 1;
        }

        /* Bottom gradient to blend into cream background */
        .hero::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 40%;
            background: linear-gradient(to top, var(--cream), transparent);
            z-index: 2;
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.1;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2.5rem;
        }
        .search-form {
            display: flex;
            max-width: 550px;
            margin: 0 auto 2rem;
            background: white;
            border-radius: 60px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }
        .search-form input {
            flex: 1;
            padding: 1rem 1.5rem;
            border: none;
            outline: none;
            font-size: 1rem;
            color: var(--text-primary);
        }
        .search-form button {
            background: var(--tunisia-gold);
            border: none;
            padding: 0 2rem;
            color: var(--charcoal);
            font-weight: 700;
            cursor: pointer;
            transition: background var(--transition);
        }
        .search-form button:hover { background: #E5B73B; }
        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-white {
            background: white;
            color: var(--tunisia-red);
            padding: 0.75rem 2rem;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            transition: all var(--transition);
        }
        .btn-white:hover { background: var(--sand-light); transform: translateY(-2px); }
        .btn-outline-light {
            border: 1px solid white;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            transition: all var(--transition);
        }
        .btn-outline-light:hover { background: white; color: var(--tunisia-red); }

        /* ========== SECTIONS ========== */
        .section {
            padding: 5rem 0;
        }
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 3rem;
        }
        .section-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            margin-bottom: 0.75rem;
            color: var(--med-blue);
        }
        .section-header p {
            color: var(--text-muted);
            font-size: 1rem;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2.5rem;
        }
        .card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-lighter);
            transition: all var(--transition);
        }
        .card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
        }
        .card-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            background: var(--sand);
        }
        .card-content {
            padding: 1.5rem;
        }
        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--med-blue);
        }
        .card-location {
            color: var(--tunisia-red);
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 0.75rem;
        }
        .card-text {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.4;
        }
        .card-price {
            font-weight: 700;
            color: var(--med-blue);
            margin-bottom: 0.75rem;
        }
        .btn-link {
            text-decoration: none;
            font-weight: 600;
            color: var(--tunisia-red);
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            transition: gap 0.2s;
        }
        .btn-link:hover { gap: 0.6rem; color: var(--tunisia-red-dark); }

        .two-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2.5rem;
            align-items: center;
        }
        .feature-card {
            background: var(--sand-light);
            border-radius: var(--radius-lg);
            padding: 2rem;
            border: 1px solid var(--border-lighter);
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }
        .testimonial {
            background: var(--white);
            border-radius: var(--radius-md);
            padding: 1.5rem;
            border-left: 4px solid var(--tunisia-gold);
            box-shadow: var(--shadow-sm);
        }
        .stars { color: #F5B042; margin-bottom: 0.75rem; }

        .cta-banner {
            background: var(--med-blue);
            border-radius: var(--radius-lg);
            padding: 3.5rem 2rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .cta-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(212,175,55,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        .cta-banner h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }
        .btn-red {
            background: var(--tunisia-red);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            margin: 0.5rem;
            transition: all var(--transition);
            box-shadow: 0 4px 12px rgba(193,18,31,0.2);
        }
        .btn-red:hover { background: var(--tunisia-red-dark); transform: translateY(-2px); }

        .footer {
            background: var(--charcoal);
            color: rgba(255,255,255,0.7);
            padding: 3rem 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 2rem;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        .footer h4 {
            color: var(--tunisia-gold);
            margin-bottom: 1rem;
            font-family: 'Cinzel', serif;
        }
        .footer ul { list-style: none; }
        .footer ul li { margin-bottom: 0.5rem; }
        .footer a { color: inherit; text-decoration: none; transition: color var(--transition); }
        .footer a:hover { color: var(--tunisia-gold); }
        .footer-bottom {
            text-align: center;
            padding: 1.5rem;
            background: #111;
            color: rgba(255,255,255,0.5);
            font-size: 0.8rem;
        }

        @media (max-width: 768px) {
            .top-bar { padding: 0.4rem 1rem; flex-direction: column; text-align: center; }
            .header-inner { padding: 0.8rem 1rem; }
            .container { padding: 0 1.5rem; }
            .hero h1 { font-size: 2.5rem; }
            .section { padding: 3rem 0; }
            .two-col { grid-template-columns: 1fr; }
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

            <!-- Desktop Navigation -->
            <nav class="desktop-nav" id="desktopNav">
                <a href="{{ route('home') }}" class="nav-link active">Home</a>
                <a href="{{ route('trips.index') }}" class="nav-link">Trips</a>
                <a href="{{ route('destinations.index') }}" class="nav-link">Destinations</a>
                <a href="{{ route('activities.index') }}" class="nav-link">Activities</a>
                <a href="{{ route('blog.index') }}" class="nav-link">Blog</a>
                <a href="{{ route('transport.index') }}" class="nav-link">Transport</a>
                <a href="{{ route('directory.index') }}" class="nav-link">Directory</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button type="submit" class="nav-link" style="background:none; border:none; font-family:inherit; cursor:pointer; color: var(--text-secondary);">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('register') }}" class="btn-gold-sm">Register</a>
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
        <a href="{{ route('home') }}" class="active">Home</a>
        <a href="{{ route('trips.index') }}">Trips</a>
        <a href="{{ route('destinations.index') }}">Destinations</a>
        <a href="{{ route('activities.index') }}">Activities</a>
        <a href="{{ route('blog.index') }}">Blog</a>
        <a href="{{ route('transport.index') }}">Transport</a>
        <a href="{{ route('directory.index') }}">Directory</a>

        <div class="user-section">
            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="margin-top:0.5rem;">
                    @csrf
                    <button type="submit" class="btn-outline" style="width:100%; text-align:center; justify-content:center;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-outline" style="margin-bottom:0.5rem; text-align:center; justify-content:center; display:flex;">Login</a>
                <a href="{{ route('register') }}" class="btn-gold-sm" style="text-align:center; justify-content:center; display:flex;">Register</a>
            @endauth
        </div>
    </div>

    <!-- Hero with Video Background -->
    <section class="hero">
        <!-- Video: replace the src with your own video URL or local file -->
            <img class="hero-video" src="https://c1.wallpaperflare.com/preview/835/994/337/tunisia-komachi-seaside-sea.jpg" alt="Seaside">        <!-- Dark overlay to keep text readable -->
        <div class="hero-overlay"></div>

        <div class="container">
            <div class="hero-content">
                <h1>Discover Tunisia</h1>
                <p>From Mediterranean beaches to Sahara dunes — your journey starts here.</p>
                <form action="{{ route('trips.index') }}" method="GET" class="search-form">
                    <input type="text" name="destination" placeholder="Search destination (Tunis, Sousse, Djerba...)">
                    <button type="submit">Search</button>
                </form>
                <div class="cta-buttons">
                    <a href="{{ route('trips.index') }}" class="btn-white">Explore Trips</a>
                    <a href="{{ route('directory.index') }}" class="btn-outline-light">Hotels & Restaurants</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Rest of the page remains exactly the same as before -->
    <main>
        <!-- Featured Trips -->
        <div class="section">
            <div class="container">
                <div class="section-header">
                    <h2>Featured Destinations</h2>
                    <p>Hand-picked experiences for an unforgettable journey</p>
                </div>
                @if($featuredTrips->count())
                    <div class="card-grid">
                        @foreach($featuredTrips as $trip)
                            <div class="card">
                                @if($trip->image)
                                    <img src="{{ asset('storage/' . $trip->image) }}" alt="{{ $trip->title }}" class="card-img">
                                @else
                                    <div class="card-img" style="background:var(--sand); display:flex; align-items:center; justify-content:center; font-size:2.5rem; color:var(--text-muted);">📸</div>
                                @endif
                                <div class="card-content">
                                    <h3 class="card-title">{{ $trip->title }}</h3>
                                    <div class="card-location"><i class="fas fa-map-marker-alt"></i> {{ $trip->destination }}</div>
                                    <p class="card-text">{{ \Illuminate\Support\Str::limit($trip->description, 90) }}</p>
                                    <div class="card-price">{{ number_format($trip->price, 2) }} TND</div>
                                    <a href="{{ route('trips.show', $trip) }}" class="btn-link">View details →</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="text-align:center; color:var(--text-muted);">No featured trips yet. Check back soon!</p>
                @endif
            </div>
        </div>

        <!-- Popular Experiences + Beaches -->
        <div class="section" style="background: var(--sand-light);">
            <div class="container">
                <div class="two-col">
                    <div class="feature-card">
                        <h3 style="font-family:'Playfair Display', serif; font-size:1.8rem; margin-bottom:1rem; color:var(--med-blue);">✨ Popular Experiences</h3>
                        @if($popularExperiences->count())
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                @foreach($popularExperiences->take(3) as $exp)
                                    <div>
                                        <strong>{{ $exp->title }}</strong>
                                        <div style="font-size:0.85rem; color:var(--text-muted);">{{ $exp->destination }}</div>
                                        <div class="card-price" style="font-size:0.9rem;">{{ number_format($exp->price, 2) }} TND</div>
                                    </div>
                                @endforeach
                                <a href="{{ route('trips.index') }}" class="btn-link" style="margin-top:0.5rem;">Browse all →</a>
                            </div>
                        @else <p>No experiences yet.</p> @endif
                    </div>
                    <div class="feature-card">
                        <h3 style="font-family:'Playfair Display', serif; font-size:1.8rem; margin-bottom:1rem; color:var(--med-blue);">🏖️ Best Beaches</h3>
                        @if($beaches->count())
                            <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                                @foreach($beaches->take(4) as $beach)
                                    <div><i class="fas fa-water" style="color:var(--med-blue); margin-right:0.5rem;"></i> <strong>{{ $beach->title }}</strong> – {{ $beach->destination }}</div>
                                @endforeach
                            </div>
                        @else <p>Beach guides coming soon.</p> @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sahara Tours & Food Experiences -->
        <div class="section">
            <div class="container">
                <div class="two-col">
                    <div>
                        <div class="section-header" style="text-align:left; margin-bottom:1.5rem;">
                            <h2>🏜️ Sahara Tours</h2>
                            <p>Experience the magic of the desert</p>
                        </div>
                        @if($saharaTours->count())
                            <div class="card-grid" style="grid-template-columns: 1fr 1fr;">
                                @foreach($saharaTours->take(2) as $tour)
                                    <div class="card">
                                        @if($tour->image)<img src="{{ asset('storage/' . $tour->image) }}" class="card-img" style="height:160px;">@else<div class="card-img" style="height:160px; background:var(--sand);"></div>@endif
                                        <div class="card-content">
                                            <h3 class="card-title" style="font-size:1.1rem;">{{ $tour->title }}</h3>
                                            <div class="card-location">{{ $tour->destination }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a href="{{ route('trips.index') }}" class="btn-link">View all Sahara trips →</a>
                        @else <p>No Sahara tours yet.</p> @endif
                    </div>
                    <div>
                        <div class="section-header" style="text-align:left; margin-bottom:1.5rem;">
                            <h2>🍽️ Food Experiences</h2>
                            <p>Taste authentic Tunisian cuisine</p>
                        </div>
                        @if($foodExperiences->count())
                            <div class="card-grid" style="grid-template-columns: 1fr 1fr;">
                                @foreach($foodExperiences->take(2) as $food)
                                    <div class="card">
                                        @if($food->image)<img src="{{ asset('storage/' . $food->image) }}" class="card-img" style="height:160px;">@else<div class="card-img" style="height:160px; background:var(--sand);"></div>@endif
                                        <div class="card-content">
                                            <h3 class="card-title" style="font-size:1.1rem;">{{ $food->title }}</h3>
                                            <div class="card-location">{{ $food->destination }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a href="{{ route('trips.index') }}" class="btn-link">Discover food tours →</a>
                        @else <p>Food experiences coming soon.</p> @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Travel Tips (Blog) -->
        <div class="section" style="background: var(--sand-light);">
            <div class="container">
                <div class="section-header">
                    <h2>Travel Tips & Stories</h2>
                    <p>Insider advice from local experts</p>
                </div>
                @if($travelTips->count())
                    <div class="card-grid">
                        @foreach($travelTips->take(3) as $tip)
                            <div class="card">
                                @if($tip->featured_image)<img src="{{ asset('storage/' . $tip->featured_image) }}" class="card-img" alt="{{ $tip->title }}">@else<div class="card-img" style="background:var(--sand); display:flex; align-items:center; justify-content:center; color:var(--text-muted);">📰</div>@endif
                                <div class="card-content">
                                    <div style="font-size:0.75rem; color:var(--tunisia-gold); margin-bottom:0.5rem;">
                                        {{ $tip->published_at->format('M d, Y') }}
                                    </div>
                                    <h3 class="card-title" style="font-size:1.2rem;">{{ $tip->title }}</h3>
                                    <p class="card-text">{{ \Illuminate\Support\Str::limit($tip->excerpt ?? $tip->content, 100) }}</p>
                                    <a href="{{ route('blog.show', $tip->slug) }}" class="btn-link">Read more →</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div style="text-align:center; margin-top:2rem;">
                        <a href="{{ route('blog.index') }}" class="btn-outline">View all articles</a>
                    </div>
                @else <p style="text-align:center; color:var(--text-muted);">Travel tips coming soon.</p> @endif
            </div>
        </div>

        <!-- Directory & Transport Callout -->
        <div class="section">
            <div class="container">
                <div class="two-col" style="gap: 2rem;">
                    <div class="feature-card" style="text-align:center;">
                        <i class="fas fa-hotel fa-2x" style="color:var(--tunisia-gold); margin-bottom:1rem;"></i>
                        <h3>Where to Stay & Eat</h3>
                        <p style="margin-bottom:1.5rem;">Curated hotels, restaurants, and cafés across Tunisia.</p>
                        <a href="{{ route('directory.index') }}" class="btn-link">Browse Directory →</a>
                    </div>
                    <div class="feature-card" style="text-align:center;">
                        <i class="fas fa-bus fa-2x" style="color:var(--tunisia-gold); margin-bottom:1rem;"></i>
                        <h3>Getting Around</h3>
                        <p style="margin-bottom:1.5rem;">Complete transport guides: trains, louage, car rental, ferries.</p>
                        <a href="{{ route('transport.index') }}" class="btn-link">View Transportation →</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonials -->
        <div class="section">
            <div class="container">
                <div class="section-header">
                    <h2>What Travelers Say</h2>
                    <p>Real experiences from our community</p>
                </div>
                <div class="testimonial-grid">
                    @foreach($testimonials as $t)
                        <div class="testimonial">
                            <div class="stars">{!! str_repeat('★', $t['rating']) !!}</div>
                            <p style="font-style:italic; margin-bottom:0.75rem;">“{{ $t['text'] }}”</p>
                            <div><strong>{{ $t['name'] }}</strong></div>
                            <div style="font-size:0.8rem; color:var(--text-muted);">{{ $t['country'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Final CTA -->
        <div class="section">
            <div class="container">
                <div class="cta-banner">
                    <h2>Ready for an unforgettable journey?</h2>
                    <p style="position:relative; z-index:1;">Let us help you plan the perfect trip to Tunisia.</p>
                    <a href="{{ route('trips.index') }}" class="btn-red" style="position:relative; z-index:1;">View all trips</a>
                    <a href="#" class="btn-outline-light" style="border-color:white; color:white; position:relative; z-index:1;">Plan your trip</a>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div>
            <h4>Travel To Tunisia</h4>
            <p>Your gateway to authentic Tunisian experiences.</p>
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
        <p>© {{ date('Y') }} Travel To Tunisia — Your ultimate guide to Tunisia.</p>
        <p style="margin-top:0.5rem;">
            <a style="color:rgba(255,255,255,0.7); margin:0 8px;" href="#"><i class="fab fa-instagram"></i></a>
            <a style="color:rgba(255,255,255,0.7);" href="#"><i class="fab fa-facebook"></i></a>
        </p>
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