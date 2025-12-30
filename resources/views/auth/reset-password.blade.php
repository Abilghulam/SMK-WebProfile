<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Buat Password Baru</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>

<body class="a-auth-body">
    <main class="a-auth">
        <div class="a-auth-shell">

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
