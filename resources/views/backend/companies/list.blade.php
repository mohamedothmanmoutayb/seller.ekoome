@extends('backend.layouts.app')
@section('content')
        
        <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                           <a href="javascript:void(0)" onclick="history.back()" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                                <i class="ti ti-arrow-left fs-5"></i> 
                            </a>
                    <div>
                        <h4 class="mb-4 mb-sm-0 card-title"> Shipping Companies </h4>
                        <p class="mb-0 text-muted">Connect with your delivery partners.</p>
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

                <div class="product-wrapper-grid">
                    <div class="row">
                        @foreach ($companies as $v_company)
                            @if ($v_company->countries)
                                @foreach ($v_company->countries as $country)
                                    @if($country == Auth::user()->country_id)
                                    <div class="col-xl-3 col-lg-4 col-sm-6">
                                        <div class="card">
                                            <div class="product-box">
                                                <div class="product-img"><img class="img-fluid" src="https://seller.ekoome.shop/public/{{$v_company->logo}}" width="400px"  alt="">
                                                    <div class="product-hover">
                                                        <ul>
                                                            <li><a data-bs-toggle="modal" data-bs-target="#exampleModalCenter{{$v_company->id}}"><i class="icon-eye"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-details"><a href="{{ route('last-mille.details' ,$v_company->id )}}">
                                                    <h4 class="text-center">{{ $v_company->name}}</h4></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
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
