<x-app-layout>
    <x-slot name="header">
        {{ $transport->title }}
    </x-slot>

    <div class="transport-show-container">
        <div class="transport-show-card">
            <!-- Featured Image -->
            @if($transport->featured_image)
                <div class="featured-image">
                    <img src="{{ asset('storage/' . $transport->featured_image) }}" alt="{{ $transport->title }}">
                </div>
            @else
                <div class="featured-image-placeholder">
                    <i class="fas fa-map-signs"></i>
                </div>
            @endif

            <div class="transport-show-content">
                <!-- Main Content -->
                <div class="content-body">
                    {!! $transport->content !!}
                </div>

                <!-- Map -->
                @if($transport->map_url)
                    <div class="map-section">
                        <h3><i class="fas fa-map"></i> Location Map</h3>
                        <div class="map-container">
                            {!! $transport->map_url !!}
                        </div>
                    </div>
                @endif

                <!-- Contact Info -->
                @if($transport->contact_info)
                    <div class="contact-section">
                        <h3><i class="fas fa-phone-alt"></i> Contact Information</h3>
                        <div class="contact-content">
                            {!! nl2br(e($transport->contact_info)) !!}
                        </div>
                    </div>
                @endif

                <!-- Gallery -->
                @if($transport->gallery && count($transport->gallery) > 0)
                    <div class="gallery-section">
                        <h3><i class="fas fa-images"></i> Photo Gallery</h3>
                        <div class="gallery-grid">
                            @foreach($transport->gallery as $image)
                                <a href="{{ asset('storage/' . $image) }}" target="_blank" class="gallery-item">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery image">
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Back link -->
                <div class="back-link-wrapper">
                    <a href="{{ route('transport.index') }}" class="back-link-alt">
                        <i class="fas fa-arrow-left"></i> Back to all transportation guides
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .transport-show-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    .transport-show-card {
        background: var(--white);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-lighter);
    }

    .featured-image {
        width: 100%;
        max-height: 450px;
        overflow: hidden;
    }

    .featured-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .featured-image-placeholder {
        width: 100%;
        height: 300px;
        background: var(--sand-light);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: var(--text-muted);
    }

    .transport-show-content {
        padding: 2.5rem;
    }

    /* Content body */
    .content-body {
        font-size: 1rem;
        line-height: 1.7;
        color: var(--text-primary);
        margin-bottom: 2rem;
    }

    .content-body h1,
    .content-body h2,
    .content-body h3 {
        font-family: 'Playfair Display', serif;
        color: var(--med-blue);
        margin: 2rem 0 1rem 0;
        font-weight: 700;
    }

    .content-body h1 {
        font-size: 2rem;
    }

    .content-body h2 {
        font-size: 1.7rem;
    }

    .content-body h3 {
        font-size: 1.4rem;
    }

    .content-body p {
        margin-bottom: 1rem;
    }

    .content-body ul,
    .content-body ol {
        margin: 1rem 0 1rem 1.5rem;
    }

    .content-body li {
        margin-bottom: 0.3rem;
    }

    .content-body a {
        color: var(--tunisia-red);
        text-decoration: underline;
        font-weight: 500;
    }

    .content-body a:hover {
        color: var(--tunisia-red-dark);
    }

    .content-body img {
        max-width: 100%;
        border-radius: var(--radius-md);
        margin: 1rem 0;
    }

    /* Sections */
    .map-section,
    .contact-section,
    .gallery-section {
        margin-top: 2rem;
        margin-bottom: 2rem;
        border-top: 1px solid var(--border-lighter);
        padding-top: 2rem;
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

    h3 i {
        color: var(--tunisia-gold);
        font-size: 1.2rem;
    }

    .map-container {
        border-radius: var(--radius-md);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .map-container iframe {
        width: 100%;
        height: 350px;
        border: 0;
    }

    .contact-content {
        background: var(--sand-light);
        padding: 1.5rem;
        border-radius: var(--radius-md);
        border-left: 4px solid var(--tunisia-gold);
        font-size: 0.95rem;
        line-height: 1.6;
        color: var(--text-secondary);
        white-space: pre-line;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
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
        height: 150px;
        object-fit: cover;
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
        .transport-show-content {
            padding: 1.5rem;
        }

        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        }

        .map-container iframe {
            height: 250px;
        }
    }
</style>