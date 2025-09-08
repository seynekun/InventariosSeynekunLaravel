<?php

namespace App\Livewire\Admin\Datatables;

use App\Exports\MovementsExport;
use App\Models\Movement;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class MovementTable extends DataTableComponent
{
    // protected $model = PurchaseOrder::class;


    public function builder(): Builder
    {
        return Movement::query()->with(['warehouse', 'reason']);
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
            Column::make('Tipo', 'type')
                ->sortable()->format(fn($value) => match ($value) {
                    1 => 'Entrada',
                    2 => 'Salida',
                }),
            Column::make('Serie', 'serie')
                ->sortable(),
            Column::make('Correlativo', 'correlative')
                ->sortable(),
            Column::make("Almacen", "warehouse.name")
                ->sortable(),
            Column::make("Motivo", "reason.name")
                ->sortable(),
            Column::make("Total", "total")
                ->sortable()->format(fn($value) => 'COP ' . number_format($value, 2, '.', ',')),
            Column::make('Acciones', 'actions')->label(
                function ($row) {
                    return view('admin.movements.actions', ['movement' => $row]);
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
        $movements = count($selected)  ? Movement::whereIn('id', $selected)->with(['warehouse', 'reason'])->get() : Movement::with(['warehouse', 'reason'])->get();
        return Excel::download(new MovementsExport($movements), 'movimientos.xlsx');
    }

    public $form = [
        'open' => false,
        'document' => '',
        'client' => '',
        'email' => '',
        'model' => null,
        'view_pdf_patch' => 'admin.movements.pdf',
    ];

    // Metodo
    public function openModal(Movement $movement)
    {
        $this->form['open'] = true;
        $this->form['document'] = 'Movimiento ' . '-' . $movement->correlative;
        $this->form['client'] = $movement->warehouse->name;
        $this->form['email'] = '';
        $this->form['model'] = $movement;
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
