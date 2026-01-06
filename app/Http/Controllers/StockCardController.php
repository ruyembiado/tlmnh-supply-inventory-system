<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class StockCardController extends Controller
{
    public function index()
    {
        $items = Item::orderBy('stock_no', 'asc')->get();
        return view('stock_card', compact('items'));
    }

    public function show($id)
    {
        $item = Item::with('stockcard')->find($id);
        return view('view_stock_card', compact('item'));
    }
}
