@extends('layouts.app')

@section('content')
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
            <form action="{{ route('menu.index') }}" method="GET" class="pt-2 max-w-md">
                @if ($selectedCategory !== '')
                    <input type="hidden" name="category" value="{{ $selectedCategory }}">
                @endif
                <div class="relative">
                    <svg class="w-5 h-5 absolute left-3.5 top-3 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" name="q" value="{{ $search }}" placeholder="Search food or drinks..."
                        class="w-full bg-zinc-800/80 text-white placeholder-gray-400 pl-10 pr-4 py-2.5 rounded-xl border border-zinc-700 focus:outline-none focus:border-red-600 text-sm">
                </div>
            </form>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        {{-- Section: Popular Today --}}
        @if ($popularMenus->isNotEmpty() && $search === '' && $selectedCategory === '')
            <div>
                <div class="flex items-center space-x-2 mb-6">
                    <span class="text-yellow-500">⭐</span>
                    <h2 class="text-lg font-bold text-gray-900">Popular Today</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($popularMenus as $menu)
                        <x-menu-card :menu="$menu" :popular="true" />
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Section: Categories --}}
        <div class="flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-none">
            <a href="{{ route('menu.index', array_filter(['q' => $search])) }}"
                class="{{ $selectedCategory === '' ? 'bg-red-600 text-white' : 'bg-white text-gray-600 border border-gray-300 hover:bg-gray-50' }} font-semibold px-5 py-2 rounded-full text-sm whitespace-nowrap">
                All
            </a>
            @foreach ($categories as $category)
                <a href="{{ route('menu.index', array_filter(['category' => $category->slug, 'q' => $search])) }}"
                    class="{{ $selectedCategory === $category->slug ? 'bg-red-600 text-white' : 'bg-white text-gray-600 border border-gray-300 hover:bg-gray-50' }} font-semibold px-5 py-2 rounded-full text-sm whitespace-nowrap">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        {{-- Section: Menu Grid --}}
        @if ($menus->isEmpty())
            <div class="bg-neutral-50 border border-neutral-200 rounded-2xl p-10 text-center">
                <p class="text-neutral-600 font-medium">No menu items match your filter.</p>
                <a href="{{ route('menu.index') }}" class="inline-block mt-3 text-sm font-semibold text-red-600 hover:underline">
                    Reset filters
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($menus as $menu)
                    <x-menu-card :menu="$menu" />
                @endforeach
            </div>
        @endif

    </main>
@endsection
