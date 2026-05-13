<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LEGADO PATO')</title>

    <link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&family=Work+Sans:wght@400;600&family=EB+Garamond:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-background text-on-background selection:bg-secondary-fixed selection:text-on-secondary-fixed">
    <header class="docked full-width top-0 sticky backdrop-blur-md z-50 bg-surface/90 border-b border-primary/10">
        <div class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop py-4 max-w-max-width mx-auto">
            <a href="{{ url('/') }}" class="text-headline-md font-headline-md tracking-[0.2em] text-primary uppercase">
                LEGADO PATO
            </a>
            <nav class="hidden md:flex items-center gap-8">
                <a class="text-label-caps font-label-caps text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/') }}">Inicio</a>
                <a class="text-label-caps font-label-caps text-on-surface-variant hover:text-primary transition-colors" href="{{ route('catalog.index') }}">Colección</a>
                <a class="text-label-caps font-label-caps text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/nuestra-historia') }}">Nuestra Historia</a>
                <a class="text-label-caps font-label-caps text-on-surface-variant hover:text-primary transition-colors" href="{{ url('/contacto') }}">Contacto</a>
            </nav>
            <div class="flex items-center gap-4">
                <a href="{{ route('cart.index') }}" class="hover:opacity-80 transition-opacity active:scale-95 duration-150">
                    <span class="material-symbols-outlined">shopping_bag</span>
                </a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="hover:opacity-80 transition-opacity active:scale-95 duration-150">
                        <span class="material-symbols-outlined">person</span>
                    </a>
                @else
                    <a href="{{ url('/login') }}" class="hover:opacity-80 transition-opacity active:scale-95 duration-150">
                        <span class="material-symbols-outlined">person</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="full-width mt-20 bg-primary text-secondary-fixed">
        <div class="flex flex-col items-center justify-center text-center gap-base py-16 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto">
            <div class="text-headline-lg font-headline-lg text-secondary-fixed tracking-[0.25em] mb-4">
                LEGADO PATO
            </div>
            <div class="flex flex-wrap justify-center gap-x-12 gap-y-4 mb-12">
                <a class="text-label-caps font-label-caps text-primary-fixed/70 hover:text-surface-bright transition-colors" href="#">Envíos y Cambios</a>
                <a class="text-label-caps font-label-caps text-primary-fixed/70 hover:text-surface-bright transition-colors" href="#">Cuidado de la Lana</a>
                <a class="text-label-caps font-label-caps text-primary-fixed/70 hover:text-surface-bright transition-colors" href="#">Traceabilidad</a>
                <a class="text-label-caps font-label-caps text-primary-fixed/70 hover:text-surface-bright transition-colors" href="#">Términos y Condiciones</a>
            </div>
            <div class="h-[1px] w-full max-w-xs bg-secondary-fixed/20 mb-8"></div>
            <p class="text-label-caps font-label-caps text-[10px] tracking-[0.15em] opacity-80">
                © {{ now()->year }} LEGADO PATO. HECHO EN ARGENTINA CON ORGULLO PARA SIEMPRE.
            </p>
            <div class="mt-8 flex gap-6">
                <a class="text-primary-fixed/70 hover:text-secondary-fixed transition-colors" href="#">
                    <span class="material-symbols-outlined">photo_camera</span>
                </a>
                <a class="text-primary-fixed/70 hover:text-secondary-fixed transition-colors" href="#">
                    <span class="material-symbols-outlined">mail</span>
                </a>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (!window.gsap) {
                return;
            }

            gsap.from('[data-fade-in]', {
                opacity: 0,
                y: 18,
                duration: 0.85,
                stagger: 0.12,
                ease: 'power2.out'
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
