@extends('layouts.public')

@section('title', 'Leadership — BGBR Rwanda')
@section('meta_description', 'Meet the leadership team of the Boys\' and Girls\' Brigade Rwanda.')

@section('styles')
<style>
    .leaders-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 32px;
        margin-top: 48px;
    }

    .leader-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid var(--border);
        transition: all 0.4s ease;
        text-align: center;
    }

    .leader-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 48px rgba(0,0,0,0.1);
        border-color: transparent;
    }

    .leader-photo {
        width: 100%;
        height: 280px;
        background: linear-gradient(135deg, var(--primary), #3B82F6);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .leader-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s;
    }

    .leader-card:hover .leader-photo img {
        transform: scale(1.05);
    }

    .leader-photo .placeholder-icon {
        color: rgba(255,255,255,0.3);
    }

    .leader-info {
        padding: 24px;
    }

    .leader-info h3 {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--text);
        margin: 0 0 4px;
    }

    .leader-info .title {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .leader-info .bio {
        font-size: 0.85rem;
        color: var(--text-light);
        line-height: 1.7;
        margin: 0;
    }

    .empty-state {
        text-align: center;
        padding: 80px 24px;
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        background: rgba(30,47,163,0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: var(--primary);
    }
</style>
@endsection

@section('content')
    <div class="pub-page-hero">
        <h1>Our Leadership</h1>
        <p>Meet the dedicated leaders guiding BGBR Rwanda's mission.</p>
    </div>

    <section class="pub-section">
        <div class="pub-container">
            @if($leaders->count())
                <div class="leaders-grid">
                    @foreach($leaders as $leader)
                    <div class="leader-card fade-up">
                        <div class="leader-photo">
                            @if($leader->photo_path)
                                <img src="{{ asset('storage/' . $leader->photo_path) }}" alt="{{ $leader->name }}">
                            @else
                                <svg class="placeholder-icon" width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            @endif
                        </div>
                        <div class="leader-info">
                            <h3>{{ $leader->name }}</h3>
                            <div class="title">{{ $leader->title }}</div>
                            @if($leader->bio)
                                <p class="bio">{{ Str::limit($leader->bio, 150) }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state fade-up">
                    <div class="empty-state-icon">
                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 style="font-weight:700;color:var(--text);margin:0 0 8px;">Leadership Team Coming Soon</h3>
                    <p style="color:var(--text-light);">Our leadership team profiles will be published shortly.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
