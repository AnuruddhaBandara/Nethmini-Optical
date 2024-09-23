@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-uppercase mb-0"><span class="text-muted">Supplier</span> <span class="mx-2">/</span> Add
                Supplier
            </h5>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body p-0">
                    <form action="{{route('supplier.store')}}" method="post" enctype="multipart/form-data"
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
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name"
                                           placeholder="Enter the item name" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email"
                                           placeholder="Enter the supplier email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Contact No.</label>
                                    <input type="text" class="form-control" name="phone"
                                           placeholder="Enter the supplier Phone Number" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" cols="10" rows="5"></textarea>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Province</label>
                                    <select class="form-select select2" name="province">
                                        <option value="" selected disabled>Select Province</option>
                                        @foreach($provinces as $province)
                                            <option value="{{$province->name_en}}">{{$province->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">District</label>
                                    <select class="form-select select2" name="district">
                                        <option value="" selected disabled>Select District</option>
                                        @foreach($districts as $district)
                                            <option value="{{$district->name_en}}">{{$district->name_en}}</option>
                                        @endforeach
                                    </select>
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
            showAlert('success', "{{ session('success') }}", "/supplier");

        </script>
    @elseif(session('error'))
        <script>
            showAlert('error', "{{ session('error') }}", "/supplier");

        </script>
    @endif
@endpush
