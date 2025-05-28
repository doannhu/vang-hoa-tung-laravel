<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'buy_price',
        'sell_price',
        'order',
    ];

    protected $casts = [
        'buy_price' => 'float',
        'sell_price' => 'float',
        'order' => 'integer',
        'updated_at' => 'datetime'
    ];
} 