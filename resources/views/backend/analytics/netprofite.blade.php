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
                <div class="col-12">
                </div>
                <div class="col-12 ">
                    <div class="card">
                        <div class="row m-4 d-flex align-items-center justify-content-between">
                            <h4>Calculate Net Profite</h4>
                            <form class=" align-items-center">
                                <div class="row">
                                    <div class="col-lg-3 col-md-10">
                                        <div class="dl">
                                            <div class="col-12 align-self-center">
                                                <div class='input-group '>
                                                    <input type='text' class="form-control dated"
                                                        name="profit_date" value="{{ request()->input('date_call') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-lg-2 col-md-10">
                                        <div class="dl w-100">
                                            <select class="select2 form-control"  name="store" placeholder="Select Store" id="all_product_select">
                                                <option value=" ">Select Store</option>
                                                @foreach ($stores as $v_store)
                                                    <option value="{{ $v_store->id }}" {{ $v_store->id == request()->input('store') ? 'selected' : '' }}>{{ $v_store->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class=" col-lg-2 col-md-10">
                                        <div class="dl w-100">
                                            <select class="form-control select2" name="profite_product">
                                                <option value=" ">Select Product</option>
                                                @foreach ($products as $v_product)
                                                    <option value="{{ $v_product->id }}"
                                                        {{ $v_product->id == request()->input('profite_product') ? 'selected' : '' }}>
                                                        {{ $v_product->name }} / {{ $v_product->sku }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class=" col-lg-2 col-md-10">
                                        <div class="dl w-100">
                                            <select class="form-control select2" name="profite_agents">
                                                <option value=" " selected>Select Agent Confirmation</option>
                                                @foreach ($agents as $v_agent)
                                                    <option value="{{ $v_agent->id }}"
                                                        {{ $v_agent->id == request()->input('profite_agents') ? 'selected' : '' }}>
                                                        {{ $v_agent->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class=" col-lg-2 col-md-10">
                                        <div class="dl w-100">
                                            <select class="form-control select2" name="profite_shipping">
                                                <option value=" " selected>Select Shipping Company</option>
                                                @foreach ($companys as $v_company)
                                                    <option value="{{ $v_company->id }}"
                                                        {{ $v_company->id == request()->input('profite_shipping') ? 'selected' : '' }}>
                                                        {{ $v_company->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class=" col-lg-12 col-md-12">
                                        <div class="align-items-center">
                                            <div class="dl">
                                                <button class="btn btn-primary input-group-append w-100" type="submit">APPLY</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-3 mb-3" bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Total Ads</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{ $speendads }}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3" bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Revenue</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{ $revenues}}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3" bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Fees Products</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{$sumproduct}}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3" bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Expensess</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{ $expensse}}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3" bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Fees Shipping</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{number_format((float)($feessdelivered) , 2)}}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3" bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Total Profite</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{ number_format((float)($revenues - ($speendads + $sumproduct + $expensse + $feessdelivered)), 2) }}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3" bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Cost Per Lead</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{number_format((float)($costperlead) , 2)}}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3" bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Cost per Confirmed</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{ number_format((float)($costperconfirmed) , 2)}}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 " bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Cost Per Delivered</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{ number_format((float)($costperdelivered) , 2)}}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 " bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">ROI</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{ number_format((float)($roi) , 2)}} %" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                </div>
                            </form>
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
{{-- 

        <script>
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
        </script>
        
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
    
    <script>

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
