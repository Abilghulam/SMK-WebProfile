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
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.posts.index') }}">Kembali</a>
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
