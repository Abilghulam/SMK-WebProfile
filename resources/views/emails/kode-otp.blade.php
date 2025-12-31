<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Kode Verifikasi OTP</title>
</head>

<body style="margin:0; padding:0; background:#f4f7fb; color:#0f172a;">
    @php
        // Inline logo via CID (AMAN di Gmail & localhost)
        $logoPath = public_path('img/logo.png');
        $logoSrc = is_file($logoPath) ? $message->embed($logoPath) : null;
    @endphp

    <div style="width:100%; background:#f4f7fb; padding:24px 12px;">
        <div
            style="
        max-width:560px;
        margin:0 auto;
        background:#ffffff;
        border:1px solid rgba(15,23,42,0.10);
        border-radius:16px;
        box-shadow:0 18px 50px rgba(15,23,42,0.08);
        overflow:hidden;
    ">

            <!-- Header -->
            <div
                style="
            background:linear-gradient(135deg, rgba(2,56,117,0.98), rgba(2,56,117,0.92));
            padding:18px 18px 16px;
        ">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td
                                        style="
                                    width:44px;
                                    height:44px;
                                    border-radius:12px;
                                    background:rgba(255,255,255,0.14);
                                    border:1px solid rgba(255,255,255,0.18);
                                    text-align:center;
                                    vertical-align:middle;
                                ">
                                        @if ($logoSrc)
                                            <img src="{{ $logoSrc }}" width="32" height="32" alt="Logo"
                                                style="display:block; margin:6px auto; object-fit:contain;">
                                        @else
                                            <span style="color:#fff; font-weight:700;">LOGO</span>
                                        @endif
                                    </td>
                                    <td style="padding-left:12px;">
                                        <div
                                            style="
                                        font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
                                        font-size:13px;
                                        font-weight:700;
                                        color:#ffffff;
                                    ">
                                            {{ $siteName }}
                                        </div>
                                        <div
                                            style="
                                        font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
                                        font-size:12px;
                                        color:rgba(255,255,255,0.82);
                                        margin-top:2px;
                                    ">
                                            Verifikasi Kode OTP
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td align="right">
                            <span
                                style="
                            display:inline-block;
                            padding:7px 10px;
                            border-radius:999px;
                            background:rgba(255,255,255,0.14);
                            border:1px solid rgba(255,255,255,0.18);
                            color:#ffffff;
                            font-size:11px;
                            font-weight:700;
                            letter-spacing:0.06em;
                        ">
                                OTP CODE
                            </span>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Body -->
            <div style="padding:18px;">
                <div
                    style="
                font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
                font-size:16px;
                font-weight:800;
                margin-bottom:8px;
            ">
                    Kode OTP Verifikasi
                </div>

                <p
                    style="
                font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
                font-size:13.5px;
                color:rgba(15,23,42,0.78);
                line-height:1.7;
                margin-bottom:14px;
            ">
                    Gunakan kode OTP berikut untuk masuk ke dashboard admin
                    <strong>{{ $siteName }}</strong>.
                </p>

                <!-- OTP -->
                <div
                    style="
                border-radius:14px;
                border:1px solid rgba(2,56,117,0.18);
                background:linear-gradient(180deg, rgba(2,56,117,0.06), rgba(2,56,117,0.03));
                padding:14px;
                text-align:center;
                margin-bottom:14px;
            ">
                    <div
                        style="
                    height:4px;
                    width:96px;
                    margin:0 auto 10px;
                    border-radius:999px;
                    background:linear-gradient(90deg, rgba(234,179,8,0.92), rgba(234,179,8,0.55));
                ">
                    </div>

                    <div
                        style="
                    font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,'Courier New',monospace;
                    font-size:28px;
                    font-weight:800;
                    letter-spacing:10px;
                    color:#023875;
                ">
                        {{ $code }}
                    </div>

                    <div
                        style="
                    font-size:12px;
                    color:rgba(15,23,42,0.62);
                    margin-top:10px;
                ">
                        Berlaku <strong>{{ $ttlMinutes }} menit</strong>
                    </div>
                </div>

                <!-- Security note -->
                <div
                    style="
                border-left:4px solid rgba(234,179,8,0.9);
                background:rgba(234,179,8,0.10);
                border-radius:12px;
                padding:10px 12px;
                font-size:12.5px;
                color:rgba(15,23,42,0.78);
                line-height:1.6;
            ">
                    Jangan bagikan kode ini kepada siapa pun.
                    Jika Anda tidak merasa melakukan login, abaikan email ini.
                </div>
            </div>

            <!-- Footer -->
            <div
                style="
            padding:14px 18px;
            border-top:1px solid rgba(15,23,42,0.08);
            background:rgba(248,250,252,0.7);
            font-size:12px;
            color:rgba(15,23,42,0.62);
        ">
                Email ini dikirim otomatis oleh sistem
                <strong>{{ $siteName }}</strong>.<br>
                © {{ date('Y') }} {{ $siteName }}.
            </div>
        </div>

        <div
            style="
        max-width:560px;
        margin:14px auto 0;
        font-size:11.5px;
        color:rgba(15,23,42,0.52);
        text-align:center;
    ">
            Jika email tidak tampil sempurna, salin kode OTP:
            <strong>{{ $code }}</strong>
        </div>
    </div>
</body>

</html>
