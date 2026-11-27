@extends('layouts.app')

@section('content')
    <div class="w-full min-h-[70vh] bg-neutral-100">
        <main class="max-w-5xl mx-auto px-4 sm:px-8 py-8">

            {{-- Stepper --}}
            <div class="flex items-center gap-4 mb-8">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-green-500 text-white text-sm font-bold flex items-center justify-center">✓</span>
                    <span class="font-semibold text-neutral-900 text-sm">Review</span>
                </div>
                <div class="h-px w-12 bg-neutral-300"></div>
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-full bg-red-600 text-white text-sm font-bold flex items-center justify-center">2</span>
                    <span class="font-semibold text-neutral-900 text-sm">Payment</span>
                </div>
            </div>

            @if (! empty($warnings))
                <div class="mb-4 bg-amber-50 border border-amber-200 text-amber-800 text-sm px-4 py-3 rounded-lg space-y-1">
                    @foreach ($warnings as $warning)
                        <p>{{ $warning }}</p>
                    @endforeach
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                <div class="lg:col-span-2 bg-white rounded-2xl border border-neutral-200 p-6">
                    <h1 class="font-bold text-neutral-900 text-lg uppercase tracking-wider mb-1">QRIS Payment</h1>
                    <p class="text-sm text-neutral-500 mb-6">Scan the QR code below with any mobile banking or e-wallet app.</p>

                    <div class="border border-neutral-200 rounded-xl p-6 flex flex-col items-center text-center">
                        <div class="w-48 h-48 bg-neutral-100 border border-neutral-300 rounded-xl flex items-center justify-center mb-4">
                            <div class="text-center px-4">
                                <div class="text-xs font-bold uppercase tracking-widest text-neutral-500 mb-1">QRIS</div>
                                <div class="text-sm font-semibold text-neutral-800">KantinPapa</div>
                            </div>
                        </div>
                        <p class="text-xs text-neutral-500">Amount to Pay</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">Rp {{ number_format($totals['total'], 0, ',', '.') }}</p>
                        <p class="text-xs text-amber-600 mt-2 font-medium">● Waiting for payment confirmation</p>
                    </div>

                    <div class="mt-6 flex items-center gap-4">
                        <a href="{{ route('checkout.review') }}"
                            class="flex-1 text-center border border-neutral-300 hover:bg-neutral-50 text-neutral-700 text-sm font-semibold py-3 rounded-xl">
                            Back
                        </a>
                        <form action="{{ route('checkout.store') }}" method="POST" class="flex-1"
                            onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.textContent = 'Processing...';">
                            @csrf
                            <input type="hidden" name="checkout_token" value="{{ $checkoutToken }}">
                            <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 disabled:opacity-60 transition-colors text-white text-sm font-semibold py-3 rounded-xl">
                                Place Order
                            </button>
                        </form>
                    </div>
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
