<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ExpirePendingOrdersService
{
    public function __construct(
        private OrderStatusService $orderStatusService
    ) {}

    public function expireOverdueOrders(): int
    {
        $cutoff = now();
        $fallbackCutoff = $cutoff->copy()->subMinutes(15);

        $orderIds = Order::query()
            ->where('order_status', OrderStatus::Pending->value)
            ->where('payment_status', PaymentStatus::Pending->value)
            ->where(function ($query) use ($cutoff, $fallbackCutoff) {
                $query->where('expires_at', '<=', $cutoff)
                    ->orWhere(function ($sub) use ($fallbackCutoff) {
                        $sub->whereNull('expires_at')
                            ->where('created_at', '<=', $fallbackCutoff);
                    });
            })
            ->pluck('id');

        $expiredCount = 0;

        foreach ($orderIds as $orderId) {
            $order = Order::find($orderId);
            if ($order && $this->expireIfNeeded($order)) {
                $expiredCount++;
            }
        }

        return $expiredCount;
    }

    public function expireIfNeeded(Order $order): bool
    {
        if ($order->order_status !== OrderStatus::Pending || $order->payment_status !== PaymentStatus::Pending) {
            return false;
        }

        $isExpired = $order->expires_at !== null
            ? $order->expires_at->isPast()
            : $order->created_at->lte(now()->subMinutes(15));

        if (! $isExpired) {
            return false;
        }

        DB::transaction(function () use ($order) {
            $fresh = $order->fresh(['payment']);
            if (! $fresh || $fresh->order_status !== OrderStatus::Pending) {
                return;
            }

            $this->orderStatusService->transition($fresh, OrderStatus::Cancelled);

            if ($fresh->payment && $fresh->payment->status === PaymentStatus::Pending) {
                $payload = $fresh->payment->raw_payload ?? [];
                $payload['expired_at'] = now()->toIso8601String();

                $fresh->payment->update([
                    'status' => PaymentStatus::Failed,
                    'raw_payload' => $payload,
                ]);
            }
        });

        return true;
    }
}
