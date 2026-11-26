<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $selectedCategory = trim((string) $request->query('category', ''));

        $categories = Category::orderBy('id')->get();

        $popularMenus = Menu::with('category')
            ->where('is_available', true)
            ->where('stock', '>', 0)
            ->latest('id')
            ->take(4)
            ->get();

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
}
