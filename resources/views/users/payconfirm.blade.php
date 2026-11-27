@extends('layouts.app')

@section('content')
    <div class="w-full min-h-[70vh] bg-neutral-100">
        <main class="flex flex-col items-center justify-center px-4 py-24 text-center">

            <div class="w-20 h-20 rounded-full bg-green-500 flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>

            <h1 class="font-bold text-neutral-900 text-2xl mb-3">
                {{ $order->payment_status === \App\Enums\PaymentStatus::Paid ? 'Payment Confirmed!' : 'Order Placed!' }}
            </h1>
            <p class="text-sm text-neutral-500 mb-1">Your order <span
                    class="font-semibold text-neutral-700">{{ $order->order_number }}</span></p>
            <p class="text-sm text-neutral-400 mb-4">Total: {{ $order->formattedTotal() }}.
                @if ($order->payment_status === \App\Enums\PaymentStatus::Paid)
                    Your order is being prepared for pickup at the counter.
                @else
                    Please complete QRIS payment within 15 minutes or wait for counter confirmation.
                @endif
            </p>

            @if (session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-2.5 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-wrap items-center justify-center gap-3 mt-4">
                @if ($order->payment_status === \App\Enums\PaymentStatus::Pending && $order->order_status === \App\Enums\OrderStatus::Pending)
                    <a href="{{ route('orders.pay', $order) }}"
                       class="bg-red-600 hover:bg-red-700 transition-colors text-white text-sm font-medium px-6 py-2.5 rounded-md">
                        Pay with QRIS
                    </a>
                @endif
                <a href="{{ route('orders.index') }}"
                   class="bg-white hover:bg-neutral-50 transition-colors text-neutral-700 text-sm font-medium px-6 py-2.5 rounded-md border border-neutral-300">
                    View Orders
                </a>
                <a href="{{ route('menu.index') }}"
                   class="{{ $order->payment_status === \App\Enums\PaymentStatus::Paid ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-white hover:bg-neutral-50 text-neutral-700 border border-neutral-300' }} transition-colors text-sm font-medium px-6 py-2.5 rounded-md">
                    Back To Menu
                </a>
            </div>

        </main>
    </div>
@endsection
