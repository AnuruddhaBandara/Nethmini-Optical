@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-uppercase mb-0"><span class="text-muted">Category</span> <span class="mx-2">/</span> Add
                Category
            </h5>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body p-0">
                    <form action="{{route('category.store')}}" method="post">
                        @csrf
                        <div class="px-3 py-4">
                            @role('admin')
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Branch</label>
                                    <select class="form-select select2" name="branch"
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
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" name="name"
                                               placeholder="Enter the category name" required>
                                        <label>Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" name="description"
                                               placeholder="Enter the category description">
                                        <label>Description</label>
                                    </div>
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
            showAlert('success', "{{ session('success') }}", "/category");

        </script>
    @elseif(session('error'))
        <script>
            showAlert('error', "{{ session('error') }}", "/category");

        </script>
    @endif
@endpush
