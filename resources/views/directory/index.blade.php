<x-app-layout>
    <x-slot name="header">
        Hotels & Restaurants — Where to Stay & Eat
    </x-slot>

    <!-- Category filter pills -->
    <div class="category-filter">
        <a href="{{ route('directory.index') }}" class="filter-pill {{ !request('category') ? 'active' : '' }}">All</a>
        @foreach([
            'hotel' => 'Hotels',
            'resort' => 'Resorts',
            'hostel' => 'Hostels',
            'guest_house' => 'Guest Houses',
            'cafe' => 'Cafés',
            'traditional_restaurant' => 'Traditional Restaurants',
            'luxury_dining' => 'Luxury Dining'
        ] as $value => $label)
            <a href="{{ route('directory.index', ['category' => $value]) }}" 
               class="filter-pill {{ request('category') == $value ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    @if($establishments->count())
        <div class="directory-grid">
            @foreach($establishments as $item)
                <a href="{{ route('directory.show', $item->slug) }}" class="directory-card-link">
                    <article class="directory-card">
                        <div class="card-image">
                            @if($item->photos && count($item->photos) > 0)
                                <img src="{{ asset('storage/' . $item->photos[0]) }}" alt="{{ $item->name }}" loading="lazy">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-hotel"></i>
                                </div>
                            @endif
                            <div class="card-image-badge">{{ $item->category_label }}</div>
                        </div>
                        <div class="card-content">
                            <div class="card-header">
                                @if($item->rating > 0)
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <span>{{ number_format($item->rating, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <h3 class="card-title">{{ $item->name }}</h3>
                            @if($item->city || $item->region)
                                <div class="card-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $item->city ? $item->city . ', ' : '' }}{{ $item->region ?? '' }}
                                </div>
                            @endif
                            @if($item->price_range)
                                <div class="card-price-range">
                                    <i class="fas fa-tag"></i> {{ $item->price_range }}
                                </div>
                            @endif
                            <p class="card-description">
                                {{ Str::limit($item->description ?? 'No description yet.', 100) }}
                            </p>
                            <div class="card-footer">
                                <span class="view-details">View details <i class="fas fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </article>
                </a>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $establishments->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-utensils"></i>
            <p>No establishments found in this category.</p>
            <a href="{{ route('directory.index') }}" class="btn-gold" style="margin-top: 1rem;">View all categories</a>
        </div>
    @endif
</x-app-layout>

<style>
    /* Category Filter */
    .category-filter {
        display: flex;
        flex-wrap: wrap;
        gap: 0.6rem;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-lighter);
        justify-content: center;
    }

    .filter-pill {
        padding: 0.55rem 1.4rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: all var(--transition);
        background: var(--white);
        color: var(--text-secondary);
        border: 1px solid var(--border-light);
    }

    .filter-pill:hover {
        background: var(--sand-light);
        border-color: var(--tunisia-gold);
        color: var(--med-blue);
    }

    .filter-pill.active {
        background: var(--tunisia-red);
        color: white;
        border-color: var(--tunisia-red);
    }

    /* Directory Grid */
    .directory-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
        gap: 2.5rem;
    }

    .directory-card-link {
        text-decoration: none;
        color: inherit;
    }

    .directory-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-lighter);
        transition: all var(--transition);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .directory-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
    }

    .card-image {
        position: relative;
        height: 200px;
        overflow: hidden;
        background: var(--sand-light);
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .directory-card:hover .card-image img {
        transform: scale(1.04);
    }

    .no-image {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--sand-light);
        color: var(--text-muted);
        font-size: 3rem;
    }

    .card-image-badge {
        position: absolute;
        bottom: 1rem;
        left: 1rem;
        background: rgba(193,18,31,0.9);
        color: white;
        padding: 0.3rem 1rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        backdrop-filter: blur(4px);
    }

    .card-content {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .card-header {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 0.5rem;
    }

    .rating-stars {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.8rem;
        font-weight: 600;
        background: var(--sand-light);
        padding: 0.2rem 0.7rem;
        border-radius: 20px;
        color: var(--text-primary);
    }

    .rating-stars i {
        color: #F5B042;
    }

    .card-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--med-blue);
        line-height: 1.3;
    }

    .card-location, .card-price-range {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 0.4rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .card-location i, .card-price-range i {
        color: var(--tunisia-gold);
    }

    .card-description {
        font-size: 0.85rem;
        color: var(--text-secondary);
        line-height: 1.5;
        margin: 0.8rem 0 1.2rem;
        flex: 1;
    }

    .card-footer {
        border-top: 1px solid var(--border-lighter);
        padding-top: 1rem;
        margin-top: auto;
    }

    .view-details {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--tunisia-red);
        display: flex;
        align-items: center;
        gap: 0.3rem;
        transition: gap 0.2s;
    }

    .directory-card:hover .view-details {
        gap: 0.6rem;
    }

    .pagination-wrapper {
        margin-top: 3rem;
        display: flex;
        justify-content: center;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-lighter);
    }
    .empty-state i {
        font-size: 3rem;
        color: var(--tunisia-gold);
        margin-bottom: 1rem;
    }
    .empty-state p {
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }

    @media (max-width: 768px) {
        .category-filter {
            justify-content: center;
            gap: 0.4rem;
        }
        .directory-grid {
            grid-template-columns: 1fr;
        }
    }
</style>