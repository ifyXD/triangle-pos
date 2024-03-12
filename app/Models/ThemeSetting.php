<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'sidebar_color',
        'color_palette',
        'user_id',
    ];

    public function usertheme()
    {
        return $this->belongsTo(User::class);
    }
    
}
