<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomersExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $customers;
    public function __construct($customers)
    {
        $this->customers = $customers->map(function ($customer) {
            return [
                $customer->id,
                $customer->identity->name,
                $customer->document_number,
                $customer->name,
                $customer->address,
                $customer->email,
                $customer->phone,
            ];
        });
    }

    public function collection()
    {
        return $this->customers;
    }

    public function headings(): array
    {
        return [
            [
                'id',
                'Identidad',
                'Número de documento',
                'Nombre',
                'Dirección',
                'Correo',
                'Teléfono',
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        $fullRange = 'A1:' . $lastColumn . $lastRow;
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startcolor' => [
                        'argb' => 'FFCCCCCC',
                    ],
                ],
                'alignment' => [
                    'horizontal' => 'center',
                ]
            ],
            $fullRange => [
                'borders' => [
                    'allborders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => [
                            'argb' => 'FF000000',
                        ],
                    ],
                ]
            ]

        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setSelectedCell('A1');
            }
        ];
    }
}
