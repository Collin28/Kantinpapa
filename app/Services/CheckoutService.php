<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    public function __construct(
        private CartService $cartService
    ) {}

    public function placeOrder(User $user): Order
    {
        $rawCart = $this->cartService->raw();

        if (empty($rawCart)) {
            throw ValidationException::withMessages([
                'cart' => 'Your cart is empty.',
            ]);
        }

        $order = DB::transaction(function () use ($user, $rawCart) {
            $menus = Menu::whereIn('id', array_keys($rawCart))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $lineItems = [];
            $subtotal = 0;

            foreach ($rawCart as $menuId => $qty) {
                $menu = $menus->get($menuId);
                $qty = (int) $qty;

                if (! $menu || ! $menu->is_available || $menu->stock < $qty || $qty <= 0) {
                    $name = $menu?->name ?? 'Menu item';
                    throw ValidationException::withMessages([
                        'cart' => "{$name} is unavailable or does not have enough stock.",
                    ]);
                }

                $unitPrice = (int) round((float) $menu->price);
                $lineTotal = $unitPrice * $qty;
                $subtotal += $lineTotal;

                $lineItems[] = [
                    'menu' => $menu,
                    'menu_name' => $menu->name,
                    'unit_price' => $unitPrice,
                    'qty' => $qty,
                    'line_total' => $lineTotal,
                ];
            }

            $taxAmount = (int) round($subtotal * 0.10);
            $total = $subtotal + $taxAmount;

            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total' => $total,
                'payment_status' => PaymentStatus::Pending,
                'order_status' => OrderStatus::Pending,
            ]);

            foreach ($lineItems as $item) {
                $order->items()->create([
                    'menu_id' => $item['menu']->id,
                    'menu_name' => $item['menu_name'],
                    'unit_price' => $item['unit_price'],
                    'qty' => $item['qty'],
                    'line_total' => $item['line_total'],
                ]);

                $item['menu']->decrement('stock', $item['qty']);
            }

            $order->payment()->create([
                'method' => 'qris',
                'amount' => $total,
                'status' => PaymentStatus::Pending,
            ]);

            return $order;
        });

        $this->cartService->clear();

        return $order;
    }

    private function generateOrderNumber(): string
    {
        do {
            $number = 'KTG-'.str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
