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
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
       

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h3 class="page-title"><span
                            class="text-muted fw-light">Dashboard /</span> Categories</h3>
                    </div>
                    <div class="col-7 d-flex justify-content-end">
                        <div class="form-group mb-0 text-right">
                            <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light mt-2" data-bs-toggle="modal"
                                data-bs-target="#add_category">Add New Category <i class="ti ti-plus"></i></button>
                            <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light mt-2" data-bs-toggle="modal"
                               data-bs-target="#add_subcategory">Add New SubCategory <i class="ti ti-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row my-4">
                <div class="col-xl-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                           
                            <div class="table-responsive">
                                <table id="demo-foo-addrow"
                                    class="table table-bordered table-striped table-hover contact-list" data-paging="true"
                                    data-paging-size="7">
                                    <thead>
                                        <tr>                             
                                            <th>Category Name</th>
                                            <th>Created at</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        @foreach ($categories as $category)
                                            <tr>
                                               
                                                <td>
                                                    {{ $category->name }}
                                                </td>
                                                <td>{{ $category->created_at }}</td>
                                            </tr>
                                            
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $categories->withQueryString()->links('vendor.pagination.courier') }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="demo-foo-addrow"
                                    class="table table-bordered table-striped table-hover contact-list" data-paging="true"
                                    data-paging-size="7">
                                    <thead>
                                        <tr>                             
                                            <th>SubCategory Name</th>
                                            <th>Category Parent</th>
                                            <th>Created at</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subcategories as $category)
                                        <tr>
                                           
                                            <td>
                                                {{ $category->name }}
                                            </td>
                                            <td>
                                                {{ $category->category->name }}
                                            </td>
                                            <td>{{ $category->created_at }}</td>
                                           
                                        </tr>
                                        
                                    @endforeach
                                    </tbody>
                                </table>
                                {{ $subcategories->withQueryString()->links('vendor.pagination.courier') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
        </div>
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

    {{-- <div id="edit_product" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                                <input type="text" class="form-control" name="product_linkvideo"
                                    id="product_linkvideo" />
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="product_price" id="product_price"
                                    placeholder="Price">
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="product_weight" id="product_weight"
                                    placeholder="weight">
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
    </div> --}}
    <div id="add_category" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add Category</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                </div>
                <form action="{{ route('categories.store') }}" method="POST" class="form-horizontal form-material"
                    enctype="multipart/form-data" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Enter Name" required>
                              
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
    <div id="add_subcategory" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add SubCategory</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                </div>
                <form action="{{ route('categories.subcategoriesStore') }}" method="POST" class="form-horizontal form-material"
                    enctype="multipart/form-data" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                         
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="sub_name" id="sub_name"
                                    placeholder="Enter Name" required>
                                
                            </div>
                          
                            <div class="col-md-12 m-b-20">
                                <label for="">Category</label>
                                <select class="form-control" name="category_id" id="category_id" required>

                                    <option value="">Select Category Prent</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                </select>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    <script type="text/javascript">
    
   

    //deleted

    $(document).ready(function() {
            $('#add_subcategory form').submit(function(event) {
                event.preventDefault();

                var formData = new FormData($(this)[0]);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('categories.subcategoriesStore') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Good Job.', 'SubCategory Has Been Requested!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 3000
                            });
                            location.reload();
                        }
                        
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors occurred
                            var errors = xhr.responseJSON.errors;

                            // Display each error
                            for (var field in errors) {
                                toastr.warning('Good Job.', 'Opps ' + errors[field][0], {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 4000
                                });
                            }
                        } else {
                            // Other types of errors
                            toastr.warning('Good Job.', 'Opps Something went wrong!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                        console.log(xhr);
                    }
                });
            });
            $('#add_category form').submit(function(event) {
                event.preventDefault();

                var formData = new FormData($(this)[0]);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('categories.store') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Good Job.', 'SubCategory Has Been Requested!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 3000
                            });
                            location.reload();
                        }
                        console.log(response);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors occurred
                            var errors = xhr.responseJSON.errors;

                            // Display each error
                            for (var field in errors) {
                                toastr.warning('Good Job.', 'Opps ' + errors[field][0], {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 4000
                                });
                            }
                        } else {
                            // Other types of errors
                            toastr.warning('Good Job.', 'Opps Something went wrong!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                        console.log(xhr);
                    }
                });
            });
        });
</script>


@endsection
