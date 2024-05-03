<?php

namespace App\Models;

use App\Models\Figures\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Sale\Entities\SaleDetails;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'unit_id', 'product_cost', 'product_price', 'stock_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function detail() {
        return $this->belongsTo(SaleDetails::class, 'price_id', 'id');
    }
}
