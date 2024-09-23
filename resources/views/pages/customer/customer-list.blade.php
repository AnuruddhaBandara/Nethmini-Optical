@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-uppercase mb-0"><span class="text-muted">Customer</span> <span class="mx-2">/</span> All
                Customer</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-datatable table-responsive">
            <table id="customer_list" class="table table-striped" style="width:100%">
                <thead>
                <tr>
                    @role('admin')
                    <th>Branch</th>
                    @endrole
                    <th>customer Full Name</th>
                    <th>Email</th>
                    <th>NIC No.</th>
                    <th>Contact No.</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($customerList as $customer)
                    <tr>
                        @role('admin')
                        <td>{{ucfirst($supplier->branches->name)}}</td>
                        @endrole
                        <td>{{$customer->first_name.' '.$customer->last_name}}</td>
                        <td>{{$customer->email}}</td>
                        <td>{{$customer->nic}}</td>
                        <td>{{$customer->phone}}</td>
                        <td>

                            <a href="{{route('customer.edit',$customer->id)}}"
                               title="Edit"
                               class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                            >
                                <i class="mdi mdi-pencil-outline" style="color: #ff8000;"></i>
                            </a>
                            <a href="#"
                               title="Delete"
                               class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                               onclick="deleteCustomer({{$customer->id}})"
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
                            exportOptions: {columns: [0, 1, 2, 3, 4]}
                        },
                        {
                            extend: 'csv',
                            text: '<i class="mdi mdi-file-document-outline me-1"></i>CSV',
                            className: 'dropdown-item',
                            exportOptions: {columns: [0, 1, 2, 3, 4]}
                        },
                        {
                            extend: 'excel',
                            text: '<i class="mdi mdi-file-excel-outline me-1"></i>Excel',
                            className: 'dropdown-item',
                            exportOptions: {columns: [0, 1, 2, 3, 4]}
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="mdi mdi-file-pdf-box me-1"></i>PDF',
                            className: 'dropdown-item',
                            customize: function (doc) {
                                doc.content[1].table.widths = ['15%', '25%', '20%', '20%', '20%'];
                            },
                            exportOptions: {columns: [0, 1, 2, 3, 4]}
                        }
                    ]
                },

                    {
                        text: 'Add Customer',
                        className: 'btn btn-info',
                        action: function (e, dt, node, config) {
                            window.location.href = './customer/create';
                        }
                    }
                ]

            };
            // Customize for clerk role
            if (userRole === '2') {
                dataTableOptions.buttons = [{
                    text: 'Add Item',
                    className: 'btn btn-info',
                    action: function (e, dt, node, config) {
                        window.location.href = './customer/create';
                    }
                }]; // Remove export buttons for clerks
                dataTableOptions.columnDefs = []; // Customize columns shown to clerks if necessary
            }

            // Initialize DataTable with dynamic options
            $('#customer_list').DataTable(dataTableOptions);
        });

    </script>
    <script>
        function deleteCustomer(id) {
            const csrfToken = $('meta[name="csrf-token"]').attr('content')
            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this Supplier!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, proceed with the AJAX delete call
                    $.ajax({
                        url: '/customer/destroy/' + id,
                        type: 'GET',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            Swal.fire({
                                title: "Done!",
                                text: "Item deleted Successfully!!",
                                icon: "success",
                                confirmButtonText: "OK",
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
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
