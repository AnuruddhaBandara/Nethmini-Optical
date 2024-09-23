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
            <h5 class="text-uppercase mb-0"><span class="text-muted">Item</span> <span class="mx-2">/</span> Add
                Stock
            </h5>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body p-0">
                    <div class="px-3 py-4">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="purchaseOrderNo" class="form-label">Purchase Order No</label>
                                <input type="text" class="form-control" id="purchaseOrderNo" name="purchaseOrderNo">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="supplier" class="form-label">Select Branch</label>
                                <select class="form-select select2" id="branchSelect" name="branch">
                                    <option selected disabled>Select Branch</option>
                                    @foreach($branches as $branch)
                                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                                    @endforeach
                                </select>
                                <span style="color:red; font-weight: bold" id="branchError"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="supplier" class="form-label">Select Supplier</label>
                                <select class="form-select select2" id="supplier" name="supplier">
                                    <option selected disabled>Select Supplier</option>
                                    @foreach($supplierList as $supplier)
                                        <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="date" class="form-label">Stock Date</label>
                                <input type="date" class="form-control" id="date" name="date">
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
                                <th>Cost</th>
                                <th>Discount</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody class="table-row">
                            {{--                            @foreach($stock as $row)--}}
                            {{--                                <tr class="new-table-row">--}}
                            {{--                                    <td>--}}
                            {{--                                        <button class="btn btn-danger delete-btn" data-id="{{$row['id']}}"><i--}}
                            {{--                                                class="fa fa-times"--}}
                            {{--                                                aria-hidden="true"></i>--}}
                            {{--                                        </button>--}}
                            {{--                                    </td>--}}
                            {{--                                    <td>{{$row['category']}}</td>--}}
                            {{--                                    <td>{{$row['item']}}</td>--}}
                            {{--                                    <td>{{$row['quantity']}}</td>--}}
                            {{--                                    <td>{{$row['cost']}}</td>--}}
                            {{--                                    <td>{{$row['discount']}}</td>--}}
                            {{--                                    <td>{{$row['total_cost']}}</td>--}}

                            {{--                                </tr>--}}

                            {{--                            @endforeach--}}
                            </tbody>
                            <tbody>
                            <tr>
                                <td>
                                    <button class="btn btn-warning" onclick="deleteAllTempStock()">Clear
                                        All
                                    </button>

                                </td>
                                <td colspan="5" style="text-align: right;font-size: 18px"><b>Sub Total</b></td>
                                <td style="font-size: 18px" id="subtotal">
                                {{--                                    <b>{{(!empty($stock)) ? $row['sub_total'] : '0.00'}}</b></td>--}}
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
                                       value="{{(!empty($stock)) ? $row['sub_total'] : '0.00'}}" disabled>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-success" onclick="submitStock()" value="Submit">
                    </div>
                    {{--                    </form>--}}
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
        document.addEventListener('DOMContentLoaded', function () {
            let categorySelect = document.querySelector('.category-select');
            categorySelect.onchange = function () {
                let categoryId = this.value,
                    itemSelect = document.querySelector('.itemSelect');
                itemSelect.disabled = true;
                fetch(`get-item/${categoryId}`)
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
                quantityError = document.getElementById('requireQuantityError'),
                selectedOption = document.getElementById("branchSelect").options[document.getElementById("branchSelect").selectedIndex],
                branchError = document.getElementById('branchError'),
                branch = selectedOption.textContent,
                branchId = document.getElementById('branchSelect').value;

            branchError.innerHTML = '';
            quantityError.innerText = '';
            if (branch === 'Select Branch' || branch === null) {
                branchError.innerHTML = 'Please select a branch.';
                return;
            }
            if (quantity === '') {
                quantityError.innerText = 'Please enter the quantity';
                return;
            }

            formData.append('category_id', categoryId);
            formData.append('item_id', itemId);
            formData.append('quantity', quantity);
            formData.append('discount', discount);
            formData.append('branch', branchId);

            $.ajax({
                    url: 'add-temp-stock/',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    processData: false,
                    contentType: false,
                    success: function (data) {

                        const newRow =
                            `<tr class="new-table-row">
                                    <td><button class="btn btn-danger delete-btn" data-id="${data.id}"><i class="fa fa-times" aria-hidden="true"></i></button></td>
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

        function deleteAllTempStock() {
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/stock/delete-all-temp-stock/',
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
                deleteItem(id);
            }
        });

        function deleteItem(id) {
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/stock/delete-item/' + id,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function (data) {
                    document.getElementById('subtotal').textContent = data;

                },
                error: function (xhr, status, error) {
                    console.error('Error fetching data.');
                    console.log('XHR Status: ' + status);
                    console.log('Error: ' + error); // Log error message
                    console.log(xhr.responseText);
                }
            })
        }

        function submitStock() {
            let csrfToken = $('meta[name="csrf-token"]').attr('content'),
                purchaseOrderNo = document.getElementById('purchaseOrderNo').value,
                // supplier = document.getElementById('supplier').value,
                selectedOption = document.getElementById("supplier").options[document.getElementById("supplier").selectedIndex],
                supplier = selectedOption.value,
                selectedOptionB = document.getElementById("branchSelect").options[document.getElementById("branchSelect").selectedIndex],
                branch = selectedOptionB.value,
                date = document.getElementById('date').value,
                discount = document.getElementById('discountTotal').value,
                finalTotal = document.getElementById('finalTotal').value,
                formData = new FormData;
            formData.append('purchase_order_no', purchaseOrderNo);
            formData.append('supplier', supplier);
            formData.append('build_date', date);
            formData.append('discount', discount);
            formData.append('finalTotal', finalTotal);
            formData.append('branch', branch);


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
                    showAlert('success', "{{ session('success') }}", "/stock");
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

            document.getElementById('finalTotal').value = 'Rs. ' + finalTotal.toFixed(2);

        })
    </script>
    <script>
        $(document).ready(function () {
            $('#branchSelect').change(function () {
                let branchId = this.value;
                let categorySelect = document.getElementById('category');
                // Clear existing options
                categorySelect.innerHTML = '<option selected disabled>Select Category</option>';
                const tbody = document.querySelector('.table-row');
                tbody.innerHTML = '';
                document.getElementById('subtotal').textContent = '0.00';

                document.getElementById('finalTotal').value = '0.00';

                if (branchId) {
                    // Fetch categories based on the selected branch
                    fetch(`/stock/get-stock/${branchId}`)
                        .then(response => response.json())
                        .then(stocks => {
                            stocks.categories.forEach(category => {
                                let option = document.createElement('option');
                                option.value = category.id;
                                option.textContent = category.name;
                                categorySelect.appendChild(option);
                            });
                            let newRow = '';
                            if (stocks.stock.length > 0) {

                                stocks.stock.forEach(data => {
                                    newRow +=
                                        `<tr class="new-table-row">
                                        <td><button class="btn btn-danger delete-btn" data-id="${data.id}"><i class="fa fa-times" aria-hidden="true"></i></button></td>
                                        <td>${data.category}</td>
                                        <td>${data.item}</td>
                                        <td>${data.quantity}</td>
                                        <td>${data.cost}</td>
                                        <td>${data.discount}</td>
                                        <td>${data.total_cost}</td>
                                    </tr>`;

                                });
                                const tbody = document.querySelector('.table-row');
                                tbody.insertAdjacentHTML('beforeend', newRow);
                                document.getElementById('subtotal').textContent = stocks.stock[0].sub_total;

                                document.getElementById('finalTotal').value = stocks.stock[0].sub_total;
                            }

                        })
                        .catch(error => console.error('Error fetching categories:', error));
                }
            });

        });

    </script>
@endpush
