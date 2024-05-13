<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLoss extends Model
{
    protected $fillable = ['sale_return_id', 'product_id','stock_id','store_id'];
    use HasFactory;
}
