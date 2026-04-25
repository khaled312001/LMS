<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $notif_title }}</title>
</head>
<body style="margin:0;padding:0;background:#f1f5f9;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Tahoma,sans-serif;">
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background:#f1f5f9;padding:32px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="max-width:600px;width:100%;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 12px 40px rgba(15,23,42,0.06);">
                <tr>
                    <td style="background:linear-gradient(135deg,#0f172a 0%,#1e1b4b 50%,#4c1d95 100%);padding:36px 32px;text-align:center;color:#fff;">
                        @php $logo = get_image(get_frontend_settings('dark_logo') ?: get_frontend_settings('light_logo')); @endphp
                        @if ($logo)
                            <img src="{{ $logo }}" alt="{{ get_settings('system_title') }}" style="max-height:48px;margin-bottom:14px;">
                        @endif
                        <h1 style="margin:0;font-size:1.4rem;font-weight:800;color:#fff;line-height:1.4;">{{ $notif_title }}</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:34px 36px 12px 36px;color:#0f172a;">
                        @if (!empty($recipient_name))
                            <p style="margin:0 0 18px;font-size:0.95rem;color:#475569;">
                                Hi <strong style="color:#0f172a;">{{ $recipient_name }}</strong>,
                            </p>
                        @endif
                        <div style="font-size:1rem;line-height:1.7;color:#334155;">
                            {!! nl2br(e($notif_body)) !!}
                        </div>
                    </td>
                </tr>
                @if (!empty($notif_link))
                <tr>
                    <td style="padding:18px 36px 12px 36px;text-align:center;">
                        <a href="{{ $notif_link }}" style="display:inline-block;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;text-decoration:none;font-weight:700;padding:13px 28px;border-radius:100px;box-shadow:0 8px 18px rgba(99,102,241,0.35);">
                            View details &rarr;
                        </a>
                    </td>
                </tr>
                @endif
                <tr>
                    <td style="padding:24px 36px 36px 36px;border-top:1px solid #e2e8f0;margin-top:18px;">
                        <p style="margin:0;font-size:0.78rem;color:#94a3b8;text-align:center;line-height:1.6;">
                            {{ get_settings('system_title') }} &copy; {{ date('Y') }}<br>
                            <a href="{{ url('/') }}" style="color:#6366f1;text-decoration:none;">{{ str_replace(['https://','http://'], '', url('/')) }}</a>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
