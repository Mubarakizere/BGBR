@extends('layouts.public')

@section('title', 'BGBR Rwanda — Sure & Steadfast')
@section('meta_description', 'The Boys\' and Girls\' Brigade Rwanda — Empowering youth through Christian values, leadership, and discipline.')

@section('styles')
<style>
    /* Hero Carousel */
    .hero-carousel {
        position: relative;
        height: 100vh;
        min-height: 600px;
        background: var(--text);
    }

    .carousel-slides {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .carousel-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 1s ease-in-out;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .carousel-slide.active {
        opacity: 1;
        z-index: 1;
    }

    /* Add overlay to images for text readability */
    .carousel-slide::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(10, 15, 58, 0.8) 0%, rgba(10, 15, 58, 0.4) 100%);
    }

    .hero-content-wrapper {
        position: absolute;
        inset: 0;
        z-index: 2;
        display: flex;
        align-items: center;
    }

    .hero-content {
        max-width: 800px;
        padding: 0 24px;
        color: white;
    }

    .hero-title {
        font-size: clamp(2.5rem, 5vw, 4.5rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 24px;
        color: white;
    }

    .hero-title .highlight {
        color: var(--secondary);
    }

    .hero-desc {
        font-size: 1.125rem;
        line-height: 1.6;
        margin-bottom: 40px;
        max-width: 600px;
        color: rgba(255, 255, 255, 0.9);
    }

    .carousel-controls {
        position: absolute;
        bottom: 120px;
        left: 24px;
        z-index: 2;
        display: flex;
        gap: 12px;
    }
    
    @media (min-width: 1280px) {
        .carousel-controls {
            left: calc((100vw - 1280px) / 2 + 24px);
        }
    }

    .carousel-dot {
        width: 40px;
        height: 4px;
        background: rgba(255, 255, 255, 0.3);
        cursor: pointer;
        transition: background 0.3s;
    }

    .carousel-dot.active {
        background: var(--secondary);
    }

    /* Hero Stats Bar */
    .hero-stats-wrapper {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 10;
        transform: translateY(50%);
        padding: 0 24px;
    }

    .hero-stats {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border);
    }

    .hero-stat {
        padding: 32px 24px;
        text-align: center;
        border-right: 1px solid var(--border);
    }

    .hero-stat:last-child {
        border-right: none;
    }

    .hero-stat-icon {
        color: var(--primary);
        margin-bottom: 16px;
    }

    .hero-stat-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--text);
        margin-bottom: 4px;
    }

    .hero-stat-label {
        font-size: 0.875rem;
        color: var(--text-light);
        font-weight: 500;
    }

    /* Clean Mission Section */
    .mission-section {
        background: white;
        padding-top: 180px; /* space for stats overlap */
        padding-bottom: 100px;
    }

    .mission-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 64px;
        align-items: center;
    }

    .mission-image {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
    }

    .mission-image img {
        width: 100%;
        height: auto;
        display: block;
    }

    .mission-content h2 {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 24px;
    }

    .mission-content p {
        font-size: 1.125rem;
        color: var(--text-light);
        line-height: 1.7;
        margin-bottom: 32px;
    }

    .value-list {
        display: grid;
        gap: 24px;
    }

    .value-item {
        display: flex;
        gap: 16px;
        align-items: flex-start;
    }

    .value-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        flex-shrink: 0;
    }

    .value-text h4 {
        font-size: 1.125rem;
        font-weight: 700;
        margin: 0 0 8px 0;
        color: var(--text);
    }

    .value-text p {
        font-size: 0.95rem;
        color: var(--text-light);
        margin: 0;
    }

    /* Clean Events & News */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 40px;
    }

    .section-title h2 {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--text);
        margin: 0;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 32px;
    }

    .content-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--border);
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
        display: flex;
        flex-direction: column;
    }

    .content-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
    }

    .card-img {
        height: 240px;
        background: var(--bg);
        position: relative;
    }

    .card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-body {
        padding: 24px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-meta {
        font-size: 0.875rem;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 12px;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 12px 0;
        line-height: 1.4;
    }

    .card-text {
        color: var(--text-light);
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0;
        flex: 1;
    }

    /* Simple CTA */
    .simple-cta {
        background: var(--bg);
        border-top: 1px solid var(--border);
        padding: 100px 24px;
        text-align: center;
        color: var(--text);
    }

    .simple-cta h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0 0 16px 0;
        color: var(--text);
    }

    .simple-cta p {
        font-size: 1.125rem;
        color: var(--text-light);
        max-width: 600px;
        margin: 0 auto 32px;
    }

    @media (max-width: 992px) {
        .mission-grid { grid-template-columns: 1fr; }
        .hero-stats { grid-template-columns: repeat(2, 1fr); }
        .hero-stats-wrapper { position: static; transform: none; margin-top: -40px; }
        .mission-section { padding-top: 80px; }
    }

    @media (max-width: 768px) {
        .hero-stats { grid-template-columns: 1fr; }
        .section-header { flex-direction: column; align-items: flex-start; gap: 16px; }
    }
