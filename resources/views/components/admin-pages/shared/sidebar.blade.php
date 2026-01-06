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
            <div class="admin-nav-section">Manage</div>

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
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-newspaper-icon lucide-newspaper">
                        <path d="M15 18h-5" />
                        <path d="M18 14h-8" />
                        <path
                            d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2" />
                        <rect width="8" height="4" x="10" y="6" rx="1" />
                    </svg>
                </span>
                Blog (Posts)
            </a>

            <a class="admin-nav-link {{ request()->is('admin/legal-documents*') ? 'active' : '' }}"
                href="{{ url('/admin/legal-documents') }}">
                <span class="admin-nav-ic" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-file-up-icon lucide-file-up">
                        <path
                            d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                        <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                        <path d="M12 12v6" />
                        <path d="m15 15-3-3-3 3" />
                    </svg>
                </span>
                Legalitas
            </a>

            <a class="admin-nav-link {{ request()->is('admin/documentation*') ? 'active' : '' }}"
                href="{{ url('/admin/documentation') }}">
                <span class="admin-nav-ic" aria-hidden="true">
                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m3 16 5-7 6 6.5m6.5 2.5L16 13l-4.286 6M14 10h.01M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                    </svg>
                </span>
                Dokumentasi
            </a>

            <a class="admin-nav-link {{ request()->is('admin/departments*') ? 'active' : '' }}"
                href="{{ url('/admin/departments') }}">
                <span class="admin-nav-ic" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-layers-icon lucide-layers">
                        <path
                            d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z" />
                        <path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12" />
                        <path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17" />
                    </svg>
                </span>
                Program Keahlian
            </a>

            <a class="admin-nav-link {{ request()->is('admin/facilities*') ? 'active' : '' }}"
                href="{{ url('/admin/facilities') }}">
                <span class="admin-nav-ic" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-building2-icon lucide-building-2">
                        <path d="M10 12h4" />
                        <path d="M10 8h4" />
                        <path d="M14 21v-3a2 2 0 0 0-4 0v3" />
                        <path d="M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2" />
                        <path d="M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16" />
                    </svg>
                </span>
                Fasilitas
            </a>
        @endif

        @if ($isSuper)
            <div class="admin-nav-section">Sistem</div>

            <a class="admin-nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}"
                href="{{ url('/admin/settings') }}" target="_blank">
                <span class="admin-nav-ic" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings">
                        <path
                            d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </span>
                Settings
            </a>
        @endif

        <div class="admin-nav-section">Home</div>

        <a class="admin-nav-link" href="{{ url('/') }}" target="_blank" rel="noopener">
            <span class="admin-nav-ic" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-external-link-icon lucide-external-link">
                    <path d="M15 3h6v6" />
                    <path d="M10 14 21 3" />
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                </svg>
            </span>
            Buka Website
        </a>
    </nav>
</aside>

<div class="admin-overlay" aria-hidden="true" data-admin-overlay></div>
