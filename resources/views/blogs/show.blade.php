<x-app-layout>
    <x-slot name="header">
        {{ $blog->title }}
    </x-slot>

    <div class="blog-article-container">
        <article class="blog-article-card">
            @if($blog->featured_image)
                <div class="article-hero">
                    <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}">
                    <div class="article-hero-overlay"></div>
                    <div class="article-hero-meta">
                        <span><i class="far fa-calendar-alt"></i> {{ $blog->published_at->format('F j, Y') }}</span>
                        <span><i class="far fa-user"></i> {{ $blog->user->name }}</span>
                    </div>
                </div>
            @endif

            <div class="article-body">
                <div class="article-meta-bar">
                    <span class="meta-item"><i class="far fa-calendar-alt"></i>
                        {{ $blog->published_at->format('F j, Y') }}</span>
                    <span class="meta-item"><i class="far fa-user"></i> {{ __('By') }} {{ $blog->user->name }}</span>
                    <span class="meta-item"><i class="far fa-clock"></i>
                        {{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} min read</span>
                </div>

                @if($blog->excerpt)
                    <div class="excerpt-pullquote">
                        <i class="fas fa-quote-left"></i> {{ $blog->excerpt }}
                    </div>
                @endif

                <div class="article-content">
                    {!! nl2br(e($blog->content)) !!}
                </div>

                <div class="article-footer">
                    <a href="{{ route('blog.index') }}" class="back-link-alt">
                        <i class="fas fa-arrow-left"></i> {{ __('Back to all posts') }}
                    </a>
                    <div class="share-buttons">
                        <span>Share:</span>
                        <a href="#" aria-label="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Share on Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Share on Pinterest"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </article>
    </div>
</x-app-layout>

<style>
    /* ---- Container ---- */
    .blog-article-container {
        max-width: 860px;
        margin: 0 auto;
    }

    .blog-article-card {
        background: var(--white);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-lighter);
    }

    /* ---- Hero image ---- */
    .article-hero {
        position: relative;
        height: 420px;
        overflow: hidden;
    }

    .article-hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .article-hero-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60%;
        background: linear-gradient(to top, rgba(27, 42, 74, 0.85), transparent);
    }

    .article-hero-meta {
        position: absolute;
        bottom: 2rem;
        left: 2rem;
        display: flex;
        gap: 2rem;
        color: #fff;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .article-hero-meta i {
        margin-right: 0.4rem;
        color: var(--tunisia-gold);
    }

    /* ---- Body ---- */
    .article-body {
        padding: 2.5rem 2rem;
    }

    .article-meta-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 1.2rem;
        border-bottom: 1px solid var(--border-lighter);
        font-size: 0.9rem;
        color: var(--text-secondary);
    }

    .meta-item i {
        margin-right: 0.3rem;
        color: var(--tunisia-gold);
    }

    .excerpt-pullquote {
        background: var(--sand-light);
        border-left: 5px solid var(--tunisia-gold);
        padding: 1.5rem 2rem;
        margin-bottom: 2.5rem;
        font-family: 'Playfair Display', serif;
        font-style: italic;
        font-size: 1.2rem;
        color: var(--med-blue);
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        line-height: 1.6;
    }

    .excerpt-pullquote i {
        color: var(--tunisia-gold);
        margin-right: 0.5rem;
        font-size: 1rem;
    }

    .article-content {
        font-size: 1.05rem;
        line-height: 1.8;
        color: var(--text-primary);
    }

    .article-content p {
        margin-bottom: 1.5rem;
    }

    /* Drop cap on first paragraph */
    .article-content p:first-of-type::first-letter {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        font-weight: 700;
        float: left;
        line-height: 1;
        margin-right: 0.5rem;
        color: var(--tunisia-red);
    }

    /* ---- Footer ---- */
    .article-footer {
        margin-top: 3rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border-lighter);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .back-link-alt {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--tunisia-red);
        text-decoration: none;
        font-weight: 600;
        transition: gap 0.2s;
    }

    .back-link-alt:hover {
        gap: 0.8rem;
        text-decoration: underline;
    }

    .share-buttons {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: var(--text-muted);
    }

    .share-buttons a {
        color: var(--text-muted);
        font-size: 1.1rem;
        transition: color var(--transition);
    }

    .share-buttons a:hover {
        color: var(--tunisia-gold);
    }

    @media (max-width: 768px) {
        .article-hero {
            height: 280px;
        }

        .article-hero-meta {
            bottom: 1rem;
            left: 1rem;
            flex-direction: column;
            gap: 0.3rem;
        }

        .article-body {
            padding: 2rem 1.5rem;
        }

        .article-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .article-content p:first-of-type::first-letter {
            font-size: 2.8rem;
        }
    }
</style>