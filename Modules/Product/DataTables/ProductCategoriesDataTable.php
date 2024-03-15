<?php

namespace Modules\Product\DataTables;

use Modules\Product\Entities\Category;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductCategoriesDataTable extends DataTable
{

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                return view('product::categories.partials.actions', compact('data'));
            });
         
    }


    public function query(Category $model)
    {
        $user = auth()->user();

        // Check if the user has the role "Super Admin"
        if ($user->hasRole('Super Admin')) {
            return $model->newQuery()->withCount('products')->orderBy('category_name');
        }

        // If not "Super Admin," apply the original condition
        return $model->newQuery()
            ->withCount('products')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('user_id', 1);
            })
            ->orderBy('category_name');
    } 

    public function html()
    {
        $auth = auth()->user()->id;
        $route = route('category.printToExcel.id', $auth);
        return $this->builder()
            ->setTableId('product_categories-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>>" .
                    "'tr'" .
                    "<'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
            ->orderBy(4)
            ->buttons(
                "<a href='{$route}' class='btn btn-primary'><i class='bi bi-file-earmark-excel-fill'></i> Excel</a>",
                Button::make('print')
                    ->text('<i class="bi bi-printer-fill border"></i> Print'),
                Button::make('reset')
                    ->text('<i class="bi bi-x-circle"></i> Reset'),
                Button::make('reload')
                    ->text('<i class="bi bi-arrow-repeat"></i> Reload')
            );
        
    }

    protected function getColumns()
    {
        return [
            Column::make('category_code')
                ->addClass('text-center')
                ->searchable(true),
    
            Column::make('category_name')
                ->addClass('text-center')
                ->searchable(true),
    
            Column::make('products_count')
                ->addClass('text-center')
                ->searchable(false), // Assuming you don't want to search on products_count
    
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->searchable(false), // Assuming you don't want to search on actions
    
            Column::make('created_at')
                ->visible(false)
                ->searchable(false), // Assuming you don't want to search on created_at
        ];
    }
    

    protected function filename(): string
    {
        return 'ProductCategories_' . date('YmdHis');
    }
}
