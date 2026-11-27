<?php

namespace App\Contracts;

use App\Models\Order;
use App\Models\Payment;

interface PaymentGatewayInterface
{
    public function createCharge(Order $order): Payment;

    public function buildQrPayload(Order $order): string;

    public function verifyWebhookSignature(string $rawBody, string $signature): bool;
}
