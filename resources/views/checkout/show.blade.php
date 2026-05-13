@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-20">
    <h1 class="text-stone-800 text-3xl mb-8 text-center font-serif">Resumen de Compra</h1>

    <div class="bg-[#F9F8F6] border border-stone-200 rounded-sm p-8 mb-8">
        <h2 class="text-stone-800 text-xl mb-6 font-serif">Tu Pedido</h2>

        <div class="space-y-4 mb-8">
            @foreach($order->items as $item)
            <div class="flex items-center border border-stone-200 p-4 bg-white">
                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->title }}" class="w-16 h-16 object-cover mr-4">
                <div class="flex-1">
                    <h3 class="text-stone-800 font-semibold">{{ $item->product->title }}</h3>
                    <p class="text-stone-500 text-sm">Cant: {{ $item->quantity }}</p>
                </div>
                <div class="text-stone-800 font-semibold">${{ number_format($item->total_price, 2, ',', '.') }}</div>
            </div>
            @endforeach
        </div>

        <div class="flex justify-between items-center border-t border-stone-200 pt-6 mb-8">
            <span class="text-stone-800 text-lg">Total</span>
            <span class="text-stone-800 text-2xl font-semibold">${{ number_format($order->total, 2, ',', '.') }}</span>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <h2 class="text-stone-800 text-xl mb-4 font-serif">Método de Pago</h2>

            <div class="space-y-4 mb-8">
                <label class="flex items-center p-4 border border-stone-200 cursor-pointer hover:bg-stone-50 transition-colors bg-white">
                    <input type="radio" name="payment_method" value="mercadopago" required class="text-stone-800 w-5 h-5">
                    <span class="ml-3 text-stone-800 font-medium">Mercado Pago</span>
                </label>
                <label class="flex items-center p-4 border border-stone-200 cursor-pointer hover:bg-stone-50 transition-colors bg-white">
                    <input type="radio" name="payment_method" value="transferencia" required class="text-stone-800 w-5 h-5">
                    <span class="ml-3 text-stone-800 font-medium">Transferencia Bancaria</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-stone-800 text-white py-4 tracking-widest uppercase text-sm hover:bg-stone-700 transition-colors font-semibold">
                Pagar y Continuar
            </button>
        </form>
    </div>
</div>
@endsection
