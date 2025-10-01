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
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 align-self-center ">
                        <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                class="text-muted fw-light">Dashboard /</span> Requests &nbsp;

                        </h4>
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
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search" id="search"
                                                    placeholder="Name Country, Name Product, Name User" aria-label=""
                                                    aria-describedby="basic-addon1">
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
            <div id="confirm" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"></h4>
                            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="text-center mb-4">
                            <h3 class="mb-2">Confirm request</h3>
                            <p class="text-muted">Are you sure you want to accept this request ?</p>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <input type="text" hidden id="ReqId">
                            <button type="button" id="confirming"
                                class="btn btn-primary btn-rounded waves-effect waves-light ">
                                Confirm</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div id="inactive" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"></h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="text-center mb-4">
                            <h3 class="mb-2">Confirm request</h3>
                            <p class="text-muted">Are you sure you want to accept this request ?</p>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <input type="text" hidden id="RequestId">
                            <button type="button" id="inactiving"
                                class="btn btn-primary btn-rounded waves-effect waves-light ">
                                Confirm</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-subtitle"></h6>


                            <div class="table-responsive">
                                <table id="demo-foo-addrow" class="table table-bordered m-t-5 table-hover contact-list mb-4"
                                    data-paging="true" data-paging-size="7">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>country</th>
                                            <th>user</th>
                                            <th>product</th>
                                            <th>ref</th>
                                            <th>status</th>
                                            <th>Created at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $counter = 1;
                                        ?>
                                        @foreach ($requests as $request)
                                            <tr>
                                                <td>{{ $counter }}</td>
                                                <td>{{ $request->country->name }}</td>
                                                <td>{{ $request->user->name }}</td>
                                                <td>{{ $request->offer->name ?? 'not found' }}</td>
                                                <td>{{ $request->ref }}</td>
                                                @if ($request->is_active == 1)
                                                    <td><span class="badge bg-success">active</span></td>
                                                @else
                                                    <td><span class="badge bg-danger">inactive</span></td>
                                                @endif

                                                <td>{{ $request->created_at }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="ti ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu animated slideInUp"
                                                            x-placement="bottom-start"
                                                            style="position: absolute; will-change: transform; transform: translate3d(0px, 35px, 0px);margin-left: -60px!important;">
                                                            <button @if ($request->is_active == 1) hidden @endif class="dropdown-item confirmed"
                                                                data-id="{{ $request->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#confirm"><i class="ti ti-edit-circle"></i>
                                                                Set Active</button>
                                                            <button @if ($request->is_active == 0) hidden @endif class="dropdown-item inactive"
                                                                data-id="{{ $request->id }}" data-bs-toggle="modal"
                                                                data-bs-target="#inactive"><i class="ti ti-edit-circle"></i>
                                                                Set Inactive</button>
                                                        </div>

                                                    </div>
                                                    {{-- <a @if ($request->is_active == 1) hidden @endif data-id="{{ $request->id }}" class="text-inverse pr-2 confirmed "
                                                        data-bs-toggle="modal" data-bs-target="#confirm"><i
                                                            class="ti ti-edit-circle"></i></a> --}}


                                                    <!--<a data-id="{{ $request->id }}" class="text-inverse deleted" title="Delete" data-toggle="tooltip"><i class="ti-trash"></i></a>-->
                                                </td>
                                            </tr>
                                            <?php
                                            $counter++;
                                            ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $requests->withQueryString()->links('vendor.pagination.courier') }}
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
        <!-- Footer -->
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
        <!-- / Footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        //Inactive
        $(function(e) {
            $('.inactive').on('click', function(e) {
                var request = $(this).data('id');
                // console.log(request);
                $('#RequestId').val(request)
            });


            $('#inactiving').on('click', function(e) {
                var produit = $('#RequestId').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('requests.inactive') }}',
                    cache: false,
                    data: {
                        id: produit,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job Product.',
                                'Request Has Been Confirmed!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                            location.reload();
                        }
                        if (response.error == false) {
                            toastr.error('Good Job Product.', "Somethig went's wrong!", {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                    }
                });
            });
        });

        //confirm
        $(function(e) {
            $('.confirmed').on('click', function(e) {
                var request = $(this).data('id');
                // console.log(request);
                $('#ReqId').val(request)
            });


            $('#confirming').on('click', function(e) {
                var produit = $('#ReqId').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('requests.confirm') }}',
                    cache: false,
                    data: {
                        id: produit,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job Product.',
                                'Request Has Been Confirmed!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                            location.reload();
                        }
                        if (response.error == false) {
                            toastr.error('Good Job Product.', "Somethig went's wrong!", {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                    }
                });
            });
        });
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
    <style>
        .badge-success {
            background-color: rgb(104, 255, 104);
            color: rgb(15, 104, 12);
            padding: 4px 8px;
            text-align: center;
            border-radius: 20px;
        }

        .badge-alert {
            background-color: rgb(255, 104, 104);
            color: rgb(128, 37, 14);
            padding: 4px 10px;
            text-align: center;
            border-radius: 20px;
        }
    </style>
@endsection
