@extends('layouts.master')

@section('title', 'Daftar - SecondHand')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-blue-50 px-4 py-12">

        <div class="w-full max-w-md">

            {{-- Logo & Title --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-2 mb-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <span
                        class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-500 bg-clip-text text-transparent">
                        SecondHand
                    </span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">
                    Buat Akun Baru
                </h1>
                <p class="text-gray-600">
                    Mulai jual beli barang bekas
                </p>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">

                <form method="POST" class="space-y-5">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-500 @enderror"
                            placeholder="Nama lengkap Anda" required autofocus>
                        @error('name')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-500 @enderror"
                            placeholder="nama@email.com" required>
                        @error('email')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor Telepon
                        </label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('phone') border-red-500 @enderror"
                            placeholder="08xxxxxxxxxx" required>
                        @error('phone')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <input type="password" name="password"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password') border-red-500 @enderror"
                            placeholder="Minimal 8 karakter" required>
                        @error('password')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Confirmation --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <input type="password" name="password_confirmation"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                            placeholder="Ulangi password" required>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-500 text-white py-3.5 rounded-xl font-semibold hover:shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all">
                        Daftar Sekarang
                    </button>
                </form>

            </div>

            {{-- Footer Links --}}
            <div class="text-center mt-6">
                <p class="text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:text-blue-700">
                        Masuk
                    </a>
                </p>
            </div>

        </div>

    </div>
@endsection
