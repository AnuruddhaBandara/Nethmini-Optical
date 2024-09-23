@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-uppercase mb-0"><span class="text-muted">Order</span> <span class="mx-2">/</span> All
                Order</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-datatable table-responsive">
            <table id="order_list" class="table table-striped" style="width:100%">
                <thead>
                <tr>
                    @role('admin')
                    <th>Branch</th>
                    @endrole
                    <th>Invoice No</th>
                    <th>Order Date</th>
                    <th>Customer Details</th>
                    <th>Item Name(s)</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orderList as $order)
                    <tr>
                        @role('admin')
                        <td>{{$order->branches->name}}</td>
                        @endrole
                        <td>{{$order->invoice_number}}</td>
                        <td>{{date('d M Y h:i A', strtotime($order->created_at))}}</td>
                        <td>
                            @if(!empty($order->customer))
                                <span

                                    class="dt-name">{{$order->customer->first_name .' ' }}{{($order->customer->last_name != null) ? $order->customer->last_name : '' }}</span>
                                <br>
                                <a href="tel:{{$order->customer->phone}}"
                                   class="dt-name fw-normal">{{$order->customer->phone}}</a><br>
                                <a href="mailto:{{$order->customer->email}}"
                                   class="dt-name fw-normal">{{$order->customer->email}}</a>
                            @endif
                        </td>
                        <td>
                            {{$order->orderItem?->item_names}}
                        </td>
                        <td>
                            {{$order->final_total}}
                        </td>
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
                        <td>
                            <a href="{{route('order.view',$order->id)}}"
                               title="View"
                               class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                            >
                                <i class="mdi mdi-eye-arrow-right-outline" style="color: #0a14ad;"></i>
                            </a>
                            <a href="{{route('order.edit',$order->id)}}"
                               title="Edit"
                               class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                            >
                                <i class="mdi mdi-pencil-outline" style="color: #ff8000;"></i>
                            </a>

                            <a href="#"
                               title="Delete"
                               class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                               onclick="deleteOrder({{$order->id}})"
                            >
                                <i class="mdi mdi-delete" style="color: #800000"></i>
                            </a>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            let userRole = '{{ $userRoleId }}';

            let dataTableOptions = {
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
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
                        },
                        {
                            extend: 'csv',
                            text: '<i class="mdi mdi-file-document-outline me-1"></i>CSV',
                            className: 'dropdown-item',
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
                        },
                        {
                            extend: 'excel',
                            text: '<i class="mdi mdi-file-excel-outline me-1"></i>Excel',
                            className: 'dropdown-item',
                            exportOptions: {columns: [0, 1, 2, 3, 4, 5]}
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="mdi mdi-file-pdf-box me-1"></i>PDF',
                            className: 'dropdown-item',
                            customize: function (doc) {
                                doc.content[1].table.widths = ['25%', '20%', '15%', '15%', '15%', '10%'];
                            },
                            exportOptions:
                                {
                                    columns: [0, 1, 2, 3, 4, 5],
                                }
                        }
                    ]
                },

                    {
                        text: 'Add New Order',
                        className: 'btn btn-info',
                        action: function (e, dt, node, config) {
                            window.location.href = './order/create';
                        }
                    }]
            };

            if (userRole === '2') {
                dataTableOptions.buttons = [{
                    text: 'Add New Order',
                    className: 'btn btn-info',
                    action: function (e, dt, node, config) {
                        window.location.href = './order/create';
                    }
                }]; // Remove export buttons for clerks
                dataTableOptions.columnDefs = []; // Customize columns shown to clerks if necessary
            }

            // Initialize DataTable with dynamic options
            $('#order_list').DataTable(dataTableOptions);
        });

    </script>
    <script>
        function deleteOrder(id) {
            const csrfToken = $('meta[name="csrf-token"]').attr('content')
            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this Order!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, proceed with the AJAX delete call
                    $.ajax({
                        url: '/order/destroy/' + id,
                        type: 'GET',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            Swal.fire({
                                title: "Success",
                                text: "Order deleted Successfully!!",
                                icon: "success",
                                // confirmButtonText: "OK",
                                // allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    console.log(result)
                                    window.location.reload();
                                }
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error('Error fetching data.');
                            console.log('XHR Status: ' + status);
                            console.log('Error: ' + error); // Log error message
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        }

    </script>
@endpush
