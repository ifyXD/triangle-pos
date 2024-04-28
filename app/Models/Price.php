<?php

namespace App\Models;

use App\Models\Figures\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'unit_id', 'product_cost', 'product_price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
