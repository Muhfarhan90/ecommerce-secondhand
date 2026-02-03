<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - SecondHand</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100">

    @include('admin.layouts.partials.navbar')

    <div class="flex pt-[57px]">
        @include('admin.layouts.partials.sidebar')

        {{-- Main Content --}}
        <main class="flex-1 p-6 ml-64">
            @if (session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>

</html>
