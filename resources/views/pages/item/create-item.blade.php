@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-uppercase mb-0"><span class="text-muted">Item</span> <span class="mx-2">/</span> Add
                Item
            </h5>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body p-0">
                    <form action="{{route('item.store')}}" method="post" enctype="multipart/form-data"
                          autocomplete="off">
                        @csrf
                        <div class="px-3 py-4">
                            @role('admin')
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Branch</label>
                                    <select class="form-select select2" name="branch" id="branchSelect"
                                            @role('admin') required @endrole>
                                        <option value="" selected disabled>Select Branch</option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->id}}">{{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endrole
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Category List</label>
                                    <select class="form-select select2" name="category_id" id="category" required>
                                        <option selected disabled>Select Category</option>
                                        @foreach($categoryList as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>

                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name"
                                           placeholder="Enter the item name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Purchase Cost</label>
                                    <input type="number" class="form-control" name="purchase_cost"
                                           placeholder="Enter the item purchase cost" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Selling Price</label>
                                    <input type="number" class="form-control" name="selling_price"
                                           placeholder="Enter the item selling price" required>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Item Brand</label>
                                    <input type="text" class="form-control" name="brand"
                                           placeholder="Enter the item brand">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Item Color</label>
                                    <input type="color" class="form-control" name="color"
                                           placeholder="Select the color">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="description"
                                           placeholder="Enter the Description">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Add Image</label>
                                    <input type="file" class="form-control" name="file"
                                           accept="image/png, image/jpeg, image/jpg">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="submit" class="btn btn-success" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @if(session('success'))
        <script>
            showAlert('success', "{{ session('success') }}", "/item");

        </script>
    @elseif(session('error'))
        <script>
            showAlert('error', "{{ session('error') }}", "/item");

        </script>
    @endif
    <script>
        $(document).ready(function () {
            $('#branchSelect').change(function () {
                let branchId = this.value;
                let categorySelect = document.getElementById('category');

                // Clear existing options
                categorySelect.innerHTML = '<option selected disabled>Select Category</option>';

                if (branchId) {
                    // Fetch categories based on the selected branch
                    fetch(`/item/categories-by-branch/${branchId}`)
                        .then(response => response.json())
                        .then(categories => {
                            categories.forEach(category => {
                                let option = document.createElement('option');
                                option.value = category.id;
                                option.textContent = category.name;
                                categorySelect.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error fetching categories:', error));
                }
            });

        });

    </script>
@endpush
