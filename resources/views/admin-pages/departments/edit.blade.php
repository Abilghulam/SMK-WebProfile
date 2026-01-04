@extends('layouts.app-admin')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Edit Program Keahlian</h1>
                <p class="adm-subtitle">Perbarui detail program keahlian.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.departments.index') }}">Kembali</a>
            </div>
        </div>

        <form class="adm-form" method="POST" action="{{ route('admin.departments.update', $department) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin-pages.departments._form', ['department' => $department])
            <div class="adm-form-actions">
                <button class="adm-btn adm-btn--primary" type="submit">Simpan Perubahan</button>
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.departments.index') }}">Batal</a>
            </div>
        </form>
    </div>
@endsection
