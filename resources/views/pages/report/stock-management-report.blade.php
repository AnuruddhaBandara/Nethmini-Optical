@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="text-uppercase mb-0"><span class="text-muted">Report</span> <span class="mx-2">/</span>
                    Stock Management Report</h5>
            </div>
        </div>
        <form action="" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <label for="branch_id">Branch</label>
                    <select name="branch_id" id="branch_id" class="form-select select2" onchange="this.form.submit()">
                        <option value="0" {{ $branchId == 0 ? 'selected' : '' }}>All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $branchId == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
        <!-- Stock Table -->
        <div class="card" style="margin-top: 20px">
            <div class="card-datatable table-responsive">
                <table id="stock-management-list" class="table table-striped" style="width:100%">
                    <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Stock In</th>
                        <th>Stock Out</th>
                        <th>Available Stock</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($availableStock as $stock)
                        <tr>
                            <td>{{ $stock->item_id }}</td>
                            <td>{{ $stock->items?->name }}</td>
                            <td>{{ number_format($stock->stock_in) }}</td>
                            <td>{{ number_format($soldMap->get($stock->item_id)->stock_out ?? 0) }}</td>
                            <td>{{ number_format($stock->available_stock) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No stock data found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
