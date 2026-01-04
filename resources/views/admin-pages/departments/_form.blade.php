@php
    // Convert arrays -> textarea lines
    $competenciesText = old(
        'competencies_text',
        is_array($department->competencies ?? null) ? implode("\n", $department->competencies) : '',
    );
    $careerText = old(
        'career_opportunities_text',
        is_array($department->career_opportunities ?? null) ? implode("\n", $department->career_opportunities) : '',
    );
    $activitiesText = old(
        'learning_activities_text',
        is_array($department->learning_activities ?? null) ? implode("\n", $department->learning_activities) : '',
    );
@endphp

<div class="adm-dep-form-grid">
    <div class="adm-field">
        <label class="adm-label">Nama Program</label>
        <input class="adm-input" type="text" name="name" value="{{ old('name', $department->name) }}" required>
        @error('name')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field">
        <label class="adm-label">Slug</label>
        <input class="adm-input adm-input--muted" type="text" name="slug"
            value="{{ old('slug', $department->slug) }}" placeholder="otomatis dari nama" readonly>
        <div class="adm-help">Slug otomatis dari nama. Tidak perlu diubah.</div>
        @error('slug')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field">
        <label class="adm-label">Ringkasan Singkat</label>
        <input class="adm-input" type="text" name="short_description"
            value="{{ old('short_description', $department->short_description) }}"
            placeholder="Satu kalimat ringkas (opsional)">
        @error('short_description')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field">
        <label class="adm-label">Durasi (tahun)</label>
        <input class="adm-input" type="number" name="duration_years" min="1" max="10"
            value="{{ old('duration_years', $department->duration_years ?? 3) }}" required>
        @error('duration_years')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field adm-field--full">
        <label class="adm-label">Deskripsi</label>
        <textarea class="adm-input" name="description" rows="6" required placeholder="Deskripsi lengkap program...">{{ old('description', $department->description) }}</textarea>
        @error('description')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field">
        <label class="adm-label">Model Pembelajaran</label>
        <input class="adm-input" type="text" name="learning_model"
            value="{{ old('learning_model', $department->learning_model) }}" placeholder="Contoh: Teaching Factory">
        @error('learning_model')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field">
        <label class="adm-label">Profil Lulusan</label>
        <input class="adm-input" type="text" name="graduate_profile"
            value="{{ old('graduate_profile', $department->graduate_profile) }}"
            placeholder="Contoh: Teknisi, Operator, Wirausaha">
        @error('graduate_profile')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field adm-field--full">
        <label class="adm-label">Cover Image (opsional)</label>
        <input class="adm-input" type="file" name="image" accept="image/*">
        <div class="adm-help">Rekomendasi: JPG/PNG, landscape.</div>
        @error('image')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="adm-field adm-field--full">
        <label class="adm-label">Kompetensi (1 baris = 1 item)</label>
        <textarea class="adm-input" name="competencies_text" rows="5"
            placeholder="Contoh:
Perakitan komputer
Jaringan dasar
Troubleshooting">{{ $competenciesText }}</textarea>
    </div>

    <div class="adm-field adm-field--full">
        <label class="adm-label">Peluang Karier (1 baris = 1 item)</label>
        <textarea class="adm-input" name="career_opportunities_text" rows="5"
            placeholder="Contoh:
Teknisi komputer
Administrator jaringan">{{ $careerText }}</textarea>
    </div>

    <div class="adm-field adm-field--full">
        <label class="adm-label">Aktivitas Pembelajaran (1 baris = 1 item)</label>
        <textarea class="adm-input" name="learning_activities_text" rows="5"
            placeholder="Contoh:
Praktikum lab
Kunjungan industri">{{ $activitiesText }}</textarea>
    </div>

    <div class="adm-field">
        <label class="adm-label">PKL / Internship</label>
        <div class="adm-dep-radio">
            <label class="adm-check">
                <input type="radio" name="has_internship" value="1"
                    {{ old('has_internship', $department->has_internship ?? 1) ? 'checked' : '' }}>
                <span>Ya</span>
            </label>

            <label class="adm-check">
                <input type="radio" name="has_internship" value="0"
                    {{ !old('has_internship', $department->has_internship ?? 1) ? 'checked' : '' }}>
                <span>Tidak</span>
            </label>
        </div>
        @error('has_internship')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>


    <div class="adm-field">
        <label class="adm-label">Status</label>
        <div class="adm-dep-radio">
            <label class="adm-check">
                <input type="radio" name="is_active" value="1"
                    {{ old('is_active', $department->is_active ?? 1) ? 'checked' : '' }}>
                <span>Aktif</span>
            </label>

            <label class="adm-check">
                <input type="radio" name="is_active" value="0"
                    {{ !old('is_active', $department->is_active ?? 1) ? 'checked' : '' }}>
                <span>Nonaktif</span>
            </label>
        </div>
        @error('is_active')
            <div class="adm-error">{{ $message }}</div>
        @enderror
    </div>
</div>

<script>
    // Auto-fill slug (read-only) from name (client-side) - optional "professional"
    document.addEventListener("DOMContentLoaded", () => {
        const nameInput = document.querySelector('input[name="name"]');
        const slugInput = document.querySelector('input[name="slug"]');
        if (!nameInput || !slugInput) return;

        const slugify = (str) =>
            (str || "")
            .toString()
            .trim()
            .toLowerCase()
            .normalize("NFD").replace(/[\u0300-\u036f]/g, "")
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/(^-|-$)/g, "");

        nameInput.addEventListener("input", () => {
            if (slugInput.dataset.locked === "1") return;
            slugInput.value = slugify(nameInput.value);
        });
    });
</script>
