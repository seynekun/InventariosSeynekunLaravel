<?php

namespace App\Livewire\Admin\Datatables;

use App\Exports\SuppliersExport;
use App\Models\Supplier;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class SupplierTable extends DataTableComponent
{
    protected $model = Supplier::class;

    public function builder(): Builder
    {
        return Supplier::query()->with(['identity']);
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
                return view('admin.suppliers.actions', ['supplier' => $row]);
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
        $suppliers = count($selected)  ? Supplier::whereIn('id', $selected)->with(['identity'])->get() : Supplier::with(['identity'])->get();
        return Excel::download(new SuppliersExport($suppliers), 'proveedores.xlsx');
    }
}
