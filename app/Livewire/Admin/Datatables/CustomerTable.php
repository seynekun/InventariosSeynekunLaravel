<?php

namespace App\Livewire\Admin\Datatables;

use App\Exports\CustomersExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class CustomerTable extends DataTableComponent
{
    protected $model = Customer::class;

    public function builder(): Builder
    {
        return Customer::query()->with(['identity']);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Tipo Doc", "identity.name")
                ->searchable()
                ->sortable(),
            Column::make("Num Doc", "document_number")
                ->searchable()
                ->sortable(),
            Column::make("Razón Social", "name")
                ->sortable(),
            Column::make("Correo", "email")
                ->sortable(),
            Column::make("Telefono", "phone")
                ->sortable(),
            Column::make('Acciones')->label(function ($row) {
                return view('admin.customers.actions', ['customer' => $row]);
            })
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
        $customers = count($selected)  ? Customer::whereIn('id', $selected)->with(['identity'])->get() : Customer::with(['identity'])->get();
        return Excel::download(new CustomersExport($customers), 'clientes.xlsx');
    }
}
