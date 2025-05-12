<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anuncis extends Model
{
    use HasFactory;
    
    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Titol',
        'descripció',
        'email',
        'date',
        'hora',
        'categoria_id',
    ];

    /**
     * Obtiene la categoría a la que pertenece el zapato.
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
