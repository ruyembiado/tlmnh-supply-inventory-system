@extends('layouts.auth')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0">Report</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <form method="GET" action="{{ route('show.report.requisition') }}" class="d-print-none col-md-3">
                    <div class="row g-2 align-items-center">
                        <div class="d-flex flex-column col-md-4">
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
                        <div class="d-flex flex-column col-md-5">
                            <label for="month" class="form-label mb-0">Select Month:</label>
                            <select name="month" id="month" class="form-control form-control-sm"
                                onchange="this.form.submit()">
                                @foreach (range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ $selected_month == $month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                    </option>
                                @endforeach
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
                            <h4 class="fw-bold mb-0">SUPPLIES AND MATERIALS REQUISITION REPORT</h4>
                            <h5 class="mb-3">{{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                {{ $selected_year }} JUNIOR HS</h5>
                        </td>
                    </tr>
                    {{-- <tr>
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
                    </tr> --}}
                </table>

                <div class="table-responsive req main-report-table">
                    <p class="mb-2">
                        <strong>Total Requisitions:</strong> {{ $req_items->count() }} <br>
                        <strong>Total Quantity Issued:</strong> {{ $req_items->sum('quantity') }}
                    </p>
                    <table class="table table-bordered text-center align-middle" width="100%" cellpadding="3">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Item Name</th>
                                <th>Unit</th>
                                <th>Qty Issued</th>
                                <th>Balance</th>
                                <th>End User</th>
                                <th>Purpose</th>
                                <th>Reference</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($req_items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ $item->unit }}</td>
                                    <td>{{ $item->stockcard->issue ?? '-' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->stockcard->end_user ?? '-' }}</td>
                                    <td>{{ $item->stockcard->purpose ?? '-' }}</td>
                                    <td>{{ $item->stockcard->reference ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">No items due for requisition.</td>
                                </tr>
                            @endforelse
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
