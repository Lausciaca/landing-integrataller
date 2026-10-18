@props(['eyebrow' => null, 'title', 'subtitle' => null])

<section class="bg-gris-50">
    <div class="contenedor py-14 md:py-20">
        {{ $breadcrumbs ?? '' }}
        <div class="max-w-[720px]">
            @if ($eyebrow)
                <p class="t-etiqueta">{{ $eyebrow }}</p>
            @endif
            <h1 class="t-display mt-4">{{ $title }}</h1>
            @if ($subtitle)
                <p class="t-cuerpo-grande mt-5 max-w-[36rem] text-texto-secundario">{{ $subtitle }}</p>
            @endif
            {{ $slot }}
        </div>
    </div>
</section>
