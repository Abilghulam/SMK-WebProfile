<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi OTP | {{ data_get($settings, 'site_name', 'SMK Negeri') }}</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>

<body class="a-auth">

    <main class="a-auth-shell">
        <header class="a-auth-brand" aria-label="Identitas sistem">
            <a href="{{ url('/') }}" class="a-auth-brand-link">
                <span class="a-auth-logo">
                    @php
                        $logo = data_get($settings, 'logo');
                        $siteName = data_get($settings, 'site_name', 'SMK Negeri');
                    @endphp

                    @if (!empty($logo))
                        <img src="{{ asset('storage/' . ltrim($logo, '/')) }}" alt="Logo {{ $siteName }}">
                    @else
                        <span class="a-auth-logo-fallback" aria-hidden="true"></span>
                    @endif
                </span>

                <span class="a-auth-brand-text">
                    <span class="a-auth-brand-name">{{ $siteName }}</span>
                    <span class="a-auth-brand-sub">Panel Admin</span>
                </span>
            </a>

            <span class="a-auth-chip">OTP</span>
        </header>

        <section class="a-auth-card" aria-label="Form verifikasi OTP">
            <div class="a-auth-card-head">
                <div class="a-auth-card-ic" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M15 10a4 4 0 1 1-2.8-3.8" stroke="currentColor" stroke-width="1.7"
                            stroke-linecap="round" />
                        <path d="M11 12h10l-2 2 2 2-2 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>

                <div class="a-auth-card-title">
                    <div class="a-auth-kicker">Verifikasi</div>
                    <h1 class="a-auth-h1">Masukkan Kode OTP</h1>
                    <p class="a-auth-lead">
                        Kode verifikasi telah dikirim ke email Anda. Masukkan 6 digit kode untuk melanjutkan.
                    </p>
                </div>
            </div>

            @if ($errors->any())
                <div class="a-auth-alert a-auth-alert--danger" role="alert">
                    <strong>Verifikasi gagal.</strong>
                    <ul>
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="a-auth-alert a-auth-alert--info" role="status">
                    {{ session('status') }}
                </div>
            @endif

            <form class="a-auth-form" method="POST" action="{{ route('admin.otp.verify') }}">
                @csrf

                <div class="a-auth-field">
                    <label class="a-auth-label" for="otp">Kode OTP</label>

                    <input class="a-auth-input a-auth-input--otp" type="text" inputmode="numeric" pattern="[0-9]*"
                        maxlength="6" name="otp" id="otp" value="{{ old('otp') }}" placeholder="••••••"
                        autocomplete="one-time-code" required>

                    <div class="a-auth-hint">
                        Jika kode tidak masuk, silakan ulangi proses login untuk mengirim OTP kembali.
                    </div>
                </div>

                <button class="a-auth-submit" type="submit">
                    <span>Verifikasi</span>
                    <span class="a-auth-arrow" aria-hidden="true">→</span>
                </button>

                <div class="a-auth-row a-auth-row--center" style="margin-top: 12px;">
                    <a class="a-auth-link" href="{{ route('admin.login') }}">
                        Kembali ke Login
                    </a>
                </div>
            </form>
        </section>

        <footer class="a-auth-footer">
            <span>{{ data_get($settings, 'site_name', 'SMK Negeri') }} — Admin Panel</span>
            <span>© {{ date('Y') }}</span>
        </footer>
    </main>

    <script>
        const otp = document.getElementById('otp');
        if (otp) {
            otp.focus();
            otp.addEventListener('input', () => {
                otp.value = otp.value.replace(/\D/g, '').slice(0, 6);
            });
        }
    </script>
</body>

</html>
