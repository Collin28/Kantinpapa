<?php

namespace App\Http\Controllers\Customer;

use App\Contracts\PaymentGatewayInterface;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\ExpirePendingOrdersService;
use App\Services\OrderStatusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function show(
        Request $request,
        Order $order,
        ExpirePendingOrdersService $expiry,
        PaymentGatewayInterface $gateway
    ): View|RedirectResponse {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        $expiry->expireIfNeeded($order);
        $order->refresh();

        if ($order->order_status === OrderStatus::Cancelled) {
            return redirect()
                ->route('orders.index')
                ->with('error', "Order {$order->order_number} has expired or was cancelled.");
        }

        if ($order->payment_status === PaymentStatus::Paid) {
            return redirect()->route('orders.confirmed', $order);
        }

        $order->load(['items', 'payment']);

        return view('users.order-pay', [
            'order' => $order,
            'qrPayload' => $gateway->buildQrPayload($order),
        ]);
    }

    public function simulate(
        Request $request,
        Order $order,
        ExpirePendingOrdersService $expiry,
        OrderStatusService $orderStatusService
    ): RedirectResponse {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($expiry->expireIfNeeded($order)) {
            return redirect()
                ->route('orders.index')
                ->with('error', "Order {$order->order_number} has expired and stock was released.");
        }

        $order->refresh();

        if ($order->order_status === OrderStatus::Cancelled) {
            return redirect()
                ->route('orders.index')
                ->with('error', "Order {$order->order_number} was cancelled.");
        }

        if ($order->payment_status !== PaymentStatus::Paid) {
            $updated = $orderStatusService->transition($order, OrderStatus::Paid);
            if ($updated->payment) {
                $payload = $updated->payment->raw_payload ?? [];
                $payload['simulated_at'] = now()->toIso8601String();
                $updated->payment->update(['raw_payload' => $payload]);
            }
        }

        return redirect()
            ->route('orders.confirmed', $order)
            ->with('success', 'QRIS payment confirmed!');
    }

    public function status(
        Request $request,
        Order $order,
        ExpirePendingOrdersService $expiry
    ): JsonResponse {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        $expiry->expireIfNeeded($order);
        $order->refresh();

        return response()->json([
            'order_number' => $order->order_number,
            'order_status' => $order->order_status->value,
            'order_status_label' => $order->order_status->label(),
            'order_badge_classes' => $order->order_status->badgeClasses(),
            'payment_status' => $order->payment_status->value,
            'payment_status_label' => $order->payment_status->label(),
            'payment_badge_classes' => $order->payment_status->badgeClasses(),
            'expires_at' => $order->expires_at?->toIso8601String(),
        ]);
    }
}
