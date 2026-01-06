<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login Admin | SMKN 9 Muaro Jambi</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])

    {{-- Favicon --}}
    @if (!empty($settings?->favicon))
        <link rel="icon" href="{{ asset($settings->favicon) }}">
    @endif

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
                            {{-- fallback: simple crest --}}
                            <svg class="a-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 2l8 4v6c0 5-3.5 9.5-8 10-4.5-.5-8-5-8-10V6l8-4z" stroke="currentColor"
                                    stroke-width="1.8" />
                                <path d="M9.2 12.2l2 2 3.8-4.2" stroke="currentColor" stroke-width="1.8"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        @endif
                    </div>

                    <div class="a-auth-brand-text">
                        <div class="a-auth-brand-name">{{ $site }}</div>
                        <div class="a-auth-brand-sub">Panel Admin</div>
                    </div>
                </div>

                <div class="a-auth-pill" aria-label="Mode Admin">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-shield-check-icon lucide-shield-check">
                        <path
                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                        <path d="m9 12 2 2 4-4" />
                    </svg>
                    AUTHENTICATION
                </div>
            </div>

            {{-- Card --}}
            <section class="a-card" aria-label="Form login admin">
                <div class="a-card-head">
                    <div class="a-card-ic" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-lock-keyhole-icon lucide-lock-keyhole">
                            <circle cx="12" cy="16" r="1" />
                            <rect x="3" y="10" width="18" height="12" rx="2" />
                            <path d="M7 10V7a5 5 0 0 1 10 0v3" />
                        </svg>
                    </div>

                    <div class="a-card-title">
                        <h1>Selamat Datang!</h1>
                        <p>Gunakan email & password untuk melakukan autentikasi</p>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="a-alert a-alert--danger" role="alert" aria-live="polite">
                        <div>
                            <div class="a-alert-title">Login gagal</div>
                            <ul class="a-alert-list">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if (session('status'))
                    <div class="a-alert" role="status" aria-live="polite">
                        <div>{{ session('status') }}</div>
                    </div>
                @endif

                <form class="a-form" method="POST" action="{{ route('admin.login.submit') }}" novalidate>
                    @csrf

                    <div class="a-field">
                        <div class="a-label">Email</div>
                        <div class="a-input-wrap">
                            <span class="a-input-ic" aria-hidden="true">
                                <svg class="a-ic" viewBox="0 0 24 24" fill="none">
                                    <path d="M4 7.5l8 5 8-5" stroke="currentColor" stroke-width="1.8"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M5.5 18h13A1.5 1.5 0 0020 16.5v-9A1.5 1.5 0 0018.5 6h-13A1.5 1.5 0 004 7.5v9A1.5 1.5 0 005.5 18z"
                                        stroke="currentColor" stroke-width="1.8" />
                                </svg>
                            </span>

                            <input class="a-input" type="email" name="email" value="{{ old('email') }}"
                                placeholder="admin@sekolah.sch.id" autocomplete="email" required>
                        </div>
                    </div>

                    <div class="a-field">
                        <div class="a-label">Password</div>
                        <div class="a-input-wrap">
                            <span class="a-input-ic" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-key-round-icon lucide-key-round">
                                    <path
                                        d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z" />
                                    <circle cx="16.5" cy="7.5" r=".5" fill="currentColor" />
                                </svg>
                            </span>

                            <input class="a-input" id="admin-password" type="password" name="password"
                                placeholder="••••••••" autocomplete="current-password" required>
                        </div>
                    </div>

                    <div class="a-form-row">
                        <label class="a-check">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            Ingat saya
                        </label>

                        <a class="a-link" href="{{ route('admin.password.request') }}">Lupa password</a>
                    </div>

                    <button class="a-btn a-btn--primary" type="submit">
                        Masuk
                        <svg class="a-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M10 7l5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </form>
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
