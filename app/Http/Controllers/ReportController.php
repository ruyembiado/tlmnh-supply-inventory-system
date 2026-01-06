<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\StockCard;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function report_sami(Request $request)
    {
        $selected_year = $request->input('year') ?? Carbon::now()->year;
        $selected_month = $request->input('month');

        if ($selected_month) {
            // filter by specific month
            $startDate = Carbon::createFromDate($selected_year, $selected_month, 1)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
        } else {
            // filter by entire year
            $startDate = Carbon::createFromDate($selected_year, 1, 1)->startOfYear();
            $endDate = $startDate->copy()->endOfYear();
        }

        $items = Item::with(['stockcard' => function ($query) use ($startDate, $endDate) {
            $query->where('type', 'OUT')
                ->whereBetween('release_date', [$startDate, $endDate]);
        }])->orderBy('release_date', 'desc')->get();

        $recap = $items->filter(fn($item) => $item->stockcard->sum('issue') > 0)
            ->groupBy('stock_no')
            ->map(function ($group) {
                $quantity = $group->sum(fn($i) => $i->stockcard->sum('issue'));
                $unitCost = $group->first()->unit_cost ?? 0;
                return [
                    'stock_no'  => $group->first()->stock_no,
                    'object_code'  => $group->first()->category,
                    'quantity'  => $quantity,
                    'unit_cost' => $unitCost,
                    'total_cost' => $quantity * $unitCost,
                ];
            });

        return view('report_sami', compact('items', 'recap', 'selected_year', 'selected_month'));
    }

    // public function download_sami_report(Request $request)
    // {
    //     $selected_year = $request->input('year') ?? Carbon::now()->year;
    //     $selected_month = $request->input('month');

    //     if ($selected_month) {
    //         // filter by specific month
    //         $startDate = Carbon::createFromDate($selected_year, $selected_month, 1)->startOfMonth();
    //         $endDate = $startDate->copy()->endOfMonth();
    //     } else {
    //         // filter by entire year
    //         $startDate = Carbon::createFromDate($selected_year, 1, 1)->startOfYear();
    //         $endDate = $startDate->copy()->endOfYear();
    //     }

    //     $items = Item::with(['stockcard' => function ($query) use ($startDate, $endDate) {
    //         $query->where('type', 'OUT')
    //             ->whereBetween('release_date', [$startDate, $endDate]);
    //     }])->orderBy('release_date', 'desc')->get();

    //     $recap = $items->filter(fn($item) => $item->stockcard->sum('issue') > 0)
    //         ->groupBy('stock_no')
    //         ->map(function ($group) {
    //             $quantity = $group->sum(fn($i) => $i->stockcard->sum('issue'));
    //             $unitCost = $group->first()->unit_cost ?? 0;
    //             return [
    //                 'stock_no'  => $group->first()->stock_no,
    //                 'quantity'  => $quantity,
    //                 'unit_cost' => $unitCost,
    //                 'total_cost' => $quantity * $unitCost,
    //             ];
    //         });

    //     // $pdf = Pdf::loadView('pdf.sami', compact('items', 'recap', 'selected_year', 'selected_month'
    //     // ))->setPaper('letter', 'portrait');

    //     // return $pdf->download('sami-report.pdf');

    //     return view('pdf.sami', compact('items', 'recap', 'selected_year', 'selected_month'));
    // }

    // public function report_item_requisition(Request $request)
    // {
    //     $selected_year = $request->input('year') ?? Carbon::now()->year;
    //     $selected_month = $request->input('month');

    //     $req_items = Item::with('stockcard')
    //         ->whereColumn('quantity', '<=', 'restock_point')
    //         ->whereNotNull('issue')
    //         ->get();

    //     return view('report_requisition', compact('req_items', 'selected_year', 'selected_month'));
    // }
}
