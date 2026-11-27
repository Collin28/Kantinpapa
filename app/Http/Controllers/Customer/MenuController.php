<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $selectedCategory = trim((string) $request->query('category', ''));

        $categories = Category::orderBy('id')->get();

        $popularMenus = $this->popularMenusToday();

        $menus = Menu::with('category')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($selectedCategory !== '', function ($query) use ($selectedCategory) {
                $query->whereHas('category', fn ($q) => $q->where('slug', $selectedCategory));
            })
            ->orderByDesc('is_available')
            ->orderBy('id')
            ->get();

        return view('users.home', [
            'categories' => $categories,
            'popularMenus' => $popularMenus,
            'menus' => $menus,
            'search' => $search,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    private function popularMenusToday()
    {
        $now = now('Asia/Jakarta');
        $todayStart = $now->copy()->startOfDay();
        $todayEnd = $now->copy()->endOfDay();

        $topMenuIds = OrderItem::query()
            ->selectRaw('order_items.menu_id, SUM(order_items.qty) as total_ordered')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('menus', 'menus.id', '=', 'order_items.menu_id')
            ->whereNull('menus.deleted_at')
            ->where('menus.is_available', true)
            ->where('menus.stock', '>', 0)
            ->where('orders.order_status', '!=', OrderStatus::Cancelled->value)
            ->whereBetween('orders.created_at', [$todayStart, $todayEnd])
            ->groupBy('order_items.menu_id')
            ->orderByDesc('total_ordered')
            ->limit(4)
            ->pluck('order_items.menu_id')
            ->all();

        $popular = collect();
        if (! empty($topMenuIds)) {
            $byId = Menu::with('category')->whereIn('id', $topMenuIds)->get()->keyBy('id');
            foreach ($topMenuIds as $id) {
                if ($byId->has($id)) {
                    $popular->push($byId->get($id));
                }
            }
        }

        if ($popular->count() < 4) {
            $fallback = Menu::with('category')
                ->where('is_available', true)
                ->where('stock', '>', 0)
                ->when($popular->isNotEmpty(), fn ($q) => $q->whereNotIn('id', $popular->pluck('id')->all()))
                ->latest('id')
                ->take(4 - $popular->count())
                ->get();

            $popular = $popular->concat($fallback);
        }

        return $popular;
    }
}
