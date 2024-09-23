@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-uppercase mb-0"><span class="text-muted">Item</span> <span class="mx-2">/</span> All
                Item</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-datatable table-responsive">
            <table id="item_list" class="table table-striped" style="width:100%">
                <thead>
                <tr>
                    @role('admin')
                    <th>Branch</th>
                    @endrole
                    <th>Item Name</th>
                    <th>Item Image</th>
                    <th>Purchase Cost</th>
                    <th>Selling Cost</th>
                    <th>Item Brand</th>
                    <th>Item Colour</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itemList as $item)
                    @php
                        if(!empty($item->image)){
                            $path = public_path('uploads/item_image').'/'.$item->image;
                        } else{
                            $path = public_path('uploads/placeholder.jpg');
                        }
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/'.$type.';base64,'.base64_encode($data);
                    @endphp
                    <tr>
                        @role('admin')
                        <td>{{ucfirst($item->branches->name)}}</td>
                        @endrole
                        <td>{{$item->name}}</td>
                        <td> @if(!empty($item->image) && file_exists(public_path('uploads/item_image/'.$item->image)))
                                <img src="{{ $base64 }}" id="img_id"
                                     class="img-fluid"
                                     height="80" width="80">
                            @else
                                <img src="{{ $base64 }}" height="80" width="80"
                                     alt="No Image">
                            @endif
                        </td>
                        <td>{{'Rs. '.number_format($item->purchase_cost,2)}}</td>
                        <td>{{'Rs. '.number_format($item->selling_price,2)}}</td>
                        <td>{{$item->brand}}</td>
                        <td>
                            <div class="color-box" style="background-color: {{ $item->color }};"></div>
                        </td>
                        <td>

                            <a href="{{route('item.edit',$item->id)}}"
                               title="Edit"
                               class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                            >
                                <i class="mdi mdi-pencil-outline" style="color: #ff8000;"></i>
                            </a>
                            <a href="#"
                               title="Delete"
                               class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                               onclick="deleteItem({{$item->id}})"
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
                columnDefs: [
                    {
                        targets: 3, // Index of the "Purchase cost" column
                        render: function (data, type, row) {
                            if (type === 'display' || type === 'filter') {
                                return data.replace(/,/g, '');
                            }
                            return data;
                        }
                    },
                    {
                        targets: 4, // Index of the "Selling Price" column
                        render: function (data, type, row) {
                            if (type === 'display' || type === 'filter') {
                                return data.replace(/,/g, '');
                            }
                            return data;
                        }
                    }
                ],
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
                            exportOptions: {columns: [0, 1, 3, 4, 5, 6]}
                        },
                        {
                            extend: 'csv',
                            text: '<i class="mdi mdi-file-document-outline me-1"></i>CSV',
                            className: 'dropdown-item',
                            exportOptions: {columns: [0, 1, 3, 4, 5, 6]}
                        },
                        {
                            extend: 'excel',
                            text: '<i class="mdi mdi-file-excel-outline me-1"></i>Excel',
                            className: 'dropdown-item',
                            exportOptions: {columns: [0, 1, 3, 4, 5, 6]}
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="mdi mdi-file-pdf-box me-1"></i>PDF',
                            className: 'dropdown-item',
                            customize: function (doc) {
                                doc.content[1].table.widths = ['10%', '20%', '15%', '15%', '15%', '15%', '10%'];
                                doc.content[1].table.body.forEach(function (row) {
                                    row.forEach(function (cell, index) {
                                        if (index === 2 && typeof cell.text === 'string' && cell.text.startsWith('data:image')) {
                                            cell.image = cell.text;
                                            cell.fit = [50, 50];
                                            delete cell.text;
                                        }
                                        if (index === 6 && typeof cell.text === 'string') {
                                            var divElement = document.createElement('div');
                                            divElement.innerHTML = cell.text;
                                            var colorBox = divElement.querySelector('.color-box');
                                            if (colorBox) {
                                                var backgroundColor = colorBox.style.backgroundColor;
                                                var rgb = backgroundColor.match(/\d+/g);
                                                if (rgb) {
                                                    cell.fillColor = [parseInt(rgb[0]), parseInt(rgb[1]), parseInt(rgb[2])];
                                                    cell.text = ''; // Remove text content
                                                }
                                            }
                                        }
                                    });
                                });
                            },
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6],
                                format: {
                                    body: function (data, row, column, node) {
                                        if (column === 2) {
                                            let imgElement = node.querySelector('img');
                                            if (imgElement) {
                                                return imgElement.src; // Return the Base64 string
                                            }
                                        }
                                        if (column === 6) {
                                            let colorBox = node.querySelector('.color-box');
                                            if (colorBox) {
                                                return '<div class="color-box" style="background-color: ' + colorBox.style.backgroundColor + ';"></div>';
                                            }
                                        }
                                        return data;
                                    }
                                },
                            }
                        }
                    ]
                },
                    {
                        text: 'Add Item',
                        className: 'btn btn-info',
                        action: function (e, dt, node, config) {
                            window.location.href = './item/create';
                        }
                    }]
            };

            // Customize for clerk role
            if (userRole === '2') {
                dataTableOptions.buttons = [{
                    text: 'Add Item',
                    className: 'btn btn-info',
                    action: function (e, dt, node, config) {
                        window.location.href = './item/create';
                    }
                }]; // Remove export buttons for clerks
                dataTableOptions.columnDefs = []; // Customize columns shown to clerks if necessary
            }

            // Initialize DataTable with dynamic options
            $('#item_list').DataTable(dataTableOptions);
        });

    </script>
    <script>
        function deleteItem(id) {
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
