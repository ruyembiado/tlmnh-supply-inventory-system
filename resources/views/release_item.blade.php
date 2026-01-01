@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Release Item</h1>
    </div>

    <!-- Card -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('release.item') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="item_id" class="form-label">Item Name</label>
                            <select name="item_name" id="item_name"
                                class="form-control select2 @error('item_name') is-invalid @enderror">
                                <option value="">-- Select Item --</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('item_name') == $item->id ? 'selected' : '' }}>
                                        {{ $item->item_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('item_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <div class="mb-2">
                                <span id="remaining-stock" class="text-muted">Remaining stock: <span class="fw-bold">0</span></span>
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
                                class="form-control @error('end_user') is-invalid @enderror" value="{{ old('end_user') }}">
                            @error('end_user')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="reference" class="form-label">Reference (optional)</label>
                            <input type="text" name="reference" id="reference"
                                class="form-control @error('reference') is-invalid @enderror"
                                value="{{ old('reference') }}">
                            @error('reference')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="purpose" class="form-label">Purpose / No. of Days to Consume (optional)</label>
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
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#item_name').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: "-- Select Item --",
                allowClear: true
            });
        });

        $('#item_name').on('change', function() {
            var itemId = $(this).val();
            if (itemId) {
                $.ajax({
                    url: '{{ url('item/stock') }}/' + itemId,
                    type: 'GET',
                    success: function(response) {
                        var stock = response.stock;
                        $('#quantity').attr('max', stock);
                        $('#remaining-stock span').text(response.stock);
                        // Auto-correct quantity if it exceeds stock
                        if (parseInt($('#quantity').val()) > stock) {
                            $('#quantity').val(stock);
                        }
                    },
                    error: function() {
                        $('#remaining-stock span').text('0');
                        $('#quantity').attr('max', 0);
                    }
                });
            } else {
                $('#remaining-stock span').text('0');
                $('#quantity').attr('max', 0);
            }
        });

        // Trigger change on load to show stock for old selected item (if any)
        $('#item_name').trigger('change');
    </script>
@endpush
