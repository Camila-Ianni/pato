@extends('layouts.app')

@section('title', 'Nuestra Historia | LEGADO PATO')

@section('content')
    <!-- Hero Section: El Legado -->
    <header class="relative h-[921px] overflow-hidden flex items-center justify-center bg-surface-container" data-fade-in>
        <div class="absolute inset-0 z-0">
            <img alt="Heritage scenery" class="w-full h-full object-cover opacity-80" data-alt="A sweeping, cinematic landscape of the Argentine pampas at sunrise, featuring rolling golden grasslands under a soft, hazy sky. The lighting is ethereal and warm, utilizing a palette of earth tones, deep browns, and soft crèmes to establish a heritage feel. The composition is vast and minimalist, evoking a sense of eternal tradition and the raw beauty of the natural world." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAULudUCyTG4TUzAoQnkWw-eY5_TV3OOh5gNQFIkJsOQ8hoOwd5Nq66Zoj-nrVBFs762Vaw8OxAGCcL368JAohX8AEz4P6y3ofOWSWcEUj2Tttf0tEWgLc8Jj0SIVxLSWHTqPhgpfzEtnyfLjf1sWa7mmBTpffBszSb8i6-_KWtA6Amb7u3o4u8TbwXMqNBdbEuVbC0SAZ-Ty0PHKVeEZ4mhT2ltJDBiFAGZxCcXAvG1SSOYk59dshco25lFkxbD6MU2shMimpWbJCG"/>
        </div>
        <div class="relative z-10 text-center px-margin-mobile">
            <span class="text-label-caps font-label-caps tracking-widest text-primary mb-4 block">RAÍCES QUE ABRIGAN. HISTORIAS QUE ACOMPAÑAN.</span>
            <h1 class="text-display-lg font-display-lg text-primary max-w-2xl mx-auto mb-6">Nuestra Historia</h1>
            <div class="w-16 h-px bg-primary/30 mx-auto"></div>
        </div>
    </header>

    <!-- El Origen Section -->
    <section class="py-24 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto grid grid-cols-1 md:grid-cols-12 gap-gutter items-center" data-fade-in>
        <div class="md:col-span-5 space-y-8">
            <h2 class="text-headline-lg font-headline-lg text-primary">El origen</h2>
            <div class="space-y-6 text-body-lg font-body-lg text-on-surface-variant leading-relaxed">
                <p>Hay recuerdos que no vuelven en imágenes, sino en sensaciones. En el olor de la casa: madera vieja, mate lavado y silencios compartidos. En el roce de una tela antigua.</p>
                <p>De chico no sabía nombrarlo. Era apenas una prenda gruesa, pesada, áspera a veces. Pero en las noches largas —esas donde el mundo parecía demasiado grande— alguien la apoyaba sobre mis hombros y todo cambiaba.</p>
            </div>
            <div class="pt-8">
                <p class="text-accent-script font-accent-script italic text-secondary text-2xl">"El silencio ya no era tan hondo. Y el miedo encontraba dónde descansar."</p>
            </div>
        </div>
        <div class="md:col-span-7 relative">
            <div class="aspect-[4/5] overflow-hidden bg-surface-container-high shadow-sm">
                <img alt="Wool weaving detail" class="w-full h-full object-cover" data-alt="A high-detail close-up of a hand-weaving process on a traditional wooden loom, showing the intricate textures of raw, cream-colored wool. The lighting is soft and side-lit to emphasize the tactile fibers and artisanal craftsmanship. The color palette is organic, dominated by warm neutrals and deep wood tones, creating a sense of authentic, slow fashion." src="https://lh3.googleusercontent.com/aida-public/AB6AXuB3OjqihzFJsW15wJV8_u7xGgnNY7IEiQVuTHVkHlJqropYcCt20pdb86ooKHW4qKC5CIDNT6i3viy0hD05FAJl_Qju5q9LwHD8UO06vzizh1TLZ444ZttwKLOPsMZijCg8tYcBRKP-_kJBzdjwWTdKHb10xodKCKWzA-Gm8jrfgmznzJJUHDNxKlB-jlAENXJqsyhQoE09oJfgiWIrK_SFFBxS7N6JPxy7qnGMYpYx7QSaD4rvZLTl3foKNdPC3cgPfLJaUJzXod1h"/>
            </div>
            <div class="absolute -bottom-8 -left-8 hidden lg:block w-48 aspect-square border border-primary/20 bg-surface p-4 flex flex-col justify-center items-center text-center">
                <span class="material-symbols-outlined text-secondary mb-2" data-icon="history_edu">history_edu</span>
                <span class="text-label-caps font-label-caps text-primary">TRADICIÓN ORGÁNICA</span>
            </div>
        </div>
    </section>

    <!-- Quote Block -->
    <section class="py-32 bg-primary text-secondary-fixed text-center px-margin-mobile" data-fade-in>
        <div class="max-w-3xl mx-auto">
            <blockquote class="text-display-lg font-display-lg italic mb-8">
                "Una pertenencia que no se aprende. Se hereda."
            </blockquote>
            <div class="flex justify-center items-center gap-4">
                <div class="h-px w-12 bg-secondary-fixed/30"></div>
                <span class="text-label-caps font-label-caps">IDENTIDAD ARGENTINA</span>
                <div class="h-px w-12 bg-secondary-fixed/30"></div>
            </div>
        </div>
    </section>

    <!-- La Identidad Section (Bento Inspired) -->
    <section class="py-24 px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto" data-fade-in>
        <div class="flex flex-col md:flex-row justify-between items-baseline mb-16 gap-4">
            <h2 class="text-headline-lg font-headline-lg text-primary">La identidad</h2>
            <p class="text-label-caps font-label-caps text-on-surface-variant max-w-xs">NACE DE ENTENDER QUE ALGUNAS COSAS NO NECESITAN EXPLICACIÓN.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-12 grid-rows-none md:grid-rows-2 gap-gutter">
            <div class="md:col-span-8 md:row-span-2 aspect-square md:aspect-auto h-full overflow-hidden relative group">
                <img alt="Portrait of an artisan" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" data-alt="A portrait of an elderly Argentine artisan with weathered hands and a serene expression, sitting in a sun-drenched workshop. The environment is filled with rolls of raw wool and traditional tools, illuminated by natural light that creates deep shadows and warm highlights. The aesthetic is deeply authentic and quiet, focusing on the human connection to heritage and handwork." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBRYPLD8I7ARvu13Rad5xVRYaWP9eBfcLwMZRkkuIzV8OHDQ6PBJvdj1YM-D6a5UtUiecxXxQgKBeoDMV5yNeRNMOAFh7DaAnJ2vHLgZ6SZhvTLXgg5gP27ipeJHHowEdu38U3iSaxCmJDNR1zq0lwuqJ9ALJ2IDWFYqS6bT3eTEJ4mjT7qp7PXRE8Ck_CgciLNfxS7TESTmd0yVIvJ8WL33KqhE9Vp0p5NuPhrqXLKOfLEovQt2tXLBDidWe5i6ALr43xg91Yhz6Xt"/>
                <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent"></div>
                <div class="absolute bottom-8 left-8 text-surface">
                    <h3 class="text-headline-md font-headline-md mb-2">Manos que hablan</h3>
                    <p class="text-body-md font-body-md opacity-90 max-w-sm">Vivían las manos que la hicieron, las historias contadas alrededor de una mesa, el campo abierto.</p>
                </div>
            </div>
            <div class="md:col-span-4 bg-surface-container p-12 flex flex-col justify-center space-y-4 border-l border-primary/10">
                <span class="material-symbols-outlined text-secondary text-4xl" data-icon="eco">eco</span>
                <h4 class="text-headline-md font-headline-md text-primary">Lana Pura</h4>
                <p class="text-body-md font-body-md text-on-surface-variant leading-relaxed">Cada fibra de nuestra lana 100% natural guarda el susurro del viento patagónico y la templanza de la tierra seca y noble.</p>
            </div>
            <div class="md:col-span-4 bg-secondary p-12 flex flex-col justify-center space-y-4 text-surface">
                <span class="material-symbols-outlined text-secondary-fixed text-4xl" data-icon="workspace_premium">workspace_premium</span>
                <h4 class="text-headline-md font-headline-md">Hecho a Mano</h4>
                <p class="text-body-md font-body-md opacity-90 leading-relaxed">Nace de la necesidad de mantener vivas nuestras raíces y transformar esa historia en algo que otros también puedan sentir.</p>
            </div>
        </div>
    </section>

    <!-- El Refugio Section (Editorial Asymmetric) -->
    <section class="py-24 bg-surface-container-low overflow-hidden" data-fade-in>
        <div class="px-margin-mobile md:px-margin-desktop max-w-max-width mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
                <div class="relative">
                    <img alt="Woven blanket detail" class="w-full h-auto aspect-[3/4] object-cover" data-alt="A lifestyle shot of a heavy, cream-colored hand-woven woolen blanket draped over a rustic wooden chair in a minimalist, warmly lit interior. The lighting is soft and golden, highlighting the deep texture and fringe of the textile. The surrounding environment features natural materials like wood and clay, reinforcing a sense of calm, refuge, and timeless Argentine elegance." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDMLApsCFXuvoT2ruiQ5-kNUgeiwFwOHnIIcdN4oMtNUibwK-AlPD404dsr9j_VEkA5UHW5yjYG7SNLkl8USsyfvcnG79Msk59KwFOwlrnG8kAglKanjmG1c9r_w-iR4BFNgXbSInpNCr2J7iO11-G5t2UdAUQ1k_6Um4H8lArTV3azihAHuK-LIfu7afmatz4gbW4d5ExlRZpZOQ9-8_ZuZ2XRdJibbDRA_ZT68Fi6O7TKUfN3YQoY0zad3NYncPeQrlfQMY1KIx4e"/>
                    <div class="absolute top-1/2 -right-12 hidden lg:block text-primary/5 font-display-lg text-[180px] select-none leading-none -translate-y-1/2">
                        PATO
                    </div>
                </div>
                <div class="space-y-8 lg:pl-12">
                    <div class="space-y-4">
                        <h2 class="text-headline-lg font-headline-lg text-primary">El refugio</h2>
                        <div class="h-1 w-12 bg-secondary"></div>
                    </div>
                    <div class="space-y-6 text-body-lg font-body-lg text-on-surface-variant leading-relaxed">
                        <p>Con el tiempo entendí que nunca fue solo abrigo. Era compañía. Era refugio. Era una forma silenciosa de decir "estoy acá".</p>
                        <p>Crecí, como crecen todos. La vida empezó a apurarse, a llenarse de ruido y distancia. Pero cada vez que volvía a esa prenda, volvía también a ese lugar donde alguien cuidaba sin preguntar.</p>
                    </div>
                    <div class="pt-12 grid grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <span class="text-label-caps font-label-caps text-secondary">MEMORIA</span>
                            <p class="text-body-md font-body-md">Que sostiene incluso cuando faltan las palabras.</p>
                        </div>
                        <div class="space-y-2">
                            <span class="text-label-caps font-label-caps text-secondary">TIERRA</span>
                            <p class="text-body-md font-body-md">La identidad de este suelo en cada hilo.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Ribbon (From provided image) -->
    <div class="bg-primary py-12 px-margin-mobile md:px-margin-desktop" data-fade-in>
        <div class="max-w-max-width mx-auto grid grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="flex flex-col items-center text-center space-y-2 text-secondary-fixed">
                <span class="material-symbols-outlined text-3xl" data-icon="front_hand">front_hand</span>
                <span class="text-label-caps font-label-caps">HECHO A MANO ARTESANAL</span>
            </div>
            <div class="flex flex-col items-center text-center space-y-2 text-secondary-fixed">
                <span class="material-symbols-outlined text-3xl" data-icon="fiber_manual_record">texture</span>
                <span class="text-label-caps font-label-caps">LANA PURA 100% NATURAL</span>
            </div>
            <div class="flex flex-col items-center text-center space-y-2 text-secondary-fixed">
                <span class="material-symbols-outlined text-3xl" data-icon="nest_eco_leaf">nest_eco_leaf</span>
                <span class="text-label-caps font-label-caps">ABRIGA DE VERDAD</span>
            </div>
            <div class="flex flex-col items-center text-center space-y-2 text-secondary-fixed">
                <span class="material-symbols-outlined text-3xl" data-icon="favorite">favorite</span>
                <span class="text-label-caps font-label-caps">PENSADO PARA DURAR SIEMPRE</span>
            </div>
        </div>
    </div>

    <!-- Heritage Map Section -->
    <section class="py-24 bg-surface text-center px-margin-mobile" data-fade-in>
        <div class="max-w-xl mx-auto space-y-8">
            <h2 class="text-headline-md font-headline-md text-primary">Nuestras Raíces, Nuestra Historia.</h2>
            <div class="flex justify-center opacity-40">
                <div class="w-16 h-24 border-2 border-primary rounded-full relative overflow-hidden flex items-center justify-center">
                    <span class="text-[10px] text-primary font-bold">ARG</span>
                </div>
            </div>
            <p class="text-label-caps font-label-caps tracking-widest text-on-surface-variant">HECHO EN ARGENTINA</p>
        </div>
    </section>
@endsection
