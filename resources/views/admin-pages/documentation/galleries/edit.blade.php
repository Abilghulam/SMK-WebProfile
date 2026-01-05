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
                <a class="adm-btn adm-btn--primary" href="{{ route('admin.documentation.items.index', $gallery) }}"><span
                        class="adm-btn-ic"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-images-icon lucide-images">
                            <path d="m22 11-1.296-1.296a2.4 2.4 0 0 0-3.408 0L11 16" />
                            <path d="M4 8a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2" />
                            <circle cx="13" cy="7" r="1" fill="currentColor" />
                            <rect x="8" y="2" width="14" height="14" rx="2" />
                        </svg></span> Kelola Item</a>

                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.documentation.galleries.index') }}"><span
                        class="adm-btn-ic"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left">
                            <path d="m15 18-6-6 6-6" />
                        </svg></span> Kembali</a>
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
