<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin | {{ data_get($settings, 'site_name', 'SMK Negeri') }}</title>
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

                    <img src="{{ data_get($settings, 'logo_url', asset('assets/images/logo.png')) }}"
                        alt="Logo {{ data_get($settings, 'site_name', 'SMK') }}">

                </span>

                <span class="a-auth-brand-text">
                    <span class="a-auth-brand-name">{{ $siteName }}</span>
                    <span class="a-auth-brand-sub">Panel Admin</span>
                </span>
            </a>

            <span class="a-auth-chip">ADMIN</span>
        </header>

        <section class="a-auth-card" aria-label="Form login admin">
            <div class="a-auth-card-head">
                <div class="a-auth-card-ic" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 3l7 4v6c0 5-3.5 8-7 9-3.5-1-7-4-7-9V7l7-4z" stroke="currentColor"
                            stroke-width="1.7" />
                        <path d="M9.5 12.3l1.8 1.8 3.7-4" stroke="currentColor" stroke-width="1.7"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>

                <div class="a-auth-card-title">
                    <div class="a-auth-kicker">Autentikasi</div>
                    <h1 class="a-auth-h1">Masuk Admin</h1>
                    <p class="a-auth-lead">Masukkan email dan password. Setelah itu, kode OTP akan dikirim ke email.</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="a-auth-alert a-auth-alert--danger" role="alert">
                    <strong>Login gagal.</strong>
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

            <form class="a-auth-form" method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="a-auth-field">
                    <label class="a-auth-label" for="email">Email</label>
                    <input class="a-auth-input" type="email" name="email" id="email" value="{{ old('email') }}"
                        placeholder="contoh: admin@sekolah.sch.id" autocomplete="username" required>
                </div>

                <div class="a-auth-field">
                    <label class="a-auth-label" for="password">Password</label>

                    <div class="a-auth-inputwrap">
                        <input class="a-auth-input a-auth-input--withbtn" type="password" name="password" id="password"
                            placeholder="Masukkan password" autocomplete="current-password" required>

                        <button class="a-auth-eye" type="button" data-toggle-password="#password"
                            aria-label="Tampilkan password">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z" stroke="currentColor"
                                    stroke-width="1.7" />
                                <path d="M12 15.2a3.2 3.2 0 1 0 0-6.4 3.2 3.2 0 0 0 0 6.4z" stroke="currentColor"
                                    stroke-width="1.7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="a-auth-row">
                    <label class="a-auth-check">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button class="a-auth-submit" type="submit">
                    <span>Masuk</span>
                    <span class="a-auth-arrow" aria-hidden="true">→</span>
                </button>

                <p class="a-auth-note">
                    Dengan masuk, Anda menyetujui penggunaan sistem ini untuk operasional sekolah.
                </p>
            </form>
        </section>

        <footer class="a-auth-footer">
            <span>{{ data_get($settings, 'site_name', 'SMK Negeri') }} — Admin Panel</span>
            <span>© {{ date('Y') }}</span>
        </footer>
    </main>

    <script>
        document.querySelectorAll('[data-toggle-password]').forEach(btn => {
            btn.addEventListener('click', () => {
                const sel = btn.getAttribute('data-toggle-password');
                const input = document.querySelector(sel);
                if (!input) return;
                input.type = (input.type === 'password') ? 'text' : 'password';
            });
        });
    </script>
</body>

</html>
