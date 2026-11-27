<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()
            ->orders()
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('users.order-history', [
            'orders' => $orders,
        ]);
    }

    public function confirmed(Request $request, Order $order): View
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        return view('users.payconfirm', [
            'order' => $order,
        ]);
    }

    public function reorder(Request $request, Order $order, CartService $cart): RedirectResponse
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        $order->load('items.menu');
        $added = 0;
        $adjusted = [];
        $skipped = [];

        foreach ($order->items as $item) {
            if (! $item->menu || $item->menu->isSoldOut()) {
                $skipped[] = $item->menu_name;

                continue;
            }

            $currentQty = $cart->raw()[$item->menu->id] ?? 0;
            if ($currentQty >= $item->menu->stock) {
                $skipped[] = $item->menu_name;

                continue;
            }

            if ($currentQty + $item->qty > $item->menu->stock) {
                $adjusted[] = "{$item->menu->name} (max {$item->menu->stock})";
            }

            $cart->add($item->menu, $item->qty);
            $added++;
        }

        if ($added === 0) {
            return redirect()
                ->route('orders.index')
                ->with('error', 'None of the items from this order are currently available.');
        }

        $redirect = redirect()
            ->route('cart.index')
            ->with('success', "Added {$added} item(s) from your previous order to your cart.");

        $notes = [];
        if (! empty($adjusted)) {
            $notes[] = 'Quantity adjusted to available stock: '.implode(', ', $adjusted).'.';
        }
        if (! empty($skipped)) {
            $notes[] = 'Skipped unavailable items: '.implode(', ', $skipped).'.';
        }

        if (! empty($notes)) {
            $redirect->with('warning', implode(' ', $notes));
        }

        return $redirect;
    }
}
