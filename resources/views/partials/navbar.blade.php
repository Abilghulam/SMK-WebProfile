<header class="navbar">
    <div class="container navbar-wrapper">

        {{-- Logo & Nama Sekolah --}}
        <a href="{{ url('/') }}" class="navbar-brand">
            <img src="{{ data_get($settings, 'logo_url', asset('assets/images/logo.png')) }}"
                alt="Logo {{ data_get($settings, 'site_name', 'SMK') }}">

            <span class="brand-name">{{ data_get($settings, 'site_name', 'SMK Negeri 9 Muaro Jambi') }}</span>
        </a>

        {{-- Toggle (Mobile) --}}
        <button class="navbar-toggle" id="navbarToggle" aria-label="Toggle menu" aria-expanded="false">
            <span class="toggle-bars"></span>
        </button>

        {{-- Menu --}}
        <nav class="navbar-menu" id="navbarMenu" aria-label="Main navigation">
            <ul class="nav-list">

                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>

                {{-- Akademik dropdown --}}
                <li class="nav-item nav-dropdown {{ request()->is('akademik*') ? 'active' : '' }}">
                    <button class="nav-link nav-trigger" type="button" aria-haspopup="true" aria-expanded="false">
                        Akademik
                        <span class="chev" aria-hidden="true">▾</span>
                    </button>

                    <div class="dropdown">
                        <a class="dropdown-link" href="{{ url('/akademik/program-keahlian') }}">Program Keahlian</a>
                        <a class="dropdown-link" href="{{ url('/akademik/fasilitas') }}">Fasilitas</a>
                    </div>
                </li>

                {{-- Blog --}}
                <li class="nav-item {{ request()->is('blog*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('blog.index') }}">
                        Blog
                    </a>
                </li>

                {{-- Dokumentasi --}}
                <li class="nav-item {{ request()->is('dokumentasi*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/dokumentasi') }}">Dokumentasi</a>
                </li>

                {{-- Layanan --}}
                <li class="nav-item {{ request()->is('layanan*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/layanan') }}">Layanan</a>
                </li>

            </ul>
        </nav>

    </div>
</header>
