@extends('backend.layouts.app')
@section('content')
    <style>
        .hiddenRow {
            padding: 0 !important;
        }
    </style>
    @if (Auth::user()->id_role != '3')
        <style>
            .multi {
                display: none;
            }
        </style>
    @endif
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="page-wrapper">
                <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-8 align-self-center ">
                            <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                    class="text-muted fw-light">Dashboard /</span> Sourcings&nbsp;

                            </h4>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->


                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <!-- Column -->
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-10 col-sm-12">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="search" id=""
                                                        placeholder="Ref ,  Phone , Price" aria-label=""
                                                        aria-describedby="basic-addon1">
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-sm-12">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit">Search</button>
                                                </div>
                                            </div>
                                            <div class="col-md-1 col-sm-12">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button"
                                                        onclick="toggleText()">Multi</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="form-group multi mt-3" id="multi">
                                    <form>
                                        {{-- <div class="row">
                                            <div class="col-md-3 col-sm-12 m-b-20">
                                                <input type="text" class="form-control" id="search_ref" name="ref" placeholder="Ref">
                                            </div>
                                            <div class="col-md-3 col-sm-12 m-b-20">
                                                <input type="text" class="form-control" name="customer" placeholder="Customer Name">
                                            </div>
                                            <div class="col-md-3 col-sm-12 m-b-20">
                                                <input type="text" class="form-control" name="phone1" placeholder="Phone ">
                                            </div>
                                        </div> --}}
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12 m-b-20">
                                                <label>Status Confirmation</label>
                                                <select class="form-control" name="confirmation"
                                                    style="width: 100%;height: 36px;">
                                                    <option value="">Status Confirmation</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="confirmed">Confirmed</option>
                                                    <option value="canceled">Canceled</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-12 m-b-20">
                                                <label>Status Shipping</label>
                                                <select class="form-control" name="livraison"
                                                    style="width: 100%;height: 36px;">
                                                    <option value=" ">Status Livraison</option>
                                                    <option value="pendinf">Pending</option>
                                                    <option value="processing">Processing</option>
                                                    <option value="packing">Packing</option>
                                                    <option value="shipped">Shipped</option>
                                                    <option value="delivered">Delivered</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-12 m-b-20">
                                                <label>Status Payment</label>
                                                <select class="form-control" name="payment"
                                                    style="width: 100%;height: 36px;">
                                                    <option value=" ">Status Payment</option>
                                                    <option value="unpaid">unpaid</option>
                                                    <option value="paid">Paid</option>
                                                </select>
                                            </div>
                                            <div class="col-3 align-self-center">
                                                <label>Date Range</label>
                                                <div class='input-group mb-3'>
                                                                             
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="date"
                                                    placeholder="YYYY-MM-DD to YYYY-MM-DD"
                                                    id="flatpickr-range" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            <span class="ti ti-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-1 align-self-center">
                                                <div class="form-group mb-0">
                                                    <button type="submit"
                                                        class="btn btn-primary waves-effect btn-rounded m-t-10 mb-2 "
                                                        style="width:100%">Search</button>
                                                </div>
                                            </div>
                                            <div class="col-1 align-self-center">
                                                <div class="form-group mb-0">
                                                    <a href="{{ route('leads.index') }}"
                                                        class="btn btn-primary waves-effect btn-rounded m-t-10 mb-2 "
                                                        style="width:100%">Reset</a>
                                                </div>
                                            </div>
                                            <div class="col-1 align-self-center">
                                                <div class="form-group mb-0">
                                                    <button id="exportss2"
                                                        class="btn btn-primary btn-rounded m-t-10 mb-2 ">Export</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row mt-4">
                    <div class="col-12">
                        <!-- Column -->
                        <div class="card">
                            <div class="card-body">
                                <!-- Add Contact Popup Model -->
                                <div id="StatusLeads" class="modal fade in" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">List History</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <from class="form-horizontal form-material">
                                                    <div class="table-responsive">
                                                        <table id="demo-foo-addrow"
                                                            class="table m-t-30 table-hover contact-list"
                                                            data-paging="true" data-paging-size="7">
                                                            <thead>
                                                                <tr>
                                                                    <th>User</th>
                                                                    <th>Date</th>
                                                                    <th>Status</th>
                                                                    <th>Date Action</th>
                                                                    <th>Comment</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="" id="history">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </from>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div class="table-responsive mt-4">
                                    <table id=""
                                        class="table table-bordered table-striped table-hover contact-list"
                                        data-paging="true" data-paging-size="7">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="selectall custom-control-input"
                                                            id="chkCheckAll" required>
                                                        <label class="custom-control-label" for="chkCheckAll"></label>
                                                    </div>
                                                </th>
                                                <th>Ref</th>
                                                <th>SELLER</th>
                                                <th>PRODUCT NAME</th>
                                                <th>LINK</th>
                                                <th>QUANTITY</th>
                                                <th>SHIPPING METHOD</th>
                                                <th>Status Confirmation</th>
                                                <th>Status Payment</th>
                                                <th>Status Livrison</th>
                                                <th>CREATED AT</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="alldata">
                                            <?php
                                            $counter = 1;
                                            ?>
                                            @foreach ($sourcings as $v_sourcing)
                                                <tr class="accordion-toggle data-item" data-id="{{ $v_sourcing->id }}">
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="ids"
                                                                class="custom-control-input checkBoxClass"
                                                                value="{{ $v_sourcing->id }}"
                                                                id="pid-{{ $counter }}">
                                                            <label class="custom-control-label"
                                                                for="pid-{{ $counter }}"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        #{{ $v_sourcing->ref }}
                                                    </td>
                                                    <td>
                                                        {{ $v_sourcing['seller']->name }}
                                                    </td>
                                                    <td>{{ $v_sourcing->product_name }}</td>
                                                    <td><a href="{{ $v_sourcing->link }}" target="_blank">Open
                                                            Link</a></td>
                                                    <td>{{ $v_sourcing->quantity }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-warning">{{ $v_sourcing->method_shipping }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($v_sourcing->status_confirmation == 'pending')
                                                            <form class="myform" data-id="{{ $v_sourcing->id }}">
                                                                <select class="form-control statu_con"
                                                                    id="statu_con{{ $v_sourcing->id }}"
                                                                    data-placeholder="Select a option" name="statu_con">
                                                                    <option value="pending"
                                                                        {{ $v_sourcing->status_confirmation == 'pending' ? 'selected' : '' }}>
                                                                        Pending</option>
                                                                    <option value="confirmed"
                                                                        {{ $v_sourcing->status_confirmation == 'confirmed' ? 'selected' : '' }}>
                                                                        Confirmed</option>
                                                                    <option value="canceled"
                                                                        {{ $v_sourcing->status_confirmation == 'canceled' ? 'selected' : '' }}>
                                                                        Canceled</option>
                                                                </select>
                                                                <input type="hidden" class="id_lead" id="id_lead"
                                                                    data-id="{{ $v_sourcing->id }}"
                                                                    value="{{ $v_sourcing->id }}" />
                                                            </form>
                                                        @else
                                                            <span
                                                                class="badge bg-warning">{{ $v_sourcing->status_confirmation }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-warning">{{ $v_sourcing->status_payment }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($v_sourcing->status_confirmation == 'confirmed')
                                                            <form class="myform2" data-id="{{ $v_sourcing->id }}">
                                                                <select class="form-control statu_liv"
                                                                    id="statu_liv{{ $v_sourcing->id }}"
                                                                    data-placeholder="Select a option" name="statu_liv">
                                                                    <option value="pending"
                                                                        {{ $v_sourcing->status_livrison == 'pending' ? 'selected' : '' }}>
                                                                        Pending</option>
                                                                    <option value="proccessing"
                                                                        {{ $v_sourcing->status_livrison == 'processing' ? 'selected' : '' }}>
                                                                        Processing</option>
                                                                    <option value="packing"
                                                                        {{ $v_sourcing->status_livrison == 'packing' ? 'selected' : '' }}>
                                                                        Packing</option>
                                                                    <option value="shipped"
                                                                        {{ $v_sourcing->status_livrison == 'shipped' ? 'selected' : '' }}>
                                                                        Shipped</option>
                                                                    <option value="delivered"
                                                                        {{ $v_sourcing->status_livrison == 'delivered' ? 'selected' : '' }}>
                                                                        Delivered</option>
                                                                </select>
                                                                <input type="hidden" class="id_lead" id="id_lead"
                                                                    data-id="{{ $v_sourcing->id }}"
                                                                    value="{{ $v_sourcing->id }}" />
                                                            </form>
                                                        @else
                                                            <span
                                                                class="badge bg-warning">{{ $v_sourcing->status_livrison }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $v_sourcing->created_at }}</td>
                                                    <td>
                                                       
                                                        <div class="dropdown">
                                                            <button class="btn p-0" type="button" id="earningReports"
                                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end"
                                                                aria-labelledby="earningReports">
                                                                <a class="dropdown-item" href="{{ route('sourcing.edit', $v_sourcing->id) }}">Details</a>
                                                                @if($v_sourcing->status_confirmation == "canceled")
                                                                <a class="dropdown-item" href="{{ route('sourcing.delete', $v_sourcing->id) }}"> Deleted</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php $counter = $counter + 1; ?>
                                            @endforeach
                                        </tbody>
                                        <tbody id="contentdata" class="datasearch"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <footer class="content-footer footer bg-footer-theme">
        <div class="container-xxl">
            <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
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
    <!-- Add reclamation Popup Model -->
    <div id="confirmedsourcing" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="max-width:1200px">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Confirmed Request</h4>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> --}}
                </div>
                <from class="">
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 m-b-20">
                                                <input type="hidden" class="form-control" id="request_id" placeholder="N Lead">
                                            </div>
                                            <div class="col-md-12 col-sm-12 m-b-20">
                                                <input type="number" step="any" class="form-control" id="unite_price" placeholder="unite price">
                                            </div>
                                            <div class="col-md-12 col-sm-12 m-b-20 mt-2">
                                                <input type="number" step="any" class="form-control" id="tota_price" placeholder="ADD SHIPPING PRICE AND TOTAL">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info waves-effect updatestatus"
                            id="updatestatus">Save</button>
                        <button type="button" class="btn btn-primary waves-effect"
                            data-bs-dismiss="modal">Cancel</button>
                    </div>
                </from>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        $("#search").keyup(function() {
            $value = $(this).val();
            if ($value) {
                $('.alldata').hide();
                $('.datasearch').show();
            } else {
                $('.alldata').show();
                $('.datasearch').hide();
            }
            $.ajax({
                type: 'get',
                url: '{{ route('leads.search') }}',
                data: {
                    'search': $value,
                },
                success: function(data) {
                    $('#contentdata').html(data);
                }
            });
        });
        $(document).ready(function() {
            $("#chkCheckAll").click(function() {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });
            $('#deletedselected').click(function(e) {
                e.preventDefault();
                var allids = [];
                $("input:checkbox[name=ids]:checked").each(function() {
                    allids.push($(this).val());
                });
                ///alert(allids);
                if (confirm("Are you sure, you want to Deleted List Leads?")) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('leads.delete') }}',
                        cache: false,
                        data: {
                            ids: allids,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.', 'Lead Has been Deleted Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                            }
                            location.reload();
                        }
                    });
                } else {
                    alert('Whoops Something went wrong!!');
                }
            });
            $(function(e) {
                $('#savelead').click(function(e) {
                    var idproduct = $('#id_product').val();
                    var namecustomer = $('#name_customer').val();
                    var quantity = $('#quantity').val();
                    var mobile = $('#mobile').val();
                    var mobile2 = $('#mobile2').val();
                    var country = $('#id_country').val();
                    var cityid = $('#id_city').val();
                    var zoneid = $('#id_zone').val();
                    var address = $('#address').val();
                    var total = $('#total').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('leads.store') }}',
                        cache: false,
                        data: {
                            id: idproduct,
                            namecustomer: namecustomer,
                            quantity: quantity,
                            mobile: mobile,
                            mobile2: mobile2,
                            country: country,
                            cityid: cityid,
                            zoneid: zoneid,
                            address: address,
                            total: total,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.',
                                    'Upsell Has been Addess Success!', {
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
            // Department Change
            $('#id_country').change(function() {

                // Department id
                var id = $(this).val();

                // Empty the dropdown
                $('#id_city').find('option').not(':first').remove();
                //console.log(id);
                // AJAX request 
                $.ajax({
                    url: 'city/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {

                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].name;

                                var option = "<option value='" + id + "'>" + name + "</option>";

                                $("#id_city").append(option);
                            }
                        }

                    }
                });
            });
            $('#id_cit').change(function() {

                // Department id
                var id = $(this).val();

                // Empty the dropdown
                $('#id_zone').find('option').not(':first').remove();
                //console.log(id);
                // AJAX request 
                $.ajax({
                    url: 'zone/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {

                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].name;

                                var option = "<option value='" + id + "'>" + name + "</option>";

                                $("#id_zone").append(option);
                            }
                        }

                    }
                });
            });
            // Department Change
            $('#id_cityy').change(function() {

                // Department id
                var id = $(this).val();

                // Empty the dropdown
                $('#id_zonee').find('option').not(':first').remove();
                //console.log(id);
                // AJAX request 
                $.ajax({
                    url: 'zone/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {

                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].name;

                                var option = "<option value='" + id + "'>" + name + "</option>";

                                $("#id_zonee").append(option);
                            }
                        }

                    }
                });
            });
            $('#id_city').change(function() {

                // Department id
                var id = $(this).val();

                // Empty the dropdown
                $('#id_zone').find('option').not(':first').remove();
                //console.log(id);
                // AJAX request 
                $.ajax({
                    url: 'zone/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {

                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].name;

                                var option = "<option value='" + id + "'>" + name + "</option>";

                                $("#id_zone").append(option);
                            }
                        }

                    }
                });
            });
            $('body').on('change', '.myform', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var statuu = $('#request_id').val(id);
                var status = $('#statu_con'+id).val();
                if (status == "canceled") {
                    $('#lead_id').val(id);
                    var status = "canceled";
                }
                if(status == "confirmed"){
                    $('#leads_id').val(id);
                    $('#confirmedsourcing').modal('show');
                }
                    $.ajax({
                        type: "POST",
                        url: '{{ route('sourcing.statuscon') }}',
                        cache: false,
                        data: {
                            id: id,
                            status: status,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.',
                                    'Sourcing Has been Cancelled Success!', {
                                        "showMethod": "slideDown",
                                        "hideMethod": "slideUp",
                                        timeOut: 2000
                                    });
                            }
                        }
                    });
            });
            $('body').on('change', '.myform2', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var statuu = "#statu_liv" + id;
                var status = $(statuu).val();
                $.ajax({
                    type: "POST",
                    url: '{{ route('sourcing.statusliv') }}',
                    cache: false,
                    data: {
                        id: id,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.',
                                'Sourcing Has been Change Status Shipping Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                        }
                    }
                });
            });
            $('#updatestatus').click(function(e) {
                var id = $('#request_id').val();
                var price = $('#unite_price').val();
                var total = $('#tota_price').val();
                var status = "confirmed";
                $.ajax({
                    type: "POST",
                    url: '{{ route('sourcing.statuscon') }}',
                    cache: false,
                    data: {
                        id: id,
                        price: price,
                        total: total,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.',
                                'Sourcing Has been Confirmed Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                            location.reload();
                        }
                    }
                });
            })
        });

        //Export
        $(function(e) {
            $("#chkCheckAll").click(function() {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });
            $('#exportss').click(function(e) {
                e.preventDefault();
                var allids = [];
                $("input:checkbox[name=ids]:checked").each(function() {
                    allids.push($(this).val());
                });
                if (allids != '') {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('leads.export') }}',
                        cache: false,
                        data: {
                            ids: allids,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response, leads) {
                            $.each(allids, function(key, val, leads) {
                                var a = JSON.stringify(allids);
                                window.location = ('leads/export-download/' + a);
                            });
                        }
                    });
                } else {
                    toastr.warning('Opss.', 'Please Selected Leads!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                }
            });
            //export date
            $('#exportss2').click(function(e) {
                e.preventDefault();
                var allids = [];
                $("input:checkbox[name=ids]:checked").each(function() {
                    allids.push($(this).val());
                });
                var date = $('#timeseconds').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('leads.export2') }}',
                    cache: false,
                    data: {
                        date: date,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response, leads) {
                        $.each(response, function(key, val, leads) {
                            var a = response;
                            window.location = ('leads/export-download2/' + a);
                        });
                    }
                });
            });

        });

        $('#saveupsell').click(function(e) {
            e.preventDefault();
            var id = $('#lead_upsell').val();
            var product = $('#product_upsell').val();
            var quantity = $('#upsell_quantity').val();
            var price = $('#price_upsell').val();
            //console.log(agent);
            $.ajax({
                type: "POST",
                url: '{{ route('leads.upsellstore') }}',
                cache: false,
                data: {
                    id: id,
                    product: product,
                    quantity: quantity,
                    price: price,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success == true) {
                        toastr.success('Good Job.', 'Upsell Has been Added Success!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                }
            });
        });

        ///list lead search



        $('#searchdetai').click(function(e) {
            e.preventDefault();
            var n_lead = $('#search_2').val();
            $('#listlead').modal('show');
            //console.log(agent);
            $.ajax({
                type: "get",
                url: '{{ route('leads.leadsearch') }}',
                data: {
                    n_lead: n_lead,
                },
                success: function(data) {
                    $('#listleadss').html(data);
                }
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


    <script>
        document.getElementById('pagination').onchange = function() {
            if (window.location.href == "https://www.admin.ecomfulfilment.eu/leads") {
                //alert(window.location.href);
                window.location = window.location.href + "?&items=" + this.value;
            } else {
                window.location = window.location.href + "&items=" + this.value;
            }

        };
    </script>
@endsection
