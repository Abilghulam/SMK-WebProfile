@extends('layouts.app')

{{-- ===== PAGE META ===== --}}
@section('title', 'Home | SMK Negeri 9 Muaro Jambi')
@section('meta_description', 'Website resmi SMK Negeri sebagai pusat informasi dan publikasi sekolah')

@section('content')

    {{-- HERO --}}
    @include('components.user-pages.home.hero')

    {{-- PROFIL SEKOLAH --}}
    @include('components.user-pages.home.school-profile')

    {{-- STATISTIK SEKOLAH --}}
    @include('components.user-pages.home.statistics')

    {{-- DOKUMENTASI TERBARU --}}
    @include('components.user-pages.home.documentation')

    {{-- SAMBUTAN KEPALA SEKOLAH --}}
    @include('components.user-pages.home.principal-welcome')

@endsection
