@extends('layouts.app')

@section('content')
    <main class="max-w-5xl mx-auto px-6 lg:px-16 py-10">
        <div class="flex items-start justify-between mb-8 gap-4">
            <div>
                <h1 class="font-bold text-neutral-950 text-3xl mb-1">Order History</h1>
                <p class="text-neutral-500 text-sm">All your KantinPapa orders in one place</p>
            </div>
            <a href="{{ route('menu.index') }}"
                class="bg-red-600 hover:bg-red-700 transition-colors text-white text-sm font-medium px-5 py-2.5 rounded-md whitespace-nowrap">
                Browse Menu
            </a>
        </div>

        <div id="order-live-toast" class="hidden mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium px-4 py-3 rounded-lg"></div>

        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if ($orders->isEmpty())
            <div class="border border-neutral-200 rounded-md px-6 py-12 text-center">
                <p class="text-neutral-600 font-medium mb-3">You haven't placed any orders yet.</p>
                <a href="{{ route('menu.index') }}" class="text-sm font-semibold text-red-600 hover:underline">
                    Start ordering now
                </a>
            </div>
        @else
            <div class="flex flex-col gap-4">
                @foreach ($orders as $order)
                    @php
                        $isActiveOrder = ! in_array($order->order_status, [\App\Enums\OrderStatus::Completed, \App\Enums\OrderStatus::Cancelled], true);
                    @endphp
                    <div class="border border-neutral-200 rounded-md px-6 py-6"
                        @if ($isActiveOrder)
                            data-poll-order="{{ $order->order_number }}"
                            data-status-url="{{ route('orders.status', $order) }}"
                            data-current-status="{{ $order->order_status->value }}"
                        @endif>
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="font-semibold text-neutral-950 text-sm">{{ $order->order_number }}</h2>
                                <p class="text-xs text-neutral-400 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span data-payment-badge class="{{ $order->payment_status->badgeClasses() }} text-xs font-medium px-3 py-1 rounded-full">
                                    {{ $order->payment_status->label() }}
                                </span>
                                <span data-order-badge class="{{ $order->order_status->badgeClasses() }} text-xs font-medium px-3 py-1 rounded-full">
                                    {{ $order->order_status->label() }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-5 flex flex-col gap-2">
                            @foreach ($order->items as $item)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-neutral-800">{{ $item->menu_name }} <span class="text-neutral-400">x{{ $item->qty }}</span></span>
                                    <span class="text-neutral-500">{{ $item->formattedLineTotal() }}</span>
                                </div>
                            @endforeach
                        </div>

                        <hr class="border-neutral-200 my-5">

                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div>
                                <span class="text-xs text-neutral-400">Total (incl.tax):</span>
                                <span class="font-semibold text-neutral-950 text-sm ml-2">{{ $order->formattedTotal() }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                @if ($order->order_status === \App\Enums\OrderStatus::Pending && $order->payment_status === \App\Enums\PaymentStatus::Pending)
                                    <a href="{{ route('orders.pay', $order) }}"
                                        class="border border-red-600 text-red-600 hover:bg-red-50 transition-colors text-xs font-semibold px-4 py-2 rounded-md">
                                        Pay Now (QRIS)
                                    </a>
                                @endif
                                <form action="{{ route('orders.reorder', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 transition-colors text-white text-xs font-semibold px-4 py-2 rounded-md">
                                        Order Again
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($orders->hasPages())
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif
    </main>
@endsection

@push('scripts')
<script>
    (function () {
        const activeCards = Array.from(document.querySelectorAll('[data-poll-order]'));
        if (activeCards.length === 0) return;

        const toast = document.getElementById('order-live-toast');

        async function pollOrders() {
            for (const card of activeCards) {
                const statusUrl = card.dataset.statusUrl;
                const previousStatus = card.dataset.currentStatus;
                if (!statusUrl || previousStatus === 'completed' || previousStatus === 'cancelled') continue;

                try {
                    const res = await fetch(statusUrl, { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) continue;
                    const data = await res.json();

                    if (data.order_status !== previousStatus) {
                        card.dataset.currentStatus = data.order_status;

                        const orderBadge = card.querySelector('[data-order-badge]');
                        if (orderBadge) {
                            orderBadge.className = data.order_badge_classes + ' text-xs font-medium px-3 py-1 rounded-full';
                            orderBadge.textContent = data.order_status_label;
                        }

                        const paymentBadge = card.querySelector('[data-payment-badge]');
                        if (paymentBadge) {
                            paymentBadge.className = data.payment_badge_classes + ' text-xs font-medium px-3 py-1 rounded-full';
                            paymentBadge.textContent = data.payment_status_label;
                        }

                        if (toast) {
                            const msg = data.order_status === 'ready'
                                ? `Order ${data.order_number} is Ready for pickup at the counter!`
                                : `Order ${data.order_number} status updated to ${data.order_status_label}.`;
                            toast.textContent = msg;
                            toast.classList.remove('hidden');
                        }
                    }
                } catch (_) {}
            }
        }

        setInterval(pollOrders, 8000);
    })();
</script>
@endpush
