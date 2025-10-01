@extends('backend.layouts.app')
@section('content')
    <style>
        .dropdown-menu.show {
            display: block;
        }
        .card-body,
        .table-responsive {
        overflow: visible !important; /* allow dropdowns to overflow */
        }

        .dropdown-menu {
        z-index: 1050 !important; /* above card & table */
        }
    </style>
    <!-- ============================================================== -->

    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                     <div class="d-sm-flex align-items-center justify-space-between">
                         <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                        <i class="ti ti-arrow-left fs-5"></i> 
                    </a>
                    <div>
                        <h4 class="mb-4 mb-sm-0 card-title">Users <span id="userLimitBadge" class="badge bg-danger ms-2 d-none"></span></h4>
                        <p class="mb-0 text-muted"> Track sales, leads, and performance in real time.</p>
                                    
                    </div>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex" href="{{ route('home') }}">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>

    </div>


    <ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row">
        <li class="nav-item">
            <a href="javascript:void(0)" onclick="toggleText()"
                class="nav-link gap-6 note-link d-flex align-items-center justify-content-center px-3 px-md-3 me-0 me-md-2 fs-11 active"
                id="all-category">
                <i class="ti ti-list fill-white"></i>
                <span class="d-none d-md-block fw-medium">Filter</span>
            </a>
        </li>
        <li class="nav-item ms-auto">
            <a type="button" class="btn btn-primary btn-rounded waves-effect waves-light text-white my-2"
                data-bs-toggle="modal" data-bs-target="#adduser" id="addUserBtn">Add New User</a>
        </li>
        <div class="col-12 form-group multi mt-2" id="multi">
            <div class="form-group-1">
                <form>
                    <div class="row">
                        <div class="col-md-11 col-sm-12">
                            <label for="User Name" style="margin-left: 8px; margin-bottom: 5px;">User Name</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" id="search"
                                    placeholder="Name User" aria-label="" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-12">
                            <div class="input-group-append">
                                <button class="btn btn-primary mt-4" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </ul>
    <!-- ============================================================== -->
    <div class="col-xl-12 col-lg-12 col-md-12 box-col-12">
        <div class="card order-card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1">
                        <p class="square-after f-w-600">List users<i class="fa fa-circle"></i></p>
                    </div>
                    <div class="setting-list">
                        <ul class="list-unstyled setting-option">
                            <li>
                                <div class="setting-light"><i class="icon-layout-grid2"></i></div>
                            </li>
                            <li><i class="view-html fa fa-code font-white"></i></li>
                            <li><i class="icofont icofont-maximize full-card font-white"></i></li>
                            <li><i class="icofont icofont-minus minimize-card font-white"></i></li>
                            <li><i class="icofont icofont-refresh reload-card font-white"></i></li>
                            <li><i class="icofont icofont-error close-card font-white"> </i></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive theme-scrollbar">
                    <table class="table table-bordernone">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Active</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $counter = 1; ?>
                            @forelse ($users as $v_user)
                                <tr>
                                    <td>{{ $counter }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-6">
                                            <img src="{{ asset('public/assets/images/profile/user-1.jpg') }}" alt="prd1"
                                                width="48" class="rounded">
                                            {{ $v_user->name }}
                                        </div>
                                    </td>
                                    <td>{{ $v_user->email }}</td>
                                    <td>{{ $v_user['rol']->name }}</td>
                                    <td>
                                        @if ($v_user->is_active == '1')
                                            <span class="badge bg-success-subtle text-success">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">InActive</span>
                                        @endif
                                    </td>
                                    <td>{{ $v_user->created_at ? $v_user->created_at->format('F j, Y') : '-' }}</td>
                                    <td>
                                        <div class="dropdown" data-bs-display="static">
                                            <button class="btn btn-primary dropdown-toggle show" type="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i
                                                    class="icon-settings"></i></button>
                                            <div class="dropdown-menu" bis_skin_checked="1"
                                                style="position: absolute; z-index: 9999; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(184px, -325.203px, 0px);"
                                                data-popper-placement="top-start">
                                                @if ($v_user->is_active == '0')
                                                    <a class="dropdown-item activee" data-id="{{ $v_user->id }}">Active</a>
                                                @else
                                                    <a class="dropdown-item inactive"
                                                        data-id="{{ $v_user->id }}">InActive</a>
                                                @endif
                                                <a class="dropdown-item password" data-id="{{ $v_user->id }}">Change
                                                    Password</a>
                                                <a class="dropdown-item update" data-id="{{ $v_user->id }}">Update</a>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                                <?php $counter++; ?>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <img src="{{ asset('public/Empty-amico.svg') }}" class="img-fluid" width="300"
                                            style="margin: 0 auto; display: block;">
                                        <p class="mt-3 text-muted">No users found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Add User Popup Model -->
    <div id="adduser" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add New User</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-material">
                        <div class="form-group">
                            <div class="col-md-12 my-3">
                                <label for="id_countru" style="margin-left: 8px; margin-bottom: 5px;">Country</label>
                                <select class="form-control" name="id_countru" id="id_countru">
                                    <option>Select Country</option>
                                    @foreach ($countries as $v_country)
                                        <option value="{{ $v_country->id }}">{{ $v_country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 my-3">
                                <label for="role_name" style="margin-left: 8px; margin-bottom: 5px;">Role</label>
                                <select class="form-control role_name" name="id_role" id="role_name">
                                    <option>Select Roles</option>
                                    @foreach ($roles as $v_role)
                                        <option value="{{ $v_role->id }}">{{ $v_role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 my-3 warehouse" style="display: none;">
                                <label for="warehouse_name" style="margin-left: 8px; margin-bottom: 5px;">Warehouse</label>
                                <select class="form-control " name="warehouse_name" id="warehouse_name">
                                    <option>Select Warehouse</option>
                                    @foreach ($warehouses as $v_warehouse)
                                        <option value="{{ $v_warehouse->id }}">{{ $v_warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 my-3 company" id="company" style="display: none;">
                                <label for="assigne_company" style="margin-left: 8px; margin-bottom: 5px;">Company</label>
                                <input type="text" class="form-control" id="assigne_company" placeholder="Company">
                            </div>
                            <div class="col-md-12 my-3">
                                <label for="assigne_name" style="margin-left: 8px; margin-bottom: 5px;">User Name</label>
                                <input type="text" class="form-control" id="assigne_name" placeholder="User Name">
                            </div>
                            <div class="col-md-12 my-3">
                                <label for="assigne_phone" style="margin-left: 8px; margin-bottom: 5px;">Phone</label>
                                <input type="phone" class="form-control" id="assigne_phone" placeholder="Phone">
                            </div>
                            <div class="col-md-12 my-3">
                                <label for="assigne_email" style="margin-left: 8px; margin-bottom: 5px;">Email</label>
                                <input type="email" class="form-control" id="assigne_email" placeholder="Email">
                            </div>
                            <div class="col-md-12 my-3">
                                <label for="assigne_password" style="margin-left: 8px; margin-bottom: 5px;">Password</label>
                                <input type="password" class="form-control" id="assigne_password"
                                    placeholder="password">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-body">
                    <button type="submit" class="btn btn-primary waves-effect" id="add-user">
                        <span class="spinner-border spinner-border-sm me-1 d-none" id="saveSpinner"></span>
                        Save</button>
                    <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
                        <button type="button" class="btn btn-primary waves-effect"
                            data-bs-dismiss="modal">Cancel</button>
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
                        <button type="button" class="btn btn-primary waves-effect"
                            data-bs-dismiss="modal">Cancel</button>
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
                        <button type="button" class="btn btn-primary waves-effect"
                            data-bs-dismiss="modal">Cancel</button>
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
            $(document).ready(function() {
                checkUserLimits();
            });

            $(function(e) {
                $('#add-user').click(function(e) {
                    e.preventDefault();

                    var button = $(this);

                    var name = $('#assigne_name').val();
                    var email = $('#assigne_email').val();
                    var password = $('#assigne_password').val();
                    var phone = $('#assigne_phone').val();
                    var role = $('#role_name').val();
                    var country = $('#id_countru').val();
                    var company = $('#assigne_company').val();
                    var warehouse = $('#warehouse_name').val();

                    $('#saveSpinner').removeClass('d-none');
                    button.prop('disabled', true);

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
                            warehouse: warehouse,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success === true) {
                                toastr.success('Good Job.', 'User Has been Added Successfully!', {
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
                        },
                        error: function(xhr) {
                            toastr.error('Error', 'Something went wrong!');
                        },
                        complete: function() {
                            $('#saveSpinner').addClass('d-none');
                            button.prop('disabled', false);
                        }
                    });
                });
            });

            $(function(e) {
                $('.activee').click(function(e) {
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
                $('#changepassword').click(function(e) {
                    var id = $('#user_id').val();
                    var password = $('#new_password').val();
                    var newpassword = $('#con_new_password').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('users.password') }}',
                        cache: false,
                        data: {
                            id: id,
                            password: password,
                            newpassword: newpassword,
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
                })
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
                $('body').on('change', '.role_name', function() {
                    var id = $('#role_name').val();
                    if (id == "7") {
                        $('.company').show();
                    }
                    if (id != 7) {
                        $('.company').hide();
                    }
                    if (id == "6" || id == "7" || id == "5") {
                        $('.warehouse').show();
                    }
                    if (id != "6" && id != "7" && id != "5") {
                        $('.warehouse').hide();
                    }
                });
            });

            function checkUserLimits() {
                $.ajax({
                    url: '/usage/limits/check',
                    type: 'GET',
                    success: function(response) {
                        if (response.users) {
                            const users = response.users;

                            if (users.is_over_limit) {
                                $('#userLimitBadge')
                                    .removeClass('d-none bg-info bg-success')
                                    .addClass('bg-danger')
                                    .text('Limit Exceeded');

                                $('#userLimitAlert').removeClass('d-none');
                                $('#addUserBtn').prop('disabled', true);
                                $('#addUserBtn').html('<i class="fas fa-ban me-1"></i> Limit Exceeded');
                                $('.card').addClass('limit-exceeded');

                                toastr.warning(
                                    'You have exceeded your user limit. Please upgrade your plan to add more users.',
                                    'Limit Exceeded'
                                );

                            } else {
                                $('#userLimitBadge')
                                    .removeClass('d-none bg-danger')
                                    .addClass('bg-success')
                                    .text(`${users.current_usage} / ${users.limit} Users`);

                                $('#userLimitAlert').addClass('d-none');
                                $('#addUserBtn').prop('disabled', false);
                                $('#addUserBtn').html('<i class="fas fa-plus me-1"></i> Add New User');
                                $('.card').removeClass('limit-exceeded');
                            }
                        }
                    },
                    error: function() {
                        console.error('Failed to check user limits');
                    }
                });
            }
        </script>
    @endsection
@endsection
