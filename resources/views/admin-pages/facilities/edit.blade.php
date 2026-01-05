@extends('layouts.app-admin')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Edit Fasilitas</h1>
                <p class="adm-subtitle">Perbarui data fasilitas.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.facilities.index') }}">Kembali</a>
            </div>
        </div>

        <section class="adm-card adm-card--pad">
            <form class="adm-form" method="POST" action="{{ route('admin.facilities.update', $facility) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin-pages.facilities._form', ['facility' => $facility])
                <div class="adm-actions">
                    <button class="adm-btn adm-btn--primary" type="submit">Simpan Perubahan</button>
                    <a class="adm-btn adm-btn--ghost" href="{{ route('admin.facilities.index') }}">Batal</a>
                </div>
            </form>
        </section>
    </div>
@endsection
