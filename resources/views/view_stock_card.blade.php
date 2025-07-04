@extends('layouts.auth')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Stock Card for <strong>{{ $item->item_name }}</strong></h1>
    </div>

    <!-- Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="p-3">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6"><strong>Entity Name:</strong> Tario Lim National Memorial High School</div>
                        <div class="col-md-6 text-end"><strong>Stock No:</strong> {{ $item->stock_no }}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><strong>Item:</strong> {{ $item->item_name }}</div>
                        <div class="col-md-6 text-end"><strong>Reorder Point:</strong></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12"><strong>Description:</strong> {{ $item->description ?? '' }}</div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12"><strong>Unit of Measurement:</strong> {{ strtoupper($item->unit) }}</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Date</th>
                                <th>Reference</th>
                                <th>Receipt (QTY)</th>
                                <th>Issue (QTY)</th>
                                <th>Office/End-User</th>
                                {{-- <th>Type</th> --}}
                                <th>Balance</th>
                                <th>Purpose/ No. of days to consume</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($item->stockcard as $record)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($record->date)->format('F d, Y') }}</td>
                                    <td>{{ $record->reference ?? '' }}</td>
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
                                    <td>{{ $record->purpose?? '' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No stock card records found.</td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="6" class="text-end"><strong class="pe-2">Balance: </strong></td>
                                <td colspan="2"><strong>{{ $item->quantity }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <a href="{{ url('/stock-cards') }}" class="btn btn-primary mt-3 float-end">Back to Stock Cards</a>
        </div>
    </div>
@endsection
