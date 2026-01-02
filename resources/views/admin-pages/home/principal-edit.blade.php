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
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.home.index') }}">Kembali</a>
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
                    <button class="adm-btn adm-btn--primary" type="submit">Simpan Perubahan</button>
                    <a class="adm-btn adm-btn--ghost" href="{{ route('admin.home.index') }}">Batal</a>
                </div>
            </form>
        </section>
    </div>
@endsection
