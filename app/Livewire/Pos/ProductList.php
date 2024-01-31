<?php

namespace App\Livewire\Pos;

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

    public function mount($categories) {
        $this->categories = $categories;
        $this->category_id = '';
    }

    public function render() {
        $products = Product::when($this->category_id, function ($query) {
            return $query->where('category_id', $this->category_id);
        });

        // Apply hasRole check for 'Super Admin'
        if (auth()->user()->hasRole('Super Admin')) {
            $products = $products->paginate($this->limit);
        } else {
            $products = $products->where('user_id', auth()->user()->id)->orWhere('user_id', 1)->paginate($this->limit);
        }

        return view('livewire.pos.product-list', ['products' => $products]);
    }

    public function categoryChanged($category_id) {
        $this->category_id = $category_id;
        $this->resetPage();
    }

    public function showCountChanged($value) {
        // Apply hasRole check for 'Super Admin'
        if (auth()->user()->hasRole('Super Admin')) {
            $this->limit = $value;
            $this->resetPage();
        }
    }

    public function selectProduct($product) {
        // Apply hasRole check for 'Super Admin'
        if (!auth()->user()->hasRole('Super Admin')) {
            $this->dispatch('productSelected', $product);
        }
    }
}
