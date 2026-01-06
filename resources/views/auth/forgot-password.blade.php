<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Lupa Password | SMKN 9 Muaro Jambi</title>
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
                    <svg class="a-ic" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-key-round-icon lucide-key-round">
                        <path
                            d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z" />
                        <circle cx="16.5" cy="7.5" r=".5" fill="currentColor" />
                    </svg>
                    PASSWORD
                </div>
            </div>

            <section class="a-card">
                <div class="a-card-head">
                    <div class="a-card-ic" aria-hidden="true">
                        <svg class="a-ic" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-rotate-ccw-key-icon lucide-rotate-ccw-key">
                            <path d="m14.5 9.5 1 1" />
                            <path d="m15.5 8.5-4 4" />
                            <path d="M3 12a9 9 0 1 0 9-9 9.74 9.74 0 0 0-6.74 2.74L3 8" />
                            <path d="M3 3v5h5" />
                            <circle cx="10" cy="14" r="2" />
                        </svg>
                    </div>
                    <div class="a-card-title">
                        <h1>Reset Password</h1>
                        <p>Kami akan kirim link ke email.</p>
                    </div>
                </div>

                @if (session('status'))
                    <div class="a-alert" role="status">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="a-alert a-alert--danger" role="alert">
                        <ul class="a-alert-list">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="a-form" method="POST" action="{{ route('admin.password.email') }}">
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
                            <input class="a-input" type="email" name="email" value="{{ old('email') }}" required
                                autocomplete="email">
                        </div>
                    </div>

                    <button class="a-btn a-btn--primary" type="submit">Kirim Link</button>

                    <div class="a-actions-row">
                        <a class="a-btn a-btn--ghost" href="{{ route('admin.login') }}">
                            <svg class="a-ic" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M14 7l-5 5 5 5" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Kembali</a>
                    </div>
                </form>
            </section>

        </div>
    </main>
</body>

</html>
