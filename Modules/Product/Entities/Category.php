<?php

namespace Modules\Product\Entities;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function products() {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
