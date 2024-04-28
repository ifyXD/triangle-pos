<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Product\Entities\Product;

class SearchProduct extends Component
{

    public $query;
    public $search_results;
    public $how_many;

    public function mount()
    {
        $this->query = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
    }

    public function render()
    {
        return view('livewire.search-product');
    }

    public function updatedQuery()
    {
        $user = auth()->user();

        // Check if the user has the role "Super Admin"
        if ($user->hasRole('Super Admin')) {
            $this->search_results = Product::where(function ($query) {
                $query->where('product_name', 'like', '%' . $this->query . '%')
                    ->orWhere('product_code', 'like', '%' . $this->query . '%');
            })
                ->take($this->how_many)
                ->get();
        } else {
            // If not "Super Admin," apply the original condition with additional user_id = 1 check
            $this->search_results = Product::where(function ($query) use ($user) {
                $query->where('store_id', $user->store->id)
                    ->where(function ($nestedQuery) {
                        $nestedQuery->where('product_name', 'like', '%' . $this->query . '%') ;
                    });
            })
                ->take($this->how_many)
                ->get();
        }
    }


    public function loadMore()
    {
        $this->how_many += 5;
        $this->updatedQuery();
    }

    public function resetQuery()
    {
        $this->query = '';
        $this->how_many = 5;
        $this->search_results = Collection::empty();
    }

    public function selectProduct($product)
    {
        $this->dispatch('productSelected', $product);
    }
}
