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
                        <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                            <i class="ti ti-arrow-left fs-5"></i> 
                        </a>
                        <h4 class="mb-4 mb-sm-0 card-title">Analytics</h4>
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

                <!--- shipping -->

                <div class="col-12 ">
                    <div class="card">
                        <div class="row m-4 d-flex align-items-center justify-content-between">
                            <h4>Shipping Data</h4>
                            <form class=" align-items-center">
                                <div class="row">
                                    <div class="col-lg-3 col-md-10">
                                        <div class="dl">
                                            <div class="col-12 align-self-center">
                                                <div class='input-group '>
                                                    <input type="text" class="form-control dated" name="date_shipped" value="{{ request()->input('date_shipped') }}"id="flatpickr-ranges"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-lg-3 col-md-10">
                                        <div class="dl w-100">
                                            <select class="form-control select2" name="shipped_product">
                                                <option value="" selected>Select Product</option>
                                                @foreach ($products as $v_product)
                                                    <option value="{{ $v_product->id }}"
                                                        {{ $v_product->id == request()->input('shipped_product') ? 'selected' : '' }}>
                                                        {{ $v_product->name }}  / {{ $v_product->sku }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-10">
                                        <div class="dl w-100">
                                            <select class="form-control select2" name="shipped_lastmille">
                                                <option value=" " selected>Select Agent Last Mille</option>
                                                @foreach ($companys as $v_companys)
                                                    <option value="{{ $v_companys->id }}"
                                                        {{ $v_companys->id == request()->input('shipped_lastmille') ? 'selected' : '' }}>
                                                        {{ $v_companys->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row col-lg-3 col-md-10">
                                        <div class="align-items-center">
                                            <div class="dl">
                                                <button class="btn btn-primary input-group-append w-100"
                                                    type="submit">APPLY</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Cards with few info -->
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Orders</small>
                                <h5 class="mb-0 me-2">{{ $orders }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-primary rounded-pill p-2">
                                    <iconify-icon icon="uil:shopping-cart-alt" class="fs-7 text-secondary text-white"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Orders unpacked</small>
                                <h5 class="mb-0 me-2">{{ $chartunpacked }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-warning rounded-pill p-2">
                                    <iconify-icon icon="tabler:location" class="fs-7 text-secondary text-white"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Orders picking proccess</small>
                                <h5 class="mb-0 me-2">{{ $chartpicking }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-warning rounded-pill p-2">
                                    <iconify-icon icon="tabler:packages" class="fs-7 text-secondary text-white"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Orders packed</small>
                                <h5 class="mb-0 me-2">{{ $chartpacked }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-warning rounded-pill p-2">
                                    <iconify-icon icon="tabler:shopping-cart-share" class="fs-7 text-secondary text-white"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Orders shipped</small>
                                <h5 class="mb-0 me-2">{{ $chartshipped }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-success rounded-pill p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cube-send"
                                        width="28" height="28" viewBox="0 0 28 28" stroke-width="1.5"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M16 12.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                                        <path d="M11 9.5v5.5l5 3" />
                                        <path d="M16 12.545l5 -3.03" />
                                        <path d="M7 9h-5" />
                                        <path d="M7 12h-3" />
                                        <path d="M7 15h-1" />
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
                                <small  style="color: #aaa8a8;">Orders in transit</small>
                                <h5 class="mb-0 me-2">{{ $charttransit }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-success rounded-pill p-2">
                                    <iconify-icon icon="tabler:trolley" class="fs-7 text-secondary text-white"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Orders in delivery</small>
                                <h5 class="mb-0 me-2">{{ $chartindelivery }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-success rounded-pill p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-truck-delivery" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                                        <path d="M3 9l4 0" />
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
                                <small  style="color: #aaa8a8;">Orders incident</small>
                                <h5 class="mb-0 me-2">{{ $chartincident }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-warning rounded-pill p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-road-off"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 19l3.332 -11.661" />
                                        <path d="M16 5l2.806 9.823" />
                                        <path d="M12 8v-2" />
                                        <path d="M12 13v-1" />
                                        <path d="M12 18v-2" />
                                        <path d="M3 3l18 18" />
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
                                <small  style="color: #aaa8a8;">Orders delivered</small>
                                <h5 class="mb-0 me-2">{{ $chartdelivered }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-success rounded-pill p-2">
                                    <iconify-icon icon="solar:delivery-broken" class="moon fs-6"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cards with few info -->
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Orders rejected</small>
                                <h5 class="mb-0 me-2">{{ $chartcanceled }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-warning rounded-pill p-2">
                                    <i class="ti ti-alert-octagon ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Orders returned</small>
                                <h5 class="mb-0 me-2">{{ $chartreturned }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-danger rounded-pill p-2">
                                    <iconify-icon icon="tabler:rotate" class="fs-7 text-secondary text-white"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="row">
                            <div class="row m-4 d-flex align-items-center justify-content-between">
                                <h4 style="color: #0c1336; font-weight: 800;">Shipping Overivew</h4>
                            </div>
                            <!-- Polar Area Chart -->
                                <div class="card-body">
                                    <div id="polarChartt"></div>
                                </div>
                            <!-- /Polar Area Chart -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="row">
                            <div class="row m-4 d-flex align-items-center justify-content-between">
                                <h4 style="color: #0c1336; font-weight: 800;">Shipping Overivew</h4>
                            </div>
                            <!-- Radar Chart -->
                                <div class="">
                                    <div class="card-body">
                                        <div id="polarCharts"></div>
                                    </div>
                                </div>
                            <!-- /Radar Chart -->
                        </div>
                    </div>
                </div>


                <div class="row mt-4">
                    <div class="col-sm-12 col-lg-4">
                        <div class="card new-card">
                            <div class="card-body">
                                <!-- title -->
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <span style="font-weight: 700;">QTE IN WEARHOUSE</span>
                                    </div>
                                </div>
                                <!-- title -->
                                <div class="table-responsive scrollable mt-2" style="height:400px;">
                                    <table class="table v-middle">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Products</th>
                                                <th class="border-top-0">Name</th>
                                                <th class="border-top-0">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($quantity_stock as $v_stock)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @foreach ($v_stock['products'] as $v_product)
                                                                <div class="mr-2"><img src="{{ $v_product->image }}"
                                                                        alt="user" class="rounded-circle"
                                                                        width="45" /></div>
                                                                    </td> <div class="">
                                                                    <td
                                                                        class="mb-0 font-medium">{{ $v_product->name }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td class="text-center">{{ $v_stock->qunatity }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">
                                                        <img src="{{ asset('public/Empty-amico.svg') }}" class="img-fluid"
                                                            width="300" style="margin: 0 auto; display: block;">
                                                        <p class="mt-3 text-muted">No products found.</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="card new-card">
                            <div class="card-body">
                                <!-- title -->
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <span class="card-title" style="font-weight: 800;">LOW STOCK PRODUCTS</span>
                                    </div>
                                </div>
                                <!-- title -->
                                <div class="table-responsive scrollable mt-2" style="height:400px;">
                                    <table class="table v-middle">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Products</th>
                                                <th class="border-top-0">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $filteredProducts = $low_stock_product->filter(function($v_product) {
                                                return $v_product->quantity != 0 && $v_product->low_stock > $v_product->quantity;
                                            });
                                        @endphp
                                        
                                        @if ($filteredProducts->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <img src="{{ asset('public/Empty-amico.svg') }}" class="img-fluid"
                                                        width="300" style="margin: 0 auto; display: block;">
                                                    <p class="mt-3 text-muted">No products found.</p>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($filteredProducts as $v_product)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="mr-2">
                                                                <img src="{{ $v_product->image }}" alt="user"
                                                                    class="rounded-circle" width="45" />
                                                            </div>
                                                            <div>
                                                                <span class="mb-0 font-medium">{{ $v_product->name }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $v_product->quantity }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="card new-card">
                            <div class="card-body">
                                <!-- title -->
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <span class="card-title" style="font-weight: 800;">OUT OF STOCK</span>
                                    </div>
                                </div>
                                <!-- title -->
                                <div class="table-responsive scrollable mt-2" style="height:400px;">
                                    <table class="table v-middle">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Products</th>
                                                <th class="border-top-0">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $outOfStockProducts = $import_product->filter(function($v_product) {
                                                return $v_product->quantity == 0;
                                            });
                                        @endphp
                                        
                                        @if ($outOfStockProducts->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <img src="{{ asset('public/Empty-amico.svg') }}" class="img-fluid"
                                                        width="300" style="margin: 0 auto; display: block;">
                                                    <p class="mt-3 text-muted">No products out of stock found.</p>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($outOfStockProducts as $v_product)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="mr-2">
                                                                <img src="{{ $v_product->image }}" alt="user" class="rounded-circle" width="45" />
                                                            </div>
                                                            <div class="mx-2">
                                                                <span class="mb-0 font-medium">{{ $v_product->name }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $v_product->quantity }}</td>
                                                </tr>
                                            @endforeach
                                        @endif                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@section('script')
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <!-- endbuild -->


    </script>


    <script>
        $('input[name="profit_date"]').daterangepicker();
        $('input[name="date_call"]').daterangepicker();
        $('input[name="date_shipped"]').daterangepicker();
    </script>


        {{-- <script>
 var options_donut = {
    series: [{{ $chartnew }}, {{ $chartconfirmed }}, {{ $chartnoanswer }}, {{ $chartcall }},
                        {{ $chartrejected }}, {{ $chartduplicated }}, {{ $chartwrong }}, {{ $chartarea }},
                        {{ $chartcanceledbysestem }}],
    chart: {
      fontFamily: "inherit",
      type: "donut",
      width: 510,
    },labels: ['New Order', 'Confirmed', 'No Answer', 'Call Later', 'Canceled', 'Duplicated',
                        'Wrong', 'Out Of Area', 'Canceled By System','Black Listed'
                    ],
    colors: [
        "#222d6f", "#29dac7" , "#f9c20a", "#f87a0c" , "#ff0000", '#d9abda', '#7e7e7e' , '#ff6693', "#ff0000"  
    ],
    responsive: [
      {
        breakpoint: 480,
        options: {
          chart: {
            width: 200,
          },
          legend: {
            position: "bottom",
          },
        },
      },
    ],
    legend: {
      labels: {
       colors:  "#a1aab2",
      },
    },
  };

  var chart_pie_donut = new ApexCharts(
    document.querySelector("#donutCharts"),
    options_donut
  );
  chart_pie_donut.render();
        </script> --}}
        
    <script>

        'use strict';

        (function() {
           


            // Donut Chart
            // --------------------------------------------------------------------

            var options_donut = {
                labels: ['Delivered', 'Returned'],
                series: [{{ $chartdelivered }}, {{ $chartreturned }}],
                chart: {
                fontFamily: "inherit",
                type: "donut",
                width: 470,
                },
                colors: [
                "#29dac7",
                "#ff0000",
                ],
                responsive: [
                {
                    breakpoint: 480,
                    options: {
                    chart: {
                        width: 200,
                    },
                    legend: {
                        position: "bottom",
                    },
                    },
                },
                ],
                legend: {
                labels: {
                colors:  "#a1aab2",
                },
                },
            };

            var chart_pie_donut = new ApexCharts(
                document.querySelector("#polarCharts"),
                options_donut
            );
            chart_pie_donut.render();
        })();
    </script>
    <script>
        /**
         * Charts Apex
         */

        'use strict';

        (function() {
            let cardColor, headingColor, labelColor, borderColor, legendColor;

            


            // Donut Chart
            // --------------------------------------------------------------------
            var options_donut = {
                labels: ['Unpacked', 'Picking Proccess', 'Item Packed', 'shipped', 'Proseccing', 'In Transit',
                        'In Delivery', 'Incident', 'Delivered', 'Rejected', 'Returned'
                    ],
                series: [{{ $chartunpacked }}, {{ $chartpicking }}, {{ $chartpacked }}, {{ $chartshipped }},
                        {{ $chartproseccing }}, {{ $charttransit }}, {{ $chartindelivery }},
                        {{ $chartincident }}, {{ $chartdelivered }}, {{ $chartcanceled }}, {{ $chartreturned }}
                    ],
                chart: {
                fontFamily: "inherit",
                type: "donut",
                width: 510,
                },
                colors: [
                    "#222d6f" , "#f9c20a", "#39c0e5", "#f87a0c" , "#834f22", '#d9abda', '#7e7e7e' , '#ff6693', "#29dac7", "#ff0000", "#ff0000", "#ff0000"
                ],
                responsive: [
                {
                    breakpoint: 480,
                    options: {
                    chart: {
                        width: 510,
                    },
                    legend: {
                        position: "bottom",
                    },
                    },
                },
                ],
                legend: {
                labels: {
                colors:  "#a1aab2",
                },
                },
            };

            var chart_pie_donut = new ApexCharts(
                document.querySelector("#polarChartt"),
                options_donut
            );
            chart_pie_donut.render();
        })();
    </script>
    
    {{-- <script>

        'use strict';

        (function() {
           


            // Donut Chart
            // --------------------------------------------------------------------

            var options_donut = {
                labels: ['Confirmed', 'Cancelled'],
                series: [{{ $chartconfirmed }}, {{ $chartrejected }}],
                chart: {
                fontFamily: "inherit",
                type: "donut",
                width: 470,
                },
                colors: [
                "#29dac7",
                "#ff0000",
                ],
                responsive: [
                {
                    breakpoint: 480,
                    options: {
                    chart: {
                        width: 200,
                    },
                    legend: {
                        position: "bottom",
                    },
                    },
                },
                ],
                legend: {
                labels: {
                colors:  "#a1aab2",
                },
                },
            };

            var chart_pie_donut = new ApexCharts(
                document.querySelector("#donutChartt"),
                options_donut
            );
            chart_pie_donut.render();
        })();
    </script> --}}

@endsection
@endsection
