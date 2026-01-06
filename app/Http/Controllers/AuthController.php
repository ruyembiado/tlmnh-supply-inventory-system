<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockCard;
use Carbon\Carbon;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect('/dashboard');
        }

        return view('welcome');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if (auth()->attempt($credentials)) {
            return redirect('/dashboard')->with('success', 'Login successful');
        }

        return back()->withErrors(['error' => 'The provided credentials do not match our records.']);
    }

    public function dashboard()
    {
        $items = Item::with('stockcard')->get();

        /* TOTAL CAPITAL */
        $totalCost = 0;
        foreach ($items as $item) {
            $totalQuantity = $item->stockcard->sum('issue');
            $unitCost = $item->unit_cost ?? 0;
            $totalCost += $totalQuantity * $unitCost;
        }

        $year = now()->year;

        /* MONTHLY CAPITAL */
        $monthlyCapital = array_fill(1, 12, 0);

        /* MONTHLY ITEM RELEASE COUNT */
        $monthlyItems = array_fill(1, 12, 0);

        $totalReleasedItems = Stockcard::sum('issue');

        $stockcards = Stockcard::with('item')
            ->whereYear('created_at', $year)
            ->get();

        foreach ($stockcards as $stock) {
            $month = Carbon::parse($stock->created_at)->month;

            // Capital
            $unitCost = $stock->item->unit_cost ?? 0;
            $monthlyCapital[$month] += $stock->issue * $unitCost;

            // Items released
            $monthlyItems[$month] += $stock->issue;
        }

        $topReleasedItems = Stockcard::select(
            'item_id',
            DB::raw('SUM(issue) as total_issued')
        )
            ->with('item')
            ->groupBy('item_id')
            ->whereYear('created_at', $year)
            ->orderByDesc('total_issued')
            ->limit(10)
            ->get();

        $topItemLabels = $topReleasedItems->pluck('item.item_name');
        $topItemData   = $topReleasedItems->pluck('total_issued');

        $monthlyTopItemsRaw = Stockcard::select(
            DB::raw("CAST(strftime('%m', created_at) AS INTEGER) as month"),
            'item_id',
            DB::raw('SUM(issue) as total_issued')
        )
            ->whereYear('created_at', $year)
            ->groupBy(
                DB::raw("CAST(strftime('%m', created_at) AS INTEGER)"),
                'item_id'
            )
            ->orderBy('month')
            ->orderByDesc('total_issued')
            ->get();

        $monthlyTopPerMonth = [];

        foreach ($monthlyTopItemsRaw as $row) {
            if (!isset($monthlyTopPerMonth[$row->month])) {
                $monthlyTopPerMonth[$row->month] = $row;
            }
        }

        $monthlyTopLabels    = [];
        $monthlyTopData      = [];
        $monthlyTopItemNames = [];

        foreach (range(1, 12) as $month) {
            $monthlyTopLabels[] = Carbon::create()->month($month)->format('M');

            if (isset($monthlyTopPerMonth[$month])) {
                $item = Item::find($monthlyTopPerMonth[$month]->item_id);

                $monthlyTopData[]      = $monthlyTopPerMonth[$month]->total_issued;
                $monthlyTopItemNames[] = $item->item_name ?? 'N/A';
            } else {
                $monthlyTopData[]      = 0;
                $monthlyTopItemNames[] = 'N/A';
            }
        }

        $req_items = Item::where('quantity', '<=', 20)
            ->get();

        return view('dashboard', compact(
            'items',
            'req_items',
            'totalCost',
            'monthlyCapital',
            'monthlyItems',
            'totalReleasedItems',
            'topItemLabels',
            'topItemData',
            'monthlyTopLabels',
            'monthlyTopData',
            'monthlyTopItemNames'
        ));
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'Logout successful');
    }
}
