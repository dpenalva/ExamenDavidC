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
            ],
            [
                'nombre' => 'Inmobiliària',
            ],
            [
                'nombre' => 'Feina',
            ],
            [
                'nombre' => 'Tecnologia',
            ],
            [
                'nombre' => 'Moda i Complements',
            ],
            [
                'nombre' => 'Llar i jardí',
            ],
            [
                'nombre' => 'Esports i Oci',
            ],
            [
                'nombre' => 'Mascotes',
            ],
            [
                'nombre' => 'Serveis',
            ],
            [
                'nombre' => 'Altres',
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
