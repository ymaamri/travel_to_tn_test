<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Travel To Tunisia') }} - {{ __('Welcome') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700&family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.jsx'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            --shadow-md: 0 8px 20px rgba(0, 0, 0, 0.06), 0 2px 6px rgba(0, 0, 0, 0.03);
            --shadow-lg: 0 16px 32px rgba(0, 0, 0, 0.08), 0 4px 12px rgba(0, 0, 0, 0.04);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --radius-xl: 32px;
            --transition: 0.25s cubic-bezier(0.33, 1, 0.68, 1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1D3557 0%, #0D2636 50%, #1D3557 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle background pattern */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M20 20 L40 20 L40 40 L20 40 Z' fill='%23d4af37' fill-opacity='0.04'/%3E%3Cpath d='M0 0 L20 0 L20 20 L0 20 Z' fill='%23d4af37' fill-opacity='0.02'/%3E%3Cpath d='M60 60 L80 60 L80 80 L60 80 Z' fill='%23d4af37' fill-opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        .auth-container {
            width: 100%;
            max-width: 460px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* Brand */
        .auth-brand {
            text-align: center;
            margin-bottom: 2.5rem;
            color: white;
        }

        .auth-brand .logo-icon {
            width: 60px;
            height: 60px;
            background: var(--tunisia-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--tunisia-red-dark);
            margin: 0 auto 1rem;
            box-shadow: 0 8px 24px rgba(212, 175, 55, 0.3);
        }

        .auth-brand a {
            font-family: 'Cinzel', serif;
            font-size: 2rem;
            font-weight: 700;
            text-decoration: none;
            color: white;
            letter-spacing: 0.5px;
            display: block;
        }

        .auth-brand a span {
            color: var(--tunisia-gold);
        }

        .auth-brand p {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 0.5rem;
        }

        /* Card */
        .auth-card {
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            padding: 2.5rem 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .auth-card h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--med-blue);
        }

        .auth-card .subtitle {
            color: var(--text-muted);
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        /* Form elements */
        .form-group {
            margin-bottom: 1.3rem;
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 0.4rem;
            color: var(--text-primary);
        }

        input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid var(--border-light);
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 0.9rem;
            transition: var(--transition);
            outline: none;
            background: var(--sand-light);
        }

        input:focus {
            border-color: var(--tunisia-gold);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
            background: white;
        }

        .btn-auth {
            width: 100%;
            background: var(--tunisia-gold);
            color: var(--charcoal);
            border: none;
            padding: 0.85rem;
            border-radius: 40px;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all var(--transition);
            margin-top: 0.5rem;
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.25);
            letter-spacing: 0.3px;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(212, 175, 55, 0.4);
        }

        .auth-links {
            text-align: center;
            margin-top: 1.8rem;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .auth-links a {
            color: var(--tunisia-red);
            text-decoration: none;
            font-weight: 600;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: var(--tunisia-red);
            font-size: 0.75rem;
            margin-top: 0.3rem;
        }

        .alert-box {
            padding: 0.8rem 1rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.85rem;
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

        hr {
            margin: 1.5rem 0;
            border: none;
            border-top: 1px solid var(--border-lighter);
        }

        .back-home {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
            transition: color var(--transition);
        }

        .back-home:hover {
            color: var(--tunisia-gold);
        }

        @media (max-width: 560px) {
            .auth-card {
                padding: 2rem 1.5rem;
            }

            body {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-brand">
            <div class="logo-icon">🇹🇳</div>
            <a href="{{ route('home') }}">Travel<span>ToTunisia</span></a>
            <p>Your gateway to North African wonders</p>
        </div>

        <div class="auth-card">
            {{ $slot }}
        </div>

        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="{{ route('home') }}" class="back-home">
                <i class="fas fa-arrow-left"></i> Back to home
            </a>
        </div>
    </div>
</body>

</html>