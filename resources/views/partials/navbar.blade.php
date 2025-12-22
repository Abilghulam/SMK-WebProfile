<header class="navbar">
    <div class="container navbar-wrapper">

        {{-- Logo & Nama Sekolah --}}
        <a href="{{ url('/') }}" class="navbar-brand">
            <img src="{{ asset('assets/images/logo.webp') }}" alt="Logo Sekolah">
            <span>SMK Lorem Ipsum</span>
        </a>

        {{-- Toggle (Mobile) --}}
        <button class="navbar-toggle" id="navbarToggle">
            ☰
        </button>

        {{-- Menu --}}
        <nav class="navbar-menu" id="navbarMenu">
            <ul>
                <li class="{{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="{{ request()->is('akademik*') ? 'active' : '' }}">
                    <a href="{{ url('/akademik') }}">Akademik</a>
                </li>
                <li class="{{ request()->is('blog*') ? 'active' : '' }}">
                    <a href="{{ url('/blog') }}">Blog</a>
                </li>
                <li class="{{ request()->is('dokumentasi*') ? 'active' : '' }}">
                    <a href="{{ url('/dokumentasi') }}">Dokumentasi</a>
                </li>
                <li class="{{ request()->is('layanan*') ? 'active' : '' }}">
                    <a href="{{ url('/layanan') }}">Layanan</a>
                </li>
            </ul>
        </nav>

    </div>
</header>
