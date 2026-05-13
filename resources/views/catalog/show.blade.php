@extends('layouts.app')

@section('title', $product->title . ' | LEGADO PATO')

@section('content')
    <section class="max-w-max-width mx-auto px-margin-mobile md:px-margin-desktop mt-12 mb-24">
        <!-- Product Main Section -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12" data-fade-in>
            <!-- Gallery Grid (Asymmetric Bento Style) -->
            <div class="md:col-span-7 grid grid-cols-2 gap-4">
                <div class="col-span-2 overflow-hidden bg-surface-container">
                    @if ($product->image)
                        <img class="w-full h-auto object-cover aspect-[4/5] hover:scale-105 transition-transform duration-700" data-alt="{{ $product->title }}" src="{{ asset('storage/' . $product->image) }}"/>
                    @else
                        <div class="w-full h-full min-h-[320px] flex items-center justify-center text-label-caps font-label-caps text-on-surface-variant">Sin imagen</div>
                    @endif
                </div>
                <div class="overflow-hidden bg-surface-container">
                    @if ($product->image)
                        <img class="w-full h-auto object-cover aspect-square hover:scale-105 transition-transform duration-700" data-alt="{{ $product->title }}" src="{{ asset('storage/' . $product->image) }}"/>
                    @else
                        <div class="w-full h-full min-h-[160px] flex items-center justify-center text-label-caps font-label-caps text-on-surface-variant">Sin imagen</div>
                    @endif
                </div>
                <div class="overflow-hidden bg-surface-container">
                    @if ($product->image)
                        <img class="w-full h-auto object-cover aspect-square hover:scale-105 transition-transform duration-700" data-alt="{{ $product->title }}" src="{{ asset('storage/' . $product->image) }}"/>
                    @else
                        <div class="w-full h-full min-h-[160px] flex items-center justify-center text-label-caps font-label-caps text-on-surface-variant">Sin imagen</div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="md:col-span-5 flex flex-col space-y-8 sticky top-32 h-fit">
                <nav class="flex gap-2 text-label-caps font-label-caps text-on-surface-variant uppercase tracking-widest opacity-60">
                    <a href="{{ route('catalog.index') }}">Colección</a> /
                    <a href="{{ route('catalog.index') }}">{{ $product->categories->first()->name ?? 'Ruanas' }}</a>
                </nav>
                <div class="space-y-4">
                    <h1 class="font-headline-lg text-headline-lg text-primary">{{ $product->title }}</h1>
                    <p class="font-headline-md text-headline-md text-secondary">$ {{ number_format((float) $product->price, 2, ',', '.') }}</p>
                </div>
                <div class="space-y-6">
                    <p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                        {{ $product->description ?: 'Prenda tejida en fibras naturales, con la identidad de nuestras raíces y abrigo auténtico para todos los días.' }}
                    </p>
                    <div class="space-y-2">
                        <span class="font-label-caps text-label-caps text-on-surface opacity-80 uppercase tracking-widest">Stock disponible: {{ $product->stock }}</span>
                        <div class="flex gap-3 mt-2">
                            <button class="w-8 h-8 rounded-full border-2 border-primary bg-[#F5F5F0]"></button>
                            <button class="w-8 h-8 rounded-full border border-outline-variant bg-[#3C2A21]"></button>
                            <button class="w-8 h-8 rounded-full border border-outline-variant bg-[#A68F7B]"></button>
                        </div>
                    </div>
                </div>
                <div class="pt-8 space-y-4">
                    <form method="POST" action="{{ route('cart.add', $product->id) }}" class="flex items-center gap-gutter">
                        @csrf
                        <div class="flex items-center border border-outline-variant py-3 px-4">
                            <button class="px-2 font-bold text-primary" type="button" id="qty-minus">-</button>
                            <input class="w-12 text-center bg-transparent border-none focus:ring-0 font-body-md text-body-md" id="quantity" name="quantity" min="1" max="{{ max((int) $product->stock, 1) }}" type="number" value="1"/>
                            <button class="px-2 font-bold text-primary" type="button" id="qty-plus">+</button>
                        </div>
                        <button class="flex-1 bg-primary text-on-primary py-4 font-label-caps text-label-caps tracking-[0.2em] uppercase hover:bg-primary-container transition-all active:scale-95 duration-150" type="submit">
                            Agregar al carrito
                        </button>
                    </form>
                </div>
                <div class="border-t border-primary/10 pt-8 flex items-center gap-4">
                    <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'wght' 300;">local_shipping</span>
                    <p class="font-body-md text-body-md text-on-surface-variant">Envío gratuito a todo el país en compras superiores a $120.000.</p>
                </div>
            </div>
        </div>

        <!-- Story Block Quote -->
        <section class="mt-32 mb-32 text-center max-w-2xl mx-auto space-y-6" data-fade-in>
            <span class="material-symbols-outlined text-primary text-4xl" style="font-variation-settings: 'wght' 200;">Calendar</span>
            <p class="font-accent-script text-accent-script text-primary italic">
                "Hay símbolos que no solo abrigan el cuerpo. Abrigan la historia que llevamos encima. Se hereda."
            </p>
            <div class="w-16 h-px bg-primary/20 mx-auto"></div>
        </section>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('quantity');
            const minus = document.getElementById('qty-minus');
            const plus = document.getElementById('qty-plus');
            if (!input || !minus || !plus) return;

            minus.addEventListener('click', () => {
                const current = Number(input.value || 1);
                input.value = String(Math.max(1, current - 1));
            });

            plus.addEventListener('click', () => {
                const current = Number(input.value || 1);
                const max = Number(input.max || 9999);
                input.value = String(Math.min(max, current + 1));
            });
        });
    </script>
@endpush
