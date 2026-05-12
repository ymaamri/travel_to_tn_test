<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Travel To Tunisia — Ultimate Travel Guide</title>

    <!-- Google Fonts & Font Awesome -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700;14..32,800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #fefcf8;
            color: #1e1e2a;
            line-height: 1.5;
        }

        /* Navigation (replaces the default Breeze navbar) */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .logo a {
            font-size: 1.8rem;
            font-weight: 800;
            text-decoration: none;
            background: linear-gradient(135deg, #e67e22, #d35400);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .nav-links a {
            text-decoration: none;
            font-weight: 500;
            color: #2c3e50;
            transition: 0.2s;
        }

        .nav-links a:hover {
            color: #e67e22;
        }

        .btn-outline {
            border: 1px solid #e67e22;
            padding: 0.5rem 1.2rem;
            border-radius: 40px;
            background: transparent;
            color: #e67e22;
            font-weight: 600;
        }

        .btn-outline:hover {
            background: #e67e22;
            color: white;
        }

        /* Hero Section */
        .hero {
            position: relative;
            min-height: 85vh;
            background: linear-gradient(rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.65)),
                url('https://images.unsplash.com/photo-1558877385-81c2d7fd8b3c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .hero-content {
            max-width: 800px;
            padding: 2rem;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .search-form {
            display: flex;
            gap: 0.5rem;
            max-width: 550px;
            margin: 0 auto 2rem auto;
            background: white;
            border-radius: 60px;
            padding: 0.5rem;
            flex-wrap: wrap;
        }

        .search-form input {
            flex: 1;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 60px;
            font-size: 1rem;
            outline: none;
        }

        .search-form button {
            background: #e67e22;
            border: none;
            padding: 0 2rem;
            border-radius: 60px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .search-form button:hover {
            background: #d35400;
        }

        .cta-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-group a {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(6px);
            padding: 0.7rem 1.5rem;
            border-radius: 40px;
            text-decoration: none;
            color: white;
            font-weight: 500;
            transition: 0.2s;
        }

        .cta-group a:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Section styling */
        .section {
            max-width: 1280px;
            margin: 0 auto;
            padding: 5rem 2rem;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .section-sub {
            text-align: center;
            color: #5a6e7c;
            max-width: 650px;
            margin: 0 auto 3rem auto;
        }

        /* Card grid */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.05);
            transition: transform 0.25s ease, box-shadow 0.25s;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.1);
        }

        .card-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .card-content {
            padding: 1.5rem;
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .card-location {
            color: #e67e22;
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 0.75rem;
        }

        .card-text {
            color: #4b5563;
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        .card-price {
            font-weight: 800;
            color: #2c3e50;
            margin-top: 0.5rem;
        }

        .btn-link {
            text-decoration: none;
            color: #e67e22;
            font-weight: 600;
        }

        /* Testimonial specific */
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .testimonial-card {
            background: #fff9f0;
            border-radius: 28px;
            padding: 2rem;
            border: 1px solid #ffe1b3;
        }

        .stars {
            color: #f5b042;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        /* Big CTA Banner */
        .cta-banner {
            background: linear-gradient(125deg, #1e2a3a, #0f172a);
            border-radius: 36px;
            padding: 3rem 2rem;
            text-align: center;
            color: white;
            margin-top: 2rem;
        }

        .cta-banner h2 {
            font-size: 2rem;
            font-weight: 800;
        }

        .btn-white {
            background: white;
            color: #0f172a;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            margin: 1rem 0.5rem 0;
        }

        .btn-white:hover {
            background: #f1f5f9;
        }

        /* Footer */
        .footer {
            background: #1e1e2a;
            color: #ccc;
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.2rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .navbar {
                flex-direction: column;
                text-align: center;
            }

            .nav-links {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <!-- Custom Navigation (replaces Breeze default) -->
    <nav class="navbar">
        <div class="logo">
            <a href="{{ route('home') }}">TravelToTunisia</a>
        </div>
        <div class="nav-links">
            <a href="{{ route('trips.index') }}">Trips</a>
            <a href="{{ route('blog.index') }}">Blog</a>
            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('profile.edit') }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit"
                        style="background:none; border:none; cursor:pointer; font-weight:500;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}" class="btn-outline">Register</a>
            @endauth
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-content">
            <h1>Discover Tunisia</h1>
            <p>Where the Mediterranean meets the Sahara – culture, beaches, and unforgettable adventures.</p>
            <form action="{{ route('trips.index') }}" method="GET" class="search-form">
                <input type="text" name="destination" placeholder="Where do you want to go? (Tunis, Sousse, Sahara...)">
                <button type="submit">Search →</button>
            </form>
            <div class="cta-group">
                <a href="#">Plan your trip</a>
                <a href="{{ route('trips.index') }}">Explore destinations</a>
                <a href="{{ route('directory.index') }}">Hotels & Restaurants</a>
                <a href="{{ route('blog.index') }}">Discover Tunisia</a>
            </div>
        </div>
    </section>

    <main>
        <!-- Featured Destinations -->
        <div class="section">
            <h2 class="section-title">Featured Destinations</h2>
            <p class="section-sub">Hand‑picked trips to start your Tunisian journey</p>
            @if($featuredTrips->count())
                <div class="card-grid">
                    @foreach($featuredTrips as $trip)
                        <div class="card">
                            @if($trip->image)
                                <img src="{{ asset('storage/' . $trip->image) }}" alt="{{ $trip->title }}" class="card-img">
                            @else
                                <div class="card-img"
                                    style="background:#ece8e0; display:flex; align-items:center; justify-content:center;">📸</div>
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
                <p style="text-align:center; color:gray;">No featured trips yet. Check back soon!</p>
            @endif
        </div>

        <!-- Popular Experiences -->
        <div class="section" style="background: #faf7f2; border-radius: 48px;">
            <h2 class="section-title">Popular Experiences</h2>
            <p class="section-sub">What travelers love the most</p>
            @if($popularExperiences->count())
                <div class="card-grid">
                    @foreach($popularExperiences as $exp)
                        <div class="card">
                            @if($exp->image) <img src="{{ asset('storage/' . $exp->image) }}" class="card-img"> @else <div
                            class="card-img" style="background:#ddd;"></div> @endif
                            <div class="card-content">
                                <h3 class="card-title">{{ $exp->title }}</h3>
                                <p class="card-text">{{ $exp->destination }}</p>
                                <div class="card-price">{{ number_format($exp->price, 2) }} TND</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else <p style="text-align:center;">No experiences yet.</p> @endif
        </div>

        <!-- Best Beaches -->
        <div class="section">
            <h2 class="section-title">Best Beaches</h2>
            <p class="section-sub">Sun, sand, and crystal‑clear water</p>
            @if($beaches->count())
                <div class="card-grid">
                    @foreach($beaches as $beach)
                        <div class="card">
                            @if($beach->image) <img src="{{ asset('storage/' . $beach->image) }}" class="card-img"> @else <div
                            class="card-img" style="background:#cbd5e1;"></div> @endif
                            <div class="card-content">
                                <h3 class="card-title">{{ $beach->title }}</h3>
                                <div class="card-location">{{ $beach->destination }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else <p style="text-align:center;">Beach trips coming soon.</p> @endif
        </div>

        <!-- Sahara Tours -->
        <div class="section" style="background: #fef5e7; border-radius: 48px;">
            <h2 class="section-title">Sahara Tours</h2>
            <p class="section-sub">Experience the magic of the desert</p>
            @if($saharaTours->count())
                <div class="card-grid">
                    @foreach($saharaTours as $tour)
                        <div class="card">
                            @if($tour->image) <img src="{{ asset('storage/' . $tour->image) }}" class="card-img"> @endif
                            <div class="card-content">
                                <h3 class="card-title">{{ $tour->title }}</h3>
                                <p class="card-text">{{ $tour->destination }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else <p style="text-align:center;">Sahara tours will appear soon.</p> @endif
        </div>

        <!-- Food Experiences -->
        <div class="section">
            <h2 class="section-title">Food Experiences</h2>
            <p class="section-sub">Taste the flavors of Tunisia</p>
            @if($foodExperiences->count())
                <div class="card-grid">
                    @foreach($foodExperiences as $food)
                        <div class="card">
                            @if($food->image) <img src="{{ asset('storage/' . $food->image) }}" class="card-img"> @endif
                            <div class="card-content">
                                <h3 class="card-title">{{ $food->title }}</h3>
                                <p class="card-text">{{ $food->destination }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else <p style="text-align:center;">Food tours coming soon.</p> @endif
        </div>

        <!-- Travel Tips (Blog) -->
        <div class="section" style="background: #f1f5f9; border-radius: 48px;">
            <h2 class="section-title">Travel Tips</h2>
            <p class="section-sub">Advice from local experts and travelers</p>
            @if($travelTips->count())
                <div class="card-grid">
                    @foreach($travelTips as $tip)
                        <div class="card">
                            @if($tip->featured_image) <img src="{{ asset('storage/' . $tip->featured_image) }}"
                            class="card-img"> @endif
                            <div class="card-content">
                                <div style="font-size:0.8rem; color:#e67e22;">{{ $tip->published_at->format('M d, Y') }}</div>
                                <h3 class="card-title" style="font-size:1.2rem;">{{ $tip->title }}</h3>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($tip->excerpt ?? $tip->content, 100) }}
                                </p>
                                <a href="{{ route('blog.show', $tip->slug) }}" class="btn-link">Read more →</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else <p style="text-align:center;">No travel tips yet.</p> @endif
        </div>

        <!-- Hotels & Restaurants Directory Section -->
        <div class="section" style="background: #fefcf8; border-radius: 48px;">
            <h2 class="section-title">Where to Stay & Eat</h2>
            <p class="section-sub">Curated hotels, traditional restaurants, and cozy cafés across Tunisia</p>
            <div style="text-align: center; margin-top: 2rem;">
                <a href="{{ route('directory.index') }}" class="btn-white"
                    style="background: #e67e22; color: white; display: inline-block; padding: 0.8rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 700;">Browse
                    Directory →</a>
            </div>
        </div>

        <!-- Testimonials -->
        <div class="section">
            <h2 class="section-title">What Travelers Say</h2>
            <p class="section-sub">Real stories from our community</p>
            <div class="testimonial-grid">
                @foreach($testimonials as $t)
                    <div class="testimonial-card">
                        <div class="stars">{!! str_repeat('★', $t['rating']) !!}</div>
                        <p style="font-style:italic; margin-bottom:1rem;">“{{ $t['text'] }}”</p>
                        <div><strong>{{ $t['name'] }}</strong></div>
                        <div style="font-size:0.85rem; color:#7f8c8d;">{{ $t['country'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- CTA Banner -->
        <div class="section">
            <div class="cta-banner">
                <h2>Ready for an unforgettable journey?</h2>
                <p style="margin-bottom:1rem;">Let us help you plan the perfect trip to Tunisia.</p>
                <a href="#" class="btn-white">Plan your trip</a>
                <a href="{{ route('trips.index') }}" class="btn-white" style="background:#e67e22; color:white;">View all
                    trips</a>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>© {{ date('Y') }} Travel To Tunisia — Your ultimate guide to Tunisia.</p>
        <p style="font-size:0.85rem; margin-top:0.5rem;">Follow us:
            <a style="color:#ccc; margin:0 5px;" href="#"><i class="fab fa-instagram"></i></a>
            <a style="color:#ccc;" href="#"><i class="fab fa-facebook"></i></a>
        </p>
    </footer>

</body>

</html>