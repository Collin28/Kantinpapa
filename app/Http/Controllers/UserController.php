<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $menus = Menu::query()
            ->with('category')
            ->where('is_available', true)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category'), fn ($query) => $query->where('category_id', $request->integer('category')))
            ->orderBy('name')
            ->get();

        $categories = Category::query()
            ->whereHas('menus', fn ($query) => $query->where('is_available', true))
            ->orderBy('name')
            ->get();

        return view('users.home', [
            'menus' => $menus,
            'categories' => $categories,
            'cartCount' => array_sum(session('cart', [])),
        ]);
    }

    public function addToCart(Menu $menu): RedirectResponse
    {
        abort_unless($menu->is_available, 404);

        $cart = session('cart', []);
        $cart[$menu->id] = min(($cart[$menu->id] ?? 0) + 1, 99);
        session(['cart' => $cart]);

        return back()->with('success', "{$menu->name} ditambahkan ke keranjang.");
    }

    public function cart(): View
    {
        $cart = session('cart', []);
        $menus = Menu::query()->whereIn('id', array_keys($cart))->get()->keyBy('id');
        $items = collect($cart)->map(function ($quantity, $menuId) use ($menus) {
            $menu = $menus->get($menuId);

            return $menu ? [
                'menu' => $menu,
                'quantity' => $quantity,
                'lineTotal' => (float) $menu->price * $quantity,
            ] : null;
        })->filter()->values();

        $subtotal = $items->sum('lineTotal');
        $tax = round($subtotal * 0.1, 2);

        return view('users.cart', [
            'items' => $items,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $subtotal + $tax,
            'cartCount' => array_sum($cart),
        ]);
    }

    public function updateCart(Request $request, Menu $menu): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cart = session('cart', []);
        abort_unless(isset($cart[$menu->id]), 404);

        $cart[$menu->id] = $validated['quantity'];
        session(['cart' => $cart]);

        return back()->with('success', 'Jumlah menu diperbarui.');
    }

    public function removeFromCart(Menu $menu): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$menu->id]);
        session(['cart' => $cart]);

        return back()->with('success', 'Menu dihapus dari keranjang.');
    }

    public function checkout(): RedirectResponse
    {
        $cart = session('cart', []);
        if ($cart === []) {
            return redirect()->route('users.cart')->withErrors([
                'cart' => 'Keranjang masih kosong.',
            ]);
        }

        $menus = Menu::query()->whereIn('id', array_keys($cart))->get()->keyBy('id');
        foreach ($cart as $menuId => $quantity) {
            $menu = $menus->get($menuId);
            if (!$menu || !$menu->is_available) {
                return redirect()->route('users.cart')->withErrors([
                    'cart' => 'Ada menu yang sudah tidak tersedia. Hapus menu tersebut sebelum checkout.',
                ]);
            }
        }

        $subtotal = collect($cart)->sum(fn ($quantity, $menuId) => (float) $menus->get($menuId)->price * $quantity);
        $tax = round($subtotal * 0.1, 2);

        $order = DB::transaction(function () use ($cart, $menus, $subtotal, $tax) {
            $order = Order::create([
                'order_number' => 'KP-' . Str::upper(Str::random(10)),
                'user_id' => auth()->id(),
                'session_id' => session()->getId(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $subtotal + $tax,
            ]);

            foreach ($cart as $menuId => $quantity) {
                $menu = $menus->get($menuId);
                $unitPrice = (float) $menu->price;
                $order->items()->create([
                    'menu_id' => $menu->id,
                    'menu_name' => $menu->name,
                    'unit_price' => $unitPrice,
                    'quantity' => $quantity,
                    'line_total' => $unitPrice * $quantity,
                ]);
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('users.orders.confirmation', $order)
            ->with('success', 'Pesanan berhasil dicatat.');
    }

    public function orderHistory(): View
    {
        $orders = Order::query()
            ->with('items')
            ->when(
                auth()->check(),
                fn ($query) => $query->where('user_id', auth()->id()),
                fn ($query) => $query->where('session_id', session()->getId())
            )
            ->latest()
            ->get();

        return view('users.orderHistory', compact('orders'));
    }

    public function payConfirm(Order $order): View
    {
        $this->ensureOrderBelongsToCurrentVisitor($order);

        return view('users.payconfirm', compact('order'));
    }

    private function ensureOrderBelongsToCurrentVisitor(Order $order): void
    {
        $belongsToCurrentVisitor = auth()->check()
            ? $order->user_id === auth()->id()
            : $order->session_id === session()->getId();

        abort_unless($belongsToCurrentVisitor, 404);
    }
}
