<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>@yield('title', 'Dashboard Admin') | {{ $settings->site_name ?? 'SMK Negeri' }}</title>

    {{-- Favicon --}}
    @if (!empty($settings?->favicon))
        <link rel="icon" href="{{ asset($settings->favicon) }}">
    @endif

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- Admin CSS --}}
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])

    @stack('styles')
</head>

<body class="admin">

    <div class="admin-shell">

        {{-- Sidebar --}}
        @include('components.admin-pages.shared.sidebar')

        {{-- Main --}}
        <div class="admin-main">

            {{-- Topbar --}}
            @include('components.admin-pages.shared.topbar')

            {{-- Content --}}
            <main class="admin-content">
                @include('components.admin-pages.shared.flash')

                @yield('content')
            </main>

            <footer class="admin-footer">
                <div class="admin-footer-inner">
                    <span>{{ $settings->site_name ?? 'SMK Negeri' }} — Dashboard Admin</span>
                    <span>&copy; {{ now()->year }} All rights reserved.</span>
                </div>
            </footer>
        </div>
    </div>

    <script>
        // Sidebar mobile toggle
        (function() {
            const btn = document.querySelector('[admin-nav-toggle]');
            const sidebar = document.querySelector('.admin-sidebar');
            const overlay = document.querySelector('.admin-overlay');

            if (!btn || !sidebar || !overlay) return;

            const open = () => {
                document.body.classList.add('is-admin-nav-open');
            };

            const close = () => {
                document.body.classList.remove('is-admin-nav-open');
            };

            btn.addEventListener('click', () => {
                document.body.classList.toggle('is-admin-nav-open');
            });

            overlay.addEventListener('click', close);

            // close on escape
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') close();
            });
        })();
    </script>

    @stack('scripts')
</body>

</html>
