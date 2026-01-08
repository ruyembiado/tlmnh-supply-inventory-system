@extends('layouts.auth')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0">Report</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <form method="GET" action="{{ route('show.monthly.report.sami') }}" class="d-print-none col-md-3">
                    <div class="row g-2 align-items-center">
                        <!-- Year Selection -->
                        <div class="d-flex flex-column col-md-4">
                            <label for="year" class="form-label mb-0">Select Year:</label>
                            <select name="year" id="year" class="form-control form-control-sm"
                                onchange="this.form.submit()">
                                @for ($y = date('Y'); $y >= 2024; $y--)
                                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor 
                            </select>
                        </div>

                        <!-- Month Selection -->
                        <div class="d-flex flex-column col-md-5">
                            <label for="month" class="form-label mb-0">Select Month:</label>
                            <select name="month" id="month" class="form-control form-control-sm"
                                onchange="this.form.submit()">
                                @foreach (range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                    </option>
                                @endforeach
                                 <option value="0" {{ request('month') == 0 ? 'selected' : '' }}>
                                    Yearly Report
                                </option>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="print-buttons d-flex gap-2">
                    <button onclick="printReport()" class="btn btn-sm btn-primary d-print-none">
                        <i class="fas fa-print"></i> Print Report
                    </button>
                    {{-- <a href="{{ url('/download-sami-report?year=' . $selected_year . '&month=' . $selected_month) }}"
                        class="btn btn-sm btn-danger">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a> --}}
                </div>
            </div>

            <div id="print-section">
                <!-- Header Section -->
                <table class="report-header m-auto mb-2" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td colspan="8" class="text-center">
                            <h4 class="fw-bold mb-0">REPORT OF SUPPLIES AND MATERIALS ISSUED</h4>
                            <h5 class="mb-3">{{ $selected_month == 0 ? 'Year' : \Carbon\Carbon::create()->month($selected_month)->format('F') }}
                                {{ $selected_year }} JUNIOR HS / SENIOR HS</h5>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="pb-2">Entity Name:
                            <span class="border-bottom border-dark">Tario Lim National Memorial High School</span>
                        </td>
                        <td colspan="2" class="pb-2">Serial No.:
                            <span class="border-bottom border-dark">
                                -
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="pb-2">
                            <div class="d-flex align-items-center">
                                <label for="">Fund Cluster: </label>
                                <span class="border-bottom border-dark m-0 p-0 col-1">
                                    <input class="pt-0 report-input form-control pb-0 text-center" type="number"
                                        value="" name="fund_cluster" />
                                </span>
                            </div>
                        </td>
                        <td colspan="2" class="pb-2">Date:
                            <span class="border-bottom border-dark">
                                {{ \Carbon\Carbon::today()->format('m/d/Y') }}
                            </span>
                        </td>
                    </tr>
                </table>

                <div class="table-responsive main-report-table">
                    <table class="table table-bordered text-center align-middle" width="100%" cellspacing="0"
                        cellpadding="3" style="border-collapse: collapse;">
                        <thead class="">
                            <tr>
                                <td colspan="6" class="full-border"><i>To be filled up by the Supply and/or Property
                                        Division/Unit</i></td>
                                <td colspan="2" class="full-border"><i>To be filled up by the Accounting
                                        Division/Unit</i></td>
                            </tr>
                            <tr>
                                <th style="vertical-align: middle">RIS No.</th>
                                <th style="vertical-align: middle">Responsibility <br> Center Code</th>
                                <th style="vertical-align: middle">Stock No.</th>
                                <th style="vertical-align: middle">Item</th>
                                <th style="vertical-align: middle">Unit</th>
                                <th style="vertical-align: middle">Quantity <br> Issued</th>
                                <th style="vertical-align: middle">Unit Cost</th>
                                <th style="vertical-align: middle">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $grandTotal = 0;

                                // Filter items where issued > 0
                                $filteredItems = $items->filter(function ($item) {
                                    return $item->stockcard->sum('issue') > 0;
                                });
                            @endphp

                            {{-- If no filtered data --}}
                            @if ($filteredItems->count() == 0)
                                <tr>
                                    <td colspan="8" class="text-center text-dark full-border">
                                        No data available for this month and year.
                                    </td>
                                </tr>
                            @else
                                {{-- Loop filtered items --}}
                                @foreach ($filteredItems as $item)
                                    @php
                                        $totalIssued = $item->stockcard->sum('issue');
                                        $balance = $item->stockcard->sum('balance');
                                        $unitCost = $item->unit_cost ?? 0;
                                        $totalCost = $totalIssued * $unitCost;
                                        $grandTotal += $totalCost;

                                        $categoryCodes = [
                                            'Office Supplies Inventory' => '1040401000',
                                            'Drugs and Medicines Inventory' => '1040406000',
                                            'Medical, Dental and Laboratory Supplies Inventory' => '1040407000',
                                            'Agricultural and Marine Supplies Inventory' => '1040409000',
                                            'Textbooks and Instructional Materials Inventory' => '1040410000',
                                            'Construction Materials Inventory' => '1040413000',
                                            'Other Supplies and Materials Inventory' => '1040499000',
                                        ];
                                    @endphp

                                    <tr>
                                        <td style="border-bottom: none !important;">
                                            {{ \Carbon\Carbon::parse($item->stockcard->first()->release_date)->format('Y-m') }}-{{ sprintf('%03d', $loop->iteration) }}
                                        </td>
                                        <td style="border-bottom: none !important;">
                                            {{ isset($categoryCodes[$item->category]) ? $categoryCodes[$item->category] : '—' }}
                                        </td>
                                        <td style="border-bottom: none !important;">{{ $item->stock_no }}</td>
                                        <td style="border-bottom: none !important;" class="text-start">
                                            {{ $item->item_name }}</td>
                                        <td style="border-bottom: none !important;">{{ $item->unit }}</td>
                                        <td style="border-bottom: none !important;">{{ $totalIssued }}</td>
                                        <td style="border-bottom: none !important;">₱ {{ number_format($unitCost, 2) }}
                                        </td>
                                        <td style="border-bottom: none !important;">₱ {{ number_format($totalCost, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if (!$filteredItems->count() == 0)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="2" class="fw-bold full-border">Recapitulation:</td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="3" class="fw-bold full-border">Recapitulation:</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="fw-bold full-border">Stock No.</td>
                                    <td class="fw-bold full-border">Quantity</td>
                                    <td></td>
                                    <td></td>
                                    <td class="fw-bold full-border">Unit Cost</td>
                                    <td class="fw-bold full-border">Total Cost</td>
                                    <td class="fw-bold full-border">UACS Object Code</td>
                                </tr>
                                @php
                                    $categoryCodes = [
                                        'Office Supplies Inventory' => '1040401000',
                                        'Drugs and Medicines Inventory' => '1040406000',
                                        'Medical, Dental and Laboratory Supplies Inventory' => '1040407000',
                                        'Agricultural and Marine Supplies Inventory' => '1040409000',
                                        'Textbooks and Instructional Materials Inventory' => '1040410000',
                                        'Construction Materials Inventory' => '1040413000',
                                        'Other Supplies and Materials Inventory' => '1040499000',
                                    ];
                                @endphp
                                @foreach ($recap as $row)
                                    <tr>
                                        <td></td>
                                        <td>{{ $row['stock_no'] }}</td>
                                        <td>{{ $row['quantity'] }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>₱ {{ number_format($row['unit_cost'], 2) }}</td>
                                        <td>₱ {{ number_format($row['total_cost'], 2) }}</td>
                                        <td>{{ $categoryCodes[$row['object_code']] ?? '—' }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>₱ {{ number_format($recap->sum('total_cost'), 2) }}</td>
                                    <td></td>
                                </tr>

                                {{-- Footer --}}
                                <tr>
                                    <td colspan="5" class="pb-5 text-center top-border">I hereby certify to the
                                        correctness of the
                                        above information.</td>
                                    <td colspan="3" class="top-border"></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <input oninput="this.value = this.value.toUpperCase()"
                                            class="w-100 py-0 report-input form-control text-center" type="text"
                                            value="JEFRY J. TILBE" name="property_custodian" />
                                    </td>
                                    <td colspan="2" class="text-center right-border-none">
                                        <input oninput="this.value = this.value.toUpperCase()"
                                            class="w-100 py-0 report-input form-control text-center" type="text"
                                            value="RIZA LEAH B. SIANSON" name="accounting_staff" />
                                    </td>
                                    <td colspan="1" class="text-center">
                                        <span
                                            class="border-bottom border-dark">{{ \Carbon\Carbon::today()->format('m/d/Y') }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5" style="vertical-align: top;"
                                        class="text-center bottom-border pb-3 pt-0">Signature over
                                        Printed Name of Supply and/or Property Custodian</td>
                                    <td colspan="2" style="vertical-align: top;"
                                        class="text-center bottom-border pb-3 pt-0 right-border-none">Signature over
                                        Printed Name of <br> Designated Accounting Staff</td>
                                    <td colspan="1" style="vertical-align: top;"
                                        class="text-center bottom-border pb-3 pt-0">Date</td>
                                </tr>
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
                    '{{ asset('public/css/bootstrap.min.css') }}',
                    '{{ asset('public/css/styles.css') }}'
                ],
                scanStyles: false
            });
        }
    </script>
@endsection
