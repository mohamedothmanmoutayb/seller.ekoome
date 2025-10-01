@extends('backend.layouts.app')
@section('content')
   <style>
        body{
          overflow-x: hidden;
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
                        <h4 class="mb-4 mb-sm-0 card-title">Stores</h4>
                        <p class="mb-0 text-muted">Manage and monitor all your connected stores in one place.</p>
                                    
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
            <!-- ============================================================== -->

            <ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row">
                <li class="nav-item">
                <a href="javascript:void(0)" onclick="toggleText()" class="nav-link gap-6 note-link d-flex align-items-center justify-content-center px-3 px-md-3 me-0 me-md-2 fs-11 active" id="all-category">
                    <i class="ti ti-list fill-white"></i>
                    <span class="d-none d-md-block fw-medium">Filter</span>
                </a>
                </li>
                <li class="nav-item ms-auto">
                    <button type="button" class="btn btn-primary btn-rounded mb-2" data-bs-toggle="modal" data-bs-target="#add-contact">  + Add New Store</button>
                </li>
                <div class="col-12 form-group multi" id="multi" >
                    <form>
                        <div class="row">
                            <div class="col-md-5 col-sm-12">
                                                                    <label for="search " style="margin-bottom: 5px;">Search by Store Name</label>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="search" placeholder="Enter store name " aria-label="" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12">
                         <label for="product" style="margin-bottom: 5px;">Choose Product</label>
                                <div class="input-group mb-3">
                                    <select class="form-control select2 mx-2" name="product">
                                        <option value="">Select Product</option>
                                        @foreach ($products as $v_product)
                                        <option value="{{ $v_product->id }}">{{ $v_product->name }} / {{$v_product->sku}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 mt-4">
                                <button class="btn btn-primary w-full" style="width:100%" type="submit">Search</button>
                            </div><br>
                        </div>
                    </form>
                </div>
            </ul>
            <!-- Add Contact Popup Model -->
            <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Add New Store</h4>
                        </div>
                        <form action="{{ route('stores.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                    <div class="form-group">
                                        <div class="col-md-12 m-b-20">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Store Name"
                                                required>
                                        </div>
                                        <div class="col-md-12 m-b-20 mt-3">
                                            <input type="text" class="form-control" id="link" name="link" placeholder="Link"
                                                required>
                                        </div>
                                        <div class="col-md-12 m-b-20 mt-3">
                                            <input type="file" class="form-control" name="image" placeholder="Image">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect">Save</button>
                                <button type="button" class="btn btn-default waves-effect"
                                    data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <!--/ Bordered Table -->
                <div class="col-xl-12 col-lg-12 col-md-12 box-col-12">
                    <div class="card order-card">
                        {{-- <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <div class="flex-grow-1">
                                    <p class="square-after f-w-600  dropdown-toggle show" type="button" id="btnGroupDrop1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Select Action<i class="fa fa-circle"></i></p>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" bis_skin_checked="1" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(0px, -44px, 0px);" data-popper-placement="top-start" data-popper-reference-hidden="">
                                        <a class="dropdown-item" id="exportss">Export</a>
                                        <a class="dropdown-item" id="deletedselected">Deleted</a>
                                    </div>
                                </div>
                                <div class="setting-list">
                                </div>
                            </div>
                        </div> --}}

                        <div class="card-header pb-0">
                            <div class="row">
                                @if(!$stores->isempty())
                                @foreach ($stores as $v_store)
                                <div class="col-sm-4 col-xxl-3 pb-0">
                                    <div class="card overflow-hidden rounded-2 border">
                                    <div class="position-relative">
                                        <a href="" class="hover-img d-block overflow-hidden">
                                        <img src="{{$v_store->image}}" class="card-img-top rounded-0" alt="matdash-img" style="max-height: 323px;">
                                        </a>
                                        <div class="dropup d-inline-flex position-absolute bottom-0 end-0  me-3 translate-middle-y " style="bottom: -80px !important;">
                                            <button class="btn  dropdown-toggle  text-bg-primary rounded-circle text-white show" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="border-color: transparent !importante;"><i class="icon-settings"></i></button>
                                            <div class="dropdown-menu" bis_skin_checked="1" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(184px, -325.203px, 0px);" data-popper-placement="top-start">                          
                                                <a class="dropdown-item " href="{{ route('stores.products', $v_store->id) }}" id="">List Product</a>
                                                @if ($v_store->CountProduct($v_store->id) == 0)
                                                    <a href="{{ route('stores.delete', $v_store->id) }}" class="dropdown-item" data-toggle="tooltip" title="deleted">Deleted</a>
                                                @endif
                                                <a class="dropdown-item update" data-bs-id="{{ $v_store->id }}" data-id="{{ $v_store->id }}">Updated</a>   
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-3 p-4">
                                        <h6 class="fw-semibold fs-4">{{ $v_store->name }} </h6>
                                        <div class="d-flex align-items-center justify-content-between">
                                        <h6 class="fw-semibold fs-4 mb-0"><span class="ms-2 fw-normal text-muted fs-3">Total Product :{{ $v_store->CountProduct($v_store->id)}} </span><br>
                                        {{-- <span class="ms-2 fw-normal text-muted fs-3">Total Payment in Stock :  {{ $currency->currency}} </span> --}}
                                        </h6>
                                        <ul class="list-unstyled d-flex align-items-center mb-0">
                                        
                                        </ul>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="col-12">
                                    <img src="{{ asset('public/Empty-amico.svg')}}" style="margin-left: auto ; margin-right: auto; display: block;" width="500" />
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
        <div id="edit_store" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Edit Store</h4>
                    </div>
                    <form action="{{ route('stores.update') }}" method="POST" class="form-horizontal form-material"
                        enctype="multipart/form-data" novalidate="novalidate">

                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-md-12 m-b-20">
                                    <input type="text" class="form-control" name="store_name" id="store_name"
                                        maxlength="20" placeholder="Product Name">
                                    <input type="hidden" class="form-control" name="store_id" id="store_id"
                                        placeholder="Product Name">
                                </div>
                                <div class="col-md-12 m-b-20 mt-2">
                                    <input type="text" class="form-control" name="store_link" id="store_link"
                                        placeholder="Link">
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
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    @section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    <script type="text/javascript">
        $(function(e) {
            $('#save').click(function(e) {
                if ($('#name').val() != '') {
                    var name = $('#name').val();
                    var link = $('#link').val();
                    var image = $('#image').prop('files')[0];
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('stores.store') }}',
                        cache: false,
                        data: {
                            name: name,
                            link: link,
                            image: image,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            location.reload();
                            if (response.success == true) {
                                toastr.success('Good Job.', 'Store Has been Addess Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                // Validation errors occurred
                                var errors = xhr.responseJSON.errors;

                                // Display each error
                                for (var field in errors) {
                                    toastr.error('Good Job.', 'Opps ' + errors[field][0], {
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

                        }
                    });
                }

            });

            $('body').on('click', '.update', function() {
                var store_id = $(this).data('id');
                console.log(store_id);
                $.get("{{ route('stores.index') }}" + '/' + store_id + '/edit', function(data) {
                    //console.log(store_id);
                    $('#edit_store').modal('show');
                    $('#store_id').val(data.id);
                    $('#store_name').val(data.name);
                    $('#store_link').val(data.link);
                });
            });
           
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: 'Select  Product',
                    allowClear: true
                });
              
            });
        });

        function toggleText() {
            var x = document.getElementById("multi");
            $('#timeseconds').val('');
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
    @endsection
@endsection
