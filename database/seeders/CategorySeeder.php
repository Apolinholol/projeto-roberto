<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Categorias pré-definidas que aparecem na Home
        $categorias = [
            'Automotivos',
            'Literatura', 
            'Eletrônicos',
            'Decoração',
            'Moda'
        ];

        foreach ($categorias as $categoria) {
            Category::firstOrCreate(
                ['name' => $categoria],
                ['is_active' => true]
            );
        }
    }
}
