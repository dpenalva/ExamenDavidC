<template>
    <Head title="Detalles de Anuncio" />
    
    <anuncisLayout>
        <h1 style="text-align: center; color: purple; font-size: 24px; margin-bottom: 20px;">Detalles del Anuncio</h1>
        
        <div style="width: 80%; margin: 0 auto; background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">ID:</h3>
                    <p style="font-size: 18px;">{{ anunci.id }}</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Titol:</h3>
                    <p style="font-size: 18px;">{{ anunci.Titol }}</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Descripció:</h3>
                    <p style="font-size: 18px;">{{ anunci.descripció }}</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Categoría:</h3>
                    <p style="font-size: 18px;">{{ anunci.categoria ? anunci.categoria.nombre : 'Sin categoría' }}</p>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">hora:</h3>
                    <p style="font-size: 18px;">{{ anunci.hora }}</p>
                </div>

                                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Data:</h3>
                    <p style="font-size: 18px;">{{ anunci.date }}</p>
                </div>
                
                
                <div style="margin-bottom: 15px;">
                    <h3 style="font-size: 14px; font-weight: bold; color: #666; margin-bottom: 5px;">Fecha de creación:</h3>
                    <p style="font-size: 18px;">{{ new Date(anunci.created_at).toLocaleString() }}</p>
                </div>
            </div>

        </div>
    </anuncisLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import anuncisLayout from '@/layouts/anuncislayout.vue';

const props = defineProps({
    anunci: Object
});
</script> 