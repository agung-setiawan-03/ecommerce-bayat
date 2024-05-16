<?php

namespace App\DataTables;

use App\Models\ProductVariantItem;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductVariantItemDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('aksi', function ($query) {
            $editBtn = "<a href='" . route('admin.products-variant-item.edit', $query->id) . "'class='btn btn-primary'><i class='fas fa-edit'></i></a>";
            $deleteBtn = "<a href='" . route('admin.products-variant-item.destroy', $query->id) . "'class='btn btn-danger ml-2 delete-item'><i class='fas fa-trash'></i></a>";
            

            return $editBtn . $deleteBtn;
        })
        ->addColumn('status', function ($query) {
            if ($query->status == 1) {
                $button = '<label class="custom-switch mt-2">
                <input type="checkbox" checked name="custom-switch-checkbox" data-id="' . $query->id . '" class="custom-switch-input change-status">
                <span class="custom-switch-indicator"></span>
              </label>';
            } else {
                $button = '<label class="custom-switch mt-2">
                <input type="checkbox" name="custom-switch-checkbox" data-id="' . $query->id . '"  class="custom-switch-input change-status">
                <span class="custom-switch-indicator"></span>
              </label>';
            }
            return $button;
        })
            ->addColumn('nama_varian', function($query){
                return $query->productVariant->nama;
            })
            ->addColumn('produk_default', function($query){
                if($query->produk_default == 1){
                    return '<i class="badge badge-success">iya</i>';
                }else{
                    return '<i class="badge badge-danger">tidak</i>';
                }
            })
            ->addColumn('harga', function ($query) {
                $hargaRupiah = number_format($query->harga, 0, ",", ".");
                return "Rp {$hargaRupiah}";
            })
            ->rawColumns(['aksi', 'status', 'produk_default', 'harga'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProductVariantItem $model): QueryBuilder
    {
        return $model->where('produk_varian_id', request()->variantId)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('productvariantitem-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(0)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('nama'),
            Column::make('nama_varian'),
            Column::make('harga'),
            Column::make('produk_default'),
            Column::make('status'),
            Column::computed('aksi')
            ->exportable(false)
            ->printable(false)
            ->width(200)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProductVariantItem_' . date('YmdHis');
    }
}
