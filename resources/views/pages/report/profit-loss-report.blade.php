@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="text-uppercase mb-0"><span class="text-muted">Report</span> <span class="mx-2">/</span>
                    Financial Report</h5>
            </div>
        </div>

        <!-- Filter Form -->
        <form action="" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <label for="branch_id">Branch</label>
                    <select name="branch_id" id="branch_id" class="form-select select2">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $branchId == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="start_date">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control"
                           value="{{ $startDate }}">
                </div>

                <div class="col-md-3">
                    <label for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
                </div>

                <div class="col-md-3  d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                </div>
            </div>
        </form>

        <hr>

        <!-- Financial Summary -->
        <div class="card" style="margin-top: 20px">
            <div class="card-datatable table-responsive">
                <div class="row">
                    <div class="col-md-3" style="margin-top: 20px">
                        <h5>Total Revenue: {{ number_format($totalRevenue, 2) }}</h5>
                    </div>
                    <div class="col-md-3" style="margin-top: 20px">
                        <h5>Total Cost: {{ number_format($totalCost, 2) }}</h5>
                    </div>
                    <div class="col-md-3" style="margin-top: 20px">
                        <h5>Total Profit: {{ number_format($totalProfit, 2) }}</h5>
                    </div>
                    <div class="col-md-3" style="margin-top: 20px">
                        <h5>Total Discounts: {{ number_format($totalDiscount, 2) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
