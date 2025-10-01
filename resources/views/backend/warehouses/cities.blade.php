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
                    <h4 class="mb-4 mb-sm-0 card-title">Cities Assigned To Warehouse</h4>
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
                                            <div class="col-md-11 col-sm-12">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="search" id="search"
                                                        placeholder=" City" aria-label="" aria-describedby="basic-addon1">
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
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <input type="text" class="form-control" id="city"
                                                                placeholder="City">
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
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <input type="hidden" id="update_id" />
                                                            <input type="text" class="form-control" id="update_city"
                                                                placeholder="City">
                                                        </div>
                                                    </div>
                                                </from>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary waves-effect"
                                                    id="updatecity">Save</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>

              <div class="col-xl-12 col-lg-12 col-md-12 box-col-12">
                <div class="card order-card">
                  <div class="card-body pt-0">
                    <div class="table-responsive theme-scrollbar">
                      <table class="table table-bordernone">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Name</th>
                            {{-- <th>Province</th> --}}
                            <th>Status</th>
                            {{-- <th>Created at</th> --}}
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            ?>
                            @forelse ($cities as $v_city)
                            <tr>
                                <td>{{ $counter }}</td>
                                <td>{{ $v_city['city']->name }}</td>
                                {{-- <td>
                                    @if(!empty($v_city['province']))
                                    {{ $v_city['province']->name }}
                                    @endif
                                </td> --}}
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
                            @empty
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <img src="{{ asset('public/Empty-amico.svg') }}" class="img-fluid"
                                                        width="300" style="margin: 0 auto; display: block;">
                                                    <p class="mt-3 text-muted">No cities found.</p>
                                                </td>
                                            </tr>
                        @endforelse
                            
                        </tbody>
                      </table>
                    </div>
                        {{ $cities->withQueryString()->links('vendor.pagination.courier') }}
                  </div>
                </div>
              </div>


            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="form-group-2">
                                <form>
                                    <div class="row">
                                        <div class="col-md-11 col-sm-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search" id="search"
                                                    placeholder=" City" aria-label="" aria-describedby="basic-addon1">
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
            <div class="col-xl-12 col-lg-12 col-md-12 box-col-12">
                <div class="card order-card">
                  <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                            <p class="square-after f-w-600  dropdown-toggle show" type="button" id="btnGroupDrop1"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Select Action<i
                                    class="fa fa-circle"></i></p>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" bis_skin_checked="1"
                                style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(0px, -44px, 0px);"
                                data-popper-placement="top-start" data-popper-reference-hidden="">

                                <a type="button" class="dropdown-item" id="Assigned">Assigned</a>
                            </div>
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
                            <th>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="selectall custom-control-input" id="chkCheckAll" required>
                                    <label class="custom-control-label" for="chkCheckAll"></label>
                                </div>
                            </th>
                            <th>Name</th>
                            {{-- <th>Province</th> --}}
                            <th>Country</th>
                            <th>Status</th>
                            {{-- <th>Created at</th> --}}
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            ?>
                            @foreach ($city as $v_city)
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="ids" class="custom-control-input checkBoxClass" value="{{ $v_city->id }}" id="pid-{{ $counter }}">
                                        <label class="custom-control-label" for="pid-{{ $counter }}"></label>
                                    </div>
                                </td>
                                <td>{{ $v_city->name }}</td>
                                {{-- <td>
                                    @if(!empty($v_city['province']))
                                    {{ $v_city['province']->name }}
                                    @endif
                                </td> --}}
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
                            </tr>
                            <?php $counter++; ?>
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                   
                        {{ $city->withQueryString()->links('vendor.pagination.courier') }}
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
        <script>
            $(document).ready(function() {

                $(function(e) {
                    $('#savecity').click(function(e) {
                        var country = $('#country').val();
                        var city = $('#city').val();
                        var province = $('#province').val();
                        if (confirm("Are you sure, you want Assigned this Cities to warehouse")) {
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('cities.store') }}',
                                cache: false,
                                data: {
                                    country: country,
                                    city: city,
                                    province: province,
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
                        }
                    });
                });

                $(function(e) {
                    $('#updatecity').click(function(e) {
                        var country = $('#update_id').val();
                        var city = $('#update_city').val();
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('cities.update') }}',
                            cache: false,
                            data: {
                                country: country,
                                city: city,
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

                        });
                    });
                });
            });

            $(document).ready(function() {
                $("#chkCheckAll").click(function() {
                    $(".checkBoxClass").prop('checked', $(this).prop('checked'));
                });
                $("#Assigned").click(function() {
                    var id = {{$id}};
                    var allids = [];
                    $("input:checkbox[name=ids]:checked").each(function() {
                        allids.push($(this).val());
                    });
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('warehouses.assigned') }}',
                        cache: false,
                        data: {
                            id: id,
                            cities : allids,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.',
                                    'City Has been Assigned Success!', {
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
        @endsection
    @endsection
