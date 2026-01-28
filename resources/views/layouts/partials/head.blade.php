<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>@yield('title', 'Marketplace')</title>

{{-- SEO --}}
<meta name="description" content="@yield('meta_description', 'Marketplace jual beli lokal')">

{{-- Tailwind --}}
@vite('resources/css/app.css')

{{-- Custom style --}}
@stack('styles')
