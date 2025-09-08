<?php

namespace App\Livewire\Admin\Datatables;

use App\Exports\SalesExport;
use App\Models\Purchase;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PurchaseOrder;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class SaleTable extends DataTableComponent
{
    // protected $model = PurchaseOrder::class;


    public function builder(): Builder
    {
        return Sale::query()->with(['customer']);
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
            Column::make("Document", "customer.document_number")
                ->sortable(),
            Column::make("Razón Social", "customer.name")
                ->sortable(),
            Column::make("Total", "total")
                ->sortable()->format(fn($value) => 'COP ' . number_format($value, 2, '.', ',')),
            Column::make('Acciones', 'actions')->label(
                function ($row) {
                    return view('admin.sales.actions', ['sale' => $row]);
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
        $sales = count($selected)  ? Sale::whereIn('id', $selected)->with(['customer.identity'])->get() : Sale::with(['customer.identity'])->get();
        return Excel::download(new SalesExport($sales), 'ventas.xlsx');
    }


    public $form = [
        'open' => false,
        'document' => '',
        'client' => '',
        'email' => '',
        'model' => null,
        'view_pdf_patch' => 'admin.sales.pdf',
    ];

    // Metodo
    public function openModal(Sale $sale)
    {
        $this->form['open'] = true;
        $this->form['document'] = 'Venta ' . '-' . $sale->correlative;
        $this->form['client'] = $sale->customer->document_number . ' - ' . $sale->customer->name;
        $this->form['email'] = $sale->customer->email;
        $this->form['model'] = $sale;
    }

    public function sendEmail()
    {
        $this->validate([
            'form.email' => 'required|email',
        ]);
        Mail::to($this->form['email'])->send(new \App\Mail\PdfSend($this->form));

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => '!Enviado!',
            'text' => 'Correo enviado con éxito',
        ]);
        $this->reset('form');
    }
}
