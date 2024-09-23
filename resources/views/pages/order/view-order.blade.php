@extends('layouts.app')
@section('content')
    <style>
        /* Table header color */
        .table thead th {
            background-color: #3a3a3a;
            color: #ffffff;
            padding: 15px;
        }

        .table {
            margin-top: 40px;
        }

        .table, .table th, .table td {
            border: 1px solid #555555;
        }
    </style>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-uppercase mb-0"><span class="text-muted">Order</span> <span class="mx-2">/</span> Edit
                Order
            </h5>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body p-0">
                    <div class="px-3 py-4">
                        @role('admin')
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Branch</label>
                                <input type="text" value="{{$orderDetails->branches->name}}" class="form-control"
                                       readonly/>
                            </div>
                        </div>
                        @endrole
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="supplier" class="form-label">Customer</label>
                                <input type="text"
                                       value="{{$orderDetails->customer->first_name. ' '. $orderDetails->customer->first_name. ' - '.$orderDetails->customer->nic}}"
                                       class="form-control" readonly/>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="supplier" class="form-label">Invoice Number</label>
                                <input type="text"
                                       value="{{$orderDetails->invoice_number}}"
                                       class="form-control" readonly/>
                            </div>
                        </div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Category</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Sale Price</th>
                                <th>Discount</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody class="table-row">
                            @foreach($orderItems as $item)
                                <tr>
                                    <td>{{$item->category->name}}</td>
                                    <td>{{$item->items->name}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{'Rs. '.number_format($item->sale_price,2)}}</td>
                                    <td>{{'Rs. '.number_format($item->discount,2)}}</td>
                                    <td>{{'Rs. '.number_format($item->total,2)}}</td>
                                </tr>
                            @endforeach
                            @foreach($lensDetails as $lens)
                                <tr>
                                    <td colspan="3">{{$lens->lens_name}}</td>
                                    <td>{{'Rs. '.number_format($lens->lens_price,2)}}</td>
                                    <td>{{'Rs. '.number_format($lens->discount,2)}}</td>
                                    <td>{{'Rs. '.number_format(($lens->lens_price - $lens->discount),2)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tbody>
                            <tr>
                                <td colspan="5" style="text-align: right;font-size: 18px"><b>Sub Total</b></td>
                                <td style="font-size: 18px">{{'Rs. '.number_format($orderDetails->sub_total,2)}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row" style="margin-top: 40px">
                            <div class="col-md-6 mb-4">
                                <label for="discount" class="form-label">Discount</label>
                                <input type="text" class="form-control"
                                       value="{{'Rs. '.number_format($orderDetails->discount,2)}}" readonly>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="finalTotal" class="form-label">Final Total</label>
                                <input type="text" class="form-control"
                                       value="{{'Rs. '.number_format($orderDetails->final_total,2)}}" readonly>
                            </div>
                        </div>
                        <hr style="border: 1px solid #6c757d;">
                        <div class="row" style="margin-top: 40px">
                            <div class="col-md-3 mb-3">
                                <label for="payment_received" class="form-label">Payment Received</label>
                                <input type="text" placeholder="0.00" class="form-control"
                                       value="{{'Rs. '.$orderDetails->payment_received}}" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="remaining_payment" class="form-label">Remaining Payment</label>
                                <input type="text" placeholder="0.00" class="form-control"
                                       value="{{'Rs.'.$orderDetails->remaining_payment}}" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="payment_method" class="form-label">Payment Method</label>
                                <input type="text" class="form-control" value="{{$orderDetails->payment_method}}"
                                       readonly/>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="remark" class="form-label">Remark </label>
                                <input type="text" class="form-control" value="{{$orderDetails->remark}}" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="ic-sticky-top">
                <div class="card">
                    <div class="card-header bg-light-grey">
                        <h6 class="fw-semibold mb-0">Invoice</h6>
                    </div>
                    <div class="card-body p-0">
                        <form id="invoiceForm" action="{{route('order.download-invoice')}}" method="get">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $orderDetails->id }}">
                            <div class="d-flex flex-column gap-3 p-3">
                                <div class="form-floating form-floating-outline">
                                    <label class="form-label">Select Invoice Type</label>
                                    <select class="form-select select2" name="invoice" id="invoice">
                                        <option value="" selected disabled>Select Status</option>
                                        @foreach($invoiceType as $invoice)
                                            <option value="{{$invoice->id}}">{{$invoice->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-secondary">
                                    <i class="mdi mdi-download"></i> Download
                                </button>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.getElementById('invoiceForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission
            let invoiceId = document.getElementById('invoice').value,

                if
            (invoiceId)
            {
                // Construct the URL for the download
                let downloadUrl = this.action + '?invoice_id=' + encodeURIComponent(invoiceId);

                // Redirect to the download URL
                window.location.href = downloadUrl;
            }
        else
            {
                alert('Please select an invoice type.');
            }
        });
    </script>

    {{--    <script>--}}
    {{--        function downloadInvoice() {--}}
    {{--            let invoiceStatusId = document.getElementById('invoice').value,--}}
    {{--                orderId = {{ $orderDetails->id }},--}}
    {{--                csrfToken = $('meta[name="csrf-token"]').attr('content');--}}
    {{--            console.log(invoiceStatusId, orderId);--}}
    {{--            $.ajax({--}}
    {{--                url: '/order/download-invoice/' + invoiceStatusId + '/' + orderId,--}}
    {{--                type: 'GET',--}}
    {{--                dataType: 'json',--}}
    {{--                headers: {--}}
    {{--                    'X-CSRF-TOKEN': csrfToken--}}
    {{--                },--}}
    {{--                processData: false,--}}
    {{--                contentType: false,--}}
    {{--                success: function (data) {--}}
    {{--                    location.reload();--}}
    {{--                    --}}{{--                   showAlert('success', "{{ session('success') }}", "/order");--}}
    {{--                },--}}
    {{--                error: function (xhr, status, error) {--}}
    {{--                    console.error('Error fetching data.');--}}
    {{--                    console.log('XHR Status: ' + status);--}}
    {{--                    console.log(error)--}}
    {{--                }--}}

    {{--            });--}}
    {{--        }--}}
    {{--    </script>--}}
@endpush
