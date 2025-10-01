@extends('backend.layouts.app')
@section('content')
    <style>
        #overlay {
            background: #ffffff;
            color: #666666;
            position: fixed;
            height: 100%;
            width: 100%;
            z-index: 5000;
            top: 0;
            left: 0;
            float: left;
            text-align: center;
            padding-top: 25%;
            opacity: .80;
        }

        .spinner {
            margin: 0 auto;
            height: 64px;
            width: 64px;
            animation: rotate 0.8s infinite linear;
            border: 5px solid firebrick;
            border-right-color: transparent;
            border-radius: 50%;
        }
    </style>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-xl-11 align-self-center ">
                        <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                class="text-muted fw-light">Dashboard /</span> Offers &nbsp;

                        </h4>
                    </div>
                    <div class="col-xl-1 align-self-center">
                        <div class="form-group mb-0 text-right">
                            {{-- <button type="button" class="btn btn-primary btn-rounded my-1" data-bs-toggle="modal"
                                data-bs-target="#add-contact">Add New Product</button> --}}
                            <button type="button" class="btn btn-primary btn-rounded my-1" id="exportss">Export</button>
                        </div>
                        <br>
                    </div>
                </div>
            </div>

            <!-- Add Contact Popup Model -->
            {{-- <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Add New Product</h4>
                            
                        </div>
                        <div class="modal-body">
                            <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#add-contac">New Product</button>
                            <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#add-ex">Product Existing</button>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div> --}}
            <!-- Add Product Popup Model -->
            {{-- <div id="add-contac" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" style="max-width: 700px;">
                    <div class="modal-content">
                        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Add New Product</h4>
                                
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12 my-2" style="width:100%">
                                            <select class="form-control custom-select" style="width: 100%; height:36px;"
                                                name="seller_name" id="seller_name">
                                                <option>Select Seller</option>
                                                @foreach ($users as $v_user)
                                                    <option value="{{ $v_user->id }}">{{ $v_user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 my-2">
                                            <input type="text" class="form-control" name="name_product" id="name_product"
                                                placeholder="Product Name">
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <input type="text" class="form-control" name="link_product" id="link_product"
                                                placeholder="Link">
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <input type="text" class="form-control" name="price_product"
                                                id="price_product" placeholder="Price">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 my-2">
                                            <input type="text" class="form-control" name="quantity_product"
                                                id="quantity_product" placeholder="Quantity">
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <input type="text" class="form-control" name="low_stock" id="low_stock"
                                                placeholder="Low Stock">
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <input type="text" class="form-control" name="nbr_package"
                                                id="nbr_package" placeholder="NBRE OF PACKAGES">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 my-2">
                                            <input type="file" class="form-control" name="image_product"
                                                id="image_product" placeholder="Image">
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <select class="form-control" name="warehouse" id="warehouse">
                                                <option>Select Warehouse</option>
                                                @foreach ($countries as $v_country)
                                                    <option value="{{ $v_country->name }}">{{ $v_country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <select class="form-control" name="shipping_country" id="shipping_country">
                                                <option>Select Expidition Mode</option>
                                                <option value="AIR">AIR</option>
                                                <option value="SEA">SEA</option>
                                                <option value="ROAD">ROAD</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 my-2">
                                            <input type="date" class="form-control" name="date_shipping"
                                                id="date_shipping" placeholder="Date">
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <input type="text" class="form-control" name="name_transport"
                                                id="name_transport" placeholder="Name Transporteur">
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <input type="text" class="form-control" name="phone_shipping"
                                                id="phone_shipping" placeholder="Phone">
                                        </div>
                                        <div class="col-md-4 my-2">
                                            <textarea type="text" class="form-control" name="description_product" id="description_product"
                                                placeholder="Description Product"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect">Save</button>
                                <button type="button" class="btn btn-primary waves-effect"
                                    data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div> --}}
            <!-- Add Import Popup Model -->
            <div id="add-ex" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Add New Stock</h4>

                        </div>
                        <div class="modal-body">
                            <from class="form-horizontal form-material">
                                <div class="form-group">
                                    <div class="col-md-12 my-2">
                                        <select class="select2 form-control" id="product_name" style="width:100%">
                                            <option>Select Product</option>
                                            @foreach ($product as $v_product)
                                                <option value="{{ $v_product->id }}">{{ $v_product->name }}</option>*
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="number" class="form-control" id="quantity" placeholder="Quantity">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" id="country"
                                            placeholder="Shipping Country">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <select class="form-control" name="warehouse" id="warehouse_send">
                                            <option>Select Warehouse</option>
                                            @foreach ($countries as $v_country)
                                                <option value="{{ $v_country->name }}">{{ $v_country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <select class="form-control" id="expidition_mode">
                                            <option>Select Expidition Mode</option>
                                            <option value="AIR">AIR</option>
                                            <option value="SEA">SEA</option>
                                            <option value="ROAD">ROAD</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="date" class="form-control" id="expidition_date" placeholder="Date">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" id="expidition_name"
                                            placeholder="Name Transporteur">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" id="expidition_phone"
                                            placeholder="Phone">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" id="nbr_packagin"
                                            placeholder="NBR PACHING">
                                    </div>
                                </div>
                            </from>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary waves-effect" id="existin_product">Save</button>
                            <button type="button" class="btn btn-primary waves-effect"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div id="filter" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Search</h4>

                        </div>
                        <div class="modal-body">
                            <from class="form-horizontal form-material">
                                <div class="form-group">
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" placeholder="Store Name">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" placeholder="Link">
                                    </div>
                                </div>
                            </from>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary waves-effect"
                                data-bs-dismiss="modal">Search</button>
                            <button type="button" class="btn btn-primary waves-effect"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div class="modal fade" id="DeactivateOffer" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-md modal-simple modal-edit-user">
                    <div class="modal-content p-3 p-md-5">
                        <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            <div class="text-center mb-4">
                                <h3 class="mb-2">Offer Request</h3>
                                <p class="text-muted">Are you sure you want to desactivate this offer ?</p>
                            </div>
                            <form action="{{ route('offers.desactivatedOffer') }}" class="d-flex justify-content-center">
                                <input type="text" name="id" value="" hidden id="offerId">
                                <button href="#" class="btn btn-primary ">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <div id="edit_product" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Edit Product</h4>

                        </div>
                        <form action="{{ route('offers.update') }}" method="POST" class="form-horizontal form-material"
                            enctype="multipart/form-data" novalidate="novalidate">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="row">

                                        <div class="col-md-6 my-2">
                                            <label for="">Product Name</label>
                                            <input type="text" class="form-control" name="product_nam"
                                                id="product_nam" placeholder="Product Name">
                                            <input type="hidden" class="form-control" name="product_id" id="product_id"
                                                placeholder="Product Name">
                                        </div>

                                        <div class="col-md-6 my-2">
                                            <label for="">Product Image</label>
                                            <input type="file" class="form-control" name="product_image"
                                                id="product_image" placeholder="Product Image">
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6 my-2">
                                            <label for="">Product Link</label>
                                            <input type="text" class="form-control" name="product_link"
                                                id="product_link" placeholder="Link">
                                        </div>

                                        <div class="col-md-6 my-2">
                                            <label for="">Product Video Link</label>
                                            <input type="text" class="form-control" name="product_linkvideo"
                                                id="product_linkvideo" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 my-2">
                                            <label for="">Product Price</label>
                                            <input type="text" class="form-control" name="product_price"
                                                id="product_price" placeholder="Price">
                                        </div>

                                        <div class="col-md-6 my-2">
                                            <label for="">Product Weight</label>
                                            <input type="text" class="form-control" name="product_weight"
                                                id="product_weight" placeholder="weight">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 my-2">
                                            <label for="">Product Price Service</label>
                                            <input type="text" class="form-control" name="product_fees"
                                                id="product_fees" placeholder="Price and Fees">
                                        </div>

                                        <div class="col-md-6 my-2">
                                            <label for="">Offer Price</label>
                                            <input type="text" class="form-control" name="product_offer"
                                                id="product_offer" placeholder="Price and Fees">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 my-2">
                                            <label for="">Offer Price fixed</label>

                                            <select class="form-control" name="price_status" id="price_status">
                                                <option value="1">Fixed</option>
                                                <option value="0">Not Fixed</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 my-2">
                                            <textarea type="text" class="form-control" name="description_produc" id="description_produc"
                                                placeholder="Description Product"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect">Save</button>
                                <button type="button" class="btn btn-primary waves-effect"
                                    data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <div id="overlay" style="display:none;">
                <div class="spinner"></div>
                <br />
                Loading...
            </div>
            <!-- Bordered Table -->
            <div class="card">
                <div class="card-body">
                    <div class="form-group-1">
                        <form>
                            <div class="row">
                                <div class="col-md-11 col-sm-12">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="search"
                                            placeholder="SKU , Name , Link Product" aria-label=""
                                            aria-describedby="basic-addon1">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-12">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="multi">Multi</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="form-group multi" style="display:none">
                        <form>
                            <div class="row">
                                <div class="col-md-3 col-sm-12 my-2">
                                    <input type="text" class="form-control" name="sku" placeholder="SKU">
                                </div>
                                <div class="col-md-3 col-sm-12 my-2">
                                    <select class="select2 form-control custom-select" style="width: 100%; height:36px;"
                                        name="product_name">
                                        <option value=" ">Select Product</option>
                                        @foreach ($product as $v_user)
                                            <option value="{{ $v_user->id }}">{{ $v_user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12 my-2">
                                    <select class="select2 form-control custom-select" style="width: 100%; height:36px;"
                                        name="seller_name">
                                        <option value=" ">Select Vendor</option>
                                        @foreach ($users as $v_user)
                                            <option value="{{ $v_user->id }}">{{ $v_user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-12 my-2">
                                    <button type="submit" class="btn btn-primary waves-effect"
                                        style="width:100%">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive text-nowrap mt-2" style="min-height: 400px">
                        <table id="demo-foo-addrow" class="table table-bordered table-striped table-hover contact-list"
                            data-paging="true" data-paging-size="7">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="selectall custom-control-input"
                                                id="chkCheckAll" required>
                                            <label class="custom-control-label" for="chkCheckAll"></label>
                                        </div>
                                    </th>
                                    <th>Vendor</th>
                                    <th>SKU</th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Link</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter = 1; ?>
                                @foreach ($products as $v_product)
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="ids"
                                                    class="custom-control-input checkBoxClass"
                                                    value="{{ $v_product->id }}" id="pid-{{ $counter }}">
                                                <label class="custom-control-label"
                                                    for="pid-{{ $counter }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            @foreach ($v_product['users'] as $v_user)
                                                {{ $v_user->name }}
                                            @endforeach
                                        </td>
                                        <td class="editProduct" data-id="{{ $v_product->id }}" id="editProduct">
                                            {{ $v_product->sku }}</td>
                                        <td><img src="{{ $v_product->image }}" alt="user" class="circle"
                                                width="45" /></td>
                                        <td>{{ Str::limit($v_product->name, 30) }}</td>
                                        <td><a href="{{ $v_product->link }}" target="_blank">Open Link</a></td>
                                        <td>{{ $v_product->created_at }}</td>
                                        <td>



                                            <div class="dropdown">
                                                <button class="btn p-0" type="button" id="earningReports"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="earningReports">
                                                    <a class="dropdown-item"
                                                        href="{{ route('products.imports', $v_product->sku) }}">
                                                        Imports</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('products.stocks', $v_product->sku) }}">
                                                        Stocks</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('products.upsells', $v_product->sku) }}"> All
                                                        Upsells</a>
                                                    <a class="dropdown-item update" data-id="{{ $v_product->sku }}">
                                                        Update</a>
                                                    <a href="{{ route('offers.details', $v_product->id) }}"
                                                        class="dropdown-item"> Show Offer</a>
                                                    <a class="dropdown-item deleted" data-id="{{ $v_product->id }}"
                                                        id="deleted"> Deleted</a>
                                                    <a href="#" data-bs-toggle="modal" class="dropdown-item"
                                                        data-bs-target="#DeactivateOffer" data-id="{{ $v_product->id }}"
                                                        class="btn btn-primary ">Desactivate Offer</a>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    <?php $counter++; ?>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- <span>Count Order: {{ $count }} / {{ $items }}</span> --}}
                        {{ $products->withQueryString()->links('vendor.pagination.courier') }}
                    </div>
                </div>
            </div>
            <!--/ Bordered Table -->

        </div>
        <!-- / Content -->

        <!-- Footer -->
        <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl">
                <div
                    class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                    <div>
                        ©
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        , made with ❤️ by <a href="https://Palace Agency.eu" target="_blank" class="fw-semibold">Palace Agency</a>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->

@section('script')
    <!-- Page JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(function(e) {
            $('#existin_product').click(function(e) {
                var product = $('#product_name').val();
                var quantity = $('#quantity').val();
                var country = $('#country').val();
                var expidition = $('#expidition_name').val();
                var mode = $('#expidition_mode').val();
                var date = $('#expidition_date').val();
                var phone = $('#expidition_phone').val();
                var packagin = $('#nbr_packagin').val();
                var warehouse = $('#warehouse_send').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('products.warehousestore') }}',
                    cache: false,
                    data: {
                        product: product,
                        quantity: quantity,
                        country: country,
                        expidition: expidition,
                        mode: mode,
                        date: date,
                        phone: phone,
                        packagin: packagin,
                        warehouse: warehouse,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job Product.',
                                'Stock Has been Addess Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                        }
                        location.reload();
                    }
                });
            });
        });

        //deleted

        $(function(e) {
            $('.deleted').on('click', function(e) {
                var product = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('products.delete') }}',
                    cache: false,
                    data: {
                        id: product,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job Product.',
                                'Product Has been deleted Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                            location.reload();
                        }
                        if (response.error == false) {
                            toastr.error('Good Job Product.', 'You cant deleted product!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                    }
                });
            });
        });

        $(function() {
            $('body').on('click', '.update', function() {
                var product_id = $(this).data('id');
                //console.log(product_id);
                $.get("{{ route('products.index') }}" + '/' + product_id + '/edit', function(data) {
                    //console.log(product_id);
                    $('#edit_product').modal('show');
                    $('#product_id').val(data.id);
                    $('#product_nam').val(data.name);
                    $('#product_link').val(data.link);
                    $('#product_linkvideo').val(data.link_video);
                    $('#product_price').val(data.price_vente);
                    $('#product_weight').val(data.weight);
                    $('#product_fees').val(data.price_service);
                    $('#product_offer').val(data.offer_price);
                    //fixed price status select
                    if (data.price_status == 1) {
                        $('#price_status').val(1);
                        $('#price_status option[value="1"]').prop('selected', true);
                    } else {
                        $('#price_status').val(0);
                        // Assuming #price_status is a dropdown/select element
                        $('#price_status option[value="0"]').prop('selected', true);
                    }


                    $('#description_produc').val(data.description);
                });
            });
            $('body').on('click', '#multi', function() {
                $('.multi').show();
            })
        });


        $(function() {
            $('body').on('click', '.configupsel', function() {
                var product_id = $(this).data('id');
                //console.log(product_id);
                $('#config_upsel').modal('show');
                $('#upsel_product_id').val(product_id);

            });
        });



        //Export
        $(function(e) {
            $("#chkCheckAll").click(function() {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });
            $('#exportss').click(function(e) {
                e.preventDefault();
                var allids = [];
                $("input:checkbox[name=ids]:checked").each(function() {
                    allids.push($(this).val());
                });
                if (allids != '') {
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('products.export') }}',
                        cache: false,
                        data: {
                            ids: allids,
                        },
                        success: function(response, leads) {
                            $.each(allids, function(key, val, leads) {
                                var a = JSON.stringify(allids);
                                window.location = ('products/export-download/' + a);
                            });
                        }
                    });
                } else {
                    toastr.warning('Opss.', 'Please Selected Leads!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                }
            });
        });

        $(document).ready(function() {
            $("#seller_name").select2({
                dropdownParent: $("#add-contac")
            });
        });
    </script>
    @if (session()->has('success'))
        <div class="alert alert-success">
            @if (is_array(session('success')))
                <ul>
                    @foreach (session('success') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @else
                {{ session('success') }}
            @endif
        </div>
    @endif

    {{-- <script>
            @if (session('success'))

                toastr.success('Good Job.', 'Offer has been accepeted!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                });

            @endif
        </script> --}}

@endsection
@endsection
