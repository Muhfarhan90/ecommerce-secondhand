@extends('layouts.master')

@section('title', 'Pesan Saya - SecondHand')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Pesan</h1>
                <p class="text-gray-600">Kelola percakapan dengan pembeli dan penjual</p>
            </div>

            @if ($conversations->count() > 0)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    @foreach ($conversations as $conversation)
                        @php
                            $otherUser =
                                $conversation->buyer_id === auth()->id() ? $conversation->seller : $conversation->buyer;
                            $lastMessage = $conversation->messages->first();
                            $unreadCount = $conversation
                                ->messages()
                                ->where('sender_id', '!=', auth()->id())
                                ->where('is_read', false)
                                ->count();
                        @endphp

                        <a href="{{ route('conversations.show', $conversation) }}"
                            class="flex items-center gap-4 p-6 hover:bg-gray-50 transition-colors border-b border-gray-100 last:border-b-0">

                            {{-- Listing Image --}}
                            <div class="flex-shrink-0">
                                <img src="{{ $conversation->listing->images->first()?->image_path ?? asset('images/placeholder.jpg') }}"
                                    alt="{{ $conversation->listing->title }}" class="w-20 h-20 object-cover rounded-lg">
                            </div>

                            {{-- Conversation Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4 mb-2">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 truncate">
                                            {{ $conversation->listing->title }}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            Chat dengan {{ $otherUser->name }}
                                        </p>
                                    </div>
                                    @if ($unreadCount > 0)
                                        <span
                                            class="flex-shrink-0 px-2.5 py-1 bg-blue-600 text-white text-xs font-semibold rounded-full">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </div>

                                @if ($lastMessage)
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm text-gray-600 truncate">
                                            <span class="font-medium">
                                                {{ $lastMessage->sender_id === auth()->id() ? 'Anda' : $otherUser->name }}:
                                            </span>
                                            {{ Str::limit($lastMessage->message, 50) }}
                                        </p>
                                        <span class="text-xs text-gray-500 flex-shrink-0 ml-4">
                                            {{ $lastMessage->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-400 italic">Belum ada pesan</p>
                                @endif
                            </div>

                            {{-- Arrow Icon --}}
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Percakapan</h3>
                    <p class="text-gray-600 mb-6">Mulai chat dengan penjual untuk bernegosiasi</p>
                    <a href="{{ route('listings.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Jelajahi Iklan
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
