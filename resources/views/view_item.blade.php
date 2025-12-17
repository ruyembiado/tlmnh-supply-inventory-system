@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">View Item</h1>
        <a class="btn btn-primary" href="{{ url()->previous() }}">Back</a>
    </div>

    <!-- Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="item_name" class="form-label">Item Name</label>
                        <input type="text" name="item_name" id="item_name"
                            class="form-control @error('item_name') is-invalid @enderror" readonly
                            value="{{ $item->item_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="supplier_name" class="form-label">Supplier Name</label>
                        <input type="text" name="supplier_name" id="supplier_name"
                            class="form-control @error('supplier_name') is-invalid @enderror" readonly
                            value="{{ $item->supplier_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" name="category" id="category"
                            class="form-control @error('category') is-invalid @enderror" readonly
                            value="{{ $item->category }}">
                    </div>
                    <div class="mb-3">
                        <label for="stock_no" class="form-label">Stock No.</label>
                        <input type="text" name="stock_no" id="stock_no"
                            class="form-control @error('stock_no') is-invalid @enderror" readonly
                            value="{{ $item->stock_no }}">
                    </div>
                    <div class="mb-3">
                        <label for="restock_point" class="form-label">Restock Point</label>
                        <input type="number" name="restock_point" id="restock_point"
                            class="form-control @error('restock_point') is-invalid @enderror" readonly min="0"
                            value="{{ $item->restock_point }}">
                    </div>
                    <div class="mb-3">
                        <label for="unit_cost" class="form-label">Unit Cost</label>
                        <input type="number" name="unit_cost" id="unit_cost"
                            class="form-control @error('unit_cost') is-invalid @enderror" readonly step="0.01"
                            min="0" value="{{ $item->unit_cost }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity"
                            class="form-control @error('quantity') is-invalid @enderror" readonly min="0"
                            value="{{ $item->quantity }}">
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit of Measurement</label>
                        <input type="text" name="unit" id="unit"
                            class="form-control @error('unit') is-invalid @enderror" readonly placeholder="e.g. pcs, box"
                            value="{{ $item->unit }}">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea readonly name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                            rows="3">{{ $item->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks</label>
                        <textarea readonly name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror"
                            rows="3">{{ $item->remarks }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
