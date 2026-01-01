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

        return view('dashboard', compact(
            'items',
            'totalCost',
            'monthlyCapital',
            'monthlyItems'
        ));
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'Logout successful');
    }
}
