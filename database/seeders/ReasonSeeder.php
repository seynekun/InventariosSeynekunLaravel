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
                'name' => 'Ajuste por inventario',
                'type' => 1
            ],
            [
                'name' => 'Devolución de cliente',
                'type' => 1
            ],

            [
                'name' => 'Producción terminada',
                'type' => 1
            ],
            [
                'name' => 'Error en salida anterior',
                'type' => 1
            ],

            // Razones para salida

            [
                'name' => 'Ajuste por inventario',
                'type' => 2
            ],
            [
                'name' => 'Merma o deterioro',
                'type' => 2
            ],

            [
                'name' => 'Consumo interno',
                'type' => 2
            ],
            [
                'name' => 'Caducidad',
                'type' => 2
            ]

        ];
        foreach ($reasons as $reason) {
            Reason::create($reason);
        }
    }
}
