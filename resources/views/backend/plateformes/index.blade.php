@extends('backend.layouts.app')
@section('content')
    <style>
        .platformes {
            height: 300px !important;
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
                        <h4 class="mb-4 mb-sm-0 card-title">Integrations Plateformes</h4>
                        <p class="mb-0 text-muted"> Sync your stores easily.</p>
                                    
                    </div>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex" href="{{ route('home') }}">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="product-wrapper-grid">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="card">
                    <div class="product-box">
                        <div class="product-img"><img class="img-fluid platformes"
                                src="{{ asset('public/plateformes/Shopify.jpg') }}" alt="">
                            <div class="product-hover">
                                <ul>
                                    <li><a href="{{ route('shopify.index') }}"><i class="icon-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-details text-center "><a href="{{ route('shopify.index') }}">
                                <h4>Shoppify</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="card">
                    <div class="product-box">
                        <div class="product-img"><img class="img-fluid platformes"
                                src="{{ asset('public/plateformes/lightfunnel.png') }}" alt="">
                            <div class="product-hover">
                                <ul>
                                    <li><a href="{{ route('lightfunnels.index') }}"><i class="icon-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-details text-center"><a href="{{ route('lightfunnels.index') }}">
                                <h4>Lightfunnels</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="card">
                    <div class="product-box">
                        <div class="product-img"><img class="img-fluid platformes"
                                src="{{ asset('public/plateformes/Lightfunnels-logo.png') }}" alt="">
                            <div class="product-hover">
                                <ul>
                                    <li><a
                                            href="https://app.lightfunnels.com/admin/oauth?client_id={{ env('LIGHTFUNNELS_CLIENT_ID') }}&redirect_uri={{ Request::root() }}/auth/redirect&scope=orders&state=123"><i
                                                class="icon-shopping-cart"></i></a></li>
                                    <li><a data-bs-toggle="modal" data-bs-target="#exampleModalCenter16"><i
                                                class="icon-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal fade" id="exampleModalCenter16">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="product-box row">
                                            <div class="product-img col-lg-6"><img class="img-fluid"
                                                    src="{asset('public/plateformes/Lightfunnels-logo.png')}}"
                                                    alt=""></div>
                                            <div class="col-lg-6 text-start">
                                                <div class="product-details"><a
                                                        href="https://app.lightfunnels.com/admin/oauth?client_id={{ env('LIGHTFUNNELS_CLIENT_ID') }}&redirect_uri={{ Request::root() }}/auth/redirect&scope=orders&state=123">
                                                        <h4>Shoppify </h4>
                                                    </a>
                                                    <div class="product-view">
                                                        <h6 class="f-w-600">Product Details</h6>
                                                        <p class="mb-0">Rock Paper Scissors Women Tank Top High
                                                            Neck Cotton Top Stylish Women Top..</p>
                                                    </div>
                                                    <div class="product-size">
                                                        <ul>
                                                            <li>
                                                                <button class="btn" type="button">M</button>
                                                            </li>
                                                            <li>
                                                                <button class="btn" type="button">L</button>
                                                            </li>
                                                            <li>
                                                                <button class="btn" type="button">Xl</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-qnty">
                                                        <h6 class="f-w-600">Quantity</h6>
                                                        <fieldset>
                                                            <div class="input-group">
                                                                <input class="touchspin text-center" type="text"
                                                                    value="5">
                                                            </div>
                                                        </fieldset>
                                                        <div class="addcart-btn"><a class="btn btn-primary me-2"
                                                                href="https://app.lightfunnels.com/admin/oauth?client_id={{ env('LIGHTFUNNELS_CLIENT_ID') }}&redirect_uri={{ Request::root() }}/auth/redirect&scope=orders&state=123">Add
                                                                to Cart </a><a class="btn btn-primary"
                                                                href="product-page.html">View Details</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn-close" type="button" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-details"><a
                                href="https://app.lightfunnels.com/admin/oauth?client_id={{ env('LIGHTFUNNELS_CLIENT_ID') }}&redirect_uri={{ Request::root() }}/auth/redirect&scope=orders&state=123">
                                <h4>Lightfunnels</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- ------------------------------------------------------------------------------------------------ --}}

            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="card">
                    <div class="product-box">
                        <div class="product-img"><img class="img-fluid platformes"
                                src="{{ asset('public/plateformes/youcann.png') }}" alt="">
                            <div class="product-hover">
                                <ul>
                                    <li><a href="{{ route('youcan.index') }}"><i class="icon-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-details text-center"><a href="{{ route('youcan.index') }}">
                                <h4>Youcan</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="card">
                    <div class="product-box">
                        <div class="product-img"><img class="img-fluid platformes"
                                src="{{ asset('public/plateformes/Logo-YouCan.png') }}" alt="">
                            <div class="product-hover">
                                <ul>
                                    <li><a
                                            href="https://seller-area.youcan.shop/admin/oauth/authorize?client_id={{ env('YOUCAN_CLIENT_ID') }}&redirect_uri={{ Request::root().'/callback'}}&response_type=code&scope[]=*"><i
                                                class="icon-shopping-cart"></i></a></li>
                                    <li><a data-bs-toggle="modal" data-bs-target="#exampleModalCenter16"><i
                                                class="icon-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="modal fade" id="exampleModalCenter16">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="product-box row">
                                            <div class="product-img col-lg-6"><img class="object-fit: none;"
                                                    src="{{asset('public/plateformes/youcan.png')}}"
                                                    alt=""></div>
                                            <div class="col-lg-6 text-start">
                                                <div class="product-details"><a
                                                        href="https://app.lightfunnels.com/admin/oauth?client_id={{ env('LIGHTFUNNELS_CLIENT_ID') }}&redirect_uri={{ Request::root() }}/auth/redirect&scope=orders&state=123">
                                                        <h4>Shoppify </h4>
                                                    </a>
                                                    <div class="product-view">
                                                        <h6 class="f-w-600">Product Details</h6>
                                                        <p class="mb-0">Rock Paper Scissors Women Tank Top High
                                                            Neck Cotton Top Stylish Women Top..</p>
                                                    </div>
                                                    <div class="product-size">
                                                        <ul>
                                                            <li>
                                                                <button class="btn" type="button">M</button>
                                                            </li>
                                                            <li>
                                                                <button class="btn" type="button">L</button>
                                                            </li>
                                                            <li>
                                                                <button class="btn" type="button">Xl</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-qnty">
                                                        <h6 class="f-w-600">Quantity</h6>
                                                        <fieldset>
                                                            <div class="input-group">
                                                                <input class="touchspin text-center" type="text"
                                                                    value="5">
                                                            </div>
                                                        </fieldset>
                                                        <div class="addcart-btn"><a class="btn btn-primary me-2"
                                                                href="https://app.lightfunnels.com/admin/oauth?client_id={{ env('LIGHTFUNNELS_CLIENT_ID') }}&redirect_uri={{ Request::root() }}/auth/redirect&scope=orders&state=123">Add
                                                                to Cart </a><a class="btn btn-primary"
                                                                href="product-page.html">View Details</a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn-close" type="button" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-details"><a
                                href="https://seller-area.youcan.shop/admin/oauth/authorize?client_id={{ env('YOUCAN_CLIENT_ID') }}&redirect_uri={{ Request::root() }}/callback&response_type=code&scope[]=*">
                                <h4>Youcan</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="card">
                    <div class="product-box">
                        <div class="product-img"><img class="img-fluid platformes"
                                src="{{ asset('public/plateformes/woocommerce.png') }}" alt="">
                            <div class="product-hover">
                                <ul>
                                    <li><a href="{{ route('woocommerce.index') }}"><i class="icon-eye"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-details text-center"><a href="{{ route('woocommerce.index') }}">
                                <h4>Woocommerce</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="card">
                    <div class="product-box">
                        <div class="product-img"><img class="img-fluid platformes"
                                src="{{ asset('public/plateformes/sheet.png') }}" alt="">
                            <div class="product-hover">
                                <ul>
                                    <li><a href="{{ route('sheets.index') }}"><i class="icon-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-details text-center"><a href="{{ route('sheets.index') }}">
                                <h4>Google Sheets</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#select2Primary').select2({
                minimumResultsForSearch: -1,
                placeholder: function() {
                    $(this).data('placeholder');
                }
            });
        });
        $(function(e) {
            $('#createsheets').click(function(e) {

                var countries = $('#select2Primary').val();
                var name = $('#name').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('companies.store') }}',
                    cache: false,
                    data: {
                        countries: countries,
                        name: name,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.', 'Company Has been Addess Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            location.reload();
                        }
                        if (response.success == error) {
                            toastr.error('Error.', 'Name already Exist!', {
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
            $('.deletesheet').click(function(e) {
                var id = $(this).data('id');
                if (confirm("Are you sure, you want to Delete Sheet?")) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('companies.delete') }}',
                        cache: false,
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.', 'Sheet Has been Deleted Success!', {
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
        $(function() {
            $('body').on('click', '.editProduct', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var countries = $(this).data('countries');
                //console.log(product_id);
                $('#sheetrow').modal('show');
                $('#company_id').val(id);
                $('#company_name').val(name);

                $('#select2Success').empty();
                for (var i = 0; i < countries.length; i++) {

                    $('#select2Success').append(countries[i]);
                }


            });
        });

        $(function(e) {
            $('#editsheets').click(function(e) {
                var id = $('#company_id').val();
                var name = $('#company_name').val();
                var countries = $('#select2Success').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('companies.update') }}',
                    cache: false,
                    data: {
                        id: id,
                        name: name,
                        countries: countries,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.', 'Sheet Has been Addess Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            location.reload();
                        }

                    }
                });
            });
        });
    </script>
@endsection
