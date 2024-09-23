@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="text-uppercase mb-0"><span class="text-muted">Report</span> <span class="mx-2">/</span> Sales
                    Report</h5>
            </div>
        </div>

        <!-- Filter Form -->
        <form action="" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <label for="branch_id">Branch</label>
                    <select class="form-select select2" name="branch_id" id="branch_id" class="form-control">
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
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                </div>
            </div>
        </form>

        <hr>

        <!-- Sales Summary -->
        <div class="row">
            <div class="col-md-3">
                <h5>Total Sales: {{ number_format($totalSales, 2) }}</h5>
            </div>
            <div class="col-md-3">
                <h5>Total Discount: {{ number_format($totalDiscount, 2) }}</h5>
            </div>
            <div class="col-md-3">
                <h5>Payment Received: {{ number_format($totalPaymentReceived, 2) }}</h5>
            </div>
            <div class="col-md-3">
                <h5>Remaining Payments: {{ number_format($totalRemainingPayments, 2) }}</h5>
            </div>
        </div>

        <div class="card" style="margin-top: 20px">
            <div class="card-datatable table-responsive">
                <!-- Sales Table -->
                <table id="sale-report-list" class="table table-striped" style="width:100%">
                    <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Customer</th>
                        <th>Branch</th>
                        <th>Sub Total</th>
                        <th>Discount</th>
                        <th>Final Total</th>
                        <th>Payment Received</th>
                        <th>Remaining Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->invoice_number }}</td>
                            <td>{{ $order->customer->first_name.' ' . $order->customer->last_name }}</td>
                            <td>{{ $order->branch->name }}</td>
                            <td>{{ number_format($order->sub_total, 2) }}</td>
                            <td>{{ number_format($order->discount, 2) }}</td>
                            <td>{{ number_format($order->final_total, 2) }}</td>
                            <td>{{ number_format($order->payment_received, 2) }}</td>
                            <td>{{ number_format($order->remaining_payment, 2) }}</td>
                            <td>
                                @if($order->status == 1)
                                    <span class="badge rounded-pill bg-label-warning">Pending</span>
                                @elseif($order->status == 2)
                                    <span class="badge rounded-pill bg-label-success">Completed</span>
                                @elseif($order->status == 3)
                                    <span class="badge rounded-pill bg-label-info">Delivered</span>
                                @elseif($order->status == 4)
                                    <span class="badge rounded-pill bg-label-danger">Canceled</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No sales data found.</td>
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
            $('#sale-report-list').DataTable(
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
                                exportOptions: {columns: [0, 1, 3, 4, 5, 6, 7, 8, 9]}
                            },
                            {
                                extend: 'csv',
                                text: '<i class="mdi mdi-file-document-outline me-1"></i>CSV',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 3, 4, 5, 6, 7, 8, 9]}
                            },
                            {
                                extend: 'excel',
                                text: '<i class="mdi mdi-file-excel-outline me-1"></i>Excel',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 3, 4, 5, 6, 7, 8, 9]}
                            },
                            {
                                extend: 'pdfHtml5',
                                text: '<i class="mdi mdi-file-pdf-box me-1"></i>PDF',
                                className: 'dropdown-item',
                                customize: function (doc) {
                                    doc.content[1].table.widths = ['10%', '10%', '10%', '10%', '10%', '10%', '10%', '10%', '10%', '10%'];
                                },
                                exportOptions:
                                    {
                                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
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
