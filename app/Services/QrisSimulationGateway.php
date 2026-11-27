<?php

namespace App\Services;

use App\Contracts\PaymentGatewayInterface;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;

class QrisSimulationGateway implements PaymentGatewayInterface
{
    public function createCharge(Order $order): Payment
    {
        $providerRef = 'QRIS-'.$order->order_number;
        $qrPayload = $this->buildQrPayload($order);

        return $order->payment()->create([
            'method' => 'qris',
            'provider_ref' => $providerRef,
            'amount' => $order->total,
            'status' => PaymentStatus::Pending,
            'raw_payload' => [
                'gateway' => 'simulation',
                'qr_payload' => $qrPayload,
                'expires_at' => $order->expires_at?->toIso8601String(),
            ],
        ]);
    }

    public function buildQrPayload(Order $order): string
    {
        return sprintf(
            '00020101021226380015ID.KANTINPAPA.QR0115%s530336054%02d%d5802ID5910KANTINPAPA6007JAKARTA6214%s',
            'KANTINPAPA00001',
            strlen((string) $order->total),
            $order->total,
            $order->order_number
        );
    }

    public function verifyWebhookSignature(string $rawBody, string $signature): bool
    {
        $secret = $this->webhookSecret();

        if ($secret === '' || $signature === '') {
            return false;
        }

        $expected = hash_hmac('sha256', $rawBody, $secret);

        return hash_equals($expected, $signature);
    }

    public function signPayload(string $rawBody): string
    {
        return hash_hmac('sha256', $rawBody, $this->webhookSecret());
    }

    private function webhookSecret(): string
    {
        return (string) (config('services.qris.webhook_secret') ?: config('app.key', ''));
    }
}
