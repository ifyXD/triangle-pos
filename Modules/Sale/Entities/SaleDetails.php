<?php

namespace Modules\Sale\Entities;

use App\Models\Price;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;

class SaleDetails extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = ['stock_id','sale_id','product_id','quantity','price_id','store_id','unit_id'];

    protected $with = ['product', 'price'];


    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function price() {
        return $this->hasOne(Price::class, 'id', 'price_id');
    }

    public function sale() {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }

    // public function getPriceAttribute($value) {
    //     return $value;
    // }

    // public function getUnitPriceAttribute($value) {
    //     return $value;
    // }


    public function getSubTotalAttribute($value) {
        return $value / 100;
    }

    public function getProductDiscountAmountAttribute($value) {
        return $value / 100;
    }

    public function getProductTaxAmountAttribute($value) {
        return $value / 100;
    }
}
