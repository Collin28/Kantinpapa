<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Collection;

class CartService
{
    private const SESSION_KEY = 'cart';

    /**
     * @return array<int, int>
     */
    public function raw(): array
    {
        return session()->get(self::SESSION_KEY, []);
    }

    public function add(Menu $menu, int $qty = 1): void
    {
        if ($menu->isSoldOut() || $qty <= 0) {
            return;
        }

        $cart = $this->raw();
        $currentQty = $cart[$menu->id] ?? 0;
        $cart[$menu->id] = min($currentQty + $qty, $menu->stock);

        session()->put(self::SESSION_KEY, $cart);
    }

    public function update(Menu $menu, int $qty): void
    {
        $cart = $this->raw();

        if ($qty <= 0 || $menu->isSoldOut()) {
            unset($cart[$menu->id]);
        } else {
            $cart[$menu->id] = min($qty, $menu->stock);
        }

        session()->put(self::SESSION_KEY, $cart);
    }

    public function remove(int $menuId): void
    {
        $cart = $this->raw();
        unset($cart[$menuId]);
        session()->put(self::SESSION_KEY, $cart);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function count(): int
    {
        return array_sum($this->raw());
    }

    /**
     * @return Collection<int, array{menu: Menu, qty: int, unit_price: int, line_total: int}>
     */
    public function items(): Collection
    {
        $raw = $this->raw();

        if (empty($raw)) {
            return collect();
        }

        $menus = Menu::with('category')
            ->whereIn('id', array_keys($raw))
            ->get()
            ->keyBy('id');

        $items = collect();

        foreach ($raw as $menuId => $qty) {
            $menu = $menus->get($menuId);
            if (! $menu) {
                continue;
            }

            $unitPrice = (int) round((float) $menu->price);
            $items->push([
                'menu' => $menu,
                'qty' => (int) $qty,
                'unit_price' => $unitPrice,
                'line_total' => $unitPrice * (int) $qty,
            ]);
        }

        return $items;
    }

    /**
     * @return array{count: int, subtotal: int, tax_amount: int, total: int}
     */
    public function totals(): array
    {
        $items = $this->items();
        $subtotal = $items->sum('line_total');
        $taxAmount = (int) round($subtotal * 0.10);

        return [
            'count' => $items->sum('qty'),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $subtotal + $taxAmount,
        ];
    }
}
