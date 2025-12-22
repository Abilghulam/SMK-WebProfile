<footer class="footer">
    <div class="container footer-wrapper">

        {{-- ===== COLUMN 1: PROFILE ===== --}}
        <div class="footer-col">
            <div class="footer-brand">
                <img src="{{ asset('assets/images/logo.webp') }}" alt="Logo Sekolah">
                <h4>SMK Lorem Ipsum</h4>
            </div>
            <p>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.
            </p>
        </div>

        {{-- ===== COLUMN 2: QUICK LINKS ===== --}}
        <div class="footer-col">
            <h5>Menu</h5>
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/akademik') }}">Akademik</a></li>
                <li><a href="{{ url('/blog') }}">Blog</a></li>
                <li><a href="{{ url('/dokumentasi') }}">Dokumentasi</a></li>
                <li><a href="{{ url('/layanan') }}">Layanan</a></li>
            </ul>
        </div>

        {{-- ===== COLUMN 3: CONTACT ===== --}}
        <div class="footer-col">
            <h5>Kontak</h5>
            <ul class="footer-contact">
                <li>📍 Jl. Pendidikan No. 1</li>
                <li>📞 (021) 123456</li>
                <li>✉️ info@smknegeri.sch.id</li>
            </ul>
        </div>

    </div>

    {{-- ===== COPYRIGHT ===== --}}
    <div class="footer-bottom">
        <p>
            &copy; {{ date('Y') }} SMK Lorem Ipsum.
            All rights reserved.
        </p>
    </div>
</footer>
