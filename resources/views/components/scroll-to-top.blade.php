<button x-data="{ show: false }" x-show="show" x-init="window.addEventListener('scroll', () => show = window.scrollY > 300)"
    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
    class="fixed bottom-5 right-5 z-50 bg-yellow px-4 py-2 rounded-full border-2 border-yellow hover:bg-black hover:text-yellow transition duration-150 ease-in-out"
    aria-label="Volver arriba" x-cloak>
    <i class="fas fa-arrow-up" aria-hidden="true"></i>
</button>
