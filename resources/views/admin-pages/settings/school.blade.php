@extends('layouts.app-admin-settings')

@section('title', 'Settings | Informasi Sekolah')

@section('content')
    <section class="adm-setting-page" aria-label="Informasi Sekolah">
        <header class="adm-setting-page-head">
            <h1 class="adm-setting-page-title">Informasi Sekolah</h1>
            <p class="adm-setting-page-sub">
                Kelola detail yang membuat Website berfungsi lebih baik untuk Anda, dan tentukan info apa yang dapat dilihat
                orang lain
            </p>
        </header>

        <div class="adm-setting-stack" role="list">
            <button type="button" class="adm-setting-item" data-open-modal="identitas" role="listitem">
                <span class="adm-setting-item-ic" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-user-round-icon lucide-user-round">
                        <circle cx="12" cy="8" r="5" />
                        <path d="M20 21a8 8 0 0 0-16 0" />
                    </svg>
                </span>

                <span class="adm-setting-item-main">
                    <span class="adm-setting-item-title">Identitas</span>
                    <span class="adm-setting-item-sub">Nama situs, logo, favicon</span>
                </span>
                <span class="adm-setting-item-go" aria-hidden="true"><i data-lucide="chevron-right"></i></span>
            </button>

            <button type="button" class="adm-setting-item" data-open-modal="kontak" role="listitem">
                <span class="adm-setting-item-ic" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-map-pin-icon lucide-map-pin">
                        <path
                            d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                </span>

                <span class="adm-setting-item-main">
                    <span class="adm-setting-item-title">Kontak & Lokasi</span>
                    <span class="adm-setting-item-sub">Telepon, email, alamat, maps embed</span>
                </span>
                <span class="adm-setting-item-go" aria-hidden="true"><i data-lucide="chevron-right"></i></span>
            </button>

            <button type="button" class="adm-setting-item" data-open-modal="sosial" role="listitem">
                <span class="adm-setting-item-ic" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-badge-check-icon lucide-badge-check">
                        <path
                            d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z" />
                        <path d="m9 12 2 2 4-4" />
                    </svg>
                </span>

                <span class="adm-setting-item-main">
                    <span class="adm-setting-item-title">Sosial Media</span>
                    <span class="adm-setting-item-sub">Instagram, Facebook, TikTok, WhatsApp</span>
                </span>
                <span class="adm-setting-item-go" aria-hidden="true"><i data-lucide="chevron-right"></i></span>
            </button>

            <button type="button" class="adm-setting-item" data-open-modal="footer" role="listitem">
                <span class="adm-setting-item-ic" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-layout-panel-top-icon lucide-layout-panel-top">
                        <rect width="18" height="7" x="3" y="3" rx="1" />
                        <rect width="7" height="7" x="3" y="14" rx="1" />
                        <rect width="7" height="7" x="14" y="14" rx="1" />
                    </svg>
                </span>
                <span class="adm-setting-item-main">
                    <span class="adm-setting-item-title">Footer</span>
                    <span class="adm-setting-item-sub">Footer about & copyright</span>
                </span>
                <span class="adm-setting-item-go" aria-hidden="true"><i data-lucide="chevron-right"></i></span>
            </button>
        </div>
    </section>

    {{-- MODAL SHELL (single modal, isi diganti via section) --}}
    <div class="adm-setting-modal" id="admSettingModal" aria-hidden="true">
        <div class="adm-setting-modal-backdrop" data-close-modal></div>

        <div class="adm-setting-modal-dialog" role="dialog" aria-modal="true" aria-label="Edit Informasi Sekolah">
            <div class="adm-setting-modal-head">
                <div class="adm-setting-modal-title" id="admSettingModalTitle">Edit</div>
                <button class="adm-setting-modal-x" type="button" aria-label="Tutup" data-close-modal>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-x-icon lucide-x">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>

            <div class="adm-setting-modal-body">

                {{-- =======================
                     IDENTITAS
                     ======================= --}}
                <form class="adm-setting-modal-form" id="form-identitas" method="POST"
                    action="{{ route('admin.settings.school.update') }}" enctype="multipart/form-data" hidden>
                    @csrf
                    @method('PATCH')

                    <div class="adm-setting-field">
                        <label class="adm-setting-label" for="site_name">Nama Situs</label>
                        <input class="adm-setting-input" id="site_name" name="site_name" type="text"
                            value="{{ old('site_name', $settings->site_name) }}" placeholder="SMK Negeri ...">
                    </div>

                    <div class="adm-setting-field-grid">
                        <div class="adm-setting-field">
                            <label class="adm-setting-label" for="logo">Logo</label>
                            <input class="adm-setting-input" id="logo" name="logo" type="file"
                                accept="image/*">
                            @if (!empty($settings->logo))
                                <div class="adm-setting-preview">
                                    <img src="{{ asset($settings->logo) }}" alt="Logo" loading="lazy">
                                    <div class="adm-setting-muted">{{ $settings->logo }}</div>
                                </div>
                            @endif
                        </div>

                        <div class="adm-setting-field">
                            <label class="adm-setting-label" for="favicon">Favicon</label>
                            <input class="adm-setting-input" id="favicon" name="favicon" type="file"
                                accept="image/*">
                            @if (!empty($settings->favicon))
                                <div class="adm-setting-preview">
                                    <img src="{{ asset($settings->favicon) }}" alt="Favicon" loading="lazy">
                                    <div class="adm-setting-muted">{{ $settings->favicon }}</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="adm-setting-modal-actions">
                        <button class="adm-setting-btn adm-setting-btn--primary" type="submit">Simpan</button>
                        <button class="adm-setting-btn" type="button" data-close-modal>Batal</button>
                    </div>
                </form>

                {{-- =======================
                     KONTAK
                     ======================= --}}
                <form class="adm-setting-modal-form" id="form-kontak" method="POST"
                    action="{{ route('admin.settings.school.update') }}" hidden>
                    @csrf
                    @method('PATCH')

                    <div class="adm-setting-field-grid">
                        <div class="adm-setting-field">
                            <label class="adm-setting-label" for="phone">Telepon</label>
                            <input class="adm-setting-input" id="phone" name="phone" type="text"
                                value="{{ old('phone', $settings->phone) }}" placeholder="08xx-xxxx-xxxx">
                        </div>

                        <div class="adm-setting-field">
                            <label class="adm-setting-label" for="email">Email</label>
                            <input class="adm-setting-input" id="email" name="email" type="text"
                                value="{{ old('email', $settings->email) }}" placeholder="email@domain.com">
                        </div>
                    </div>

                    <div class="adm-setting-field">
                        <label class="adm-setting-label" for="address">Alamat</label>
                        <textarea class="adm-setting-textarea" id="address" name="address" rows="3"
                            placeholder="Alamat sekolah...">{{ old('address', $settings->address) }}</textarea>
                    </div>

                    <div class="adm-setting-field">
                        <label class="adm-setting-label" for="maps_embed">Maps Embed</label>
                        <textarea class="adm-setting-textarea" id="maps_embed" name="maps_embed" rows="4"
                            placeholder="Tempel kode embed Google Maps...">{{ old('maps_embed', $settings->maps_embed) }}</textarea>
                        <div class="adm-setting-help">Boleh isi iframe embed.</div>
                    </div>

                    <div class="adm-setting-modal-actions">
                        <button class="adm-setting-btn adm-setting-btn--primary" type="submit">Simpan</button>
                        <button class="adm-setting-btn" type="button" data-close-modal>Batal</button>
                    </div>
                </form>

                {{-- =======================
                     SOSIAL
                     ======================= --}}
                <form class="adm-setting-modal-form" id="form-sosial" method="POST"
                    action="{{ route('admin.settings.school.update') }}" hidden>
                    @csrf
                    @method('PATCH')

                    <div class="adm-setting-field">
                        <label class="adm-setting-label" for="instagram_url">Instagram URL</label>
                        <input class="adm-setting-input" id="instagram_url" name="instagram_url" type="text"
                            value="{{ old('instagram_url', $settings->instagram_url) }}"
                            placeholder="https://instagram.com/...">
                    </div>

                    <div class="adm-setting-field">
                        <label class="adm-setting-label" for="facebook_url">Facebook URL</label>
                        <input class="adm-setting-input" id="facebook_url" name="facebook_url" type="text"
                            value="{{ old('facebook_url', $settings->facebook_url) }}"
                            placeholder="https://facebook.com/...">
                    </div>

                    <div class="adm-setting-field">
                        <label class="adm-setting-label" for="tiktok_url">TikTok URL</label>
                        <input class="adm-setting-input" id="tiktok_url" name="tiktok_url" type="text"
                            value="{{ old('tiktok_url', $settings->tiktok_url) }}" placeholder="https://tiktok.com/@...">
                    </div>

                    <div class="adm-setting-field">
                        <label class="adm-setting-label" for="whatsapp_url">WhatsApp URL</label>
                        <input class="adm-setting-input" id="whatsapp_url" name="whatsapp_url" type="text"
                            value="{{ old('whatsapp_url', $settings->whatsapp_url) }}" placeholder="https://wa.me/...">
                    </div>

                    <div class="adm-setting-modal-actions">
                        <button class="adm-setting-btn adm-setting-btn--primary" type="submit">Simpan</button>
                        <button class="adm-setting-btn" type="button" data-close-modal>Batal</button>
                    </div>
                </form>

                {{-- =======================
                     FOOTER
                     ======================= --}}
                <form class="adm-setting-modal-form" id="form-footer" method="POST"
                    action="{{ route('admin.settings.school.update') }}" hidden>
                    @csrf
                    @method('PATCH')

                    <div class="adm-setting-field">
                        <label class="adm-setting-label" for="footer_about">Footer About</label>
                        <textarea class="adm-setting-textarea" id="footer_about" name="footer_about" rows="4"
                            placeholder="Tentang sekolah...">{{ old('footer_about', $settings->footer_about) }}</textarea>
                    </div>

                    <div class="adm-setting-field">
                        <label class="adm-setting-label" for="copyright_text">Copyright</label>
                        <input class="adm-setting-input" id="copyright_text" name="copyright_text" type="text"
                            value="{{ old('copyright_text', $settings->copyright_text) }}" placeholder="© 2026 ...">
                    </div>

                    <div class="adm-setting-modal-actions">
                        <button class="adm-setting-btn adm-setting-btn--primary" type="submit">Simpan</button>
                        <button class="adm-setting-btn" type="button" data-close-modal>Batal</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            const modal = document.getElementById('admSettingModal');
            const titleEl = document.getElementById('admSettingModalTitle');

            const forms = {
                identitas: document.getElementById('form-identitas'),
                kontak: document.getElementById('form-kontak'),
                sosial: document.getElementById('form-sosial'),
                footer: document.getElementById('form-footer'),
            };

            const titles = {
                identitas: 'Edit Identitas',
                kontak: 'Edit Kontak & Lokasi',
                sosial: 'Edit Sosial Media',
                footer: 'Edit Footer',
            };

            function lockScroll(lock) {
                document.documentElement.classList.toggle('adm-setting-lock', !!lock);
                document.body.classList.toggle('adm-setting-lock', !!lock);
            }

            function openModal(key) {
                Object.values(forms).forEach(f => f && (f.hidden = true));
                if (forms[key]) forms[key].hidden = false;

                titleEl.textContent = titles[key] || 'Edit';
                modal.setAttribute('aria-hidden', 'false');
                modal.classList.add('is-open');
                lockScroll(true);

                // Fokus ke input pertama agar terasa “app-like”
                const first = modal.querySelector(
                    '.adm-setting-modal-form:not([hidden]) input, .adm-setting-modal-form:not([hidden]) textarea');
                if (first) setTimeout(() => first.focus(), 50);
            }

            function closeModal() {
                modal.setAttribute('aria-hidden', 'true');
                modal.classList.remove('is-open');
                lockScroll(false);
            }

            document.addEventListener('click', (e) => {
                const openBtn = e.target.closest('[data-open-modal]');
                if (openBtn) {
                    openModal(openBtn.getAttribute('data-open-modal'));
                    return;
                }
                if (e.target.closest('[data-close-modal]')) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
            });
        })();
    </script>
@endpush
