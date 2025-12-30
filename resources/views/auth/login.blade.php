<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login Admin</title>
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
                    <svg class="a-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 3l8 4v6c0 5-3.5 9.5-8 10-4.5-.5-8-5-8-10V7l8-4z" stroke="currentColor"
                            stroke-width="1.8" />
                    </svg>
                    AUTHENTICATION
                </div>
            </div>

            {{-- Card --}}
            <section class="a-card" aria-label="Form login admin">
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
                        <h1>Login</h1>
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
                                <svg class="a-ic" viewBox="0 0 24 24" fill="none">
                                    <path d="M7.5 11V8.5A4.5 4.5 0 0112 4a4.5 4.5 0 014.5 4.5V11" stroke="currentColor"
                                        stroke-width="1.8" stroke-linecap="round" />
                                    <path d="M7 11h10a2 2 0 012 2v5a2 2 0 01-2 2H7a2 2 0 01-2-2v-5a2 2 0 012-2z"
                                        stroke="currentColor" stroke-width="1.8" />
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
