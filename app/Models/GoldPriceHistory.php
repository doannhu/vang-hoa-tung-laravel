<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldPriceHistory extends Model
{
    use HasFactory;

    protected $table = 'gold_price_history';

    protected $fillable = [
        'gold_price_id',
        'type',
        'buy_price',
        'sell_price',
        'date',
        'updated_by'
    ];

    protected $casts = [
        'buy_price' => 'float',
        'sell_price' => 'float',
        'date' => 'date',
        'updated_at' => 'datetime'
    ];

    public function goldPrice()
    {
        return $this->belongsTo(GoldPrice::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
} 