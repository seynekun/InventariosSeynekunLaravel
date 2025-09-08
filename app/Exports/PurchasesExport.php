<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PurchasesExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $purchases;
    public function __construct($purchases)
    {
        $this->purchases = $purchases->map(function ($purchase) {
            return [
                $purchase->id,
                $purchase->date,
                $purchase->serie,
                $purchase->correlative,
                $purchase->supplier->identity->name,
                $purchase->supplier->document_number,
                $purchase->supplier->name,
                $purchase->total,
            ];
        });
    }

    public function collection()
    {
        return $this->purchases;
    }

    public function headings(): array
    {
        return [
            [
                'ID',
                'Fecha',
                'Serie',
                'Correlativo',
                'Proveedor',
                'N° Doc',
                'Nombre',
                'Total',
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
