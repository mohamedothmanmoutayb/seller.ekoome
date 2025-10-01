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
        <!-- Content -->

            <div class="card card-body py-3">
                <div class="row align-items-center">
                <div class="col-12">
                     <div class="d-sm-flex align-items-center justify-space-between">
                         <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                        <i class="ti ti-arrow-left fs-5"></i> 
                    </a>
                    <div>
                        <h4 class="mb-4 mb-sm-0 card-title">Cities</h4>
                        <p class="mb-0 text-muted"> Manage active cities per country.</p>
                                    
                    </div>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            {{-- <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex" href="{{ route('home')}}">
                                <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                            </li> --}}
                            <li class="nav-item ms-auto">
                                <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center px-3 gap-6" data-bs-toggle="modal"
                                    data-bs-target="#add-citie">
                                    <i class="ti ti-plus fs-4"></i>
                                    <span class="d-none d-md-block fw-medium fs-3">Add New Citie</span>
                                </a>
                            </li>
                        </ol>
                    </nav>
                    </div>
                </div>
                </div>
            </div>

            
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->
       
    <!-- create lead manule -->
    <div id="add-citie" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">New Citie</h4>

                </div>
                <form class="form-horizontal form-material">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 my-2">
                                    <label>Name :</label>
                                    <input type="text" class="form-control" id="name_citie" placeholder="Name Citie">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 my-2">
                                    <lable>Select Shipping Countrie Or Delivery Man</lable>
                                    <select class="form-control" id="shippingcompany">
                                        <option>Select Shipping Countrie Or Delivery Man :</option>
                                        <option value="Livreur">Livreur</option>
                                        @foreach ($shippingcompany as $v_shipping)
                                            <option value="{{ $v_shipping->name }}">{{ $v_shipping->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 my-2">
                                    <label>Fees Delivered :</label>
                                    <input type="text" class="form-control" id="fees_delivered" value="30">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 my-2">
                                    <label>Fees Return :</label>
                                    <input type="text" class="form-control" id="fees_return" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary waves-effect" id="saveCitie">Save</button>
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
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="form-group-2">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-5 col-sm-12">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="search" id="search"
                                                        placeholder=" City" aria-label="" aria-describedby="basic-addon1">
                                                </div>
                                            </div>
                                            <div class="col-md-5 col-sm-12">
                                                <select class="form-control" id="id_cit" name="city">
                                                    <option value=" ">Select Last Mille</option>
                                                    @foreach($lastmille as $v_lastmille)
                                                    <option value="{{ $v_lastmille->name}}">{{$v_lastmille->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2 col-sm-12">
                                                <button class="btn btn-primary w-100" type="submit">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                <!-- Add city Popup Model -->
                                <div id="add-city" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="height:auto !important;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Add New City</h4>
                                                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <from class="form-horizontal form-material">
                                                    <div class="form-group">

                                                        <div class="col-md-12 col-sm-12 m-b-20 mt-4">
                                                            <select class="form-control" id="country">
                                                                <option value="">Select Country</option>
                                                                @foreach ($countries as $v_country)
                                                                    <option value="{{ $v_country->id }}">
                                                                        {{ $v_country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 m-b-20 mt-4">
                                                            <select class="form-control" id="province">
                                                                <option value="">Select Provinces</option>
                                                                @foreach ($provinces as $v_province)
                                                                    <option value="{{ $v_province->id }}">
                                                                        {{ $v_province->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <input type="text" class="form-control" id="city" placeholder="City">
                                                        </div>
                                                    </div>
                                                </from>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary waves-effect"
                                                    id="savecity">Save</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div id="edit-city" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="height:auto !important;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Update City</h4>
                                                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <from class="form-horizontal form-material">
                                                    <div class="form-group">
                                                        <div class="col-md-12 m-b-20 ">
                                                            <input type="hidden" id="update_id" />
                                                            <lable>Name</lable>
                                                            <input type="text" class="form-control" id="update_city" placeholder="City">
                                                        </div>
                                                        <div class="col-md-12 m-b-20 mt-2">
                                                            <lable>Fees Delivered</lable>
                                                            <input type="text" class="form-control" id="update_fees_delivered" placeholder="Fees Delivered">
                                                        </div>
                                                        <div class="col-md-12 m-b-20 mt-2">
                                                            <lable>Fees Returned</lable>
                                                            <input type="text" class="form-control" id="update_fees_returned" placeholder="Fees Returned">
                                                        </div>
                                                    </div>
                                                </from>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary waves-effect" id="updatecity">Save</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- Add province Popup Model -->
                                <div id="upload-province" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="height:auto !important;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Upload Cities</h4>
                                                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('cities.upload') }}" method="post"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="col-md-12 col-sm-12 m-b-20 mt-4">
                                                            <select class="form-control" name="country">
                                                                <option value="">Select Country</option>
                                                                @foreach ($countries as $v_country)
                                                                    <option value="{{ $v_country->id }}">
                                                                        {{ $v_country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 m-b-20 mt-4">
                                                            <select class="form-control" name="province">
                                                                <option value="">Select Provinces</option>
                                                                @foreach ($provinces as $v_province)
                                                                    <option value="{{ $v_province->id }}">
                                                                        {{ $v_province->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <input type="file" class="form-control" name="csv_file"
                                                                id="csv_file" placeholder="province">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit"
                                                        class="btn btn-primary waves-effect">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>

              <div class="col-xl-12 col-lg-12 col-md-12 box-col-12">
                <div class="card order-card">
                  <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                      <div class="flex-grow-1">
                        <p class="square-after f-w-600">List cities<i class="fa fa-circle"></i></p>
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
                            <th>Fees Delivered</th>
                            <th>Fees Returned</th>
                            <th>Type</th>
                            <th>Country</th>
                            <th>Status</th>
                            {{-- <th>Created at</th> --}}
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            ?>
                            @foreach ($cities as $v_city)
                            <tr>
                                <td>{{ $counter }}</td>
                                <td>{{ $v_city->name }}</td>
                                <td>{{ $v_city->fees_delivered }} DH</td>
                                <td>{{ $v_city->fees_returned }} DH</td>
                                <td>{{ $v_city->last_mille}}</td>
                                <td>
                                    @foreach ($v_city['country'] as $v_country)
                                        {{ $v_country->name }}
                                    @endforeach
                                </td>
                                <td>
                                    @if($v_city->is_active == 1)
                                    <span class="badge bg-success text-white">Active</span>
                                    @else
                                    <span class="badge bg-warning text-white">InActive</span>
                                    @endif
                                </td>
                                {{-- <td>{{ $v_city->created_at }}</td> --}}
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle show" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="icon-settings"></i></button>
                                        <div class="dropdown-menu" bis_skin_checked="1" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(184px, -325.203px, 0px);" data-popper-placement="top-start">                          
                                            <a class="dropdown-item deleted" data-id="{{ $v_city->id }}">Deleted</a>
                                            @if($v_city->is_active == 1)
                                            <a class="dropdown-item" href="{{ route('cities.inactive', $v_city->id)}}">InActive</a>
                                            @else
                                            <a class="dropdown-item" href="{{ route('cities.active', $v_city->id)}}">Active</a>
                                            @endif
                                            <a class="dropdown-item edit" data-id="{{ $v_city->id }}">Update</a>
                                        </div>
                                        
                                    </div> 
                                </td>
                            </tr>
                            <?php $counter++; ?>
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                   
                        {{ $cities->withQueryString()->links('vendor.pagination.courier') }}
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
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- edit city Popup Model -->
        <div id="edit-city" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Update City</h4>
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <from class="form-horizontal form-material">
                            <div class="form-group">

                                <div class="col-md-12 col-sm-12 m-b-20 mt-4" id="select_country">

                                </div>
                                <div class="col-md-12 m-b-20 mt-4">
                                    <input type="text" class="form-control" id="citie" placeholder="City">
                                </div>
                            </div>
                        </from>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary waves-effect" id="editcity">Save</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        @section('script')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
                $(function(e) {
                    $('#saveCitie').click(function(e) {
                        var city = $('#name_citie').val();
                        var company = $('#shippingcompany').val();
                        var delivered = $('#fees_delivered').val();
                        var returned = $('#fees_return').val();
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('cities.store') }}',
                            cache: false,
                            data: {
                                city: city,
                                company: company,
                                delivered: delivered,
                                returned: returned,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success == true) {
                                    toastr.success('Good Job.',
                                        'City Has been Addess Success!', {
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
            $(document).ready(function() {


                $(function(e) {
                    $('#updatecity').click(function(e) {
                        var id = $('#update_id').val();
                        var city = $('#update_city').val();
                        var delivered = $('#update_fees_delivered').val();
                        var returned = $('#update_fees_returned').val();
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('cities.update') }}',
                            cache: false,
                            data: {
                                id: id,
                                city: city,
                                delivered: delivered,
                                returned: returned,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success == true) {
                                    toastr.success('Good Job.',
                                        'City Has been Update Success!', {
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
                    $('.deleted').click(function(e) {
                        var id = $(this).data('id');
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('cities.delete') }}',
                            cache: false,
                            data: {
                                id: id,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success == true) {
                                    toastr.success('Good Job.',
                                        'City Has been Deleted Success!', {
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
                    $('body').on('click', '.edit', function(products) {
                        var id = $(this).data('id');
                        $.get("{{ route('cities.index') }}" + '/' + id + '/details', function(data) {
                            $('#edit-city').modal('show');

                            $('#update_id').val(id);
                            $('#update_city').val(data.name);
                            $('#update_fees_delivered').val(data.fees_delivered);
                            $('#update_fees_returned').val(data.fees_returned);

                        });
                    });
                });
            });
        </script>
        @endsection
    @endsection
