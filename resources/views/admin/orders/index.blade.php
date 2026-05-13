@extends('layouts.app')

@section('title', 'Admin Pedidos | LEGADO PATO')

@section('content')
    <section class="py-14 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto" data-fade-in>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <h1 class="text-headline-lg font-headline-lg text-primary">Pedidos</h1>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.products.index') }}" class="text-label-caps font-label-caps text-on-surface-variant hover:text-primary">Productos</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-label-caps font-label-caps text-on-surface-variant hover:text-primary">Salir</button>
                </form>
            </div>
        </div>

        <form method="GET" class="mb-6 max-w-xs">
            <label for="status" class="block text-label-caps font-label-caps text-on-surface-variant mb-2">Filtrar por estado</label>
            <select id="status" name="status" onchange="this.form.submit()" class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none">
                <option value="">Todos</option>
                @foreach ($availableStatuses as $status)
                    <option value="{{ $status }}" @selected($selectedStatus === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </form>

        <div class="bg-surface-container-low border border-primary/10 overflow-x-auto">
            <table class="w-full min-w-[760px]">
                <thead>
                    <tr class="border-b border-primary/10 text-left">
                        <th class="px-4 py-3 text-label-caps font-label-caps text-on-surface-variant">ID</th>
                        <th class="px-4 py-3 text-label-caps font-label-caps text-on-surface-variant">Cliente</th>
                        <th class="px-4 py-3 text-label-caps font-label-caps text-on-surface-variant">Estado</th>
                        <th class="px-4 py-3 text-label-caps font-label-caps text-on-surface-variant">Items</th>
                        <th class="px-4 py-3 text-label-caps font-label-caps text-on-surface-variant">Total</th>
                        <th class="px-4 py-3 text-label-caps font-label-caps text-on-surface-variant">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr class="border-b border-primary/10">
                            <td class="px-4 py-4 text-body-md font-body-md text-on-surface">#{{ $order->id }}</td>
                            <td class="px-4 py-4 text-body-md font-body-md text-on-surface">{{ $order->user?->name ?? 'Sin usuario' }}</td>
                            <td class="px-4 py-4 text-body-md font-body-md text-on-surface-variant">{{ ucfirst($order->status) }}</td>
                            <td class="px-4 py-4 text-body-md font-body-md text-on-surface">{{ $order->items_count }}</td>
                            <td class="px-4 py-4 text-body-md font-body-md text-secondary">$ {{ number_format((float) $order->total, 2, ',', '.') }}</td>
                            <td class="px-4 py-4">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-label-caps font-label-caps text-primary hover:text-secondary">Ver detalle</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-body-md font-body-md text-on-surface-variant">No hay pedidos para mostrar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </section>
@endsection
