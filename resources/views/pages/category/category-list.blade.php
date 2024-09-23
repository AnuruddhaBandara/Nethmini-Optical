@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-uppercase mb-0"><span class="text-muted">Category</span> <span class="mx-2">/</span> All
                Category</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-datatable table-responsive">
            <table id="category_list" class="table table-striped" style="width:100%">
                <thead>
                <tr>
                    @role('admin')
                    <th>Branch</th>
                    @endrole
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categoryList as $category)

                    <tr>
                        @role('admin')
                        <td>{{ucfirst($category->branches->name)}}</td>
                        @endrole
                        <td>{{ucfirst($category->name)}}</td>
                        <td>{{$category->description}}</td>
                        <td>

                            <a href="{{route('category.edit', $category->id)}}"
                               title="Edit"
                               class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                            >
                                <i class="mdi mdi-pencil-outline" style="color: #ff8000;"></i>
                            </a>
                            <a href="#"
                               title="Delete"
                               class="btn btn-sm btn-text-secondary rounded-pill btn-icon"
                               onclick="deleteCategory({{$category->id}})"
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
                            exportOptions: {columns: [0, 1, 2]}
                        },
                        {
                            extend: 'csv',
                            text: '<i class="mdi mdi-file-document-outline me-1"></i>CSV',
                            className: 'dropdown-item',
                            exportOptions: {columns: [0, 1, 2]}
                        },
                        {
                            extend: 'excel',
                            text: '<i class="mdi mdi-file-excel-outline me-1"></i>Excel',
                            className: 'dropdown-item',
                            exportOptions: {columns: [0, 1, 2]}
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="mdi mdi-file-pdf-box me-1"></i>PDF',
                            className: 'dropdown-item',
                            exportOptions: {columns: [0, 1, 2]}
                        }
                    ]
                },

                    {
                        text: 'Add Category',
                        className: 'btn btn-info',
                        action: function (e, dt, node, config) {
                            window.location.href = './category/create';
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
                        window.location.href = './category/create';
                    }
                }]; // Remove export buttons for clerks
                dataTableOptions.columnDefs = []; // Customize columns shown to clerks if necessary
            }

            // Initialize DataTable with dynamic options
            $('#category_list').DataTable(dataTableOptions);

        });
    </script>
    <script>
        function deleteCategory(id) {
            const csrfToken = $('meta[name="csrf-token"]').attr('content')
            Swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this Category!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, proceed with the AJAX delete call
                    $.ajax({
                        url: '/category/destroy/' + id,
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
                                text: "Category deleted Successfully!!",
                                icon: "success",
                                showCancelButton: false,
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
