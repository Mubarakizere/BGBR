@extends('layouts.public')

@section('title', $article->title . ' — BGBR Rwanda')
@section('meta_description', Str::limit($article->excerpt ?? strip_tags($article->content), 160))

@section('styles')
<style>
    .article-hero {
        height: 400px;
        background: linear-gradient(135deg, var(--primary), #3B82F6);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: flex-end;
    }

    .article-hero img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .article-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 60%);
    }

    .article-hero-content {
        position: relative;
        z-index: 1;
        padding: 40px;
        max-width: 800px;
    }

    .article-hero-content h1 {
        font-size: 2.2rem;
        font-weight: 800;
        color: white;
        margin: 0 0 16px;
        line-height: 1.2;
    }

    .article-hero-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 0.85rem;
        color: rgba(255,255,255,0.8);
    }

    .article-content {
        max-width: 780px;
        margin: 0 auto;
        padding: 48px 24px;
    }

    .article-content .body {
        font-size: 1.05rem;
        line-height: 2;
        color: #374151;
    }

    .article-content .body p {
        margin-bottom: 1.5em;
    }

    .article-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary);
        font-weight: 700;
        font-size: 0.875rem;
        text-decoration: none;
        margin-bottom: 32px;
        transition: gap 0.2s;
    }

    .article-back:hover { gap: 12px; }

    .related-section {
        background: #f1f5f9;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 24px;
        margin-top: 32px;
    }

    .related-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--border);
        text-decoration: none;
        transition: all 0.3s;
    }

    .related-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }

    .related-card-body {
        padding: 20px;
    }

    .related-card-body h3 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 4px;
        line-height: 1.4;
    }

    .related-card-body p {
        font-size: 0.8rem;
        color: var(--text-light);
        margin: 0;
    }
</style>
@endsection

@section('content')
    <div class="article-hero" style="margin-top:72px;">
        @if($article->image_path)
            <img src="{{ asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}">
        @endif
        <div class="article-hero-content">
            <h1>{{ $article->title }}</h1>
            <div class="article-hero-meta">
                @if($article->published_at)
                    <span>{{ $article->published_at->format('F j, Y') }}</span>
                @endif
                @if($article->author_name)
                    <span>&bull; By {{ $article->author_name }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="article-content">
        <a href="{{ route('site.news') }}" class="article-back">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
            Back to News
        </a>

        <div class="body">
            {!! nl2br(e($article->content)) !!}
        </div>
    </div>

    @if($related->count())
    <section class="pub-section related-section">
        <div class="pub-container">
            <span class="pub-section-label">Related</span>
            <h2 class="pub-section-title" style="font-size:1.8rem;">More Articles</h2>
            <div class="related-grid">
                @foreach($related as $rel)
                <a href="{{ route('site.news.show', $rel->slug) }}" class="related-card">
                    <div class="related-card-body">
                        <h3>{{ $rel->title }}</h3>
                        <p>{{ $rel->published_at?->format('M d, Y') }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endsection
