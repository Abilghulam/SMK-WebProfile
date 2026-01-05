@extends('layouts.app-admin')

@section('title', 'Kelola Item | Admin')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Item Album</h1>
                <p class="adm-subtitle">
                    <strong>{{ $gallery->title ?: 'Tanpa Judul' }}</strong>
                    <span class="adm-dot">•</span>
                    <span class="adm-muted">{{ $gallery->slug }}</span>
                </p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--primary" href="{{ route('admin.documentation.galleries.edit', $gallery) }}"> <span
                        class="adm-btn-ic"><svg class="w-[20px] h-[20px] text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                        </svg>
                    </span> Edit Album</a>

                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.documentation.galleries.index') }}"><span
                        class="adm-btn-ic"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left">
                            <path d="m15 18-6-6 6-6" />
                        </svg></span> Kembali</a>
            </div>
        </div>

        <section class="adm-card adm-card--pad">
            <form class="adm-doc-item-form" method="POST" action="{{ route('admin.documentation.items.store', $gallery) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="adm-form-grid">
                    <div class="adm-field">
                        <label class="adm-label">Tipe</label>
                        <select class="adm-select" name="type">
                            <option value="image" {{ old('type', 'image') === 'image' ? 'selected' : '' }}>Image</option>
                            <option value="video" {{ old('type', 'image') === 'video' ? 'selected' : '' }}>Video</option>
                        </select>
                        @error('type')
                            <div class="adm-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="adm-field adm-field--grow">
                        <label class="adm-label">Caption</label>
                        <input class="adm-input" type="text" name="caption" value="{{ old('caption') }}"
                            placeholder="Keterangan singkat...">
                        @error('caption')
                            <div class="adm-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="adm-field adm-field--full">
                        <label class="adm-label">File</label>
                        <input class="adm-input" type="file" name="file" required>
                        <div class="adm-help">Image: jpg/png/webp • Video: mp4/webm/ogg (maks 5MB).</div>
                        @error('file')
                            <div class="adm-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="adm-actions">
                        <button class="adm-btn adm-btn--primary" type="submit"> <span class="adm-btn-ic"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-image-plus-icon lucide-image-plus">
                                    <path d="M16 5h6" />
                                    <path d="M19 2v6" />
                                    <path d="M21 11.5V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7.5" />
                                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                                    <circle cx="9" cy="9" r="2" />
                                </svg></span>
                            Tambah Item
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <section class="adm-doc-items-grid">
            @forelse ($items as $it)
                <article class="adm-doc-item-card" data-doc-item data-item-id="{{ $it->id }}">
                    <div class="adm-doc-item-media">
                        @if ($it->type === 'video')
                            <video src="{{ asset('storage/' . $it->path) }}" controls></video>
                        @else
                            <img class="adm-doc-thumb" data-item-thumb src="{{ $it->url }}"
                                alt="{{ $it->caption ?? '' }}">
                        @endif
                    </div>

                    <div class="adm-doc-item-body">
                        <div class="adm-doc-item-top">
                            <span class="adm-badge">{{ strtoupper($it->type) }}</span>
                            <span class="adm-muted">#{{ $it->sort_order }}</span>
                        </div>

                        <div class="adm-doc-item-caption" data-item-caption>
                            {{ $it->caption ?? '—' }}
                        </div>

                        <div class="adm-doc-item-actions">
                            <button class="adm-icon-btn" type="button" title="Edit item" aria-label="Edit item"
                                data-item-edit data-item-id="{{ $it->id }}"
                                data-action="{{ route('admin.documentation.items.update', $it) }}"
                                data-caption="{{ $it->caption ?? '' }}" data-type="{{ $it->type ?? 'image' }}"
                                data-src="{{ $it->type === 'image' ? $it->url : '' }}">
                                <svg class="adm-btn-ic" class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                            </button>

                            <form method="POST" action="{{ route('admin.documentation.items.destroy', $it) }}"
                                onsubmit="return confirm('Hapus item ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="adm-icon-btn adm-icon-btn--delete" type="submit" title="Hapus"
                                    aria-label="Hapus">
                                    <svg class="adm-btn-ic" xmlns="http://www.w3.org/2000/svg" width="20"
                                        height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-trash2-icon lucide-trash-2">
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                        <path d="M3 6h18" />
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="adm-empty">
                    <div class="adm-empty-title">Belum ada item.</div>
                    <div class="adm-empty-sub">Tambahkan foto/video agar album tampil di halaman pengguna.</div>
                </div>
            @endforelse

            {{-- Modal Edit --}}
            <div class="adm-modal" data-item-modal hidden>
                <div class="adm-modal-backdrop" data-modal-close></div>

                <div class="adm-modal-card" role="dialog" aria-modal="true" aria-labelledby="admModalTitle">
                    <div class="adm-modal-head">
                        <div class="adm-modal-head-left">
                            <div class="adm-modal-ic" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7Z"
                                        stroke="currentColor" stroke-width="1.8" />
                                    <path d="M8.5 10.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" stroke="currentColor"
                                        stroke-width="1.8" />
                                    <path d="m21 16-5-5-6 6" stroke="currentColor" stroke-width="1.8"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>

                            <div class="adm-modal-title-wrap">
                                <div class="adm-modal-title" id="admModalTitle">Edit Item</div>
                                <div class="adm-modal-sub">Ubah gambar dan caption (opsional).</div>
                            </div>
                        </div>

                        <button type="button" class="adm-modal-x" data-modal-close aria-label="Tutup">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M7 7l10 10M17 7 7 17" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                        </button>
                    </div>

                    <form method="POST" enctype="multipart/form-data" data-item-form>
                        @csrf
                        @method('PATCH')

                        <div class="adm-modal-body">
                            {{-- Preview --}}
                            <div class="adm-modal-preview" data-preview-wrap>
                                <img class="adm-modal-img" data-preview-img alt="Preview" />
                                <div class="adm-modal-preview-fallback" data-preview-fallback hidden>
                                    Preview tidak tersedia.
                                </div>
                            </div>

                            {{-- Ganti file --}}
                            <div class="adm-field">
                                <label class="adm-label">Ganti Gambar (opsional)</label>

                                <label class="adm-file" for="admFileInput">
                                    <span class="adm-file-ic" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none">
                                            <path d="M12 16V4" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" />
                                            <path d="M8 8l4-4 4 4" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M4 20h16" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" />
                                        </svg>
                                    </span>
                                    <span class="adm-file-text" data-file-text>Pilih file</span>
                                    <span class="adm-file-hint">JPG/PNG/WebP</span>
                                </label>

                                <input id="admFileInput" class="adm-file-input" type="file" name="image"
                                    accept="image/*" data-file-input>
                                <div class="adm-help">Kosongkan jika tidak ingin mengganti gambar.</div>
                            </div>

                            {{-- Caption --}}
                            <div class="adm-field">
                                <label class="adm-label">Caption</label>
                                <textarea class="adm-input" name="caption" rows="3" placeholder="Tambahkan keterangan singkat..."
                                    data-caption-input></textarea>
                            </div>
                        </div>

                        <div class="adm-modal-actions">
                            <button type="button" class="adm-btn adm-btn--ghost" data-modal-close>Batal</button>
                            <button type="submit" class="adm-btn adm-btn--primary" data-save-btn><span
                                    class="adm-btn-ic"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                        height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-save-icon lucide-save">
                                        <path
                                            d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                                        <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                                        <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                                    </svg></span> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
