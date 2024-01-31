<?php

namespace App\Livewire\Pos;

use Livewire\Component;
use Modules\Product\Entities\Category;

class Filter extends Component
{
    public $categories; 
    public $category;
    public $showCount;

    public function mount($categories) { 
        $this->categories = $categories; 
    }

    public function render() {
        $user = auth()->user();
        // Check if the user has the 'Super Admin' role
        if (!$user->hasRole('Super Admin')) {
            $this->categories = Category::where('user_id', $user->id)->orWhere('user_id',1)->get();
        }
        return view('livewire.pos.filter');
    }

    public function updatedCategory() {
        $this->dispatch('selectedCategory', $this->category);
    }

    public function updatedShowCount() {
        $this->dispatch('showCount', $this->category);
    }
}
