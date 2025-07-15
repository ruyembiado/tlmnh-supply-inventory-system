@extends('layouts.auth')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0">Yearly Report</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <form method="GET" action="{{ route('show.report') }}" class="d-print-none col-md-3">
                    <div class="row g-2 align-items-center">
                        <div class="d-flex flex-column col-md-6">
                            <label for="year" class="form-label mb-0">Select Year:</label>
                            <select name="year" id="year" class="form-control form-control-sm"
                                onchange="this.form.submit()">
                                @for ($y = date('Y'); $y >= 2024; $y--)
                                    <option value="{{ $y }}"
                                        {{ request('year', $selected_year) == $y ? 'selected' : '' }}>{{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </form>

                <div class="print-buttons">
                    <button onclick="printReport()" class="btn btn-sm btn-primary d-print-none">
                        <i class="fas fa-print"></i> Print Report
                    </button>
                </div>
            </div>

            <div id="print-section">
                <table class="report-header m-auto" width="100%" cellspacing="0" cellpadding="0"
                    style="border-collapse: collapse;">
                    <tr>
                        <td colspan="2" style="vertical-align: middle;" class="text-center">
                            <div class="d-flex align-items-center justify-content-center gap-1">
                                <div class="company-text">
                                    <h4 class="mb-4">REPORT OF SUPPLIES AND MATERIAL ISSUED</h4>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="pb-2">
                            Entity Name: <span class="border-bottom border-dark">Tario Lim National Memorial High School</span>
                        </td>
                        <td class="pb-2">
                            Year:<span class="border-bottom border-dark">{{ $selected_year }}</span>
                        </td>
                    </tr>
                </table>

                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="">
                            <tr>
                                <th>Stock No.</th>
                                <th>Item</th>
                                <th>Unit of Measurement</th>
                                <th>Quantity Issued</th>
                                <th>Unit Cost</th>
                                <th>Amount</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $hasData = $items
                                    ->filter(function ($item) {
                                        return $item->stockcard->sum('issue') > 0;
                                    })
                                    ->isNotEmpty();
                            @endphp
                            @if (!$hasData)
                                <tr>
                                    <td colspan="7" class="text-center">No data available for this year.</td>
                                </tr>
                            @else
                                @foreach ($items as $item)
                                    @php
                                        $totalQuantity = $item->stockcard->sum('issue');
                                        $unitCost = $item->unit_cost ?? 0;
                                        $totalCost = $totalQuantity * $unitCost;
                                    @endphp
                                    @if ($totalQuantity > 0)
                                        <tr>
                                            <td>{{ $item->stock_no }}</td>
                                            <td>{{ $item->item_name }}</td>
                                            <td>{{ $item->unit }}</td>
                                            <td>{{ $totalQuantity }}</td>
                                            <td>{{ number_format($unitCost, 2) }}</td>
                                            <td>{{ number_format($totalCost, 2) }}</td>
                                            <td>{{ number_format($totalCost, 2) }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printReport() {
            printJS({
                printable: 'print-section',
                type: 'html',
                css: [
                    '{{ asset('/public/css/styles.css') }}',
                    'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css'
                ],
            });
        }
    </script>
@endsection
