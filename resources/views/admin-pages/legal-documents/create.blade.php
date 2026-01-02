@extends('layouts.app-admin')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Tambah Dokumen Legalitas</h1>
                <p class="adm-subtitle">Upload PDF atau gunakan tautan eksternal.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.legal-documents.index') }}">Kembali</a>
            </div>
        </div>

        @include('components.admin-pages.shared.flash')

        <section class="adm-card adm-card--pad">
            <form method="POST" action="{{ route('admin.legal-documents.store') }}" enctype="multipart/form-data">
                @csrf
                @include('admin-pages.legal-documents._form', ['doc' => $doc])
            </form>
        </section>
    </div>
@endsection
