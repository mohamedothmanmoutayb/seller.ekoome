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
                        <h4 class="mb-4 mb-sm-0 card-title">Expense Categories</h4>
                                    
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
                    <a type="button" class="btn btn-primary btn-rounded waves-effect waves-light text-white my-2" data-bs-toggle="modal" data-bs-target="#adduser">+ Add New Category</a>
                </li>
                <div class="col-12 form-group multi mt-2" id="multi" >
                    <div class="form-group-1">
                        <form>
                            <div class="row">
                                <div class="col-md-11 col-sm-12">
                                    <label for="category-name" style="margin-left: 8px; margin-bottom: 5px;">Category Name</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" id="search" placeholder="Name User" aria-label="" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="col-md-1 col-sm-12 mt-4">
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
                    <div class="flex-grow-1">
                      <p class="square-after f-w-600">Our Total Sold<i class="fa fa-circle"></i></p>
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
                            <th>Image</th>
                            <th>Name</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $counter = 1; ?>
                        @forelse ($categories as $v_categorie)
                        <tr>
                            <td>{{ $counter }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-6">
                                    @if(empty($v_categorie->image))
                                    <img src="{{asset('public/assets/images/profile/user-1.jpg')}}" alt="prd1" width="48" class="rounded">
                                    @else
                                    <img src="{{ $v_categorie->image }}" alt="prd1" width="48" class="rounded">
                                    @endif
                                </div>
                            </td>
                            <td>{{ $v_categorie->name }}</td>
                            {{-- <td>
                                @if ($v_categorie->is_active == '1')
                                <span class="badge bg-success-subtle text-success">Active</span>
                                @else
                                <span class="badge bg-danger-subtle text-danger">InActive</span>
                                @endif
                            </td> --}}
                            <td>{{ $v_categorie->created_at }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle show" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="icon-settings"></i></button>
                                    <div class="dropdown-menu show" bis_skin_checked="1" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(184px, -325.203px, 0px);" data-popper-placement="top-start">                          
                                        {{-- @if ($v_categorie->is_active == '0')
                                        <a class="dropdown-item active" data-id="{{ $v_categorie->id }}">Active</a>
                                        @else
                                        <a class="dropdown-item inactive" data-id="{{ $v_categorie->id }}">InActive</a>
                                        @endif --}}
                                        <a class="dropdown-item update" data-id="{{ $v_categorie->id }}">Update</a>
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
                                <p class="mt-3 text-muted">No categories found.</p>
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
        <div id="adduser" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Add Category</h4>
                    </div>
                     <from  class="form-horizontal form-material"  enctype="multipart/form-data">
                        <div class="modal-body">
                                <div class="form-group">
                                    <div class="col-md-12 my-3">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <label for="category_name" class="form-label" style="color: #b4b3b3 ; margin-left:8px; font-weight:300;">Category Name</label>
                                        <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Category Name">
                                    </div>
                                    <div class="col-md-12 my-3">
                                        <label for="image" class="form-label" style="color: #b4b3b3 ; margin-left:8px; font-weight:300;">Image</label>
                                        <input type="file" class="form-control" name="image" id="image" placeholder="Image">
                                    </div>
                                </div>
                        </div>
                        <div class="modal-body">
                            <button type="submit" class="btn btn-primary waves-effect" id="add-category">Save</button>
                            <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </from>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->

    @section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    <script type="text/javascript">
    $(document).ready(function (e) {
        $("#uploadForm").submit(function(e){
            e.preventDefault();

            var formData = new FormData(this);
            
            $.ajax({
                url: "{{ route('categoryexpense.store') }}", // Route here
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,

                success: function(response){
                    if (response.success == true) {
                            toastr.success('Good Job.', 'Category Has been Addess Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            location.reload();
                    } else {
                            toastr.warning('Oppps.', 'Please Check Data!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                    }
                },
                error: function(xhr){
                    alert('Upload failed');
                }
            });
        });
    });
        $(function(e) {
            $('#add-user').click(function(e) {
                var name = $('#category_name').val();
                var image = $('#image_category').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('categoryexpense.store') }}',
                    cache: false,
                    data: {
                        name: name,
                        image: image,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.', 'Category Has been Addess Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            location.reload();
                        } else {
                            toastr.warning('Oppps.', 'Please Check Data!', {
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
            $('#add-category').click(function(e) {
                 let formData = new FormData();
                formData.append('category_name', $('#category_name').val());
                formData.append('image', $('#image')[0].files[0]); 
                formData.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    type: 'POST',
                    url: "{{ route('categoryexpense.store') }}",
                    cache: false,
                    data:  formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Good Job!',
                                text: 'Category has been added successfully!',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Please check your data!',
                                confirmButtonText: 'OK'
                            });
                        }

                    }
                });
            });
        });
        // // $(function(e) {
        // //     $('.active').click(function(e) {
        // //         var id = $(this).data('id');
        // //         $.ajax({
        // //             type: 'POST',
        // //             url: '{{ route('users.active') }}',
        // //             cache: false,
        // //             data: {
        // //                 id: id,
        // //                 _token: '{{ csrf_token() }}'
        // //             },
        // //             success: function(response) {
        // //                 if (response.success == true) {
        // //                     toastr.success('Good Job.',
        // //                     'User Status Has been Change Success!', {
        // //                         "showMethod": "slideDown",
        // //                         "hideMethod": "slideUp",
        // //                         timeOut: 2000
        // //                     });
        // //                 }
        // //                 location.reload();
        // //             }
        // //         });
        // //     });
        // // });
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
