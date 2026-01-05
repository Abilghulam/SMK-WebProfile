@extends('layouts.app-admin')

@section('page_kicker', 'Konten')
@section('page_title', 'Tambah Post')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Tambah Post</h1>
                <p class="adm-subtitle">Buat konten baru.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.posts.index') }}"><span class="adm-btn-ic"><svg
                            xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left">
                            <path d="m15 18-6-6 6-6" />
                        </svg></span> Kembali</a>
            </div>
        </div>

        <div class="adm-card adm-card--pad">
            @include('admin-pages.posts._form', [
                'mode' => 'create',
                'post' => null,
                'typeOptions' => $typeOptions,
            ])
        </div>
    </div>
@endsection
