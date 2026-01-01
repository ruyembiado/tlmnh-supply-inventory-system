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
                            <input type="text" name="item_name" class="form-control" value="{{ $item->item_name }}"
                                required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Supplier Name</label>
                            <input type="text" name="supplier_name" class="form-control"
                                value="{{ $item->supplier_name }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" class="form-control" value="{{ $item->category }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="restock_point" class="form-label">Restock Point</label>
                            <input type="number" name="restock_point" id="restock_point" class="form-control"
                                value="{{ $item->restock_point }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Stock No.</label>
                            <input type="text" name="stock_no" class="form-control" value="{{ $item->stock_no }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Unit</label>
                            <input type="text" name="unit" class="form-control"
                                value="{{ $item->unit }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Unit Cost</label>
                            <input type="number" step="0.01" name="unit_cost" class="form-control"
                                value="{{ $item->unit_cost }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Current Stock</label>
                            <input readonly type="number" class="form-control" value="{{ $item->quantity }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Add Stock</label>
                            <input type="number" name="stock" class="form-control" min="0">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="2">{{ $item->description }}</textarea>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Remarks</label>
                            <textarea name="remarks" class="form-control" rows="2">{{ $item->remarks }}</textarea>
                        </div>

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
