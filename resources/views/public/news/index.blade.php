@extends('layouts.public')

@section('title', 'News — BGBR Rwanda')
@section('meta_description', 'Latest news, updates, and stories from the Boys\' and Girls\' Brigade Rwanda.')

@section('styles')
<style>
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 28px;
        margin-top: 48px;
    }

    .news-item {
        text-decoration: none;
        color: inherit;
    }

    .news-img {
        height: 220px;
        overflow: hidden;
        background: linear-gradient(135deg, var(--primary), #3B82F6);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .news-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s;
    }

    .pub-card:hover .news-img img {
        transform: scale(1.05);
    }

    .news-body {
        padding: 24px;
    }

    .news-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.75rem;
        color: var(--text-light);
        margin-bottom: 12px;
    }

    .news-body h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0 0 8px;
        line-height: 1.4;
        color: var(--text);
    }

    .news-body p {
        font-size: 0.875rem;
        color: var(--text-light);
        line-height: 1.7;
        margin: 0;
    }

    .news-read-more {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 16px;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--primary);
    }

    .pagination-wrapper {
        margin-top: 48px;
        display: flex;
        justify-content: center;
    }

    .pagination-wrapper nav > div:first-child { display: none; }

    @media (max-width: 768px) {
        .news-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
    <div class="pub-page-hero">
        <h1>News & Updates</h1>
        <p>Stay informed with the latest from BGBR Rwanda.</p>
    </div>

    <section class="pub-section">
        <div class="pub-container">
            @if($articles->count())
            <div class="news-grid">
                @foreach($articles as $article)
                <a href="{{ route('site.news.show', $article->slug) }}" class="pub-card news-item fade-up">
                    <div class="news-img">
                        @if($article->image_path)
                            <img src="{{ asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}">
                        @else
                            <svg width="48" height="48" fill="none" stroke="white" viewBox="0 0 24 24" style="opacity:0.3"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        @endif
                    </div>
                    <div class="news-body">
                        <div class="news-meta">
                            @if($article->published_at)
                                <span>{{ $article->published_at->format('M d, Y') }}</span>
                            @endif
                            @if($article->author_name)
                                <span>&bull; {{ $article->author_name }}</span>
                            @endif
                        </div>
                        <h3>{{ $article->title }}</h3>
                        <p>{{ Str::limit($article->excerpt ?? strip_tags($article->content), 140) }}</p>
                        <div class="news-read-more">
                            Read More
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $articles->links() }}
            </div>
            @else
            <div style="text-align:center;padding:60px 0;">
                <div style="width:80px;height:80px;border-radius:20px;background:rgba(30,47,163,0.06);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;color:var(--primary);">
                    <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <h3 style="font-weight:700;margin:0 0 8px;">No News Yet</h3>
                <p style="color:var(--text-light);">Stay tuned for the latest news and updates.</p>
            </div>
            @endif
        </div>
    </section>
@endsection
