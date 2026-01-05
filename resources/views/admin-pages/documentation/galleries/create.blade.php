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
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.documentation.galleries.index') }}"><span
                        class="adm-btn-ic"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left">
                            <path d="m15 18-6-6 6-6" />
                        </svg></span> Kembali</a>
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
