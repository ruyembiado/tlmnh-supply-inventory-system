@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Released Items</h1>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <form method="GET" action="{{ route('released.items') }}" class="mb-3">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Filter by Date</label>
                            <input type="date" name="release_date" class="form-control"
                                value="{{ request('release_date') }}">
                        </div>

                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">
                                Filter
                            </button>
                        </div>

                        <div class="col-auto">
                            <a href="{{ route('released.items') }}" class="btn btn-danger">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Item Name</th>
                            {{-- <th>Category</th> --}}
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Purpose</th>
                            <th>Office/End-User</th>
                            <th>Release Date</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($releasedItems as $releasedItem)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $releasedItem->item->item_name }}</td>
                                {{-- <td>{{ $releasedItem->item->category }}</td> --}}
                                <td>{{ $releasedItem->issue }}</td>
                                <td>{{ $releasedItem->item->unit }}</td>
                                <td>{{ $releasedItem->purpose }}</td>
                                <td>{{ $releasedItem->end_user }}</td>
                                <td>
                                    {{ $releasedItem->release_date ? \Carbon\Carbon::parse($releasedItem->release_date)->format('F d, Y') : '' }}
                                </td>
                                {{-- <td>
                                    <div class="d-flex align-items-center justify-c gap-2">
                                        <a href="{{ route('show.item', $releasedItem->item->id) }}" class="btn btn-secondary btn-sm">
                                            View
                                        </a>
                                        <a href="{{ route('edit.item', $releasedItem->item->id) }}" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('destroy.item', $releasedItem->item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this item?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Content Row -->
@endsection <!-- End the content section -->
