@extends('layouts.master')

@section('content')
    <div class="max-w-6xl mx-auto px-4">

        <div class="grid md:grid-cols-2 gap-8">
            {{-- Images --}}
            <img src="{{ $listing->images->first()->image_path ?? '/placeholder.jpg' }}"
                class="rounded-xl w-full object-cover">

            {{-- Info --}}
            <div>
                <h1 class="text-2xl font-semibold mb-2">{{ $listing->title }}</h1>

                <p class="text-2xl text-blue-600 font-bold mb-4">
                    Rp {{ number_format($listing->price) }}
                </p>

                <p class="text-gray-600 mb-4">
                    {{ $listing->description }}
                </p>

                <p class="text-sm text-gray-500">
                    📍 {{ $listing->city }}, {{ $listing->province }}
                </p>

                <div class="mt-6">
                    @auth
                        <a href="#" class="bg-green-600 text-white px-6 py-3 rounded-lg">
                            Chat Penjual
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg">
                            Login untuk Chat
                        </a>
                    @endauth
                </div>
            </div>
        </div>

    </div>
@endsection
