<?php

namespace App\Http\Controllers;

use App\Models\Item;
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
        $totalCost = 0;

        foreach ($items as $item) {
            $totalQuantity = $item->stockcard->sum('issue');
            $unitCost = $item->unit_cost ?? 0;
            $itemTotalCost = $totalQuantity * $unitCost;
            $totalCost += $itemTotalCost;
        }

        return view('dashboard', compact('items', 'totalCost'));
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'Logout successful');
    }
}
