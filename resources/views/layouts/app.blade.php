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

    {{-- SEO Open Graph --}}
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title')))" />
    <meta property="og:description" content="@yield('og_description', trim($__env->yieldContent('meta_description')))" />
    <meta property="og:image" content="@yield('og_image', asset('assets/images/placeholder.png'))" />
    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:url" content="{{ url()->current() }}" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('og_title', trim($__env->yieldContent('title')))" />
    <meta name="twitter:description" content="@yield('og_description', trim($__env->yieldContent('meta_description')))" />
    <meta name="twitter:image" content="@yield('og_image', asset('assets/images/placeholder.png'))" />

    {{-- Favicon --}}
    <link rel="icon" href="{{ data_get($settings, 'favicon_url', asset('assets/images/favicon.ico')) }}">


    {{-- Vite Assets --}}
    @vite(['resources/css/style.css', 'resources/js/script.js'])

    {{-- Google Fonts (opsional) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

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
