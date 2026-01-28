<!DOCTYPE html>
<html lang="id">

<head>
    @include('layouts.partials.head')
</head>

<body class="bg-gray-50 text-gray-800">

    {{-- Navbar --}}
    @include('layouts.partials.navbar')

    {{-- Main Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.partials.footer')

    {{-- JS --}}
    @include('layouts.partials.scripts')

</body>

</html>
