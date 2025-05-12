<?php

namespace App\Http\Controllers;

use App\Models\Anuncis;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnuncisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Anuncis::with('categoria');
        
        // Filtro por categoría
        if ($request->has('categoria') && $request->categoria != '') {
            $query->where('categoria_id', $request->categoria);
        }
        
        // Búsqueda por texto
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('marca', 'like', "%{$search}%")
                  ->orWhere('talla', 'like', "%{$search}%");
            });
        }
        
        // Paginar los resultados
        $anuncis = $query->paginate(3);
        
        return Inertia::render('Anuncis/Index', [
            'anuncis' => $anuncis,
            'categorias' => Categoria::all(),
            'filters' => $request->only(['search', 'categoria'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Anuncis/Create', [
            'categorias' => Categoria::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Titol' => 'required|string|max:255',
            'descripció' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'date' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        Anuncis::create($request->all());

        return redirect()->route('anuncis.index')->with('success', 'Anuncio creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Anuncis $anunci)
    {
        $anunci->load('categoria');
        
        return Inertia::render('Anuncis/Show', [
            'anunci' => $anunci
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anuncis $anunci)
    {
        return Inertia::render('Anuncis/Edit', [
            'anunci' => $anunci,
            'categorias' => Categoria::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Anuncis $anuncis)
    {
        $request->validate([
            'Titol' => 'required|string|max:255',
            'descripció' => 'required|string|max:255',
            'email' => 'required|string|max:10',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $anuncis->update($request->all());

        return redirect()->route('anuncis.index')->with('success', 'Anuncio actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anuncis $anunci)
    {
        $anunci->delete();

        return redirect()->route('anuncis.index')->with('success', 'Anuncio eliminado exitosamente.');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $categoria = $request->input('categoria');
        
        $anuncisQuery = Anuncis::query();
        
        // Filtrar por búsqueda de texto
        if (!empty($query)) {
            $anuncisQuery->where(function($q) use ($query) {
                $q->where('Titol', 'like', "%{$query}%")
                  ->orWhere('descripció', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            });
        }
        
        // Filtrar por categoría
        if (!empty($categoria)) {
            $anuncisQuery->where('categoria_id', $categoria);
        }
        
        // Incluir relación categoría
        $anuncis = $anuncisQuery->with('categoria')->get();
        
        return response()->json($anuncis);
    }
}
