@extends('layouts.app')

@section('content')
    <div class="w-full min-h-[70vh] bg-neutral-100">
        <main class="max-w-5xl mx-auto px-4 sm:px-8 py-8">
            <h1 class="text-xl font-semibold text-neutral-900 mb-6">Shopping Cart</h1>

            @if (session('success'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

                <!-- Cart items -->
                <div class="lg:col-span-2 flex flex-col gap-4">
                    @foreach ($items as $item)
                        @php($menu = $item['menu'])
                        <div class="bg-white rounded-lg border border-neutral-200 p-4 flex items-center gap-4">
                            <img src="{{ $menu->imageUrl() }}" alt="{{ $menu->name }}"
                                class="w-20 h-20 rounded-md object-cover flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <h2 class="font-semibold text-neutral-900 text-sm">{{ $menu->name }}</h2>
                                @if ($menu->description)
                                    <p class="text-xs text-neutral-500 mt-1 leading-relaxed line-clamp-2">{{ $menu->description }}</p>
                                @endif
                                <div class="mt-3 flex items-center gap-2">
                                    <form action="{{ route('cart.update', $menu) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="qty" value="{{ $item['qty'] - 1 }}">
                                        <button type="submit"
                                            class="w-7 h-7 rounded-md border border-neutral-300 text-neutral-700 hover:bg-neutral-100 text-sm font-semibold">-</button>
                                    </form>
                                    <span class="text-sm font-medium px-2">{{ $item['qty'] }}</span>
                                    <form action="{{ route('cart.update', $menu) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="qty" value="{{ $item['qty'] + 1 }}">
                                        <button type="submit"
                                            class="w-7 h-7 rounded-md border border-neutral-300 text-neutral-700 hover:bg-neutral-100 text-sm font-semibold">+</button>
                                    </form>
                                    <form action="{{ route('cart.destroy', $menu) }}" method="POST" class="ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-500 hover:underline">Remove</button>
                                    </form>
                                </div>
                            </div>
                            <div class="font-semibold text-neutral-900 text-sm whitespace-nowrap">
                                Rp {{ number_format($item['line_total'], 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="bg-neutral-200/60 rounded-lg p-5">
                    <h2 class="font-semibold text-neutral-900 text-sm mb-4">Order Summary</h2>

                    <div class="flex justify-between text-sm text-neutral-600 mb-2">
                        <span>Subtotal ({{ $totals['count'] }})</span>
                        <span>Rp {{ number_format($totals['subtotal'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-neutral-600 mb-4">
                        <span>Pajak (10%)</span>
                        <span>Rp {{ number_format($totals['tax_amount'], 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between items-center border-t border-neutral-300 pt-4 mb-5">
                        <span class="font-semibold text-neutral-900 text-sm">Total</span>
                        <span class="font-semibold text-red-600 text-base">Rp {{ number_format($totals['total'], 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('checkout.review') }}"
                        class="block text-center w-full bg-red-600 hover:bg-red-700 transition-colors text-white text-sm font-medium py-2.5 rounded-md">
                        Lanjut Pembayaran
                    </a>
                </div>

            </div>
        </main>
    </div>
@endsection
