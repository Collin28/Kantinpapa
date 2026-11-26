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
            ->get();

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

        foreach ($order->items as $item) {
            if ($item->menu && ! $item->menu->isSoldOut()) {
                $cart->add($item->menu, $item->qty);
                $added++;
            }
        }

        if ($added === 0) {
            return redirect()
                ->route('orders.index')
                ->with('error', 'None of the items from this order are currently available.');
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Items from your previous order have been added to your cart.');
    }
}
