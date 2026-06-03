<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 0; }
        .wrapper { max-width: 600px; margin: 30px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #1E2FA3 0%, #2a3fcc 100%); padding: 32px 40px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 22px; font-weight: 700; letter-spacing: -0.3px; }
        .header p { color: rgba(255,255,255,0.8); margin: 6px 0 0; font-size: 13px; }
        .body { padding: 32px 40px; }
        .field { margin-bottom: 20px; }
        .field-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #667085; margin-bottom: 6px; }
        .field-value { font-size: 15px; color: #101828; line-height: 1.6; }
        .message-box { background: #f8fafc; border-left: 4px solid #1E2FA3; padding: 16px 20px; border-radius: 0 8px 8px 0; margin-top: 6px; }
        .divider { border: none; border-top: 1px solid #e4e7ec; margin: 24px 0; }
        .footer { padding: 20px 40px; background: #f8fafc; text-align: center; }
        .footer p { color: #667085; font-size: 12px; margin: 0; }
        .badge { display: inline-block; background: #F4C542; color: #101828; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>BGBR Rwanda</h1>
            <p>New Contact Form Submission</p>
        </div>
        <div class="body">
            <div style="text-align: center; margin-bottom: 24px;">
                <span class="badge">New Message</span>
            </div>

            <div class="field">
                <div class="field-label">From</div>
                <div class="field-value">{{ $contact->name }}</div>
            </div>

            <div class="field">
                <div class="field-label">Email</div>
                <div class="field-value"><a href="mailto:{{ $contact->email }}" style="color: #1E2FA3; text-decoration: none;">{{ $contact->email }}</a></div>
            </div>

            @if($contact->phone)
            <div class="field">
                <div class="field-label">Phone</div>
                <div class="field-value">{{ $contact->phone }}</div>
            </div>
            @endif

            <div class="field">
                <div class="field-label">Subject</div>
                <div class="field-value" style="font-weight: 600;">{{ $contact->subject }}</div>
            </div>

            <hr class="divider">

            <div class="field">
                <div class="field-label">Message</div>
                <div class="message-box">
                    {!! nl2br(e($contact->message)) !!}
                </div>
            </div>

            <hr class="divider">

            <div class="field">
                <div class="field-label">Submitted</div>
                <div class="field-value" style="font-size: 13px; color: #667085;">
                    {{ $contact->created_at->format('F j, Y \\a\\t g:i A') }} &bull; IP: {{ $contact->ip_address }}
                </div>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} BGBR Rwanda &mdash; This is an automated message from the website contact form.</p>
        </div>
    </div>
</body>
</html>
