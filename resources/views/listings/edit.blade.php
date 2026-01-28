@extends('layouts.master')

@section('title', 'Edit Iklan')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-10">

        <h1 class="text-2xl font-semibold mb-6">
            Edit Iklan
        </h1>

        <form method="POST" action="{{ route('listings.update', $listing) }}"
            class="bg-white border rounded-2xl p-6 space-y-6">
            @csrf
            @method('PUT')

            <input type="text" name="title" value="{{ old('title', $listing->title) }}"
                class="w-full border rounded-lg px-4 py-2" required>

            <select name="category_id" class="w-full border rounded-lg px-4 py-2">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($category->id == $listing->category_id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <div class="grid grid-cols-2 gap-4">
                <input type="number" name="price" value="{{ old('price', $listing->price) }}"
                    class="border rounded-lg px-4 py-2">

                <select name="condition" class="border rounded-lg px-4 py-2">
                    <option value="used" @selected($listing->condition === 'used')>Bekas</option>
                    <option value="new" @selected($listing->condition === 'new')>Baru</option>
                </select>
            </div>

            <textarea name="description" rows="4" class="w-full border rounded-lg px-4 py-2">{{ old('description', $listing->description) }}</textarea>

            <div class="grid grid-cols-2 gap-4">
                <input name="city" value="{{ old('city', $listing->city) }}" class="border rounded-lg px-4 py-2">
                <input name="province" value="{{ old('province', $listing->province) }}"
                    class="border rounded-lg px-4 py-2">
            </div>

            <div class="flex justify-between items-center">
                <button class="bg-blue-600 text-white px-6 py-2 rounded-lg">
                    Simpan Perubahan
                </button>

                <form method="POST" action="{{ route('listings.destroy', $listing) }}"
                    onsubmit="return confirm('Yakin hapus iklan ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 text-sm">
                        Hapus Iklan
                    </button>
                </form>
            </div>
        </form>

    </div>
@endsection
