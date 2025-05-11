<template>
    <Head title="Listado de Anuncios" />
    
    <anuncisLayout>
        <h1 style="text-align: center; color: #2b72e6; margin-bottom: 15px; font-size: 32px;">Listado de Anuncios</h1>
        
        <div v-if="$page.props.flash && $page.props.flash.success" style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; margin-bottom: 15px;">
            {{ $page.props.flash.success }}
        </div>
        <!-- Buscador -->
        <div style="width: 100%; margin-bottom: 18px; padding: 10px;">
            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                <label for="busqueda-input" style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">Buscar zapatos</label>
                <input 
                    id="busqueda-input"
                    type="text" 
                    v-model="busqueda" 
                    placeholder="Buscar zapatos..." 
                    style="flex-grow: 1; padding: 10px; border: 1px solid #767676;"
                    @input="buscarConAxios"
                    aria-label="Buscar zapatos por nombre, marca, talla, color, precio o stock"
                />
            </div>
        </div>
        
        <!-- Filtro por Categoría -->
        <div style="width: 100%; margin-bottom: 12px; padding: 10px;">
            <div style="display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
                <label for="categoria-select" style="min-width: 120px;">Filtrar por categoría:</label>
                <select 
                    id="categoria-select"
                    v-model="categoriaSeleccionada" 
                    style="flex-grow: 1; padding: 8px; border: 1px solid #767676;" 
                    @change="buscarConAxios"
                    aria-label="Filtrar zapatos por categoría"
                >
                    <option value="">Todas las categorías</option>
                    <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                        {{ categoria.nombre }}
                    </option>
                </select>
            </div>
        </div>
        
        <!-- Tabla Responsiva -->
        <div style="overflow-x: auto; margin-bottom: 20px; border: 1px solid #ddd;">
            <table style="width: 100%; border-collapse: collapse;" aria-label="Listado de zapatos">
                <caption style="position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;">Listado de zapatos disponibles</caption>
                <thead style="background-color: white;">
                    <tr>
                        <th scope="col" style="border: 1px solid #ddd; padding: 5px; text-align: center; color: black;">ID</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Títol</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Descripció</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Categoría</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Email</th>
                        <th scope="col" style="border: 1px solid #ddd; padding: 8px; text-align: center; color: black;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(zapato, index) in zapatosFiltrados" :key="zapato.id" style="border: 1px solid #ddd;" :style="index % 2 === 0 ? 'background-color: #f2f2f2;' : 'background-color: white;'">
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ zapato.id }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.nombre }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.marca }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px;">{{ zapato.categoria ? zapato.categoria.nombre : 'Sin categoría' }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ zapato.talla }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">{{ zapato.stock }}</td>
                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                            <Link 
                                :href="route('zapatos.show', zapato.id)" 
                                style="background-color: #2b72e6; color: white; padding: 5px; text-decoration: none; margin-right: 3px; display: inline-block;"
                                aria-label="Ver detalles del zapato"
                            >
                                Ver
                            </Link>
                            <Link 
                                :href="route('zapatos.edit', zapato.id)" 
                                style="background-color: #c85200; color: white; padding: 5px; text-decoration: none; margin-right: 3px; display: inline-block;"
                                aria-label="Editar zapato"
                            >
                                Editar
                            </Link>
                            <button 
                                @click="eliminarZapato(zapato.id)" 
                                style="background-color: #e00; color: white; padding: 5px; border: none; cursor: pointer;"
                                aria-label="Eliminar zapato"
                            >
                                Eliminar
                            </button>
                        </td>
                    </tr>
                    <tr v-if="zapatosFiltrados.length === 0">
                        <td colspan="9" style="border: 1px solid #ddd; padding: 15px; text-align: center; color: #666;">No se encontraron anuncios</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Paginación Accesible -->
        <nav v-if="zapatos.links && zapatos.links.length > 3" style="display: flex; flex-direction: column; align-items: center; margin-bottom: 20px;" aria-label="Paginación de zapatos">
            <div style="display: flex; justify-content: center; margin: 10px 0;">
                <Link 
                    v-for="(link, i) in zapatos.links" 
                    :key="i"
                    :href="link.url ? link.url : '#'"
                    :style="{
                        padding: '8px 12px',
                        margin: '0 2px',
                        border: '1px solid #ccc',
                        backgroundColor: link.active ? '#2b72e6' : 'white',
                        color: link.active ? 'white' : '#2b72e6',
                        textDecoration: 'none',
                        cursor: link.url ? 'pointer' : 'not-allowed',
                        opacity: link.url ? '1' : '0.5'
                    }"
                    :aria-current="link.active ? 'page' : undefined"
                    :aria-disabled="!link.url"
                    :tabindex="link.url ? 0 : -1"
                    v-html="link.label"
                ></Link>
            </div>
            <div style="font-size: 14px; color: #666; margin-top: 8px;" aria-live="polite">
                Mostrando {{ zapatos.from }} a {{ zapatos.to }} de {{ zapatos.total }} zapatos
            </div>
        </nav>
        
        <div style="text-align: center; margin-top: 20px;">
            <Link 
                :href="route('zapatos.create')" 
                style="background-color: #008933; color: white; padding: 10px 15px; text-decoration: none; display: inline-block;"
                aria-label="Añadir Nuevo Anuncio"
            >
            Añadir Nuevo Anuncio
            </Link>
        </div>
    </anuncisLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import anuncisLayout from '@/layouts/anuncislayout.vue';
import { router } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    zapatos: Object,
    categorias: Array,
    filters: Object
});

// Variables
const busqueda = ref('');
const categoriaSeleccionada = ref('');
const zapatosFiltrados = ref([]);
const cargando = ref(false);
let timeoutId = null;

// Inicializar datos
onMounted(() => {
    if (props.filters) {
        busqueda.value = props.filters.search || '';
        categoriaSeleccionada.value = props.filters.categoria || '';
    }
    zapatosFiltrados.value = props.zapatos.data || [];
});

// Buscar con Axios y delay
function buscarConAxios() {
        
        axios.get(route('zapatos.buscar'), {
            params: {
                q: busqueda.value,
                categoria: categoriaSeleccionada.value
            }
        })
        .then(response => {
            zapatosFiltrados.value = response.data;
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al buscar zapatos');
        })
        .finally(() => {
            cargando.value = false;
        });
}

// Eliminar zapato con Axios - versión ultra simple
function eliminarZapato(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este zapato?')) {
        axios.post(`/zapatos/${id}`, {
            _method: 'DELETE'
        })
            .then(() => zapatosFiltrados.value = zapatosFiltrados.value.filter(zapato => zapato.id !== id))
            .catch(() => alert('Error al eliminar'));
    }
}
</script>