@extends('layouts.app-admin')

@section('kicker', 'Home')
@section('page_title', 'Edit Principal')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Kepala Sekolah</h1>
                <p class="adm-subtitle">Edit data kepala sekolah</p>
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

        <section class="adm-card">
            <form method="POST" action="{{ route('admin.home.principal.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="adm-form-grid">
                    <div class="adm-field">
                        <label class="adm-label">Nama</label>
                        <input class="adm-input" type="text" name="name" value="{{ old('name', $principal->name) }}">
                    </div>

                    <div class="adm-field">
                        <label class="adm-label">Jabatan</label>
                        <input class="adm-input" type="text" name="position"
                            value="{{ old('position', $principal->position) }}" placeholder="Kepala Sekolah">
                    </div>

                    <div class="adm-field adm-field--full">
                        <label class="adm-label">Sambutan</label>
                        <textarea class="adm-textarea" name="welcome_message" rows="6">{{ old('welcome_message', $principal->welcome_message) }}</textarea>
                    </div>

                    <div class="adm-field adm-field--full">
                        <label class="adm-label">Foto (Opsional)</label>
                        <input class="adm-input" type="file" name="photo" accept="image/*">
                        <div class="adm-help">JPG/PNG/WEBP maks 2MB.</div>

                        @if (!empty($principal->photo))
                            <div class="adm-help" style="margin-top:8px;">
                                Foto saat ini: <code>{{ $principal->photo }}</code>
                            </div>
                        @endif
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
