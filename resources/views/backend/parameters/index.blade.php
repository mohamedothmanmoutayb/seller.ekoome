@extends('backend.layouts.app')
@section('content')
    <style>
        .hiddenRow {
            padding: 0 !important;
        }

        .select2 {
            width: 100% !important;
        }

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

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .row.operationbtn button,
        .row.operationbtn a {
            text-transform: uppercase !important;
        }
    </style>
    <!-- ============================================================== -->
        <div class="container-xxl flex-grow-1 container-p-y">
           
                <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-8 align-self-center ">
                            <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                    class="text-muted fw-light">Dashboard /</span> Parameters&nbsp;

                            </h4>
                        </div>
                    </div>
                </div>
               
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <form>
                                <div class="card-body">
                                    <div class="d-flex no-block align-items-center">
                                        <h4 class="card-title">Parameters Invoice</h4>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="emp1" class="control-label col-form-label">Company
                                                    Name</label>
                                                <input type="hidden" id="id"
                                                    @if (!empty($parameter->id)) value="{{ $parameter->id }}" @endif />
                                                <input type="text" class="form-control" id="name_customer"
                                                    @if (!empty($parameter->app_name)) value="{{ $parameter->app_name }}" @endif
                                                    placeholder="Name Customer">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="datec" class="control-label col-form-label">Vat
                                                    number</label>
                                                <input type="text" class="form-control" id="vat"
                                                    @if (!empty($parameter->vat_number)) value="{{ $parameter->vat_number }}" @endif
                                                    placeholder="Vat">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="sign" class="control-label col-form-label">Email</label>
                                                <input type="text" class="form-control" id="email"
                                                    @if (!empty($parameter->email)) value="{{ $parameter->email }}" @endif
                                                    placeholder="Email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="sign" class="control-label col-form-label">ZipCod</label>
                                                <input type="text" class="form-control" id="zipcod"
                                                    @if (!empty($parameter->zipcod)) value="{{ $parameter->zipcod }}" @endif
                                                    placeholder="Zipcod">
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="suname" class="control-label col-form-label">Country</label>
                                                <input class="form-control" id="country"
                                                    @if (!empty($parameter->country)) value="{{ $parameter->country }}" @endif />
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="suname" class="control-label col-form-label">City</label>
                                                <input class="form-control" id="city"
                                                    @if (!empty($parameter->city)) value="{{ $parameter->city }}" @endif />
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label col-form-label">Address</label>
                                                <textarea type="text" class="form-control" id="address"
                                                    @if (!empty($parameter->address)) value="{{ $parameter->address }}" @endif placeholder="Address"> @if (!empty($parameter->address))
                                                    {!! $parameter->address !!}
                                                    @endif
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mt-3">
                                        <h3>Fees By Lead</h3>
                                        <div class="col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="suname" class="control-label col-form-label">Lead Entred</label>
                                                <input class="form-control" id="entred"
                                                    @if (!empty($parameter->entred_lead)) value="{{ $parameter->entred_lead }}" @endif />
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="suname" class="control-label col-form-label">Lead Confirmed</label>
                                                <input class="form-control" id="confirmed"
                                                    @if (!empty($parameter->confirmed)) value="{{ $parameter->confirmed }}" @endif />
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label for="suname" class="control-label col-form-label">Order Fulfilment</label>
                                                <input class="form-control" id="fulfilment"
                                                    @if (!empty($parameter->fulfilment)) value="{{ $parameter->fulfilment }}" @endif />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="card-body">
                                    <div class="action-form">
                                        <div class="form-group mb-0 text-center">
                                            @if (empty($parameter->id))
                                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                                    id="save">Save</button>
                                            @else
                                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                                    id="update">Update</button>
                                            @endif
                                            <button type="button"
                                                class="btn btn-dark waves-effect waves-light">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                
           
        </div>
        <div id="overlay" style="display:none;">
            <div class="spinner"></div>
            <br />
            Loading...
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <script type="text/javascript">
            $(function(e) {
                $('#save').click(function(e) {
                    
                    var seller = $('#id_seller').val();
                    var name = $('#name_customer').val();
                    var vat = $('#vat').val();
                    var email = $('#email').val();
                    var zipcod = $('#zipcod').val();
                    var country = $('#country').val();
                    var city = $('#city').val();
                    var address = $('#address').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('parameters.store') }}',
                        cache: false,
                        data: {
                            seller: seller,
                            name: name,
                            vat: vat,
                            email: email,
                            zipcod: zipcod,
                            country: country,
                            city: city,
                            address: address,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.', 'Parameter Has been Addess Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                            }
                        }
                    });
                });
                $('#update').click(function(e) {
                    var id = $('#id').val();
                    var name = $('#name_customer').val();
                    var vat = $('#vat').val();
                    var email = $('#email').val();
                    var zipcod = $('#zipcod').val();
                    var country = $('#country').val();
                    var city = $('#city').val();
                    var address = $('#address').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('parameters.update') }}',
                        cache: false,
                        data: {
                            id: id,
                            name: name,
                            vat: vat,
                            email: email,
                            zipcod: zipcod,
                            country: country,
                            city: city,
                            address: address,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.', 'Parameter Has been Addess Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                            }
                        }
                    });
                });
            });
        </script>
    @endsection
