@extends('layouts.auth')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Release Items</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('release.item') }}" method="POST">
                @csrf

                {{-- ================= HEADER DATA ================= --}}
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Office / End-User</label>
                        <input type="text" name="end_user" class="form-control @error('end_user') is-invalid @enderror"
                            value="{{ old('end_user') }}">
                        @error('end_user')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- <div class="col-md-3">
                        <label class="form-label">Reference (optional)</label>
                        <input type="text" name="reference" class="form-control @error('reference') is-invalid @enderror"
                            value="{{ old('reference') }}">
                        @error('reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    {{-- <div class="col-md-3">
                        <label class="form-label">Purpose / No. of Days to Consume</label>
                        <textarea name="purpose" class="form-control @error('purpose') is-invalid @enderror" rows="3">{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <div class="col-md-3">
                        <label class="form-label">Release Date</label>
                        <input type="date" name="release_date"
                            class="form-control @error('release_date') is-invalid @enderror"
                            value="{{ old('release_date') ?? today()->toDateString() }}">
                        @error('release_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>

                {{-- ================= ITEMS ================= --}}
                @php
                    $oldItems = old('items', [null]);
                    $oldQuantities = old('quantities', [null]);
                    $oldPurposes = old('purposes', [null]);
                @endphp

                <div id="items-wrapper">
                    @foreach ($oldItems as $index => $oldItem)
                        <div class="item-row row mb-3">

                            {{-- ITEM --}}
                            <div class="col-md-3">
                                <label class="form-label">
                                    Item Name -
                                    <small class="text-dark remaining-stock">Remaining stock: 0</small>
                                </label>

                                <select name="items[]"
                                    class="form-control item-select select2
                                    @error("items.$index") is-invalid @enderror">

                                    <option value="">-- Select Item --</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}" {{ $oldItem == $item->id ? 'selected' : '' }}>
                                            {{ $item->item_name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error("items.$index")
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- QUANTITY --}}
                            <div class="col-md-3">
                                <div class="label">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" name="quantities[]"
                                        class="form-control quantity-input @error("quantities.$index") is-invalid @enderror"
                                        min="0" value="{{ $oldQuantities[$index] ?? '' }}">

                                    @error("quantities.$index")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Purpose</label>
                                <textarea name="purposes[]" class="form-control purpose-input @error("purposes.$index") is-invalid @enderror"
                                    rows="2">{{ old("purposes.$index") }}</textarea>

                                @error("purposes.$index")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- REMOVE --}}
                            <div class="col-md-3">
                                <button type="button" style="margin-top: 35px;"
                                    class="btn btn-sm btn-danger btn-remove-item {{ $index === 0 ? 'd-none' : '' }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-item" class="btn btn-sm btn-secondary mb-3">
                    <i class="fas fa-plus"></i> Add Item
                </button>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary float-end">
                        Release Items
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            function initSelect2() {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    width: '100%'
                });
            }

            initSelect2();

            // ================= ADD ITEM =================
            $('#add-item').on('click', function() {

                // Destroy select2 first (important)
                $('.item-select').select2('destroy');

                let row = $('.item-row:first').clone(false);

                row.find('select').val('');
                row.find('.quantity-input').val('');
                row.find('.purpose-input').val('');
                row.find('.remaining-stock').text('Remaining stock: 0');
                row.find('.btn-remove-item').removeClass('d-none');

                $('#items-wrapper').append(row);

                // Re-init select2
                initSelect2();
                refreshItemOptions();
            });

            // ================= REMOVE ITEM =================
            $(document).on('click', '.btn-remove-item', function() {
                $(this).closest('.item-row').remove();
                refreshItemOptions();
            });

            // ================= ITEM CHANGE =================
            $(document).on('change', '.item-select', function() {
                let select = $(this);
                let itemId = select.val();
                let row = select.closest('.item-row');

                if (itemId) {
                    $.get("{{ url('item/stock') }}/" + itemId, function(res) {
                        row.find('.remaining-stock').text('Remaining stock: ' + res.stock);
                        row.find('.quantity-input').attr('max', res.stock);
                    });
                } else {
                    row.find('.remaining-stock').text('Remaining stock: 0');
                    row.find('.quantity-input').attr('max', 0);
                }

                refreshItemOptions();
            });

            // ================= HIDE SELECTED ITEMS =================
            function refreshItemOptions() {
                let selected = [];

                $('.item-select').each(function() {
                    if ($(this).val()) {
                        selected.push($(this).val());
                    }
                });

                $('.item-select').each(function() {
                    let current = $(this).val();

                    $(this).find('option').each(function() {
                        let val = $(this).val();
                        if (val && val !== current && selected.includes(val)) {
                            $(this).prop('disabled', true);
                        } else {
                            $(this).prop('disabled', false);
                        }
                    });
                });
            }

        });
    </script>
@endpush
