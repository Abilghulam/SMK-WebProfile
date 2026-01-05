<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel Setting')</title>

    {{-- Admin Setting CSS --}}
    @vite(['resources/css/admin-settings.css', 'resources/js/admin.js'])

    {{-- Favicon --}}
    <link rel="icon" href="{{ data_get($settings, 'favicon_url', asset('assets/images/favicon.ico')) }}">

    {{-- (Opsional) font karakteristik untuk judul "Panel Setting" --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body class="adm-setting-body">
    <div class="adm-setting-shell">
        {{-- Sidebar Settings --}}
        <aside class="adm-setting-side" aria-label="Sidebar Settings">
            <div class="adm-setting-side-head">
                <div class="adm-setting-brand" aria-label="Panel Setting">
                    <div class="adm-setting-brand-mark" aria-hidden="true">
                        <!-- ikon settings -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings">
                            <path
                                d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </div>

                    <div class="adm-setting-brand-text">
                        <div class="adm-setting-brand-title">
                            Panel <span>Settings</span>
                        </div>
                        <div class="adm-setting-brand-sub">Pengaturan Website</div>
                    </div>

                </div>
            </div>

            <nav class="adm-setting-nav">
                <a class="adm-setting-link {{ request()->is('admin/settings') ? 'active' : '' }}"
                    href="{{ route('admin.settings.index') }}">
                    <span class="adm-setting-ic" aria-hidden="true"><i data-lucide="home"></i></span>
                    Beranda
                </a>

                <a class="adm-setting-link {{ request()->is('admin/settings/school*') ? 'active' : '' }}"
                    href="{{ route('admin.settings.school') }}">
                    <span class="adm-setting-ic" aria-hidden="true"><i data-lucide="school"></i></span>
                    Informasi Sekolah
                </a>

                {{-- Slot pengembangan nanti --}}
                <div class="adm-setting-nav-sep" aria-hidden="true"></div>

                <a class="adm-setting-link adm-setting-link--muted" href="{{ url('/admin') }}">
                    <span class="adm-setting-ic" aria-hidden="true"><i data-lucide="arrow-left"></i></span>
                    Kembali ke Dashboard
                </a>
            </nav>
        </aside>

        {{-- Main --}}
        <main class="adm-setting-main">
            @if (session('success'))
                <div class="adm-setting-toast" role="status">
                    <span class="adm-setting-toast-ic" aria-hidden="true"><i data-lucide="check-circle-2"></i></span>
                    <div class="adm-setting-toast-text">{{ session('success') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="adm-setting-toast adm-setting-toast--danger" role="alert">
                    <span class="adm-setting-toast-ic" aria-hidden="true"><i data-lucide="alert-triangle"></i></span>
                    <div class="adm-setting-toast-text">
                        <div class="adm-setting-toast-title">Ada input yang belum valid:</div>
                        <ul class="adm-setting-toast-list">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="adm-setting-center">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Lucide icons (external) --}}
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        if (window.lucide) window.lucide.createIcons();
    </script>

    @stack('scripts')
</body>

</html>
