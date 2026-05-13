@extends('layouts.app')

@section('title', 'Pedido #' . $order->id . ' | Admin')

@section('content')
    <section class="py-14 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto" data-fade-in>
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-headline-lg font-headline-lg text-primary">Pedido #{{ $order->id }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="text-label-caps font-label-caps text-on-surface-variant hover:text-primary transition-colors">Volver</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-surface-container-low border border-primary/10 p-5">
                <p class="text-label-caps font-label-caps text-on-surface-variant">Cliente</p>
                <p class="text-body-md font-body-md text-on-surface mt-2">{{ $order->user?->name ?? 'Sin usuario' }}</p>
                <p class="text-body-md font-body-md text-on-surface-variant">{{ $order->user?->email }}</p>
                <p class="text-body-md font-body-md text-on-surface-variant mt-1">Contacto: {{ $order->customer_email ?? '-' }} / {{ $order->customer_phone ?? '-' }}</p>
            </div>
            <div class="bg-surface-container-low border border-primary/10 p-5">
                <p class="text-label-caps font-label-caps text-on-surface-variant">Estado y Pago</p>
                <p class="text-body-md font-body-md text-on-surface mt-2 uppercase">{{ $order->status }}</p>
                <p class="text-body-md font-body-md text-on-surface-variant uppercase">{{ $order->payment_provider ?? 'N/A' }}</p>
            </div>
            <div class="bg-surface-container-low border border-primary/10 p-5">
                <p class="text-label-caps font-label-caps text-on-surface-variant">Total</p>
                <p class="text-headline-md font-headline-md text-secondary mt-2">$ {{ number_format((float) $order->total, 2, ',', '.') }}</p>
                <p class="text-body-md font-body-md text-on-surface-variant">Moneda: {{ $order->currency }}</p>
            </div>
        </div>

        <div class="bg-surface-container-low border border-primary/10 overflow-x-auto mb-8">
            <table class="w-full min-w-[760px]">
                <thead>
                    <tr class="border-b border-primary/10 text-left">
                        <th class="px-4 py-3 text-label-caps font-label-caps text-on-surface-variant">Producto</th>
                        <th class="px-4 py-3 text-label-caps font-label-caps text-on-surface-variant">Cantidad</th>
                        <th class="px-4 py-3 text-label-caps font-label-caps text-on-surface-variant">Unitario</th>
                        <th class="px-4 py-3 text-label-caps font-label-caps text-on-surface-variant">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr class="border-b border-primary/10">
                            <td class="px-4 py-4 text-body-md font-body-md text-on-surface">{{ $item->product?->title ?? 'Producto eliminado' }}</td>
                            <td class="px-4 py-4 text-body-md font-body-md text-on-surface">{{ $item->quantity }}</td>
                            <td class="px-4 py-4 text-body-md font-body-md text-on-surface">$ {{ number_format((float) $item->unit_price, 2, ',', '.') }}</td>
                            <td class="px-4 py-4 text-body-md font-body-md text-secondary">$ {{ number_format((float) $item->total_price, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-surface-container-low border border-primary/10 p-8">
            <h3 class="text-label-caps font-label-caps text-primary mb-6 tracking-widest">Actualizar Estado del Pedido</h3>
            
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex flex-wrap items-center gap-6">
                @csrf
                @method('PATCH')
                
                <div class="flex flex-col gap-2">
                    <select name="status" class="bg-surface border border-primary/20 p-3 rounded-sm text-on-surface focus:outline-none focus:border-primary transition-colors min-w-[200px]">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>En Proceso</option>
                        <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Pagado</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Enviado</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completado</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                
                <button type="submit" class="bg-primary text-secondary-fixed px-8 py-3 uppercase tracking-[0.2em] text-sm font-semibold hover:opacity-90 transition-all active:scale-95 cursor-pointer rounded-sm shadow-sm">
                    Guardar Cambios
                </button>
            </form>
            
            @if(session('success'))
                <p class="mt-4 text-secondary font-body-sm italic">{{ session('success') }}</p>
            @endif
        </div>
    </section>
@endsection
