@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Items</h1>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Item Name</th>
                            {{-- <th>Category</th> --}}
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Description</th>
                            {{-- <th>Remark</th> --}}
                            <th>Date Added</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->item_name }}</td>
                                {{-- <td>{{ $item->category }}</td> --}}
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->unit }}</td>
                                <td>{{ $item->description }}</td>
                                {{-- <td>{{ $item->remarks }}</td> --}}
                                <td>{{ $item->created_at->format('F d, Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-c gap-2">
                                         <a href="{{ route('show.item', $item->id) }}" class="btn btn-secondary btn-sm">
                                            View
                                        </a>
                                        <a href="{{ route('edit.item', $item->id) }}" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('destroy.item', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this item?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Content Row -->
@endsection <!-- End the content section -->
