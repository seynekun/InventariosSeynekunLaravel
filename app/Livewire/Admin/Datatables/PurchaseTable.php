<?php

namespace App\Livewire\Admin\Datatables;

use App\Exports\PurchasesExport;
use App\Models\Purchase;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;

class PurchaseTable extends DataTableComponent
{
    // protected $model = PurchaseOrder::class;

    public function builder(): Builder
    {
        return Purchase::query()->with(['supplier']);
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
            }),
            MultiSelectFilter::make('Proveedor')
                ->options(
                    Supplier::query()
                        ->orderBy('name')
                        ->get()
                        ->keyBy('id')
                        ->map(fn($tag) => $tag->name)
                        ->toArray()
                )->filter(function ($query, array $selected) {
                    $query->whereIn('supplier_id', $selected);
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
                ->searchable()
                ->sortable(),
            Column::make("Total", "total")
                ->sortable()->format(fn($value) => 'COP ' . number_format($value, 2, '.', ',')),
            Column::make('Acciones', 'actions')->label(
                function ($row) {
                    return view('admin.purchases.actions', ['purchase' => $row]);
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
        $purchasesOrder = count($selected)  ? Purchase::whereIn('id', $selected)->with(['supplier.identity'])->get() : Purchase::with(['supplier.identity'])->get();
        return Excel::download(new PurchasesExport($purchasesOrder), 'Compras.xlsx');
    }



    // Propiedades

    public $form = [
        'open' => false,
        'document' => '',
        'client' => '',
        'email' => '',
        'model' => null,
        'view_pdf_patch' => 'admin.purchases.pdf',
    ];

    // Metodo
    public function openModal(Purchase $purchase)
    {
        $this->form['open'] = true;
        $this->form['document'] = 'Compra ' . '-' . $purchase->correlative;
        $this->form['client'] = $purchase->supplier->document_number . ' - ' . $purchase->supplier->name;
        $this->form['email'] = $purchase->supplier->email;
        $this->form['model'] = $purchase;
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
