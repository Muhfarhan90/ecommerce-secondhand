<div class="grid grid-cols-2 md:grid-cols-3 gap-6">
    @forelse ($listings as $listing)
        <a href="{{ route('listings.show', $listing) }}"
            class="group bg-white border rounded-xl overflow-hidden hover:shadow-md transition">

            <div class="aspect-square bg-gray-100 overflow-hidden">
                <img src="{{ $listing->images->first()->image_path ?? '/placeholder.jpg' }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition">
            </div>

            <div class="p-4 space-y-1">
                <p class="font-semibold text-blue-600">
                    Rp {{ number_format($listing->price) }}
                </p>
                <h3 class="text-sm font-medium truncate">
                    {{ $listing->title }}
                </h3>
                <p class="text-xs text-gray-500">
                    {{ $listing->city }}
                </p>
            </div>
        </a>
    @empty
        <div class="col-span-full flex flex-col items-center justify-center py-32 text-center">

            <p class="text-lg font-medium text-gray-600">
                Belum ada barang yang ditampilkan
            </p>
            <p class="text-sm text-gray-400 mt-2">
                Coba ubah filter atau kata kunci pencarian
            </p>
        </div>
    @endforelse

</div>

<div class="mt-8">
    {{ $listings->links() }}
</div>
