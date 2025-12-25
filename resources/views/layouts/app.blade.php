<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', config('app.name', 'SMK Negeri '))
    </title>

    {{-- Meta SEO --}}
    <meta name="description" content="@yield('meta_description', 'Website Resmi Sekolah Menengah Kejuruan')">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('img/logo.png') }}">

    {{-- Vite Assets --}}
    @vite([
        'resources/css/style.css',
        'resources/js/script.js'
    ])

    {{-- Google Fonts (opsional) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @stack('styles')
</head>
<body>

    {{-- ===== NAVBAR ===== --}}
    @include('partials.navbar')

    {{-- ===== CONTENT ===== --}}
    <main>
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    @include('partials.footer')

    @stack('scripts')
</body>
</html>
