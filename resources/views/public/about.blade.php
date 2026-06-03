@extends('layouts.public')

@section('title', 'About Us — BGBR Rwanda')
@section('meta_description', 'Learn about the mission, vision, history, and core values of the Boys\' and Girls\' Brigade Rwanda.')

@section('styles')
<style>
    .about-card {
        background: white;
        border-radius: 24px;
        padding: 40px;
        border: 1px solid var(--border);
        transition: all 0.3s;
    }

    .about-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    }

    .about-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .about-card h3 {
        font-size: 1.3rem;
        font-weight: 800;
        margin: 0 0 12px;
        color: var(--text);
    }

    .about-card p {
        color: var(--text-light);
        line-height: 1.8;
        margin: 0;
        font-size: 0.95rem;
    }

    .about-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 28px;
        margin-top: 48px;
    }

    .history-section {
        background: white;
    }

    .history-content {
        max-width: 800px;
        margin: 48px auto 0;
    }

    .history-content p {
        font-size: 1.05rem;
        line-height: 2;
        color: var(--text-light);
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
        margin-top: 48px;
    }

    .value-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 28px;
        text-align: center;
        transition: all 0.3s;
    }

    .value-card:hover {
        border-color: var(--primary);
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(30,47,163,0.1);
    }

    .value-card .value-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(30,47,163,0.05);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .value-card .value-icon svg {
        width: 24px;
        height: 24px;
    }

    .value-card h4 {
        font-size: 0.95rem;
        font-weight: 700;
        margin: 0 0 8px;
        color: var(--text);
    }

    .value-card p {
        font-size: 0.8rem;
        color: var(--text-light);
        margin: 0;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .about-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
    <div class="pub-page-hero">
        <h1>About BGBR Rwanda</h1>
        <p>Empowering youth through Christian values, leadership, and discipline since our founding.</p>
    </div>

    <!-- Mission & Vision -->
    <section class="pub-section">
        <div class="pub-container">
            <div style="text-align:center;">
                <span class="pub-section-label">Who We Are</span>
                <h2 class="pub-section-title">Our Mission & Vision</h2>
            </div>
            <div class="about-grid">
                <div class="about-card">
                    <div class="about-icon" style="background:rgba(30,47,163,0.08);color:var(--primary);">
                        <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3>{{ $mission->title ?? 'Our Mission' }}</h3>
                    <p>{{ $mission->content ?? 'To advance the Kingdom of God among young people by providing opportunities for growth in Christian character, leadership skills, and community service through the Boys\' and Girls\' Brigade movement in Rwanda.' }}</p>
                </div>
                <div class="about-card">
                    <div class="about-icon" style="background:rgba(244,197,66,0.12);color:#D4A017;">
                        <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <h3>{{ $vision->title ?? 'Our Vision' }}</h3>
                    <p>{{ $vision->content ?? 'A generation of young Rwandans who are sure and steadfast in their faith, confident in their leadership abilities, and committed to making a positive impact in their communities and nation.' }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- History -->
    <section class="pub-section history-section">
        <div class="pub-container">
            <div style="text-align:center;">
                <span class="pub-section-label">Our Story</span>
                <h2 class="pub-section-title">{{ $history->title ?? 'Our History' }}</h2>
            </div>
            <div class="history-content">
                <p>{!! nl2br(e($history->content ?? 'The Boys\' and Girls\' Brigade has a rich history of serving youth worldwide. In Rwanda, the Brigade has been a transformative force, providing structured programs that help young people develop their faith, build character, and learn valuable life skills. Through dedicated leaders and committed communities, we continue to grow and make a lasting impact on the lives of Rwandan youth.')) !!}</p>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="pub-section" style="background:#f1f5f9;">
        <div class="pub-container">
            <div style="text-align:center;">
                <span class="pub-section-label">What Guides Us</span>
                <h2 class="pub-section-title">Core Values</h2>
                <p class="pub-section-subtitle" style="margin:0 auto;">The principles that drive everything we do.</p>
            </div>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg></div>
                    <h4>Faith</h4>
                    <p>Rooted in Christian values and Biblical principles.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg></div>
                    <h4>Discipline</h4>
                    <p>Building character through structure and self-control.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                    <h4>Service</h4>
                    <p>Serving communities with compassion and dedication.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg></div>
                    <h4>Leadership</h4>
                    <p>Developing confident and responsible young leaders.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                    <h4>Unity</h4>
                    <p>Fostering togetherness across all backgrounds.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div>
                    <h4>Steadfastness</h4>
                    <p>Sure and steadfast in our commitment to excellence.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
