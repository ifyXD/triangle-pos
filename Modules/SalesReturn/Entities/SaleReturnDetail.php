<?php

namespace Modules\SalesReturn\Entities;

use App\Models\Price;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;
use Modules\Setting\Entities\Unit;

class SaleReturnDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['product', 'unit', 'price'];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function unit() {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
    public function price() {
        return $this->belongsTo(Price::class, 'price_id', 'id');
    }


    public function saleReturn() {
        return $this->belongsTo(SaleReturnPayment::class, 'sale_return_id', 'id');
    }

    // public function getPriceAttribute($value) {
    //     return $value / 100;
    // }

    // public function getUnitPriceAttribute($value) {
    //     return $value / 100;
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
