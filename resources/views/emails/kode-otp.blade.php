<!doctype html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body style="font-family: Arial, sans-serif; line-height:1.6; color:#0f172a;">
    <h2 style="margin:0 0 8px;">Kode Verifikasi Admin</h2>
    <p style="margin:0 0 14px;">
        Berikut kode OTP untuk masuk ke <strong>{{ $siteName }}</strong>:
    </p>

    <div
        style="display:inline-block; padding:12px 16px; border:1px solid #cbd5e1; border-radius:10px; background:#f8fafc;">
        <span style="font-size:22px; letter-spacing:6px; font-weight:700;">{{ $code }}</span>
    </div>

    <p style="margin:14px 0 0; font-size:13px; color:#475569;">
        Kode berlaku {{ $ttlMinutes }} menit. Jangan bagikan kode ini kepada siapa pun.
    </p>
</body>

</html>
