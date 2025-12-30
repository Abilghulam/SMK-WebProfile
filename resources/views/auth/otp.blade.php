<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Verifikasi OTP</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>

<body class="a-auth-body">
    <main class="a-auth">
        <div class="a-auth-shell">

            {{-- Brand bar --}}
            <div class="a-auth-brand" role="banner" aria-label="Admin brand">
                <div class="a-auth-brand-left">
                    <div class="a-auth-logo" aria-hidden="true">
                        @php
                            $logo = data_get($settings ?? null, 'logo');
                            $site = data_get($settings ?? null, 'site_name', 'SMK Negeri');
                        @endphp

                        @if (!empty($logo))
                            <img src="{{ data_get($settings, 'logo_url', asset('assets/images/logo.png')) }}"
                                alt="Logo {{ data_get($settings, 'site_name', 'SMK') }}">
                        @else
                            <svg class="a-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 2l8 4v6c0 5-3.5 9.5-8 10-4.5-.5-8-5-8-10V6l8-4z" stroke="currentColor"
                                    stroke-width="1.8" />
                                <path d="M8.5 12.2l2.2 2.2L15.8 9" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        @endif
                    </div>

                    <div class="a-auth-brand-text">
                        <div class="a-auth-brand-name">{{ $site }}</div>
                        <div class="a-auth-brand-sub">Panel Admin</div>
                    </div>
                </div>

                <div class="a-auth-pill" aria-label="Mode OTP">
                    <svg class="a-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" />
                        <path d="M7 11h10v9H7v-9z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                        <path d="M12 15v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                    2FA SECURITY
                </div>
            </div>

            {{-- Card --}}
            <section class="a-card" aria-label="Form OTP">
                <div class="a-card-head">
                    <div class="a-card-ic" aria-hidden="true">
                        <svg class="a-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" />
                            <path d="M7 11h10v9H7v-9z" stroke="currentColor" stroke-width="1.8"
                                stroke-linejoin="round" />
                            <path d="M12 15v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                    </div>

                    <div class="a-card-title">
                        <h1>Verifikasi OTP</h1>
                        <p>Masukkan 6 digit dari akun email Anda</p>
                    </div>
                </div>

                {{-- Alerts --}}
                @if ($errors->any())
                    <div class="a-alert a-alert--danger" role="alert" aria-live="polite">
                        <div>
                            <div class="a-alert-title">Verifikasi gagal</div>
                            <ul class="a-alert-list">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="a-alert a-alert--danger" role="alert" aria-live="polite">
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="a-alert" role="status" aria-live="polite">
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if (session('status'))
                    <div class="a-alert" role="status" aria-live="polite">
                        <div>{{ session('status') }}</div>
                    </div>
                @endif

                {{-- ✅ VERIFY FORM (JANGAN DITUTUP SEBELUM TOMBOL VERIFIKASI) --}}
                <form class="a-form" method="POST" action="{{ route('admin.otp.verify') }}" novalidate data-otp-form
                    data-expires-at="{{ $expiresAtIso ?? '' }}">
                    @csrf

                    <input type="hidden" name="otp" value="" data-otp-hidden>

                    <div class="a-field">
                        <div class="a-label">Kode OTP</div>

                        <div class="a-otp" data-otp>
                            @for ($i = 0; $i < 6; $i++)
                                <input class="a-otp-box" type="text" inputmode="numeric" pattern="[0-9]*"
                                    maxlength="1" autocomplete="one-time-code"
                                    aria-label="Digit OTP {{ $i + 1 }}">
                            @endfor
                        </div>

                        {{-- ✅ META: kiri expiry, kanan resend --}}
                        <div class="a-otp-meta">
                            <div class="a-otp-exp">
                                <svg class="a-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M12 7v6l4 2" stroke="currentColor" stroke-width="1.8"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor"
                                        stroke-width="1.8" />
                                </svg>
                                <span>Kedaluwarsa: <strong data-otp-exp-text>—</strong></span>
                                <span class="a-otp-sep">•</span>
                                <span>Sisa: <strong data-otp-countdown>—</strong></span>
                            </div>

                            {{-- ✅ RESEND FORM TERPISAH (TIDAK NESTED) --}}
                            <form class="a-form a-form--inline" method="POST"
                                action="{{ route('admin.otp.resend') }}" data-otp-resend-form
                                data-resend-seconds="{{ (int) ($cooldownRemaining ?? 0) }}">
                                @csrf

                                <button type="submit" class="a-link" data-resend-btn
                                    {{ ((int) ($cooldownRemaining ?? 0)) > 0 ? 'disabled' : '' }}
                                    aria-disabled="{{ ((int) ($cooldownRemaining ?? 0)) > 0 ? 'true' : 'false' }}">
                                    Kirim ulang
                                    <span class="a-link-muted">
                                        (<span data-resend-count>{{ (int) ($cooldownRemaining ?? 0) }}</span>s)
                                    </span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <button class="a-btn a-btn--primary" type="submit">
                        Verifikasi
                        <svg class="a-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M10 7l5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>

                    <div class="a-actions-row">
                        <a class="a-btn a-btn--ghost" href="{{ route('admin.login') }}">
                            <svg class="a-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M14 7l-5 5 5 5" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Kembali
                        </a>
                    </div>
                </form>
                {{-- ✅ END VERIFY FORM --}}
            </section>

            <footer class="a-auth-footer" aria-label="Footer auth">
                <span>{{ $site }} — Admin Panel</span>
                <span class="a-auth-footer-dot">•</span>
                <span>&copy; {{ now()->year }}</span>
            </footer>

        </div>
    </main>
</body>

</html>
