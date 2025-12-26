<header class="navbar">
    <div class="container navbar-wrapper">

        {{-- Logo & Nama Sekolah --}}
        <a href="{{ url('/') }}" class="navbar-brand">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo Sekolah">
            <span class="brand-name">{{ $schoolProfile->school_name ?? 'SMK' }}</span>
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

                {{-- Blog dropdown --}}
                <li class="nav-item {{ request()->is('blog*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('blog.index') }}">
                        Blog
                    </a>
                </li>

                <li class="nav-item {{ request()->is('dokumentasi*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/dokumentasi') }}">Dokumentasi</a>
                </li>

                {{-- Layanan dropdown --}}
                <li class="nav-item nav-dropdown {{ request()->is('layanan*') ? 'active' : '' }}">
                    <button class="nav-link nav-trigger" type="button" aria-haspopup="true" aria-expanded="false">
                        Layanan
                        <span class="chev" aria-hidden="true">▾</span>
                    </button>

                    <div class="dropdown">
                        <a class="dropdown-link" href="{{ url('/layanan/kontak-lokasi') }}">Kontak &amp; Lokasi</a>
                        <a class="dropdown-link" href="{{ url('/layanan/legalitas') }}">Legalitas Sekolah</a>
                    </div>
                </li>

            </ul>
        </nav>

    </div>
</header>
