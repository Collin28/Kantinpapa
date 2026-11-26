@props(['menu', 'popular' => false])

@if ($menu->isSoldOut())
    <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col opacity-80">
        <div class="relative h-48 w-full">
            <img src="{{ $menu->imageUrl() }}" alt="{{ $menu->name }}"
                class="w-full h-full object-cover grayscale">
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                <span class="bg-zinc-800/90 text-white text-xs font-bold px-4 py-2 rounded-lg">Sold Out</span>
            </div>
        </div>
        <div class="p-4 flex-1 flex flex-col justify-between">
            <div>
                <h3 class="font-bold text-gray-900 text-base">{{ $menu->name }}</h3>
                @if ($menu->description)
                    <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $menu->description }}</p>
                @endif
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm font-bold text-gray-900">{{ $menu->formattedPrice() }}</span>
                <span class="text-xs font-medium text-gray-400">Unavailable</span>
            </div>
        </div>
    </div>
@else
    <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col">
        <div class="relative h-48 w-full">
            <img src="{{ $menu->imageUrl() }}" alt="{{ $menu->name }}"
                class="w-full h-full object-cover">
            @if ($popular)
                <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-semibold px-2.5 py-1 rounded-md">Popular</span>
            @endif
        </div>
        <div class="p-4 flex-1 flex flex-col justify-between">
            <div>
                <h3 class="font-bold text-gray-900 text-base">{{ $menu->name }}</h3>
                <p class="text-gray-900 font-semibold text-sm mt-1">{{ $menu->formattedPrice() }}</p>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <span class="text-xs font-medium text-emerald-600">{{ $menu->stock }} left</span>
            </div>
            <form action="{{ route('cart.store', $menu) }}" method="POST" class="mt-2">
                @csrf
                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-xl transition text-sm">
                    + Add to Cart
                </button>
            </form>
        </div>
    </div>
@endif
