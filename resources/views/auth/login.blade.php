@extends('layouts.master')

@section('title', 'Login')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">

        <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border p-8">

            {{-- Title --}}
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-semibold text-gray-800">
                    Login
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Masuk untuk pasang iklan dan chat penjual
                </p>
            </div>

            {{-- Form --}}
            <form method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm font-medium text-gray-600">
                        Email
                    </label>
                    <input type="email" name="email"
                        class="mt-1 w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500"
                        placeholder="email@example.com" required>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">
                        Password
                    </label>
                    <input type="password" name="password"
                        class="mt-1 w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200 focus:border-blue-500"
                        placeholder="••••••••" required>
                </div>

                @error('email')
                    <p class="text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror

                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-medium hover:bg-blue-700 transition">
                    Login
                </button>
            </form>

            {{-- Footer --}}
            <p class="text-sm text-center text-gray-500 mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 font-medium hover:underline">
                    Daftar
                </a>
            </p>

        </div>

    </div>
@endsection
