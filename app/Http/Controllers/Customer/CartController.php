<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(CartService $cart): View
    {
        $items = $cart->items();

        if ($items->isEmpty()) {
            return view('users.cart-empty');
        }

        return view('users.cart', [
            'items' => $items,
            'totals' => $cart->totals(),
        ]);
    }

    public function store(Request $request, Menu $menu, CartService $cart): RedirectResponse
    {
        if ($menu->isSoldOut()) {
            return back()->with('error', "{$menu->name} is currently sold out.");
        }

        $validated = $request->validate([
            'qty' => ['sometimes', 'integer', 'min:1'],
        ]);

        $cart->add($menu, $validated['qty'] ?? 1);

        return back()->with('success', "{$menu->name} added to cart.");
    }

    public function update(Request $request, Menu $menu, CartService $cart): RedirectResponse
    {
        $validated = $request->validate([
            'qty' => ['required', 'integer', 'min:0'],
        ]);

        $cart->update($menu, (int) $validated['qty']);

        return redirect()->route('cart.index');
    }

    public function destroy(Menu $menu, CartService $cart): RedirectResponse
    {
        $cart->remove($menu->id);

        return redirect()->route('cart.index');
    }
}
