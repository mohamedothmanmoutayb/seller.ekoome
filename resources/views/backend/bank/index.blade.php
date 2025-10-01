@extends('backend.layouts.app')
@section('content')
    <style>
        .dropdown-menu.show {
            display: block;
        }
    </style>
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="content-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->

        <!-- Add User Popup Model -->
        <div id="adduser" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Add New Bank</h4>
                    </div>
                    <div class="modal-body">
                        <from class="form-horizontal form-material">
                            <div class="form-group">
                                <div class="col-md-12 my-3 company" id="company">
                                    <select class="select2 form-control" id="bank_name" style="width: 100%;height: 36px;">
                                        <option value=" ">Select Bank</option>
                                        <option value="wise">WISE</option>
                                        <option value="payonner">PAYONNER</option>
                                        <option value="paypal">PAYPAL</option>
                                        <option value="cih">CIH BANK</option>
                                    </select>
                                </div>
                                <div class="col-md-12 my-3">
                                    <input type="text" class="form-control" id="bank_swift" placeholder="Bank Swift">
                                </div>
                                <div class="col-md-12 my-3">
                                    <input type="text" class="form-control" id="bank_iban" placeholder="Bank Iban">
                                </div>
                                <div class="col-md-12 my-3">
                                    <input type="text" class="form-control" id="bank_bic" placeholder="Bank Bic">
                                </div>
                                <div class="col-md-12 my-3">
                                    <input type="text" class="form-control" id="bank_rib" placeholder="Bank Rib">
                                </div>
                                <div class="col-md-12 my-3">
                                    <input type="text" class="form-control" id="bank_email" placeholder="Email">
                                </div>
                            </div>
                        </from>
                    </div>
                    <div class="modal-body">
                        <button type="submit" class="btn btn-primary waves-effect" id="add-bank">Save</button>
                        <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-8 align-self-center ">
                        <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                class="text-muted fw-light">Dashboard /</span> Bank list&nbsp;

                        </h4>
                    </div>
                    <div class="col-4 d-flex justify-content-end">
                        <div class="form-group mb-0 text-right">
                            <!-- <a type="button" class="btn btn-info btn-rounded waves-effect waves-light text-white" id="paid">Paid Order Selected</a> -->
                            <a type="button" class="btn btn-primary btn-rounded waves-effect waves-light text-white my-2"
                                data-bs-toggle="modal" data-bs-target="#adduser">Add New Bank</a>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Page Content -->
            <div class="row my-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group-1">
                                <form>
                                    <div class="row">
                                        <div class="col-md-11 col-sm-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search" id="search"
                                                    placeholder="Name User" aria-label="" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-sm-12">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"></h4>
                            <h6 class="card-subtitle"></h6>

                            <div class="table-responsive">
                                <table id="demo-foo-addrow"
                                    class="table table-bordered table-striped table-hover contact-list" data-paging="true"
                                    data-paging-size="7">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Created at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $counter = 1; ?>
                                            @foreach($banks as $v_bank)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="ids" class="custom-control-input checkBoxClass"  value="{{$v_bank->id}}" id="pid-{{$counter}}">
                                                        <label class="custom-control-label" for="pid-{{$counter}}"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $v_bank->name}}</td>
                                                <td>{{ $v_bank->created_at}}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn p-0" type="button" id="earningReports" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                          <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">
                                                            <a class="dropdown-item detailcustomer" data-id="{{$v_bank->id}}" > Details</a>
                                                        </div>
                                                    </div> 
                                                </td>
                                            </tr>
                                            @endforeach
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
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
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
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->

    <div id="edit_user" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Edit User</h4>
                    
                </div>
                <form action="{{ route('users.update') }}" method="POST" class="form-horizontal form-material"
                    enctype="multipart/form-data" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-md-12 my-3">
                                <input type="text" class="form-control" name="user_name" id="user_name"
                                    placeholder="User Name">
                                <input type="hidden" class="form-control" name="user_id" id="user_id"
                                    placeholder="User Name">
                            </div>
                            <div class="col-md-12 my-3">
                                <input type="text" class="form-control" name="user_phone" id="user_phone"
                                    placeholder="User Phone">
                            </div>
                            <div class="col-md-12 my-3">
                                <input type="text" class="form-control" name="user_email" id="user_email"
                                    placeholder="User Email">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect">Save</button>
                        <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
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
                    
                </div>
                <form class="form-horizontal form-material" enctype="multipart/form-data" novalidate="novalidate">

                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-md-12 my-3">
                                <input type="text" class="form-control" name="upsel_quantity" id="upsel_quantity"
                                    placeholder="Quantity">
                                <input type="hidden" class="form-control" name="upsel_product_id" id="upsel_product_id"
                                    placeholder="Product Name">
                            </div>
                            <div class="col-md-12 my-3">
                                <input type="text" class="form-control" name="discount" id="discount"
                                    placeholder="Discount">
                            </div>
                            <div class="col-md-12 my-3">
                                <input type="text" class="form-control" name="note" id="note"
                                    placeholder="Note">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect" id="config">Save</button>
                        <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div id="modal_password" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Modal Password</h4>
                   
                </div>
                <form class="form-horizontal form-material" enctype="multipart/form-data" novalidate="novalidate">

                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-md-12 my-3">
                                <input type="password" class="form-control" name="new_password" id="new_password"
                                    placeholder="New Password">
                                <input type="hidden" class="form-control" name="user_id" id="user_id"
                                    placeholder="">
                            </div>
                            <div class="col-md-12 my-3">
                                <input type="password" class="form-control" name="conf_new_password"
                                    id="conf_new_password" placeholder="Confirmed New password">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect" id="changepassword">Save</button>
                        <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    <script type="text/javascript">
        $(function(e) {
            $('#add-user').click(function(e) {
                var name = $('#assigne_name').val();
                var email = $('#assigne_email').val();
                var password = $('#assigne_password').val();
                var phone = $('#assigne_phone').val();
                var role = $('#role_name').val();
                var country = $('#id_countru').val();
                var company = $('#assigne_company').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('users.store') }}',
                    cache: false,
                    data: {
                        name: name,
                        email: email,
                        password: password,
                        phone: phone,
                        role: role,
                        country: country,
                        company: company,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.', 'User Has been Addess Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            location.reload();
                        } else {
                            toastr.warning('Oppps.', 'Please Change Email!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                    }
                });
            });
        });
        $(function(e) {
            $('.active').click(function(e) {
                var id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('users.active') }}',
                    cache: false,
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.',
                            'User Status Has been Change Success!', {
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
        $(function(e) {
            $('.reset').click(function(e) {
                var id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('users.reset') }}',
                    cache: false,
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.',
                            'User Has been Reset Password Success!', {
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
        $(function(e) {
            $('.inactive').click(function(e) {
                var ids = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('users.inactive') }}',
                    cache: false,
                    data: {
                        id: ids,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.',
                            'User Status Has been Change Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                        location.reload();
                    }
                });
            });
            $('#add-bank').click(function(e) {
                var name = $('#bank_name').val();
                var swift = $('#bank_swift').val();
                var iban = $('#bank_iban').val();
                var bic = $('#bank_bic').val();
                var rib = $('#bank_rib').val();
                var email = $('#bank_email').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('banks.store') }}',
                    cache: false,
                    data: {
                        name: name,
                        swift: swift,
                        iban: iban,
                        bic: bic,
                        rib: rib,
                        email: email,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.',
                                'User Has been Change password Success!', {
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

        $(function() {
            $('body').on('click', '.update', function() {
                var id = $(this).data('id');
                //console.log(product_id);
                $.get("{{ route('users.index') }}" + '/' + id + '/edit', function(data) {
                    //console.log(product_id);
                    $('#edit_user').modal('show');
                    $('#user_id').val(data.id);
                    $('#user_name').val(data.name);
                    $('#user_phone').val(data.telephone);
                    $('#user_email').val(data.email);
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
            $('body').on('click', '.password', function() {
                var id = $(this).data('id');
                $('#modal_password').modal('show');
                $('#user_id').val(id);
            })
        });
        $(function() {
            $('body').on('change', '#role_name', function() {
                var id = $('#role_name').val();
                if (id == "7") {
                    $('.company').show();
                }
                if (id != 7) {
                    $('.company').hide();
                }
            });
        });
    </script>
@endsection
