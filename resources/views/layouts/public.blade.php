<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'BGBR Rwanda — Sure & Steadfast')</title>
    <meta name="description" content="@yield('meta_description', 'The Boys\' and Girls\' Brigade Rwanda — Empowering youth through Christian values, leadership, and discipline.')">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/logo.jpg') }}" type="image/jpeg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #1E2FA3;
            --primary-dark: #161f75;
            --secondary: #F4C542;
            --secondary-light: #FFE270;
            --accent: #8BC665;
            --text: #101828;
            --text-light: #667085;
            --bg: #F8FAFC;
            --surface: #FFFFFF;
            --border: #E4E7EC;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text);
            background: var(--bg);
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        /* ===== PUBLIC NAVBAR ===== */
        .pub-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.35s ease;
            padding: 0 1.5rem;
        }

        .pub-nav.scrolled {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 1px 20px rgba(0,0,0,0.08);
        }

        .pub-nav-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
        }

        .pub-nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .pub-nav-logo img {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            object-fit: contain;
            background: white;
            padding: 3px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .pub-nav-logo span {
            font-weight: 800;
            font-size: 1.25rem;
            letter-spacing: -0.5px;
            color: white;
            text-shadow: 0 1px 4px rgba(0,0,0,0.2);
            transition: color 0.3s;
        }

        .pub-nav.scrolled .pub-nav-logo span {
            color: var(--primary);
            text-shadow: none;
        }

        .pub-nav-links {
            display: flex;
            align-items: center;
            gap: 2px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .pub-nav-links a {
            padding: 8px 16px;
            font-size: 0.875rem;
            font-weight: 600;
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .pub-nav-links a:hover,
        .pub-nav-links a.active {
            background: rgba(255,255,255,0.15);
            color: white;
        }

        .pub-nav.scrolled .pub-nav-links a {
            color: var(--text);
        }

        .pub-nav.scrolled .pub-nav-links a:hover,
        .pub-nav.scrolled .pub-nav-links a.active {
            background: var(--primary);
            color: white;
        }

        .pub-nav-cta {
            padding: 10px 24px !important;
            background: var(--secondary) !important;
            color: var(--primary) !important;
            font-weight: 700 !important;
            border-radius: 50px !important;
            box-shadow: 0 2px 12px rgba(244,197,66,0.4);
            transition: all 0.25s !important;
        }

        .pub-nav-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(244,197,66,0.5) !important;
            background: var(--secondary-light) !important;
        }

        /* Mobile menu */
        .pub-nav-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            color: white;
            transition: color 0.3s;
        }

        .pub-nav.scrolled .pub-nav-toggle { color: var(--primary); }

        .pub-nav-toggle svg { width: 28px; height: 28px; }

        .pub-mobile-menu {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 999;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
        }

        .pub-mobile-menu.open { display: block; }

        .pub-mobile-panel {
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            max-width: 85vw;
            height: 100%;
            background: white;
            box-shadow: -4px 0 30px rgba(0,0,0,0.15);
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }

        .pub-mobile-panel a {
            display: block;
            padding: 14px 16px;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s;
        }

        .pub-mobile-panel a:hover,
        .pub-mobile-panel a.active {
            background: var(--primary);
            color: white;
        }

        .pub-mobile-close {
            align-self: flex-end;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-light);
            padding: 8px;
            margin-bottom: 16px;
        }

        @media (max-width: 768px) {
            .pub-nav-links { display: none; }
            .pub-nav-toggle { display: block; }
        }

        /* ===== FOOTER ===== */
        .pub-footer {
            background: linear-gradient(135deg, #0a0f3a 0%, var(--primary-dark) 50%, var(--primary) 100%);
            color: white;
            padding: 80px 24px 32px;
        }

        .pub-footer-grid {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 48px;
        }

        .pub-footer h3 {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--secondary);
            margin-bottom: 20px;
        }

        .pub-footer-brand p {
            color: rgba(255,255,255,0.7);
            font-size: 0.9rem;
            line-height: 1.7;
            margin-top: 16px;
        }

        .pub-footer a {
            display: block;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.875rem;
            padding: 5px 0;
            transition: all 0.2s;
        }

        .pub-footer a:hover {
            color: var(--secondary);
            padding-left: 4px;
        }

        .pub-footer-bottom {
            max-width: 1280px;
            margin: 48px auto 0;
            padding-top: 24px;
            border-top: 1px solid rgba(255,255,255,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.4);
        }

        @media (max-width: 768px) {
            .pub-footer-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }
            .pub-footer-bottom {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }
        }

        /* ===== SHARED UTILITIES ===== */
        .pub-section {
            padding: 100px 24px;
        }

        .pub-container {
            max-width: 1280px;
            margin: 0 auto;
        }

        .pub-section-label {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--primary);
            background: rgba(30,47,163,0.08);
            padding: 6px 16px;
            border-radius: 50px;
            margin-bottom: 16px;
        }

        .pub-section-title {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -1px;
            line-height: 1.15;
            color: var(--text);
            margin: 0 0 16px;
        }

        .pub-section-subtitle {
            font-size: 1.1rem;
            color: var(--text-light);
            max-width: 600px;
            line-height: 1.7;
        }

        .pub-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            font-size: 0.9rem;
            font-weight: 700;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.25s;
            border: none;
            cursor: pointer;
        }

        .pub-btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 16px rgba(30,47,163,0.3);
        }

        .pub-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(30,47,163,0.4);
        }

        .pub-btn-secondary {
            background: var(--secondary);
            color: var(--primary);
            box-shadow: 0 4px 16px rgba(244,197,66,0.3);
        }

        .pub-btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(244,197,66,0.4);
        }

        .pub-btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--border);
        }

        .pub-btn-outline:hover {
            border-color: var(--primary);
            background: rgba(30,47,163,0.04);
        }

        .pub-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
        }

        .pub-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.08);
            border-color: transparent;
        }

        /* Flash messages */
        .pub-flash {
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            padding: 14px 28px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
            animation: flashIn 0.4s ease, flashOut 0.4s ease 4s forwards;
        }

        .pub-flash-success { background: #059669; color: white; }
        .pub-flash-error { background: #DC2626; color: white; }

        @keyframes flashIn {
            from { opacity: 0; transform: translateX(-50%) translateY(-20px); }
            to { opacity: 1; transform: translateX(-50%) translateY(0); }
        }

        @keyframes flashOut {
            from { opacity: 1; }
            to { opacity: 0; pointer-events: none; }
        }

        /* Page hero */
        .pub-page-hero {
            background: linear-gradient(135deg, var(--primary) 0%, #2a3fcc 50%, #3B82F6 100%);
            padding: 140px 24px 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .pub-page-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: rgba(244,197,66,0.15);
            filter: blur(80px);
        }

        .pub-page-hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: rgba(59,130,246,0.2);
            filter: blur(80px);
        }

        .pub-page-hero h1 {
            position: relative;
            z-index: 1;
            font-size: 3rem;
            font-weight: 800;
            color: white;
            letter-spacing: -1px;
            margin: 0 0 12px;
        }

        .pub-page-hero p {
            position: relative;
            z-index: 1;
            color: rgba(255,255,255,0.8);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="pub-flash pub-flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="pub-flash pub-flash-error">{{ session('error') }}</div>
    @endif

    <!-- Navigation -->
    <nav class="pub-nav" id="pubNav">
        <div class="pub-nav-inner">
            <a href="{{ route('site.home') }}" class="pub-nav-logo">
                <img src="{{ asset('images/logo.jpg') }}" alt="BGBR Logo" />
                <span>BGBR</span>
            </a>

            <ul class="pub-nav-links">
                <li><a href="{{ route('site.about') }}" class="{{ request()->routeIs('site.about') ? 'active' : '' }}">About</a></li>
                <li><a href="{{ route('site.leadership') }}" class="{{ request()->routeIs('site.leadership') ? 'active' : '' }}">Leadership</a></li>
                <li><a href="{{ route('site.events') }}" class="{{ request()->routeIs('site.events') ? 'active' : '' }}">Events</a></li>
                <li><a href="{{ route('site.news') }}" class="{{ request()->routeIs('site.news*') ? 'active' : '' }}">News</a></li>
                <li><a href="{{ route('site.gallery') }}" class="{{ request()->routeIs('site.gallery') ? 'active' : '' }}">Gallery</a></li>
                <li><a href="{{ route('site.faq') }}" class="{{ request()->routeIs('site.faq') ? 'active' : '' }}">FAQ</a></li>
                <li><a href="{{ route('site.contact') }}" class="pub-nav-cta">Contact Us</a></li>
            </ul>

            <button class="pub-nav-toggle" onclick="document.getElementById('mobileMenu').classList.add('open')">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="pub-mobile-menu" id="mobileMenu" onclick="if(event.target===this)this.classList.remove('open')">
        <div class="pub-mobile-panel">
            <button class="pub-mobile-close" onclick="document.getElementById('mobileMenu').classList.remove('open')">&times;</button>
            <a href="{{ route('site.home') }}" class="{{ request()->routeIs('site.home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('site.about') }}" class="{{ request()->routeIs('site.about') ? 'active' : '' }}">About Us</a>
            <a href="{{ route('site.leadership') }}" class="{{ request()->routeIs('site.leadership') ? 'active' : '' }}">Leadership</a>
            <a href="{{ route('site.events') }}" class="{{ request()->routeIs('site.events') ? 'active' : '' }}">Events</a>
            <a href="{{ route('site.news') }}" class="{{ request()->routeIs('site.news*') ? 'active' : '' }}">News</a>
            <a href="{{ route('site.gallery') }}" class="{{ request()->routeIs('site.gallery') ? 'active' : '' }}">Gallery</a>
            <a href="{{ route('site.faq') }}" class="{{ request()->routeIs('site.faq') ? 'active' : '' }}">FAQ</a>
            <a href="{{ route('site.donate') }}" class="{{ request()->routeIs('site.donate') ? 'active' : '' }}">Donate</a>
            <a href="{{ route('site.contact') }}" class="{{ request()->routeIs('site.contact') ? 'active' : '' }}">Contact Us</a>
        </div>
    </div>

    <!-- Page Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="pub-footer">
        <div class="pub-footer-grid">
            <div class="pub-footer-brand">
                <div style="display:flex;align-items:center;gap:12px;">
                    <img src="{{ asset('images/logo.jpg') }}" alt="BGBR" style="width:48px;height:48px;border-radius:14px;object-fit:contain;background:white;padding:4px;">
                    <div>
                        <div style="font-weight:800;font-size:1.1rem;">BGBR Rwanda</div>
                        <div style="font-size:0.75rem;color:var(--secondary);font-weight:600;">Sure & Steadfast</div>
                    </div>
                </div>
                <p>The Boys' and Girls' Brigade Rwanda empowers youth through Christian values, leadership development, and discipline for a brighter future.</p>
            </div>
            <div>
                <h3>Quick Links</h3>
                <a href="{{ route('site.about') }}">About Us</a>
                <a href="{{ route('site.leadership') }}">Leadership</a>
                <a href="{{ route('site.events') }}">Events</a>
                <a href="{{ route('site.news') }}">News</a>
                <a href="{{ route('site.gallery') }}">Gallery</a>
            </div>
            <div>
                <h3>Support</h3>
                <a href="{{ route('site.faq') }}">FAQ</a>
                <a href="{{ route('site.contact') }}">Contact Us</a>
                <a href="{{ route('site.donate') }}">Donate</a>
            </div>
            <div>
                <h3>Contact</h3>
                <a href="mailto:info@bgbr.rw">info@bgbr.rw</a>
                <a href="tel:+250780000000">+250 780 000 000</a>
                <p style="color:rgba(255,255,255,0.5);font-size:0.85rem;margin-top:8px;line-height:1.6;">Kigali, Rwanda</p>
            </div>
        </div>
        <div class="pub-footer-bottom">
            <span>&copy; {{ date('Y') }} BGBR Rwanda. All rights reserved.</span>
            <span>Sure & Steadfast</span>
        </div>
    </footer>

    <style>
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .fade-up.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <!-- Scroll effects -->
    <script>
        // Navbar scroll effect
        const nav = document.getElementById('pubNav');
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 50);
        });

        // Fade-up animation observer
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: "0px 0px -50px 0px" });

            document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
        });
    </script>

    @yield('scripts')
</body>
</html>
