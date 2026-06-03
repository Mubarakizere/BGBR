@extends('layouts.public')

@section('title', 'FAQ — BGBR Rwanda')
@section('meta_description', 'Frequently asked questions about the Boys\' and Girls\' Brigade Rwanda.')

@section('styles')
<style>
    .faq-list {
        max-width: 780px;
        margin: 48px auto 0;
        display: grid;
        gap: 12px;
    }

    .faq-item {
        background: white;
        border-radius: 16px;
        border: 1px solid var(--border);
        overflow: hidden;
        transition: all 0.3s;
    }

    .faq-item.open {
        border-color: var(--primary);
        box-shadow: 0 4px 20px rgba(30,47,163,0.08);
    }

    .faq-question {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 20px 24px;
        cursor: pointer;
        user-select: none;
        width: 100%;
        background: none;
        border: none;
        text-align: left;
        font-family: inherit;
    }

    .faq-question h3 {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text);
        margin: 0;
        line-height: 1.4;
    }

    .faq-item.open .faq-question h3 {
        color: var(--primary);
    }

    .faq-toggle {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(30,47,163,0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: var(--primary);
        transition: all 0.3s;
    }

    .faq-item.open .faq-toggle {
        background: var(--primary);
        color: white;
        transform: rotate(45deg);
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.35s ease;
    }

    .faq-answer-inner {
        padding: 0 24px 20px;
        font-size: 0.9rem;
        color: var(--text-light);
        line-height: 1.8;
    }

    .faq-category {
        display: inline-block;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--primary);
        background: rgba(30,47,163,0.06);
        padding: 4px 10px;
        border-radius: 6px;
        margin-bottom: 8px;
    }

    .faq-cta {
        text-align: center;
        margin-top: 64px;
        padding: 48px;
        background: white;
        border-radius: 24px;
        border: 1px solid var(--border);
        max-width: 780px;
        margin-left: auto;
        margin-right: auto;
    }

    .faq-cta h3 {
        font-size: 1.3rem;
        font-weight: 800;
        margin: 0 0 8px;
        color: var(--text);
    }

    .faq-cta p {
        color: var(--text-light);
        margin: 0 0 24px;
    }
</style>
@endsection

@section('content')
    <div class="pub-page-hero">
        <h1>Frequently Asked Questions</h1>
        <p>Find answers to common questions about BGBR Rwanda.</p>
    </div>

    <section class="pub-section">
        <div class="pub-container">
            @if($faqs->count())
            <div class="faq-list">
                @foreach($faqs as $faq)
                <div class="faq-item fade-up" id="faq-{{ $faq->id }}">
                    <button class="faq-question" onclick="toggleFaq('faq-{{ $faq->id }}')">
                        <div>
                            @if($faq->category)
                                <div class="faq-category">{{ $faq->category }}</div>
                            @endif
                            <h3>{{ $faq->question }}</h3>
                        </div>
                        <div class="faq-toggle">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v12m6-6H6"/></svg>
                        </div>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            {!! nl2br(e($faq->answer)) !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div style="text-align:center;padding:60px 0;">
                <div style="width:80px;height:80px;border-radius:20px;background:rgba(30,47,163,0.06);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;color:var(--primary);">
                    <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 style="font-weight:700;margin:0 0 8px;">FAQ Coming Soon</h3>
                <p style="color:var(--text-light);">We're preparing answers to common questions.</p>
            </div>
            @endif

            <div class="faq-cta fade-up">
                <h3>Still have questions?</h3>
                <p>We're here to help. Don't hesitate to reach out.</p>
                <a href="{{ route('site.contact') }}" class="pub-btn pub-btn-primary">Contact Us</a>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    function toggleFaq(id) {
        const item = document.getElementById(id);
        const answer = item.querySelector('.faq-answer');
        const isOpen = item.classList.contains('open');

        // Close all
        document.querySelectorAll('.faq-item.open').forEach(openItem => {
            openItem.classList.remove('open');
            openItem.querySelector('.faq-answer').style.maxHeight = '0';
        });

        // Open clicked (if it was closed)
        if (!isOpen) {
            item.classList.add('open');
            answer.style.maxHeight = answer.scrollHeight + 'px';
        }
    }
</script>
@endsection
