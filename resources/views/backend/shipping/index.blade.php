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
                    <div class="col-9 align-self-center ">
                        <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                class="text-muted fw-light">Dashboard /</span> Shipping Countries &nbsp;

                        </h4>
                    </div>
                    <div class="col-3 d-flex justify-content-end align-self-center">
                        <div class="form-group mb-0 text-right">
                            <div class="form-group mb-0 text-right">
                                <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#add-country">Add New Countrie</button>
                            </div>

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
                                                        placeholder="Name Country" aria-label=""
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
                                <!-- Add Contact Popup Model -->
                                <div id="add-country" class="modal fade in" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Add New Country Shipping</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <from class="form-horizontal form-material">
                                                    <div class="form-group">
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <input type="text" class="form-control" id="country"
                                                                placeholder="Country">
                                                        </div>
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <select class="form-control" id="shipping_type">
                                                                <option>Select Expidition Mode</option>
                                                                <option value="AIR">AIR</option>
                                                                <option value="SEA">SEA</option>
                                                                <option value="ROAD">ROAD</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <input type="text" class="form-control" id="dayli"
                                                                placeholder="Delay">
                                                        </div>
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <textarea class="form-control" id="warehouse" placeholder="Warehouse"></textarea>
                                                        </div>
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <input type="text" class="form-control" id="contact"
                                                                placeholder="contact">
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
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                

                                <div class="table-responsive">
                                    <table id="demo-foo-addrow" class="table table-bordered m-t-30 table-hover contact-list"
                                        data-paging="true" data-paging-size="7">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Shipping Type</th>
                                                <th>Delay</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            ?>
                                            @foreach ($countries as $v_country)
                                                <tr>
                                                    <td>{{ $counter }}</td>
                                                    <td>{{ $v_country->name }}</td>
                                                    <td>{{ $v_country->type_shippng }}</td>
                                                    <td>{{ $v_country->dayli }}</td>
                                                    <td>{{ $v_country->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        <a data-id="{{ $v_country->id }}"
                                                            class="text-inverse pr-2 detailcountry" data-toggle="tooltip"
                                                            title="Edit"><i class="ti ti-highlight"></i></a>
                                                        <a data-id="{{ $v_country->id }}" class="text-inverse deleted"
                                                            title="Delete" data-toggle="tooltip"><i
                                                                class="ti ti-trash"></i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $counter++;
                                                ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $countries->withQueryString()->links('vendor.pagination.courier') }}
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
            
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
        </div>
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
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->

    <div id="editcountry" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Update Country</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <from class="form-horizontal form-material">
                        <div class="form-group">
                            <div class="col-md-12 m-b-20 mt-4">
                                <input type="hidden" class="form-control" id="dataid">
                                <input type="text" class="form-control" id="edit_country" placeholder="Country">
                            </div>
                            <div class="col-md-12 m-b-20 mt-4">
                                <select class="form-control" id="edit_shipping_type">
                                    <option value=" ">Select Expidition Mode</option>
                                    <option value="AIR">AIR</option>
                                    <option value="SEA">SEA</option>
                                    <option value="ROAD">ROAD</option>
                                </select>
                            </div>
                            <div class="col-md-12 m-b-20 mt-4">
                                <input type="text" class="form-control" id="edit_dayli" placeholder="Delay">
                            </div>
                            <div class="col-md-12 m-b-20 mt-4">
                                <textarea class="form-control" id="edit_warehouse" placeholder="Warehouse"></textarea>
                            </div>
                            <div class="col-md-12 m-b-20 mt-4">
                                <input type="text" class="form-control" id="edit_contact" placeholder="contact">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {

            $(function(e) {
                $('#savecountry').click(function(e) {
                    var country = $('#country').val();
                    var dayli = $('#dayli').val();
                    var type = $('#shipping_type').val();
                    var warehouse = $('#warehouse').val();
                    var contact = $('#contact').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('shipping.store') }}',
                        cache: false,
                        data: {
                            country: country,
                            dayli: dayli,
                            type: type,
                            warehouse: warehouse,
                            contact: contact,
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
                    var id = $('#dataid').val();
                    var country = $('#edit_country').val();
                    var dayli = $('#edit_dayli').val();
                    var type = $('#edit_shipping_type').val();
                    var warehouse = $('#edit_warehouse').val();
                    var contact = $('#edit_contact').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('shipping.update') }}',
                        cache: false,
                        data: {
                            id: id,
                            country: country,
                            dayli: dayli,
                            type: type,
                            warehouse: warehouse,
                            contact: contact,
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
                                location.reload();
                            }
                            if (response.remplier == false) {
                                toastr.warning('Opps.', 'Pleas Select Type!', {
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
                $('.deleted').click(function(e) {
                    var id = $(this).data('id');
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('shipping.delete') }}',
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
                    $.get("{{ route('shipping.index') }}" + '/' + id + '/details', function(data) {
                        $('#editcountry').modal('show');

                        $('#dataid').val(data.id);
                        $('#edit_country').val(data.name);
                        $('#edit_dayli').val(data.dayli);
                        $('#edit_warehouse').val(data.warehouse);
                        $('#edit_contact').val(data.contact);

                    });
                });
            });
        });
    </script>
@endsection
