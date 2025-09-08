<?php

namespace App\Livewire\Admin\Datatables;

use App\Exports\QuotesExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PurchaseOrder;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class QuoteTable extends DataTableComponent
{
    // protected $model = PurchaseOrder::class;
    public function builder(): Builder
    {
        return Quote::query()->with(['customer']);
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
                    return view('admin.quotes.actions', ['quote' => $row]);
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
        $quotes = count($selected)  ? Quote::whereIn('id', $selected)->with(['customer.identity'])->get() : Quote::with(['customer.identity'])->get();
        return Excel::download(new QuotesExport($quotes), 'cotizaciones.xlsx');
    }



    public $form = [
        'open' => false,
        'document' => '',
        'client' => '',
        'email' => '',
        'model' => null,
        'view_pdf_patch' => 'admin.quotes.pdf',
    ];

    // Metodo
    public function openModal(Quote $quote)
    {
        $this->form['open'] = true;
        $this->form['document'] = 'Cotización ' . '-' . $quote->correlative;
        $this->form['client'] = $quote->customer->document_number . ' - ' . $quote->customer->name;
        $this->form['email'] = $quote->customer->email;
        $this->form['model'] = $quote;
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
