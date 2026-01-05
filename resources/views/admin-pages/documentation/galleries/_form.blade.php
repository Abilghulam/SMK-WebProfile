@php
    $isEdit = isset($gallery) && $gallery->exists;
    $isEdited = !empty($gallery->id);
@endphp

<div class="adm-form-grid">
    <div class="adm-field adm-field--full">
        <label class="adm-label">Judul (opsional)</label>
        <input class="adm-input" type="text" name="title" value="{{ old('title', $gallery->title ?? '') }}"
            placeholder="Contoh: Kegiatan MPLS 2025">
        @error('title')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field adm-field--grow">
        <label class="adm-label">Slug</label>
        <input class="adm-input" type="text" name="slug" value="{{ old('slug', $gallery->slug ?? '') }}"
            placeholder="Slug otomatis dari judul" readonly>
        @error('slug')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field">
        <label class="adm-label">Kategori</label>
        <input class="adm-input" type="text" name="category" value="{{ old('category', $gallery->category ?? '') }}"
            placeholder="Contoh: kegiatan / prestasi">
        @error('category')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field">
        <label class="adm-label">Tanggal Event</label>
        <input class="adm-input" type="date" name="event_date"
            value="{{ old('event_date', optional($gallery->event_date ?? null)->format('Y-m-d')) }}">
        @error('event_date')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field adm-field--full">
        <label class="adm-label">Deskripsi</label>
        <textarea class="adm-textarea" name="description" rows="4" placeholder="Ringkasan album...">{{ old('description', $gallery->description ?? '') }}</textarea>
        @error('description')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field adm-field--full">
        <label class="adm-label">Cover Image {{ $isEdit ? '(opsional)' : '(wajib)' }}</label>

        @if ($isEdit && !empty($gallery->cover_url))
            <div class="adm-doc-cover-preview">
                <img src="{{ $gallery->cover_url }}" alt="cover">
            </div>
        @endif

        <input class="adm-input" type="file" name="cover_image" accept="image/*">
        <div class="adm-help">JPG/PNG/WEBP maks 2MB.</div>
        @error('cover_image')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field adm-field--full">
        <div class="adm-check-row">
            <label class="adm-check">
                <input type="checkbox" name="is_published" value="1"
                    {{ old('is_published', $gallery->is_published ?? 1) ? 'checked' : '' }}>
                <span>Published</span>
            </label>
        </div>
        @error('is_published')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-actions">
        <button class="adm-btn adm-btn--primary" type="submit">
            <span class="adm-btn-ic"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-save-icon lucide-save">
                    <path
                        d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                    <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                    <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                </svg></span>
            {{ $isEdited ? 'Simpan Perubahan' : 'Simpan Album' }}
        </button>
        <a class="adm-btn adm-btn--ghost" href="{{ route('admin.documentation.galleries.index') }}">Batal</a>
    </div>
</div>
