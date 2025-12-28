<footer class="site-footer">
    <div class="container footer-grid">

        {{-- Column 1: Brand + Description + Social --}}
        <div class="footer-col footer-brandcol">
            <a href="{{ url('/') }}" class="footer-brand">
                <img src="{{ data_get($settings, 'logo_url', asset('assets/images/logo.png')) }}"
                    alt="Logo {{ data_get($settings, 'site_name', 'SMK') }}">

                <div class="footer-brandtext">
                    <div class="footer-schoolname">
                        {{ data_get($settings, 'site_name', 'SMK Negeri 9 Muaro Jambi') }}
                    </div>
                    <div class="footer-tagline">Website Resmi Sekolah</div>
                </div>
            </a>

            <p class="footer-desc">
                {{ data_get($settings, 'footer_about', 'Website resmi sekolah sebagai pusat informasi, publikasi, dan layanan.') }}
            </p>

            @if (
                !empty($settings?->instagram_url) ||
                    !empty($settings?->facebook_url) ||
                    !empty($settings?->tiktok_url) ||
                    !empty($settings?->whatsapp_url))
                <div class="footer-social">

                    @if (!empty($settings?->instagram_url))
                        <a class="social-link" href="{{ $settings->instagram_url }}" target="_blank" rel="noopener"
                            aria-label="Instagram">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Z"
                                    stroke="currentColor" stroke-width="1.8" />
                                <path d="M12 17a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z" stroke="currentColor"
                                    stroke-width="1.8" />
                                <path d="M17.5 6.6h.01" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                            </svg>
                        </a>
                    @endif

                    @if (!empty($settings?->facebook_url))
                        <a class="social-link" href="{{ $settings->facebook_url }}" target="_blank" rel="noopener"
                            aria-label="Facebook">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M14 9h3V6h-3c-2.2 0-4 1.8-4 4v3H7v3h3v6h3v-6h3l1-3h-4v-3c0-.6.4-1 1-1Z"
                                    fill="currentColor" />
                            </svg>
                        </a>
                    @endif

                    @if (!empty($settings?->tiktok_url))
                        <a class="social-link" href="{{ $settings->tiktok_url }}" target="_blank" rel="noopener"
                            aria-label="TikTok">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path
                                    d="M15 3c.6 2.9 2.7 4.9 6 5v3c-2.3 0-4.3-.8-6-2.2V15a6 6 0 1 1-6-6c.4 0 .7 0 1 .1v3.2c-.3-.1-.7-.2-1-.2a3 3 0 1 0 3 3V3h3Z"
                                    fill="currentColor" />
                            </svg>
                        </a>
                    @endif

                    @if (!empty($settings?->whatsapp_url))
                        <a class="social-link" href="{{ $settings->whatsapp_url }}" target="_blank" rel="noopener"
                            aria-label="WhatsApp">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 2a10 10 0 0 0-8.7 14.9L2 22l5.3-1.3A10 10 0 1 0 12 2Z"
                                    stroke="currentColor" stroke-width="1.8" />
                                <path
                                    d="M9.2 8.7c.2-.4.4-.4.7-.4h.5c.2 0 .4 0 .6.5l.8 1.9c.1.3.1.5-.1.7l-.4.5c-.1.1-.2.3-.1.5.2.6 1.1 2.1 2.6 2.8.5.2.7.2.9 0l.6-.7c.2-.2.4-.2.6-.1l1.9.9c.3.2.5.3.5.6 0 .3-.1 1-.7 1.5-.6.5-1.3.6-1.8.5-.5 0-2-.4-3.8-2-1.8-1.6-2.7-3.6-2.9-4.1-.2-.6 0-1 .1-1.2l.4-.5Z"
                                    fill="currentColor" />
                            </svg>
                        </a>
                    @endif

                </div>
            @endif
        </div>

        {{-- Column 2: Menu --}}
        <div class="footer-col">
            <h5 class="footer-title">Menu</h5>
            <ul class="footer-links">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/akademik') }}">Akademik</a></li>
                <li><a href="{{ url('/blog') }}">Blog</a></li>
                <li><a href="{{ url('/dokumentasi') }}">Dokumentasi</a></li>
                <li><a href="{{ url('/layanan') }}">Layanan</a></li>
            </ul>
        </div>

        {{-- Column 3: Kontak --}}
        <div class="footer-col">
            <h5 class="footer-title">Kontak</h5>

            @if (!empty($settings?->address) || !empty($settings?->phone) || !empty($settings?->email))
                <ul class="footer-contact">

                    @if (!empty($settings?->address))
                        <li>
                            <span class="c-ic" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M12 21s7-4.4 7-11a7 7 0 1 0-14 0c0 6.6 7 11 7 11Z" stroke="currentColor"
                                        stroke-width="1.8" />
                                    <path d="M12 10.5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" stroke="currentColor"
                                        stroke-width="1.8" />
                                </svg>
                            </span>
                            <span class="c-tx">{{ $settings->address }}</span>
                        </li>
                    @endif

                    @if (!empty($settings?->phone))
                        <li>
                            <span class="c-ic" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M5 4h4l2 6-2.5 1.5a12 12 0 0 0 6 6L16 15l6 2v4c0 1-1 2-2 2C10.6 23 1 13.4 1 4c0-1 1-2 2-2Z"
                                        stroke="currentColor" stroke-width="1.8" />
                                </svg>
                            </span>
                            <span class="c-tx">{{ $settings->phone }}</span>
                        </li>
                    @endif

                    @if (!empty($settings?->email))
                        <li>
                            <span class="c-ic" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M4 6h16v12H4V6Z" stroke="currentColor" stroke-width="1.8" />
                                    <path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.8" />
                                </svg>
                            </span>
                            <span class="c-tx">{{ $settings->email }}</span>
                        </li>
                    @endif

                </ul>
            @endif
        </div>

        {{-- Column 4: Maps (paling kanan) --}}
        <div class="footer-col footer-mapscol">
            <h5 class="footer-title">Lokasi</h5>

            @if (!empty($settings?->maps_embed))
                <div class="footer-maps">
                    {!! $settings->maps_embed !!}
                </div>
            @endif
        </div>

    </div>

    <div class="footer-bottom">
        <div class="container footer-bottomwrap">
            <p>&copy; {{ date('Y') }}
                {{ data_get($settings, 'copyright_text', data_get($settings, 'site_name', 'SMK Negeri')) }}
            </p>
            <p class="footer-note">Dikelola oleh {{ data_get($settings, 'site_name', 'SMK Negeri') }}</p>
        </div>
    </div>
</footer>
