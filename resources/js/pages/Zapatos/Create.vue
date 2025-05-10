<template>
    <Head title="Crear Anuncio" />
    
    <anuncislayout>
        <h1 style="text-align: center; color: green; font-size: 24px; margin-bottom: 20px;">Crear Nuevo Anuncio</h1>
        
        <form @submit.prevent="submit" style="width: 80%; margin: 0 auto; background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd;">
            <!-- Nombre -->
            <div style="margin-bottom: 15px;">
                <label for="nombre" style="display: block; margin-bottom: 5px; font-weight: bold;">Títol:</label>
                <input id="nombre" v-model="form.nombre" type="text" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                <div v-if="form.errors.nombre" style="color: red; margin-top: 5px;">{{ form.errors.nombre }}</div>
            </div>
            
            <!-- Marca -->
            <div style="margin-bottom: 15px;">
                <label for="marca" style="display: block; margin-bottom: 5px; font-weight: bold;">Descripció:</label>
                <input id="marca" v-model="form.marca" type="text" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                <div v-if="form.errors.marca" style="color: red; margin-top: 5px;">{{ form.errors.marca }}</div>
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
                <label for="talla" style="display: block; margin-bottom: 5px; font-weight: bold;">Email:</label>
                <input id="talla" v-model="form.talla" type="text" style="width: 100%; padding: 8px; border: 1px solid #ccc;" required />
                <div v-if="form.errors.talla" style="color: red; margin-top: 5px;">{{ form.errors.talla }}</div>
            </div>
    
            
            <div style="text-align: center; margin-top: 20px;">
                <Link :href="route('zapatos.index')" style="background-color: #767676; color: white; padding: 10px 15px; text-decoration: none; display: inline-block; margin-right: 10px;">
                    Cancelar
                </Link>
                <button type="submit" style="background-color: #008933; color: white; padding: 10px 15px; border: none; cursor: pointer;">
                    Guardar Zapato
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
    nombre: '',
    marca: '',
    talla: '',
    color: '',
    precio: '',
    stock: '',
    categoria_id: ''
});

const submit = () => {
    form.post(route('zapatos.store'));
};
</script> 