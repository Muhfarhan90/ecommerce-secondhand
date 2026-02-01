<!DOCTYPE html>
<html lang="id">

<head>
    @include('layouts.partials.head')
</head>

<body class="bg-gradient-to-br from-gray-50 to-blue-50/30 text-gray-800 antialiased">

    {{-- Navigation --}}
    @include('layouts.partials.navbar')

    {{-- Main Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.partials.footer')

    {{-- Scripts --}}
    @include('layouts.partials.scripts')

</body>

</html>
