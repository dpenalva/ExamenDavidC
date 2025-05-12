<template>
    <Head title="Editar Anuncis" />
    
    <Anuncislayout>
        <h1 style="text-align: center; color: orange; font-size: 24px; margin-bottom: 20px;">Editar Anuncis</h1>
        
        <form @submit.prevent="submit" style="width: 80%; margin: 0 auto; background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd;">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <!-- Nombre -->
                <div style="margin-bottom: 15px;">
                    <label for="Titol" style="display: block; margin-bottom: 5px; font-weight: bold;">Títol:</label>
                    <input id="Titol" v-model="form.Titol" type="text" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                    <div v-if="form.errors.Titol" style="color: red; margin-top: 5px;">{{ form.errors.Titol }}</div>
                </div>
                
                <!-- Marca -->
                <div style="margin-bottom: 15px;">
                    <label for="descripció" style="display: block; margin-bottom: 5px; font-weight: bold;">Descripció:</label>
                    <input id="descripció" v-model="form.descripció" type="text" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                    <div v-if="form.errors.descripció" style="color: red; margin-top: 5px;">{{ form.errors.descripció }}</div>
                </div>
                
                <!-- Categoría -->
                <div style="margin-bottom: 15px;">
                    <label for="categoria" style="display: block; margin-bottom: 5px; font-weight: bold;">Categoría:</label>
                    <select id="categoria" v-model="form.categoria" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required>
                        <option value="" disabled>Selecciona una categoría</option>
                        <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">{{ categoria.nombre }}</option>
                    </select>
                    <div v-if="form.errors.categoria_id" style="color: red; margin-top: 5px;">{{ form.errors.categoria_id }}</div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="hora" style="display: block; margin-bottom: 5px; font-weight: bold;">Hora:</label>
                    <input id="hora" v-model="form.hora" type="hore" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                    <div v-if="form.errors.hora" style="color: red; margin-top: 5px;">{{ form.errors.hora }}</div>
                </div>
                
                <!-- Talla -->
                <div style="margin-bottom: 15px;">
                    <label for="date" style="display: block; margin-bottom: 5px; font-weight: bold;">Fecha:</label>
                    <input id="date" v-model="form.date" type="date" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                    <div v-if="form.errors.date" style="color: red; margin-top: 5px;">{{ form.errors.date }}</div>
                </div>
                
            
                
            </div>
            
            <div style="text-align: center; margin-top: 20px;">
                <Link :href="route('anuncis.index')" style="background-color: #767676; color: white; padding: 10px 15px; text-decoration: none; display: inline-block; margin-right: 10px;">
                    Cancelar
                </Link>
                <button type="submit" style="background-color: #c85200; color: white; padding: 10px 15px; border: none; cursor: pointer;">
                    Actualizar
                </button>
            </div>
        </form>
    </Anuncislayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Anuncislayout from '@/layouts/anuncislayout.vue';


const props = defineProps({
    anunci: Object,
    categorias: Array
});

const form = useForm({
    Titol: props.anunci.Titol,
    descripció: props.anunci.descripció,
    categoria:props.anunci.categoria_id,
    email: props.anunci.email,
    date: props.anunci.date,
    hora: props.anunci.hora,
    categoria_id: props.anunci.categoria_id
});

const submit = () => {
    form.put(route('anuncis.update', props.anuncis.id));
};
</script> 