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

                <div class="card card-body py-3">
                    <div class="row align-items-center">
                    <div class="col-12">
                         <div class="d-sm-flex align-items-center justify-space-between">
                         <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                        <i class="ti ti-arrow-left fs-5"></i> 
                    </a>
                    <div>
                        <h4 class="mb-4 mb-sm-0 card-title">Countries</h4>
                        <p class="mb-0 text-muted"> Manage country codes and currencies.</p>
                                    
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

                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="form-group-1 ">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-11 col-sm-12">
                                                <label for="Name_Country" style="margin-left: 8px; margin-bottom: 5px;">Country Name</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="search" id="search"
                                                        placeholder="Name Country" aria-label=""
                                                        aria-describedby="basic-addon1">
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
                        </div>
                    </div>
                </div>
                                <!-- Add Contact Popup Model -->
                                <div id="add-country" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="height:auto !important;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Add New Country</h4>
                                                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <from class="form-horizontal form-material">
                                                    <div class="form-group">
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <input type="text" class="form-control" id="country"
                                                                placeholder="Country">
                                                        </div>
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <input type="text" class="form-control" id="negative"
                                                                placeholder="Negative">
                                                        </div>
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <input type="text" class="form-control" id="currency"
                                                                placeholder="Currency">
                                                        </div>
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <input type="text" class="form-control" id="flage"
                                                                placeholder="Flag">
                                                        </div>
                                                    </div>
                                                </from>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary waves-effect"
                                                    id="savecountry">Save</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                <!-- ============================================================== -->
                <div class="col-xl-12 col-lg-12 col-md-12 box-col-7">
                  <div class="card order-card">
                    <div class="card-header pb-0">
                      <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                          <p class="square-after f-w-600">List Countries<i class="fa fa-circle"></i></p>
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
                                <th>Flag</th>
                                <th>Name</th>
                                <th>Phone Code</th>
                                <th>Currency</th>
                                <th>Created On</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $counter = 1; ?>
                            @foreach ($countries as $v_country)
                            <tr>
                                <td>{{ $counter }}</td>
                                <td><span class="flag-icon flag-icon-{{$v_country->flag}} f-30"> </span></td>
                                <td>{{ $v_country->name }}</td>
                                <td>{{ $v_country->negative }}</td>
                                <td>{{ $v_country->currency }}</td>
                                <td>{{ $v_country->created_at }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle show" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="icon-settings"></i></button>
                                        <div class="dropdown-menu" bis_skin_checked="1" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(184px, -325.203px, 0px);" data-popper-placement="top-start">                          
                                            <a class="dropdown-item detailcountry" data-id="{{ $v_country->id }}">Details</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php $counter++; ?>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->

                <div id="editcountry" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="height:auto !important;">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Update Country</h4>
                            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <from class="form-horizontal form-material">
                                    <div class="form-group">
                                        <div class="col-md-12 m-b-20 mt-4">
                                            <input type="text" class="form-control" id="update_name" placeholder="Country Name">
                                            <input type="hidden" class="form-control" id="country_id">
                                        </div>
                                        <div class="col-md-12 m-b-20 mt-4">
                                            <input type="text" class="form-control" id="update_negative" placeholder="Negative">
                                        </div>
                                        <div class="col-md-12 m-b-20 mt-4">
                                            <input type="text" class="form-control" id="update_currency" placeholder="Currency">
                                        </div>
                                        <div class="col-md-12 m-b-20 mt-4">
                                            <input type="text" class="form-control" id="update_flag" placeholder="Flag">
                                        </div>
                                    </div>
                                </from>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary waves-effect" id="edit-country">Save</button>
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
                $('#savecountry').click(function(e) {
                    var country = $('#country').val();
                    var negative = $('#negative').val();
                    var currency = $('#currency').val();
                    var flag = $('#flag').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('countries.store') }}',
                        cache: false,
                        data: {
                            country: country,
                            negative: negative,
                            currency: currency,
                            flag: flag,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.',
                                    'Country Has been Addess Success!', {
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
                $('#edit-country').click(function(e) {
                    var id = $('#country_id').val();
                    var name = $('#update_name').val();
                    var negative = $('#update_negative').val();
                    var currency = $('#update_currency').val();
                    var flag = $('#update_flag').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('countries.update') }}',
                        cache: false,
                        data: {
                            id: id,
                            name: name,
                            negative: negative,
                            currency: currency,
                            flag: flag,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.',
                                    'Country Has been Updated Success!', {
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
                        url: '{{ route('countries.delete') }}',
                        cache: false,
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.',
                                    'Country Has been Deleted Success!', {
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
                $('body').on('click', '.detailcountry', function(products) {
                    var id = $(this).data('id');
                    $.get("{{ route('countries.index') }}" + '/' + id + '/details', function(
                    data) {
                        $('#editcountry').modal('show');

                        $('#country_id').val(data.id);
                        $('#update_name').val(data.name);
                        $('#update_negative').val(data.negative);
                        $('#update_currency').val(data.currency);
                        $('#update_flag').val(data.flag);

                    });
                });
            });
        });
    </script>
    @endsection
@endsection
