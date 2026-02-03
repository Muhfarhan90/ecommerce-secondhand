@extends('admin.layouts.master')

@section('title', 'Kelola Kategori')

@section('content')
    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">Kelola Kategori</h1>
            <a href="{{ route('admin.categories.create') }}"
                class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition">
                + Tambah Kategori
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Jumlah Iklan</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900">{{ $category->name }}</p>
                                @if ($category->description)
                                    <p class="text-sm text-gray-500">{{ Str::limit($category->description, 50) }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $category->slug }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $category->listings_count }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium mr-3">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada kategori</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $categories->links() }}

    </div>
@endsection
