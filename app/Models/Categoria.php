<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    
    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
    ];

    /**
     * Obtiene los zapatos relacionados con esta categoría.
     */
    public function anuncis()
    {
        return $this->hasMany(Anuncis::class);
    }
} 