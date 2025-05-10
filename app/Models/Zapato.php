<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zapato extends Model
{
    use HasFactory;
    
    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'marca',
        'talla',
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
