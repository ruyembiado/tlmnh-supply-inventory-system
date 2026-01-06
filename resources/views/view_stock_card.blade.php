@extends('layouts.auth')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Stock Card for <strong>{{ $item->item_name }}</strong></h1>
        <a href="{{ url()->previous() }}" class="btn btn-primary float-end d-print-none">Back</a>
    </div>

    <!-- Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="print-section" id="print-section">
                <div class="p-3">
                    <table id="print-stockcard" class="table table-responsive table-borderless w-100 mb-3">
                        <tbody>
                            <tr>
                                <td class="w-60"><strong>Entity Name:</strong> Tario Lim National Memorial High School</td>
                                <td class="w-40 text-end"><strong>Stock No:</strong> {{ $item->stock_no }}</td>
                            </tr>
                            <tr>
                                <td><strong>Item:</strong> {{ $item->item_name }}</td>
                                {{-- <td class="text-end"><strong>Reorder Point:</strong></td> --}}
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Description:</strong> {{ $item->description ?? '' }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Unit of Measurement:</strong> {{ strtoupper($item->unit) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="print-stockcard" class="table-responsive">
                        <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Date</th>
                                    {{-- <th>Reference</th> --}}
                                    <th>Receipt (QTY)</th>
                                    <th>Issue (QTY)</th>
                                    {{-- <th>Type</th> --}}
                                    <th>Office/End-User</th>
                                    <th>Balance</th>
                                    <th>Purpose/ No. of days to consume</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($item->stockcard as $record)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($record->date)->format('F d, Y') }}</td>
                                        {{-- <td>{{ $record->reference ?? '' }}</td> --}}
                                        <td>{{ $record->receipt ?? '' }}</td>
                                        <td>{{ $record->issue ?? '' }}</td>
                                        {{-- <td>
                                            @if ($record->type == 'IN')
                                                <span class="badge bg-success">IN</span>
                                            @else
                                                <span class="badge bg-danger">OUT</span>
                                            @endif
                                        </td> --}}
                                        <td>{{ $record->end_user ?? '' }}</td>
                                        <td>{{ $record->balance }}</td>
                                        <td>{{ $record->purpose ?? '' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No stock card records found.</td>
                                    </tr>
                                @endforelse
                                <tr>
                                    <td colspan="5" class="text-end"><strong class="pe-2">Balance: </strong></td>
                                    <td colspan="2"><strong>{{ $item->quantity }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex gap-2 justify-content-end mt-3">
                        <button onclick="printReport()" class="btn btn-sm btn-primary d-print-none">
                            <i class="fas fa-print"></i> Print Stock Card
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function printReport() {
        printJS({
            printable: 'print-section',
            type: 'html',
            css: [
                '{{ asset('public/css/styles.css') }}',
                '{{ asset('public/css/bootstrap.min.css') }}'
            ],
        });
    }
</script>
