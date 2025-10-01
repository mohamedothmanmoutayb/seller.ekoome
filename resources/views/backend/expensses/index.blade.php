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
                         <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                        <i class="ti ti-arrow-left fs-5"></i> 
                    </a>
                    <div>
                        <h4 class="mb-4 mb-sm-0 card-title">Expenses</h4>
                        <p class="mb-0 text-muted"> Track and manage your spending.</p>
                                    
                    </div>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item d-flex align-items-center">
                            <a class="text-muted text-decoration-none d-flex" href="{{ route('home')}}">
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
                <a href="javascript:void(0)" onclick="toggleText()" class="nav-link gap-6 note-link d-flex align-items-center justify-content-center px-3 px-md-3 me-0 me-md-2 fs-11 active" id="all-category">
                    <i class="ti ti-list fill-white"></i>
                    <span class="d-none d-md-block fw-medium">Filter</span>
                </a>
                </li>
                <li class="nav-item ms-auto">
                    <a type="button" class="btn btn-primary btn-rounded waves-effect waves-light text-white my-2" data-bs-toggle="modal" data-bs-target="#addexpensse">+ Add New Expensses</a>
                </li>
                <div class="col-12 form-group multi mt-2" id="multi" >
                    <div class="form-group-1">
                        <form>
                            <div class="row">
                                <label for="Username" class="col-md-12 col-sm-12" style="margin-left: 8px; margin-bottom: 5px;">User Name</label>
                                <div class="col-md-11 col-sm-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" id="search" placeholder="Name User" aria-label="" aria-describedby="basic-addon1">
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
            </ul>
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 box-col-12">
              <div class="card order-card">
                <div class="card-header pb-0">
                  <div class="d-flex justify-content-between">
                  
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
                            <th>Category</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $counter = 1; ?>
                        @forelse ($expenses as $v_expenses)
                        <tr>
                            <td>{{ $counter }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-6">
                                    <img src="{{asset('public/assets/images/profile/user-1.jpg')}}" alt="prd1" width="48" class="rounded">
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
                            <td>{{ $v_user->created_at }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle show" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="icon-settings"></i></button>
                                    <div class="dropdown-menu show" bis_skin_checked="1" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(184px, -325.203px, 0px);" data-popper-placement="top-start">                          
                                        @if ($v_user->is_active == '0')
                                        <a class="dropdown-item active" data-id="{{ $v_user->id }}">Active</a>
                                        @else
                                        <a class="dropdown-item inactive" data-id="{{ $v_user->id }}">InActive</a>
                                        @endif
                                        <a class="dropdown-item password" data-id="{{ $v_user->id }}">Change Password</a>
                                        <a class="dropdown-item update" data-id="{{ $v_user->id }}">Update</a>
                                    </div>
                                    
                                </div> 
                            </td>
                        </tr>
                        <?php $counter++; ?>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                <img src="{{ asset('public/Empty-amico.svg') }}" class="img-fluid"
                                    width="300" style="margin: 0 auto; display: block;">
                                <p class="mt-3 text-muted">No Expenses Recorded.</p>
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
        <div id="addexpensse" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Add New Expensse</h4>
                    </div>
                    <div class="modal-body">
                        <from class="form-horizontal form-material">
                            <div class="form-group">
                                <div class="col-md-12 my-3">
                                    <select class="form-control" name="id_countru" id="id_countru">
                                        <option>Select Category</option>
                                        @foreach ($categories as $v_category)
                                            <option value="{{ $v_category->id }}">{{ $v_category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 my-3 company" id="company" style="display: none;">
                                    <input type="text" class="form-control" id="name_expensse" placeholder="Expensse Name">
                                </div>
                                <div class="col-md-12 my-3">
                                    <input type="phone" class="form-control" id="amount_expensse" placeholder="Expensse Amount">
                                </div>
                                <div class="col-md-12 my-3">
                                    <textarea type="text" class="form-control" id="description_expensse" placeholder="Expensse Description"></textarea>
                                </div>
                                <div class="col-md-12 my-3">
                                    <input type="email" class="form-control" id="assigne_email" placeholder="Email">
                                </div>
                            </div>
                        </from>
                    </div>
                    <div class="modal-body">
                        <button type="submit" class="btn btn-primary waves-effect" id="add-user">Save</button>
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
    @section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    <script type="text/javascript">
        // $(function(e) {
        //     $('#add-user').click(function(e) {
        //         var name = $('#assigne_name').val();
        //         var email = $('#assigne_email').val();
        //         var password = $('#assigne_password').val();
        //         var phone = $('#assigne_phone').val();
        //         var role = $('#role_name').val();
        //         var country = $('#id_countru').val();
        //         var company = $('#assigne_company').val();
        //         var warehouse = $('#warehouse_name').val();
        //         $.ajax({
        //             type: 'POST',
        //             url: '{{ route('users.store') }}',
        //             cache: false,
        //             data: {
        //                 name: name,
        //                 email: email,
        //                 password: password,
        //                 phone: phone,
        //                 role: role,
        //                 country: country,
        //                 company: company,
        //                 warehouse: warehouse,
        //                 _token: '{{ csrf_token() }}'
        //             },
        //             success: function(response) {
        //                 if (response.success == true) {
        //                     toastr.success('Good Job.', 'User Has been Addess Success!', {
        //                         "showMethod": "slideDown",
        //                         "hideMethod": "slideUp",
        //                         timeOut: 2000
        //                     });
        //                     location.reload();
        //                 } else {
        //                     toastr.warning('Oppps.', 'Please Change Email!', {
        //                         "showMethod": "slideDown",
        //                         "hideMethod": "slideUp",
        //                         timeOut: 2000
        //                     });
        //                 }
        //             }
        //         });
        //     });
        // });
        // $(function(e) {
        //     $('.active').click(function(e) {
        //         var id = $(this).data('id');
        //         $.ajax({
        //             type: 'POST',
        //             url: '{{ route('users.active') }}',
        //             cache: false,
        //             data: {
        //                 id: id,
        //                 _token: '{{ csrf_token() }}'
        //             },
        //             success: function(response) {
        //                 if (response.success == true) {
        //                     toastr.success('Good Job.',
        //                     'User Status Has been Change Success!', {
        //                         "showMethod": "slideDown",
        //                         "hideMethod": "slideUp",
        //                         timeOut: 2000
        //                     });
        //                 }
        //                 location.reload();
        //             }
        //         });
        //     });
        // });
        // $(function(e) {
        //     $('.reset').click(function(e) {
        //         var id = $(this).data('id');
        //         $.ajax({
        //             type: 'POST',
        //             url: '{{ route('users.reset') }}',
        //             cache: false,
        //             data: {
        //                 id: id,
        //                 _token: '{{ csrf_token() }}'
        //             },
        //             success: function(response) {
        //                 if (response.success == true) {
        //                     toastr.success('Good Job.',
        //                     'User Has been Reset Password Success!', {
        //                         "showMethod": "slideDown",
        //                         "hideMethod": "slideUp",
        //                         timeOut: 2000
        //                     });
        //                 }
        //                 location.reload();
        //             }
        //         });
        //     });
        // });
        // $(function(e) {
        //     $('.inactive').click(function(e) {
        //         var ids = $(this).data('id');
        //         $.ajax({
        //             type: 'POST',
        //             url: '{{ route('users.inactive') }}',
        //             cache: false,
        //             data: {
        //                 id: ids,
        //                 _token: '{{ csrf_token() }}'
        //             },
        //             success: function(response) {
        //                 if (response.success == true) {
        //                     toastr.success('Good Job.',
        //                     'User Status Has been Change Success!', {
        //                         "showMethod": "slideDown",
        //                         "hideMethod": "slideUp",
        //                         timeOut: 2000
        //                     });
        //                 }
        //                 location.reload();
        //             }
        //         });
        //     });
        //     $('#changepassword').click(function(e) {
        //         var id = $('#user_id').val();
        //         var password = $('#new_password').val();
        //         var newpassword = $('#con_new_password').val();
        //         $.ajax({
        //             type: 'POST',
        //             url: '{{ route('users.password') }}',
        //             cache: false,
        //             data: {
        //                 id: id,
        //                 password: password,
        //                 newpassword: newpassword,
        //                 _token: '{{ csrf_token() }}'
        //             },
        //             success: function(response) {
        //                 if (response.success == true) {
        //                     toastr.success('Good Job.',
        //                         'User Has been Change password Success!', {
        //                             "showMethod": "slideDown",
        //                             "hideMethod": "slideUp",
        //                             timeOut: 2000
        //                         });
        //                 }
        //                 location.reload();
        //             }
        //         });
        //     })
        // });

        // $(function() {
        //     $('body').on('click', '.update', function() {
        //         var id = $(this).data('id');
        //         //console.log(product_id);
        //         $.get("{{ route('users.index') }}" + '/' + id + '/edit', function(data) {
        //             //console.log(product_id);
        //             $('#edit_user').modal('show');
        //             $('#user_id').val(data.id);
        //             $('#user_name').val(data.name);
        //             $('#user_phone').val(data.telephone);
        //             $('#user_email').val(data.email);
        //         });
        //     });
        //     $('body').on('click', '#multi', function() {
        //         $('.multi').show();
        //     })
        // });


        // $(function() {
        //     $('body').on('click', '.configupsel', function() {
        //         var product_id = $(this).data('id');
        //         //console.log(product_id);
        //         $('#config_upsel').modal('show');
        //         $('#upsel_product_id').val(product_id);

        //     });
        //     $('body').on('click', '.password', function() {
        //         var id = $(this).data('id');
        //         $('#modal_password').modal('show');
        //         $('#user_id').val(id);
        //     })
        // });
        // $(function() {
        //     $('body').on('change', '.role_name', function() {
        //         var id = $('#role_name').val();
        //         if (id == "7") {
        //             $('.company').show();
        //         }
        //         if (id != 7) {
        //             $('.company').hide();
        //         }
        //         if (id == "6" || id == "7" || id == "5" ) {
        //             $('.warehouse').show();
        //         }
        //         if (id != "6" && id != "7" && id != "5" ) {
        //             $('.warehouse').hide();
        //         }
        //     });
        // });
    </script>
    @endsection
@endsection
