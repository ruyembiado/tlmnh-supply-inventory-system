<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLNMHS</title>

    <!-- Bootstrap Style -->
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Fontawesome Style -->
    <link href="{{ asset('public/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/fontawesome.min.css') }}" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{ asset('public/css/datatables.min.css') }}" rel="stylesheet">
    <!-- Select2 Style -->
    <link href="{{ asset('public/css/select2.min.css') }}" rel="stylesheet">
    <!-- Select2 Bootstrap Styles -->
    <link href="{{ asset('public/css/select2-bootstrap5.min.css') }}" rel="stylesheet">
    <!-- Custom Styles -->
    <link href="{{ asset('public/css/styles.css') }}" rel="stylesheet">
</head>

<body>

    <div class="wrapper">
        <div id="print-section">
            <!-- Header Section -->
            <table class="report-header m-auto mb-2" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td colspan="8" class="text-center">
                        <h4 class="fw-bold mb-0">REPORT OF SUPPLIES AND MATERIALS ISSUED</h4>
                        <h5 class="mb-3">{{ \Carbon\Carbon::create()->month($selected_month)->format('F') }}
                            {{ $selected_year }} JUNIOR HS</h5>
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
                    <td colspan="3" class="pb-2">Fund Cluster:
                        <span class="border-bottom border-dark">---</span>
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
                                @endphp

                                <tr>
                                    <td style="border-bottom: none !important;">---</td>
                                    <td style="border-bottom: none !important;">---</td>
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
                            @foreach ($recap as $row)
                                <tr>
                                    <td></td>
                                    <td>{{ $row['stock_no'] }}</td>
                                    <td>{{ $row['quantity'] }}</td>
                                    <td></td>
                                    <td></td>
                                    <td>₱ {{ number_format($row['unit_cost'], 2) }}</td>
                                    <td>₱ {{ number_format($row['total_cost'], 2) }}</td>
                                    <td>---</td>
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
                                        class="w-100 pt-0 report-input form-control text-center" type="text"
                                        value="JEFRY J. TILBE" />
                                </td>
                                <td colspan="2" class="text-center right-border-none">
                                    <input oninput="this.value = this.value.toUpperCase()"
                                        class="w-100 pt-0 report-input form-control text-center" type="text"
                                        value="RIZA LEAH B. SIANSON" />
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

    <!-- jQuery Script -->
    <script src="{{ asset('public/js/jquery.min.js') }}"></script>
    <!-- Bootstrap Script -->
    <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('public/js/datatables.min.js') }}"></script>
    <!-- Fontawesome Script -->
    <script src="{{ asset('public/js/all.min.js') }}"></script>
    <!-- Chart Script -->
    <script src="{{ asset('public/js/chart.js') }}"></script>
    <!-- Select2 Script -->
    <script src="{{ asset('public/js/select2.min.js') }}"></script>
    <!-- Print.js JS -->
    <script src="{{ asset('public/js/print.min.js') }}"></script>
    <!--Custom Script -->
    <script src="{{ asset('public/js/script.js') }}"></script>
</body>

</html>
