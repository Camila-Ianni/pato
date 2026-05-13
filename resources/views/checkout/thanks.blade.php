@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-20 text-center">
    <h1 class="text-stone-800 text-3xl mb-4 font-serif">¡Gracias por tu compra!</h1>
    <p class="text-stone-600 mb-8">Tu pedido #{{ $order->id ?? '' }} fue registrado con éxito.</p>
    <div class="bg-[#F9F8F6] border border-stone-200 p-8 text-left inline-block">
        <h2 class="font-bold mb-2">Datos para la transferencia:</h2>
        <p><strong>CBU:</strong> 0000003100000000000000</p>
        <p><strong>Alias:</strong> LEGADO.PATO</p>
        <p class="text-sm mt-4 text-stone-500">Por favor, envianos el comprobante respondiendo al mail de confirmación.</p>
    </div>
</div>
@endsection
