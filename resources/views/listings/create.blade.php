@extends('layouts.master')

@section('title', 'Pasang Iklan')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-10">

        <h1 class="text-2xl font-semibold mb-6">
            Pasang Iklan
        </h1>

        <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data"
            class="bg-white border rounded-2xl p-6 space-y-6">
            @csrf

            {{-- Title --}}
            <div>
                <label class="block text-sm font-medium mb-1">
                    Judul Iklan
                </label>
                <input type="text" name="title" class="w-full border rounded-lg px-4 py-2"
                    placeholder="Contoh: iPhone 11 128GB Mulus" required>
            </div>

            {{-- Category --}}
            <div>
                <label class="block text-sm font-medium mb-1">
                    Kategori
                </label>
                <select name="category_id" class="w-full border rounded-lg px-4 py-2" required>
                    <option value="">Pilih kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Price & Condition --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Harga
                    </label>
                    <input type="number" name="price" class="w-full border rounded-lg px-4 py-2" placeholder="Rp">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Kondisi
                    </label>
                    <select name="condition" class="w-full border rounded-lg px-4 py-2">
                        <option value="used">Bekas</option>
                        <option value="new">Baru</option>
                    </select>
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium mb-1">
                    Deskripsi
                </label>
                <textarea name="description" rows="4" class="w-full border rounded-lg px-4 py-2"
                    placeholder="Jelaskan kondisi barang..." required></textarea>
            </div>

            {{-- Location --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">
                        Kota
                    </label>
                    <input type="text" name="city" class="w-full border rounded-lg px-4 py-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">
                        Provinsi
                    </label>
                    <input type="text" name="province" class="w-full border rounded-lg px-4 py-2" required>
                </div>
            </div>

            {{-- Images --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Foto Barang
                </label>
                <input type="file" name="images[]" class="w-full" multiple accept="image/*" required>
                <p class="text-xs text-gray-500 mt-1">
                    Upload minimal 1 foto (maks 2MB per foto)
                </p>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end">
                <button class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition">
                    Pasang Iklan
                </button>
            </div>

        </form>

    </div>
@endsection
