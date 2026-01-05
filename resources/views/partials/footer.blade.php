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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-instagram-icon lucide-instagram">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                            </svg>
                        </a>
                    @endif

                    @if (!empty($settings?->facebook_url))
                        <a class="social-link" href="{{ $settings->facebook_url }}" target="_blank" rel="noopener"
                            aria-label="Facebook">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M13.135 6H15V3h-1.865a4.147 4.147 0 0 0-4.142 4.142V9H7v3h2v9.938h3V12h2.021l.592-3H12V6.591A.6.6 0 0 1 12.592 6h.543Z"
                                    clip-rule="evenodd" />
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
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M12 4a8 8 0 0 0-6.895 12.06l.569.718-.697 2.359 2.32-.648.379.243A8 8 0 1 0 12 4ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.96 9.96 0 0 1-5.016-1.347l-4.948 1.382 1.426-4.829-.006-.007-.033-.055A9.958 9.958 0 0 1 2 12Z"
                                    clip-rule="evenodd" />
                                <path fill="currentColor"
                                    d="M16.735 13.492c-.038-.018-1.497-.736-1.756-.83a1.008 1.008 0 0 0-.34-.075c-.196 0-.362.098-.49.291-.146.217-.587.732-.723.886-.018.02-.042.045-.057.045-.013 0-.239-.093-.307-.123-1.564-.68-2.751-2.313-2.914-2.589-.023-.04-.024-.057-.024-.057.005-.021.058-.074.085-.101.08-.079.166-.182.249-.283l.117-.14c.121-.14.175-.25.237-.375l.033-.066a.68.68 0 0 0-.02-.64c-.034-.069-.65-1.555-.715-1.711-.158-.377-.366-.552-.655-.552-.027 0 0 0-.112.005-.137.005-.883.104-1.213.311-.35.22-.94.924-.94 2.16 0 1.112.705 2.162 1.008 2.561l.041.06c1.161 1.695 2.608 2.951 4.074 3.537 1.412.564 2.081.63 2.461.63.16 0 .288-.013.4-.024l.072-.007c.488-.043 1.56-.599 1.804-1.276.192-.534.243-1.117.115-1.329-.088-.144-.239-.216-.43-.308Z" />
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-map-pin-icon lucide-map-pin">
                                    <path
                                        d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                    <circle cx="12" cy="10" r="3" />
                                </svg>
                            </span>
                            <span class="c-tx">{{ $settings->address }}</span>
                        </li>
                    @endif

                    @if (!empty($settings?->phone))
                        <li>
                            <span class="c-ic" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-phone-icon lucide-phone">
                                    <path
                                        d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                                </svg>
                            </span>
                            <span class="c-tx">{{ $settings->phone }}</span>
                        </li>
                    @endif

                    @if (!empty($settings?->email))
                        <li>
                            <span class="c-ic" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-mail-icon lucide-mail">
                                    <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7" />
                                    <rect x="2" y="4" width="20" height="16" rx="2" />
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
