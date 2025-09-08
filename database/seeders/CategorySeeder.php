<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Eelectronicos',
                'description' => 'Articulos electrónicos',
            ],
            [
                'name' => 'Ropa',
                'description' => 'Productos de ropa',
            ],
            [
                'name' => 'Alimentos',
                'description' => 'Productos alimenticios',
            ],
            [
                'name' => 'Juguetes',
                'description' => 'Productos de juguetes',
            ],
            [
                'name' => 'Hogar',
                'description' => 'Productos de hogar',
            ]
        ];
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
