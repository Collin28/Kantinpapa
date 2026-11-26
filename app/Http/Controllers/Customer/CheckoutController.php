<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function review(CartService $cart): View|RedirectResponse
    {
        $items = $cart->items();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index');
        }

        return view('users.checkout-review', [
            'items' => $items,
            'totals' => $cart->totals(),
        ]);
    }

    public function payment(CartService $cart): View|RedirectResponse
    {
        $items = $cart->items();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index');
        }

        return view('users.checkout-payment', [
            'items' => $items,
            'totals' => $cart->totals(),
        ]);
    }

    public function store(Request $request, CheckoutService $checkout): RedirectResponse
    {
        $order = $checkout->placeOrder($request->user());

        return redirect()->route('orders.confirmed', $order);
    }
}
