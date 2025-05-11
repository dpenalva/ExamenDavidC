<?php

use App\Http\Controllers\ZapatoController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Zapato;
use App\Models\Categoria;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'zapatosDestacados' => Zapato::inRandomOrder()->limit(5)->get(),
        'categorias' => Categoria::withCount('zapatos')->get()
    ]);
})->name('home');

// Redirección desde dashboard a zapatos
Route::get('/dashboard', function () {
    return redirect()->route('zapatos.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ruta para buscar zapatos - DEBE IR ANTES DE LAS RUTAS DE RESOURCE
Route::get('/zapatos/buscar', function(Request $request) {
    $query = $request->input('q');
    $categoria = $request->input('categoria');
    
    $zapatosQuery = Zapato::query();
    
    // Filtrar por búsqueda de texto
    if (!empty($query)) {
        $zapatosQuery->where(function($q) use ($query) {
            $q->where('nombre', 'like', "%{$query}%")
              ->orWhere('marca', 'like', "%{$query}%")
              ->orWhere('talla', 'like', "%{$query}%")
              ->orWhere('color', 'like', "%{$query}%");
        });
    }
    
    // Filtrar por categoría
    if (!empty($categoria)) {
        $zapatosQuery->where('categoria_id', $categoria);
    }
    
    // Incluir relación categoría
    $zapatos = $zapatosQuery->with('categoria')->get();
    
    return response()->json($zapatos);
})->name('zapatos.buscar');

// Rutas para el CRUD de zapatos
Route::resource('zapatos', ZapatoController::class)->middleware('auth');

// Rutas para el CRUD de categorías
Route::resource('categorias', CategoriaController::class);

// Incluir las rutas de configuración desde settings.php
require __DIR__.'/settings.php';

// Incluir las rutas de autenticación
require __DIR__.'/auth.php';
