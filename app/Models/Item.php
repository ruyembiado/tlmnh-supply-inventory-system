<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'item_name',
        'category',
        'stock_no',
        'restock_point',
        'unit_cost',
        'quantity',
        'unit',
        'description',
        'remarks',
    ];

    public function stockcard()
    {
        return $this->hasMany(StockCard::class);
    }
}
