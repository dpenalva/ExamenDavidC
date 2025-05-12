<?php

use App\Http\Controllers\AnuncisController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Anuncis;
use App\Models\Categoria;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'anuncisDestacados' => Anuncis::inRandomOrder()->limit(5)->get(),
        'categorias' => Categoria::withCount('anuncis')->get()
    ]);
})->name('home');

// Redirección desde dashboard a zapatos
Route::get('/dashboard', function () {
    return redirect()->route('anuncis.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ruta para buscar zapatos - DEBE IR ANTES DE LAS RUTAS DE RESOURCE
Route::get('/anuncis/buscar',[AnuncisController::class,'search'])->name('anuncis.buscar');

// Rutas para el CRUD de zapatos
Route::resource('anuncis', AnuncisController::class)->middleware('auth');

// Rutas para el CRUD de categorías
Route::resource('categorias', CategoriaController::class);

// Incluir las rutas de configuración desde settings.php
require __DIR__.'/settings.php';

// Incluir las rutas de autenticación
require __DIR__.'/auth.php';
