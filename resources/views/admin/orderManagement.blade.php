@extends('layouts.admin')

@section('content')
    <h1 class="font-bold text-neutral-950 text-4xl mb-1">Order Management</h1>
    <p class="text-neutral-500 text-lg mb-6">Monitor and update order statuses in real time.</p>

    @if (session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm font-medium px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-wrap items-center gap-2 mb-6">
        <a href="{{ route('admin.orders.index') }}"
            class="{{ $selectedStatus === '' ? 'bg-neutral-950 text-white' : 'border border-neutral-200 text-neutral-500 hover:border-neutral-400' }} text-sm font-semibold px-5 py-2 rounded-full transition">
            All
        </a>
        @foreach ($statuses as $status)
            <a href="{{ route('admin.orders.index', ['status' => $status->value]) }}"
                class="{{ $selectedStatus === $status->value ? 'bg-neutral-950 text-white' : 'border border-neutral-200 text-neutral-500 hover:border-neutral-400' }} text-sm font-semibold px-5 py-2 rounded-full transition">
                {{ $status->label() }}
            </a>
        @endforeach
    </div>

    <div class="border border-neutral-200 rounded-2xl overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-neutral-200">
                    <th class="text-left font-bold text-neutral-950 tracking-wide px-6 py-5 whitespace-nowrap">
                        ORDER ID</th>
                    <th class="text-left font-bold text-neutral-950 tracking-wide px-4 py-5 whitespace-nowrap">
                        CUSTOMERS</th>
                    <th class="text-left font-bold text-neutral-950 tracking-wide px-4 py-5 whitespace-nowrap">
                        ITEMS</th>
                    <th class="text-left font-bold text-neutral-950 tracking-wide px-4 py-5 whitespace-nowrap">
                        QTY</th>
                    <th class="text-left font-bold text-neutral-950 tracking-wide px-4 py-5 whitespace-nowrap">
                        TOTAL</th>
                    <th class="text-left font-bold text-neutral-950 tracking-wide px-4 py-5 whitespace-nowrap">
                        PAYMENT</th>
                    <th class="text-left font-bold text-neutral-950 tracking-wide px-4 py-5 whitespace-nowrap">
                        STATUS</th>
                    <th class="text-left font-bold text-neutral-950 tracking-wide px-4 py-5 whitespace-nowrap">
                        DATE</th>
                    <th class="text-left font-bold text-neutral-950 tracking-wide px-6 py-5 whitespace-nowrap">
                        ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    @php
                        $nextStatus = $order->order_status->nextForwardStatus();
                        $totalQty = $order->items->sum('qty');
                        $itemsSummary = $order->items->map(fn ($item) => $item->menu_name.' ×'.$item->qty)->implode(', ');
                    @endphp
                    <tr class="border-b border-neutral-100 last:border-b-0">
                        <td class="px-6 py-4 font-semibold text-neutral-800 whitespace-nowrap">{{ $order->order_number }}</td>
                        <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">{{ $order->user?->name ?? 'Deleted User' }}</td>
                        <td class="px-4 py-4 text-neutral-500 max-w-xs">{{ $itemsSummary }}</td>
                        <td class="px-4 py-4 text-neutral-700">{{ $totalQty }}</td>
                        <td class="px-4 py-4 font-semibold text-neutral-900 whitespace-nowrap">{{ $order->formattedTotal() }}</td>
                        <td class="px-4 py-4">
                            <span class="{{ $order->payment_status->badgeClasses() }} text-xs font-semibold px-3 py-1.5 rounded-full whitespace-nowrap">
                                {{ $order->payment_status->label() }}
                            </span>
                        </td>
                        <td class="px-4 py-4">
                            <span class="{{ $order->order_status->badgeClasses() }} text-xs font-semibold px-3 py-1.5 rounded-full whitespace-nowrap">
                                {{ $order->order_status->label() }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-neutral-500 whitespace-nowrap">{{ $order->created_at->format('d M, H:i') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                @if ($nextStatus)
                                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $nextStatus->value }}">
                                        <button type="submit"
                                            class="bg-neutral-950 hover:bg-neutral-800 text-white text-xs font-semibold px-3 py-2 rounded-lg whitespace-nowrap transition">
                                            → {{ $nextStatus->label() }}
                                        </button>
                                    </form>
                                @endif
                                @if ($order->order_status->canBeCancelled())
                                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST"
                                        onsubmit="return confirm('Cancel order {{ $order->order_number }} and restore menu stock?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ \App\Enums\OrderStatus::Cancelled->value }}">
                                        <button type="submit"
                                            class="bg-red-50 hover:bg-red-100 text-red-500 text-xs font-semibold px-3 py-2 rounded-lg whitespace-nowrap transition">
                                            Cancel
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-10 text-center text-neutral-500">
                            No orders found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($orders->hasPages())
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
@endsection
