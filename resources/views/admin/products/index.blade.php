@extends('layouts.app')

@section('title', 'Admin Productos | LEGADO PATO')

@section('content')
    <section class="py-14 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto" data-fade-in>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <h1 class="text-headline-lg font-headline-lg text-primary">Productos</h1>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.orders.index') }}" class="text-label-caps font-label-caps text-on-surface-variant hover:text-primary">Pedidos</a>
                <a href="{{ route('admin.products.create') }}" class="bg-primary text-on-primary py-3 px-5 font-label-caps text-label-caps tracking-[0.12em] uppercase hover:bg-primary-container">Nuevo</a>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-5 border border-primary/15 bg-surface-container-low px-4 py-3 text-body-md font-body-md text-primary">{{ session('status') }}</div>
        @endif

        <div class="bg-surface-container-low border border-primary/10 overflow-x-auto">
            <table class="w-full min-w-[900px]">
                <thead>
                    <tr class="border-b border-primary/10 text-left">
                        <th class="px-4 py-3 text-label-caps font-label-caps text-on-surface-variant">Producto</th>
                        <th class="px-4 py-3 text-label-caps font-label-caps text-on-surface-variant">Categorías</th>
                        <th class="px-4 py-3 text-label-caps font-label-caps text-on-surface-variant">Precio</th>
                        <th class="px-4 py-3 text-label-caps font-label-caps text-on-surface-variant">Stock</th>
                        <th class="px-4 py-3 text-label-caps font-label-caps text-on-surface-variant">Activo</th>
                        <th class="px-4 py-3 text-label-caps font-label-caps text-on-surface-variant">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="border-b border-primary/10">
                            <td class="px-4 py-4 text-body-md font-body-md text-on-surface">{{ $product->title }}</td>
                            <td class="px-4 py-4 text-body-md font-body-md text-on-surface-variant">{{ $product->categories->pluck('name')->join(', ') ?: '-' }}</td>
                            <td class="px-4 py-4 text-body-md font-body-md text-secondary">$ {{ number_format((float) $product->price, 2, ',', '.') }}</td>
                            <td class="px-4 py-4 text-body-md font-body-md text-on-surface">{{ $product->stock }}</td>
                            <td class="px-4 py-4 text-body-md font-body-md text-on-surface-variant">{{ $product->is_active ? 'Sí' : 'No' }}</td>
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-label-caps font-label-caps text-primary hover:text-secondary">Editar</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-label-caps font-label-caps text-on-surface-variant hover:text-error">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-body-md font-body-md text-on-surface-variant">No hay productos cargados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </section>
@endsection
