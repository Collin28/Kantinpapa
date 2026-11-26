<div class="space-y-5">
    <div>
        <label for="category_id" class="block text-sm font-medium text-neutral-800 mb-1.5">Category</label>
        <select id="category_id" name="category_id" required
            class="w-full border border-neutral-300 rounded-lg px-3.5 py-2.5 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-red-500">
            <option value="">Select category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $menu->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="name" class="block text-sm font-medium text-neutral-800 mb-1.5">Menu Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $menu->name ?? '') }}" required
            class="w-full border border-neutral-300 rounded-lg px-3.5 py-2.5 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-red-500">
        @error('name')
            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-neutral-800 mb-1.5">Description</label>
        <textarea id="description" name="description" rows="3"
            class="w-full border border-neutral-300 rounded-lg px-3.5 py-2.5 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-red-500">{{ old('description', $menu->description ?? '') }}</textarea>
        @error('description')
            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="price" class="block text-sm font-medium text-neutral-800 mb-1.5">Price (Rp)</label>
            <input type="number" id="price" name="price" min="0" step="100" value="{{ old('price', isset($menu) ? (int) $menu->price : '') }}" required
                class="w-full border border-neutral-300 rounded-lg px-3.5 py-2.5 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-red-500">
            @error('price')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="stock" class="block text-sm font-medium text-neutral-800 mb-1.5">Stock</label>
            <input type="number" id="stock" name="stock" min="0" value="{{ old('stock', $menu->stock ?? 0) }}" required
                class="w-full border border-neutral-300 rounded-lg px-3.5 py-2.5 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-red-500">
            @error('stock')
                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div>
        <label for="image" class="block text-sm font-medium text-neutral-800 mb-1.5">Upload Image</label>
        <input type="file" id="image" name="image" accept="image/*"
            class="w-full border border-neutral-300 rounded-lg px-3.5 py-2 text-sm text-neutral-700">
        @error('image')
            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="img_url" class="block text-sm font-medium text-neutral-800 mb-1.5">Or Image URL (optional)</label>
        <input type="url" id="img_url" name="img_url" value="{{ old('img_url', isset($menu) && str_starts_with((string) $menu->img_url, 'http') ? $menu->img_url : '') }}"
            placeholder="https://..."
            class="w-full border border-neutral-300 rounded-lg px-3.5 py-2.5 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-red-500">
        @error('img_url')
            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex items-center gap-2">
        <input type="hidden" name="is_available" value="0">
        <input type="checkbox" id="is_available" name="is_available" value="1"
            @checked(old('is_available', $menu->is_available ?? true))
            class="rounded border-neutral-300 text-red-600 focus:ring-red-500">
        <label for="is_available" class="text-sm font-medium text-neutral-700">Available for order</label>
    </div>
</div>
