@csrf
@isset($product)
    @method('PUT')
@endisset

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div class="md:col-span-2">
        <label class="block text-label-caps font-label-caps text-on-surface-variant mb-2">Título</label>
        <input type="text" name="title" value="{{ old('title', $product->title ?? '') }}" required class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none">
    </div>

    <div>
        <label class="block text-label-caps font-label-caps text-on-surface-variant mb-2">Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $product->slug ?? '') }}" class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none">
    </div>

    <div>
        <label class="block text-label-caps font-label-caps text-on-surface-variant mb-2">Precio (ARS)</label>
        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', isset($product) ? (float) $product->price : '') }}" required class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none">
    </div>

    <div>
        <label class="block text-label-caps font-label-caps text-on-surface-variant mb-2">Stock</label>
        <input type="number" min="0" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none">
    </div>

    <div>
        <label class="block text-label-caps font-label-caps text-on-surface-variant mb-2">Imagen</label>
        <input type="file" name="image" accept="image/*" class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none">
    </div>

    <div class="md:col-span-2">
        <label class="block text-label-caps font-label-caps text-on-surface-variant mb-2">Descripción</label>
        <textarea name="description" rows="5" class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block text-label-caps font-label-caps text-on-surface-variant mb-2">Categorías</label>
        <div class="flex flex-wrap gap-4">
            @foreach ($categories as $category)
                <label class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        name="category_ids[]"
                        value="{{ $category->id }}"
                        @checked(in_array($category->id, old('category_ids', isset($product) ? $product->categories->pluck('id')->all() : []), true))
                    >
                    <span class="text-body-md font-body-md text-on-surface">{{ $category->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="md:col-span-2">
        <label class="flex items-center gap-3">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', isset($product) ? (bool) $product->is_active : true))>
            <span class="text-body-md font-body-md text-on-surface">Producto activo</span>
        </label>
    </div>
</div>
