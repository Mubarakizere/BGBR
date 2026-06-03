@extends('layouts.public')

@section('title', 'Contact Us — BGBR Rwanda')
@section('meta_description', 'Get in touch with the Boys\' and Girls\' Brigade Rwanda. We\'d love to hear from you.')

@section('styles')
<style>
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 48px;
        margin-top: 48px;
    }

    .contact-info-cards {
        display: grid;
        gap: 20px;
    }

    .contact-info-card {
        background: white;
        border-radius: 20px;
        padding: 28px;
        border: 1px solid var(--border);
        display: flex;
        gap: 16px;
        align-items: flex-start;
        transition: all 0.3s;
    }

    .contact-info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    }

    .contact-info-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .contact-info-card h4 {
        font-size: 0.95rem;
        font-weight: 700;
        margin: 0 0 4px;
        color: var(--text);
    }

    .contact-info-card p {
        font-size: 0.85rem;
        color: var(--text-light);
        margin: 0;
        line-height: 1.6;
    }

    .contact-info-card a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }

    .contact-form-wrapper {
        background: white;
        border-radius: 24px;
        padding: 40px;
        border: 1px solid var(--border);
        box-shadow: 0 4px 24px rgba(0,0,0,0.04);
    }

    .contact-form-wrapper h3 {
        font-size: 1.3rem;
        font-weight: 800;
        margin: 0 0 24px;
        color: var(--text);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid var(--border);
        border-radius: 12px;
        font-size: 0.9rem;
        font-family: inherit;
        color: var(--text);
        transition: border-color 0.2s;
        background: var(--bg);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
    }

    textarea.form-input {
        resize: vertical;
        min-height: 120px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-error {
        color: #DC2626;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 4px;
    }

    /* Honeypot field — hidden from humans */
    .hp-field {
        position: absolute;
        left: -9999px;
        opacity: 0;
        height: 0;
        width: 0;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .contact-grid { grid-template-columns: 1fr; }
        .form-row { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
    <div class="pub-page-hero">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you. Reach out to us with any questions or inquiries.</p>
    </div>

    <section class="pub-section">
        <div class="pub-container">
            <div class="contact-grid">
                <!-- Contact Info -->
                <div class="contact-info-cards fade-up">
                    <div class="contact-info-card">
                        <div class="contact-info-icon" style="background:rgba(30,47,163,0.08);color:var(--primary);">
                            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h4>Email</h4>
                            <p><a href="mailto:info@bgbr.rw">info@bgbr.rw</a></p>
                        </div>
                    </div>
                    <div class="contact-info-card">
                        <div class="contact-info-icon" style="background:rgba(34,197,94,0.08);color:#059669;">
                            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <h4>Phone</h4>
                            <p><a href="tel:+250780000000">+250 780 000 000</a></p>
                        </div>
                    </div>
                    <div class="contact-info-card">
                        <div class="contact-info-icon" style="background:rgba(244,197,66,0.12);color:#D4A017;">
                            <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h4>Address</h4>
                            <p>Kigali, Rwanda</p>
                        </div>
                    </div>

                    <div style="background:linear-gradient(135deg,var(--primary),#2a3fcc);border-radius:20px;padding:32px;color:white;margin-top:8px;">
                        <h4 style="font-weight:800;margin:0 0 8px;font-size:1.1rem;">Sure & Steadfast</h4>
                        <p style="color:rgba(255,255,255,0.8);font-size:0.9rem;line-height:1.7;margin:0;">
                            The Boys' and Girls' Brigade Rwanda is committed to empowering youth. Don't hesitate to reach out — we're here to help.
                        </p>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form-wrapper fade-up">
                    <h3>Send us a Message</h3>
                    <form method="POST" action="{{ route('site.contact.submit') }}">
                        @csrf

                        <!-- Honeypot -->
                        <div class="hp-field">
                            <label for="website_url">Website</label>
                            <input type="text" name="website_url" id="website_url" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact_name">Your Name *</label>
                                <input type="text" name="name" id="contact_name" class="form-input" value="{{ old('name') }}" required placeholder="John Doe">
                                @error('name') <div class="form-error">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group">
                                <label for="contact_email">Email Address *</label>
                                <input type="email" name="email" id="contact_email" class="form-input" value="{{ old('email') }}" required placeholder="john@example.com">
                                @error('email') <div class="form-error">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="contact_phone">Phone (optional)</label>
                                <input type="tel" name="phone" id="contact_phone" class="form-input" value="{{ old('phone') }}" placeholder="+250 7XX XXX XXX">
                                @error('phone') <div class="form-error">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group">
                                <label for="contact_subject">Subject *</label>
                                <input type="text" name="subject" id="contact_subject" class="form-input" value="{{ old('subject') }}" required placeholder="How can we help?">
                                @error('subject') <div class="form-error">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="contact_message">Message *</label>
                            <textarea name="message" id="contact_message" class="form-input" required placeholder="Write your message here...">{{ old('message') }}</textarea>
                            @error('message') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="pub-btn pub-btn-primary" style="width:100%;justify-content:center;">
                            Send Message
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
