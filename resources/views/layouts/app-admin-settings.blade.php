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
                    <div class="adm-setting-brand-mark">
                        <!-- ikon settings -->
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z" />
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
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
                    <span class="adm-setting-ic" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </span>
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
