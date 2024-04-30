<?php

namespace App\Livewire\Pos;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Product\Entities\Product;

class ProductList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'selectedCategory' => 'categoryChanged',
        'showCount'        => 'showCountChanged'
    ];

    public $categories;
    public $category_id;
    public $limit = 9;
    public $product_selected_price = 0;

    public function mount($categories)
    {
        $this->categories = $categories;
        $this->category_id = '';
    }

    public function render()
    {

        $products = Product::when($this->category_id, function ($query) {
            return $query->where('category_id', $this->category_id);
        })
            ->leftJoin('prices', 'prices.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.product_name',
                DB::raw('MIN(prices.product_price) as min_price'),
                DB::raw('MAX(prices.product_price) as max_price'),
                 
            )
            ->groupBy('products.id', 'products.product_name');

        // Apply hasRole check for 'Super Admin'
        if (auth()->user()->hasRole('Super Admin')) {
            $products = $products->paginate($this->limit);
        } else {
            $products = $products->where('store_id', auth()->user()->store->id)->paginate($this->limit);
        }

        return view('livewire.pos.product-list', ['products' => $products]);
    }

    public function categoryChanged($category_id)
    {
        $this->category_id = $category_id;
        $this->resetPage();
    }

    public function showCountChanged($value)
    {
        // Apply hasRole check for 'Super Admin'

        $this->limit = $value;
        $this->resetPage();
    }

    public function selectProduct($product)
    {
        // Apply hasRole check for 'Super Admin' 
        $this->dispatch('productSelected', $product);

        // dd($product);
    }
}
