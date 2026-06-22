<x-app-layout>
    <x-slot name="header">
        {{ $trip->title }}
    </x-slot>

    <div class="trip-detail-container">
        <!-- Hero image -->
        <div class="detail-hero">
            @if($trip->image)
                <img src="{{ asset('storage/' . $trip->image) }}" alt="{{ $trip->title }}">
            @else
                <div class="detail-hero-placeholder">
                    <i class="fas fa-mountain-sun"></i>
                </div>
            @endif
            <div class="hero-overlay-detail"></div>
            <div class="hero-info-box">
                <span class="destination-badge">
                    <i class="fas fa-map-marker-alt"></i> {{ $trip->destination }}
                </span>
                <h1 class="trip-name">{{ $trip->title }}</h1>
            </div>
        </div>

        <div class="detail-grid">
            <!-- Main column -->
            <div class="detail-main">
                <!-- Quick info cards -->
                <div class="info-cards-row">
                    <div class="info-card">
                        <i class="far fa-calendar-alt"></i>
                        <div>
                            <strong>Date</strong>
                            <p>{{ $trip->date->format('F j, Y') }}</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <i class="far fa-clock"></i>
                        <div>
                            <strong>Departure</strong>
                            <p>{{ $trip->departure_time->format('g:i A') }}</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <i class="fas fa-undo-alt"></i>
                        <div>
                            <strong>Return</strong>
                            <p>{{ $trip->return_time->format('g:i A') }}</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <i class="fas fa-chair"></i>
                        <div>
                            <strong>Seats</strong>
                            <p>{{ $trip->available_seats }} left</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <i class="fas fa-tag"></i>
                        <div>
                            <strong>Price</strong>
                            <p>{{ number_format($trip->price, 2) }} TND</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <i class="fas fa-building"></i>
                        <div>
                            <strong>Agency</strong>
                            <p>{{ $trip->user->name ?? 'Unknown' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($trip->description)
                    <div class="section-block">
                        <h2 class="section-title">About this trip</h2>
                        <div class="description-text">
                            {!! nl2br(e($trip->description)) !!}
                        </div>
                    </div>
                @endif

                <!-- Reviews Section -->
                <div class="section-block" id="reviews">
                    <h2 class="section-title">Traveler Reviews</h2>

                    @php
                        $avgRating = $trip->reviews->avg('rating') ?? 0;
                        $reviewCount = $trip->reviews->count();
                    @endphp

                    <div class="reviews-summary-card">
                        <div class="avg-rating-big">{{ number_format($avgRating, 1) }}</div>
                        <div class="stars-large">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= round($avgRating) ? '' : '-o' }}"></i>
                            @endfor
                        </div>
                        <span class="review-total">({{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})</span>
                    </div>

                    @if(session('success'))
                        <div class="alert-box alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert-box alert-error">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        </div>
                    @endif

                    <!-- Write review form -->
                    @auth
                        <div class="write-review-card">
                            <h3>Write a Review</h3>
                            <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="reviewable_type" value="trip">
                                <input type="hidden" name="reviewable_id" value="{{ $trip->id }}">

                                <div class="form-group">
                                    <label>Rating *</label>
                                    <select name="rating" required class="form-select">
                                        <option value="">Select rating</option>
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">{{ $i }} star{{ $i > 1 ? 's' : '' }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Review Title (optional)</label>
                                    <input type="text" name="title" class="form-input" value="{{ old('title') }}">
                                </div>
                                <div class="form-group">
                                    <label>Your Review</label>
                                    <textarea name="content" rows="3" class="form-textarea">{{ old('content') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Upload Photos (optional)</label>
                                    <input type="file" name="images[]" multiple accept="image/*" class="form-file">
                                    <small>JPEG, PNG, GIF up to 2MB each</small>
                                </div>
                                <button type="submit" class="btn-gold">Submit Review</button>
                            </form>
                        </div>
                    @else
                        <div class="login-prompt-card">
                            <i class="fas fa-lock"></i>
                            <a href="{{ route('login') }}">Log in</a> to write a review.
                        </div>
                    @endauth

                    <!-- Reviews list -->
                    @foreach($trip->reviews()->with('user', 'images')->latest()->get() as $review)
                        <div class="review-card">
                            <div class="review-head">
                                <div class="review-user-info">
                                    <div class="review-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                    <div class="review-badges">
                                        @if($review->is_verified)
                                            <span class="badge verified">✓ Verified Traveler</span>
                                        @endif
                                        @if($review->user->hasVerifiedTravel() && !$review->is_verified)
                                            <span class="badge eligible">Eligible for verification</span>
                                        @endif
                                    </div>
                                </div>
                                @if(auth()->check() && (auth()->id() === $review->user_id || auth()->user()->role === 'admin'))
                                    <div class="review-actions">
                                        @if(auth()->user()->role === 'admin' && !$review->is_verified)
                                            <form action="{{ route('reviews.verify', $review) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="action-link verify">Verify</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('reviews.destroy', $review) }}" method="POST"
                                            onsubmit="return confirm('Delete this review?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="action-link delete">Delete</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            @if($review->title)
                                <h4 class="review-title">{{ $review->title }}</h4>
                            @endif
                            <p class="review-text">{{ $review->content }}</p>
                            <div class="review-meta-line">
                                <span class="review-author">– {{ $review->user->name }}</span>
                                <span class="review-date">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            @if($review->images->count())
                                <div class="review-images-gallery">
                                    @foreach($review->images as $img)
                                        <img src="{{ asset('storage/' . $img->image_path) }}" alt="Review image">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Back link -->
                <a href="{{ route('trips.index') }}" class="back-link-alt">
                    <i class="fas fa-arrow-left"></i> Back to all trips
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    /* ---- Detail Hero ---- */
    .detail-hero {
        position: relative;
        height: 400px;
        overflow: hidden;
        border-radius: var(--radius-lg);
        margin-bottom: 2rem;
        box-shadow: var(--shadow-md);
    }

    .detail-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .detail-hero-placeholder {
        width: 100%;
        height: 100%;
        background: var(--sand);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        color: var(--text-muted);
    }

    .hero-overlay-detail {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50%;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
    }

    .hero-info-box {
        position: absolute;
        bottom: 2rem;
        left: 2rem;
        color: white;
    }

    .destination-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        padding: 0.3rem 1rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .trip-name {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    /* ---- Detail Grid ---- */
    .detail-grid {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .detail-main {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-lighter);
        padding: 2rem;
    }

    /* Info cards */
    .info-cards-row {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .info-card {
        background: var(--sand-light);
        border-radius: var(--radius-md);
        padding: 1rem;
        display: flex;
        gap: 0.8rem;
        align-items: center;
        transition: box-shadow var(--transition);
    }

    .info-card:hover {
        box-shadow: var(--shadow-sm);
    }

    .info-card i {
        font-size: 1.4rem;
        color: var(--tunisia-gold);
        width: 2rem;
        text-align: center;
    }

    .info-card strong {
        display: block;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--text-muted);
        margin-bottom: 0.15rem;
    }

    .info-card p {
        font-weight: 600;
        color: var(--text-primary);
    }

    /* Section */
    .section-block {
        margin-bottom: 2.5rem;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--med-blue);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--tunisia-gold);
        display: inline-block;
    }

    .description-text {
        font-size: 0.95rem;
        line-height: 1.8;
        color: var(--text-secondary);
    }

    /* Reviews summary */
    .reviews-summary-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--sand-light);
        border-radius: var(--radius-md);
        margin-bottom: 2rem;
    }

    .avg-rating-big {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--tunisia-red);
        line-height: 1;
    }

    .stars-large {
        color: var(--tunisia-gold);
        font-size: 1.2rem;
    }

    .review-total {
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    /* Write review card */
    .write-review-card {
        background: var(--sand-light);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-light);
    }

    .write-review-card h3 {
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.3rem;
        font-size: 0.85rem;
    }

    .form-select,
    .form-input,
    .form-textarea,
    .form-file {
        width: 100%;
        padding: 0.65rem 0.8rem;
        border: 1px solid var(--border-light);
        border-radius: var(--radius-sm);
        font-family: inherit;
        font-size: 0.9rem;
        transition: 0.2s;
    }

    .form-select:focus,
    .form-input:focus,
    .form-textarea:focus {
        outline: none;
        border-color: var(--tunisia-gold);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
    }

    .login-prompt-card {
        background: var(--sand-light);
        padding: 1.5rem;
        text-align: center;
        border-radius: var(--radius-md);
        margin-bottom: 2rem;
    }

    .login-prompt-card a {
        color: var(--tunisia-red);
        font-weight: 600;
        text-decoration: none;
    }

    /* Individual review */
    .review-card {
        border: 1px solid var(--border-lighter);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        background: var(--white);
        transition: box-shadow var(--transition);
    }

    .review-card:hover {
        box-shadow: var(--shadow-sm);
    }

    .review-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 0.8rem;
        margin-bottom: 0.8rem;
    }

    .review-stars {
        color: var(--tunisia-gold);
        font-size: 0.85rem;
    }

    .review-badges {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.3rem;
    }

    .badge {
        font-size: 0.65rem;
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-weight: 600;
    }

    .badge.verified {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .badge.eligible {
        background: #E3F2FD;
        color: #1565C0;
    }

    .review-actions {
        display: flex;
        gap: 1rem;
    }

    .action-link {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 0.75rem;
        font-weight: 600;
        text-decoration: underline;
    }

    .action-link.verify {
        color: #2E7D32;
    }

    .action-link.delete {
        color: var(--tunisia-red);
    }

    .review-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.3rem;
        color: var(--med-blue);
    }

    .review-text {
        font-size: 0.9rem;
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 0.6rem;
    }

    .review-meta-line {
        display: flex;
        gap: 1rem;
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-bottom: 0.8rem;
    }

    .review-images-gallery {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .review-images-gallery img {
        width: 65px;
        height: 65px;
        object-fit: cover;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-lighter);
    }

    .back-link-alt {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--tunisia-red);
        font-weight: 600;
        text-decoration: none;
        margin-top: 1rem;
        transition: gap 0.2s;
    }

    .back-link-alt:hover {
        gap: 0.8rem;
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .detail-hero {
            height: 260px;
        }

        .trip-name {
            font-size: 1.5rem;
        }

        .info-cards-row {
            grid-template-columns: 1fr 1fr;
        }

        .detail-main {
            padding: 1.2rem;
        }
    }
</style>