@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Add Item</h1>
    </div>

    <!-- Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('store.item') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="item_name" class="form-label">Item Name</label>
                            <input type="text" name="item_name" id="item_name" class="form-control @error('item_name') is-invalid @enderror" value="{{ old('item_name') }}">
                            @error('item_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" name="category" id="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category') }}">
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stock_no" class="form-label">Stock No.</label>
                            <input type="text" name="stock_no" id="stock_no" class="form-control @error('stock_no') is-invalid @enderror" value="{{ old('stock_no') }}">
                            @error('stock_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="restock_point" class="form-label">Restock Point (optional)</label>
                            <input type="number" name="restock_point" id="restock_point" class="form-control @error('restock_point') is-invalid @enderror" min="0" value="{{ old('restock_point') }}">
                            @error('restock_point')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="unit_cost" class="form-label">Unit Cost</label>
                            <input type="number" name="unit_cost" id="unit_cost" class="form-control @error('unit_cost') is-invalid @enderror" step="0.01" min="0" value="{{ old('unit_cost') }}">
                            @error('unit_cost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" min="0" value="{{ old('quantity', 0) }}">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="unit" class="form-label">Unit of Measurement</label>
                            <input type="text" name="unit" id="unit" class="form-control @error('unit') is-invalid @enderror" placeholder="e.g. pcs, box" value="{{ old('unit') }}">
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description (optional)</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks (optional)</label>
                            <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" rows="3">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary float-end">Add Item</button>
                </div>
            </form>
        </div>
    </div>
@endsection
