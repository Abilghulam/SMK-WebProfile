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
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.posts.index') }}">Kembali</a>
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
