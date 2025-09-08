<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PurchaseOrdersExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $purchasesOrders;
    public function __construct($purchasesOrders)
    {
        $this->purchasesOrders = $purchasesOrders->map(function ($purchaseOrder) {
            return [
                $purchaseOrder->id,
                $purchaseOrder->date,
                $purchaseOrder->serie,
                $purchaseOrder->correlative,
                $purchaseOrder->supplier->identity->name,
                $purchaseOrder->supplier->document_number,
                $purchaseOrder->supplier->name,
                $purchaseOrder->total,
            ];
        });
    }

    public function collection()
    {
        return $this->purchasesOrders;
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
