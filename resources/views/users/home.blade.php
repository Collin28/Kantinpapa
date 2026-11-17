<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KantinPapa - Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">
    <header class="bg-white border-b border-gray-100 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('users.home') }}" class="text-xl font-bold text-gray-900">Kantin<span class="text-red-600">Papa</span></a>
            <nav class="flex items-center gap-5 text-sm">
                <a href="{{ route('users.home') }}" class="text-red-600 font-semibold">Menu</a>
                <a href="{{ route('users.orders') }}" class="text-gray-600 hover:text-red-600">Pesanan Saya</a>
                <a href="{{ route('users.cart') }}" class="relative text-gray-700 hover:text-red-600">
                    Keranjang
                    @if ($cartCount > 0)
                        <span class="ml-1 rounded-full bg-red-600 px-2 py-0.5 text-xs text-white">{{ $cartCount }}</span>
                    @endif
                </a>
            </nav>
        </div>
    </header>

    <section class="bg-zinc-900 text-white py-12 px-4 sm:px-6">
        <div class="max-w-7xl mx-auto">
            <p class="text-red-400 text-sm font-semibold uppercase tracking-wide">KantinPapa</p>
            <h1 class="mt-2 text-4xl font-black">Menu Kantin</h1>
            <p class="mt-3 text-gray-300">Pilih menu favoritmu dan pesan untuk diambil di kantin.</p>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
        @if (session('success'))
            <div class="mb-5 rounded-lg bg-green-50 p-3 text-sm text-green-700">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ route('users.home') }}" class="mb-6 flex flex-col gap-3 sm:flex-row">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari menu..."
                class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
            <select name="category" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm">
                <option value="">Semua kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) request('category') === (string) $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button class="rounded-lg bg-zinc-800 px-5 py-2.5 text-sm font-semibold text-white hover:bg-zinc-700">Cari</button>
        </form>

        @if ($menus->isEmpty())
            <div class="rounded-xl border border-dashed border-gray-300 bg-white px-6 py-14 text-center">
                <h2 class="font-semibold text-gray-900">Menu belum tersedia</h2>
                <p class="mt-2 text-sm text-gray-500">Silakan kembali lagi nanti atau ubah pencarianmu.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($menus as $menu)
                    <article class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                        @if ($menu->img_url)
                            <img src="{{ $menu->img_url }}" alt="{{ $menu->name }}" class="h-48 w-full object-cover">
                        @else
                            <div class="flex h-48 items-center justify-center bg-gray-100 text-sm text-gray-400">Foto menu tidak tersedia</div>
                        @endif
                        <div class="p-5">
                            @if ($menu->category)
                                <span class="text-xs font-medium text-red-600">{{ $menu->category->name }}</span>
                            @endif
                            <h2 class="mt-1 font-bold text-gray-900">{{ $menu->name }}</h2>
                            @if ($menu->description)
                                <p class="mt-2 min-h-10 text-sm text-gray-500">{{ $menu->description }}</p>
                            @endif
                            <div class="mt-4 flex items-center justify-between">
                                <span class="font-semibold text-gray-900">Rp {{ number_format((float) $menu->price, 0, ',', '.') }}</span>
                                <form method="POST" action="{{ route('users.cart.add', $menu) }}">
                                    @csrf
                                    <button class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">
                                        + Tambah
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </main>
</body>

</html>
