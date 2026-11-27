<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function review(CartService $cart): View|RedirectResponse
    {
        $warnings = $cart->sanitize();
        $items = $cart->items();

        if ($items->isEmpty()) {
            $redirect = redirect()->route('cart.index');

            return ! empty($warnings)
                ? $redirect->with('warning', implode(' ', $warnings))
                : $redirect;
        }

        return view('users.checkout-review', [
            'items' => $items,
            'totals' => $cart->totals(),
            'warnings' => $warnings,
        ]);
    }

    public function payment(Request $request, CartService $cart): View|RedirectResponse
    {
        $warnings = $cart->sanitize();
        $items = $cart->items();

        if ($items->isEmpty()) {
            $redirect = redirect()->route('cart.index');

            return ! empty($warnings)
                ? $redirect->with('warning', implode(' ', $warnings))
                : $redirect;
        }

        $checkoutToken = Str::random(40);
        $request->session()->put('checkout_token', $checkoutToken);

        return view('users.checkout-payment', [
            'items' => $items,
            'totals' => $cart->totals(),
            'warnings' => $warnings,
            'checkoutToken' => $checkoutToken,
        ]);
    }

    public function store(Request $request, CheckoutService $checkout): RedirectResponse
    {
        $sessionToken = (string) $request->session()->pull('checkout_token', '');
        $submittedToken = (string) $request->input('checkout_token', '');

        if ($sessionToken === '' || ! hash_equals($sessionToken, $submittedToken)) {
            return redirect()
                ->route('orders.index')
                ->with('error', 'Checkout session expired or already submitted.');
        }

        $order = $checkout->placeOrder($request->user());

        return redirect()->route('orders.confirmed', $order);
    }
}
