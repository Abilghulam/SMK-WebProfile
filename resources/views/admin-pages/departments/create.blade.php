@extends('layouts.app-admin')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Tambah Program Keahlian</h1>
                <p class="adm-subtitle">Buat data program keahlian baru.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.departments.index') }}">Kembali</a>
            </div>
        </div>

        <section class="adm-card adm-card--pad">
            <form class="adm-form" method="POST" action="{{ route('admin.departments.store') }}"
                enctype="multipart/form-data">
                @csrf
                @include('admin-pages.departments._form', ['department' => $department])
                <div class="adm-form-actions">
                    <button class="adm-btn adm-btn--primary" type="submit">Simpan</button>
                    <a class="adm-btn adm-btn--ghost" href="{{ route('admin.departments.index') }}">Batal</a>
                </div>
            </form>
        </section>
    </div>
@endsection
