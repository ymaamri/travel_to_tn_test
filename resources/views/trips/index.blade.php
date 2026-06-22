<x-app-layout>
    <x-slot name="header">
        Available Trips — Discover Tunisia
    </x-slot>

    <!-- Search hero -->
    <div class="search-hero">
        <div class="search-inner">
            <h2 class="search-title">Find your perfect Tunisian trip</h2>
            <p class="search-sub">From ancient medinas to Saharan dunes, we curate unforgettable journeys.</p>
            <form method="GET" action="{{ route('trips.index') }}" class="search-form-large">
                <div class="search-input-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" name="destination"
                        placeholder="Search by destination (e.g., Tunis, Sousse, Sahara)"
                        value="{{ request('destination') }}">
                </div>
                <button type="submit" class="btn-gold">Search</button>
                @if(request('destination'))
                    <a href="{{ route('trips.index') }}" class="btn-outline">Clear</a>
                @endif
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-box alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($trips->count())
        <div class="trips-grid">
            @foreach($trips as $trip)
                @php
                    $avgRating = $trip->reviews->avg('rating') ?? 0;
                    $reviewCount = $trip->reviews->count();
                @endphp
                <a href="{{ route('trips.show', $trip) }}" class="trip-card-link">
                    <article class="trip-card">
                        <div class="trip-card-image">
                            @if($trip->image)
                                <img src="{{ asset('storage/' . $trip->image) }}" alt="{{ $trip->title }}" loading="lazy">
                            @else
                                <div class="no-image"><i class="fas fa-mountain-sun"></i></div>
                            @endif
                            <div class="trip-card-badge">{{ $trip->destination }}</div>
                        </div>
                        <div class="trip-card-body">
                            <div class="trip-card-header">
                                <h3 class="trip-title">{{ $trip->title }}</h3>
                                <div class="trip-price">
                                    {{ number_format($trip->price, 2) }} <span>TND</span>
                                </div>
                            </div>
                            <div class="trip-rating-row">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= round($avgRating) ? '' : '-o' }}"></i>
                                    @endfor
                                </div>
                                <span class="review-count">({{ $reviewCount }})</span>
                            </div>
                            <p class="trip-desc">{{ Str::limit($trip->description, 100) }}</p>
                            <div class="trip-meta">
                                <span><i class="far fa-calendar-alt"></i> {{ $trip->date->format('d M Y') }}</span>
                                <span><i class="far fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($trip->departure_time)->format('H:i') }} –
                                    {{ \Carbon\Carbon::parse($trip->return_time)->format('H:i') }}</span>
                                <span><i class="fas fa-chair"></i> {{ $trip->available_seats }} seats</span>
                            </div>
                            <div class="trip-footer">
                                <span class="trip-guide"><i class="far fa-user-circle"></i>
                                    {{ $trip->user->name ?? 'Agency' }}</span>
                                <span class="view-link">View details <i class="fas fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </article>
                </a>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $trips->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-map-marked-alt"></i>
            <h3>No trips found</h3>
            <p>We couldn't find any trips matching “{{ request('destination') }}”.</p>
            <a href="{{ route('trips.index') }}" class="btn-gold">View all trips</a>
        </div>
    @endif
</x-app-layout>

<style>
    /* ---- Search Hero ---- */
    .search-hero {
        background: linear-gradient(135deg, var(--med-blue) 0%, #1A3A4B 100%);
        border-radius: var(--radius-xl);
        padding: 3rem 2rem;
        margin-bottom: 3rem;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .search-hero::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.15) 0%, transparent 70%);
        border-radius: 50%;
    }

    .search-inner {
        position: relative;
        z-index: 1;
    }

    .search-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .search-sub {
        opacity: 0.9;
        margin-bottom: 2rem;
    }

    .search-form-large {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.8rem;
        max-width: 600px;
        margin: 0 auto;
    }

    .search-input-wrap {
        flex: 1;
        min-width: 250px;
        display: flex;
        align-items: center;
        background: white;
        border-radius: 50px;
        padding: 0 1.2rem;
        gap: 0.6rem;
        box-shadow: var(--shadow-sm);
    }

    .search-input-wrap i {
        color: var(--text-muted);
    }

    .search-input-wrap input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 0.9rem 0;
        font-size: 0.95rem;
        outline: none;
        color: var(--text-primary);
    }

    .search-form-large .btn-gold,
    .search-form-large .btn-outline {
        padding: 0.9rem 1.8rem;
        font-size: 0.95rem;
        border-radius: 50px;
    }

    .search-form-large .btn-outline {
        color: white;
        border-color: rgba(255, 255, 255, 0.6);
        background: transparent;
    }

    .search-form-large .btn-outline:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: white;
    }

    /* ---- Trips Grid ---- */
    .trips-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
        gap: 2rem;
    }

    .trip-card-link {
        text-decoration: none;
        color: inherit;
    }

    .trip-card {
        background: white;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-lighter);
        overflow: hidden;
        transition: all var(--transition);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .trip-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
    }

    .trip-card-image {
        position: relative;
        height: 200px;
        overflow: hidden;
        background: var(--sand);
    }

    .trip-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .trip-card:hover .trip-card-image img {
        transform: scale(1.04);
    }

    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--sand-light);
        color: var(--text-muted);
        font-size: 2.5rem;
    }

    .trip-card-badge {
        position: absolute;
        bottom: 1rem;
        left: 1rem;
        background: rgba(193, 18, 31, 0.9);
        color: white;
        padding: 0.3rem 1rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        backdrop-filter: blur(4px);
    }

    .trip-card-body {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .trip-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 0.8rem;
        margin-bottom: 0.5rem;
    }

    .trip-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--med-blue);
        line-height: 1.3;
    }

    .trip-price {
        font-weight: 800;
        font-size: 1.3rem;
        color: var(--tunisia-red);
        white-space: nowrap;
    }

    .trip-price span {
        font-size: 0.7rem;
        font-weight: 500;
    }

    .trip-rating-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.8rem;
    }

    .trip-rating-row .stars {
        color: var(--tunisia-gold);
        font-size: 0.8rem;
    }

    .review-count {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .trip-desc {
        font-size: 0.85rem;
        color: var(--text-secondary);
        line-height: 1.5;
        margin-bottom: 1rem;
        flex: 1;
    }

    .trip-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-bottom: 1rem;
    }

    .trip-meta i {
        margin-right: 0.3rem;
        color: var(--tunisia-gold);
    }

    .trip-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid var(--border-lighter);
        padding-top: 1rem;
        margin-top: auto;
    }

    .trip-guide {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .view-link {
        font-weight: 600;
        font-size: 0.8rem;
        color: var(--tunisia-red);
        display: flex;
        align-items: center;
        gap: 0.3rem;
        transition: gap var(--transition);
    }

    .trip-card:hover .view-link {
        gap: 0.6rem;
    }

    /* ---- Pagination ---- */
    .pagination-wrapper {
        margin-top: 3rem;
        display: flex;
        justify-content: center;
    }

    /* ---- Empty State ---- */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-lighter);
    }

    .empty-state i {
        font-size: 3rem;
        color: var(--tunisia-gold);
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: var(--med-blue);
    }

    .empty-state p {
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .search-hero {
            padding: 2rem 1rem;
        }

        .search-title {
            font-size: 1.8rem;
        }

        .search-form-large {
            flex-direction: column;
            align-items: stretch;
        }

        .trips-grid {
            grid-template-columns: 1fr;
        }
    }
</style>