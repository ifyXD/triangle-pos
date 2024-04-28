<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Category;

class Store extends Model
{
    protected $fillable = ['user_id', 'store_name', 'store_email', 'store_phone', 'store_logo', 'image', 'footer_text', 'store_address'];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->hasMany(Category::class);
    }
}
