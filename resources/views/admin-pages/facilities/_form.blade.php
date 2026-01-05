@php
    $isActiveOld = old('is_active', $facility->is_active ?? 1);
@endphp

<div class="adm-fac-form-grid">
    <div class="adm-field">
        <label class="adm-label">Nama Fasilitas</label>
        <input class="adm-input" type="text" name="name" value="{{ old('name', $facility->name) }}" required>
        @error('name')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field">
        <label class="adm-label">Kategori</label>
        <select class="adm-select" name="category" required>
            @foreach ($categories as $key => $label)
                <option value="{{ $key }}"
                    {{ old('category', $facility->category ?? 'indoor') === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('category')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field">
        <label class="adm-label">Urutan</label>
        <input class="adm-input" type="number" name="sort_order" min="0"
            value="{{ old('sort_order', $facility->sort_order ?? 0) }}">
        @error('sort_order')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field adm-field--full">
        <label class="adm-label">Deskripsi</label>
        <textarea class="adm-input" name="description" rows="6" required>{{ old('description', $facility->description) }}</textarea>
        @error('description')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field adm-field--full">
        <label class="adm-label">Gambar (opsional)</label>

        @if (!empty($facility->image))
            <div class="adm-fac-cover-preview">
                <img src="{{ asset('storage/' . $facility->image) }}" alt="{{ $facility->name }}">
            </div>
        @endif

        <input class="adm-input" type="file" name="image" accept="image/*">
        @error('image')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field adm-field--full">
        <label class="adm-label">Status</label>
        <div class="adm-fac-radio">
            <label class="adm-check">
                <input type="radio" name="is_active" value="1" {{ (int) $isActiveOld === 1 ? 'checked' : '' }}>
                <span>Aktif</span>
            </label>
            <label class="adm-check">
                <input type="radio" name="is_active" value="0" {{ (int) $isActiveOld === 0 ? 'checked' : '' }}>
                <span>Nonaktif</span>
            </label>
        </div>
        @error('is_active')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>
</div>
