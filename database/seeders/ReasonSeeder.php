<?php

namespace Database\Seeders;

use App\Models\Reason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Razones para ingreso
        $reasons = [


            [
                'name' => 'Compra a proveedor',
                'type' => 1,
            ],
            [
                'name' => 'Devolución de cliente',
                'type' => 1,
            ],
            [
                'name' => 'Producción terminada',
                'type' => 1,
            ],
            [
                'name' => 'Ajuste positivo de inventario',
                'type' => 1,
            ],
            [
                'name' => 'Error en salida previa',
                'type' => 1,
            ],

            [
                'name' => 'Venta a cliente',
                'type' => 2,
            ],
            [
                'name' => 'Consumo interno',
                'type' => 2,
            ],
            [
                'name' => 'Merma o deterioro',
                'type' => 2,
            ],
            [
                'name' => 'Caducidad de producto',
                'type' => 2,
            ],
            [
                'name' => 'Ajuste negativo de inventario',
                'type' => 2,
            ],
        ];
        foreach ($reasons as $reason) {
            Reason::create($reason);
        }
    }
}
