@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-uppercase mb-0"><span class="text-muted">Item</span> <span class="mx-2">/</span> Edit
                Item
            </h5>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body p-0">
                    <form action="{{route('item.update',$item->id)}}" method="post" enctype="multipart/form-data"
                          autocomplete="off">
                        @csrf
                        <div class="px-3 py-4">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Category List</label>
                                    <select class="form-select" name="category_id" required>
                                        <option value="{{$selectedCategory->id}}"
                                                selected>{{$selectedCategory->name}}</option>
                                        @foreach($categoryList as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>

                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name"
                                           placeholder="Enter the item name" value="{{$item->name}}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Purchase Cost</label>
                                    <input type="number" class="form-control" name="purchase_cost"
                                           placeholder="Enter the item purchase cost" value="{{$item->purchase_cost}}"
                                           required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Selling Price</label>
                                    <input type="number" class="form-control" name="selling_price"
                                           placeholder="Enter the item selling price" value="{{$item->selling_price}}"
                                           required>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Item Brand</label>
                                    <input type="text" class="form-control" name="brand"
                                           placeholder="Enter the item brand" value="{{$item->brand}}">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Item Color</label>
                                    <input type="color" class="form-control" name="color"
                                           placeholder="Select the color" value="{{$item->color}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" name="description"
                                           placeholder="Enter the Description" value="{{$item->description}}">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Add Image</label>
                                    <input type="file" class="form-control" name="file" value="{{$item->image}}"
                                           accept="image/png, image/jpeg, image/jpg">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="submit" class="btn btn-warning" value="Update">
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
@endpush
