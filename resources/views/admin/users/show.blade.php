@extends('admin.layouts.master')

@section('title', 'Detail Pengguna')

@section('content')
    <div class="space-y-6">

        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}" class="text-red-600 hover:text-red-700 font-medium">
                ← Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl font-bold text-blue-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-gray-600">{{ $user->email }}</p>
                        <p class="text-sm text-gray-500 mt-1">Bergabung {{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="px-4 py-2 {{ $user->is_active ? 'bg-red-600' : 'bg-green-600' }} text-white font-medium rounded-lg hover:opacity-90 transition">
                        {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
            </div>

            <div class="grid md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-sm text-blue-600 mb-1">Total Iklan</p>
                    <p class="text-2xl font-bold text-blue-700">{{ $stats['total_listings'] }}</p>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <p class="text-sm text-green-600 mb-1">Iklan Aktif</p>
                    <p class="text-2xl font-bold text-green-700">{{ $stats['active_listings'] }}</p>
                </div>
                <div class="bg-purple-50 rounded-lg p-4">
                    <p class="text-sm text-purple-600 mb-1">Favorit</p>
                    <p class="text-2xl font-bold text-purple-700">{{ $stats['favorites'] }}</p>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-bold text-gray-900 mb-4">Iklan Terbaru</h2>
                @if ($user->listings->count() > 0)
                    <div class="space-y-3">
                        @foreach ($user->listings as $listing)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $listing->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $listing->category->name }} •
                                        {{ $listing->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-blue-600">Rp {{ number_format($listing->price, 0, ',', '.') }}
                                    </p>
                                    <span
                                        class="text-xs px-2 py-1 rounded {{ $listing->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                                        {{ ucfirst($listing->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Belum ada iklan</p>
                @endif
            </div>
        </div>

    </div>
@endsection
