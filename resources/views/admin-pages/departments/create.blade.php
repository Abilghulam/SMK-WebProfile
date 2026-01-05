@extends('layouts.app-admin')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Tambah Program Keahlian</h1>
                <p class="adm-subtitle">Buat data program keahlian baru.</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.departments.index') }}"><span class="adm-btn-ic"><svg
                            xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left">
                            <path d="m15 18-6-6 6-6" />
                        </svg></span> Kembali</a>
            </div>
        </div>

        <section class="adm-card adm-card--pad">
            <form class="adm-form" method="POST" action="{{ route('admin.departments.store') }}"
                enctype="multipart/form-data">
                @csrf
                @include('admin-pages.departments._form', ['department' => $department])
                <div class="adm-form-actions">
                    <button class="adm-btn adm-btn--primary" type="submit"><span class="adm-btn-ic"><svg
                                xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-save-icon lucide-save">
                                <path
                                    d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                                <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                                <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                            </svg></span> Simpan</button>
                    <a class="adm-btn adm-btn--ghost" href="{{ route('admin.departments.index') }}">Batal</a>
                </div>
            </form>
        </section>
    </div>
@endsection
