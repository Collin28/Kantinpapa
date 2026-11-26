@extends('layouts.admin')

@section('content')
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="font-bold text-neutral-950 text-4xl mb-1">Menu Management</h1>
            <p class="text-neutral-500 text-lg">{{ $totalCount }} items total - {{ $availableCount }} available</p>
        </div>
        <a href="{{ route('admin.menus.create') }}"
            class="bg-red-600 hover:bg-red-700 transition-colors text-white text-sm font-semibold px-6 py-3 rounded-lg whitespace-nowrap">
            + Add items
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-wrap items-center gap-2 mb-8">
        <form action="{{ route('admin.menus.index') }}" method="GET" class="relative">
            @if ($selectedCategory !== '')
                <input type="hidden" name="category" value="{{ $selectedCategory }}">
            @endif
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 text-neutral-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35M18 10.5a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
            </svg>
            <input type="text" name="q" value="{{ $search }}" placeholder="Search menu..."
                class="border border-neutral-200 text-sm text-neutral-700 placeholder-neutral-400 rounded-lg pl-11 pr-4 py-2.5 w-64 focus:outline-none focus:border-neutral-400">
        </form>
        <a href="{{ route('admin.menus.index', array_filter(['q' => $search])) }}"
            class="{{ $selectedCategory === '' ? 'bg-neutral-950 text-white' : 'border border-neutral-200 text-neutral-500 hover:border-neutral-400' }} text-sm font-semibold px-5 py-2.5 rounded-full">
            All
        </a>
        @foreach ($categories as $category)
            <a href="{{ route('admin.menus.index', array_filter(['category' => $category->slug, 'q' => $search])) }}"
                class="{{ $selectedCategory === $category->slug ? 'bg-neutral-950 text-white' : 'border border-neutral-200 text-neutral-500 hover:border-neutral-400' }} text-sm font-semibold px-5 py-2.5 rounded-full">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    @if ($menus->isEmpty())
        <div class="border border-neutral-200 rounded-xl p-10 text-center text-neutral-500">
            No menu items found.
        </div>
    @else
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ($menus as $menu)
                <article class="border border-neutral-200 rounded-xl overflow-hidden flex flex-col">
                    <div class="relative h-36 bg-neutral-100">
                        <img src="{{ $menu->imageUrl() }}" alt="{{ $menu->name }}"
                            class="w-full h-full object-cover {{ $menu->is_available ? '' : 'grayscale' }}">
                        <form action="{{ route('admin.menus.toggle', $menu) }}" method="POST" class="absolute top-2.5 right-2.5 z-10">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="{{ $menu->is_available ? 'bg-green-500 hover:bg-green-600' : 'bg-neutral-600 hover:bg-neutral-700' }} text-white text-xs font-semibold px-2.5 py-1 rounded-full transition">
                                {{ $menu->is_available ? 'Active' : 'Off' }}
                            </button>
                        </form>
                        @if (! $menu->is_available)
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                <span class="bg-neutral-900 text-white text-xs font-medium px-4 py-1.5 rounded-full">Unavailable</span>
                            </div>
                        @endif
                    </div>
                    <div class="px-4 pt-3 pb-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-neutral-950 text-sm">{{ $menu->name }}</h3>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-neutral-800 text-sm">{{ $menu->formattedPrice() }}</span>
                                <span class="{{ $menu->stock > 0 ? 'text-emerald-600' : 'text-red-500' }} text-xs font-medium">{{ $menu->stock }} left</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.menus.edit', $menu) }}"
                                class="flex-1 text-center border border-neutral-200 hover:bg-neutral-50 text-neutral-600 text-sm font-medium py-2 rounded-lg">
                                Edit
                            </a>
                            <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="flex-1"
                                onsubmit="return confirm('Delete this menu item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full bg-red-50 hover:bg-red-100 text-red-500 text-sm font-medium py-2 rounded-lg">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
@endsection
