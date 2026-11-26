@extends('layouts.app')

@section('content')
    <div class="w-full min-h-[70vh] bg-neutral-100">
        <main class="max-w-5xl mx-auto px-4 sm:px-8 py-8">
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
                        class="w-full bg-red-600 hover:bg-red-700 transition-colors text-white text-sm font-medium py-2.5 rounded-md">
                        Lanjut Pembayaran
                    </button>
                </div>

            </div>
        </main>
    </div>
@endsection
