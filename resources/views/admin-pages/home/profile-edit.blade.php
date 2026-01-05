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
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.home.index') }}"><span class="adm-btn-ic"><svg
                            xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left">
                            <path d="m15 18-6-6 6-6" />
                        </svg></span> Kembali</a>
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
                    <button class="adm-btn adm-btn--primary" type="submit"><span class="adm-btn-ic"><svg
                                xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-save-icon lucide-save">
                                <path
                                    d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                                <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                                <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                            </svg></span> Simpan Perubahan</button>
                    <a class="adm-btn adm-btn--ghost" href="{{ route('admin.home.index') }}">Batal</a>
                </div>
            </form>
        </section>
    </div>
@endsection
