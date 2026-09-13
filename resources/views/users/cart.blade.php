<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KantinPapa - Shopping Cart</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>

    <div class="w-full min-h-screen bg-neutral-100">


        <header class="flex items-center justify-between px-8 py-4 bg-white border-b border-neutral-200">
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 bg-red-600 inline-block"></span>
                <span class="font-semibold text-lg">
                    <span class="text-neutral-900">Kantin</span><span class="text-red-600">Papa</span>
                </span>
            </div>

            <nav>
                <a href="#" class="text-red-600 font-medium text-sm">Menu</a>
            </nav>

            <div class="flex items-center gap-5">
                <div class="relative flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-neutral-800" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.98-4.804 2.545-7.454A1.125 1.125 0 0019.905 4.5H5.106M7.5 14.25L5.106 4.5M7.5 14.25L5.25 20.25M17.25 20.25a.75.75 0 100-1.5.75.75 0 000 1.5zm-9 0a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                    </svg>
                    <span
                        class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] font-semibold rounded-full w-4 h-4 flex items-center justify-center">2</span>
                </div>
                <button
                    class="bg-red-600 hover:bg-red-600/90 transition-colors text-white text-sm font-medium px-5 py-2 rounded-md">
                    Login
                </button>
            </div>
        </header>


        <main class="px-8 py-8">
            <h1 class="text-xl font-semibold text-neutral-900 mb-6">Shopping Cart</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

                <!-- Cart items -->
                <div class="lg:col-span-2 flex flex-col gap-4">

                    <!-- Item 1 -->
                    <div class="bg-white rounded-lg border border-neutral-200 p-4 flex items-center gap-4">
                        <img src="https://images.unsplash.com/photo-1512058564366-18510be2db19?w=200&h=200&fit=crop"
                            alt="Nasi Ayam Bakar" class="w-20 h-20 rounded-md object-cover flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <h2 class="font-semibold text-neutral-900 text-sm">Nasi Ayam Bakar</h2>
                            <p class="text-xs text-neutral-500 mt-1 leading-relaxed">Grilled chicken over steamed
                                jasmine rice with sambal, fresh cucumber slices, and fresh shallots.</p>
                        </div>
                        <div class="font-semibold text-neutral-900 text-sm whitespace-nowrap">Rp 20.000</div>
                    </div>


                    <div class="bg-white rounded-lg border border-neutral-200 p-4 flex items-center gap-4">
                        <img src="https://images.unsplash.com/photo-1585032226651-759b368d7246?w=200&h=200&fit=crop"
                            alt="Mie Goreng Spesial" class="w-20 h-20 rounded-md object-cover flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <h2 class="font-semibold text-neutral-900 text-sm">Mie Goreng Spesial</h2>
                            <p class="text-xs text-neutral-500 mt-1 leading-relaxed">Wok-tossed egg noodles with shrimp,
                                chicken, egg, vegetables, and house sweet soy sauce.</p>
                        </div>
                        <div class="font-semibold text-neutral-900 text-sm whitespace-nowrap">Rp 18.000</div>
                    </div>

                </div>


                <div class="bg-neutral-200/60 rounded-lg p-5">
                    <h2 class="font-semibold text-neutral-900 text-sm mb-4">Order Summary</h2>

                    <div class="flex justify-between text-sm text-neutral-600 mb-2">
                        <span>Total (2)</span>
                        <span>Rp41.800</span>
                    </div>
                    <div class="flex justify-between text-sm text-neutral-600 mb-4">
                        <span>Pajak (10%)</span>
                        <span>Rp5.800</span>
                    </div>

                    <div class="flex justify-between items-center border-t border-neutral-300 pt-4 mb-5">
                        <span class="font-semibold text-neutral-900 text-sm">Total</span>
                        <span class="font-semibold text-red-600 text-base">Rp41.800</span>
                    </div>

                    <button
                        class="w-full bg-red-600 hover:bg-red-600/90 transition-colors text-white text-sm font-medium py-2.5 rounded-md">
                        Lanjut Pembayaran
                    </button>
                </div>

            </div>
        </main>
    </div>

</body>

</html>