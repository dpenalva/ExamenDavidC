<template>
    <Head title="Crear Anuncio" />
    
    <anuncislayout>
        <h1 style="text-align: center; color: green; font-size: 24px; margin-bottom: 20px;">Crear Nuevo Anuncio</h1>
        
        <form @submit.prevent="submit" style="width: 80%; margin: 0 auto; background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd;">
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
                <select id="categoria" v-model="form.categoria_id" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required>
                    <option value="" disabled>Selecciona una categoría</option>
                    <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">{{ categoria.nombre }}</option>
                </select>
                <div v-if="form.errors.categoria_id" style="color: red; margin-top: 5px;">{{ form.errors.categoria_id }}</div>
            </div>
            
            <!-- Talla -->
            <div style="margin-bottom: 15px;">
                <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold;">Email:</label>
                <input id="email" v-model="form.email" type="text" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                <div v-if="form.errors.email" style="color: red; margin-top: 5px;">{{ form.errors.email }}</div>
            </div>

            <!-- Fecha -->
            <div style="margin-bottom: 15px;">
                <label for="date" style="display: block; margin-bottom: 5px; font-weight: bold;">Fecha:</label>
                <input id="date" v-model="form.date" type="date" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                <div v-if="form.errors.data" style="color: red; margin-top: 5px;">{{ form.errors.data }}</div>
            </div>

            <!-- Hora -->
            <div style="margin-bottom: 15px;">
                <label for="hora" style="display: block; margin-bottom: 5px; font-weight: bold;">Hora:</label>
                <input id="hora" v-model="form.hora" type="time" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                <div v-if="form.errors.hora" style="color: red; margin-top: 5px;">{{ form.errors.hora }}</div>
            </div>
    
            <div style="text-align: center; margin-top: 20px;">
                <Link :href="route('anuncis.index')" style="background-color: #767676; color: white; padding: 10px 15px; text-decoration: none; display: inline-block; margin-right: 10px;">
                    Cancelar
                </Link>
                <button type="submit" style="background-color: #008933; color: white; padding: 10px 15px; border: none; cursor: pointer;">
                    Guardar Anuncio
                </button>
            </div>
        </form>
    </anuncislayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import anuncislayout from '@/layouts/anuncislayout.vue';

const props = defineProps({
    categorias: Array
});

const form = useForm({
    Titol: '',
    descripció: '',
    email: '',
    date: '',
    hora: '',
    categoria_id: ''
});

const submit = () => {
    form.post(route('anuncis.store'));
};
</script> 