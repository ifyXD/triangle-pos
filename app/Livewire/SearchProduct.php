<?php

namespace App\Livewire;

use App\Models\Stock;
use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Product\Entities\Product;

class SearchProduct extends Component
{
    // Query
    public $search = '';



    public $query;
    public $search_results;
    public $how_many;

    public $unitId = 0;

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

    public function updateUnitId(){
        
    }
    public function updatedQuery()
    {
        $user = auth()->user();

        $this->unitId = 0;
        // If not "Super Admin," apply the original condition with additional user_id = 1 check
        if(auth()->user()->hasRole('Super Admin')){
            $this->search_results = Product::where(function ($query) use ($user) {
                $query->where(function ($nestedQuery) {
                        $nestedQuery->where('product_name', 'like', '%' . $this->query . '%');
                    });
            })
                ->take($this->how_many)
                ->get();
        }
        else{
            $this->search_results = Product::where(function ($query) use ($user) {
                $query->where('store_id', $user->store->id)
                    ->where(function ($nestedQuery) {
                        $nestedQuery->where('product_name', 'like', '%' . $this->query . '%');
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

    public function selectProduct($id)
    {

        // dd($id);
        $this->search = '';
        $product = Stock::find($id);
        $this->dispatch('productSelected', $product);
        
    }
    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }
    public function resetFields()
    {
        $this->reset([
            'productId',
            'image',
            'oldimage',
            'product_name',
            'description',
            'product_price',
            'product_stock',
            'product_unit',
            'selectCategory',
            'categoryId',
            'store_cat_id',
        ]);

        // Increment $iteration to trigger Livewire re-render
        $this->iteration++;
    }
    public function openModal()
    {
        // $this->isOpen = true;
        $this->resetValidation();
    }
    public function closeModal()
    {
        $this->isOpen = false;
        $this->isDeleteOpen = false;
        $this->resetFields();
    }
}
