@extends('layouts.app-admin')

@section('title', 'Tambah Album | Admin')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Tambah Album</h1>
                <p class="adm-subtitle">Buat album dokumentasi baru.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.documentation.galleries.index') }}">Kembali</a>
            </div>
        </div>

        <section class="adm-card adm-card--pad">
            <form method="POST" action="{{ route('admin.documentation.galleries.store') }}" enctype="multipart/form-data">
                @csrf
                @include('admin-pages.documentation.galleries._form', ['gallery' => $gallery])
            </form>
        </section>
    </div>
@endsection
