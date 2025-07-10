<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function report(Request $request)
    {
        $selected_year = $request->input('year') ?? Carbon::now()->year;

        $startDate = Carbon::createFromDate($selected_year, 1, 1)->startOfYear();
        $endDate = $startDate->copy()->endOfYear();

        $items = Item::with(['stockcard' => function ($query) use ($startDate, $endDate) {
            $query->where('type', 'OUT')
                ->whereBetween('created_at', [$startDate, $endDate]);
        }])->get();

        return view('report', compact('items', 'selected_year'));
    }
}
