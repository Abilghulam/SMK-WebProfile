<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Reset Password | SMKN 9 Muaro Jambi</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])

    {{-- Favicon --}}
    @if (!empty($settings?->favicon))
        <link rel="icon" href="{{ asset($settings->favicon) }}">
    @endif
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
                    PASSWORD
                </div>
            </div>

            <section class="a-card">
                <div class="a-card-head">
                    <div class="a-card-ic" aria-hidden="true">
                        <svg class="a-ic" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2l8 4v6c0 5-3.5 9.5-8 10-4.5-.5-8-5-8-10V6l8-4z" stroke="currentColor"
                                stroke-width="1.8" />
                            <path d="M9 12h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            <path d="M10 15.5h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                    </div>
                    <div class="a-card-title">
                        <h1>Password Baru</h1>
                        <p>Masukkan password baru.</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="a-alert a-alert--danger" role="alert">
                        <ul class="a-alert-list">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="a-form" method="POST" action="{{ route('admin.password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="a-field">
                        <div class="a-label">Email</div>
                        <div class="a-input-wrap">
                            <input class="a-input" type="email" name="email" value="{{ old('email', $email) }}"
                                required autocomplete="email">
                        </div>
                    </div>

                    <div class="a-field">
                        <div class="a-label">Password Baru</div>
                        <div class="a-input-wrap">
                            <input class="a-input" type="password" name="password" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="a-field">
                        <div class="a-label">Konfirmasi Password</div>
                        <div class="a-input-wrap">
                            <input class="a-input" type="password" name="password_confirmation" required
                                autocomplete="new-password">
                        </div>
                    </div>

                    <button class="a-btn a-btn--primary" type="submit">Simpan Password</button>
                </form>
            </section>

        </div>
    </main>
</body>

</html>
