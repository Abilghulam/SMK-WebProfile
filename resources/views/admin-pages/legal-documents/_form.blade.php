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
        <input class="adm-select" type="file" name="file" accept="application/pdf">
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
        <div class="adm-check-row">
            <label class="adm-check">
                <input type="checkbox" name="is_published" value="1"
                    {{ old('is_published', $doc->is_published ?? 1) ? 'checked' : '' }}>
                <span>Published</span>
            </label>

            <div class="adm-publish-at">
                <label class="adm-label" style="margin:0;">Published At</label>
                <input class="adm-input" type="datetime-local" name="published_at"
                    value="{{ old('published_at', optional($doc->published_at ?? null)->format('Y-m-d\TH:i')) }}">
            </div>
        </div>
        @error('published_at')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-form-actions">
        <button class="adm-btn adm-btn--primary" type="submit">
            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Dokumen' }}
        </button>
        <a class="adm-btn adm-btn--ghost" href="{{ route('admin.legal-documents.index') }}">Batal</a>
    </div>
</div>
