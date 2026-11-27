<?php

namespace App\Http\Controllers\Webhook;

use App\Contracts\PaymentGatewayInterface;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderStatusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QrisWebhookController extends Controller
{
    public function __invoke(
        Request $request,
        PaymentGatewayInterface $gateway,
        OrderStatusService $orderStatusService
    ): JsonResponse {
        $signature = (string) $request->header('X-Qris-Signature', '');

        if (! $gateway->verifyWebhookSignature($request->getContent(), $signature)) {
            return response()->json(['message' => 'Invalid signature.'], 401);
        }

        $validated = $request->validate([
            'order_number' => ['required', 'string'],
            'provider_ref' => ['required', 'string'],
            'amount' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:paid,failed'],
        ]);

        return DB::transaction(function () use ($validated, $orderStatusService) {
            $order = Order::with('payment')
                ->where('order_number', $validated['order_number'])
                ->lockForUpdate()
                ->first();

            if (! $order) {
                return response()->json(['message' => 'Order not found.'], 404);
            }

            if ($order->payment && $order->payment->provider_ref !== null && $order->payment->provider_ref !== $validated['provider_ref']) {
                return response()->json(['message' => 'Provider reference mismatch.'], 422);
            }

            if ($order->total !== (int) $validated['amount']) {
                return response()->json(['message' => 'Amount mismatch.'], 422);
            }

            if ($order->payment_status === PaymentStatus::Paid) {
                return response()->json(['status' => 'already_paid'], 200);
            }

            if ($order->order_status === OrderStatus::Cancelled) {
                return response()->json(['status' => 'order_cancelled'], 409);
            }

            if ($validated['status'] === 'paid') {
                $updated = $orderStatusService->transition($order, OrderStatus::Paid);
                if ($updated->payment) {
                    $payload = $updated->payment->raw_payload ?? [];
                    $payload['webhook_received_at'] = now()->toIso8601String();
                    $payload['webhook_payload'] = $validated;
                    $updated->payment->update(['raw_payload' => $payload]);
                }

                return response()->json(['status' => 'paid'], 200);
            }

            $updated = $orderStatusService->transition($order, OrderStatus::Cancelled);
            if ($updated->payment) {
                $payload = $updated->payment->raw_payload ?? [];
                $payload['webhook_received_at'] = now()->toIso8601String();
                $payload['webhook_payload'] = $validated;
                $updated->payment->update([
                    'status' => PaymentStatus::Failed,
                    'raw_payload' => $payload,
                ]);
            }

            return response()->json(['status' => 'failed'], 200);
        });
    }
}
