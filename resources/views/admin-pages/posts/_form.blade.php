@php
    $isEdit = ($mode ?? 'create') === 'edit';
    $action = $isEdit ? route('admin.posts.update', $post) : route('admin.posts.store');
@endphp

<form class="adm-form" method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    @if ($errors->any())
        <div class="adm-alert adm-alert--danger">
            <div class="adm-alert-title">Periksa input</div>
            <ul class="adm-alert-list">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="adm-form-grid">
        <div class="adm-field">
            <label class="adm-label">Type</label>
            <select class="adm-select" name="type" required>
                @foreach ($typeOptions as $k => $v)
                    <option value="{{ $k }}"
                        {{ old('type', $post->type ?? 'news') === $k ? 'selected' : '' }}>
                        {{ $v }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="adm-field">
            <label class="adm-label">Slug (opsional)</label>
            <input class="adm-input" type="text" name="slug" value="{{ old('slug', $post->slug ?? '') }}"
                placeholder="otomatis dari judul">
            <div class="adm-help">Kosongkan untuk auto.</div>
        </div>

        <div class="adm-field adm-field--full">
            <label class="adm-label">Judul</label>
            <input class="adm-input" type="text" name="title" value="{{ old('title', $post->title ?? '') }}"
                required>
        </div>

        <div class="adm-field adm-field--full">
            <label class="adm-label">Deskripsi Singkat</label>
            <textarea class="adm-textarea" name="excerpt" rows="3">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
        </div>

        <div class="adm-field adm-field--full">
            <label class="adm-label">Deskripsi</label>
            <textarea class="adm-textarea" name="content" rows="10">{{ old('content', $post->content ?? '') }}</textarea>
        </div>

        <div class="adm-field adm-field--full">
            <label class="adm-label">Upload Thumbnail (opsional)</label>
            <input class="adm-file" type="file" name="thumbnail_file" accept="image/*">
            <div class="adm-help">JPG/PNG/WEBP maks 2MB.</div>
        </div>

        <div class="adm-field">
            <label class="adm-label">Event Start (opsional)</label>
            <input class="adm-input" type="datetime-local" name="event_start_at"
                value="{{ old('event_start_at', optional($post->event_start_at ?? null)->format('Y-m-d\TH:i')) }}">
        </div>

        <div class="adm-field">
            <label class="adm-label">Event End (opsional)</label>
            <input class="adm-input" type="datetime-local" name="event_end_at"
                value="{{ old('event_end_at', optional($post->event_end_at ?? null)->format('Y-m-d\TH:i')) }}">
        </div>

        <div class="adm-field adm-field--full">
            <label class="adm-label">Lokasi (opsional)</label>
            <input class="adm-input" type="text" name="location"
                value="{{ old('location', $post->location ?? '') }}">
        </div>

        <div class="adm-field">
            <label class="adm-label">Level (opsional)</label>
            <input class="adm-input" type="text" name="level" value="{{ old('level', $post->level ?? '') }}"
                placeholder="Kabupaten/Provinsi/Nasional">
        </div>

        <div class="adm-field">
            <label class="adm-label">Awarded At (opsional)</label>
            <input class="adm-input" type="date" name="awarded_at"
                value="{{ old('awarded_at', optional($post->awarded_at ?? null)->format('Y-m-d')) }}">
        </div>

        <div class="adm-field adm-field--full">
            <div class="adm-check-row">
                <label class="adm-check">
                    <input type="checkbox" name="is_published" value="1"
                        {{ old('is_published', $post->is_published ?? 1) ? 'checked' : '' }}>
                    <span>Published</span>
                </label>

                <label class="adm-check">
                    <input type="checkbox" name="is_featured" value="1"
                        {{ old('is_featured', $post->is_featured ?? 0) ? 'checked' : '' }}>
                    <span>Featured</span>
                </label>

                <div class="adm-publish-at">
                    <label class="adm-label" style="margin:0;">Published At (opsional)</label>
                    <input class="adm-input" type="datetime-local" name="published_at"
                        value="{{ old('published_at', optional($post->published_at ?? null)->format('Y-m-d\TH:i')) }}">
                </div>
            </div>
        </div>
    </div>

    <div class="adm-form-actions">
        <button class="adm-btn adm-btn--primary" type="submit">
            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Post' }}
        </button>

        <a class="adm-btn adm-btn--ghost" href="{{ route('admin.posts.index') }}">Batal</a>
    </div>
</form>
