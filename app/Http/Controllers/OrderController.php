<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // Tampilkan halaman keranjang
    public function cart()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return view('users.cardempty');
        }
        return view('users.cart', compact('cart'));
    }

    // Proses buat pesanan baru (Checkout)
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $cart = session()->get('cart', []);
            if (empty($cart)) {
                return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
            }

            $totalPrice = 0;
            foreach ($cart as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }

            $order = Order::create([
                'user_id' => Auth::id() ?? 1,
                'order_code' => 'INV-' . strtoupper(Str::random(8)),
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('orders.payconfirm', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }

    // Tampilkan halaman konfirmasi pembayaran
    public function showPayConfirm($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('users.payconfirm', compact('order'));
    }
}