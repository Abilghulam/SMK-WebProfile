@extends('layouts.app-admin')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Edit Dokumen Legalitas</h1>
                <p class="adm-subtitle">Perbarui metadata, file, atau tautan dokumen.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.legal-documents.index') }}">Kembali</a>
            </div>
        </div>

        @include('components.admin-pages.shared.flash')

        <section class="adm-card adm-card--pad">
            <form method="POST" action="{{ route('admin.legal-documents.update', $doc) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin-pages.legal-documents._form', ['doc' => $doc])
            </form>
        </section>
    </div>
@endsection
