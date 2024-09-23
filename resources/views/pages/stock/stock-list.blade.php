@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-uppercase mb-0"><span class="text-muted">Stock</span> <span class="mx-2">/</span> All
                Stock</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-datatable table-responsive">
            <table id="stock_list" class="table table-striped" style="width:100%">
                <thead>
                <tr>
                    <th>Branch</th>
                    <th>Purchase Order No</th>
                    <th>Build Date</th>
                    <th>Supplier Name</th>
                    <th>Item Name(s)</th>
                    <th>Total Cost</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($stockList as $stock)
                    <tr>
                        <td>{{$stock->branches?->name}}</td>
                        <td>{{$stock->stock_no}}</td>
                        <td>{{$stock->build_date}}</td>
                        <td>{{$stock->supplier?->name}}</td>
                        <td>{{$stock->stockItem?->item_names}}</td>
                        <td>{{'Rs. '.number_format($stock?->final_total,2)}}</td>
                        <td>

                            <a href="{{route('stock.edit',$stock->id)}}"
                               title="Edit"
                               class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                            >
                                <i class="mdi mdi-pencil-outline" style="color: #ff8000;"></i>
                            </a>
                            <a href="#"
                               title="Delete"
                               class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                               onclick="deleteStock({{$stock->id}})"
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
            $('#stock_list').DataTable(
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
                                exportOptions: {columns: [0, 1, 3, 4, 5]}
                            },
                            {
                                extend: 'csv',
                                text: '<i class="mdi mdi-file-document-outline me-1"></i>CSV',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 3, 4, 5]}
                            },
                            {
                                extend: 'excel',
                                text: '<i class="mdi mdi-file-excel-outline me-1"></i>Excel',
                                className: 'dropdown-item',
                                exportOptions: {columns: [0, 1, 3, 4, 5]}
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
                            text: 'Add Stock',
                            className: 'btn btn-info',
                            action: function (e, dt, node, config) {
                                window.location.href = './stock/create';
                            }
                        }
                    ]
                },
            )

        })

    </script>
    <script>
        function deleteStock(id) {
            const csrfToken = $('meta[name="csrf-token"]').attr('content')
            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this Item!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, proceed with the AJAX delete call
                    $.ajax({
                        url: '/item/destroy/' + id,
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
