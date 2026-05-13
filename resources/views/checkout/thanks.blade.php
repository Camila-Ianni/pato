@extends('layouts.app')

@section('title', 'Gracias por tu compra | LEGADO PATO')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-20">
        <div class="bg-[#F9F8F6] border border-stone-200 rounded-sm p-8 space-y-8">
            <div class="text-center">
                <h1 class="text-stone-800 text-3xl mb-3 font-serif">¡Gracias por tu compra!</h1>
                <p class="text-stone-600 text-sm">Pedido #{{ $order->id }} generado correctamente.</p>
            </div>

            <div class="border border-stone-200 rounded-sm bg-white p-5 space-y-3">
                <h2 class="text-stone-800 text-xl font-serif">Datos para Transferencia Bancaria</h2>
                <p class="text-stone-700 text-sm"><span class="font-semibold">CBU:</span> {{ $transferCbu }}</p>
                <p class="text-stone-700 text-sm"><span class="font-semibold">Alias:</span> {{ $transferAlias }}</p>
                <p class="text-stone-700 text-sm"><span class="font-semibold">Enviar comprobante a:</span> {{ $transferReceiptEmail }}</p>
                <p class="text-stone-500 text-sm">Cuando recibamos el comprobante, confirmaremos tu pago.</p>
            </div>

            <div class="space-y-3">
                @foreach ($order->items as $item)
                    <div class="border border-stone-200 rounded-sm bg-white p-4 flex items-start justify-between gap-4">
                        <div>
                            <p class="text-stone-800 text-base font-medium">{{ $item->product?->title ?? 'Producto' }}</p>
                            <p class="text-stone-500 text-sm">Cantidad: {{ $item->quantity }}</p>
                        </div>
                        <p class="text-stone-700 text-sm">$ {{ number_format((float) $item->total_price, 2, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>

            <div class="flex items-center justify-between pt-2">
                <span class="text-stone-600 uppercase tracking-wider text-xs">Total</span>
                <span class="text-stone-900 text-2xl font-serif">$ {{ number_format((float) $order->total, 2, ',', '.') }}</span>
            </div>

            <a href="{{ route('home') }}" class="block w-full mt-6 bg-stone-800 text-white py-4 tracking-widest uppercase text-sm hover:bg-stone-700 transition-colors font-semibold text-center">
                Volver al inicio
            </a>
        </div>
    </div>
@endsection
