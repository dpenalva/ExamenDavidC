<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import Navbar from '@/components/Navbar.vue';
import Footer from '@/components/Footer.vue';
import { ref, onMounted, computed, onBeforeUnmount } from 'vue';

const props = defineProps({
    anuncisDestacados: {
        type: Array,
        default: () => [],
    },
});

// Para el carrusel
const indiceActual = ref(0);
const totalSlides = computed(() => props.anuncisDestacados.length || 1);

function siguienteSlide() {
    indiceActual.value = (indiceActual.value + 1) % totalSlides.value;
}

function anteriorSlide() {
    indiceActual.value = (indiceActual.value - 1 + totalSlides.value) % totalSlides.value;
}

// Iniciar carrusel automático
let intervalo;
onMounted(() => {
    intervalo = setInterval(siguienteSlide, 5000); // Cambiar slide cada 5 segundos
    
    // Añadir manejadores de eventos para teclado (accesibilidad)
    document.addEventListener('keydown', manejarTeclado);
});

onBeforeUnmount(() => {
    // Limpiar intervalo y eventos cuando el componente se desmonta
    clearInterval(intervalo);
    document.removeEventListener('keydown', manejarTeclado);
});

// Manejar eventos de teclado para accesibilidad
function manejarTeclado(e) {
    // Navegación del carrusel con flechas
    if (e.key === 'ArrowLeft') {
        anteriorSlide();
    } else if (e.key === 'ArrowRight') {
        siguienteSlide();
    }
}

const irAListadoAnuncis = () => {
    router.visit(route('anuncis.index'));
};

const irACrearAnuncis = () => {
    router.visit(route('anuncis.create'));
};
</script>

<template>
    <Head title="Anuncis - Inicio" />
    
    <div style="min-height: 100vh; display: flex; flex-direction: column;">
        <Navbar />
        
        <main style="flex-grow: 1;">
            <div style="background-color: #d1d1d1; text-align: center; color: black; padding: 20px;">
                Benvinguts:
                Al mon dels anuncis 
            </div>

            <!-- Sección de Zapatos -->
            <div style="background-color: #d1d1d1; text-align: center; color: black; padding: 20px;">
                Anuncis:
                <div style="margin-top: 10px;">
                    <button @click="irACrearAnuncis" style="background-color: white; color: black; font-weight: bold; padding: 8px 15px; border: 1px solid black; margin-right: 10px; cursor: pointer;">
                        Crear
                    </button>
                    <button @click="irAListadoAnuncis" style="background-color: white; color: black; font-weight: bold; padding: 8px 15px; border: 1px solid black; cursor: pointer;">
                        Ver Lista
                    </button>
                            </div>
                            </div>
                </main>

        <Footer />
    </div>
</template>

<style>
/* Ajustes de accesibilidad */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
    }
}
</style>
