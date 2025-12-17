@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Update Item</h1>
        <a class="btn btn-primary" href="{{ url()->previous() }}">Back</a>
    </div>

    <!-- Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('update.item', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="item_name" class="form-label">Item Name</label>
                            <input type="text" name="item_name" id="item_name"
                                class="form-control @error('item_name') is-invalid @enderror"
                                value="{{ $item->item_name }}">
                            @error('item_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="supplier_name" class="form-label">Supplier Name</label>
                            <input type="text" name="supplier_name" id="supplier_name"
                                class="form-control @error('supplier_name') is-invalid @enderror"
                                value="{{ $item->supplier_name }}">
                            @error('supplier_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" name="category" id="category"
                                class="form-control @error('category') is-invalid @enderror" value="{{ $item->category }}">
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stock_no" class="form-label">Stock No.</label>
                            <input type="text" name="stock_no" id="stock_no"
                                class="form-control @error('stock_no') is-invalid @enderror" value="{{ $item->stock_no }}">
                            @error('stock_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity"
                                class="form-control @error('quantity') is-invalid @enderror" min="0"
                                value="{{ $item->quantity }}" disabled>
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="restock_point" class="form-label">Restock Point (optional)</label>
                            <input type="number" name="restock_point" id="restock_point"
                                class="form-control @error('restock_point') is-invalid @enderror" min="0"
                                value="{{ $item->restock_point }}">
                            @error('restock_point')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="unit_cost" class="form-label">Unit Cost</label>
                            <input type="number" name="unit_cost" id="unit_cost"
                                class="form-control @error('unit_cost') is-invalid @enderror" step="0.01" min="0"
                                value="{{ $item->unit_cost }}">
                            @error('unit_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="stock" class="form-label">Add Stock</label>
                            <input type="number" name="stock" id="stock"
                                class="form-control @error('stock') is-invalid @enderror" min="0" value="">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="unit" class="form-label">Unit of Measurement</label>
                            <input type="text" name="unit" id="unit"
                                class="form-control @error('unit') is-invalid @enderror" placeholder="e.g. pcs, box"
                                value="{{ $item->unit }}">
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description (optional)</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                rows="3">{{ $item->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks (optional)</label>
                            <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" rows="3">{{ $item->remarks }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary float-end">Update Item</button>
                </div>
            </form>
        </div>
    </div>
@endsection
