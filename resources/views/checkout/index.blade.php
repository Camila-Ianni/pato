@extends('layouts.app')

@section('title', 'Checkout | LEGADO PATO')

@section('content')
    <section class="py-16 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto" data-fade-in>
        <div class="mb-10">
            <p class="text-label-caps font-label-caps text-on-surface-variant">Checkout</p>
            <h1 class="text-headline-lg font-headline-lg text-primary mt-2">Confirmar compra</h1>
        </div>

        @if ($errors->any())
            <div class="mb-6 border border-error/30 bg-error-container/40 px-4 py-3 text-body-md font-body-md text-on-error-container">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-7">
                <form method="POST" action="{{ route('checkout.process') }}" class="bg-surface-container-low border border-primary/10 p-6 md:p-8 space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label class="block text-label-caps font-label-caps text-on-surface-variant">Email</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()->email) }}" required class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-label-caps font-label-caps text-on-surface-variant">Celular</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none">
                    </div>

                    <div class="space-y-3">
                        <label class="block text-label-caps font-label-caps text-on-surface-variant">Método de pago</label>
                        <label class="flex items-center gap-3 border border-outline-variant px-4 py-3">
                            <input type="radio" name="payment_provider" value="mercadopago" {{ old('payment_provider', 'mercadopago') === 'mercadopago' ? 'checked' : '' }}>
                            <span class="text-body-md font-body-md text-on-surface">MercadoPago</span>
                        </label>
                        <label class="flex items-center gap-3 border border-outline-variant px-4 py-3">
                            <input type="radio" name="payment_provider" value="transferencia" {{ old('payment_provider') === 'transferencia' ? 'checked' : '' }}>
                            <span class="text-body-md font-body-md text-on-surface">Transferencia (alias + envío de comprobante)</span>
                        </label>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-label-caps font-label-caps text-on-surface-variant">Notas (opcional)</label>
                        <textarea name="notes" rows="3" class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-primary text-on-primary py-4 font-label-caps text-label-caps tracking-[0.2em] uppercase hover:bg-primary-container transition-all">
                        Confirmar compra
                    </button>
                </form>
            </div>

            <aside class="lg:col-span-5">
                <div class="bg-surface-container border border-primary/10 p-6 md:p-8">
                    <h2 class="text-headline-md font-headline-md text-primary mb-6">Resumen</h2>
                    <div class="space-y-4">
                        @foreach ($items as $item)
                            <div class="flex justify-between gap-3 border-b border-primary/10 pb-3">
                                <div>
                                    <p class="text-body-md font-body-md text-on-surface">{{ $item->product->title }}</p>
                                    <p class="text-label-caps font-label-caps text-on-surface-variant">Cantidad: {{ $item->quantity }}</p>
                                </div>
                                <p class="text-body-md font-body-md text-secondary">$ {{ number_format((float) $item->product->price * $item->quantity, 2, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 pt-4 border-t border-primary/10 flex items-center justify-between">
                        <span class="text-body-md font-body-md text-on-surface-variant">Total</span>
                        <span class="text-headline-md font-headline-md text-primary">$ {{ number_format((float) $total, 2, ',', '.') }}</span>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
