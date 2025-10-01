@extends('backend.layouts.app')
@section('content')
    <style>
        .dropdown-menu.show {
            display: block;
        }
    </style>
    <!-- ============================================================== -->

                     <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                         <a href="javascript:void(0)" onclick="history.back()" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                                <i class="ti ti-arrow-left fs-5"></i> 
                            </a>

                    <div>
                        <h4 class="mb-4 mb-sm-0 card-title">{{ ucfirst(strtolower($shippingCompany->name)) }} Integration list </h4>
                    </div>
                  <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item d-flex align-items-center">
                        <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light"
                            data-bs-toggle="modal" data-bs-target="#addintegration">Add New Integration</button>
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
        </div>
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <div class="row my-4">
        <div class="col-12">
            <div class="card">
                  

                <div id="addintegration" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Add New Integration</h4>
                            </div>
                            <form class="form-horizontal form-material" action="{{ route('last-mille.store') }}"
                                method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" name="id_lastmile"
                                            value="{{ $id }}">
                                        <div class="col-md-12">
                                            <label class="custom-control-label">Name :</label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Business name">
                                        </div>
                                        <div class="col-md-12 mt-10">
                                            <label class="custom-control-label">Key :</label>
                                            <input type="text" class="form-control" name="key"
                                                placeholder="Auth Key | API Key">
                                        </div>
                                        <div class="col-md-12 mt-10">
                                            <label class="custom-control-label">Auth Id :</label>
                                            <input type="text" class="form-control" name="auth_id"
                                                placeholder="Auth Id | Client Id">
                                            <input type="hidden" class="form-control" name="assigned_id">
                                        </div>
                                        @if ($isOnessta)
                                            <div class="col-md-12 mt-10">
                                                <label class="custom-control-label">Api Key :</label>
                                                <input type="text" class="form-control" name="api_key"
                                                    placeholder="API Key" required>
                                            </div>
                                        @endif
                                        <div class="col-md-12 mt-10">
                                            <label class="custom-control-label">Type :</label>
                                            <select class=" form-control custom-select" name="type">
                                                <option value="SIMPLE">SIMPLE</option>
                                                <option value="STOCK">STOCK</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mt-10">
                                            <label class="custom-control-label">Fragile :</label>
                                            <select class=" form-control custom-select" name="fragile">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mt-10">
                                            <label class="custom-control-label">Open :</label>
                                            <select class=" form-control custom-select" name="open">
                                                <option value="YES">YES</option>
                                                <option value="NO">NO</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mt-10">
                                            <label class="custom-control-label">Fees Delivered :</label>
                                            <input type="text" class="form-control" name="fees_delivered" value="30">
                                        </div> 
                                        <div class="col-md-12 mt-10">
                                            <label class="custom-control-label">Fees Retourn :</label>
                                            <input type="text" class="form-control" name="fees_retourn" placeholder="0">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary waves-effect mt-3">Save</button>
                                    <button type="button" class="btn btn-primary waves-effect mt-3"
                                        data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                    <!-- /.modal-content -->

                <!-- /.modal-dialog -->
            </div>
            <div class="table-responsive border rounded-1">
                <table class="table text-nowrap customize-table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Business Name</th>
                            <th>Auth Key</th>
                            <th>Auth Id</th>
                            @if ($isOnessta)
                                <th>API Key</th>
                            @endif
                            <th>Active</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        @if (!$lastmilles->isempty())
                            @foreach ($lastmilles as $v_integration)
                                <tr>
                                    <td>{{ $counter }}</td>
                                    <td>{{ $v_integration->name }}</td>
                                    <td>{{ $v_integration->auth_key }}</td>
                                    <td>{{ $v_integration->auth_id }}</td>
                                    @if ($isOnessta)
                                        <td>{{ $v_integration->api_key }}</td>
                                    @endif
                                    <td>
                                        @if ($v_integration->is_active == '1')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">InActive</span>
                                        @endif
                                    </td>
                                    <td>{{ $v_integration->created_at }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle show" type="button"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i
                                                        class="icon-settings"></i></button>
                                                <div class="dropdown-menu" bis_skin_checked="1"
                                                    style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(184px, -325.203px, 0px);"
                                                    data-popper-placement="top-start">
                                                    @if ($v_integration->is_active == '0')
                                                        <a class="dropdown-item"
                                                            href="{{ route('last-mille.active', $v_integration->id) }}">
                                                            Active</a>
                                                    @else
                                                        <a class="dropdown-item"
                                                            href="{{ route('last-mille.inactive', $v_integration->id) }}">
                                                            InActive</a>
                                                    @endif
                                                    <a class="dropdown-item"
                                                        href="{{ route('last-mille.deleted', $v_integration->id) }}">
                                                        Deleted</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $counter++; ?>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="12">
                                    <div class="col-12">
                                        <img src="{{ asset('public/Empty-amico.svg') }}"
                                            style="margin-left: auto ; margin-right: auto; display: block;"
                                            width="500" />
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right sidebar -->
    <!-- ============================================================== -->
    <!-- .right-sidebar -->
    <!-- ============================================================== -->
    <!-- End Right sidebar -->
    <!-- ============================================================== -->


    <div id="edit_product" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form action="{{ route('products.update') }}" method="POST" class="form-horizontal form-material"
                    enctype="multipart/form-data" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="product_nam" id="product_nam"
                                    placeholder="Product Name">
                                <input type="hidden" class="form-control" name="product_id" id="product_id"
                                    placeholder="Product Name">
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="file" class="form-control" name="product_image" id="product_image"
                                    placeholder="Product Image">
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="product_link" id="product_link"
                                    placeholder="Link">
                            </div>
                            <div class="col-md-12 m-b-20">
                                <textarea type="text" class="form-control" name="description_produc" id="description_produc"
                                    placeholder="Description Product"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info waves-effect">Save</button>
                        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div id="config_upsel" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Config Upsell</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form class="form-horizontal form-material" enctype="multipart/form-data" novalidate="novalidate">

                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="upsel_quantity" id="upsel_quantity"
                                    placeholder="Quantity">
                                <input type="hidden" class="form-control" name="upsel_product_id" id="upsel_product_id"
                                    placeholder="Product Name">
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="discount" id="discount"
                                    placeholder="Discount">
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="note" id="note"
                                    placeholder="Note">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info waves-effect" id="config">Save</button>
                        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    <script type="text/javascript">
        $(function(e) {
            $('#add-assigne').click(function(e) {
                var name = $('#assigne_name').val();
                var email = $('#assigne_email').val();
                var password = $('#assigne_password').val();
                var phone = $('#assigne_phone').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('customers.store') }}',
                    cache: false,
                    data: {
                        name: name,
                        email: email,
                        password: password,
                        phone: phone,
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
    @if (session()->has('success'))
        <script>
            toastr.success('Good Job Product.', 'Product Has been Addess Success!', {
                "showMethod": "slideDown",
                "hideMethod": "slideUp",
                timeOut: 2000
            });
        </script>
    @endif
@endsection
@endsection
