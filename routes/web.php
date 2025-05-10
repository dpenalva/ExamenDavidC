<?php

use App\Http\Controllers\Auth\Settings\ProfileController;
use App\Http\Controllers\Auth\Settings\PasswordController;
use App\Http\Controllers\Auth\SettingsController;
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


Route::middleware('auth')->group(function () {
    Route::get('/settings', [SettingsController::class, 'profile'])->name('settings.index');
    Route::get('/settings/password', [PasswordController::class, 'edit'])->name('settings.password');
    Route::put('/settings/password', [PasswordController::class, 'update'])->name('password.update');
    Route::get('/settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/settings/appearance', [SettingsController::class, 'appearance'])->name('settings.appearance');
});

require __DIR__.'/auth.php';
