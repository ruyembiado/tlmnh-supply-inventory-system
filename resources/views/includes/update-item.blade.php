<div class="modal fade" id="editItemModal-{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">
                    Update Item
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('update.item') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Item Name</label>
                            <input type="text" name="item_name"
                                class="form-control @error('item_name', 'update') is-invalid @enderror"
                                value="{{ old('item_name', $item->item_name) }}">
                            @error('item_name', 'update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Supplier Name</label>
                            <input type="text" name="supplier_name"
                                class="form-control @error('supplier_name', 'update') is-invalid @enderror"
                                value="{{ old('supplier_name', $item->supplier_name) }}">
                            @error('supplier_name', 'update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="col-md-4 mb-3">
                            <label class="form-label">Category</label>

                            <select name="category"
                                class="form-control @error('category', 'update') is-invalid @enderror">

                                <option value="">-- Select Category --</option>

                                @php
                                    $categories = [
                                        'Office Supplies Inventory',
                                        'Drugs and Medicines Inventory',
                                        'Medical, Dental and Laboratory Supplies Inventory',
                                        'Agricultural and Marine Supplies Inventory',
                                        'Textbooks and Instructional Materials Inventory',
                                        'Construction Materials Inventory',
                                        'Other Supplies and Materials Inventory',
                                    ];

                                    $currentCategory = old('category', $item->category);
                                @endphp

                                @foreach ($categories as $category)
                                    <option value="{{ $category }}"
                                        {{ $currentCategory == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach

                            </select>

                            @error('category', 'update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        {{-- <div class="col-md-4 mb-3">
                            <label for="restock_point" class="form-label">Restock Point</label>
                            <input type="number" name="restock_point" id="restock_point" class="form-control @error('restock_point', 'update') is-invalid @enderror"
                                value="{{ old('restock_point', $item->restock_point) }}">
                            @error('restock_point', 'update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        {{-- <div class="col-md-4 mb-3">
                            <label class="form-label">Stock No.</label>
                            <input type="text" name="stock_no"
                                class="form-control @error('stock_no', 'update') is-invalid @enderror"
                                value="{{ old('stock_no', $item->stock_no) }}">
                            @error('stock_no', 'update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Unit</label>
                            <input type="text" name="unit"
                                class="form-control @error('unit', 'update') is-invalid @enderror"
                                value="{{ old('unit', $item->unit) }}">
                            @error('unit', 'update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Unit Cost</label>
                            <input type="number" step="0.01" name="unit_cost"
                                class="form-control @error('unit_cost', 'update') is-invalid @enderror"
                                value="{{ old('unit_cost', $item->unit_cost) }}">
                            @error('unit_cost', 'update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Current Stock</label>
                            <input readonly type="number" class="form-control" value="{{ $item->quantity }}">
                            @error('quantity', 'update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Add Stock</label>
                            <input type="number" name="stock"
                                class="form-control @error('stock', 'update') is-invalid @enderror" min="0">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control @error('description', 'update') is-invalid @enderror" rows="2">{{ old('description', $item->description) }}</textarea>
                            @error('description', 'update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="col-md-4 mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" class="form-control" rows="2">{{ $item->remarks }}</textarea>
                        </div> --}}

                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Update Item
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@push('scripts')
    @if ($errors->update->any())
        <script>
            $(document).ready(function() {
                $('#editItemModal-{{ old('item_id') }}').modal('show');
            });
        </script>
    @endif
@endpush
