@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Pengguna</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                        <p class="text-sm text-green-600 mt-2">{{ $stats['active_users'] }} aktif</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Iklan</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_listings']) }}</p>
                        <p class="text-sm text-green-600 mt-2">{{ $stats['active_listings'] }} aktif</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Kategori</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Data --}}
        <div class="grid lg:grid-cols-2 gap-6">
            {{-- Recent Users --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Pengguna Terbaru</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach ($recent_users as $user)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span
                                            class="text-sm font-bold text-blue-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Recent Listings --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Iklan Terbaru</h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach ($recent_listings as $listing)
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900 line-clamp-1">{{ $listing->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $listing->user->name }}</p>
                                    <p class="text-sm font-medium text-blue-600">Rp
                                        {{ number_format($listing->price, 0, ',', '.') }}</p>
                                </div>
                                <span class="text-xs text-gray-500">{{ $listing->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
