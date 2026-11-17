<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KantinPapa - Keranjang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-neutral-100">
    <header class="flex items-center justify-between border-b border-neutral-200 bg-white px-6 py-4">
        <a href="{{ route('users.home') }}" class="text-lg font-semibold text-neutral-900">Kantin<span class="text-red-600">Papa</span></a>
        <nav class="flex gap-5 text-sm">
            <a href="{{ route('users.home') }}" class="text-neutral-600 hover:text-red-600">Menu</a>
            <a href="{{ route('users.orders') }}" class="text-neutral-600 hover:text-red-600">Pesanan Saya</a>
        </nav>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-8">
        <h1 class="mb-6 text-2xl font-semibold text-neutral-900">Keranjang</h1>

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-50 p-3 text-sm text-green-700">{{ session('success') }}</div>
        @endif
        @error('cart')
            <div class="mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">{{ $message }}</div>
        @enderror

        @if ($items->isEmpty())
            <div class="rounded-xl border border-neutral-200 bg-white px-6 py-14 text-center">
                <h2 class="font-semibold text-neutral-900">Keranjang masih kosong</h2>
                <p class="mt-2 text-sm text-neutral-500">Tambahkan menu terlebih dahulu untuk mulai memesan.</p>
                <a href="{{ route('users.home') }}" class="mt-5 inline-block rounded-md bg-red-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-700">
                    Lihat Menu
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 items-start gap-6 lg:grid-cols-3">
                <div class="flex flex-col gap-4 lg:col-span-2">
                    @foreach ($items as $item)
                        <article class="flex flex-wrap items-center gap-4 rounded-lg border border-neutral-200 bg-white p-4">
                            @if ($item['menu']->img_url)
                                <img src="{{ $item['menu']->img_url }}" alt="{{ $item['menu']->name }}" class="h-20 w-20 rounded-md object-cover">
                            @endif
                            <div class="min-w-0 flex-1">
                                <h2 class="text-sm font-semibold text-neutral-900">{{ $item['menu']->name }}</h2>
                                <p class="mt-1 text-sm text-neutral-500">Rp {{ number_format((float) $item['menu']->price, 0, ',', '.') }} / item</p>
                            </div>
                            @if (!$item['menu']->is_available)
                                <span class="text-sm font-medium text-red-600">Tidak tersedia</span>
                            @endif
                            <form method="POST" action="{{ route('users.cart.update', $item['menu']) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <label for="quantity-{{ $item['menu']->id }}" class="sr-only">Jumlah {{ $item['menu']->name }}</label>
                                <input id="quantity-{{ $item['menu']->id }}" type="number" name="quantity" min="1" max="99"
                                    value="{{ $item['quantity'] }}" class="w-20 rounded border border-neutral-300 px-2 py-1.5 text-sm">
                                <button class="rounded border border-neutral-300 px-3 py-1.5 text-sm hover:bg-neutral-50">Ubah</button>
                            </form>
                            <form method="POST" action="{{ route('users.cart.remove', $item['menu']) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-sm text-red-600 hover:text-red-700">Hapus</button>
                            </form>
                            <span class="w-full text-right text-sm font-semibold text-neutral-900">
                                Rp {{ number_format($item['lineTotal'], 0, ',', '.') }}
                            </span>
                        </article>
                    @endforeach
                </div>

                <aside class="rounded-lg bg-white p-5 shadow-sm">
                    <h2 class="mb-4 font-semibold text-neutral-900">Ringkasan Pesanan</h2>
                    <div class="mb-2 flex justify-between text-sm text-neutral-600">
                        <span>Subtotal ({{ $cartCount }} item)</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="mb-4 flex justify-between text-sm text-neutral-600">
                        <span>Pajak (10%)</span>
                        <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="mb-5 flex justify-between border-t border-neutral-200 pt-4 font-semibold">
                        <span>Total</span>
                        <span class="text-red-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <form method="POST" action="{{ route('users.checkout') }}">
                        @csrf
                        <button class="w-full rounded-md bg-red-600 py-2.5 text-sm font-medium text-white hover:bg-red-700">
                            Buat Pesanan
                        </button>
                    </form>
                </aside>
            </div>
        @endif
    </main>
</body>

</html>
