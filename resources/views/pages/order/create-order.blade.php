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
            <h5 class="text-uppercase mb-0"><span class="text-muted">Order</span> <span class="mx-2">/</span> Add
                Order
            </h5>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body p-0">
                    <div class="px-3 py-4">
                        @role('admin')
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Select Branch</label>
                                <select class="form-select select2" name="branch" id="branchSelect"
                                        @role('admin') required @endrole>
                                    <option value="" selected disabled>Select Branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                                    @endforeach
                                </select>
                                <span id="branchError" class="text-danger"></span>
                            </div>
                        </div>
                        @endrole
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="supplier" class="form-label">Select Customer</label>
                                <select class="form-select select2" id="customer" name="customer">
                                    <option selected disabled>Select Customer</option>
                                    @foreach($customerList as $customer)
                                        <option
                                            value="{{$customer->id}}">{{$customer->first_name. ' '. $customer->last_name. ' - '. $customer->nic}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 d-flex align-items-end">
                                <button class="btn btn-success" name="add_customer" id="add_customer"
                                >+ Add Customer
                                </button>
                            </div>
                        </div>
                        <!-- Add Lens Fees Button -->
                        <div class="row mb-4" style="margin-top: 20px">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-info" name="add_lens_fees" id="add_lens_fees">
                                    Add Lens Fees
                                </button>
                            </div>
                        </div>

                        <div id="stock-items">
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select select2 category-select" id="category"
                                            name="category">
                                        <option selected disabled>Select category</option>
                                        @foreach($categoryList as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="item" class="form-label">Item</label>
                                    <select class="form-select select2 itemSelect" id="item" name="item" disabled>
                                        <option selected disabled>Select item</option>
                                        @foreach($itemList as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="requireQuantity" class="form-label">Require Quantity</label>
                                    <input type="number" class="form-control" name="requireQuantity"
                                           id="requireQuantity">
                                    <span style="color:red" id="requireQuantityError"></span>
                                </div>
                                <div class="col">
                                    <label for="requireQuantity" class="form-label">Discount</label>
                                    <input type="number" class="form-control" name="discount"
                                           id="discount" placeholder="0.00">
                                </div>
                                <div class="col-auto d-flex align-items-end">
                                    <button type="button" class="btn btn-primary" id="add-item-btn"
                                            onclick="addTempStock()">
                                        <i class="fa fa-plus" aria-hidden="true"></i>Add To List
                                    </button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>
                                </th>
                                <th>Category</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Sale Price</th>
                                <th>Discount</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody class="table-row">

                            </tbody>
                            <tbody class="table-row-new">

                            </tbody>
                            <tbody>
                            <tr>
                                <td>
                                    <button class="btn btn-warning" onclick="deleteAllTempOrder()">Clear
                                        All
                                    </button>

                                </td>
                                <td colspan="5" style="text-align: right;font-size: 18px"><b>Sub Total</b></td>
                                <td style="font-size: 18px" id="subtotal">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row" style="margin-top: 40px">
                            <div class="col-md-6 mb-4">
                                <label for="discount" class="form-label">Discount</label>
                                <input type="text" class="form-control" id="discountTotal" name="discountTotal">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="finalTotal" class="form-label">Final Total</label>
                                <input type="text" class="form-control" id="finalTotal" name="finalTotal"
                                       value="" disabled>
                            </div>
                        </div>
                        <hr style="border: 1px solid #6c757d;">
                        <div class="row" style="margin-top: 40px">
                            <div class="col-md-3 mb-3">
                                <label for="payment_received" class="form-label">Payment Received</label>
                                <input type="number" placeholder="0.00" class="form-control" id="payment_received"
                                       name="payment_received">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="remaining_payment" class="form-label">Remaining Payment</label>
                                <input type="number" placeholder="0.00" class="form-control" id="remaining_payment"
                                       name="remaining_payment">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="payment_method" class="form-label">Payment Method</label>
                                <select class="form-select select2" name="payment_method" id="payment_method" required>
                                    <option selected disabled>Select Payment Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="Bank">Bank</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="remark" class="form-label">Remark </label>
                                <input type="text" class="form-control" id="remark"
                                       name="remark">
                            </div>
                        </div>
                        <div style="margin-top: 40px">
                            <input type="submit" class="btn btn-success" onclick="submitOrder()"
                                   value="Submit">
                            <input type="submit" class="btn btn-danger" value="Reset">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Customer Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form to add customer -->
                    <form id="addCustomerForm" action="{{route('customer.store')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="customerFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="customerFirstName" name="first_name">
                        </div>
                        <div class="mb-3">
                            <label for="customerLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="customerLastName" name="last_name">
                        </div>
                        <div class="mb-3">
                            <label for="customerNIC" class="form-label">NIC</label>
                            <input type="text" class="form-control" id="customerNIC" name="nic">
                        </div>
                        <div class="mb-3">
                            <label for="customerEmail" class="form-label">Email</label>
                            <input type="text" class="form-control" id="customerEmail" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="customerPhone" class="form-label">Contact No</label>
                            <input type="text" class="form-control" id="customerPhone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="customerAddress" class="form-label">Address</label>
                            <textarea class="form-control" id="customerAddress" name="address"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="province" class="form-label">Province</label>
                            <select class="form-select select2" name="province" id="province">
                                <option value="" selected disabled>Select Province</option>
                                @foreach($provinces as $province)
                                    <option value="{{$province->name_en}}">{{$province->name_en}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="district" class="form-label">District</label>
                            <select class="form-select select2" name="district" id="district">
                                <option value="" selected disabled>Select District</option>
                                @foreach($districts as $district)
                                    <option value="{{$district->name_en}}">{{$district->name_en}}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="submit" value="Save Customer" class="btn btn-success"
                           form="addCustomerForm"/>
                    <input type="submit" name="reset" value="Close" class="btn btn-secondary" data-bs-dismiss="modal"/>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Lens Fees Modal -->
    <div class="modal fade" id="lensFeeModal" tabindex="-1" aria-labelledby="lensFeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lensFeeModalLabel">Add Lens Fees</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="lensFeeForm">
                        <div class="mb-3">
                            <label for="lens_detail" class="form-label">Lens Details</label>
                            <input type="text" class="form-control" id="lens_detail" name="lens_detail"
                                   placeholder="Enter lens details" value="Lens Fees">
                        </div>
                        <div class="mb-3">
                            <label for="lens_cost" class="form-label">Lens Cost</label>
                            <input type="number" class="form-control" id="lens_cost" name="lens_cost"
                                   placeholder="0.00">
                        </div>
                        <div class="mb-3">
                            <label for="lens_fee" class="form-label">Lens Price</label>
                            <input type="number" class="form-control" id="lens_fee" name="lens_fee" placeholder="0.00">
                        </div>
                        <div class="mb-3">
                            <label for="lens_quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="lens_quantity" name="lens_quantity">
                            <span style="color:red" id="lensQuantityError"></span>
                        </div>
                        <div class="mb-3">
                            <label for="lens_discount" class="form-label">Discount</label>
                            <input type="number" class="form-control" id="lens_discount" name="lens_discount"
                                   placeholder="0.00">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addLensFees()">Add Fees</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let categorySelect = document.querySelector('.category-select');
            categorySelect.onchange = function () {
                let categoryId = this.value,
                    itemSelect = document.querySelector('.itemSelect');
                itemSelect.disabled = true;
                fetch(`/stock/get-item/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        var itemOptions = '<option selected disabled>Select item</option>';
                        data.forEach(function (item) {
                            itemOptions += `<option value="${item.id}">${item.name}</option>`;
                        });
                        itemSelect.innerHTML = itemOptions;
                        itemSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error fetching items:', error);
                        itemSelect.innerHTML = '<option selected disabled>Error loading items</option>';
                    });
            }
        });

        function addTempStock() {
            let categoryId = document.getElementById('category').value,
                itemId = document.getElementById('item').value,
                quantity = document.getElementById('requireQuantity').value,
                discount = document.getElementById('discount').value,
                csrfToken = $('meta[name="csrf-token"]').attr('content'),
                formData = new FormData(),
                userRoleId = '{{$userRole}}',
                quantityError = document.getElementById('requireQuantityError');
            if (userRoleId === '1') {
                let selectedOption = document.getElementById("branchSelect").options[document.getElementById("branchSelect").selectedIndex],
                    branchId = document.getElementById('branchSelect').value,
                    branchError = document.getElementById('branchError'),

                    branch = selectedOption.textContent;
                branchError.innerHTML = '';
                if (branch === 'Select Branch' || branch === null) {
                    branchError.innerHTML = 'Please select a branch.';
                    // e.preventDefault();
                    return false;
                }
                formData.append('branch', branchId);


            }

            quantityError.innerText = '';
            if (quantity === '') {
                quantityError.innerText = 'Please enter the quantity';
                return;
            }

            formData.append('category_id', categoryId);
            formData.append('item_id', itemId);
            formData.append('quantity', quantity);
            formData.append('discount', discount);


            $.ajax({
                    url: 'add-temp-orders/',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        let newRow = '';
                        newRow +=
                            `<tr class="new-table-row">
                                    <td><button class="btn btn-danger delete-btn" data-type="item" data-id="${data.id}"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                                    <td>${data.category}</td>
                                    <td>${data.item}</td>
                                    <td>${data.quantity}</td>
                                    <td>${data.cost}</td>
                                    <td>${data.discount}</td>
                                    <td>${data.total_cost}</td>
                                </tr>`;

                        const tbody = document.querySelector('.table-row');
                        tbody.insertAdjacentHTML('beforeend', newRow);

                        document.getElementById('subtotal').textContent = data.sub_total;

                        document.getElementById('finalTotal').value = data.sub_total;

                        document.getElementById('category').value = '';
                        document.getElementById('item').value = '';
                        document.getElementById('requireQuantity').value = '';
                        document.getElementById('discount').value = '';

                        document.getElementById('item').disabled = true;
                        $('#item').html('<option selected disabled>Select item</option>');

                        $('#category').html('<option selected disabled>Select category</option>');
                        data.all_category.forEach(function (category) {
                            $('#category').append(`<option value="${category.id}">${category.name}</option>`)
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching data.');
                        console.log('XHR Status: ' + status);
                        console.log('Error: ' + error); // Log error message
                        console.log(xhr.responseText);
                    }
                }
            )

        }

        function deleteAllTempOrder() {
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            let userRoleId = '{{ $userRole }}',
                branchId = '';
            if (userRoleId !== '1') {
                branchId = 5;
            } else {
                branchId = document.getElementById('branchSelect').value;
            }
            $.ajax({
                url: '/order/delete-all-temp-order/' + branchId,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function (data) {
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data.');
                    console.log('XHR Status: ' + status);
                    console.log('Error: ' + error); // Log error message
                    console.log(xhr.responseText);
                }
            })
        }

        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('delete-btn')) {
                let itemRow = e.target.closest('.new-table-row');
                itemRow.remove();
                let id = e.target.getAttribute('data-id');
                let dataType = e.target.getAttribute('data-type');
                deleteItem(id, dataType);
            }
        });

        function deleteItem(id, dataType) {
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/order/delete-item/' + id + '/' + dataType,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function (data) {
                    document.getElementById('subtotal').textContent = data;
                    document.getElementById('finalTotal').value = data;

                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data.');
                    console.log('XHR Status: ' + status);
                    console.log('Error: ' + error); // Log error message
                    console.log(xhr.responseText);
                }
            })
        }

        function submitOrder() {
            let csrfToken = $('meta[name="csrf-token"]').attr('content'),
                customer = document.getElementById('customer').value,
                branch = document.getElementById('branchSelect').value,
                discount = document.getElementById('discountTotal').value || '0',
                finalTotal = document.getElementById('finalTotal').value,
                decimal = finalTotal.replace(/[^0-9.]/g, ''),
                numericValue = decimal.split('.')[0], // Take only the part before the decimal point
                final = parseInt(numericValue),
                paymentReceived = document.getElementById('payment_received').value,
                remainingPayment = document.getElementById('remaining_payment').value,
                paymentMethod = document.getElementById('payment_method').value,
                remark = document.getElementById('remark').value,
                subTotal = final + parseInt(discount),
                formData = new FormData;

            formData.append('customer', customer);
            formData.append('branch', branch);
            formData.append('discount', discount);
            formData.append('finalTotal', final);
            formData.append('paymentReceived', paymentReceived);
            formData.append('remainingPayment', remainingPayment);
            formData.append('paymentMethod', paymentMethod);
            formData.append('remark', remark);
            formData.append('subTotal', subTotal);

            console.log(formData)
            $.ajax({
                url: 'store/',
                type: 'POST',
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function (data) {
                    showAlert('success', "{{ session('success') }}", "/order");
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data.');
                    console.log('XHR Status: ' + status);
                    console.log('Error: ' + error); // Log error message
                    console.log(xhr.responseText);
                }
            });
        }

        $('#discountTotal').keyup(function () {
            let discount = parseFloat($(this).val()) || 0,
                subTotal = document.getElementById('subtotal').textContent,
                // Remove commas from subTotal and convert to a float
                subTotalNumeric = parseFloat(subTotal.replace(/,/g, '')) || 0,
                finalTotal = subTotalNumeric - discount;

            document.getElementById('finalTotal').value = finalTotal.toFixed(2);

        })

        $('#payment_received').keyup(function () {
            let paymentReceived = parseFloat($(this).val()) || 0,
                total = document.getElementById('finalTotal').value,
                decimal = total.replace(/[^0-9.]/g, ''),
                numericValue = decimal.split('.')[0], // Take only the part before the decimal point
                final = parseInt(numericValue);
            document.getElementById('remaining_payment').value = final - paymentReceived;
        })

        function addLensFees() {
            // Get values from the modal form
            let lensDetail = document.getElementById('lens_detail').value,
                lensFee = parseFloat(document.getElementById('lens_fee').value) || 0,
                lensCost = parseFloat(document.getElementById('lens_cost').value) || 0,
                lensDiscount = parseFloat(document.getElementById('lens_discount').value) || 0,
                lensQuantity = parseFloat(document.getElementById('lens_quantity').value) || 0,
                lensQuantityError = document.getElementById('lensQuantityError'),
                csrfToken = $('meta[name="csrf-token"]').attr('content'),
                userRoleId = '{{ $userRole }}',
                branchId = '',

                // Calculate total after discount
                lensTotal = (lensFee * lensQuantity) - lensDiscount,

                // Add lens fees to the subtotal (adjust this to match your subtotal calculation)
                currentSubtotal = parseFloat(document.getElementById('subtotal').innerText) || 0,
                newSubtotal = currentSubtotal + lensTotal,
                formData = new FormData;

            if (userRoleId !== '1') {
                branchId = '';
            } else {

                branchId = document.getElementById('branchSelect').value;

            }
            lensQuantityError.innerHTML = '';
            if (lensQuantity === '') {
                lensQuantityError.innerHTML = 'Quantity is required';
            }
            // Update the subtotal display
            document.getElementById('subtotal').innerText = newSubtotal.toFixed(2);

            // Optionally close the modal
            formData.append('lens_detail', lensDetail);
            formData.append('lens_fee', lensFee);
            formData.append('lens_cost', lensCost);
            formData.append('lens_discount', lensDiscount);
            formData.append('branch', branchId);
            formData.append('quantity', lensQuantity);

            $.ajax({
                url: 'add-lens-fees/',
                type: 'POST',
                dataType: 'json',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#lensFeeModal').modal('hide');
                    $('#lensFeeForm')[0].reset();
                    $('#lens_detail').val('Lens Fees');


                    let newRow = '';
                    if (data.tempOrders && data.tempOrders.length > 0) {
                        data.tempOrders.forEach(function (tempOrder) {
                            newRow +=
                                `<tr class="new-table-row">
                                        <td><button class="btn btn-danger delete-btn" data-type="item" data-id="${tempOrder.id}"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                                        <td>${tempOrder.category}</td>
                                        <td>${tempOrder.item}</td>
                                        <td>${tempOrder.quantity}</td>
                                        <td>${tempOrder.selling_price}</td>
                                        <td>${tempOrder.discount}</td>
                                        <td>${tempOrder.total_selling_price}</td>
                                    </tr>`;

                        })
                    }
                    newRow += `<tr class="new-table-row">
                                    <td><button class="btn btn-danger delete-btn" data-type="lens" data-id="${data.lens_id}"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                                    <td colspan="2">${data.lens_name}</td>
                                    <td>${data.lens_quantity}</td>
                                    <td>${data.lens_price}</td>
                                    <td>${data.discount}</td>
                                    <td>${data.lens_total}</td>
                                </tr>`;

                    const tbody = document.querySelector('.table-row');
                    tbody.insertAdjacentHTML('beforeend', newRow);

                    document.getElementById('subtotal').textContent = data.sub_total;

                    document.getElementById('finalTotal').value = data.sub_total;

                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data.');
                    console.log('XHR Status: ' + status);
                    console.log('Error: ' + error); // Log error message
                    console.log(xhr.responseText);
                }
            });

        }
    </script>
    <script>
        $(document).ready(function () {
            $('#addCustomerForm').on('submit', function (event) {
                event.preventDefault();  // Prevent the default form submission
                let userRoleId = '{{ $userRole }}',
                    branchId = '';
                if (userRoleId !== '1') {
                    branchId = '';
                } else {
                    branchId = document.getElementById('branchSelect').value;
                }
                let formData = $(this).serialize();  // Get form data as a query string
                formData += '&branch=' + encodeURIComponent(branchId);
                // Send the form data via AJAX
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#addCustomerModal').modal('hide');
                        let newCustomer = response.customer;
                        let customerOption = `<option value="${newCustomer.id}">${newCustomer.first_name} ${newCustomer.last_name} - ${newCustomer.nic}</option>`;

                        // Append the new customer to the dropdown
                        $('#customer').append(customerOption);
                        $('#customer').val(newCustomer.id).trigger('change');

                        // Clear the form fields in the modal
                        $('#addCustomerForm')[0].reset();
                    },
                    error: function (response) {
                        console.log(response)
                    }
                });
            });
        });
        $('#add_customer').click(function (e) {
            branchSelect(e, 'addCustomerModal');

        });

        $('#add_lens_fees').click(function (e) {
            branchSelect(e, 'lensFeeModal');
        });

        function branchSelect(e, model) {
            let userRoleId = '{{$userRole}}';
            if (userRoleId === '1') {
                let selectedOption = document.getElementById("branchSelect").options[document.getElementById("branchSelect").selectedIndex],
                    branchError = document.getElementById('branchError'),
                    branch = selectedOption.textContent;
                branchError.innerHTML = '';
                if (branch === 'Select Branch' || branch === null) {
                    branchError.innerHTML = 'Please select a branch.';
                    e.preventDefault();
                    return false;
                } else {
                    branchError.innerHTML = '';
                    $(`#${model}`).modal('show');
                }

            } else {
                $(`#${model}`).modal('show');

            }
        }
    </script>
    <script>
        $(document).ready(function () {
            $('#branchSelect').change(function () {
                let branchId = $(this).val();
                loadData(branchId);


            })
        });
    </script>
    <script>
        let userRoleId = '{{ $userRole }}';
        if (userRoleId !== '1') {
            window.onload = function () {
                let branchId = '{{ $branchId }}';
                loadData(branchId);
            };

        }

        function loadData(branchId) {
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            let categorySelect = document.getElementById('category');
            // Clear existing options
            categorySelect.innerHTML = '<option selected disabled>Select Category</option>';
            document.querySelector('.table-row').innerHTML = '';
            $.ajax({
                url: 'get-order-details/' + branchId,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log(1)
                    data.categories.forEach(category => {
                        let option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        categorySelect.appendChild(option);
                    });
                    let newRow = '';
                    if (data.temp_orders && data.temp_orders.length > 0) {
                        data.temp_orders.forEach(function (tempOrder) {
                            console.log('tempOrder', tempOrder)
                            newRow +=
                                `<tr class="new-table-row">
                                        <td><button class="btn btn-danger delete-btn" data-type="item" data-id="${tempOrder.id}"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                                        <td>${tempOrder.category}</td>
                                        <td>${tempOrder.item}</td>
                                        <td>${tempOrder.quantity}</td>
                                        <td>${tempOrder.sale_price}</td>
                                        <td>${tempOrder.discount}</td>
                                        <td>${tempOrder.total_sale_price}</td>
                                    </tr>`;

                        })
                    }
                    if (data.lens_details && data.lens_details.length > 0) {
                        data.lens_details.forEach(function (lens) {
                            newRow +=
                                `<tr class="new-table-row">
                                        <td><button class="btn btn-danger delete-btn" data-type="lens" data-id="${lens.id}"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                                        <td colspan="2">${lens.lens_name}</td>
                                        <td>${lens.lens_price}</td>
                                        <td>${lens.lens_quantity}</td>
                                        <td>${lens.discount}</td>
                                        <td>${lens.lens_total}</td>
                                    </tr>`;
                        });

                    }

                    const tbody = document.querySelector('.table-row');
                    tbody.insertAdjacentHTML('beforeend', newRow);

                    document.getElementById('subtotal').textContent = data.sub_total;

                    document.getElementById('finalTotal').value = data.sub_total;

                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data.');
                    console.log('XHR Status: ' + status);
                    console.log('Error: ' + error); // Log error message
                    console.log(xhr.responseText);
                }
            })
        }
    </script>
    <script>
        $(document).ready(function () {
            let availableStock = 0;
            $('#item').change(function () {
                let itemId = $(this).val();
                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: 'check-stock-availability/' + itemId,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        availableStock = parseInt(data)
                        let quantityError = document.getElementById('requireQuantityError');
                        quantityError.innerHTML = 'Available quantity is ' + availableStock;


                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching data.');
                        console.log('XHR Status: ' + status);
                        console.log('Error: ' + error); // Log error message
                        console.log(xhr.responseText);
                    }
                })
            })
            $('#requireQuantity').on('input', function () {
                let enteredQuantity = parseInt($(this).val());
                let quantityError = document.getElementById('requireQuantityError');
                quantityError.innerHTML = '';


                if (enteredQuantity > availableStock) {
                    $('#requireQuantityError').html('Entered quantity exceeds available stock.');
                    $('#add-item-btn').prop('disabled', true); // Disable the submit button
                } else {
                    $('#requireQuantityError').html(''); // Clear any errors
                    $('#add-item-btn').prop('disabled', false); // Enable the submit button
                }
            });
        })
    </script>
@endpush
