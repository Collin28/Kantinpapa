<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KantinPapa - Riwayat Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-white">
    <header class="border-b border-neutral-200">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-5">
            <a href="{{ route('users.home') }}" class="text-lg font-semibold text-neutral-950">Kantin<span class="text-red-500">Papa</span></a>
            <nav class="flex items-center gap-6 text-sm">
                <a href="{{ route('users.home') }}" class="text-neutral-500 hover:text-neutral-800">Menu</a>
                <a href="{{ route('users.cart') }}" class="text-neutral-500 hover:text-neutral-800">Keranjang</a>
                <span class="font-medium text-red-600">Pesanan Saya</span>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-6 py-10">
        <div class="mb-8 flex items-start justify-between gap-4">
            <div>
                <h1 class="mb-1 text-3xl font-bold text-neutral-950">Riwayat Pesanan</h1>
                <p class="text-sm text-neutral-500">Menu yang pernah kamu pesan.</p>
            </div>
            <a href="{{ route('users.home') }}" class="whitespace-nowrap rounded-md bg-red-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-700">
                Pesan Lagi
            </a>
        </div>

        @if (session('success'))
            <div class="mb-5 rounded-lg bg-green-50 p-3 text-sm text-green-700">{{ session('success') }}</div>
        @endif

        @forelse ($orders as $order)
            <article class="mb-4 rounded-lg border border-neutral-200 px-5 py-6 sm:px-6">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-semibold text-neutral-950">{{ $order->order_number }}</h2>
                        <p class="mt-1 text-xs text-neutral-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <span class="rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-xs font-medium capitalize text-amber-700">
                        {{ $order->status }}
                    </span>
                </div>

                <div class="mt-5 flex flex-col gap-3">
                    @foreach ($order->items as $item)
                        <div class="flex items-start justify-between gap-4 text-sm">
                            <span class="text-neutral-800">
                                {{ $item->menu_name }}
                                <span class="text-neutral-400">x{{ $item->quantity }}</span>
                                <span class="mt-1 block text-xs text-neutral-400">Rp {{ number_format((float) $item->unit_price, 0, ',', '.') }} / item</span>
                            </span>
                            <span class="whitespace-nowrap text-neutral-600">Rp {{ number_format((float) $item->line_total, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <hr class="my-5 border-neutral-200">

                <div class="ml-auto max-w-xs space-y-2 text-sm">
                    <div class="flex justify-between text-neutral-500">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format((float) $order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-neutral-500">
                        <span>Pajak</span>
                        <span>Rp {{ number_format((float) $order->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-neutral-950">
                        <span>Total</span>
                        <span>Rp {{ number_format((float) $order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-dashed border-neutral-300 px-6 py-14 text-center">
                <h2 class="font-semibold text-neutral-900">Belum ada pesanan</h2>
                <p class="mt-2 text-sm text-neutral-500">Pesanan yang sudah dibuat akan muncul di halaman ini.</p>
                <a href="{{ route('users.home') }}" class="mt-5 inline-block rounded-md bg-red-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-700">
                    Lihat Menu
                </a>
            </div>
        @endforelse
    </main>
</body>

</html>
