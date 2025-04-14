<section id="home" class="relative bg-cover bg-center scroll-mt-32"
    style="background-image: url('{{ asset('storage/hero-background.webp') }}'); height: 80vh;">
    <div class="absolute inset-0 bg-black opacity-50"></div>

    <div class="relative h-full z-10 flex flex-col items-center justify-center gap-5 mx-5 mb-5 text-center">
        <h1 class="text-4xl md:text-5xl font-bold" data-aos="zoom-in">
            Te ponés como loquita si Daro o Tommy no te responden los mensajes?
        </h1>

        <p class="text-2xl md:text-3xl" data-aos="zoom-in" data-aos-delay="500">
            Ahora también podés sacar turno desde esta página
        </p>

        <a href="{{ route('appointments.available') }}"
            class="text-2xl md:text-3xl bg-yellow px-6 py-3 rounded-lg hover:bg-black hover:text-yellow transition duration-150 ease-in-out"
            data-aos="zoom-in" data-aos-delay="1000">
            Click acá para que no te claven el visto
        </a>
    </div>
</section>
