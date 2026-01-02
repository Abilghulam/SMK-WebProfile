@extends('layouts.app-admin')

@section('kicker', 'Home')
@section('page_title', 'Edit School Profile')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Profil Sekolah</h1>
                <p class="adm-subtitle">Edit identitas & profil sekolah</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.home.index') }}">Kembali</a>
            </div>
        </div>

        <section class="adm-card adm-card--pad">
            <form method="POST" action="{{ route('admin.home.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="adm-form-grid">
                    <div class="adm-field">
                        <label class="adm-label">Nama Sekolah</label>
                        <input class="adm-input" type="text" name="school_name"
                            value="{{ old('school_name', $profile->school_name) }}">
                    </div>

                    <div class="adm-field">
                        <label class="adm-label">Slogan</label>
                        <input class="adm-input" type="text" name="slogan"
                            value="{{ old('slogan', $profile->slogan) }}">
                    </div>

                    <div class="adm-field adm-field--full">
                        <label class="adm-label">Deskripsi Singkat</label>
                        <textarea class="adm-textarea" name="short_description" rows="3">{{ old('short_description', $profile->short_description) }}</textarea>
                    </div>

                    <div class="adm-field adm-field--full">
                        <label class="adm-label">Sejarah Singkat</label>
                        <textarea class="adm-textarea" name="history" rows="6">{{ old('history', $profile->history) }}</textarea>
                    </div>

                    <div class="adm-field">
                        <label class="adm-label">Visi</label>
                        <textarea class="adm-textarea" name="vision" rows="4">{{ old('vision', $profile->vision) }}</textarea>
                    </div>

                    <div class="adm-field">
                        <label class="adm-label">Misi</label>
                        <textarea class="adm-textarea" name="mission" rows="4">{{ old('mission', $profile->mission) }}</textarea>
                        <div class="adm-help">Kalau di user-page kamu pakai bullet/line, bisa isi per baris.</div>
                    </div>

                    <div class="adm-field">
                        <label class="adm-label">NPSN</label>
                        <input class="adm-input" type="text" name="npsn" value="{{ old('npsn', $profile->npsn) }}">
                    </div>

                    <div class="adm-field">
                        <label class="adm-label">Akreditasi</label>
                        <input class="adm-input" type="text" name="accreditation"
                            value="{{ old('accreditation', $profile->accreditation) }}">
                    </div>

                    <div class="adm-field">
                        <label class="adm-label">Kurikulum</label>
                        <input class="adm-input" type="text" name="curriculum"
                            value="{{ old('curriculum', $profile->curriculum) }}">
                    </div>

                    <div class="adm-field">
                        <label class="adm-label">YouTube URL</label>
                        <input class="adm-input" type="url" name="youtube_url"
                            value="{{ old('youtube_url', $profile->youtube_url) }}">
                    </div>
                </div>

                <div class="adm-actions">
                    <button class="adm-btn adm-btn--primary" type="submit">Simpan Perubahan</button>
                    <a class="adm-btn adm-btn--ghost" href="{{ route('admin.home.index') }}">Batal</a>
                </div>
            </form>
        </section>
    </div>
@endsection
