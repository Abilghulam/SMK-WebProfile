@php
    $role = auth()->user()->role ?? null;
    $isSuper = $role === 'super_admin';
    $isAdmin = in_array($role, ['admin', 'super_admin'], true);
@endphp

<aside class="admin-sidebar" data-admin-sidebar>
    <div class="admin-sidebar-head">
        <a class="admin-brand" href="{{ url('/admin') }}">
            @if (!empty($settings?->logo))
                <img src="{{ asset($settings->logo) }}" alt="Logo" class="admin-brand-logo">
            @else
                <div class="admin-brand-mark" aria-hidden="true"></div>
            @endif

            <div class="admin-brand-text">
                <div class="admin-brand-name">{{ $settings->site_name ?? 'SMK Negeri' }}</div>
                <div class="admin-brand-sub">Dashboard Admin</div>
            </div>
        </a>

        <div class="admin-branch">
            <span class="admin-branch-pill">
                <span class="admin-branch-ic" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 22s8-4 8-10V6l-8-3-8 3v6c0 6 8 10 8 10Z" stroke="currentColor" stroke-width="1.8"
                            stroke-linejoin="round" />
                    </svg>
                </span>
                <span class="admin-branch-text">
                    {{ $isSuper ? 'Super Admin' : ($isAdmin ? 'Admin Konten' : 'Operator') }}
                </span>
            </span>
        </div>
    </div>

    <nav class="admin-nav" aria-label="Navigasi Admin">
        <a class="admin-nav-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ url('/admin') }}">
            <span class="admin-nav-ic" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M4 10.5 12 4l8 6.5V20a1.5 1.5 0 0 1-1.5 1.5H5.5A1.5 1.5 0 0 1 4 20v-9.5Z"
                        stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                    <path d="M9 21v-7h6v7" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                </svg>
            </span>
            Dashboard
        </a>

        @if ($isAdmin)
            <div class="admin-nav-section">Konten</div>

            <a class="admin-nav-link {{ request()->routeIs('admin.home.*') ? 'active' : '' }}"
                href="{{ route('admin.home.index') }}">
                <span class="admin-nav-ic" aria-hidden="true">
                    {{-- home/settings (modern & institusional) --}}
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M3.5 10.5 12 4l8.5 6.5V20a1.5 1.5 0 0 1-1.5 1.5H5A1.5 1.5 0 0 1 3.5 20v-9.5Z"
                            stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                        <path d="M8 21v-7h8v7" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                        <path d="M8.2 10.2h.01M12 10.2h.01M15.8 10.2h.01" stroke="currentColor" stroke-width="2.4"
                            stroke-linecap="round" />
                    </svg>
                </span>
                Home Management
            </a>


            <a class="admin-nav-link {{ request()->is('admin/posts*') ? 'active' : '' }}"
                href="{{ url('/admin/posts') }}">
                <span class="admin-nav-ic" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M8 3h7l3 3v15a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" stroke="currentColor"
                            stroke-width="1.8" stroke-linejoin="round" />
                        <path d="M9 10h6M9 14h6M9 18h5" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" />
                    </svg>
                </span>
                Blog (Posts)
            </a>

            <a class="admin-nav-link {{ request()->is('admin/legal-documents*') ? 'active' : '' }}"
                href="{{ url('/admin/legal-documents') }}">
                <span class="admin-nav-ic" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M7 3h7l3 3v15a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V6a3 3 0 0 1 3-3Z" stroke="currentColor"
                            stroke-width="1.8" stroke-linejoin="round" />
                        <path d="M10 12h7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        <path d="M10 16h7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                </span>
                Legalitas
            </a>

            <a class="admin-nav-link {{ request()->is('admin/documentation*') ? 'active' : '' }}"
                href="{{ url('/admin/documentation') }}">
                <span class="admin-nav-ic" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7Z"
                            stroke="currentColor" stroke-width="1.8" />
                        <path d="M8.5 10.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" stroke="currentColor"
                            stroke-width="1.8" />
                        <path d="m21 16-5-5-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>
                Dokumentasi
            </a>

            <a class="admin-nav-link {{ request()->is('admin/departments*') ? 'active' : '' }}"
                href="{{ url('/admin/departments') }}">
                <span class="admin-nav-ic" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 3 3 8l9 5 9-5-9-5Z" stroke="currentColor" stroke-width="1.8"
                            stroke-linejoin="round" />
                        <path d="M3 12l9 5 9-5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                        <path d="M3 16l9 5 9-5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                    </svg>
                </span>
                Program Keahlian
            </a>

            <a class="admin-nav-link {{ request()->is('admin/facilities*') ? 'active' : '' }}"
                href="{{ url('/admin/facilities') }}">
                <span class="admin-nav-ic" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M4 21V7l8-4 8 4v14" stroke="currentColor" stroke-width="1.8"
                            stroke-linejoin="round" />
                        <path d="M9 21v-6h6v6" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                        <path d="M8 10h.01M12 10h.01M16 10h.01M8 13h.01M12 13h.01M16 13h.01" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" />
                    </svg>
                </span>
                Fasilitas
            </a>
        @endif

        @if ($isSuper)
            <div class="admin-nav-section">Pengaturan</div>

            <a class="admin-nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}"
                href="{{ url('/admin/settings') }}">
                <span class="admin-nav-ic" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Z" stroke="currentColor"
                            stroke-width="1.8" />
                        <path
                            d="M19.4 15a7.6 7.6 0 0 0 .1-1l2-1.2-2-3.4-2.2.6a7.8 7.8 0 0 0-1.7-1l-.3-2.3H9.7L9.4 7a7.8 7.8 0 0 0-1.7 1L5.5 7.4 3.5 10.8l2 1.2a7.6 7.6 0 0 0 0 2l-2 1.2 2 3.4 2.2-.6a7.8 7.8 0 0 0 1.7 1l.3 2.3h5.6l.3-2.3a7.8 7.8 0 0 0 1.7-1l2.2.6 2-3.4-2-1.2Z"
                            stroke="currentColor" stroke-width="1.3" stroke-linejoin="round" />
                    </svg>
                </span>
                Settings
            </a>
        @endif

        <div class="admin-nav-section">Akun</div>

        <a class="admin-nav-link" href="{{ url('/') }}" target="_blank" rel="noopener">
            <span class="admin-nav-ic" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M14 4h6v6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                    <path d="M10 14 20 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                    <path d="M20 14v6H4V4h6" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                </svg>
            </span>
            Buka Website
        </a>

        <form method="POST" action="{{ route('admin.logout') }}" class="admin-logout">
            @csrf
            <button type="submit" class="admin-nav-link admin-nav-link--danger">
                <span class="admin-nav-ic" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M10 7V5a2 2 0 0 1 2-2h7v18h-7a2 2 0 0 1-2-2v-2" stroke="currentColor"
                            stroke-width="1.8" stroke-linejoin="round" />
                        <path d="M13 12H3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                        <path d="m6 9-3 3 3 3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>
                Keluar
            </button>
        </form>

        <div class="admin-nav-foot">
            <div class="admin-footline">
                <span class="admin-foot-dot" aria-hidden="true"></span>
                <span>Mode Admin</span>
            </div>
            <div class="admin-footmuted">
                Pastikan data yang dipublikasi sudah diverifikasi.
            </div>
        </div>
    </nav>
</aside>

<div class="admin-overlay" aria-hidden="true" data-admin-overlay></div>
