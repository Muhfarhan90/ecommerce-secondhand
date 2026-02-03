@extends('admin.layouts.master')

@section('title', 'Kelola Banner')

@section('content')
    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">Kelola Banner</h1>
            <a href="{{ route('admin.banners.create') }}"
                class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition">
                + Tambah Banner
            </a>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($banners as $banner)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="relative aspect-video bg-gray-100">
                        <img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title }}"
                            class="w-full h-full object-cover">
                        @if ($banner->is_active)
                            <span
                                class="absolute top-3 right-3 px-2 py-1 bg-green-500 text-white text-xs font-semibold rounded">Aktif</span>
                        @else
                            <span
                                class="absolute top-3 right-3 px-2 py-1 bg-gray-500 text-white text-xs font-semibold rounded">Nonaktif</span>
                        @endif
                    </div>

                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 mb-2">{{ $banner->title }}</h3>

                        @if ($banner->listing)
                            <p class="text-sm text-gray-600 mb-1">Link ke: {{ $banner->listing->title }}</p>
                            <p class="text-xs text-gray-500">Penjual: {{ $banner->listing->user->name }}</p>
                        @else
                            <p class="text-sm text-gray-500">Tanpa link produk</p>
                        @endif

                        <p class="text-sm text-gray-500 mt-2">Urutan: {{ $banner->order }}</p>

                        <div class="flex gap-2 mt-4">
                            <a href="{{ route('admin.banners.edit', $banner) }}"
                                class="flex-1 text-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="flex-1"
                                onsubmit="return confirm('Yakin hapus banner ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full px-3 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <p class="text-gray-500">Belum ada banner</p>
                </div>
            @endforelse
        </div>

        {{ $banners->links() }}

    </div>
@endsection
