<x-app-layout>
    <x-slot name="header">
        Travel Blog — Stories from Tunisia
    </x-slot>

    <div class="blog-intro">
        <p>Discover the best places, local foods, travel tips, and hidden gems across Tunisia.</p>
    </div>

    @if(session('success'))
        <div class="alert-box alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($blogs->count())
        <div class="blog-grid">
            @foreach($blogs as $blog)
                <article class="blog-card">
                    <a href="{{ route('blog.show', $blog->slug) }}" class="blog-card-link">
                        <div class="blog-card-accent"></div>
                        @if($blog->featured_image)
                            <div class="blog-image">
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" loading="lazy">
                            </div>
                        @else
                            <div class="blog-image-placeholder">
                                <i class="fas fa-camera-retro"></i>
                            </div>
                        @endif
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span><i class="far fa-calendar-alt"></i>
                                    {{ $blog->published_at ? $blog->published_at->format('M d, Y') : 'Draft' }}</span>
                                <span><i class="far fa-user"></i> {{ $blog->user->name }}</span>
                            </div>
                            <h3 class="blog-title">{{ $blog->title }}</h3>
                            <p class="blog-excerpt">
                                {{ $blog->excerpt ? Str::limit($blog->excerpt, 110) : Str::limit(strip_tags($blog->content), 110) }}
                            </p>
                            <span class="blog-read-more">
                                Read more <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $blogs->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-book-open"></i>
            <p>No blog posts yet. Check back soon for travel inspiration!</p>
        </div>
    @endif
</x-app-layout>

<style>
    /* ---- Blog intro ---- */
    .blog-intro {
        margin-bottom: 2.5rem;
        font-size: 1.05rem;
        color: var(--text-secondary);
        text-align: center;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    /* ---- Blog Grid ---- */
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 2.5rem;
    }

    .blog-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-lighter);
        transition: all var(--transition);
        display: flex;
        flex-direction: column;
    }

    .blog-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
    }

    .blog-card-accent {
        height: 5px;
        background: linear-gradient(90deg, var(--tunisia-gold) 0%, var(--tunisia-red) 100%);
        width: 100%;
    }

    .blog-card-link {
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .blog-image {
        height: 240px;
        overflow: hidden;
    }

    .blog-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .blog-card:hover .blog-image img {
        transform: scale(1.05);
    }

    .blog-image-placeholder {
        height: 240px;
        background: var(--sand-light);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 2.5rem;
    }

    .blog-content {
        padding: 1.8rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .blog-meta {
        display: flex;
        gap: 1.5rem;
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-bottom: 1rem;
    }

    .blog-meta i {
        margin-right: 0.4rem;
        color: var(--tunisia-gold);
    }

    .blog-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--med-blue);
        margin-bottom: 0.8rem;
        line-height: 1.3;
        transition: color var(--transition);
    }

    .blog-card:hover .blog-title {
        color: var(--tunisia-red);
    }

    .blog-excerpt {
        font-size: 0.9rem;
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 1.5rem;
        flex: 1;
    }

    .blog-read-more {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--tunisia-red);
        color: #fff;
        padding: 0.5rem 1.4rem;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all var(--transition);
        align-self: flex-start;
    }

    .blog-card:hover .blog-read-more {
        gap: 0.8rem;
        background: var(--tunisia-red-dark);
        box-shadow: 0 4px 12px rgba(193, 18, 31, 0.3);
    }

    /* ---- Pagination ---- */
    .pagination-wrapper {
        margin-top: 3rem;
        display: flex;
        justify-content: center;
    }

    /* ---- Empty state ---- */
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
        .blog-grid {
            grid-template-columns: 1fr;
        }
    }
</style>