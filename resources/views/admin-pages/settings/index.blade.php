@extends('layouts.app-admin-settings')

@section('title', 'Settings | Beranda')

@section('content')
    <section class="adm-setting-hero" aria-label="Beranda Settings">
        <div class="adm-setting-hero-top">
            <div class="adm-setting-hero-avatar" aria-hidden="true">
                @if (!empty($settings->logo))
                    <img src="{{ asset($settings->logo) }}" alt="Logo" loading="lazy">
                @else
                    <span class="adm-setting-hero-avatar-fallback">S</span>
                @endif
            </div>

            <div class="adm-setting-hero-meta">
                <h1 class="adm-setting-hero-title">
                    {{ $settings->site_name ?: 'Nama Situs belum diisi' }}
                </h1>
                <div class="adm-setting-hero-sub">
                    {{ $settings->email ?: 'Email belum diisi' }}
                </div>
            </div>
        </div>

        <div class="adm-setting-hero-hint">
            Ubah data melalui menu <strong>Informasi Sekolah</strong>.
        </div>
    </section>
@endsection
