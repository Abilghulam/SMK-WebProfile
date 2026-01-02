@extends('layouts.app-admin')

@section('kicker', 'Home')
@section('page_title', 'Edit School Statistics')

@section('content')
    <div class="adm-page">
        <div class="adm-page-head">
            <div>
                <h1 class="adm-h1">Statistik Sekolah</h1>
                <p class="adm-subtitle">Edit data statistik sekolah</p>
            </div>

            <div class="adm-actions">
                <a class="adm-btn adm-btn--ghost" href="{{ route('admin.home.index') }}">Kembali</a>
            </div>
        </div>


        <section class="adm-card">
            <form method="POST" action="{{ route('admin.home.statistics.update') }}">
                @csrf
                @method('PUT')

                <div class="adm-form-grid">
                    <div class="adm-field">
                        <label class="adm-label">Tahun Ajaran</label>
                        <input class="adm-input" type="text" name="academic_year"
                            value="{{ old('academic_year', $stats->academic_year) }}" placeholder="2025/2026">
                    </div>

                    <div class="adm-field">
                        <label class="adm-label">Total Siswa</label>
                        <input class="adm-input" type="number" name="total_students"
                            value="{{ old('total_students', $stats->total_students) }}" min="0">
                    </div>

                    <div class="adm-field">
                        <label class="adm-label">Total Guru</label>
                        <input class="adm-input" type="number" name="total_teachers"
                            value="{{ old('total_teachers', $stats->total_teachers) }}" min="0">
                    </div>

                    <div class="adm-field">
                        <label class="adm-label">Total Jurusan</label>
                        <input class="adm-input" type="number" name="total_departments"
                            value="{{ old('total_departments', $stats->total_departments) }}" min="0">
                    </div>
                </div>

                <div class="adm-actions">
                    <button class="adm-btn adm-btn--primary" type="submit">Simpan Perubahan</button>
                    <a class="adm-btn adm-btn--ghost" href="{{ route('admin.home.index') }}">Batal</a>
                </div>
            </form>
        </section>
    </div>
@endsection
