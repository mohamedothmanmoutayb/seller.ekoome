@extends('backend.layouts.app')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
@endsection
@section('content')
    <!-- Content wrapper -->

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-9 align-self-center ">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Offer Details
                    </h4>

                </div>
               
                <div class="row mb-5">
                    <div class="col-md-12 col-lg-12 mb-3">
                        <div class="row">
                            <div class="col-md-12 col-lg-12 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                <div id="carouselExampleControlsNoTouching" class="carousel slide"
                                                    data-bs-touch="false" data-bs-interval="false">
                                                    <div class="carousel-inner mt-2">
                                                        @if ($product->image)
                                                            <div class="carousel-item active">
                                                                <img src="{{ $product->image }}" class="d-block w-100"
                                                                    alt="photo">
                                                            </div>
                                                        @else
                                                            <div class="carousel-item active">
                                                                <img src="{{ asset('/public/download.png') }}"
                                                                    class="d-block w-100" alt="photo">
                                                            </div>
                                                        @endif

                                                        @forelse ($photos as $photo)
                                                                <div class="carousel-item" style="height:100%">
                                                                    <img src="{{ $photo->image }}" class="d-block w-100"
                                                                        alt="photo">
                                                                </div>
                                                        @empty
                                                        @endforelse
                                                    </div>
                                                    <button class="carousel-control-prev" type="button"
                                                        data-bs-target="#carouselExampleControlsNoTouching"
                                                        data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button"
                                                        data-bs-target="#carouselExampleControlsNoTouching"
                                                        data-bs-slide="next">
                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                        <span class="visually-hidden">Next</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                <div class="mt-4 mb-4">
                                                    <h4 class="mt-4 mb-4">{{ $product->name }}</h4>
                                                    <h6 class="text-success text-uppercase">Category :
                                                        @if ($product->category)
                                                            {{ $product->category->name }}
                                                        @endif
                                                    </h6>
                                                    <h6 class="mt-4 fs-16">Description</h6>
                                                    <p>
                                                        @if ($product->description)
                                                            {{ $product->description }}
                                                        @else
                                                            No Description
                                                        @endif
                                                    </p>
                                                    <div class="mt-4">
                                                        <h5 class="mb-3">Specifications :</h5>
                                                        <div class="table-responsive">
                                                            <table class="table mb-0 table-stripped border">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Category :</th>

                                                                        <td scope="col">
                                                                            @if ($product->category)
                                                                                {{ $product->category->name }}
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="col">Vendor :</th>

                                                                        <td scope="col">
                                                                            @if ($user)
                                                                                {{ $user->name }}  <br>{{ $user->telephone ? $user->telephone : $user->email }}
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">Product Name :</th>
                                                                        <td>{{ $product->name }}</td>

                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Quantity :</th>
                                                                        <td>
                                                                            @if ($product->stock)
                                                                                 {{ $product->stock->qunatity }}

                                                                            @else
                                                                                stock not available
                                                                            @endif
                                                                        
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                            <th scope="row">Landing page :</th>
                                                                            <td colspan="2"><a href="{{ $product->link }}"><i class="ti ti-link"></i></a></td>

                                                                    </tr>
                                                    
                                                                    <tr>
                                                                         
                                                                            <th scope="row">Average Price in Market:</th>
                                                                            <td colspan="2">{{ $product->price_vente}}
                                                                            </td>

                                                                    </tr>
                                                                    @if ($bool == false)
                                                                        
                                                                    <tr>
                                                                        <th scope="row">Affiliates </th>
                                                                        <td colspan="2">{{ $request }}
                                                                        </td>

                                                                    </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12 col-sm-12">
                                                <div class="swiper d-flex flex-wrap">                                                
                                                    @forelse ($photos as $photo)
                                                            <div class="col-xl-2 ">
                                                                <div class="ms-4 mt-4" style="height:100%">
                                                                    <img src="{{ $photo->image }}" class="d-block rounded"
                                                                        width="150px" height="150px" alt="photo">
                                                                </div>
                                                            </div>
                                                    @empty
                                                            <div class="col-xl-2 ">
                                                                <div class="ms-4 mt-4" style="height:100%">
                                                                    <img src="{{ asset('/public/assets/img/elements/default.png') }}"
                                                                        class="d-block rounded" width="150px"
                                                                        height="150px" alt="photo">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-2 ">
                                                                <div class="ms-4 mt-4" style="height:100%">
                                                                    <img src="{{ asset('/public/assets/img/elements/default.png') }}"
                                                                        class="d-block rounded" width="150px"
                                                                        height="150px" alt="photo">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-2 ">
                                                                <div class="ms-4 mt-4" style="height:100%">
                                                                    <img src="{{ asset('/public/assets/img/elements/default.png') }}"
                                                                        class="d-block rounded" width="150px"
                                                                        height="150px" alt="photo">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-2 ">
                                                                <div class="ms-4 mt-4" style="height:100%">
                                                                    <img src="{{ asset('/public/assets/img/elements/default.png') }}"
                                                                        class="d-block rounded" width="150px"
                                                                        height="150px" alt="photo">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-2 ">
                                                                <div class="ms-4 mt-4" style="height:100%">
                                                                    <img src="{{ asset('/public/assets/img/elements/default.png') }}"
                                                                        class="d-block rounded" width="150px"
                                                                        height="150px" alt="photo">
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-2 ">
                                                                <div class="ms-4 mt-4" style="height:100%">
                                                                    <img src="{{ asset('/public/assets/img/elements/default.png') }}"
                                                                        class="d-block rounded" width="150px"
                                                                        height="150px" alt="photo">
                                                                </div>
                                                            </div>
                                                    @endforelse


                                                </div>

                                            </div>

                                        </div>
                                        @if ($product->video)
                                            <div class="row mt-4">
                                                <div class="col-xl-12 col-sm-12">
                                                    <div class="d-flex flex-wrap">
                                                        <div class="col-xl-6 col-sm-12">
                                                            <div class="ms-4 mt-4">
                                                                <video controls style="height:400px;width:100%">
                                                                    <source src="{{ $product->video }}" type="video/mp4">
                                                                    Your browser does not support the video tag.
                                                                </video>
                                                            </div>
                                                        </div>
                                                        @foreach ($videos as $video)
                                                                <div class="col-xl-6 col-sm-12">
                                                                    <div class="ms-4 mt-4">
                                                                        <video controls style="height:400px;width:100%">
                                                                            <source src="{{ $video->video }}"
                                                                                type="video/mp4">
                                                                            Your browser does not support the video tag.
                                                                        </video>
                                                                    </div>
                                                                </div>
                                                        @endforeach

                                                    </div>

                                                </div>

                                            </div>
                                        @endif
                                        {{-- <div></div> --}}
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--/ Bordered Table -->
        <!-- Request Modal -->
        {{-- <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-simple modal-edit-user">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3 class="mb-2">Product Request</h3>
                            <p class="text-muted">You can request this product to be yours...</p>
                        </div>
              
                        <form id="uploadForm" method="POST" enctype="multipart/form-data" class="row g-3">
                            @csrf
                    
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
        <!--/ Request Modal -->
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

    <!-- Content wrapper -->

    {{-- <script>
        $(document).ready(function() {
            $('#RequestForm').click(function(event) {
                event.preventDefault();


                var $id = $('#Quantity').data('id');
                var $quantity = $('#Quantity').val();

                $.ajax({
                    type: 'POST',
                    url: "",
                    data: {
                        'quantity': $quantity,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Good Job.', 'Product Has Been Requested!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            location.reload();
                        }
                    },
                    error: function(error) {
                        toastr.warning('Good Job.', 'Opps Quantity is required!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $('#uploadForm').submit(function(event) {
                event.preventDefault();

                var formData = new FormData($(this)[0]);

                $.ajax({
                    type: 'POST',
                    url: "",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Good Job.', 'Product Has Been Requested!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            location.reload();
                        }
                        console.log(response);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors occurred
                            var errors = xhr.responseJSON.errors;

                            // Display each error
                            for (var field in errors) {
                                toastr.warning('Good Job.', 'Opps ' + errors[field][0], {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 4000
                                });
                            }
                        } else {
                            // Other types of errors
                            toastr.warning('Good Job.', 'Opps Something went wrong!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                        console.log(xhr);
                    }
                });
            });
        });
    </script>
    <style>
        .dropdown-menu.show {
            display: block;
        }
    </style>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
@endsection
