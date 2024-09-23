@extends('layouts.app')
@section('content')

    <div class="row row-cols-1 row-cols-md-4 g-4 mb-4">
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-success rounded">
                                <i class="mdi mdi-cart mdi-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center gap-1">
                                <h4 class="mb-0">45</h4>
                                <div class="d-flex align-items-center gap-1">
                                    <i class="mdi mdi-chevron-down text-danger"></i>
                                </div>
                            </div>
                            <small>All Orders</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-info rounded">
                                <i class="mdi mdi-information-outline mdi-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center gap-1">
                                <h4 class="mb-0">50</h4>
                                <div class="d-flex align-items-center gap-1">
                                    <i class="mdi mdi-chevron-up text-success"></i>
                                    <p class="mb-0 text-success me-1">18.2%</p>
                                </div>
                            </div>
                            <small>Registration Requests</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-warning rounded">
                                <i class="mdi mdi-account-outline mdi-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center gap-1">
                                <h4 class="mb-0">35</h4>
                            </div>
                            <small>Registered Users</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-danger rounded">
                                <i class="mdi mdi-alert-outline mdi-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center gap-1">
                                <h4 class="mb-0">40</h4>
                                <div class="d-flex align-items-center gap-1">
                                    <i class="mdi mdi-chevron-up text-success"></i>
                                </div>
                            </div>
                            <small>SOS Alerts</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4 class="text-center">Order Progress Snapshot</h4>
            <div class="d-flex align-items-center justify-content-center">
                <canvas id="pie-chart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

@endsection
