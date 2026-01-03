@extends('layouts.app-admin')

@section('title', 'Edit Album | Admin')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Edit Album</h1>
                <p class="adm-subtitle">Perbarui detail album & cover.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--primary" href="{{ route('admin.documentation.items.index', $gallery) }}">Kelola
                    Item</a>
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.documentation.galleries.index') }}">Kembali</a>
            </div>
        </div>

        <section class="adm-card adm-card--pad">
            <form method="POST" action="{{ route('admin.documentation.galleries.update', $gallery) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('admin-pages.documentation.galleries._form', ['gallery' => $gallery])
            </form>
        </section>
    </div>
@endsection
