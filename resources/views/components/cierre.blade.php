{{-- Bloque de cierre en azul-800 con el llamado principal. Máximo uno por página. --}}
@props(['title' => 'Tu taller, en orden.', 'text' => 'Te mostramos cómo funciona con el trabajo de tu taller.'])

<section class="bg-azul-800 text-white">
    <div class="contenedor flex flex-col gap-6 py-14 md:flex-row md:items-end md:justify-between md:py-20">
        <div class="max-w-[640px]">
            <h2 class="t-titulo-1 !text-white">{{ $title }}</h2>
            <p class="t-cuerpo-grande mt-3 text-azul-100">{{ $text }}</p>
        </div>
        <div class="flex shrink-0 flex-col gap-3 sm:flex-row">
            <a href="{{ route('contacto') }}" class="boton boton-claro" data-cta="demo">Pedí tu demo</a>
            <a href="{{ \App\Support\Saas::signupUrl() }}" class="boton boton-borde-claro" data-cta="registro" data-registro>Probá 1 mes gratis</a>
        </div>
    </div>
</section>
