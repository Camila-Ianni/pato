@extends('layouts.app')

@section('title', 'Pedido #' . $order->id . ' | Admin')

@section('content')
    <section class="py-14 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto" data-fade-in>
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-headline-lg font-headline-lg text-primary">Pedido #{{ $order->id }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="text-label-caps font-label-caps text-on-surface-variant hover:text-primary">Volver</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-surface-container-low border border-primary/10 p-5">
                <p class="text-label-caps font-label-caps text-on-surface-variant">Cliente</p>
                <p class="text-body-md font-body-md text-on-surface mt-2">{{ $order->user?->name ?? 'Sin usuario' }}</p>
                <p class="text-body-md font-body-md text-on-surface-variant">{{ $order->user?->email }}</p>
                <p class="text-body-md font-body-md text-on-surface-variant mt-1">Contacto checkout: {{ $order->customer_email ?? '-' }} / {{ $order->customer_phone ?? '-' }}</p>
            </div>
            <div class="bg-surface-container-low border border-primary/10 p-5">
                <p class="text-label-caps font-label-caps text-on-surface-variant">Estado</p>
                <p class="text-body-md font-body-md text-on-surface mt-2">{{ ucfirst($order->status) }}</p>
                <p class="text-body-md font-body-md text-on-surface-variant">{{ strtoupper($order->payment_provider ?? 'N/A') }}</p>
            </div>
            <div class="bg-surface-container-low border border-primary/10 p-5">
                <p class="text-label-caps font-label-caps text-on-surface-variant">Total</p>
                <p class="text-headline-md font-headline-md text-secondary mt-2">$ {{ number_format((float) $order->total, 2, ',', '.') }}</p>
                <p class="text-body-md font-body-md text-on-surface-variant">Moneda: {{ $order->currency }}</p>
            </div>
        </div>

        <div class="bg-surface-container-low border border-primary/10 overflow-x-auto">
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
    </section>
@endsection
