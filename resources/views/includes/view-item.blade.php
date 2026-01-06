<!-- Item Modal -->
<div class="modal fade" id="itemModal{{ $item->id }}" tabindex="-1" aria-labelledby="itemModalLabel{{ $item->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="itemModalLabel{{ $item->id }}">Item Details - {{ $item->item_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="item_name" class="form-label">Item Name</label>
                            <input type="text" name="item_name" id="item_name" class="form-control" readonly
                                value="{{ $item->item_name }}">
                        </div>
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label">Supplier Name</label>
                            <input type="text" name="supplier_name" id="supplier_name" class="form-control" readonly
                                value="{{ $item->supplier_name }}">
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" name="category" id="category" class="form-control" readonly
                                value="{{ $item->category }}">
                        </div>
                        <div class="mb-3">
                            <label for="stock_no" class="form-label">Stock No.</label>
                            <input type="text" name="stock_no" id="stock_no" class="form-control" readonly
                                value="{{ $item->stock_no }}">
                        </div>
                        {{-- <div class="mb-3">
                            <label for="restock_point" class="form-label">Restock Point</label>
                            <input type="number" name="restock_point" id="restock_point" class="form-control" readonly
                                min="0" value="{{ $item->restock_point }}">
                        </div> --}}
                        <div class="mb-3">
                            <label for="unit_cost" class="form-label">Unit Cost</label>
                            <input type="number" name="unit_cost" id="unit_cost" class="form-control" readonly
                                step="0.01" min="0" value="{{ $item->unit_cost }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Current Stock</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" readonly
                                min="0" value="{{ $item->quantity }}">
                        </div>
                        <div class="mb-3">
                            <label for="unit" class="form-label">Unit of Measurement</label>
                            <input type="text" name="unit" id="unit" class="form-control" readonly
                                value="{{ $item->unit }}">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea readonly name="description" id="description" class="form-control" rows="3">{{ $item->description }}</textarea>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea readonly name="remarks" id="remarks" class="form-control" rows="3">{{ $item->remarks }}</textarea>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
