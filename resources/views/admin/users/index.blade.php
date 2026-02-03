@extends('admin.layouts.master')

@section('title', 'Kelola Pengguna')

@section('content')
    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-900">Kelola Pengguna</h1>
        </div>

        {{-- Search & Filter --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <form method="GET" class="flex gap-3">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama, email, atau telepon..."
                    class="flex-1 px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">

                <select name="status"
                    class="px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <button type="submit"
                    class="px-6 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition">
                    Cari
                </button>

                @if (request('search') || request('status'))
                    <a href="{{ route('admin.users.index') }}"
                        class="px-6 py-2 border-2 border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Kontak</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Iklan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span
                                            class="text-sm font-bold text-blue-600">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500">Bergabung {{ $user->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-900">{{ $user->email }}</p>
                                <p class="text-sm text-gray-500">{{ $user->phone ?? '-' }}</p>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->listings_count }} iklan</td>
                            <td class="px-6 py-4">
                                @if ($user->is_active)
                                    <span
                                        class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded">Aktif</span>
                                @else
                                    <span
                                        class="px-2 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.users.show', $user) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium mr-3">Detail</a>
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="text-{{ $user->is_active ? 'red' : 'green' }}-600 hover:text-{{ $user->is_active ? 'red' : 'green' }}-800 font-medium">
                                        {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada pengguna ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->links() }}

    </div>
@endsection
