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
        <div class="adm-field adm-field--full">
            <label class="adm-label">Judul</label>
            <input class="adm-input" type="text" name="title" value="{{ old('title', $post->title ?? '') }}"
                required>
        </div>

        <div class="adm-field">
            <label class="adm-label">Type</label>
            <select name="type" class="adm-select" data-post-type>
                @foreach (\App\Models\Post::TYPE_LABELS as $key => $label)
                    <option value="{{ $key }}" {{ old('type', $post->type ?? '') === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="adm-field adm-field--grow">
            <label class="adm-label">Slug</label>
            <input class="adm-input adm-input--muted" type="text" name="slug"
                value="{{ old('slug', $post->slug ?? '') }}" placeholder="Slug otomatis dari judul" readonly>
        </div>

        <div class="adm-field">
            <label class="adm-label">Deskripsi Singkat</label>
            <textarea class="adm-textarea" name="excerpt" rows="3">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
        </div>

        <div class="adm-field">
            <label class="adm-label">Deskripsi</label>
            <textarea class="adm-textarea" name="content" rows="3">{{ old('content', $post->content ?? '') }}</textarea>
        </div>

        <div class="adm-field adm-field--full">
            <label class="adm-label">Upload Thumbnail (opsional)</label>
            <input class="adm-file" type="file" name="thumbnail_file" accept="image/*">
            <div class="adm-help">JPG/PNG/WEBP maks 2MB.</div>
        </div>

        <div class="adm-field" data-field="event_start_at">
            <label class="adm-label">Tanggal Mulai</label>
            <input type="datetime-local" name="event_start_at" class="adm-input"
                value="{{ old('event_start_at', optional($post->event_start_at ?? null)->format('Y-m-d\TH:i')) }}">
        </div>

        <div class="adm-field" data-field="event_end_at">
            <label class="adm-label">Tanggal Selesai</label>
            <input type="datetime-local" name="event_end_at" class="adm-input"
                value="{{ old('event_end_at', optional($post->event_end_at ?? null)->format('Y-m-d\TH:i')) }}">
        </div>

        <div class="adm-field adm-field--full" data-field="location">
            <label class="adm-label">Lokasi</label>
            <input type="text" name="location" class="adm-input"
                value="{{ old('location', $post->location ?? '') }}">
        </div>

        <div class="adm-field" data-field="level">
            <label class="adm-label">Level</label>
            <input type="text" name="level" class="adm-input" placeholder="Kabupaten / Provinsi / Nasional"
                value="{{ old('level', $post->level ?? '') }}">
        </div>

        <div class="adm-field" data-field="awarded_at">
            <label class="adm-label">Tanggal</label>
            <input type="date" name="awarded_at" class="adm-input"
                value="{{ old('awarded_at', optional($post->awarded_at ?? null)->format('Y-m-d')) }}">
        </div>

        <div class="adm-field adm-field--full">
            @php
                $isPublished = (int) old('is_published', $post->is_published ?? 1);
                $isFeatured = (int) old('is_featured', $post->is_featured ?? 0);
            @endphp

            <div class="adm-check-row" data-publish-row>
                {{-- Draft / Published as segmented toggles (radio) --}}
                <label class="adm-check">
                    <input type="radio" name="is_published" value="0" {{ $isPublished === 0 ? 'checked' : '' }}>
                    <span>Draft</span>
                </label>

                <label class="adm-check">
                    <input type="radio" name="is_published" value="1" {{ $isPublished === 1 ? 'checked' : '' }}>
                    <span>Published</span>
                </label>

                {{-- Featured --}}
                <label class="adm-check">
                    <input type="checkbox" name="is_featured" value="1" {{ $isFeatured ? 'checked' : '' }}>
                    <span>Featured</span>
                </label>
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
