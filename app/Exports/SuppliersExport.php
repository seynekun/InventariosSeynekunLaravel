<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuppliersExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $suppliers;
    public function __construct($suppliers)
    {
        $this->suppliers = $suppliers->map(function ($supplier) {
            return [
                $supplier->id,
                $supplier->identity->name,
                $supplier->document_number,
                $supplier->name,
                $supplier->address,
                $supplier->email,
                $supplier->phone,
            ];
        });
    }

    public function collection()
    {
        return $this->suppliers;
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
