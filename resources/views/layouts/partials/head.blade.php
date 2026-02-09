<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

{{-- Title --}}
<title>@yield('title', 'SecondHand - Marketplace Barang Bekas Terpercaya')</title>

{{-- SEO Meta Tags --}}
<meta name="description" content="@yield('meta_description', 'Pasang iklan jual beli barang bekas secara gratis. Temukan ribuan iklan produk secondhand dengan kontak langsung penjual.')">
<meta name="keywords"
    content="iklan barang bekas, iklan gratis, secondhand, jual beli online, marketplace indonesia, olx indonesia">
<meta name="author" content="SecondHand">

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@yield('title', 'SecondHand - Iklan Jual Beli Barang Bekas')">
<meta property="og:description" content="@yield('meta_description', 'Platform iklan jual beli barang bekas gratis')">
<meta property="og:image" content="{{ asset('images/og-image.jpg') }}">

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ url()->current() }}">
<meta name="twitter:title" content="@yield('title', 'SecondHand')">
<meta name="twitter:description" content="@yield('meta_description', 'Platform jual beli barang bekas')">

{{-- Favicon --}}
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

{{-- Tailwind CSS --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])

{{-- Alpine.js --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

{{-- Google Fonts - Inter --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

{{-- Custom Styles --}}
<style>
    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Loading animation */
    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }

        100% {
            background-position: 1000px 0;
        }
    }

    .skeleton {
        animation: shimmer 2s infinite;
        background: linear-gradient(to right, #f0f0f0 8%, #f8f8f8 18%, #f0f0f0 33%);
        background-size: 1000px 100%;
    }

    /* Fade in animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }
</style>

{{-- Page Specific Styles --}}
@stack('styles')
