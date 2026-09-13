<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KantinPapa - Order History</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-white min-h-screen">

    <!-- Navbar -->
    <header class="border-b border-neutral-200">
        <div class="max-w-5xl mx-auto px-6 lg:px-16 py-5 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 bg-red-600 inline-block"></span>
                <span class="font-semibold text-lg">
                    <span class="text-neutral-950">Kantin</span><span class="text-red-500">Papa</span>
                </span>
            </div>

            <nav class="hidden sm:flex items-center gap-8 text-sm">
                <a href="#" class="text-neutral-500 hover:text-neutral-800">Menu</a>
                <a href="#" class="text-red-600 font-medium">My Orders</a>
            </nav>

            <div class="flex items-center gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-neutral-700" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.994-4.693 2.573-7.158.075-.323-.155-.642-.494-.642H5.106M7.5 14.25L5.106 5.25M7.5 14.25L6 21m9-6.75L15 21" />
                </svg>
                <div
                    class="w-8 h-8 rounded-full bg-neutral-950 flex items-center justify-center text-white font-semibold text-xs">
                    B</div>
                <span class="hidden sm:inline text-sm text-neutral-800">Budi</span>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="max-w-5xl mx-auto px-6 lg:px-16 py-10">
        <div class="flex items-start justify-between mb-8 gap-4">
            <div>
                <h1 class="font-bold text-neutral-950 text-3xl mb-1">Order History</h1>
                <p class="text-neutral-500 text-sm">All your KantinPapa orders in one place</p>
            </div>
            <button
                class="bg-red-600 hover:bg-red-600/90 transition-colors text-white text-sm font-medium px-5 py-2.5 rounded-md whitespace-nowrap">
                Order Again
            </button>
        </div>

        <div class="flex flex-col gap-4">

            <!-- Order Card 1 -->
            <div class="border border-neutral-200 rounded-md px-6 py-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="font-semibold text-neutral-950 text-sm">HTG-891245</h2>
                        <p class="text-xs text-neutral-400 mt-1">20 Aug 2026, 11:32</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span
                            class="bg-blue-50 border border-blue-200 text-blue-600 text-xs font-medium px-3 py-1 rounded-full">Paid</span>
                        <span
                            class="bg-emerald-50 border border-emerald-200 text-emerald-600 text-xs font-medium px-3 py-1 rounded-full">Completed</span>
                    </div>
                </div>

                <div class="mt-5 flex flex-col gap-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-neutral-800">Nasi Ayam Bakar <span class="text-neutral-400">x2</span></span>
                        <span class="text-neutral-500">Rp 36.000</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-neutral-800">Es Teh Manis <span class="text-neutral-400">x2</span></span>
                        <span class="text-neutral-500">Rp 10.000</span>
                    </div>
                </div>

                <hr class="border-neutral-200 my-5">

                <div class="flex items-center justify-between">
                    <span class="text-xs text-neutral-400">Total (incl.tax)</span>
                    <span class="font-semibold text-neutral-950 text-sm">Rp 50.600</span>
                </div>
            </div>

            <!-- Order Card 2 -->
            <div class="border border-neutral-200 rounded-md px-6 py-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="font-semibold text-neutral-950 text-sm">HTG-887831</h2>
                        <p class="text-xs text-neutral-400 mt-1">19 Aug 2026, 12:03</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span
                            class="bg-blue-50 border border-blue-200 text-blue-600 text-xs font-medium px-3 py-1 rounded-full">Paid</span>
                        <span
                            class="bg-emerald-50 border border-emerald-200 text-emerald-600 text-xs font-medium px-3 py-1 rounded-full">Completed</span>
                    </div>
                </div>

                <div class="mt-5 flex flex-col gap-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-neutral-800">Mie Goreng Spesial <span
                                class="text-neutral-400">x1</span></span>
                        <span class="text-neutral-500">Rp 16.000</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-neutral-800">Jus Alpukat <span class="text-neutral-400">x1</span></span>
                        <span class="text-neutral-500">Rp 12.000</span>
                    </div>
                </div>

                <hr class="border-neutral-200 my-5">

                <div class="flex items-center justify-between">
                    <span class="text-xs text-neutral-400">Total (incl.tax)</span>
                    <span class="font-semibold text-neutral-950 text-sm">Rp 30.800</span>
                </div>
            </div>

        </div>
    </main>

</body>

</html>