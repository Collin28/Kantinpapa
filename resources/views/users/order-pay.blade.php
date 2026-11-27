@extends('layouts.app')

@section('content')
    <div class="w-full min-h-[70vh] bg-neutral-100">
        <main class="max-w-5xl mx-auto px-4 sm:px-8 py-8">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <a href="{{ route('orders.index') }}" class="text-sm text-neutral-500 hover:text-neutral-800">← Back to My Orders</a>
                    <h1 class="font-bold text-neutral-900 text-2xl mt-1">QRIS Payment — {{ $order->order_number }}</h1>
                </div>
                <span id="payment-status-badge" class="{{ $order->payment_status->badgeClasses() }} text-xs font-semibold px-3 py-1.5 rounded-full">
                    {{ $order->payment_status->label() }}
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                <div class="lg:col-span-2 bg-white rounded-2xl border border-neutral-200 p-6">
                    <h2 class="font-bold text-neutral-900 text-base uppercase tracking-wider mb-1">Scan QRIS</h2>
                    <p class="text-sm text-neutral-500 mb-6">Scan the QR code below with any mobile banking or e-wallet app before time runs out.</p>

                    <div class="border border-neutral-200 rounded-xl p-6 flex flex-col items-center text-center">
                        <x-qris-code :seed="$qrPayload" />

                        <p class="text-xs text-neutral-500 mt-4">Order ID</p>
                        <p class="font-bold text-neutral-900 text-sm">{{ $order->order_number }}</p>

                        <p class="text-xs text-neutral-500 mt-3">Amount to Pay</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">{{ $order->formattedTotal() }}</p>

                        <p class="text-xs text-amber-600 mt-3 font-medium">
                            ● Waiting for payment
                            @if ($order->expires_at)
                                · Expires in <span id="qris-countdown" data-expires="{{ $order->expires_at->toIso8601String() }}">--:--</span>
                            @endif
                        </p>
                    </div>

                    <div class="mt-6 flex flex-col sm:flex-row items-center gap-3">
                        <a href="{{ route('orders.index') }}"
                            class="w-full sm:flex-1 text-center border border-neutral-300 hover:bg-neutral-50 text-neutral-700 text-sm font-semibold py-3 rounded-xl">
                            Pay Later
                        </a>
                        <form action="{{ route('orders.pay.simulate', $order) }}" method="POST" class="w-full sm:flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 transition-colors text-white text-sm font-semibold py-3 rounded-xl">
                                Simulate QRIS Payment
                            </button>
                        </form>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-neutral-200 p-6">
                    <h2 class="font-bold text-neutral-900 text-sm uppercase tracking-wider mb-4">Order Summary</h2>

                    <div class="space-y-2 text-sm text-neutral-600 pb-4 border-b border-neutral-200">
                        @foreach ($order->items as $item)
                            <div class="flex justify-between">
                                <span>{{ $item->menu_name }} ×{{ $item->qty }}</span>
                                <span>{{ $item->formattedLineTotal() }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="space-y-2 text-sm text-neutral-600 py-4 border-b border-neutral-200">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Tax 10%</span>
                            <span>Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-4">
                        <span class="font-bold text-neutral-900 text-sm">Total</span>
                        <span class="font-bold text-red-600 text-base">{{ $order->formattedTotal() }}</span>
                    </div>
                </div>
            </div>

        </main>
    </div>
@endsection

@push('scripts')
<script>
    (function () {
        const countdownEl = document.getElementById('qris-countdown');
        if (countdownEl && countdownEl.dataset.expires) {
            const expiresAt = new Date(countdownEl.dataset.expires).getTime();
            const updateTimer = () => {
                const diff = Math.max(0, Math.floor((expiresAt - Date.now()) / 1000));
                const mins = String(Math.floor(diff / 60)).padStart(2, '0');
                const secs = String(diff % 60).padStart(2, '0');
                countdownEl.textContent = mins + ':' + secs;
            };
            updateTimer();
            setInterval(updateTimer, 1000);
        }

        const statusUrl = @json(route('orders.status', $order));
        const confirmedUrl = @json(route('orders.confirmed', $order));
        const ordersUrl = @json(route('orders.index'));

        setInterval(async () => {
            try {
                const res = await fetch(statusUrl, { headers: { 'Accept': 'application/json' } });
                if (!res.ok) return;
                const data = await res.json();
                if (data.payment_status === 'paid') {
                    window.location.href = confirmedUrl;
                } else if (data.order_status === 'cancelled') {
                    window.location.href = ordersUrl;
                }
            } catch (_) {}
        }, 5000);
    })();
</script>
@endpush
