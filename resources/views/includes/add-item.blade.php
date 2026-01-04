<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Add New Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('store.item') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-xl-4 mb-3">
                            <label for="item_name" class="form-label">Item Name</label>
                            <input type="text" name="item_name" id="item_name"
                                class="form-control @error('item_name', 'add') is-invalid @enderror"
                                value="{{ old('item_name') }}">
                            @error('item_name', 'add')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-xl-4 mb-3">
                            <label for="supplier_name" class="form-label">Supplier Name</label>
                            <input type="text" name="supplier_name" id="supplier_name"
                                class="form-control @error('supplier_name', 'add') is-invalid @enderror"
                                value="{{ old('supplier_name') }}">
                            @error('supplier_name', 'add')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-xl-4 mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" name="category" id="category"
                                class="form-control @error('category', 'add') is-invalid @enderror"
                                value="{{ old('category') }}">
                            @error('category', 'add')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-xl-4 mb-3">
                            <label for="stock_no" class="form-label">Stock No.</label>
                            <input type="text" name="stock_no" id="stock_no"
                                class="form-control @error('stock_no', 'add') is-invalid @enderror"
                                value="{{ old('stock_no') }}">
                            @error('stock_no', 'add')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-xl-4 mb-3">
                            <label for="restock_point" class="form-label">Restock Point</label>
                            <input type="number" name="restock_point" id="restock_point"
                                class="form-control @error('restock_point', 'add') is-invalid @enderror" min="0"
                                value="{{ old('restock_point') }}">
                            @error('restock_point', 'add')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-xl-4 mb-3">
                            <label for="unit_cost" class="form-label">Unit Cost</label>
                            <input type="number" name="unit_cost" id="unit_cost"
                                class="form-control @error('unit_cost', 'add') is-invalid @enderror" step="0.01"
                                min="0" value="{{ old('unit_cost') }}">
                            @error('unit_cost', 'add')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-xl-4 mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="quantity"
                                class="form-control @error('quantity', 'add') is-invalid @enderror" min="0"
                                value="{{ old('quantity', 0) }}">
                            @error('quantity', 'add')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-xl-4 mb-3">
                            <label for="unit" class="form-label">Unit of Measurement</label>
                            <input type="text" name="unit" id="unit"
                                class="form-control @error('unit', 'add') is-invalid @enderror"
                                placeholder="e.g. pcs, box" value="{{ old('unit') }}">
                            @error('unit', 'add')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 col-xl-4 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control @error('description', 'add') is-invalid @enderror"
                                rows="3">{{ old('description') }}</textarea>
                            @error('description', 'add')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="col-md-6 col-xl-4 mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" rows="3">{{ old('remarks') }}</textarea>
                                @error('remarks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                    </div>

                    <div class="modal-footer">
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary float-end">Add Item</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@push('scripts')
    @if ($errors->add->any())
        <script>
            $(function() {
                $('#addItemModal').modal('show');
            });
        </script>
    @endif
@endpush
