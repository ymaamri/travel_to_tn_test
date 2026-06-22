<x-app-layout>
    <x-slot name="header">
        {{ $establishment->name }}
    </x-slot>

    <div class="directory-show-container">
        <div class="directory-show-card">
            <!-- Hero image -->
            @if($establishment->photos && count($establishment->photos) > 0)
                <div class="hero-image">
                    <img src="{{ asset('storage/' . $establishment->photos[0]) }}" alt="{{ $establishment->name }}">
                </div>
            @else
                <div class="hero-image-placeholder">
                    <i class="fas fa-hotel"></i>
                </div>
            @endif

            <div class="directory-show-content">
                <!-- Title section -->
                <div class="title-section">
                    <span class="category-badge">{{ $establishment->category_label }}</span>
                    @if($establishment->rating > 0)
                        <div class="rating-section">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($establishment->rating))
                                        <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= $establishment->rating)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-value">{{ number_format($establishment->rating, 1) }}</span>
                            <span class="review-count">({{ $establishment->review_count }}
                                {{ Str::plural('review', $establishment->review_count) }})</span>
                        </div>
                    @endif
                </div>

                <h1 class="establishment-title">{{ $establishment->name }}</h1>

                <!-- Quick info grid -->
                <div class="info-grid">
                    @if($establishment->address || $establishment->city)
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <strong>Location</strong>
                                <p>
                                    {{ $establishment->address ? $establishment->address . ', ' : '' }}
                                    {{ $establishment->city ? $establishment->city . ', ' : '' }}
                                    {{ $establishment->region ?? '' }}
                                </p>
                            </div>
                        </div>
                    @endif
                    @if($establishment->price_range)
                        <div class="info-item">
                            <i class="fas fa-tag"></i>
                            <div>
                                <strong>Price range</strong>
                                <p>{{ $establishment->price_range }}</p>
                            </div>
                        </div>
                    @endif
                    @if($establishment->contact_phone)
                        <div class="info-item">
                            <i class="fas fa-phone-alt"></i>
                            <div>
                                <strong>Phone</strong>
                                <p>{{ $establishment->contact_phone }}</p>
                            </div>
                        </div>
                    @endif
                    @if($establishment->contact_email)
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>Email</strong>
                                <p><a
                                        href="mailto:{{ $establishment->contact_email }}">{{ $establishment->contact_email }}</a>
                                </p>
                            </div>
                        </div>
                    @endif
                    @if($establishment->website)
                        <div class="info-item">
                            <i class="fas fa-globe"></i>
                            <div>
                                <strong>Website</strong>
                                <p><a href="{{ $establishment->website }}" target="_blank"
                                        rel="noopener noreferrer">{{ Str::limit($establishment->website, 40) }}</a></p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                @if($establishment->description)
                    <div class="description-section">
                        <h3>About</h3>
                        <div class="description-text">
                            {!! nl2br(e($establishment->description)) !!}
                        </div>
                    </div>
                @endif

                <!-- Amenities -->
                @if($establishment->amenities && count($establishment->amenities) > 0)
                    <div class="amenities-section">
                        <h3>Amenities</h3>
                        <div class="amenities-list">
                            @foreach($establishment->amenities as $amenity)
                                <span class="amenity-tag">{{ ucfirst($amenity) }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Google Map -->
                @if($establishment->map_url)
                    <div class="map-section">
                        <h3>Location Map</h3>
                        <div class="map-container">
                            {!! $establishment->map_url !!}
                        </div>
                    </div>
                @endif

                <!-- Photo gallery -->
                @if($establishment->photos && count($establishment->photos) > 1)
                    <div class="gallery-section">
                        <h3>Photo Gallery</h3>
                        <div class="gallery-grid">
                            @foreach($establishment->photos as $index => $photo)
                                @if($index > 0)
                                    <a href="{{ asset('storage/' . $photo) }}" target="_blank" class="gallery-item">
                                        <img src="{{ asset('storage/' . $photo) }}" alt="{{ $establishment->name }} gallery">
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Reviews Section -->
                <div class="reviews-section">
                    <h3>Customer Reviews</h3>

                    @php
                        $avgRating = $establishment->reviews->avg('rating') ?? 0;
                        $reviewCount = $establishment->reviews->count();
                    @endphp

                    <div class="reviews-summary">
                        <div class="avg-rating">{{ number_format($avgRating, 1) }}</div>
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($avgRating))
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <div class="review-count-badge">({{ $reviewCount }} {{ Str::plural('review', $reviewCount) }})
                        </div>
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

                    <!-- Write Review Form -->
                    @auth
                        <div class="write-review-card">
                            <h4>Write a Review</h4>
                            <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="reviewable_type" value="establishment">
                                <input type="hidden" name="reviewable_id" value="{{ $establishment->id }}">

                                <div class="form-group">
                                    <label>Rating *</label>
                                    <select name="rating" class="form-select" required>
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
                                    <small>JPEG, PNG, JPG, GIF up to 2MB each</small>
                                </div>

                                <button type="submit" class="btn-gold">Submit Review</button>
                            </form>
                        </div>
                    @else
                        <div class="login-prompt">
                            <i class="fas fa-lock"></i> <a href="{{ route('login') }}">Log in</a> to write a review.
                        </div>
                    @endauth

                    <!-- Reviews List -->
                    <div class="reviews-list">
                        @foreach($establishment->reviews()->with('user', 'images')->latest()->get() as $review)
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="review-rating">
                                        <div class="stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
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
                                    <h5 class="review-title">{{ $review->title }}</h5>
                                @endif
                                <p class="review-content">{{ $review->content }}</p>
                                <div class="review-meta">
                                    – {{ $review->user->name }} on {{ $review->created_at->format('M d, Y') }}
                                </div>
                                @if($review->images->count())
                                    <div class="review-images">
                                        @foreach($review->images as $img)
                                            <img src="{{ asset('storage/' . $img->image_path) }}" alt="Review image">
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Back link -->
                <div class="back-link-wrapper">
                    <a href="{{ route('directory.index') }}" class="back-link-alt">
                        <i class="fas fa-arrow-left"></i> Back to Directory
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .directory-show-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    .directory-show-card {
        background: var(--white);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-lighter);
    }

    .hero-image {
        width: 100%;
        max-height: 450px;
        overflow: hidden;
    }

    .hero-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .hero-image-placeholder {
        width: 100%;
        height: 300px;
        background: var(--sand-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: var(--text-muted);
    }

    .directory-show-content {
        padding: 2.5rem;
    }

    .title-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .category-badge {
        background: rgba(193, 18, 31, 0.1);
        color: var(--tunisia-red);
        padding: 0.4rem 1.2rem;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .rating-section {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .rating-section .stars {
        color: #F5B042;
        font-size: 0.9rem;
    }

    .rating-value {
        font-weight: 700;
        font-size: 1rem;
        color: var(--med-blue);
    }

    .review-count {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .establishment-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--med-blue);
        margin-bottom: 2rem;
        line-height: 1.2;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
        background: var(--sand-light);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 0.8rem;
    }

    .info-item i {
        width: 1.5rem;
        font-size: 1.1rem;
        color: var(--tunisia-gold);
        margin-top: 0.1rem;
    }

    .info-item strong {
        display: block;
        font-size: 0.7rem;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: 0.5px;
    }

    .info-item p,
    .info-item a {
        font-size: 0.85rem;
        margin-top: 0.2rem;
        color: var(--text-primary);
        text-decoration: none;
    }

    .info-item a:hover {
        color: var(--tunisia-red);
        text-decoration: underline;
    }

    .description-section,
    .amenities-section,
    .map-section,
    .gallery-section {
        margin-bottom: 2rem;
    }

    h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--med-blue);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .description-text {
        font-size: 0.95rem;
        line-height: 1.7;
        color: var(--text-secondary);
    }

    .amenities-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
    }

    .amenity-tag {
        background: var(--sand-light);
        border: 1px solid var(--border-light);
        padding: 0.4rem 1rem;
        border-radius: 30px;
        font-size: 0.8rem;
        color: var(--text-primary);
    }

    .map-container {
        border-radius: var(--radius-md);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .map-container iframe {
        width: 100%;
        height: 300px;
        border: 0;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
    }

    .gallery-item {
        overflow: hidden;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        transition: transform 0.2s;
    }

    .gallery-item:hover {
        transform: scale(1.02);
    }

    .gallery-item img {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }

    /* Reviews Section */
    .reviews-section {
        border-top: 1px solid var(--border-lighter);
        padding-top: 2rem;
        margin-top: 1rem;
    }

    .reviews-summary {
        display: flex;
        align-items: baseline;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-lighter);
    }

    .avg-rating {
        font-size: 2rem;
        font-weight: 700;
        color: var(--tunisia-red);
    }

    .reviews-summary .stars {
        color: #F5B042;
        font-size: 1rem;
    }

    .review-count-badge {
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .write-review-card {
        background: var(--sand-light);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-light);
    }

    .write-review-card h4 {
        font-weight: 700;
        margin-bottom: 1rem;
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
        background: var(--white);
    }

    .form-select:focus,
    .form-input:focus,
    .form-textarea:focus {
        outline: none;
        border-color: var(--tunisia-gold);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
    }

    .login-prompt {
        background: var(--sand-light);
        padding: 1.5rem;
        text-align: center;
        border-radius: var(--radius-md);
        margin-bottom: 2rem;
    }

    .login-prompt a {
        color: var(--tunisia-red);
        font-weight: 600;
        text-decoration: none;
    }

    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .review-item {
        border: 1px solid var(--border-lighter);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        background: var(--white);
        transition: box-shadow var(--transition);
    }

    .review-item:hover {
        box-shadow: var(--shadow-sm);
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.8rem;
        margin-bottom: 0.8rem;
    }

    .review-rating {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        flex-wrap: wrap;
    }

    .review-rating .stars {
        color: #F5B042;
        font-size: 0.8rem;
    }

    .review-badges {
        display: flex;
        gap: 0.5rem;
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

    .review-content {
        font-size: 0.9rem;
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 0.6rem;
    }

    .review-meta {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-bottom: 0.8rem;
    }

    .review-images {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-top: 0.8rem;
    }

    .review-images img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-lighter);
    }

    .back-link-wrapper {
        margin-top: 2rem;
        border-top: 1px solid var(--border-lighter);
        padding-top: 1.5rem;
    }

    .back-link-alt {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--tunisia-red);
        font-weight: 600;
        text-decoration: none;
        transition: gap 0.2s;
    }

    .back-link-alt:hover {
        gap: 0.8rem;
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .directory-show-content {
            padding: 1.5rem;
        }

        .establishment-title {
            font-size: 1.8rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }

        .review-header {
            flex-direction: column;
        }
    }
</style>