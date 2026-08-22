<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Suspended | Site Locked</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #090d16;
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Ambient Glow Background Effects */
        .bg-glow-1 {
            position: absolute;
            top: -20%;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(239, 68, 68, 0.15) 0%, rgba(0, 0, 0, 0) 70%);
            pointer-events: none;
            z-index: 0;
        }

        .bg-glow-2 {
            position: absolute;
            bottom: -20%;
            right: 10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(220, 38, 38, 0.08) 0%, rgba(0, 0, 0, 0) 70%);
            pointer-events: none;
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 520px;
            width: 100%;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5),
                        0 0 40px rgba(239, 68, 68, 0.1);
            border-radius: 24px;
            padding: 2.75rem 2.25rem;
            text-align: center;
        }

        .icon-container {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem auto;
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(185, 28, 28, 0.1) 100%);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 30px rgba(239, 68, 68, 0.2);
            animation: pulse-glow 3s infinite ease-in-out;
        }

        .icon-container svg {
            width: 38px;
            height: 38px;
            color: #ef4444;
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 25px rgba(239, 68, 68, 0.2);
                border-color: rgba(239, 68, 68, 0.3);
            }
            50% {
                box-shadow: 0 0 40px rgba(239, 68, 68, 0.4);
                border-color: rgba(239, 68, 68, 0.6);
            }
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 1rem;
            border-radius: 9999px;
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #fca5a5;
            font-size: 0.8125rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #ef4444;
            box-shadow: 0 0 8px #ef4444;
        }

        .title {
            font-size: 1.75rem;
            font-weight: 800;
            line-height: 1.25;
            color: #ffffff;
            margin-bottom: 0.875rem;
            letter-spacing: -0.02em;
        }

        .description {
            font-size: 0.95rem;
            line-height: 1.6;
            color: #94a3b8;
            margin-bottom: 2rem;
        }

        .btn-contact {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            width: 100%;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);
            transition: all 0.2s ease;
        }

        .btn-contact:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
            background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
        }

        .btn-contact:active {
            transform: translateY(0);
        }

        .email-display {
            margin-top: 1.25rem;
            font-size: 0.85rem;
            color: #64748b;
        }

        .email-display a {
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .email-display a:hover {
            color: #f8fafc;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="bg-glow-1"></div>
    <div class="bg-glow-2"></div>

    <div class="container">
        <div class="icon-container">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
            </svg>
        </div>

        <div class="badge">
            <span class="badge-dot"></span>
            Service Suspended
        </div>

        <h1 class="title">This Website Is Currently Unavailable</h1>

        <p class="description">
            Access to this website and its services has been temporarily restricted. If you are the website owner or administrator, please reach out to the developer to restore services.
        </p>

        <a href="tel:0786098155" class="btn-contact">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.47-5.115-3.761-6.585-6.585l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
            </svg>
            Contact Developer
        </a>

        <div class="email-display">
            Direct Phone: <a href="tel:0786098155">0786098155</a>
        </div>
    </div>
</body>
</html>
