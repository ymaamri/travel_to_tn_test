<x-app-layout>
    <x-slot name="header">
        Explore Destinations in Tunisia
    </x-slot>

    <div class="destinations-intro">
        <p>From Mediterranean beaches to Saharan dunes, discover the diverse regions of Tunisia.</p>
    </div>

    <!-- Filter by type -->
    <div class="filter-bar">
        <a href="{{ route('destinations.index') }}" class="filter-chip {{ !request('type') ? 'active' : '' }}">All</a>
        @foreach(['city', 'region', 'beach', 'historical_place', 'island', 'desert_area', 'village'] as $type)
            <a href="{{ route('destinations.index', ['type' => $type]) }}"
                class="filter-chip {{ request('type') == $type ? 'active' : '' }}">
                {{ ucfirst(str_replace('_', ' ', $type)) }}
            </a>
        @endforeach
    </div>

    @if($destinations->count())
        <div class="destinations-grid">
            @foreach($destinations as $destination)
                <a href="{{ route('destinations.show', $destination->slug) }}" class="destination-card-link">
                    <article class="destination-card">
                        <div class="card-image">
                            @if($destination->photo_gallery && count($destination->photo_gallery) > 0)
                                <img src="{{ asset('storage/' . $destination->photo_gallery[0]) }}" alt="{{ $destination->name }}"
                                    loading="lazy">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-map-pin"></i>
                                </div>
                            @endif
                            <div class="card-type-badge">{{ ucfirst(str_replace('_', ' ', $destination->type)) }}</div>
                        </div>
                        <div class="card-content">
                            <h3 class="destination-name">{{ $destination->name }}</h3>
                            <p class="destination-excerpt">
                                {{ Str::limit($destination->overview ?? 'No description yet.', 120) }}
                            </p>
                            <span class="view-link">Learn more <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </article>
                </a>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $destinations->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-map-signs"></i>
            <p>No destinations found.</p>
            <a href="{{ route('destinations.index') }}" class="btn-gold">View all destinations</a>
        </div>
    @endif
</x-app-layout>

<style>
    .destinations-intro {
        text-align: center;
        margin-bottom: 2rem;
        color: var(--text-secondary);
        font-size: 1.05rem;
    }

    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-lighter);
    }

    .filter-chip {
        padding: 0.5rem 1.4rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        background: var(--white);
        color: var(--text-secondary);
        border: 1px solid var(--border-light);
        transition: all var(--transition);
    }

    .filter-chip:hover {
        background: var(--sand-light);
        border-color: var(--tunisia-gold);
        color: var(--med-blue);
    }

    .filter-chip.active {
        background: var(--tunisia-red);
        color: white;
        border-color: var(--tunisia-red);
    }

    .destinations-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
        gap: 2.5rem;
    }

    .destination-card-link {
        text-decoration: none;
        color: inherit;
    }

    .destination-card {
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

    .destination-card:hover {
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

    .destination-card:hover .card-image img {
        transform: scale(1.04);
    }

    .no-image {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--sand-light);
        color: var(--text-muted);
        font-size: 2.5rem;
    }

    .card-type-badge {
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

    .card-content {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .destination-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--med-blue);
        line-height: 1.3;
    }

    .destination-excerpt {
        font-size: 0.85rem;
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 1rem;
        flex: 1;
    }

    .view-link {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--tunisia-red);
        display: flex;
        align-items: center;
        gap: 0.3rem;
        transition: gap 0.2s;
    }

    .destination-card:hover .view-link {
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
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .destinations-grid {
            grid-template-columns: 1fr;
        }
    }
</style>