<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockCard;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::orderBy('created_at', 'desc')->get();
        return view('item', compact('items'));
    }

    public function create()
    {
        return view('add_item');
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'stock_no' => 'required|string|unique:items,stock_no|max:255',
            'restock_point' => 'nullable|integer|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string|max:255',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $item = Item::create([
            'item_name'   => $request->item_name,
            'category'    => $request->category,
            'stock_no'    => $request->stock_no,
            'restock_point' => $request->restock_point,
            'unit_cost'   => $request->unit_cost,
            'quantity'    => $request->quantity,
            'unit'        => $request->unit,
            'description' => $request->description,
            'remarks'     => $request->remarks,
        ]);

        StockCard::create([
            'item_id'  => $item->id,
            'type'     => 'IN',
            'receipt' => $item->quantity,
            'balance'  => $item->quantity,
            'date'     => now()->toDateString(),
            'purpose' => 'Initial stock',
        ]);

        return redirect('/add-item')->with('success', 'Item added successfully.');
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('edit_item', compact('item'));
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);
        return view('view_item', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'stock_no' => 'required|string|max:255|unique:items,stock_no,' . $id,
            'restock_point' => 'nullable|integer|min:0',
            'unit_cost' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string|max:255',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $item = Item::findOrFail($id);
        $oldQty = $item->quantity;
        $newQty = $request->quantity;

        $item->update([
            'item_name'   => $request->item_name,
            'category'    => $request->category,
            'stock_no'    => $request->stock_no,
            'restock_point' => $request->restock_point,
            'unit_cost'   => $request->unit_cost,
            'quantity'    => $request->quantity,
            'unit'        => $request->unit,
            'description' => $request->description,
            'remarks'     => $request->remarks,
        ]);

        if ($newQty != $oldQty) {
            $type = $newQty > $oldQty ? 'IN' : 'OUT';
            $difference = abs($newQty - $oldQty);

            StockCard::create([
                'item_id'   => $item->id,
                'type'      => $type,
                'receipt'  => $difference,
                'balance'   => $newQty,
                'date'      => now()->toDateString(),
                'purpose' => 'Manual stock adjustment',
            ]);
        }
        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Item deleted successfully.');
    }

    public function create_release()
    {
        $items = Item::orderBy('item_name', 'asc')->get();
        return view('release_item', compact('items'));
    }

    public function release(Request $request)
    {
        $request->validate([
            'item_name' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'end_user' => 'required|string',
            'purpose' => 'nullable|string',
            'reference' => 'nullable|string',
        ]);

        $item = Item::findOrFail($request->item_name);
        $item->quantity -= $request->quantity;
        $item->save();
        $newQty = $item->quantity;

        $item_id = $request->item_name;

        StockCard::create([
            'item_id'   => $item_id,
            'type'      => 'OUT',
            'issue'     => $request->quantity,
            'balance'   => $newQty,
            'date'      => now()->toDateString(),
            'end_user'   => $request->end_user,
            'purpose'   => $request->purpose,
            'reference' => $request->reference,
        ]);

        return redirect()->back()->with('success', 'Item released successfully.');
    }

    public function get_item_stock($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json(['stock' => 0]);
        }

        return response()->json(['stock' => $item->quantity]);
    }
}
