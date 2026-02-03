@extends('admin.layouts.master')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="max-w-2xl">

        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="text-red-600 hover:text-red-700 font-medium">
                ← Kembali
            </a>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-6">Tambah Kategori</h1>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi (Opsional)</label>
                        <textarea name="description" rows="3"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                            class="px-6 py-3 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition">
                            Simpan
                        </button>
                        <a href="{{ route('admin.categories.index') }}"
                            class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
