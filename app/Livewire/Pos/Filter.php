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
            return $query->where('user_id', $user->id)
                         ->where('user_id', '=', 1);
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