</style>
@endsection

@section('content')
    <!-- Hero Slider -->
    <section class="hero-carousel" id="heroCarousel">
        <div class="carousel-slides">
            @if($heroImages->count() > 0)
                @foreach($heroImages as $index => $image)
                    <div class="carousel-slide {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ asset('storage/' . $image->image_path) }}');"></div>
                @endforeach
            @else
                <!-- Fallback Defaults -->
                <div class="carousel-slide active" style="background-image: url('https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&q=80&w=1920');"></div>
                <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1529390079861-591de354faf5?auto=format&fit=crop&q=80&w=1920');"></div>
                <div class="carousel-slide" style="background-image: url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&q=80&w=1920');"></div>
            @endif
        </div>

        <div class="hero-content-wrapper pub-container">
            <div class="hero-content">
                <h1 class="hero-title">
                    {{ $hero->title ?? "The Boys' & Girls' Brigade Rwanda" }}
                </h1>
                <p class="hero-desc">{{ $hero->content ?? "Sure & Steadfast. Empowering youth through Christian values, leadership development, and discipline for a brighter future." }}</p>
                <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                    <a href="{{ route('site.about') }}" class="pub-btn pub-btn-secondary">Discover Our Mission</a>
                    <a href="{{ route('site.contact') }}" class="pub-btn" style="background: white; color: var(--primary);">Get In Touch</a>
                </div>
            </div>
        </div>

        <div class="carousel-controls">
            @if($heroImages->count() > 0)
                @foreach($heroImages as $index => $image)
                    <div class="carousel-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})"></div>
                @endforeach
            @else
                <div class="carousel-dot active" onclick="goToSlide(0)"></div>
                <div class="carousel-dot" onclick="goToSlide(1)"></div>
                <div class="carousel-dot" onclick="goToSlide(2)"></div>
            @endif
        </div>

        <!-- Overlapping Stats Bar -->
        <div class="hero-stats-wrapper">
            <div class="hero-stats">
                <div class="hero-stat">
                    <svg class="hero-stat-icon" width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <div class="hero-stat-value">Growing</div>
                    <div class="hero-stat-label">Youth Community</div>
                </div>
                <div class="hero-stat">
                    <svg class="hero-stat-icon" width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <div class="hero-stat-value">Across Rwanda</div>
                    <div class="hero-stat-label">Active Companies</div>
                </div>
                <div class="hero-stat">
                    <svg class="hero-stat-icon" width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <div class="hero-stat-value">Year-Round</div>
                    <div class="hero-stat-label">Activities & Camps</div>
                </div>
                <div class="hero-stat">
                    <svg class="hero-stat-icon" width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <div class="hero-stat-value">Faith Based</div>
                    <div class="hero-stat-label">Core Values</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="mission-section">
        <div class="pub-container mission-grid">
            <div class="mission-image">
                <img src="https://images.unsplash.com/photo-1544654803-b69140b285a1?auto=format&fit=crop&q=80&w=1000" alt="BGBR Activities">
            </div>
            <div class="mission-content">
                <h2>{{ $mission->title ?? 'Building Tomorrow\'s Leaders' }}</h2>
                <p>{{ $mission->content ?? 'To advance the Kingdom of God among young people by providing opportunities for growth in Christian character, leadership skills, and community service through the Boys\' and Girls\' Brigade movement in Rwanda.' }}</p>
                
                <div class="value-list">
                    <div class="value-item">
                        <div class="value-icon"><svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg></div>
                        <div class="value-text">
                            <h4>Christian Foundation</h4>
                            <p>Grounded in Biblical principles, nurturing spiritual growth and moral integrity.</p>
                        </div>
                    </div>
                    <div class="value-item">
                        <div class="value-icon"><svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div>
                        <div class="value-text">
                            <h4>Leadership Development</h4>
                            <p>Equipping youth with skills to lead with confidence and a heart for service.</p>
                        </div>
                    </div>
                    <div class="value-item">
                        <div class="value-icon"><svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                        <div class="value-text">
                            <h4>Community & Discipline</h4>
                            <p>Building strong communities through discipline, teamwork, and mutual respect.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Events -->
    @if($featuredEvents->count())
    <section class="pub-section" style="background: var(--bg);">
        <div class="pub-container">
            <div class="section-header">
                <div class="section-title">
                    <h2>Upcoming Events</h2>
                </div>
                <a href="{{ route('site.events') }}" class="pub-btn pub-btn-outline">View All Events</a>
            </div>
            
            <div class="cards-grid">
                @foreach($featuredEvents as $event)
                <a href="{{ route('site.events') }}" class="content-card">
                    <div class="card-img">
                        @if($event->image_path)
                            <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#E4E7EC;color:#98A2B3;">
                                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="card-meta">{{ $event->event_date->format('F d, Y') }}</div>
                        <h3 class="card-title">{{ $event->title }}</h3>
                        <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                        @if($event->location)
                        <div style="margin-top:16px;font-size:0.875rem;color:var(--text-light);display:flex;align-items:center;gap:6px;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $event->location }}
                        </div>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Latest News -->
    @if($latestNews->count())
    <section class="pub-section" style="background: white;">
        <div class="pub-container">
            <div class="section-header">
                <div class="section-title">
                    <h2>Latest News</h2>
                </div>
                <a href="{{ route('site.news') }}" class="pub-btn pub-btn-outline">Read All News</a>
            </div>
            
            <div class="cards-grid">
                @foreach($latestNews as $article)
                <a href="{{ route('site.news.show', $article->slug) }}" class="content-card">
                    <div class="card-img">
                        @if($article->image_path)
                            <img src="{{ asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#E4E7EC;color:#98A2B3;">
                                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="card-meta">
                            @if($article->published_at)
                                {{ $article->published_at->format('M d, Y') }}
                            @endif
                        </div>
                        <h3 class="card-title">{{ $article->title }}</h3>
                        <p class="card-text">{{ Str::limit($article->excerpt ?? strip_tags($article->content), 120) }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Simple CTA -->
    <section class="simple-cta">
        <div class="pub-container">
            <h2>Ready to Make a Difference?</h2>
            <p>Join the Brigade and be part of a movement that transforms young lives across Rwanda.</p>
            <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
                <a href="{{ route('site.contact') }}" class="pub-btn pub-btn-primary">Contact Us</a>
                <a href="{{ route('site.about') }}" class="pub-btn pub-btn-outline">Learn More</a>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    // Hero Slider Logic
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.carousel-dot');
    
    function goToSlide(index) {
        slides[currentSlide].classList.remove('active');
        dots[currentSlide].classList.remove('active');
        
        currentSlide = index;
        
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }
    
    // Auto advance every 5 seconds
    setInterval(() => {
        let nextSlide = (currentSlide + 1) % slides.length;
        goToSlide(nextSlide);
    }, 5000);
</script>
@endsection
