@extends('layouts.app')

@section('title', 'Colección | LEGADO PATO')

@section('content')
    <section class="max-w-max-width mx-auto px-margin-mobile md:px-margin-desktop py-12 md:py-20">
        <!-- Header Section -->
        <section class="mb-16 text-center" data-fade-in>
            <h1 class="text-display-lg font-display-lg text-primary mb-4">Nuestra Colección</h1>
            <p class="text-accent-script italic text-on-surface-variant max-w-2xl mx-auto">Raíces que abrigan. Historias que acompañan.</p>
            <div class="h-[1px] bg-primary opacity-20 w-24 mx-auto mt-8"></div>
        </section>

        <div class="flex flex-col md:flex-row gap-gutter">
            <!-- Filter Sidebar -->
            <aside class="w-full md:w-64 space-y-10 shrink-0" data-fade-in>
                <div>
                    <h3 class="text-label-caps font-label-caps text-primary mb-6">COLOR</h3>
                    <div class="flex flex-wrap gap-4">
                        <button class="w-8 h-8 rounded-full border border-outline-variant bg-[#F5F5DC] ring-offset-2 hover:ring-1 ring-primary transition-all"></button>
                        <button class="w-8 h-8 rounded-full border border-outline-variant bg-[#432411] ring-offset-2 hover:ring-1 ring-primary transition-all"></button>
                        <button class="w-8 h-8 rounded-full border border-outline-variant bg-[#8B4513] ring-offset-2 hover:ring-1 ring-primary transition-all"></button>
                        <button class="w-8 h-8 rounded-full border border-outline-variant bg-[#708090] ring-offset-2 hover:ring-1 ring-primary transition-all"></button>
                    </div>
                </div>
                <div>
                    <h3 class="text-label-caps font-label-caps text-primary mb-6">TIPO DE HILADO</h3>
                    <ul class="space-y-3">
                        <li><label class="flex items-center gap-3 cursor-pointer group"><input class="w-4 h-4 border-outline text-primary focus:ring-secondary rounded-sm" type="checkbox"/><span class="text-body-md text-on-surface-variant group-hover:text-primary transition-colors">Lana de Oveja 100%</span></label></li>
                        <li><label class="flex items-center gap-3 cursor-pointer group"><input class="w-4 h-4 border-outline text-primary focus:ring-secondary rounded-sm" type="checkbox"/><span class="text-body-md text-on-surface-variant group-hover:text-primary transition-colors">Mezcla Mohair</span></label></li>
                        <li><label class="flex items-center gap-3 cursor-pointer group"><input class="w-4 h-4 border-outline text-primary focus:ring-secondary rounded-sm" type="checkbox"/><span class="text-body-md text-on-surface-variant group-hover:text-primary transition-colors">Llama Selección</span></label></li>
                    </ul>
                </div>
                <div class="pt-6 border-t border-primary/10">
                    <p class="text-label-caps font-label-caps text-on-surface-variant/60 uppercase">Filtrar por categoría</p>
                    <div class="mt-4 flex flex-col gap-2">
                        <a href="{{ route('catalog.index') }}" class="text-left text-body-md transition-colors {{ $selectedCategory === '' ? 'text-primary' : 'text-on-surface-variant hover:text-primary' }}">Todas</a>
                        @foreach ($categories as $category)
                            <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" class="text-left text-body-md transition-colors {{ $selectedCategory === $category->slug ? 'text-primary' : 'text-on-surface-variant hover:text-primary' }}">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
            </aside>

            <!-- Product Grid -->
            <div class="flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-gutter gap-y-12">
                    @forelse ($products as $product)
                        <div class="group" data-fade-in>
                            <a href="{{ route('catalog.show', $product->slug) }}">
                                <div class="aspect-[3/4] overflow-hidden bg-surface-container mb-4 relative">
                                    @if ($product->image)
                                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}"/>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-label-caps font-label-caps text-on-surface-variant">Sin imagen</div>
                                    @endif
                                    @if ($loop->first)
                                        <span class="absolute top-4 left-4 bg-surface px-3 py-1 text-label-caps font-label-caps text-primary border border-primary/10">NUEVO</span>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <h2 class="text-headline-md font-headline-md text-primary mb-1">{{ $product->title }}</h2>
                                    <p class="text-label-caps font-label-caps text-on-surface-variant mb-2">{{ strtoupper($product->categories->first()->name ?? 'LANA ARTESANAL') }}</p>
                                    <p class="text-body-lg font-body-lg text-secondary">$ {{ number_format((float) $product->price, 2, ',', '.') }}</p>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-body-lg font-body-lg text-on-surface-variant py-20" data-fade-in>
                            No encontramos productos para este filtro.
                        </div>
                    @endforelse
                </div>

                <div class="mt-12" data-fade-in>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </section>

    <!-- Story Block -->
    <section class="mt-20 relative h-[400px] flex items-center justify-center overflow-hidden" data-fade-in>
        <div class="absolute inset-0 z-0">
            <img class="w-full h-full object-cover brightness-50" data-alt="A wide panoramic view of the Argentine pampas at dusk. The horizon line is vast and low, with a soft gradient of orange and deep purple in the sky. A lone ombu tree stands silhouetted against the fading light. The mood is quiet, eternal, and deeply grounded in the earth. The aesthetic is one of expansive minimalism and natural beauty." src="https://lh3.googleusercontent.com/aida-public/AB6AXuANLOrOhxt7fo5KF09eHcHnCSjT0y5kR2FtUt-kaIKGifzyr9ZLgyGokmC8uLnFuKAOFGokOU9picdi3eZI7fQlmA07M8veqgLhVowb-7UvcRNWFqXKsivzKZ5XaQdhDx2C5skjvnmp80Z3SEcR53i4vNpzWw9FWv9N0KHkEn_oSyvmBcqpVem5prVKskw0sXwObk3reao0K9HratpCH-j5oZU9xm-YRjYDttU3GeNGno48Z0XY8XW74D7tpTbvTvhxP-oQft1K0toU"/>
        </div>
        <div class="relative z-10 text-center px-6">
            <p class="text-accent-script italic text-surface-bright text-display-lg max-w-3xl">
                "Hay símbolos que no solo abrigan el cuerpo. Abrigan la historia que llevamos encima."
            </p>
            <div class="mt-8">
                <span class="material-symbols-outlined text-surface-bright" data-icon="nature">nature</span>
            </div>
        </div>
    </section>
@endsection
