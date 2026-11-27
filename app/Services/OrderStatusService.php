<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderStatusService
{
    /**
     * Allowed status transitions map.
     *
     * @return array<string, array<int, OrderStatus>>
     */
    public function allowedTransitions(OrderStatus $current): array
    {
        return match ($current) {
            OrderStatus::Pending => [OrderStatus::Paid, OrderStatus::Cancelled],
            OrderStatus::Paid => [OrderStatus::Preparing, OrderStatus::Cancelled],
            OrderStatus::Preparing => [OrderStatus::Ready, OrderStatus::Cancelled],
            OrderStatus::Ready => [OrderStatus::Completed, OrderStatus::Cancelled],
            OrderStatus::Completed, OrderStatus::Cancelled => [],
        };
    }

    public function canTransition(OrderStatus $from, OrderStatus $to): bool
    {
        return in_array($to, $this->allowedTransitions($from), true);
    }

    public function nextForwardStatus(OrderStatus $current): ?OrderStatus
    {
        return match ($current) {
            OrderStatus::Pending => OrderStatus::Paid,
            OrderStatus::Paid => OrderStatus::Preparing,
            OrderStatus::Preparing => OrderStatus::Ready,
            OrderStatus::Ready => OrderStatus::Completed,
            OrderStatus::Completed, OrderStatus::Cancelled => null,
        };
    }

    public function transition(Order $order, OrderStatus $targetStatus): Order
    {
        return DB::transaction(function () use ($order, $targetStatus) {
            /** @var Order $lockedOrder */
            $lockedOrder = Order::with(['items', 'payment'])
                ->lockForUpdate()
                ->findOrFail($order->id);

            $currentStatus = $lockedOrder->order_status;

            if (! $this->canTransition($currentStatus, $targetStatus)) {
                throw ValidationException::withMessages([
                    'status' => "Cannot transition order from {$currentStatus->label()} to {$targetStatus->label()}.",
                ]);
            }

            if ($targetStatus === OrderStatus::Paid) {
                $paidAt = now();

                $lockedOrder->update([
                    'order_status' => OrderStatus::Paid,
                    'payment_status' => PaymentStatus::Paid,
                    'paid_at' => $paidAt,
                ]);

                if ($lockedOrder->payment) {
                    $lockedOrder->payment->update([
                        'status' => PaymentStatus::Paid,
                        'paid_at' => $paidAt,
                    ]);
                }

                return $lockedOrder->fresh(['user', 'items', 'payment']);
            }

            if ($targetStatus === OrderStatus::Cancelled) {
                $menuIds = $lockedOrder->items->pluck('menu_id')->unique()->values()->all();

                if (! empty($menuIds)) {
                    $menus = Menu::withTrashed()
                        ->whereIn('id', $menuIds)
                        ->lockForUpdate()
                        ->get()
                        ->keyBy('id');

                    foreach ($lockedOrder->items as $item) {
                        $menu = $menus->get($item->menu_id);
                        if ($menu) {
                            $menu->increment('stock', $item->qty);
                        }
                    }
                }

                $lockedOrder->update([
                    'order_status' => OrderStatus::Cancelled,
                ]);

                return $lockedOrder->fresh(['user', 'items', 'payment']);
            }

            $lockedOrder->update([
                'order_status' => $targetStatus,
            ]);

            return $lockedOrder->fresh(['user', 'items', 'payment']);
        });
    }
}
