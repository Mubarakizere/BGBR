@extends('layouts.public')

@section('title', 'Donate — BGBR Rwanda')
@section('meta_description', 'Support the Boys\' and Girls\' Brigade Rwanda. Donations are coming soon.')

@section('styles')
<style>
    .donate-wrapper {
        min-height: 50vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px 24px;
    }

    .donate-card {
        max-width: 520px;
        background: white;
        border-radius: 32px;
        padding: 56px 48px;
        border: 1px solid var(--border);
        box-shadow: 0 8px 40px rgba(0,0,0,0.06);
    }

    .donate-icon {
        width: 80px;
        height: 80px;
        border-radius: 24px;
        background: linear-gradient(135deg, rgba(244,197,66,0.15), rgba(244,197,66,0.05));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 28px;
    }

    .donate-badge {
        display: inline-block;
        background: rgba(244,197,66,0.15);
        color: #B8860B;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 6px 16px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 20px;
    }

    .donate-card h2 {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text);
        margin: 0 0 12px;
        letter-spacing: -0.5px;
    }

    .donate-card p {
        color: var(--text-light);
        font-size: 1rem;
        line-height: 1.8;
        margin: 0 0 32px;
    }
</style>
@endsection

@section('content')
    <div class="pub-page-hero">
        <h1>Support BGBR</h1>
        <p>Your generosity helps us empower the next generation of leaders in Rwanda.</p>
    </div>

    <section class="pub-section">
        <div class="donate-wrapper">
            <div class="donate-card fade-up">
                <div class="donate-icon">
                    <svg width="36" height="36" fill="none" stroke="#D4A017" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <div class="donate-badge">Coming Soon</div>
                <h2>Online Donations</h2>
                <p>We're working on setting up a secure online donation platform. In the meantime, please contact us directly if you'd like to support our mission.</p>
                <a href="{{ route('site.contact') }}" class="pub-btn pub-btn-primary">
                    Contact Us to Donate
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
        </div>
    </section>
@endsection
