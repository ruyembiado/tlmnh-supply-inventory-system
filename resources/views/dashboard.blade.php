@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-between">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-dark text-uppercase mb-1">
                                    Items</div>
                                <div class="h3 mb-0 fw-bold text-primary">{{ $items->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-box fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-between">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-dark text-uppercase mb-1">
                                    Out of Stock Items</div>
                                <div class="h3 mb-0 fw-bold text-primary">
                                    {{ $items->where('quantity', 0)->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-box fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-between">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-dark text-uppercase mb-1">
                                    Items Released</div>
                                <div class="h3 mb-0 fw-bold text-primary">{{ number_format($totalReleasedItems) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-box fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-between">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-dark text-uppercase mb-1">
                                    Capital Spent</div>
                                <div class="h3 mb-0 fw-bold text-primary">{{ $totalCost }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-dollar fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Row -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-between">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2">
                                <div class="text-xs fw-bold text-dark text-uppercase mb-1">
                                    Low Stock Items</div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Item Name</th>
                                            <th>Restock Point</th>
                                            <th>Current Stock</th>
                                            <th>Status</th>
                                            <th>Unit</th>
                                            {{-- <th>Date Created</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($req_items as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->item_name }}</td>
                                                <td>{{ $item->restock_point }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>
                                                    @if ($item->quantity == 0)
                                                        <span class="badge bg-danger ms-2">Out of Stock</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark ms-2">For
                                                            Requisition</span>
                                                    @endif
                                                </td>
                                                <td>{{ $item->unit }}</td>
                                                {{-- <td>{{ $item->created_at->format('F d, Y') }}</td> --}}
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <button class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                                            data-bs-target="#itemModal{{ $item->id }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>

                                                        @include('includes.view-item', [
                                                            'item' => $item,
                                                        ])

                                                        <a href="#" class="btn btn-warning btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editItemModal-{{ $item->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        @include('includes.update-item', [
                                                            'item' => $item,
                                                        ])
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Row -->

    <div class="row">
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs fw-bold text-dark text-uppercase mb-1">
                        Capital Spent per Month ({{ now()->year }})
                    </div>
                    <canvas id="capitalChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs fw-bold text-dark text-uppercase mb-1">
                        Items Released per Month ({{ now()->year }})
                    </div>
                    <canvas id="itemsChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs fw-bold text-dark text-uppercase mb-1">
                        Top 10 Released Items ({{ now()->year }})
                    </div>
                    <canvas id="topItemsChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-12 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs fw-bold text-dark text-uppercase mb-1">
                        Top Released Item per Month ({{ now()->year }})
                    </div>
                    <canvas id="monthlyTopItemChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection <!-- End the content section -->
@push('scripts')
    <script>
        const ctxCapitalSpent = document.getElementById('capitalChart');
        const capitalData = @json(array_values($monthlyCapital));

        new Chart(ctxCapitalSpent, {
            type: 'line',
            data: {
                labels: [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ],
                datasets: [{
                    label: 'Capital Spent',
                    data: capitalData,
                    // backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    // borderColor: 'rgba(54, 162, 235, 1)',
                    // borderWidth: 1
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => '₱ ' + value.toLocaleString()
                        }
                    }
                }
            }
        });

        const ctxItemReleased = document.getElementById('itemsChart');
        const ItemData = @json(array_values($monthlyItems));

        new Chart(ctxItemReleased, {
            type: 'line',
            data: {
                labels: [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ],
                datasets: [{
                    label: 'Items Released',
                    data: ItemData,
                    fill: true,
                    // borderColor: 'rgba(75, 192, 192, 1)',
                    // backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        const ctxTopItems = document.getElementById('topItemsChart').getContext('2d');

        new Chart(ctxTopItems, {
            type: 'bar',
            data: {
                labels: @json($topItemLabels),
                datasets: [{
                    label: 'Total Released Items',
                    data: @json($topItemData),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        const ctxMonthlyTop = document.getElementById('monthlyTopItemChart');

        new Chart(ctxMonthlyTop, {
            type: 'bar',
            data: {
                labels: @json($monthlyTopLabels),
                datasets: [{
                    label: 'Top Released Item',
                    data: @json($monthlyTopData),
                    borderWidth: 1,
                    itemNames: @json($monthlyTopItemNames)
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const itemName = context.dataset.itemNames[context.dataIndex];
                                return itemName + ': ' + context.raw;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
@endpush
