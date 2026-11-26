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
                    <div class="border border-neutral-200 rounded-md px-6 py-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="font-semibold text-neutral-950 text-sm">{{ $order->order_number }}</h2>
                                <p class="text-xs text-neutral-400 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="{{ $order->payment_status->badgeClasses() }} text-xs font-medium px-3 py-1 rounded-full">
                                    {{ $order->payment_status->label() }}
                                </span>
                                <span class="{{ $order->order_status->badgeClasses() }} text-xs font-medium px-3 py-1 rounded-full">
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

                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs text-neutral-400">Total (incl.tax):</span>
                                <span class="font-semibold text-neutral-950 text-sm ml-2">{{ $order->formattedTotal() }}</span>
                            </div>
                            <form action="{{ route('orders.reorder', $order) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 transition-colors text-white text-xs font-semibold px-4 py-2 rounded-md">
                                    Order Again
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
@endsection
