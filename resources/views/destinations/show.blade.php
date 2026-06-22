<x-app-layout>
    <x-slot name="header">
        {{ $destination->name }}
    </x-slot>

    <div class="destination-show-container">
        <div class="destination-show-card">
            <!-- Hero image -->
            @if($destination->photo_gallery && count($destination->photo_gallery) > 0)
                <div class="hero-image">
                    <img src="{{ asset('storage/' . $destination->photo_gallery[0]) }}" alt="{{ $destination->name }}">
                </div>
            @endif

            <div class="destination-show-content">
                <!-- Type badge -->
                <div class="type-badge-row">
                    <span class="type-badge">{{ ucfirst(str_replace('_', ' ', $destination->type)) }}</span>
                </div>

                <!-- Overview -->
                @if($destination->overview)
                    <div class="section-block">
                        <h3>Overview</h3>
                        <p class="section-text">{{ $destination->overview }}</p>
                    </div>
                @endif

                <!-- History -->
                @if($destination->history)
                    <div class="section-block">
                        <h3>History</h3>
                        <p class="section-text">{{ $destination->history }}</p>
                    </div>
                @endif

                <!-- Things to do -->
                @if($destination->things_to_do)
                    <div class="section-block">
                        <h3>Things to do</h3>
                        <div class="section-text">{!! nl2br(e($destination->things_to_do)) !!}</div>
                    </div>
                @endif

                <!-- Best restaurants -->
                @if($destination->best_restaurants)
                    <div class="section-block">
                        <h3>Best restaurants</h3>
                        <div class="section-text">{!! nl2br(e($destination->best_restaurants)) !!}</div>
                    </div>
                @endif

                <!-- Hotels -->
                @if($destination->hotels)
                    <div class="section-block">
                        <h3>Hotels & accommodation</h3>
                        <div class="section-text">{!! nl2br(e($destination->hotels)) !!}</div>
                    </div>
                @endif

                <!-- Weather -->
                @if($destination->weather)
                    <div class="section-block">
                        <h3>Weather</h3>
                        <p class="section-text">{{ $destination->weather }}</p>
                    </div>
                @endif

                <!-- Transportation -->
                @if($destination->transportation)
                    <div class="section-block">
                        <h3>Transportation</h3>
                        <p class="section-text">{{ $destination->transportation }}</p>
                    </div>
                @endif

                <!-- Best season -->
                @if($destination->best_season)
                    <div class="section-block">
                        <h3>Best season to visit</h3>
                        <p class="section-text">{{ $destination->best_season }}</p>
                    </div>
                @endif

                <!-- Local foods -->
                @if($destination->local_foods)
                    <div class="section-block">
                        <h3>Local foods</h3>
                        <div class="section-text">{!! nl2br(e($destination->local_foods)) !!}</div>
                    </div>
                @endif

                <!-- Budget estimate -->
                @if($destination->budget_estimate)
                    <div class="section-block">
                        <h3>Budget estimate</h3>
                        <p class="section-text">{{ $destination->budget_estimate }}</p>
                    </div>
                @endif

                <!-- Safety info -->
                @if($destination->safety_info)
                    <div class="section-block">
                        <h3>Safety information</h3>
                        <p class="section-text">{{ $destination->safety_info }}</p>
                    </div>
                @endif

                <!-- Map -->
                @if($destination->map_url)
                    <div class="section-block">
                        <h3>Location map</h3>
                        <div class="map-container">
                            {!! $destination->map_url !!}
                        </div>
                    </div>
                @endif

                <!-- Photo gallery -->
                @if($destination->photo_gallery && count($destination->photo_gallery) > 1)
                    <div class="section-block">
                        <h3>Photo gallery</h3>
                        <div class="gallery-grid">
                            @foreach($destination->photo_gallery as $index => $image)
                                @if($index > 0)
                                    <a href="{{ asset('storage/' . $image) }}" target="_blank" class="gallery-item">
                                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $destination->name }} gallery">
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- FAQs -->
                @if($destination->faqs && count($destination->faqs) > 0)
                    <div class="section-block">
                        <h3>Frequently asked questions</h3>
                        <div class="faq-list">
                            @foreach($destination->faqs as $faq)
                                <div class="faq-item">
                                    <h4 class="faq-question">{{ $faq['question'] }}</h4>
                                    <p class="faq-answer">{{ $faq['answer'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Nearby attractions -->
                @if($destination->nearby_attractions)
                    <div class="section-block">
                        <h3>Nearby attractions</h3>
                        <div class="section-text">{!! nl2br(e($destination->nearby_attractions)) !!}</div>
                    </div>
                @endif

                <!-- Reviews Section -->
                <div class="reviews-section">
                    <h3>Traveler Reviews</h3>

                    @php
                        $avgRating = $destination->reviews->avg('rating') ?? 0;
                        $reviewCount = $destination->reviews->count();
                    @endphp

                    <div class="reviews-summary">
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

                    @auth
                        <div class="write-review-card">
                            <h4>Write a Review</h4>
                            <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="reviewable_type" value="destination">
                                <input type="hidden" name="reviewable_id" value="{{ $destination->id }}">

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
                            <i class="fas fa-lock"></i> <a href="{{ route('login') }}">Log in</a> to write a review.
                        </div>
                    @endauth

                    @foreach($destination->reviews()->with('user', 'images')->latest()->get() as $review)
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
                                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this review?');">
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
                <div class="back-link-wrapper">
                    <a href="{{ route('destinations.index') }}" class="back-link-alt">
                        <i class="fas fa-arrow-left"></i> Back to all destinations
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .destination-show-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .destination-show-card {
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

    .destination-show-content {
        padding: 2.5rem;
    }

    .type-badge-row {
        margin-bottom: 2rem;
    }

    .type-badge {
        background: rgba(193,18,31,0.1);
        color: var(--tunisia-red);
        padding: 0.4rem 1.2rem;
        border-radius: 40px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .section-block {
        margin-bottom: 2.5rem;
    }

    h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--med-blue);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--tunisia-gold);
        display: inline-block;
    }

    .section-text {
        font-size: 0.95rem;
        line-height: 1.7;
        color: var(--text-secondary);
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

    .faq-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .faq-item {
        background: var(--sand-light);
        border-radius: var(--radius-md);
        padding: 1.2rem 1.5rem;
    }

    .faq-question {
        font-weight: 700;
        color: var(--med-blue);
        margin-bottom: 0.3rem;
    }

    .faq-answer {
        color: var(--text-secondary);
    }

    /* Reviews */
    .reviews-section {
        border-top: 1px solid var(--border-lighter);
        padding-top: 2rem;
        margin-top: 1rem;
    }

    .reviews-summary {
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
        box-shadow: 0 0 0 3px rgba(212,175,55,0.15);
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

    .badge.verified { background: #E8F5E9; color: #2E7D32; }
    .badge.eligible { background: #E3F2FD; color: #1565C0; }

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

    .action-link.verify { color: #2E7D32; }
    .action-link.delete { color: var(--tunisia-red); }

    .review-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.3rem; color: var(--med-blue); }
    .review-text { font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 0.6rem; }
    .review-meta-line { display: flex; gap: 1rem; font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.8rem; }

    .review-images-gallery {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-top: 0.8rem;
    }

    .review-images-gallery img {
        width: 65px;
        height: 65px;
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
        .destination-show-content {
            padding: 1.5rem;
        }
        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
        .review-head {
            flex-direction: column;
        }
    }
</style>