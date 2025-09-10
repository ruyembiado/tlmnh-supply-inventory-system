<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockCard extends Model
{
    use HasFactory;

    protected $table = 'stock_cards';

    protected $fillable = [
        'item_id',
        'type',
        'quantity',
        'balance',
        'date',
        'receipt',
        'issue',
        'reference',
        'end_user',
        'purpose',
        'release_date',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
