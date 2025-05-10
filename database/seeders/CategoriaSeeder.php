<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Vehicles',
                'descripcion' => 'Z'
            ],
            [
                'nombre' => 'Inmobiliària',
                'descripcion' => 'Z'
            ],
            [
                'nombre' => 'Feina',
                'descripcion' => 'Z'
            ],
            [
                'nombre' => 'Tecnologia',
                'descripcion' => 'C'
            ],
            [
                'nombre' => 'Moda i Complements',
                'descripcion' => 'C'
            ],
            [
                'nombre' => 'Llar i jardí',
                'descripcion' => 'C'
            ],
            [
                'nombre' => 'Esports i Oci',
                'descripcion' => 'C'
            ],
            [
                'nombre' => 'Mascotes',
                'descripcion' => 'C'
            ],
            [
                'nombre' => 'Serveis',
                'descripcion' => 'C'
            ],
            [
                'nombre' => 'Altres',
                'descripcion' => 'C'
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
