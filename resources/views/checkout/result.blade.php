@extends('layouts.app')

@section('title', 'Resultado de pago | LEGADO PATO')

@section('content')
    <section class="py-16 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto" data-fade-in>
        <div class="max-w-3xl mx-auto bg-surface-container-low border border-primary/10 p-7 md:p-10">
            <h1 class="text-headline-lg font-headline-lg text-primary mb-3">Compra confirmada</h1>
            <p class="text-body-md font-body-md text-on-surface-variant mb-8">
                Pedido #{{ $order->id }} - Estado:
                <span class="text-primary">{{ strtoupper($order->status) }}</span>
            </p>

            @if (!empty($isTransfer))
                <div class="mb-8 border border-primary/15 bg-surface px-5 py-4 space-y-2">
                    <p class="text-body-md font-body-md text-on-surface">Elegiste <strong>transferencia</strong>.</p>
                    <p class="text-body-md font-body-md text-on-surface">Alias para transferir: <strong>{{ $transferAlias }}</strong></p>
                    <p class="text-body-md font-body-md text-on-surface">Enviar comprobante a: <strong>{{ $transferReceiptEmail }}</strong></p>
                </div>
            @endif

            <div class="space-y-4">
                @foreach ($order->items as $item)
                    <div class="flex items-start justify-between gap-3 border-b border-primary/10 pb-3">
                        <div>
                            <p class="text-body-md font-body-md text-on-surface">{{ $item->product?->title ?? 'Producto' }}</p>
                            <p class="text-label-caps font-label-caps text-on-surface-variant">x{{ $item->quantity }}</p>
                        </div>
                        <p class="text-body-md font-body-md text-secondary">$ {{ number_format((float) $item->total_price, 2, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 pt-6 border-t border-primary/10 flex items-end justify-between">
                <span class="text-body-md font-body-md text-on-surface-variant">Total</span>
                <span class="text-headline-md font-headline-md text-primary">$ {{ number_format((float) $order->total, 2, ',', '.') }}</span>
            </div>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('catalog.index') }}" class="bg-primary text-on-primary py-3 px-6 font-label-caps text-label-caps tracking-[0.12em] uppercase hover:bg-primary-container transition-all">
                    Seguir comprando
                </a>
                <a href="{{ route('home') }}" class="text-label-caps font-label-caps text-on-surface-variant hover:text-primary py-3 px-2">
                    Volver al inicio
                </a>
            </div>
        </div>
    </section>
@endsection
