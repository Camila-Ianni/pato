@extends('layouts.app')

@section('title', 'Legado Pato')

@section('content')
    <!-- Hero Section -->
    <section class="relative h-[90vh] min-h-[600px] flex items-center justify-center overflow-hidden" data-fade-in>
        <div class="absolute inset-0 z-0">
            <img alt="Legado Pato Heritage" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBRNHxVHzwolyqqwouTrj0AoqShCTETOuez8pAznr1jAnWgDZXyE-szvB8KTE-Mm5HnogUhcYjeDF2z0mT8qnQbGkmRgRr-gDwQdMxGa9hDenxvx9khZ-e6cTR1IQ6-kkgM0YmZs2R9Gkx_EZkYWJshS3Uew1hLR6COK06UzhWWw34YqlnwGl0xUsQ4FndAfQhQUvRjz83FaQr1I8A8Jl0dlTdf3x7MRy3rN9DUVtJhbbxV3aloJRfXb-58UXRBJdF4lGguPKeuTgho"/>
            <div class="absolute inset-0 bg-primary/20 backdrop-brightness-75"></div>
        </div>
        <div class="relative z-10 text-center px-margin-mobile max-w-3xl flex flex-col items-center">
            <div class="mb-6">
                <span class="material-symbols-outlined text-surface text-4xl" data-icon="light_mode" style="font-variation-settings: 'wght' 100;">light_mode</span>
            </div>
            <h1 class="text-display-lg font-display-lg text-surface tracking-[0.3em] mb-4 uppercase">
                LEGADO PATO
            </h1>
            <p class="text-label-caps font-label-caps text-surface/90 tracking-[0.15em] mb-12">
                Raíces que abrigan. Historias que acompañan.
            </p>
            <div class="h-[1px] w-24 bg-surface/30 mb-8"></div>
            <div class="text-surface/90 text-body-lg font-body-lg max-w-md leading-relaxed mb-6">
                Hay símbolos que no solo abrigan el cuerpo.<br/>
                Abrigan la historia que llevamos encima.
            </div>
            <p class="text-accent-script font-accent-script text-surface text-display-lg italic">
                Se hereda.
            </p>
            <div class="mt-16">
                <a href="{{ route('catalog.index') }}" class="border border-surface/50 text-surface text-label-caps px-10 py-4 hover:bg-surface hover:text-primary transition-all duration-300">
                    Explorar Colección
                </a>
            </div>
        </div>
    </section>

    <!-- Colección Destacada Section -->
    <section class="py-24 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-4" data-fade-in>
            <div>
                <h2 class="text-headline-lg font-headline-lg text-primary mb-2">Colección Destacada</h2>
                <div class="h-1 w-20 bg-secondary"></div>
            </div>
            <a class="text-label-caps font-label-caps text-on-surface-variant hover:text-secondary transition-colors" href="{{ route('catalog.index') }}">Ver Todo</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
            @foreach ($products as $product)
                <div class="group cursor-pointer" data-fade-in>
                    <a href="{{ route('catalog.show', $product->slug) }}">
                        <div class="aspect-[3/4] overflow-hidden bg-surface-container mb-6 relative">
                            @if ($product->image)
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}"/>
                            @else
                                <div class="w-full h-full flex items-center justify-center text-label-caps font-label-caps text-on-surface-variant">Sin imagen</div>
                            @endif
                            @if ($loop->first)
                                <div class="absolute top-4 right-4 bg-surface-bright/80 backdrop-blur px-3 py-1 rounded-full text-[10px] uppercase tracking-widest font-semibold border border-primary/10">
                                    Hecho a Mano
                                </div>
                            @endif
                        </div>
                        <h3 class="text-headline-md font-headline-md text-primary mb-1">{{ $product->title }}</h3>
                        <p class="text-label-caps font-label-caps text-on-surface-variant">{{ $product->categories->first()->name ?? 'Lana Artesanal' }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Nuestra Esencia Section (Story Block) -->
    <section class="bg-surface-container py-32 px-margin-mobile relative overflow-hidden" data-fade-in>
        <div class="max-w-4xl mx-auto text-center relative z-10">
            <div class="flex justify-center mb-8">
                <span class="material-symbols-outlined text-secondary text-5xl" data-icon="history_edu">history_edu</span>
            </div>
            <h2 class="text-headline-lg font-headline-lg text-primary mb-8 tracking-wide">Nuestra Esencia</h2>
            <div class="space-y-6 max-w-2xl mx-auto text-body-lg font-body-lg text-on-surface-variant leading-relaxed">
                <p>
                    Nacemos de la memoria, de la infancia, de la identidad de esta tierra. Cada pieza de Legado Pato es el resultado de un tiempo pausado, respetando los ciclos de la naturaleza y el saber ancestral de las manos que tejen.
                </p>
                <p>
                    No creamos simples prendas; custodiamos historias que merecen ser transmitidas de generación en generación.
                </p>
            </div>
            <div class="mt-12">
                <p class="text-accent-script font-accent-script text-headline-lg text-secondary">
                    Lo que nos abriga, nos une.
                </p>
            </div>
            <div class="mt-16 flex justify-center gap-12 flex-wrap">
                <div class="flex flex-col items-center gap-2">
                    <span class="material-symbols-outlined text-primary" data-icon="eco">eco</span>
                    <span class="text-label-caps font-label-caps text-[10px]">100% Orgánico</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <span class="material-symbols-outlined text-primary" data-icon="location_on">location_on</span>
                    <span class="text-label-caps font-label-caps text-[10px]">Origen Argentino</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <span class="material-symbols-outlined text-primary" data-icon="inventory_2">inventory_2</span>
                    <span class="text-label-caps font-label-caps text-[10px]">Traceabilidad Total</span>
                </div>
            </div>
        </div>
        <div class="absolute top-0 left-0 w-64 h-64 border-l border-t border-secondary/10 -translate-x-12 -translate-y-12"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 border-r border-b border-secondary/10 translate-x-12 translate-y-12"></div>
    </section>

    <!-- Newsletter / Community Section -->
    <section class="py-24 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto text-center border-t border-primary/5 mt-20" data-fade-in>
        <h3 class="text-headline-md font-headline-md text-primary mb-4">Únete al Legado</h3>
        <p class="text-body-md font-body-md text-on-surface-variant mb-10 max-w-md mx-auto">
            Recibe historias sobre nuestras tejedoras, nuevos lanzamientos y el arte de vivir con propósito.
        </p>
        <form class="flex flex-col md:flex-row gap-4 max-w-lg mx-auto justify-center">
            <input class="flex-grow bg-transparent border-b-2 border-outline-variant focus:border-secondary outline-none px-4 py-2 font-body-md transition-colors placeholder:text-outline/50" placeholder="Tu correo electrónico" type="email"/>
            <button class="bg-primary text-secondary-fixed text-label-caps px-8 py-3 hover:opacity-90 transition-opacity" type="submit">
                Suscribirme
            </button>
        </form>
    </section>
@endsection
