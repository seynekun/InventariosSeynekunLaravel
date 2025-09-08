<?php

namespace App\Livewire\Admin\Datatables;

use App\Exports\PurchaseOrdersExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class PurchaseOrderTable extends DataTableComponent
{
    // protected $model = PurchaseOrder::class;

    public function builder(): Builder
    {
        return PurchaseOrder::query()->with(['supplier']);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
        // $this->setAdditionalSelects([
        //     'purchase_orders.id',
        // ]);
        $this->setConfigurableAreas([
            'after-wrapper' => [
                'admin.pdf.modal'
            ]
        ]);
    }

    public function filters(): array
    {
        return [
            DateRangeFilter::make('Fecha')->config(
                [
                    'placeholder' => 'Seleccione rango de fecha'
                ]
            )->filter(function ($query, array $dateRange) {
                $query->whereBetween('date', [
                    $dateRange['minDate'],
                    $dateRange['maxDate']
                ]);
            })
        ];
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make('Date', 'date')
                ->sortable()->format(fn($value) => $value->format('d/m/Y')),
            Column::make('Serie', 'serie')
                ->sortable(),
            Column::make('Correlativo', 'correlative')
                ->sortable(),
            Column::make("Document", "supplier.document_number")
                ->sortable(),
            Column::make("Razón Social", "supplier.name")
                ->sortable(),
            Column::make("Total", "total")
                ->sortable()->format(fn($value) => 'COP ' . number_format($value, 2, '.', ',')),
            Column::make('Acciones', 'actions')->label(
                function ($row) {
                    return view('admin.purchase-orders.actions', ['purchaseOrder' => $row]);
                }
            )
        ];
    }

    public function bulkActions(): array
    {
        return [
            'exportSelected' => 'Exportar',
        ];
    }

    public function exportSelected()
    {
        $selected = $this->getSelected();
        $purchasesOrder = count($selected)  ? PurchaseOrder::whereIn('id', $selected)->with(['supplier.identity'])->get() : PurchaseOrder::with(['supplier.identity'])->get();
        return Excel::download(new PurchaseOrdersExport($purchasesOrder), 'ordenesdeCompra.xlsx');
    }



    public $form = [
        'open' => false,
        'document' => '',
        'client' => '',
        'email' => '',
        'model' => null,
        'view_pdf_patch' => 'admin.purchase-orders.pdf',
    ];

    // Metodo
    public function openModal(PurchaseOrder $purchaseOrder)
    {
        $this->form['open'] = true;
        $this->form['document'] = 'Orden de compra ' . '-' . $purchaseOrder->correlative;
        $this->form['client'] = $purchaseOrder->supplier->document_number . ' - ' . $purchaseOrder->supplier->name;
        $this->form['email'] = $purchaseOrder->supplier->email;
        $this->form['model'] = $purchaseOrder;
    }

    public function sendEmail()
    {
        $this->validate([
            'form.email' => 'required|email',
        ]);
        Mail::to($this->form['email'])->send(new \App\Mail\PdfSend($this->form));

        // Llamar a un mailable
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '!Enviado!',
            'text' => 'Correo enviado con éxito',
        ]);
        $this->reset('form');
    }
}
