<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMenuRequest;
use App\Http\Requests\Admin\UpdateMenuRequest;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $selectedCategory = trim((string) $request->query('category', ''));

        $categories = Category::orderBy('id')->get();

        $menus = Menu::with('category')
            ->when($search !== '', fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($selectedCategory !== '', function ($q) use ($selectedCategory) {
                $q->whereHas('category', fn ($sub) => $sub->where('slug', $selectedCategory));
            })
            ->orderBy('id')
            ->get();

        $totalCount = Menu::count();
        $availableCount = Menu::where('is_available', true)->where('stock', '>', 0)->count();

        return view('admin.menuManagement', [
            'menus' => $menus,
            'categories' => $categories,
            'totalCount' => $totalCount,
            'availableCount' => $availableCount,
            'search' => $search,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function create(): View
    {
        return view('admin.menus.create', [
            'categories' => Category::orderBy('id')->get(),
        ]);
    }

    public function store(StoreMenuRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['image']);
        $data['is_available'] = $request->boolean('is_available', true);

        if ($request->hasFile('image')) {
            $data['img_url'] = $request->file('image')->store('menus', 'public');
        }

        Menu::create($data);

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu item created successfully.');
    }

    public function edit(Menu $menu): View
    {
        return view('admin.menus.edit', [
            'menu' => $menu,
            'categories' => Category::orderBy('id')->get(),
        ]);
    }

    public function update(UpdateMenuRequest $request, Menu $menu): RedirectResponse
    {
        $data = $request->safe()->except(['image']);
        $data['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('image')) {
            if ($menu->img_url && ! str_starts_with($menu->img_url, 'http')) {
                Storage::disk('public')->delete($menu->img_url);
            }
            $data['img_url'] = $request->file('image')->store('menus', 'public');
        } elseif (empty($data['img_url'])) {
            unset($data['img_url']);
        }

        $menu->update($data);

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu item updated successfully.');
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        $menu->delete();

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu item deleted.');
    }

    public function toggle(Menu $menu): RedirectResponse
    {
        $menu->update([
            'is_available' => ! $menu->is_available,
        ]);

        return back()->with('success', 'Menu availability updated.');
    }
}
