@extends('layouts.app')

@section('title', 'Crear cuenta | LEGADO PATO')

@section('content')
    <section class="py-24 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto" data-fade-in>
        <div class="max-w-md mx-auto bg-surface-container-low border border-primary/10 p-8 md:p-10">
            <h1 class="text-headline-lg font-headline-lg text-primary mb-8 text-center">Crear cuenta</h1>

            @if ($errors->any())
                <div class="mb-5 border border-error/30 bg-error-container/40 px-4 py-3 text-body-md font-body-md text-on-error-container">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nombre completo" class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none" required autocomplete="name">
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none" required autocomplete="email">
                <input type="password" name="password" placeholder="Contraseña" class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none" required autocomplete="new-password">
                <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none" required autocomplete="new-password">
                <button type="submit" class="w-full bg-primary text-on-primary py-4 font-label-caps text-label-caps tracking-[0.2em] uppercase hover:bg-primary-container transition-all">
                    Crear cuenta nueva
                </button>
            </form>
        </div>
    </section>
@endsection
