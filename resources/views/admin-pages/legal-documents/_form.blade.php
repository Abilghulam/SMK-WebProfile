@php
    $isEdit = !empty($doc->id);
    $hasExistingFile = $isEdit && !empty($doc->file_path);
@endphp

<div class="adm-form-grid">
    <div class="adm-field adm-field--full">
        <label class="adm-label">Judul</label>
        <input class="adm-input" type="text" name="title" value="{{ old('title', $doc->title) }}" required>
        @error('title')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    @php
        $categoryOptions = [
            'legalitas' => 'Legalitas',
            'template' => 'Template',
            'administrasi' => 'Administrasi',
            'panduan' => 'Panduan',
        ];

        $selectedCategory = old('category', $doc->category ?? 'legalitas');
    @endphp

    <div class="adm-field">
        <label class="adm-label">Kategori</label>

        <select class="adm-select" name="category" required>
            @foreach ($categoryOptions as $value => $label)
                <option value="{{ $value }}" {{ $selectedCategory === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        @error('category')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>


    <div class="adm-field adm-field--grow">
        <label class="adm-label">Slug</label>
        <input class="adm-input adm-input--muted" type="text" name="slug" value="{{ old('slug', $doc->slug) }}"
            readonly placeholder="Slug otomatis dari judul">
        @error('slug')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field adm-field--full">
        <label class="adm-label">Deskripsi</label>
        <textarea class="adm-input" name="description" rows="4">{{ old('description', $doc->description) }}</textarea>
        @error('description')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field">
        <label class="adm-label">Upload PDF</label>
        <input class="adm-file" type="file" name="file" accept="application/pdf">
        <div class="adm-help">PDF maks 5MB.</div>
        @error('file')
            <div class="adm-error">{{ $message }}</div>
        @enderror

        @if ($hasExistingFile)
            <input type="hidden" name="keep_existing_file" value="1">
            <div class="adm-help">
                File saat ini: <strong>{{ basename($doc->file_path) }}</strong>
            </div>
        @endif
    </div>

    <div class="adm-field">
        <label class="adm-label">External URL (opsional)</label>
        <input class="adm-input" type="url" name="external_url"
            value="{{ old('external_url', $doc->external_url) }}" placeholder="https://...">
        <div class="adm-help">Jika tidak upload PDF, isi URL ini.</div>
        @error('external_url')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field adm-field--full">
        <div class="adm-field adm-field--full">
            <div class="adm-check-row">
                @php
                    // Default: published (1)
                    $pubVal = (string) old('is_published', isset($doc) ? (int) $doc->is_published : 1);
                @endphp

                <label class="adm-check">
                    <input type="radio" name="is_published" value="1" {{ $pubVal === '1' ? 'checked' : '' }}>
                    <span>Published</span>
                </label>

                <label class="adm-check">
                    <input type="radio" name="is_published" value="0" {{ $pubVal === '0' ? 'checked' : '' }}>
                    <span>Draft</span>
                </label>
            </div>

            @error('is_published')
                <div class="adm-error">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="adm-form-actions">
        <button class="adm-btn adm-btn--primary" type="submit">
            <span class="adm-btn-ic"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-save-icon lucide-save">
                    <path
                        d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                    <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                    <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                </svg></span>
            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Dokumen' }}
        </button>
        <a class="adm-btn adm-btn--ghost" href="{{ route('admin.legal-documents.index') }}">Batal</a>
    </div>
</div>
