@extends('layouts.public')

@section('title', 'Events — BGBR Rwanda')
@section('meta_description', 'Upcoming and past events from the Boys\' and Girls\' Brigade Rwanda.')

@section('styles')
<style>
    .events-tabs {
        display: flex;
        gap: 4px;
        margin-bottom: 40px;
        background: var(--border);
        border-radius: 14px;
        padding: 4px;
        width: fit-content;
    }

    .events-tab {
        padding: 10px 24px;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        background: transparent;
        color: var(--text-light);
        transition: all 0.2s;
    }

    .events-tab.active {
        background: white;
        color: var(--primary);
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .events-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
        gap: 28px;
    }

    .event-item {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid var(--border);
        transition: all 0.3s;
    }

    .event-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    }

    .event-img {
        height: 200px;
        background: linear-gradient(135deg, var(--primary), #3B82F6);
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .event-img img { width: 100%; height: 100%; object-fit: cover; }

    .event-date-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        background: white;
        border-radius: 12px;
        padding: 8px 12px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .event-date-badge .month {
        font-size: 0.6rem;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--primary);
        letter-spacing: 1px;
    }

    .event-date-badge .day {
        font-size: 1.3rem;
        font-weight: 900;
        color: var(--text);
        line-height: 1;
    }

    .event-featured-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        background: var(--secondary);
        color: var(--primary);
        font-size: 0.65rem;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .event-body {
        padding: 24px;
    }

    .event-body h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0 0 8px;
        color: var(--text);
    }

    .event-body p {
        font-size: 0.875rem;
        color: var(--text-light);
        line-height: 1.7;
        margin: 0 0 12px;
    }

    .event-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 0.8rem;
        color: var(--text-light);
    }

    .event-meta span {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .past-overlay {
        opacity: 0.7;
    }

    @media (max-width: 768px) {
        .events-list { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
    <div class="pub-page-hero">
        <h1>Events & Activities</h1>
        <p>Join us in building a stronger community through meaningful programs and gatherings.</p>
    </div>

    <section class="pub-section">
        <div class="pub-container">
            <!-- Upcoming Events -->
            @if($upcoming->count())
            <div class="fade-up">
                <span class="pub-section-label">Upcoming</span>
                <h2 class="pub-section-title">Upcoming Events</h2>
            </div>
            <div class="events-list" style="margin-top:32px;margin-bottom:80px;">
                @foreach($upcoming as $event)
                <div class="event-item fade-up">
                    <div class="event-img">
                        @if($event->image_path)
                            <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}">
                        @else
                            <svg width="48" height="48" fill="none" stroke="white" viewBox="0 0 24 24" style="opacity:0.3"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        @endif
                        <div class="event-date-badge">
                            <div class="month">{{ $event->event_date->format('M') }}</div>
                            <div class="day">{{ $event->event_date->format('d') }}</div>
                        </div>
                        @if($event->is_featured)
                            <div class="event-featured-badge">Featured</div>
                        @endif
                    </div>
                    <div class="event-body">
                        <h3>{{ $event->title }}</h3>
                        <p>{{ Str::limit($event->description, 160) }}</p>
                        <div class="event-meta">
                            @if($event->location)
                            <span>
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ $event->location }}
                            </span>
                            @endif
                            @if($event->end_date)
                            <span>
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Until {{ $event->end_date->format('M d, Y') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Past Events -->
            @if($past->count())
            <div class="fade-up">
                <span class="pub-section-label">Past</span>
                <h2 class="pub-section-title">Past Events</h2>
            </div>
            <div class="events-list" style="margin-top:32px;">
                @foreach($past as $event)
                <div class="event-item past-overlay fade-up">
                    <div class="event-img">
                        @if($event->image_path)
                            <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}">
                        @else
                            <svg width="48" height="48" fill="none" stroke="white" viewBox="0 0 24 24" style="opacity:0.3"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        @endif
                        <div class="event-date-badge">
                            <div class="month">{{ $event->event_date->format('M') }}</div>
                            <div class="day">{{ $event->event_date->format('d') }}</div>
                        </div>
                    </div>
                    <div class="event-body">
                        <h3>{{ $event->title }}</h3>
                        <p>{{ Str::limit($event->description, 160) }}</p>
                        @if($event->location)
                        <div class="event-meta">
                            <span>
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                {{ $event->location }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if(!$upcoming->count() && !$past->count())
            <div style="text-align:center;padding:60px 0;">
                <div style="width:80px;height:80px;border-radius:20px;background:rgba(30,47,163,0.06);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;color:var(--primary);">
                    <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 style="font-weight:700;margin:0 0 8px;">Events Coming Soon</h3>
                <p style="color:var(--text-light);">Check back soon for upcoming events and activities.</p>
            </div>
            @endif
        </div>
    </section>
@endsection
