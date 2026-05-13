@extends('layouts.app')

@section('title', 'Nuevo Producto | Admin')

@section('content')
    <section class="py-14 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto" data-fade-in>
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-headline-lg font-headline-lg text-primary">Crear producto</h1>
            <a href="{{ route('admin.products.index') }}" class="text-label-caps font-label-caps text-on-surface-variant hover:text-primary">Volver</a>
        </div>

        @if ($errors->any())
            <div class="mb-5 border border-error/30 bg-error-container/40 px-4 py-3 text-body-md font-body-md text-on-error-container">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="bg-surface-container-low border border-primary/10 p-6 md:p-8">
            @include('admin.products._form')
            <div class="mt-8">
                <button type="submit" class="bg-primary text-on-primary py-4 px-8 font-label-caps text-label-caps tracking-[0.2em] uppercase hover:bg-primary-container transition-all">
                    Guardar
                </button>
            </div>
        </form>
    </section>
@endsection
