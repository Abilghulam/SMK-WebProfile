@extends('layouts.app-admin')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Edit Dokumen Legalitas</h1>
                <p class="adm-subtitle">Perbarui metadata, file, atau tautan dokumen.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.legal-documents.index') }}"><span
                        class="adm-btn-ic"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left">
                            <path d="m15 18-6-6 6-6" />
                        </svg></span> Kembali</a>
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
