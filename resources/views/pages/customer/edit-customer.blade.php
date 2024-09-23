@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-uppercase mb-0"><span class="text-muted">Customer</span> <span class="mx-2">/</span> Edit
                Customer
            </h5>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body p-0">
                    <form action="{{route('customer.update', $customer->id)}}" method="post"
                          enctype="multipart/form-data"
                          autocomplete="off">
                        @csrf
                        <div class="px-3 py-4">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="first_name"
                                           value="{{$customer->first_name}}"
                                           placeholder="Enter the customer first name" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="last_name"
                                           value="{{$customer->last_name}}"
                                           placeholder="Enter the customer last name">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Nic No</label>
                                    <input type="text" class="form-control" name="nic" value="{{$customer->nic}}"
                                           placeholder="Enter the customer nic" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{$customer->email}}"
                                           placeholder="Enter the customer email">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Contact No.</label>
                                    <input type="text" class="form-control" name="phone" value="{{$customer->phone}}"
                                           placeholder="Enter the customer Phone Number" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" cols="10"
                                              rows="5">{{$customer->address}}</textarea>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Province</label>
                                    <select class="form-select select2" name="province">
                                        <option value="" selected disabled>Select Province</option>
                                        @foreach($provinces as $province)
                                            <option
                                                value="{{$province->name_en}}" {{($customer->province == $province->name_en)? 'selected' : ''}}>{{$province->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">District</label>
                                    <select class="form-select select2" name="district">
                                        <option value="" disabled>Select District</option>
                                        @foreach($districts as $district)
                                            <option
                                                value="{{$district->name_en}}" {{($customer->district == $district->name_en)? 'selected' : ''}}>{{$district->name_en}}</option>
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
