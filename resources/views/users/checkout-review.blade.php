@extends('layouts.app')

@section('content')
    <div class="w-full min-h-[70vh] bg-neutral-100">
        <main class="max-w-5xl mx-auto px-4 sm:px-8 py-8">

            {{-- Stepper --}}
            <div class="flex items-center gap-4 mb-8">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-red-600 text-white text-sm font-bold flex items-center justify-center">1</span>
                    <span class="font-semibold text-neutral-900 text-sm">Review</span>
                </div>
                <div class="h-px w-12 bg-neutral-300"></div>
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-neutral-300 text-neutral-600 text-sm font-bold flex items-center justify-center">2</span>
                    <span class="font-medium text-neutral-400 text-sm">Payment</span>
                </div>
            </div>

            @if (! empty($warnings))
                <div class="mb-4 bg-amber-50 border border-amber-200 text-amber-800 text-sm px-4 py-3 rounded-lg space-y-1">
                    @foreach ($warnings as $warning)
                        <p>{{ $warning }}</p>
                    @endforeach
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                <div class="lg:col-span-2 bg-white rounded-2xl border border-neutral-200 p-6">
                    <h1 class="font-bold text-neutral-900 text-2xl mb-6">Review Your Order</h1>

                    <div class="space-y-4">
                        @foreach ($items as $item)
                            @php($menu = $item['menu'])
                            <div class="flex items-center gap-4 pb-4 border-b border-neutral-100 last:border-b-0 last:pb-0">
                                <img src="{{ $menu->imageUrl() }}" alt="{{ $menu->name }}"
                                    class="w-16 h-16 rounded-xl object-cover flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <h2 class="font-semibold text-neutral-900 text-sm">{{ $menu->name }}</h2>
                                    <p class="text-xs text-neutral-500 mt-0.5">Qty: {{ $item['qty'] }} × Rp {{ number_format($item['unit_price'], 0, ',', '.') }}</p>
                                </div>
                                <div class="font-semibold text-neutral-900 text-sm whitespace-nowrap">
                                    Rp {{ number_format($item['line_total'], 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('checkout.payment') }}"
                        class="mt-6 block text-center w-full bg-red-600 hover:bg-red-700 transition-colors text-white text-sm font-semibold py-3 rounded-xl">
                        Continue to Payment
                    </a>
                </div>

                <div class="bg-white rounded-2xl border border-neutral-200 p-6">
                    <h2 class="font-bold text-neutral-900 text-sm uppercase tracking-wider mb-4">Order Summary</h2>

                    <div class="space-y-2 text-sm text-neutral-600 pb-4 border-b border-neutral-200">
                        @foreach ($items as $item)
                            <div class="flex justify-between">
                                <span>{{ $item['menu']->name }} ×{{ $item['qty'] }}</span>
                                <span>Rp {{ number_format($item['line_total'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-2 text-sm text-neutral-600 py-4 border-b border-neutral-200">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($totals['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Tax 10%</span>
                            <span>Rp {{ number_format($totals['tax_amount'], 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-4">
                        <span class="font-bold text-neutral-900 text-sm">Total</span>
                        <span class="font-bold text-red-600 text-base">Rp {{ number_format($totals['total'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

        </main>
    </div>
@endsection
