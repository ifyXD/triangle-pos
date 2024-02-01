<?php

namespace Modules\Setting\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Currency\Entities\Currency;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['currency'];

    public function currency() {
        return $this->belongsTo(Currency::class, 'default_currency_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
