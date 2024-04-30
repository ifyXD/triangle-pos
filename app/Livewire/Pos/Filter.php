<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use Modules\Product\Entities\Category;

class Filter extends Component
{
    public $categories;
    public $category;
    public $showCount;

    public function mount($categories)
    {
        $this->categories = $categories;
    }

    public function render()
    {
        $user = auth()->user();

        $this->categories = Category::when(!$user->hasRole('Super Admin'), function ($query) use ($user) {
            return $query->where('store_id', $user->store->id);
        })->get();

        return view('livewire.pos.filter');
    }

    public function updatedCategory()
    {
        $this->dispatch('selectedCategory', $this->category);
    }

    public function updatedShowCount()
    {
        $this->dispatch('showCount', $this->category);
    }
}
