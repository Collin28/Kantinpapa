<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KantinPapa - Campus Food</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans">

    {{-- Header / Navbar --}}
    <header class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            {{-- Logo --}}
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-red-600 rounded-lg"></div>
                <span class="text-xl font-bold text-gray-900">Kantin<span class="text-red-600">Papa</span></span>
            </div>

            {{-- Nav Actions --}}
            <div class="flex items-center space-x-6">
                <a href="#" class="text-red-600 font-semibold hover:text-red-700">Menu</a>
                <button class="relative p-2 text-gray-700 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z">
                        </path>
                    </svg>
                </button>
                <a href="#"
                    class="bg-red-600 text-white px-5 py-2 rounded-xl font-semibold hover:bg-red-700 transition">Login</a>
            </div>
        </div>
    </header>

    {{-- Hero Section --}}
    <section class="bg-zinc-900 text-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-4">
            <span
                class="inline-block bg-red-950/80 text-red-400 text-xs font-semibold px-3 py-1.5 rounded-full uppercase tracking-wider border border-red-800/40">
                Canteen Open — Orders Available Now
            </span>
            <h1 class="text-4xl md:text-5xl font-black tracking-tight">
                Campus food,<br>
                <span class="text-red-600">ordered fast.</span>
            </h1>
            <p class="text-gray-400 text-sm max-w-lg leading-relaxed">
                Browse the day's menu, pick your favorites, and pay with QRIS. Your order will be ready for pickup at
                the counter.
            </p>

            {{-- Search Bar --}}
            <div class="pt-2 max-w-md">
                <div class="relative">
                    <svg class="w-5 h-5 absolute left-3.5 top-3 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" placeholder="Search food or drinks..."
                        class="w-full bg-zinc-800/80 text-white placeholder-gray-400 pl-10 pr-4 py-2.5 rounded-xl border border-zinc-700 focus:outline-none focus:border-red-600 text-sm">
                </div>
            </div>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        {{-- Section: Popular Today --}}
        <div>
            <div class="flex items-center space-x-2 mb-6">
                <span class="text-yellow-500">⭐</span>
                <h2 class="text-lg font-bold text-gray-900">Popular Today</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @for ($i = 0; $i < 4; $i++)
                    <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col">
                        <div class="relative h-48 w-full">
                            <img src="https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=800"
                                alt="Nasi Ayam Bakar" class="w-full h-full object-cover">
                            <span
                                class="absolute top-3 left-3 bg-red-600 text-white text-xs font-semibold px-2.5 py-1 rounded-md">Popular</span>
                        </div>
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-gray-900 text-base">Nasi Ayam Bakar</h3>
                                <p class="text-gray-900 font-semibold text-sm mt-1">Rp 18.000</p>
                            </div>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xs font-medium text-emerald-600">24 left</span>
                            </div>
                            <button
                                class="mt-2 w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-xl transition text-sm">
                                + Add to Cart
                            </button>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        {{-- Section: Categories --}}
        <div class="flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-none">
            <button
                class="bg-red-600 text-white font-semibold px-5 py-2 rounded-full text-sm whitespace-nowrap">All</button>
            <button
                class="bg-white text-gray-600 border border-gray-300 font-semibold px-5 py-2 rounded-full text-sm hover:bg-gray-50 whitespace-nowrap">Rice
                Bowls</button>
            <button
                class="bg-white text-gray-600 border border-gray-300 font-semibold px-5 py-2 rounded-full text-sm hover:bg-gray-50 whitespace-nowrap">Noodles</button>
            <button
                class="bg-white text-gray-600 border border-gray-300 font-semibold px-5 py-2 rounded-full text-sm hover:bg-gray-50 whitespace-nowrap">Snacks</button>
            <button
                class="bg-white text-gray-600 border border-gray-300 font-semibold px-5 py-2 rounded-full text-sm hover:bg-gray-50 whitespace-nowrap">Drinks</button>
            <button
                class="bg-white text-gray-600 border border-gray-300 font-semibold px-5 py-2 rounded-full text-sm hover:bg-gray-50 whitespace-nowrap">Desserts</button>
        </div>

        {{-- Section: Menu Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Available Items --}}
            @for ($i = 0; $i < 3; $i++)
                <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col">
                    <div class="relative h-48 w-full">
                        <img src="https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=800"
                            alt="Nasi Ayam Bakar" class="w-full h-full object-cover">
                        <span
                            class="absolute top-3 left-3 bg-red-600 text-white text-xs font-semibold px-2.5 py-1 rounded-md">Popular</span>
                    </div>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-bold text-gray-900 text-base">Nasi Ayam Bakar</h3>
                            <p class="text-gray-900 font-semibold text-sm mt-1">Rp 18.000</p>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-xs font-medium text-emerald-600">24 left</span>
                        </div>
                        <button
                            class="mt-2 w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-xl transition text-sm">
                            + Add to Cart
                        </button>
                    </div>
                </div>
            @endfor

            {{-- Sold Out Item --}}
            <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col opacity-80">
                <div class="relative h-48 w-full">
                    <img src="https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=800" alt="Soto Ayam"
                        class="w-full h-full object-cover grayscale">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <span class="bg-zinc-800/90 text-white text-xs font-bold px-4 py-2 rounded-lg">Sold Out</span>
                    </div>
                </div>
                <div class="p-4 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-gray-900 text-base">Soto Ayam</h3>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                            Clear turmeric chicken soup with glass noodles, boiled egg, shredded chicken, and fried
                            shallots.
                        </p>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-sm font-bold text-gray-900">Rp 18.000</span>
                        <span class="text-xs font-medium text-gray-400">Unavailable</span>
                    </div>
                </div>
            </div>
        </div>

    </main>

</body>

</html>