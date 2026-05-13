@extends('layouts.app')

@section('title', 'Carrito | LEGADO PATO')

@section('content')
    @php
        $cartItems = $cartItems ?? $items ?? collect();
        $total = $subtotal ?? $cartItems->sum(fn ($item) => (float) $item->product->price * $item->quantity);
    @endphp

    <section class="py-16 md:py-24 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-14" data-fade-in>
            <div>
                <p class="text-label-caps font-label-caps text-on-surface-variant mb-4">Resumen de Compra</p>
                <h1 class="text-headline-lg font-headline-lg text-primary">Tu Carrito</h1>
            </div>
            <a href="{{ route('catalog.index') }}" class="text-label-caps font-label-caps text-on-surface-variant hover:text-primary transition-colors">
                Seguir comprando
            </a>
        </div>

        @if (session('status'))
            <div class="mb-8 border border-primary/15 bg-surface-container-low px-5 py-4 text-body-md font-body-md text-primary" data-fade-in>
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-8 border border-error/30 bg-error-container/40 px-5 py-4 text-body-md font-body-md text-on-error-container" data-fade-in>
                {{ $errors->first() }}
            </div>
        @endif

        @if ($cartItems->isEmpty())
            <div class="bg-surface-container-low border border-primary/10 py-20 px-8 text-center space-y-6" data-fade-in>
                <span class="material-symbols-outlined text-primary text-4xl">shopping_bag</span>
                <h2 class="text-headline-md font-headline-md text-primary">Tu carrito está vacío</h2>
                <p class="text-body-md font-body-md text-on-surface-variant">Descubrí nuestras ruanas y elegí la que va con tu historia.</p>
                <a href="{{ route('catalog.index') }}" class="inline-flex bg-primary text-on-primary py-4 px-8 font-label-caps text-label-caps tracking-[0.2em] uppercase hover:bg-primary-container transition-all active:scale-95 duration-150">
                    Ver colección
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12">
                <div class="lg:col-span-8 space-y-4">
                    @foreach ($cartItems as $item)
                        @php
                            $product = $item->product;
                            $unitPrice = (float) $product->price;
                            $lineTotal = $unitPrice * $item->quantity;
                        @endphp

                        <article class="bg-surface-container-low border border-primary/10 p-5 md:p-6 flex flex-col md:flex-row gap-5 md:gap-6" data-fade-in>
                            <a href="{{ route('catalog.show', $product->slug) }}" class="w-full md:w-32 lg:w-36 shrink-0 bg-surface-container overflow-hidden">
                                @if ($product->image)
                                    <img
                                        src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->title }}"
                                        class="w-full h-40 md:h-full object-cover"
                                    >
                                @else
                                    <div class="w-full h-40 md:h-full flex items-center justify-center text-label-caps font-label-caps text-on-surface-variant bg-surface-container">
                                        Sin imagen
                                    </div>
                                @endif
                            </a>

                            <div class="flex-1 flex flex-col gap-4">
                                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-3">
                                    <div>
                                        <h2 class="text-headline-md font-headline-md text-primary">{{ $product->title }}</h2>
                                        <p class="text-label-caps font-label-caps text-on-surface-variant mt-2">Precio unitario: $ {{ number_format($unitPrice, 2, ',', '.') }}</p>
                                    </div>
                                    <p class="text-headline-md font-headline-md text-secondary">$ {{ number_format($lineTotal, 2, ',', '.') }}</p>
                                </div>

                                <div class="flex flex-wrap items-center justify-between gap-4 pt-1">
                                    <div class="flex items-center border border-outline-variant">
                                        <form method="POST" action="{{ route('cart.decrement', $item) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-4 py-3 text-primary hover:bg-surface-container transition-colors" aria-label="Restar cantidad">
                                                <span class="material-symbols-outlined">remove</span>
                                            </button>
                                        </form>
                                        <span class="w-10 text-center text-body-md font-body-md text-on-surface">{{ $item->quantity }}</span>
                                        <form method="POST" action="{{ route('cart.increment', $item) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-4 py-3 text-primary hover:bg-surface-container transition-colors" aria-label="Sumar cantidad">
                                                <span class="material-symbols-outlined">add</span>
                                            </button>
                                        </form>
                                    </div>

                                    <form method="POST" action="{{ route('cart.remove', $item) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-2 text-label-caps font-label-caps text-on-surface-variant hover:text-error transition-colors" aria-label="Eliminar producto">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <aside class="lg:col-span-4" data-fade-in>
                    <div class="bg-surface-container p-7 md:p-8 border border-primary/10 lg:sticky lg:top-28 space-y-8">
                        <div class="space-y-2">
                            <p class="text-label-caps font-label-caps text-on-surface-variant">Resumen</p>
                            <h2 class="text-headline-md font-headline-md text-primary">Total</h2>
                        </div>

                        <div class="flex items-end justify-between border-y border-primary/10 py-6">
                            <span class="text-body-md font-body-md text-on-surface-variant">Subtotal</span>
                            <span class="text-headline-lg font-headline-lg text-primary">$ {{ number_format((float) $total, 2, ',', '.') }}</span>
                        </div>

                        <div class="mt-8">
                            <a href="{{ route('checkout.show') }}" class="block w-full bg-stone-800 text-white text-center py-4 tracking-widest uppercase text-sm hover:bg-black transition-all font-bold">
                                INICIAR COMPRA
                            </a>
                        </div>

                        <form method="POST" action="{{ route('cart.clear') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-label-caps font-label-caps text-on-surface-variant hover:text-primary transition-colors">
                                Vaciar carrito
                            </button>
                        </form>
                    </div>
                </aside>
            </div>
        @endif
    </section>
@endsection
