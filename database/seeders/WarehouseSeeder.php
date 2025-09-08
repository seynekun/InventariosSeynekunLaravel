<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Warehouse::create([
            'name' => 'Almacen Principal',
            'location' => 'Calle Principal 123, ciudad, país',
        ]);
        Warehouse::create([
            'name' => 'Almacen de Compras Secundario',
            'location' => 'Calle Principal 123, ciudad, país',
        ]);
    }
}
