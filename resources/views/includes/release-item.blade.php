<div class="modal fade" id="releaseItemModal" tabindex="-1" aria-labelledby="releaseItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="releaseItemModalLabel">Release Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('release.item') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="item_id" class="form-label">Item Name</label>
                                <select name="item_name" id="item_name"
                                    class="form-control select2 @error('item_name') is-invalid @enderror">
                                    <option value="">-- Select Item --</option>
                                    @if (isset($items))
                                        @foreach ($items as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('item_name') == $item->id ? 'selected' : '' }}>
                                                {{ $item->item_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('item_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <div class="mb-2">
                                    <span id="remaining-stock" class="text-muted">Remaining stock:
                                        <span>0</span></span>
                                </div>

                                <input type="number" name="quantity" id="quantity"
                                    class="form-control @error('quantity') is-invalid @enderror" min="0"
                                    value="{{ old('quantity', 0) }}">
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="end_user" class="form-label">Office/End-User</label>
                                <input type="text" name="end_user" id="end_user"
                                    class="form-control @error('end_user') is-invalid @enderror"
                                    value="{{ old('end_user') }}">
                                @error('end_user')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- <div class="mb-3">
                                <label for="reference" class="form-label">Reference (optional)</label>
                                <input type="text" name="reference" id="reference"
                                    class="form-control @error('reference') is-invalid @enderror"
                                    value="{{ old('reference') }}">
                                @error('reference')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="mb-3">
                                <label for="purpose" class="form-label">Purpose / No. of Days to
                                    Consume (optional)</label>
                                <textarea name="purpose" id="purpose" class="form-control @error('purpose') is-invalid @enderror" rows="3">{{ old('purpose') }}</textarea>
                                @error('purpose')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="release_date" class="form-label">Release Date</label>
                                <input type="date" name="release_date" id="release_date"
                                    class="form-control @error('release_date') is-invalid @enderror"
                                    value="{{ old('release_date') ?? today()->toDateString() }}">
                                @error('release_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary float-end">Release Item</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@if ($errors->any())
<script>
    $(document).ready(function () {
        $('#releaseItemModal').modal('show');
    });
</script>
@endif
