@extends('layouts.app-admin')

@section('page_kicker', 'Konten')
@section('page_title', 'Edit Post')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Edit Post</h1>
                <p class="adm-subtitle">Perbarui konten yang sudah dibuat.</p>
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
                'mode' => 'edit',
                'post' => $post,
                'typeOptions' => $typeOptions ?? null,
            ])
        </div>
    </div>
@endsection
