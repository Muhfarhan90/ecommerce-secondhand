@extends('layouts.master')

@section('title', 'Chat - ' . $conversation->listing->title)

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('conversations.index') }}"
                    class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Pesan
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden">

                {{-- Listing Header --}}
                <div class="p-6 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-4">
                        <img src="{{ $conversation->listing->images->first()?->image_path ?? asset('images/placeholder.jpg') }}"
                            alt="{{ $conversation->listing->title }}" class="w-20 h-20 object-cover rounded-lg">
                        <div class="flex-1">
                            <h2 class="font-semibold text-gray-900 mb-1">
                                {{ $conversation->listing->title }}
                            </h2>
                            <p class="text-xl font-bold text-blue-600 mb-2">
                                Rp {{ number_format($conversation->listing->price, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-gray-600">
                                Chat dengan
                                <span class="font-medium">
                                    {{ $conversation->buyer_id === auth()->id() ? $conversation->seller->name : $conversation->buyer->name }}
                                </span>
                            </p>
                        </div>
                        <a href="{{ route('listings.show', $conversation->listing->slug) }}"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                            Lihat Iklan
                        </a>
                    </div>
                </div>

                {{-- Messages Container --}}
                <div id="messagesContainer" class="h-[500px] overflow-y-auto p-6 space-y-4">
                    @forelse($conversation->messages as $message)
                        <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs lg:max-w-md">
                                @if ($message->sender_id !== auth()->id())
                                    <p class="text-xs text-gray-500 mb-1">{{ $message->sender->name }}</p>
                                @endif
                                <div
                                    class="px-4 py-3 rounded-2xl {{ $message->sender_id === auth()->id() ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-900' }}">
                                    <p class="break-words">{{ $message->message }}</p>
                                </div>
                                <p
                                    class="text-xs text-gray-500 mt-1 {{ $message->sender_id === auth()->id() ? 'text-right' : 'text-left' }}">
                                    {{ $message->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            <p class="text-gray-500">Belum ada pesan. Mulai percakapan!</p>
                        </div>
                    @endforelse
                </div>

                {{-- Message Input --}}
                <div class="p-6 border-t border-gray-200 bg-gray-50">
                    <form action="{{ route('conversations.send-message', $conversation) }}" method="POST"
                        id="messageForm">
                        @csrf
                        <div class="flex gap-3">
                            <input type="text" name="message" id="messageInput" placeholder="Ketik pesan..." required
                                maxlength="1000"
                                class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                autocomplete="off">
                            <button type="submit"
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                <span class="hidden sm:inline">Kirim</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Safety Tips --}}
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Tips Aman Bertransaksi
                </h4>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        Jangan memberikan informasi pribadi sensitif (KTP, password, PIN)
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        Lakukan transaksi di tempat umum dan ramai
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        Periksa kondisi barang sebelum membayar
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Auto-scroll to bottom of messages
            const messagesContainer = document.getElementById('messagesContainer');
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            // Focus on message input
            document.getElementById('messageInput').focus();

            // Handle form submission
            const form = document.getElementById('messageForm');
            form.addEventListener('submit', function() {
                // Optionally disable submit button to prevent double submission
                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.disabled = true;

                // Re-enable after 2 seconds
                setTimeout(() => {
                    submitBtn.disabled = false;
                }, 2000);
            });
        </script>
    @endpush
@endsection
