<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'product_id',
        'unit_id',
        'product_quantity',
        'product_stock_alert',
        'store_id',
        'stock_id',
    ];

    use HasFactory;

    public function unit()
    {
        return $this->hasOne(User::class, 'unit_id', 'id');
    }
}
