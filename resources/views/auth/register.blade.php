@extends('layouts.master')

@section('title', 'Register')

@section('content')
    <div class="max-w-md mx-auto py-20 px-4">
        <h1 class="text-2xl font-semibold mb-6">Daftar Akun</h1>

        <form method="POST" class="space-y-4">
            @csrf

            <input type="text" name="name" placeholder="Nama" class="w-full border rounded-lg px-4 py-2" required>

            <input type="email" name="email" placeholder="Email" class="w-full border rounded-lg px-4 py-2" required>

            <input type="number" name="phone" placeholder="No. HP" class="w-full border rounded-lg px-4 py-2" required>

            <input type="password" name="password" placeholder="Password" class="w-full border rounded-lg px-4 py-2"
                required>

            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                class="w-full border rounded-lg px-4 py-2" required>

            <button class="w-full bg-blue-600 text-white py-2 rounded-lg">
                Daftar
            </button>
        </form>

        <p class="text-sm text-center mt-4">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600">Login</a>
        </p>
    </div>
@endsection
