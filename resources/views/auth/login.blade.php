@extends('layouts.app')

@section('title', 'Ingresar | LEGADO PATO')

@section('content')
    <section class="py-24 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto" data-fade-in>
        <div class="max-w-md mx-auto bg-surface-container-low border border-primary/10 p-8 md:p-10">
            <h1 class="text-headline-lg font-headline-lg text-primary mb-8 text-center">Ingresar</h1>

            @if ($errors->any())
                <div class="mb-5 border border-error/30 bg-error-container/40 px-4 py-3 text-body-md font-body-md text-on-error-container">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                @csrf
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none" required autocomplete="email">
                <input type="password" name="password" placeholder="Contraseña" class="w-full bg-transparent border border-outline-variant px-4 py-3 text-body-md font-body-md focus:border-primary outline-none" required autocomplete="current-password">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input class="w-4 h-4 border-outline text-primary focus:ring-secondary rounded-sm" type="checkbox" name="remember">
                    <span class="text-body-md text-on-surface-variant group-hover:text-primary transition-colors">Recordarme</span>
                </label>
                <button type="submit" class="w-full bg-primary text-on-primary py-4 font-label-caps text-label-caps tracking-[0.2em] uppercase hover:bg-primary-container transition-all">
                    Ingresar
                </button>
            </form>
        </div>
    </section>
@endsection
