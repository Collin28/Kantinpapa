<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KantinPapa - Pesanan Dicatat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-neutral-100">
    <header class="flex items-center justify-between border-b border-neutral-200 bg-white px-6 py-4">
        <a href="{{ route('users.home') }}" class="text-lg font-semibold text-neutral-900">Kantin<span class="text-red-600">Papa</span></a>
        <a href="{{ route('users.orders') }}" class="text-sm text-neutral-600 hover:text-red-600">Pesanan Saya</a>
    </header>

    <main class="mx-auto flex max-w-xl flex-col items-center px-4 py-20 text-center">
        <div class="mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-green-500 text-4xl text-white">✓</div>
        <h1 class="mb-3 text-2xl font-bold text-neutral-900">Pesanan berhasil dicatat</h1>
        <p class="mb-2 text-sm text-neutral-500">
            Nomor pesanan <span class="font-semibold text-neutral-700">{{ $order->order_number }}</span>
        </p>
        <p class="mb-8 text-sm text-neutral-500">
            Status: <span class="font-medium capitalize">{{ $order->status }}</span>.
            Pembayaran belum dikonfirmasi.
        </p>
        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('users.orders') }}" class="rounded-md border border-neutral-300 bg-white px-6 py-2.5 text-sm font-medium text-neutral-700 hover:bg-neutral-50">
                Lihat Riwayat Pesanan
            </a>
            <a href="{{ route('users.home') }}" class="rounded-md bg-red-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-red-700">
                Kembali ke Menu
            </a>
        </div>
    </main>
</body>

</html>
