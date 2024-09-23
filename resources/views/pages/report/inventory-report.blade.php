@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="text-uppercase mb-0"><span class="text-muted">Report</span> <span class="mx-2">/</span>
                    Inventory
                    Report</h5>
            </div>
        </div>

        <!-- Filter Form -->
        <form action="" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <label for="branch_id">Branch</label>
                    <select name="branch_id" id="branch_id" class="form-select select2">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $branchId == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control"
                           value="{{ $startDate }}">
                </div>

                <div class="col-md-3">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
                </div>

                <div class="col-md-3  d-flex align-items-end">
                    {{--                    <label>&nbsp;</label>--}}
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                </div>
            </div>
        </form>

        <hr>

        <!-- Inventory Summary -->
        <div class="row">
            <div class="col-md-3">
                <h5>Total Inventory Value: {{ number_format($totalInventoryValue, 2) }}</h5>
            </div>
        </div>

        <!-- Inventory Table -->
        <div class="card" style="margin-top: 20px">
            <div class="card-datatable table-responsive">
                <!-- Sales Table -->
                <table id="inventory-report-list" class="table table-striped" style="width:100%">
                    <thead>
                    <tr>
                        <th>Stock Number</th>
                        <th>Branch</th>
                        <th>Supplier</th>
                        <th>Sub Total</th>
                        <th>Discount</th>
                        <th>Final Total</th>
                        <th>Build Date</th>
                        <th>Items</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($stocks as $stock)
                        <tr>
                            <td>{{ $stock->stock_no }}</td>
                            <td>{{ $stock->branches->name }}</td>
                            <td>{{ $stock->supplier->name }}</td>
                            <td>{{ number_format($stock->sub_total, 2) }}</td>
                            <td>{{ number_format($stock->discount, 2) }}</td>
                            <td>{{ number_format($stock->final_total, 2) }}</td>
                            <td>{{ $stock->build_date }}</td>
                            <td>
                                <ul>
                                    @foreach ($stock->stockItems as $item)
                                        <li>{{ $item->items?->name }} (Qty: {{ $item->quantity }},
                                            Cost: {{ number_format($item->cost, 2) }})
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No inventory data found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#inventory-report-list').DataTable(
                {
                    dom: '<"d-flex justify-content-between"lfB>rtip',
                    buttons: [{
                        extend: 'collection',
                        className: 'btn btn-outline-secondary dropdown-toggle',
                        text: '<i class="mdi mdi-export-variant me-sm-1"></i> <span>Export</span>',
                        buttons: [
                            {
                                extend: 'print',
                                text: '<i class="mdi mdi-printer-outline me-1"></i>Print',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'csv',
                                text: '<i class="mdi mdi-file-document-outline me-1"></i>CSV',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'excel',
                                text: '<i class="mdi mdi-file-excel-outline me-1"></i>Excel',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 3, 4, 5, 6, 7]}
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="mdi mdi-file-pdf-box me-1"></i>PDF',
                                className: 'dropdown-item',
                                customize: function (doc) {
                                    doc.content[1].table.widths = ['10%', '10%', '15%', '15%', '10%', '10%', '10%', '20%'];
                                },
                                exportOptions:
                                    {
                                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
                                    }
                            }
                        ]
                    },

                    ]
                },
            )

        })

    </script>
@endpush
