@extends('backend.layouts.app')
@section('content')
    <style>
        .select2 {
            width: 100% !important;
        }

        #productconfirmation {
            height: 2500px;
            min-width: 1420px;
            max-width: 2600px;
            margin: 0 auto;
        }
    </style>
  
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />



    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">

                <!-- Revenue Growth -->
                <div class="col-xl-6 col-md-6 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="col-5">
                                    <select id="seller" class="select2 form-control years mx-2" name="seller">
                                        <option value="">seller</option>
                                        @foreach ($users as $v_user)
                                            <option value="{{ $v_user->id }}">{{ $v_user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <input  name="date-range" id="years" class="form-control timeseconds years" />
                                </div>
                                {{-- <div id="revenueGrowth"></div> --}}
                            </div>
                            <div class="d-flex flex-column">
                                <h5 class="mt-4 mx-2" style="color:gray;">Total Revenues (<a
                                        href="{{ route('leads.index') }}?confirmation%5B%5D=confirmed&livraison%5B%5D=delivered&payment=paid"
                                        id="order"> {{ $order }} </a> orders)</h4>

                                    <div class="row mx-2">
                                        <div class="col-4">
                                            <div class="d-flex flex-column">
                                                <h4 style="color:black;">{{ $countri->currency }}<br>
                                                    <span id="countrev" style="padding-left:40px;">
                                                        {{ $revenue }}
                                                    </span>

                                                </h4>
                                                <span style="color:gray; padding-left:10px;">REVENUES</span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <h4 style="color:black;">{{ $countri->currency }}<br>
                                                <span id="trev"style="padding-left:40px;">
                                                    {{ $totalfees }}
                                                </span>
                                            </h4>
                                            <span style="color:gray; padding-left:10px;">FEES FULFILLEMENT</span>
                                        </div>
                                        <div class="col-4">
                                            <p style="padding-left:10px;padding-right:10px; padding-top:40px; color:green;">
                                                <i class="fa-solid fa-coins fa-2xl"></i>
                                            </p>
                                        </div>
                                        <p style="color:purple;" class="mt-4"><i class="fa-solid fa-sort-down fa-lg"></i>
                                            Since last month
                                        <p>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="col-3">
                                    <select id="seller" class="select2 form-control years mx-2" name="seller">
                                        <option value="">seller</option>
                                        @foreach ($users as $v_user)
                                            <option value="{{ $v_user->id }}">{{ $v_user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select class="select2 form-control" name ="this year" id="id_products" required>
                                        <option value="">Product</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <input  name="date-range" id="years" class="form-control years" />
                                </div>
                                {{-- <div id="revenueGrowth"></div> --}}
                            </div>
                            <div class="d-flex flex-column">
                                <h5 class="mt-4 mx-2" style="color:gray;">Revenues To Pay</h4>

                                    <div class="row mx-2">
                                        <div class="col-4">
                                            <div class="d-flex flex-column">
                                                <h4 style="color:black;"><span>{{ $countri->currency }}</span><br>
                                                    <span style="padding-left:40px;"><span
                                                            id="rev">{{ $sumrevenutopay }}</span>(<a
                                                            href="{{ route('leads.index') }}?confirmation%5B%5D=confirmed&livraison%5B%5D=delivered&payment=no paid"
                                                            id="countreve">{{ $countrevenutopay }}</a> Orders) </span>
                                                    <p style="padding-left:250px; color:rgb(255, 72, 0);"><i
                                                            class="fa-solid fa-coins fa-xl"></i></p>
                                                </h4>
                                                <p style="color:purple;"><i class="fa-solid fa-sort-down fa-lg"></i> Since
                                                    last month
                                                <p>

                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="col-4">
                                    <select id="sellerorder" class="select2 form-control years mx-2" name="seller">
                                        <option value="">seller</option>
                                        @foreach ($users as $v_user)
                                            <option value="{{ $v_user->id }}">{{ $v_user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select class="select2 form-control" name ="this year" id="id_productss" required>
                                        <option value="">Product</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <input  name="date-range" id="yearorders" class="form-control years" />
                                </div>
                                {{-- <div id="revenueGrowth"></div> --}}
                            </div>
                            <div class="d-flex flex-column">
                                <h5 class="mt-4 mx-2" style="color:gray;">Total Orders</h4>

                                    <div class="row mx-2">
                                        <div class="col-4">
                                            <div class="d-flex flex-column">

                                                <a href="{{ route('leads.index') }}"
                                                    id="totalorder">{{ $totalorder }}</a><a style="font-size:13px"> (
                                                    {{ $totalneworder }} New Order)</a>
                                                <p style="color:purple; padding-left:270px;"><i
                                                        class="fa-sharp fa-solid fa-bars-staggered fa-2xl"></i></p>
                                            </div>
                                        </div>


                                        <p style="color:purple;" class="mt-4"><i
                                                class="fa-solid fa-sort-down fa-lg"></i>
                                            Since last month
                                        <p>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="col-5">
                                    <select id="sellerproduct" class="select2 form-control years mx-2" name="seller">
                                        <option value="">seller</option>
                                        @foreach ($users as $v_user)
                                            <option value="{{ $v_user->id }}">{{ $v_user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <input  name="date-range" id="yearproduct" class="form-control years" />
                                </div>
                                {{-- <div id="revenueGrowth"></div> --}}
                            </div>
                            <div class="d-flex flex-column">
                                <h5 class="mt-4 mx-2" style="color:gray;">Total Products</h4>

                                    <div class="row mx-2">
                                        <div class="col-4">
                                            <div class="d-flex flex-column">
                                                <br>
                                                <a href="{{ route('products.index') }}"
                                                    id="countproduct">{{ $totalproduct }}</a>
                                                <p style="color:blue;padding-left:270px;"><i
                                                        class="fa-solid fa-box-open fa-2xl"></i></p>
                                            </div>
                                        </div>

                                        <p style="color:purple;" class="mt-4"><i
                                                class="fa-solid fa-sort-down fa-lg"></i>
                                            Since last month
                                        <p>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column">
                                <h5 class="mt-4 mx-2" style="color:gray;">Total Sellers</h4>

                                    <div class="row mx-2">
                                        <div class="col-4">
                                            <div class="d-flex flex-column">
                                                {{ $total_user }}<br>
                                                <h6 style="color:gray;">ACTIVE</h6>
                                                <p style="color:brown;padding-left:270px;"><i
                                                        class="fa-sharp fa-solid fa-users-line fa-xl"></i>
                                                <p>
                                            </div>
                                        </div>

                                        <p style="color:purple;" class="mt-4"><i
                                                class="fa-solid fa-sort-down fa-lg"></i>
                                            Since last month
                                        <p>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 style="padding:7px; color:black;"> Orders Summary</h4>
                            <div class="d-flex justify-content-between">
                                <div class="col-4">
                                    <select id="sellersummary" class="form-control select2 sellersummary" name="seller">
                                        <option value="">seller</option>
                                        @foreach ($users as $v_user)
                                            <option value="{{ $v_user->id }}">{{ $v_user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select class="form-control select2 sellersummary" name ="this year" id="id_produ"
                                        required>
                                        <option value="">Product</option>


                                    </select>
                                </div>
                                <div class="col-3">
                                    <input  name="date-range" id="datesummary" class="form-control years" />
                                </div>
                                {{-- <div id="revenueGrowth"></div> --}}
                            </div>
                            <div class="d-flex flex-column">
                                <h5 class="mt-4 mx-2" style="color:gray;"> <i class="fa-solid fa-headset fa-lg"></i>
                                    Callcenter / Rate</h4>

                                    <div class="row mx-2">
                                        <div class="col-12">
                                            <div class="row">

                                                <div class="col-xl-6 col-sm-12">
                                                    <div class="d-flex gap-2 align-items-center">
                                                        <div class="badge rounded bg-label-info p-1"><i
                                                                class="ti ti-check ti-sm"></i></div>
                                                        <h6 class="mb-0">Confirmed Orders</h6>
                                                    </div>
                                                    <h4 class="my-2 pt-1"> <span id="confirmed-order">{{ $rate[4] }}</span> <span
                                                            style="font-size: 15px">Order</span></h4>
                                                    <div class="progress w-75" style="height: 4px">
                                                        <div id="confirmedbar" class="progress-bar bg-info"
                                                            role="progressbar" style="width: {{ $rate[1] }}%" aria-valuenow="50"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span id="confirmedp"> {{ $rate[1] }} </span>%
                                                </div>
                                                <div class="col-xl-6 col-sm-12">
                                                    <div class="d-flex gap-2 align-items-center">
                                                        <div class="badge rounded bg-label-danger p-1">
                                                            <i class="ti ti-trash ti-sm"></i>
                                                        </div>
                                                        <h6 class="mb-0">Cancelled Orders</h6>
                                                    </div>
                                                    <h4 class="my-2 pt-1"> <span id="canceled-order">{{ $rate[2] }}</span> <span
                                                            style="font-size: 15px">Order</span></h4>
                                                    <div class="progress w-75" style="height: 4px">
                                                        <div id="canceledbar" class="progress-bar bg-danger"
                                                            role="progressbar" style="width: {{ $rate[3] }}%" aria-valuenow="65"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span id="canceledp"> {{ $rate[3] }} </span>%
                                                </div>
                                            </div>
                                        </div>

                                        <p style="color:purple;" class="mt-4"><i
                                                class="fa-solid fa-sort-down fa-lg"></i>
                                            Since last month
                                        <p>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 style="padding:7px; color:black;"> Shipping Summary</h4>
                            <div class="d-flex justify-content-between">
                                <div class="col-4">
                                    <select id="sellershipping" class="form-control select2 sellershipping"
                                        name="seller">
                                        <option value="">seller</option>
                                        @foreach ($users as $v_user)
                                            <option value="{{ $v_user->id }}">{{ $v_user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select class="form-control select2 sellershipping" name ="this year" id="id_prod"
                                        required>
                                        <option>Product</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <input  name="date-range" id="dateshipping" class="form-control years" />
                                </div>

                            </div>
                            <div class="d-flex flex-column">
                                <h5 class="mt-4 mx-2" style="color:gray;"> <i class="fa-solid fa-truck-fast fa-lg"></i>
                                    Delivery / Rate</h4>

                                    <div class="row mx-2">
                                        <div class="col-12">
                                            <div class="row">

                                                <div class="col-xl-4 col-sm-12">
                                                    <div class="d-flex gap-2 align-items-center">
                                                        <div class="badge rounded bg-label-info p-1"><i
                                                                class="ti ti-check ti-sm"></i></div>
                                                        <h6 class="mb-0">Processing Orders</h6>
                                                    </div>
                                                    <h4 class="my-2 pt-1"> <span id="processed-order">{{ $livrisonrate[1] }}</span> <span
                                                            style="font-size: 15px">Order</span></h4>
                                                    <div class="progress w-75" style="height: 4px">
                                                        <div id="processedbar" class="progress-bar bg-info"
                                                            role="progressbar" style="width: {{ $livrisonrate[0] }}%" aria-valuenow="50"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span id="processedp">{{ $livrisonrate[0] }} </span>%
                                                </div>
                                                <div class="col-xl-4 col-sm-12">
                                                    <div class="d-flex gap-2 align-items-center">
                                                        <div class="badge rounded bg-label-success p-1">
                                                            <i class="ti ti-trash ti-sm"></i>
                                                        </div>
                                                        <h6 class="mb-0">Delivered Orders</h6>
                                                    </div>
                                                    <h4 class="my-2 pt-1"> <span id="delivered-order">{{ $livrisonrate[3] }}</span> <span
                                                            style="font-size: 15px">Order</span></h4>
                                                    <div class="progress w-75" style="height: 4px">
                                                        <div id="delivredbar" class="progress-bar bg-success"
                                                            role="progressbar" style="width: {{ $livrisonrate[2] }}%" aria-valuenow="65"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span id="delivredp">{{ $livrisonrate[2] }} </span>%
                                                </div>

                                                <div class="col-xl-4 col-sm-12">
                                                    <div class="d-flex gap-2 align-items-center">
                                                        <div class="badge rounded bg-label-danger p-1">
                                                            <i class="ti ti-trash ti-sm"></i>
                                                        </div>
                                                        <h6 class="mb-0">Return Orders</h6>
                                                    </div>
                                                    <h4 class="my-2 pt-1"> <span id="return-order">{{ $livrisonrate[5] }}</span> <span
                                                            style="font-size: 15px">Order</span></h4>
                                                    <div class="progress w-75" style="height: 4px">
                                                        <div id="returnedbar" class="progress-bar bg-danger"
                                                            role="progressbar" style="width: {{ $livrisonrate[4] }}%" aria-valuenow="65"
                                                            aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <span id="returnedp">{{ $livrisonrate[4] }} </span>%
                                                </div>
                                            </div>
                                        </div>

                                        <p style="color:purple;" class="mt-4"><i
                                                class="fa-solid fa-sort-down fa-lg"></i>
                                            Since last month
                                        <p>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 style="padding:7px; color:black;"> Confirmation By Time</h4>
                            <div class="d-flex justify-content-between">

                                <div id="time" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 style="padding:7px; color:black;"> Statistics Confirmation Leads Year</h4>
                            <div class="d-flex justify-content-between">

                                <div id="canvas" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 style="padding:7px; color:black;"> Statistics Delivery Orders Year</h4>
                            <div class="d-flex justify-content-between">

                                <div id="canvas2" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 style="padding:7px; color:black;">Statistics Confirmation Products</h4>
                            <div class="d-flex justify-content-between">

                                <div id="confirmation" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->

        <!-- Footer -->
        <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl">

            </div>
        </footer>
        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->


    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
  
 

    <script type="text/javascript">
        var options = {
            series: [{
                name: "Total Confirmation by Hour",
                data: [
                    @foreach ($time as $v_count)
                        "{{ $v_count->count }}",
                    @endforeach
                ]
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            labels: [
                @foreach ($time as $v_count)
                    "{{ $v_count->hour }}",
                @endforeach
            ],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            title: {
                text: 'Total Confirmation by Hour',
                align: 'center'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'],
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: ['', '', '', '', '', '', '', '', ''],
            },
            
        };

        var chart = new ApexCharts(document.getElementById("time"), options);
        chart.render();
    </script>
    <script>
        var options = {
            series: [{
                    name: "Confirmed",
                    data: [
                        {{ $thismonth[1] }}, {{ $lastmonth[1] }}, {{ $lasttwomonth[1] }},
                        {{ $lastthreemonth[1] }}, {{ $lastforemonth[1] }}, {{ $lastfivemonth[1] }},
                        {{ $lastsixmonth[1] }}, {{ $lastsivenmonth[1] }}, {{ $lasteightemonth[1] }},
                        {{ $lastninemonth[1] }}, {{ $lastteenmonth[1] }}
                    ]
                },
                {
                    name: "Cancelled",
                    data: [
                        {{ $thismonth[2] }}, {{ $lastmonth[2] }}, {{ $lasttwomonth[2] }},
                        {{ $lastthreemonth[2] }}, {{ $lastforemonth[2] }}, {{ $lastfivemonth[2] }},
                        {{ $lastsixmonth[2] }}, {{ $lastsivenmonth[2] }}, {{ $lasteightemonth[2] }},
                        {{ $lastninemonth[2] }}, {{ $lastteenmonth[2] }}
                    ]
                }
            ],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            labels: [
                'confirmed', 'cancelled'
            ],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            // title: {
            //     text: 'Total Confirmation by Hour',
            //     align: 'left'
            // },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'],
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: ["{{ $thismonth[0] }}", "{{ $lastmonth[0] }}", "{{ $lasttwomonth[0] }}",
                    "{{ $lastthreemonth[0] }}", "{{ $lastforemonth[0] }}", "{{ $lastfivemonth[0] }}",
                    "{{ $lastsixmonth[0] }}", "{{ $lastsivenmonth[0] }}", "{{ $lasteightemonth[0] }}",
                    "{{ $lastninemonth[0] }}", "{{ $lastteenmonth[0] }}"
                ],
            }
        };

        var chart = new ApexCharts(document.getElementById("canvas"), options);
        chart.render();
    </script>
    <script>
        var options = {
            series: [{
                    name: "Delivered",
                    data: [
                        {{ $thismonth[3] }}, {{ $lastmonth[3] }}, {{ $lasttwomonth[3] }},
                        {{ $lastthreemonth[3] }}, {{ $lastforemonth[3] }}, {{ $lastfivemonth[3] }},
                        {{ $lastsixmonth[3] }}, {{ $lastsivenmonth[3] }}, {{ $lasteightemonth[3] }},
                        {{ $lastninemonth[3] }}, {{ $lastteenmonth[3] }}
                    ]
                },
                {
                    name: "Returned",
                    data: [
                        {{ $thismonth[4] }}, {{ $lastmonth[4] }}, {{ $lasttwomonth[4] }},
                        {{ $lastthreemonth[4] }}, {{ $lastforemonth[4] }}, {{ $lastfivemonth[4] }},
                        {{ $lastsixmonth[4] }}, {{ $lastsivenmonth[4] }}, {{ $lasteightemonth[4] }},
                        {{ $lastninemonth[4] }}, {{ $lastteenmonth[4] }}
                    ]
                }
            ],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            labels: [
                'confirmed', 'cancelled'
            ],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },

            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'],
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: ["{{ $thismonth[0] }}", "{{ $lastmonth[0] }}", "{{ $lasttwomonth[0] }}",
                    "{{ $lastthreemonth[0] }}", "{{ $lastforemonth[0] }}", "{{ $lastfivemonth[0] }}",
                    "{{ $lastsixmonth[0] }}", "{{ $lastsivenmonth[0] }}", "{{ $lasteightemonth[0] }}",
                    "{{ $lastninemonth[0] }}", "{{ $lastteenmonth[0] }}"
                ],
            }
        };

        var chart = new ApexCharts(document.getElementById("canvas2"), options);
        chart.render();
    </script>
    <?php
    ?>
   
    <script>
        $(function() {
            $("#yearproduct").datepicker({
                dateFormat: 'yy'
            });
            
        });​  
    </script>
    <!-- chart order -->

    <!-- script chart top products end-->
    <script>
        $(document).ready(function() {
            $(function(e) {
                $('#id_users').on('change', function(e) {
                    // Department id
                    var id = $("#id_users").val();

                    // Empty the dropdown
                    $('#id_products').find('option').not(':first').remove();
                    //console.log(id);
                    // AJAX request 
                    $.ajax({
                        url: 'products/' + id,
                        type: 'get',
                        dataType: 'json',
                        success: function(response) {

                            var len = 0;
                            if (response['data'] != null) {
                                len = response['data'].length;
                            }

                            if (len > 0) {
                                $("#id_products").empty();
                                // Read data and create <option >
                                var optiones =
                                    "<option value=' '>Select Product</option>";
                                $("#id_products").append(optiones);
                                for (var i = 0; i < len; i++) {
                                    var id = response['data'][i].id;
                                    var name = response['data'][i].name;
                                    var option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                    $("#id_products").append(option);
                                }
                            }
                        }
                    });
                });
                //revenue to pay
                $('#yearorder').on('change', function(e) {
                    var year = $("#yearorder").val();
                    var seller = $("#id_users").val();
                    var product = $('#id_products').val();
                    //console.log(id);
                    // AJAX request 
                    $.ajax({
                        url: '{{ route('leads.countrevenu') }}',
                        type: 'post',
                        cache: false,
                        data: {
                            year: year,
                            seller: seller,
                            product: product,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) { //alert(response[0][1]);
                            $("#countreve").empty();
                            $("#countreve").append(response[0][1]);
                            $("#rev").empty();
                            $("#rev").append(response[0][0]);

                        }
                    });
                });
                //total product
                $('.yearproduct').on('change', function(e) {
                    var year = $("#yearproduct").val();
                    var seller = $("#sellerproduct").val();
                    //console.log(id);
                    // AJAX request 
                    $.ajax({
                        url: 'countproduct',
                        type: 'post',
                        data: {

                            seller: seller,
                            year: year,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#countproduct").empty();
                            $("#countproduct").append(response);

                        }
                    });
                });
                //////totalprocessed
                $('#processyear').on('change', function(e) { //alert('oo');
                    var year = $("#processyear").val();
                    var seller = $("#processseller").val();
                    //console.log(id);
                    // AJAX request 
                    $.ajax({
                        url: 'processed',
                        type: 'post',
                        data: {

                            seller: seller,
                            year: year,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) { //dd(response);
                            $("#proccesscount").empty();
                            $("#proccesscount").append(response[0][0]);
                            $("#proccesssum").empty();
                            $("#proccesssum").append(response[0][1]);
                        }
                    });
                });
                /////total revenues and fees
                $('.years').on('change', function(e) {
                    var year = $("#years").val();
                    var seller = $("#seller").val();
                    //console.log(id);
                    // AJAX request 
                    $.ajax({
                        url: 'totalrevenue',
                        type: 'post',
                        data: {

                            seller: seller,
                            year: year,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            //alert(response);
                            $("#order").empty();
                            $("#order").append(response[0][0]);
                            $("#countrev").empty();
                            $("#countrev").append(response[0][1]);
                            $("#trev").empty();
                            $("#trev").append(response[0][2]);
                        }
                    });
                });

                $('#processproducts').on('change', function(e) {
                    var seller = $('#processseller').val();
                    var product = $('#processproduct').val();
                });

                $('#processseller').on('change', function(e) {
                    var seller = $('#processseller').val();
                    $.ajax({
                        url: 'products/' + seller,
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

                                    var option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                    $("#processproducts").append(option);
                                }
                            }

                        }
                    });

                });
                $('#sellerorder').on('change', function(e) {
                    var id = $('#sellerorder').val();
                    //console.log(id);
                    // AJAX request 
                    $.ajax({
                        url: 'products/' + id,
                        type: 'get',
                        dataType: 'json',
                        success: function(response) {

                            var len = 0;
                            if (response['data'] != null) {
                                len = response['data'].length;
                            }

                            if (len > 0) {
                                $("#id_productss").empty();
                                // Read data and create <option >
                                var options =
                                    "<option value=' '>Select Product</option>";
                                $("#id_productss").append(options);
                                for (var i = 0; i < len; i++) {

                                    var id = response['data'][i].id;
                                    var name = response['data'][i].name;

                                    var option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                    $("#id_productss").append(option);
                                }
                            }

                        }
                    });
                });

                $('#sellersummary').on('change', function(e) {
                    var id = $('#sellersummary').val();
                    //console.log(id);
                    // AJAX request 
                    $.ajax({
                        url: 'products/' + id,
                        type: 'get',
                        dataType: 'json',
                        success: function(response) {

                            var len = 0;
                            if (response['data'] != null) {
                                len = response['data'].length;
                            }

                            if (len > 0) {
                                $("#id_produ").empty();
                                // Read data and create <option >
                                var options =
                                    "<option value=''>Select Product</option>";
                                $("#id_produ").append(options);
                                for (var i = 0; i < len; i++) {
                                    var id = response['data'][i].id;
                                    var name = response['data'][i].name;
                                    var option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                    $("#id_produ").append(option);
                                }
                            }

                        }
                    });
                });
                //Callcenter / Rate
                $('.sellersummary').on('change', function(e) {
                    var date = $("#datesummary").val();
                    var seller = $("#sellersummary").val();
                    var product = $('#id_produ').val();
                    //console.log(id);
                    // AJAX request 
                    $.ajax({
                        url: 'confirmation',
                        type: 'post',
                        cache: false,
                        data: {
                            date: date,
                            seller: seller,
                            product: product,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#confirmed-order").empty();
                            $("#confirmed-order").append(response[0]);
                            $("#confirmedp").empty();
                            $("#confirmedp").append(response[1]);
                            $("#confirmedbar").css("width", response[1] + "%");
                            $("#canceled-order").empty();
                            $("#canceled-order").append(response[2]);
                            $("#canceledp").empty();
                            $("#canceledp").append(response[3]);
                            $("#canceledbar").css("width", response[3] + "%");
                        }
                    });
                });
                $('#sellershipping').on('change', function(e) {
                    var id = $('#sellershipping').val();
                    //console.log(id);
                    // AJAX request 
                    $.ajax({
                        url: 'products/' + id,
                        type: 'get',
                        dataType: 'json',
                        success: function(response) {

                            var len = 0;
                            if (response['data'] != null) {
                                len = response['data'].length;
                            }

                            if (len > 0) {
                                $("#id_prod").empty();
                                // Read data and create <option >
                                var options =
                                    "<option value=''>Select Product</option>";
                                $("#id_prod").append(options);
                                for (var i = 0; i < len; i++) {

                                    var id = response['data'][i].id;
                                    var name = response['data'][i].name;

                                    var option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                    $("#id_prod").append(option);
                                }
                            }

                        }
                    });
                });
                //Livraison / Rate
                $('.sellershipping').on('change', function(e) {
                    var date = $("#dateshipping").val();
                    var seller = $("#sellershipping").val();
                    var product = $('#id_prod').val();
                    //console.log(id);
                    // AJAX request 
                    $.ajax({
                        url: 'shipping',
                        type: 'post',
                        cache: false,
                        data: {
                            date: date,
                            seller: seller,
                            product: product,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) { //alert(response[0][1]);
                            $("#processed-order").empty();
                            $("#processed-order").append(response[0]);
                            $("#processedp").empty();
                            $("#processedp").append(response[1]);
                            $("#processedbar").css("width", response[1] + "%");
                            $("#delivered-order").empty();
                            $("#delivered-order").append(response[2]);
                            $("#delivredp").empty();
                            $("#delivredp").append(response[3]);
                            $("#delivredbar").css("width", response[3] + "%");
                            $("#return-order").empty();
                            $("#return-order").append(response[4]);
                            $("#returnedp").empty();
                            $("#returnedp").append(response[5]);
                            $("#returnedbar").css("width", response[5] + "%");
                        }
                    });
                });
                //Total Orders
                $('#yearorders').on('change', function(e) {
                    var year = $('#yearorders').val();
                    var seller = $("#sellerorder").val();
                    var product = $('#id_productss').val();
                    //alert('mm');
                    //console.log(id);
                    // AJAX request 
                    $.ajax({
                        url: 'totalorder',
                        type: 'post',
                        data: {
                            year: year,
                            seller: seller,
                            product: product,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $("#totalorder").empty();
                            $("#totalorder").append(response);

                        }
                    });
                });
                ///////////
                $('#id_users').on('change', function(e) {
                    var id = $('#id_users').val();
                    $('#id_products').find('option').not(':first').remove();
                    //console.log(id);
                    // AJAX request 
                    $.ajax({
                        url: 'products/' + id,
                        type: 'get',
                        dataType: 'json',
                        success: function(response) {

                            var len = 0;
                            if (response['data'] != null) {
                                len = response['data'].length;
                            }

                            if (len > 0) {
                                $("#id_products").empty();
                                // Read data and create <option >
                                for (var i = 0; i < len; i++) {

                                    var id = response['data'][i].id;
                                    var name = response['data'][i].name;

                                    var option = "<option value='" + id + "'>" + name +
                                        "</option>";
                                    $("#id_products").append(option);
                                }
                            }

                        }
                    });
                });
                ///////////
            });

            $(function(e) {
                $('#datedeli').click(function(e) {
                    var idlead = $('#lead_id').val();
                    var date = $('#date_delivred').val()
                    //console.log(namecustomer);
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('leads.date') }}',
                        cache: false,
                        data: {
                            id: idlead,
                            date: date,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                $('#datedeli').modal('hide');
                                toastr.success('Good Job.',
                                    'Lead Has been Update Success!', {
                                        "showMethod": "slideDown",
                                        "hideMethod": "slideUp",
                                        timeOut: 2000
                                    });
                            }
                        }
                    });
                });
            });
        });
        $(document).ready(function() {
            $("#seller_name").select2({
                dropdownParent: $("#add-contac")
            });

        });
        
    </script>
    <script>
        $(function() {
            // Initialize the date range picker
            $('input[name="date-range"]').daterangepicker();
           
            // Update the input field when a date range is selected
            $('input[name="date-range"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });
    
            // Clear the input field when the user clicks "Clear"
            $('input[name="date-range"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
@endsection
