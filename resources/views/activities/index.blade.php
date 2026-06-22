<x-app-layout>
    <x-slot name="header">
        Activities & Things to Do in Tunisia
    </x-slot>

    <div class="activities-intro">
        <p>From camel treks in the Sahara to scuba diving in the Mediterranean, discover unforgettable experiences.</p>
    </div>

    @if($activities->count())
        <div class="activities-grid">
            @foreach($activities as $activity)
                <a href="{{ route('activities.show', $activity->slug) }}" class="activity-card-link">
                    <article class="activity-card">
                        <div class="card-image">
                            @if($activity->photo_gallery && count($activity->photo_gallery) > 0)
                                <img src="{{ asset('storage/' . $activity->photo_gallery[0]) }}" alt="{{ $activity->name }}"
                                    loading="lazy">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-hiking"></i>
                                </div>
                            @endif
                            @if($activity->category)
                                <div class="card-category-badge">{{ $activity->category }}</div>
                            @endif
                        </div>
                        <div class="card-content">
                            <h3 class="activity-name">{{ $activity->name }}</h3>
                            <p class="activity-excerpt">
                                {{ Str::limit($activity->description ?? 'No description yet.', 100) }}
                            </p>
                            <span class="view-link">Learn more <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </article>
                </a>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $activities->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-hiking"></i>
            <p>No activities found. Check back soon for new adventures!</p>
        </div>
    @endif
</x-app-layout>

<style>
    .activities-intro {
        text-align: center;
        margin-bottom: 2rem;
        color: var(--text-secondary);
        font-size: 1.05rem;
    }

    .activities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
        gap: 2.5rem;
    }

    .activity-card-link {
        text-decoration: none;
        color: inherit;
    }

    .activity-card {
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

    .activity-card:hover {
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

    .activity-card:hover .card-image img {
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

    .card-category-badge {
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

    .activity-name {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--med-blue);
        line-height: 1.3;
    }

    .activity-excerpt {
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

    .activity-card:hover .view-link {
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
    }

    @media (max-width: 768px) {
        .activities-grid {
            grid-template-columns: 1fr;
        }
    }
</style>