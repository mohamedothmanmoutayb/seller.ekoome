@extends('backend.layouts.app')
@section('content')
    <style>
        .chartjs {
            height: 366px !important;
        }
        body{
          overflow-x: hidden;
        }
    </style>
            <div class="card card-body py-3">
                <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="mb-4 mb-sm-0 card-title">Overview</h4>
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

            <div class="row">
                
                <!-- Cards with few info -->
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">{{ $orderstotal }}</h5>
                                <small>Total Orders</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-primary rounded-pill p-2">
                                    <i data-feather="box"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">{{ $ordersdelivered }}</h5>
                                <small>Total Order Delivered</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-warning rounded-pill p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class=" icon icon-tabler icon-tabler-location-up" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 18l-2 -4l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5l-3.251 9.003" />
                                        <path d="M19 22v-6" />
                                        <path d="M22 19l-3 -3l-3 3" />
                                    </svg>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">{{ $ordersreturned }}</h5>
                                <small>Total Orders Returned</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-success rounded-pill p-2">
                                    <i data-feather="check"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">{{ $revenues }} / {{ $currency->currency }}</h5>
                                <small>Revenues</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-success rounded-pill p-2">
                                    <i data-feather="check"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-12">
                    <div class="card new-card">
                        <div class="card-body">
                            <!-- title -->
                            <div class="d-md-flex align-items-center">
                                <div>
                                    <span class="card-title">List Products</span>
                                </div>
                            </div>
                            <!-- title -->
                            <div class="table-responsive scrollable mt-2" style="height:400px;">
                                <table class="table v-middle">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">Products</th>
                                            <th class="border-top-0">Image</th>
                                            <th class="border-top-0">Quantity Sent</th>
                                            <th class="border-top-0">Quantity Real</th>
                                            <th class="border-top-0">Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $v_product)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="mx-2">
                                                                <span
                                                                    class="mb-0 font-medium">{{ $v_product->name }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <img src="{{ $v_product->image }}"
                                                                    alt="user" class="rounded-circle"
                                                                    width="45" />
                                                        </div>
                                                    </td>
                                                    <td>{{ $v_product->CountSent($v_product->id) }}</td>
                                                    <td>{{ $v_product->CountStockReal($v_product->id) }}</td>
                                                    <td>{{ $v_product->AmountStock($v_product->id) }}</td>
                                                </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@section('script')
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <!-- endbuild -->

    <script>
        $('input[name="profit_date"]').daterangepicker();
        $('input[name="date_call"]').daterangepicker();
        $('input[name="date_shipped"]').daterangepicker();
    </script>

@endsection
@endsection
