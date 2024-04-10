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
            'products.product_quantity',
            'products.product_name',
            DB::raw('MIN(prices.product_price) as min_price'),
            DB::raw('MAX(prices.product_price) as max_price'),
            DB::raw("GROUP_CONCAT(CONCAT(prices.product_unit, ':', prices.product_price) SEPARATOR '|') as all_prices")
        )
        ->groupBy('products.id', 'products.product_name', 'products.product_quantity');
        
       





        // Apply hasRole check for 'Super Admin'
        if (auth()->user()->hasRole('Super Admin')) {
            $products = $products->paginate($this->limit);
        } else {
            $products = $products->where('user_id', auth()->user()->id)->orWhere('user_id', 1)->paginate($this->limit);
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
