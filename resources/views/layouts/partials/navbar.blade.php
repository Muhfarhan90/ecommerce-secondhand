<nav class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">
            Marketplace
        </a>

        {{-- Menu --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="text-sm text-gray-700 hover:text-blue-600">
                Browse
            </a>

            @auth
                <a href="{{ route('listings.create') }}" class="text-sm text-gray-700">
                    Pasang Iklan
                </a>

                <span class="text-sm text-gray-500">
                    Hi, {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-red-600">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm text-blue-600">
                    Login
                </a>
            @endauth
        </div>

    </div>
</nav>
