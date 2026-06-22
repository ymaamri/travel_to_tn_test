<x-app-layout>
    <x-slot name="header">
        Transportation Guide — Getting Around Tunisia
    </x-slot>

    <div class="transport-intro">
        <p>Getting around Tunisia is easy once you know your options. From trains and louages to car rentals and ferries
            — we've got you covered. Click on any guide below to learn more.</p>
    </div>

    @if($transports->count())
        <div class="transport-grid">
            @foreach($transports as $transport)
                <a href="{{ route('transport.show', $transport->slug) }}" class="transport-card-link">
                    <article class="transport-card">
                        <div class="transport-card-image">
                            @if($transport->featured_image)
                                <img src="{{ asset('storage/' . $transport->featured_image) }}" alt="{{ $transport->title }}"
                                    loading="lazy">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-bus"></i>
                                </div>
                            @endif
                        </div>
                        <div class="transport-card-content">
                            <h3 class="transport-title">{{ $transport->title }}</h3>
                            <div class="transport-link">
                                View guide <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </article>
                </a>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-map-marked-alt"></i>
            <p>No transportation guides available yet. Please check back later.</p>
        </div>
    @endif
</x-app-layout>

<style>
    .transport-intro {
        margin-bottom: 2.5rem;
        padding: 1.5rem 2rem;
        background: var(--sand-light);
        border-radius: var(--radius-md);
        border-left: 5px solid var(--tunisia-gold);
        color: var(--text-secondary);
        font-size: 0.95rem;
        line-height: 1.6;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
    }

    .transport-intro p {
        margin: 0;
    }

    .transport-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2.5rem;
    }

    .transport-card-link {
        text-decoration: none;
        color: inherit;
    }

    .transport-card {
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

    .transport-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
    }

    .transport-card-image {
        height: 220px;
        overflow: hidden;
        background: var(--sand-light);
    }

    .transport-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .transport-card:hover .transport-card-image img {
        transform: scale(1.05);
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

    .transport-card-content {
        padding: 1.8rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .transport-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--med-blue);
        line-height: 1.3;
        flex: 1;
    }

    .transport-link {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--tunisia-red);
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        transition: gap 0.2s;
        align-self: flex-start;
    }

    .transport-card:hover .transport-link {
        gap: 0.6rem;
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
        .transport-grid {
            grid-template-columns: 1fr;
        }
    }
</style>