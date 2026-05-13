@extends('layouts.app')

@section('title', 'Contacto | LEGADO PATO')

@section('content')
    <section class="py-24 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto" data-fade-in>
        <div class="max-w-3xl mx-auto text-center mb-14">
            <h1 class="text-display-lg font-display-lg text-primary mb-4">Contacto</h1>
            <p class="text-accent-script font-accent-script text-on-surface-variant italic">Estamos para ayudarte con tu próxima ruana.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
            <div class="bg-surface-container-low border border-primary/10 p-8 space-y-5" data-fade-in>
                <h2 class="text-headline-md font-headline-md text-primary">Canales</h2>
                <p class="text-body-md font-body-md text-on-surface-variant">Email: contacto@legadopato.com</p>
                <p class="text-body-md font-body-md text-on-surface-variant">WhatsApp: +54 9 11 0000 0000</p>
                <p class="text-body-md font-body-md text-on-surface-variant">Horario: Lunes a Viernes, 9 a 18 hs</p>
            </div>

            <form class="bg-surface-container-low border border-primary/10 p-8 space-y-5" data-fade-in>
                <h2 class="text-headline-md font-headline-md text-primary">Escribinos</h2>
                <input type="text" placeholder="Nombre" class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none">
                <input type="email" placeholder="Email" class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none">
                <textarea rows="4" placeholder="Mensaje" class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none"></textarea>
                <button type="button" class="bg-primary text-on-primary py-4 px-8 font-label-caps text-label-caps tracking-[0.2em] uppercase hover:bg-primary-container transition-all">
                    Enviar
                </button>
            </form>
        </div>
    </section>
@endsection
