@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-20">
    <h1 class="text-stone-800 text-3xl mb-8 text-center font-serif">Resumen de tu Pedido</h1>
    <div class="bg-[#F9F8F6] border border-stone-200 p-8 shadow-sm">
        <div class="space-y-4 mb-8">
            @foreach($order->items as $item)
            <div class="flex items-center border border-stone-200 p-4 bg-white">
                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-20 h-20 object-cover mr-4">
                <div class="flex-1">
                    <h3 class="text-stone-800 font-semibold">{{ $item->product->title }}</h3>
                    <p class="text-stone-500 text-sm">Cantidad: {{ $item->quantity }}</p>
                </div>
                <div class="text-stone-800 font-bold">${{ number_format($item->total_price, 2, ',', '.') }}</div>
            </div>
            @endforeach
        </div>
        <div class="flex justify-between items-center border-t border-stone-300 pt-6 mb-8">
            <span class="text-stone-800 text-lg uppercase tracking-widest">Total Final</span>
            <span class="text-stone-800 text-2xl font-bold">${{ number_format($order->total, 2, ',', '.') }}</span>
        </div>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <h2 class="text-stone-800 text-lg mb-4 font-serif">Seleccioná tu método de pago:</h2>
            <div class="space-y-3 mb-8">
                <label class="flex items-center p-4 border border-stone-200 cursor-pointer hover:bg-stone-50 bg-white">
                    <input type="radio" name="payment_method" value="mercadopago" required class="text-stone-800">
                    <span class="ml-3 text-stone-800 font-medium">Mercado Pago</span>
                </label>
                <label class="flex items-center p-4 border border-stone-200 cursor-pointer hover:bg-stone-50 bg-white">
                    <input type="radio" name="payment_method" value="transferencia" required class="text-stone-800">
                    <span class="ml-3 text-stone-800 font-medium">Transferencia Bancaria (CBU/Alias)</span>
                </label>
            </div>
            <button type="submit" class="w-full bg-stone-800 text-white py-4 tracking-widest uppercase text-sm hover:bg-black transition-all font-bold">
                CONFIRMAR Y PAGAR
            </button>
        </form>
    </div>
</div>
@endsection
