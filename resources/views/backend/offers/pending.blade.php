@extends('backend.layouts.app')
@section('style')
    <style>
        .badge {
            position: absolute;
            top: 10px;
            left: 10px;
        }
    </style>
@endsection
@section('content')
    <!-- Content wrapper -->

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-lg-9 col-6">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> @if($bool) Pending Offers @else Offers @endif</h4>

                </div>              
                <div class="row flex-column-reverse flex-md-row mb-5">
                    <div class="col-md-8 col-lg-9 mb-3">
                        <div class="row">
                            @forelse ($products as $product)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card h-100">
                                        @if ($product->image)
                                            <img class="card-img-top" src="{{ $product->image }}" alt="Card image cap"
                                                height="300px" />
                                        @else
                                            <img class="card-img-top" src="{{ asset('/public/download.png') }}"
                                                alt="Card image cap" height="100px" />
                                        @endif
                                        <p style="position: absolute;
                                            top: 10px;
                                            left: 10px;"
                                            class="card-text badge bg-success">
                                            @if ($product->category)
                                                <span class="">{{ $product->category->name }}</span>
                                            @else
                                                <span class="">Default</span>
                                            @endif

                                        </p>
                                        <div class="card-body">
                                            <center>
                                                <h5 class="card-title">{{ $product->name }}</h5>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('offers.details', $product->id) }}"
                                                        class="btn btn-primary mx-1"> <i class="ti ti-eye mx-1"></i></a>
                                                    @if($bool)
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#AccetpOffer" data-id="{{ $product->id }}"
                                                                class="btn btn-primary "><i class="ti ti-check mx-1"></i></a>
                                                    @endif
                                                    @if($bool == false)
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#DeactivateOffer" data-id="{{ $product->id }}"
                                                            class="btn btn-primary "><i class="ti ti-trash mx-1"></i></a>
                                                   @endif
                                                </div>
                                              
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            @empty

                                <div>
                                    <h1 class="text-center">No Offers Found</h1>
                                </div>
                            @endforelse
                        </div>

                        {{ $products->withQueryString()->links('vendor.pagination.courier') }}

                    </div>
                    <div class="col-md-4 col-lg-3 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row row-sm">
                                    <div class="col-sm-12">
                                        <form action="" method="GET">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search"
                                                    name="search" aria-label="Search" aria-describedby="basic-addon2" />
                                                <span class="input-group-text" id="basic-addon2"><button
                                                        class="btn py-0 px-1" type="submit"><i
                                                            class="fa fa-search"></i></button></span>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <br>
                        <div class="row mb-4 ">
                            <div class="col-md-12 col-lg-12">
                                <div class="card">

                                    <h6 class="mt-4 fw-bold" style="margin-left: 20px">Search <i class="fa fa-filter"></i>
                                    </h6>
                                    <hr>

                                    <form action="" method="GET">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="form-label">Categories</label>
                                                <select name="category" id="category" class="form-control">
                                                    <option value="" disabled selected>Select Category </option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            data-subcategory="{{ $category->subcategories }}">
                                                            {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Sub Category</label>
                                                <select name="subcategory" id="subCategory" class="form-control">
                                                    <option value="" disabled selected>Select Category First
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Name</label>
                                                <input type="text" class="form-control" placeholder="Search By Name"
                                                    name="name" aria-label="Search" aria-describedby="basic-addon2" />

                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Price</label>
                                                <input type="text" class="form-control" placeholder="Search By Price"
                                                    name="price" aria-label="Search" aria-describedby="basic-addon2" />

                                            </div><br>
                                            <center>
                                                <button class="btn ripple btn-primary btn-block mt-2" type="submit">
                                                    Apply Filter
                                                </button>
                                            </center>

                                        </div>

                                    </form>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <!-- Request Modal -->
                @if($bool)
                    <div class="modal fade" id="AccetpOffer" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-simple modal-edit-user">
                            <div class="modal-content p-3 p-md-5">
                                <div class="modal-body">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                    <div class="text-center mb-4">
                                        <h3 class="mb-2">Offer Request</h3>
                                        <p class="text-muted">Are you sure you want to accept this offer ?</p>
                                    </div>
                                    <form action="{{route('offers.acceptOffer')}}" class="d-flex justify-content-center">                               
                                        <input type="text" name="id" value=""  hidden  id="offerId">
                                        <button type="submit"
                                            class="btn btn-primary ">Submit</button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- @if($bool == false)
                <div class="modal fade" id="DeactivateOffer" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-simple modal-edit-user">
                        <div class="modal-content p-3 p-md-5">
                            <div class="modal-body">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                <div class="text-center mb-4">
                                    <h3 class="mb-2">Offer Request</h3>
                                    <p class="text-muted">Are you sure you want to desactivate this offer ?</p>
                                </div>
                                <form action="{{ route('offers.desactivatedOffer') }}" class="d-flex justify-content-center">                               
                                    <input type="text" name="id" value=""  hidden  id="offerId">
                                    <button href="#" 
                                        class="btn btn-primary ">Submit</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
                @endif --}}
                <!--/ Request Modal -->
            </div>
        </div>




    </div>
    <!-- / Content -->

    <!-- Footer -->
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
            </div>
        </div>
    </footer>
    <!-- / Footer -->

    <div class="content-backdrop fade"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        // $(document).ready(function() {
        //     $('#uploadForm').submit(function(event) {
        //         event.preventDefault();

        //         var formData = new FormData($(this)[0]);

        //         $.ajax({
        //             type: 'POST',
        //             url: "",
        //             data: formData,
        //             processData: false,
        //             contentType: false,
        //             success: function(response) {
        //                 if (response.success) {
        //                     toastr.success('Good Job.', 'Product Has Been Requested!', {
        //                         "showMethod": "slideDown",
        //                         "hideMethod": "slideUp",
        //                         timeOut: 2000
        //                     });
        //                     location.reload();
        //                 }
        //                 console.log(response);
        //             },
        //             error: function(xhr) {
        //                 if (xhr.status === 422) {
        //                     // Validation errors occurred
        //                     var errors = xhr.responseJSON.errors;

        //                     // Display each error
        //                     for (var field in errors) {
        //                         toastr.warning('Good Job.', 'Opps ' + errors[field][0], {
        //                             "showMethod": "slideDown",
        //                             "hideMethod": "slideUp",
        //                             timeOut: 4000
        //                         });
        //                     }
        //                 } else {
        //                     // Other types of errors
        //                     toastr.warning('Good Job.', 'Opps Something went wrong!', {
        //                         "showMethod": "slideDown",
        //                         "hideMethod": "slideUp",
        //                         timeOut: 2000
        //                     });
        //                 }
        //                 console.log(xhr);
        //             }
        //         });
        //     });
        // });

        $(document).ready(function() {
            $('#AccetpOffer').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                console.log(id);
                var modal = $(this)
                modal.find('.modal-body #offerId').val(id);
            });
        });
        @if (session('success'))

            toastr.success('Good Job.', 'Offer has been accepeted!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
            });

        @endif
        
        // $(document).ready(function() {
        //     $('#AccetpOffer form').submit(function(event) {
        //         event.preventDefault();

        //         var id = $('#offerId').val();
               
        //         $.ajax({
        //             type: 'GET',
        //             url: "{{ route('offers.acceptOffer') }}",
        //             data: {
        //                 id: id
        //             },
        //             processData: false,
        //             contentType: false,
        //             success: function(response) {
                       
        //                 if (response.success) {
        //                     console.log(response);
        //                     toastr.success('Good Job.', 'Offer has been accepted!', {
        //                         "showMethod": "slideDown",
        //                         "hideMethod": "slideUp",
        //                         timeOut: 2000
        //                     });
        //                     // location.reload();
        //                 }
                        
        //             },
        //             error: function(xhr) {
        //                 if (xhr.status === 422) {
        //                     // Validation errors occurred
        //                     var errors = xhr.responseJSON.errors;

        //                     // Display each error
        //                     for (var field in errors) {
        //                         toastr.warning('Good Job.', 'Opps ' + errors[field][0], {
        //                             "showMethod": "slideDown",
        //                             "hideMethod": "slideUp",
        //                             timeOut: 4000
        //                         });
        //                     }
        //                 } else {
        //                     // Other types of errors
        //                     toastr.warning('Good Job.', 'Opps Something went wrong!', {
        //                         "showMethod": "slideDown",
        //                         "hideMethod": "slideUp",
        //                         timeOut: 2000
        //                     });
        //                 }
        //                 console.log(xhr);
        //             }
        //         });
        //     });
        // });
    </script>
    <style>
        .dropdown-menu.show {
            display: block;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#category').on('change', function(e) {
                var subcategories = $(this).find(':selected').data('subcategory');
                $("#subCategory").html('<option value="" disabled selected>Select Sub Category</option>');
                $.each(subcategories, function(key, value) {
                    $("#subCategory").append('<option value="' + value.id + '">' +
                        value.name + '</option>');
                });
            });

        });
        $(document).ready(function() {
            $('#category2').on('change', function(e) {
                var subcategories = $(this).find(':selected').data('subcategory2');
                $("#subCategory2").html('<option value="" disabled selected>Select Sub Category</option>');
                $.each(subcategories, function(key, value) {
                    $("#subCategory2").append('<option value="' + value.id + '">' +
                        value.name + '</option>');
                });
            });

        });
    </script>

@endsection
