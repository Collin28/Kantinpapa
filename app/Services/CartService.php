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
        return (int) $this->items()->sum('qty');
    }

    /**
     * Sanitize cart entries against current DB availability and stock.
     *
     * @return array<int, string>
     */
    public function sanitize(): array
    {
        $raw = $this->raw();

        if (empty($raw)) {
            return [];
        }

        $menus = Menu::withTrashed()
            ->whereIn('id', array_keys($raw))
            ->get()
            ->keyBy('id');

        $sanitized = [];
        $warnings = [];

        foreach ($raw as $menuId => $qty) {
            $menu = $menus->get($menuId);
            $qty = (int) $qty;

            if (! $menu || $menu->trashed() || $menu->isSoldOut()) {
                $name = $menu?->name ?? 'An item';
                $warnings[] = "{$name} was removed because it is no longer available.";

                continue;
            }

            if ($qty <= 0) {
                continue;
            }

            if ($qty > $menu->stock) {
                $sanitized[$menuId] = $menu->stock;
                $warnings[] = "Quantity for {$menu->name} was adjusted to {$menu->stock} due to limited stock.";

                continue;
            }

            $sanitized[$menuId] = $qty;
        }

        if ($sanitized !== $raw) {
            if (empty($sanitized)) {
                session()->forget(self::SESSION_KEY);
            } else {
                session()->put(self::SESSION_KEY, $sanitized);
            }
        }

        return $warnings;
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
            if (! $menu || $menu->isSoldOut()) {
                continue;
            }

            $effectiveQty = min((int) $qty, $menu->stock);
            if ($effectiveQty <= 0) {
                continue;
            }

            $unitPrice = (int) round((float) $menu->price);
            $items->push([
                'menu' => $menu,
                'qty' => $effectiveQty,
                'unit_price' => $unitPrice,
                'line_total' => $unitPrice * $effectiveQty,
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
