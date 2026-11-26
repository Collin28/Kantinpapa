@extends('layouts.app')

@section('content')
    <main class="max-w-5xl mx-auto px-6 lg:px-16 py-10">
        <div class="flex items-start justify-between mb-8 gap-4">
            <div>
                <h1 class="font-bold text-neutral-950 text-3xl mb-1">Order History</h1>
                <p class="text-neutral-500 text-sm">All your KantinPapa orders in one place</p>
            </div>
            <button
                class="bg-red-600 hover:bg-red-700 transition-colors text-white text-sm font-medium px-5 py-2.5 rounded-md whitespace-nowrap">
                Order Again
            </button>
        </div>

        <div class="flex flex-col gap-4">

            <!-- Order Card 1 -->
            <div class="border border-neutral-200 rounded-md px-6 py-6">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="font-semibold text-neutral-950 text-sm">KTG-891245</h2>
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
                        <h2 class="font-semibold text-neutral-950 text-sm">KTG-887831</h2>
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
@endsection
