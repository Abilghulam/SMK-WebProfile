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
            <div class="admin-user-dd" data-user-dd>
                <button type="button" class="admin-user" data-user-dd-btn aria-expanded="false">
                    <div class="admin-user-meta">
                        <div class="admin-user-sub">
                            {{ (auth()->user()->role ?? null) === 'super_admin' ? 'Super Admin' : 'Admin' }}
                        </div>
                        <div class="admin-user-email">
                            {{ auth()->user()->email ?? '-' }}
                        </div>
                    </div>

                    <div class="admin-user-avatar" aria-hidden="true">
                        {{-- user icon --}}
                        <svg class="admin-user-ic" viewBox="0 0 24 24" fill="none">
                            <path d="M20 21a8 8 0 0 0-16 0" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" />
                            <path d="M12 12a4 4 0 1 0-4-4a4 4 0 0 0 4 4Z" stroke="currentColor" stroke-width="1.8"
                                stroke-linejoin="round" />
                        </svg>
                    </div>

                    <span class="admin-user-chev" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </span>
                </button>

                <div class="admin-user-menu" data-user-dd-menu aria-hidden="true">
                    <form method="POST" action="{{ route('admin.logout') }}" class="admin-user-logout">
                        @csrf
                        <button type="submit" class="admin-user-menu-item admin-user-menu-item--danger">
                            <span class="admin-user-menu-ic" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="m16 17 5-5-5-5" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            Logout
                        </button>
                    </form>
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
