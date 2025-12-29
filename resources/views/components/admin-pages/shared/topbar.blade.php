<header class="admin-topbar">
    <div class="admin-topbar-inner">
        <button class="admin-nav-toggle" type="button" data-admin-toggle aria-label="Buka navigasi">
            <span class="admin-nav-toggle-ic" aria-hidden="true"></span>
        </button>

        <div class="admin-topbar-title">
            <div class="admin-page-kicker">@yield('kicker', 'Admin')</div>
            <h1 class="admin-page-title">@yield('page_title', 'Dashboard')</h1>
        </div>

        <div class="admin-topbar-right">
            <div class="admin-user" title="{{ auth()->user()->email ?? '' }}">
                <div class="admin-user-meta">
                    <div class="admin-user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="admin-user-sub">
                        {{ (auth()->user()->role ?? null) === 'super_admin' ? 'Super Admin' : 'Admin' }}
                    </div>
                </div>

                <div class="admin-user-avatar" aria-hidden="true">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </div>
    </div>
</header>

{{-- Mobile sidebar toggle (simple & safe) --}}
<script>
    (function() {
        const btn = document.querySelector('[data-admin-toggle]');
        const overlay = document.querySelector('[data-admin-overlay]');
        const sidebar = document.querySelector('[data-admin-sidebar]');

        if (!btn || !overlay || !sidebar) return;

        const open = () => document.body.classList.add('is-admin-nav-open');
        const close = () => document.body.classList.remove('is-admin-nav-open');

        btn.addEventListener('click', function() {
            document.body.classList.toggle('is-admin-nav-open');
        });

        overlay.addEventListener('click', close);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') close();
        });
    })();
</script>
