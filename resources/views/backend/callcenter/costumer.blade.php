@extends('backend.layouts.app')
@section('content')
    <style>
        .chartjs {
            height: 366px !important;
        }
    </style>

  

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-8 align-self-center ">
                        <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                class="text-muted fw-light">Dashboard /</span> Analyses Costumers&nbsp;

                        </h4>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h3>Confirmation Data</h3>
                </div>
                <!-- Cards with few info -->
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">{{ $total }}</h5>
                                <small>Total Leads</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-primary rounded-pill p-2">
                                    <i class="ti ti-cpu ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">{{ $new }}</h5>
                                <small>Total New Leads</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-warning rounded-pill p-2">
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
                                <h5 class="mb-0 me-2">{{ $confirmed }}</h5>
                                <small>Total leads Confirmed</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-success rounded-pill p-2">
                                    <i class="ti ti-server ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">{{ $rejected }}</h5>
                                <small>Total Leads Canceled</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-danger rounded-pill p-2">
                                    <i class="ti ti-chart-pie-2 ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">{{ $canceledbysysteme }}</h5>
                                <small>Total Leads Canceled By System</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-danger rounded-pill p-2">
                                    <i class="ti ti-chart-pie-2 ti-sm"></i>
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
                                <h5 class="mb-0 me-2">{{ $duplicated }}</h5>
                                <small>Total Leads Duplicated</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-primary rounded-pill p-2">
                                    <i class="ti ti-cpu ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">{{ $outofstock }}</h5>
                                <small>Total Leads Out Of Stock</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-success rounded-pill p-2">
                                    <i class="ti ti-server ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">{{ $wrong }}</h5>
                                <small>Total leads Wrong</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-danger rounded-pill p-2">
                                    <i class="ti ti-chart-pie-2 ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">{{ $noanswer }}</h5>
                                <small>Total Leads No Answer</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-warning rounded-pill p-2">
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
                                <h5 class="mb-0 me-2">{{ $call }}</h5>
                                <small>Total Leads Call Later</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-warning rounded-pill p-2">
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
                                <h5 class="mb-0 me-2">{{ $area }}</h5>
                                <small>Total Leads Out Of Area</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-warning rounded-pill p-2">
                                    <i class="ti ti-alert-octagon ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 ">
                    <div class="card">
                        <div class="row card-header d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-0">CALL CENTER</h5>
                                <small class="text-muted">Call Center Overivew</small>
                            </div>

                            <form class=" align-items-center">
                                <div class="row mb-4">
                                    <div class="col-lg-5 col-md-10">
                                        <div class="dl">
                                            <div class="col-12 align-self-center">
                                                <div class='input-group '>
                                                    <input type='text' class="form-control flatpickr-input active"
                                                        name="date_call" value="{{ request()->input('date_call') }}"
                                                        placeholder="YYYY-MM-DD to YYYY-MM-DD" id="flatpickr-range"
                                                        readonly="readonly" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row col-lg-5 col-md-10">
                                        <div class="dl w-100">
                                            <select class="form-control" name="call_product" style="width:100%">
                                                <option value="" selected>Product</option>
                                                @foreach ($products as $v_product)
                                                    <option value="{{ $v_product->id }}"
                                                        {{ $v_product->id == request()->input('call_product') ? 'selected' : '' }}>
                                                        {{ $v_product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row col-lg-2 col-md-10">
                                        <div class="align-items-center">
                                            <div class="dl">
                                                <button class="btn btn-primary input-group-append"
                                                    type="submit">APPLY</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <!-- Polar Area Chart -->
                            <div class="col-md-6 mb-4">
                                <div class="card-body">
                                    <div id="donutCharts"></div>
                                </div>
                            </div>
                            <!-- /Polar Area Chart -->
                            <!-- Polar Area Chart -->
                            <div class="col-md-6 mb-4">
                                <div class="card-body">
                                    <div id="donutChartt"></div>
                                </div>
                            </div>
                            <!-- /Polar Area Chart -->
                        </div>
                    </div>
                </div>

                <!--- shipping -->

                <div class="col-12">
                    <h3>Shipping Data</h3>
                </div>

                <!-- Cards with few info -->
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">{{ $orders }}</h5>
                                <small>Total Orders</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-primary rounded-pill p-2">
                                    <i class="ti ti-cpu ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">{{ $chartunpacked }}</h5>
                                <small>Total Orders Unpacked</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-warning rounded-pill p-2">
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
                                <h5 class="mb-0 me-2">{{ $chartpicking }}</h5>
                                <small>Total Orders Picking Proccess</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-warning rounded-pill p-2">
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
                                <h5 class="mb-0 me-2">{{ $chartpacked }}</h5>
                                <small>Total Orders Packed</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-warning rounded-pill p-2">
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
                                <h5 class="mb-0 me-2">{{ $chartshipped }}</h5>
                                <small>Total Orders Shipped</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-warning rounded-pill p-2">
                                    <i class="ti ti-server ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <h5 class="mb-0 me-2">{{ $charttransit }}</h5>
                                <small>Total Orders In Transit</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-warning rounded-pill p-2">
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
                                <h5 class="mb-0 me-2">{{ $chartindelivery }}</h5>
                                <small>Total Orders In Delivery</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-warning rounded-pill p-2">
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
                                <h5 class="mb-0 me-2">{{ $chartincident }}</h5>
                                <small>Total Orders Incident</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-warning rounded-pill p-2">
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
                                <h5 class="mb-0 me-2">{{ $chartdelivered }}</h5>
                                <small>Total Orders Delivered</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-success rounded-pill p-2">
                                    <i class="ti ti-chart-pie-2 ti-sm"></i>
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
                                <h5 class="mb-0 me-2">{{ $chartcanceled }}</h5>
                                <small>Total Orders Rejected</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-warning rounded-pill p-2">
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
                                <h5 class="mb-0 me-2">{{ $chartreturned }}</h5>
                                <small>Total Orders Returned</small>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-label-primary rounded-pill p-2">
                                    <i class="ti ti-cpu ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 ">
                    <div class="card">
                        <div class="row card-header d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="card-title mb-0">DELIVERY RATE</h5>
                                <small class="text-muted">Shipping Overivew</small>
                            </div>

                            <form class=" align-items-center">
                                <div class="row mb-4">
                                    <div class="col-lg-3 col-md-10">
                                        <div class="dl">
                                            <div class="col-12 align-self-center">
                                                <div class='input-group '>
                                                    <input type="text" class="form-control flatpickr-inputs active"
                                                        name="date_shipped" value="{{ request()->input('date_shipped') }}"
                                                        placeholder="YYYY-MM-DD to YYYY-MM-DD" id="flatpickr-ranges"
                                                        readonly="readonly" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="row col-lg-3 col-md-10">
                                        <div class="dl w-100">
                                            <select class="form-control" name="shipped_product" style="width:100%">
                                                <option value="" selected>Product</option>
                                                @foreach ($products as $v_product)
                                                    <option value="{{ $v_product->id }}"
                                                        {{ $v_product->id == request()->input('shipped_product') ? 'selected' : '' }}>
                                                        {{ $v_product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row col-lg-3 col-md-10">
                                        <div class="dl w-100">
                                            <select class="form-control" name="seller" style="width:100%">
                                                <option value="" selected>Costumer</option>
                                                @foreach ($costumers as $v_seller)
                                                    <option value="{{ $v_seller->id }}"
                                                        {{ $v_seller->id == request()->input('shipped_product') ? 'selected' : '' }}>
                                                        {{ $v_seller->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row col-lg-2 col-md-10">
                                        <div class="align-items-center">
                                            <div class="dl">
                                                <button class="btn btn-primary input-group-append"
                                                    type="submit">APPLY</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <!-- Polar Area Chart -->
                            <div class="col-md-6 mb-4">
                                <div class="card-body">
                                    <div id="polarChartt"></div>
                                </div>
                            </div>
                            <!-- /Polar Area Chart -->
                            <!-- Radar Chart -->
                            <div class="col-md-6 col-12 mb-4">
                                <div class="">
                                    <div class="card-body">
                                        <div id="polarCharts"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Radar Chart -->
                        </div>
                    </div>
                </div>

              
            </div>

        </div>
    <!-- / Content -->


    <!-- Footer -->

@section('script')
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
    <script src="{{ asset('public/assets/js/chart/morris-chart/raphael.js')}}"></script>
    <script src="{{ asset('public/assets/js/chart/morris-chart/morris.js')}}"> </script>
    <script src="{{ asset('public/assets/js/chart/morris-chart/prettify.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/chart/morris-chart/morris-script.js')}}"></script>
    <script src="{{ asset('public/assets/js/tooltip-init.js')}}"></script>

    <script src="{{ asset('public/assets/js/vector-map/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/vector-map/map/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{ asset('public/assets/js/vector-map/map/jquery-jvectormap-us-aea-en.js')}}"></script>
    <script src="{{ asset('public/assets/js/vector-map/map/jquery-jvectormap-uk-mill-en.js')}}"></script>
    <script src="{{ asset('public/assets/js/vector-map/map/jquery-jvectormap-au-mill.js')}}"></script>
    <script src="{{ asset('public/assets/js/vector-map/map/jquery-jvectormap-chicago-mill-en.js')}}"></script>
    <script src="{{ asset('public/assets/js/vector-map/map/jquery-jvectormap-in-mill.js')}}"></script>
    <script src="{{ asset('public/assets/js/vector-map/map/jquery-jvectormap-asia-mill.js')}}"></script>

    {{-- <script>
        /**
         * Charts Apex
         */

        'use strict';

        (function() {
            let cardColor, headingColor, labelColor, borderColor, legendColor;

            if (isDarkStyle) {
                cardColor = config.colors_dark.cardColor;
                headingColor = config.colors_dark.headingColor;
                labelColor = config.colors_dark.textMuted;
                legendColor = config.colors_dark.bodyColor;
                borderColor = config.colors_dark.borderColor;
            } else {
                cardColor = config.colors.cardColor;
                headingColor = config.colors.headingColor;
                labelColor = config.colors.textMuted;
                legendColor = config.colors.bodyColor;
                borderColor = config.colors.borderColor;
            }

            // Color constant
            const chartColors = {
                column: {
                    series1: '#826af9',
                    series2: '#d2b0ff',
                    bg: '#f8d3ff'
                },
                donut: {
                    series1: '#fee802',
                    series4: '#2b9bf4',
                    series5: '#ff0000',
                    series6: '#f2ca00',
                    series7: '#f87a0c',
                    series8: '#7e7e7e',
                    series9: '#d9abda',
                    series2: '#3fd0bd',
                    series3: '#826bf8',
                    series10: '#2201ff',
                    series11: '#000',
                },
                area: {
                    series1: '#29dac7',
                    series2: '#60f2ca',
                    series3: '#a5f8cd',
                    series5: '#ff0000',
                    series6: '#f2ca00',
                    series7: '#f87a0c',
                    series8: '#7e7e7e',
                    series9: '#d9abda',
                    series10: '#2201ff',
                    series7: '#f87a0c',
                }
            };


            // Donut Chart
            // --------------------------------------------------------------------
            const donutChartEl = document.querySelector('#polarCharts'),
                donutChartConfig = {
                    chart: {
                        height: 390,
                        type: 'donut'
                    },
                    labels: ['Delivered', 'Returned'],
                    series: [{{ $chartdelivered }}, {{ $chartreturned }}],
                    colors: [
                        chartColors.donut.series2,
                        chartColors.donut.series11
                    ],
                    stroke: {
                        show: false,
                        curve: 'straight'
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opt) {
                            return parseInt(val, 10) + '%';
                        }
                    },
                    legend: {
                        show: true,
                        position: 'bottom',
                        markers: {
                            offsetX: -3
                        },
                        itemMargin: {
                            vertical: 3,
                            horizontal: 10
                        },
                        labels: {
                            colors: legendColor,
                            useSeriesColors: false
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                    name: {
                                        fontSize: '2rem',
                                        fontFamily: 'Open Sans'
                                    },
                                    value: {
                                        fontSize: '1.2rem',
                                        color: legendColor,
                                        fontFamily: 'Open Sans',
                                        formatter: function(val) {
                                            return parseInt(val, 10);
                                        }
                                    },
                                    total: {
                                        show: false,
                                        fontSize: '1.5rem',
                                        color: headingColor,
                                        label: 'Operational',
                                        formatter: function(w) {
                                            return '42%';
                                        }
                                    }
                                }
                            }
                        }
                    },
                    responsive: [{
                            breakpoint: 992,
                            options: {
                                chart: {
                                    height: 380
                                },
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        colors: legendColor,
                                        useSeriesColors: false
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 576,
                            options: {
                                chart: {
                                    height: 320
                                },
                                plotOptions: {
                                    pie: {
                                        donut: {
                                            labels: {
                                                show: true,
                                                name: {
                                                    fontSize: '1.5rem'
                                                },
                                                value: {
                                                    fontSize: '1rem'
                                                },
                                                total: {
                                                    fontSize: '1.5rem'
                                                }
                                            }
                                        }
                                    }
                                },
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        colors: legendColor,
                                        useSeriesColors: false
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 420,
                            options: {
                                chart: {
                                    height: 280
                                },
                                legend: {
                                    show: false
                                }
                            }
                        },
                        {
                            breakpoint: 360,
                            options: {
                                chart: {
                                    height: 250
                                },
                                legend: {
                                    show: false
                                }
                            }
                        }
                    ]
                };
            if (typeof donutChartEl !== undefined && donutChartEl !== null) {
                const donutChart = new ApexCharts(donutChartEl, donutChartConfig);
                donutChart.render();
            }
        })();
    </script> --}}
    {{-- <script>
        /**
         * Charts Apex
         */

        'use strict';

        (function() {
            let cardColor, headingColor, labelColor, borderColor, legendColor;

            if (isDarkStyle) {
                cardColor = config.colors_dark.cardColor;
                headingColor = config.colors_dark.headingColor;
                labelColor = config.colors_dark.textMuted;
                legendColor = config.colors_dark.bodyColor;
                borderColor = config.colors_dark.borderColor;
            } else {
                cardColor = config.colors.cardColor;
                headingColor = config.colors.headingColor;
                labelColor = config.colors.textMuted;
                legendColor = config.colors.bodyColor;
                borderColor = config.colors.borderColor;
            }

            // Color constant
            const chartColors = {
                column: {
                    series1: '#826af9',
                    series2: '#d2b0ff',
                    bg: '#f8d3ff'
                },
                donut: {
                    series1: '#fee802',
                    series4: '#2b9bf4',
                    series5: '#ff0000',
                    series6: '#f2ca00',
                    series7: '#f87a0c',
                    series8: '#7e7e7e',
                    series9: '#d9abda',
                    series2: '#3fd0bd',
                    series3: '#826bf8',
                    series10: '#2201ff',
                    series11: '#000',
                    seria12: '#3e9efa',
                },
                area: {
                    series1: '#29dac7',
                    series2: '#60f2ca',
                    series3: '#a5f8cd',
                    series5: '#ff0000',
                    series6: '#f2ca00',
                    series7: '#f87a0c',
                    series8: '#7e7e7e',
                    series9: '#d9abda',
                    series10: '#2201ff',
                    series7: '#f87a0c',
                }
            };


            // Donut Chart
            // --------------------------------------------------------------------
            const donutChartEl = document.querySelector('#polarChartt'),
                donutChartConfig = {
                    chart: {
                        height: 390,
                        type: 'donut'
                    },
                    labels: ['Unpacked', 'Picking Proccess', 'Item Packed', 'shipped', 'In Transit', 'In Delivery',
                        'Incident', 'Delivered', 'Rejected', 'Returned'
                    ],
                    series: [{{ $chartunpacked }}, {{ $chartpicking }}, {{ $chartpacked }}, {{ $chartshipped }},
                        {{ $charttransit }}, {{ $chartindelivery }}, {{ $chartincident }},
                        {{ $chartdelivered }}, {{ $chartcanceled }}, {{ $chartreturned }}
                    ],
                    colors: [
                        chartColors.donut.series6,
                        chartColors.donut.series4,
                        chartColors.donut.series7,
                        chartColors.donut.seria12,
                        chartColors.donut.series10,
                        chartColors.donut.series8,
                        chartColors.donut.series9,
                        chartColors.donut.series2,
                        chartColors.donut.series5,
                        chartColors.donut.series11
                    ],
                    stroke: {
                        show: false,
                        curve: 'straight'
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opt) {
                            return parseInt(val, 10) + '%';
                        }
                    },
                    legend: {
                        show: true,
                        position: 'bottom',
                        markers: {
                            offsetX: -3
                        },
                        itemMargin: {
                            vertical: 3,
                            horizontal: 10
                        },
                        labels: {
                            colors: legendColor,
                            useSeriesColors: false
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                    name: {
                                        fontSize: '2rem',
                                        fontFamily: 'Open Sans'
                                    },
                                    value: {
                                        fontSize: '1.2rem',
                                        color: legendColor,
                                        fontFamily: 'Open Sans',
                                        formatter: function(val) {
                                            return parseInt(val, 10);
                                        }
                                    },
                                    total: {
                                        show: false,
                                        fontSize: '1.5rem',
                                        color: headingColor,
                                        label: 'Operational',
                                        formatter: function(w) {
                                            return '42%';
                                        }
                                    }
                                }
                            }
                        }
                    },
                    responsive: [{
                            breakpoint: 992,
                            options: {
                                chart: {
                                    height: 380
                                },
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        colors: legendColor,
                                        useSeriesColors: false
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 576,
                            options: {
                                chart: {
                                    height: 320
                                },
                                plotOptions: {
                                    pie: {
                                        donut: {
                                            labels: {
                                                show: true,
                                                name: {
                                                    fontSize: '1.5rem'
                                                },
                                                value: {
                                                    fontSize: '1rem'
                                                },
                                                total: {
                                                    fontSize: '1.5rem'
                                                }
                                            }
                                        }
                                    }
                                },
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        colors: legendColor,
                                        useSeriesColors: false
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 420,
                            options: {
                                chart: {
                                    height: 280
                                },
                                legend: {
                                    show: false
                                }
                            }
                        },
                        {
                            breakpoint: 360,
                            options: {
                                chart: {
                                    height: 250
                                },
                                legend: {
                                    show: false
                                }
                            }
                        }
                    ]
                };
            if (typeof donutChartEl !== undefined && donutChartEl !== null) {
                const donutChart = new ApexCharts(donutChartEl, donutChartConfig);
                donutChart.render();
            }
        })();
    </script> --}}
    <script>
        /**
         * Charts Apex
         */

        'use strict';

        (function() {
            let cardColor, headingColor, labelColor, borderColor, legendColor;

            if (isDarkStyle) {
                cardColor = config.colors_dark.cardColor;
                headingColor = config.colors_dark.headingColor;
                labelColor = config.colors_dark.textMuted;
                legendColor = config.colors_dark.bodyColor;
                borderColor = config.colors_dark.borderColor;
            } else {
                cardColor = config.colors.cardColor;
                headingColor = config.colors.headingColor;
                labelColor = config.colors.textMuted;
                legendColor = config.colors.bodyColor;
                borderColor = config.colors.borderColor;
            }

            // Color constant
            const chartColors = {
                column: {
                    series1: '#826af9',
                    series2: '#d2b0ff',
                    bg: '#f8d3ff'
                },
                donut: {
                    series1: '#fee802',
                    series2: '#3fd0bd',
                    series3: '#826bf8',
                    series4: '#2b9bf4',
                    series5: '#ff0000',
                    series6: '#f2ca00',
                    series7: '#f87a0c',
                    series8: '#7e7e7e',
                    series9: '#d9abda',
                    series10: '#2201ff',
                },
                area: {
                    series1: '#29dac7',
                    series2: '#60f2ca',
                    series3: '#a5f8cd',
                    series5: '#ff0000',
                    series6: '#f2ca00',
                    series7: '#f87a0c',
                    series8: '#7e7e7e',
                    series9: '#d9abda',
                    series10: '#2201ff',
                    series7: '#f87a0c',
                }
            };


            // Donut Chart
            // --------------------------------------------------------------------
            const donutChartEl = document.querySelector('#donutCharts'),
                donutChartConfig = {
                    chart: {
                        height: 390,
                        type: 'donut'
                    },
                    labels: ['New Lead', 'Confirmed', 'No Answer', 'Call Later', 'Canceled', 'Duplicated', 'Wrong Data',
                        'Out Of Area', 'Canceled by system'
                    ],
                    series: [{{ $chartnew }}, {{ $chartconfirmed }}, {{ $chartnoanswer }}, {{ $chartcall }},
                        {{ $chartrejected }}, {{ $chartduplicated }}, {{ $chartwrong }}, {{ $chartarea }},
                        {{ $chartcanceledbysestem }}
                    ],
                    colors: [
                        chartColors.donut.series4,
                        chartColors.donut.series2,
                        chartColors.donut.series6,
                        chartColors.donut.series7,
                        chartColors.donut.series5,
                        chartColors.donut.series8,
                        chartColors.donut.series9,
                        chartColors.donut.series10
                    ],
                    stroke: {
                        show: false,
                        curve: 'straight'
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opt) {
                            return parseInt(val, 10) + '%';
                        }
                    },
                    legend: {
                        show: true,
                        position: 'bottom',
                        markers: {
                            offsetX: -3
                        },
                        itemMargin: {
                            vertical: 3,
                            horizontal: 10
                        },
                        labels: {
                            colors: legendColor,
                            useSeriesColors: false
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                    name: {
                                        fontSize: '2rem',
                                        fontFamily: 'Open Sans'
                                    },
                                    value: {
                                        fontSize: '1.2rem',
                                        color: legendColor,
                                        fontFamily: 'Open Sans',
                                        formatter: function(val) {
                                            return parseInt(val, 10);
                                        }
                                    },
                                    total: {
                                        show: false,
                                        fontSize: '1.5rem',
                                        color: headingColor,
                                        label: 'Operational',
                                        formatter: function(w) {
                                            return '42%';
                                        }
                                    }
                                }
                            }
                        }
                    },
                    responsive: [{
                            breakpoint: 992,
                            options: {
                                chart: {
                                    height: 380
                                },
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        colors: legendColor,
                                        useSeriesColors: false
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 576,
                            options: {
                                chart: {
                                    height: 320
                                },
                                plotOptions: {
                                    pie: {
                                        donut: {
                                            labels: {
                                                show: true,
                                                name: {
                                                    fontSize: '1.5rem'
                                                },
                                                value: {
                                                    fontSize: '1rem'
                                                },
                                                total: {
                                                    fontSize: '1.5rem'
                                                }
                                            }
                                        }
                                    }
                                },
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        colors: legendColor,
                                        useSeriesColors: false
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 420,
                            options: {
                                chart: {
                                    height: 280
                                },
                                legend: {
                                    show: false
                                }
                            }
                        },
                        {
                            breakpoint: 360,
                            options: {
                                chart: {
                                    height: 250
                                },
                                legend: {
                                    show: false
                                }
                            }
                        }
                    ]
                };
            if (typeof donutChartEl !== undefined && donutChartEl !== null) {
                const donutChart = new ApexCharts(donutChartEl, donutChartConfig);
                donutChart.render();
            }

            // Donut Chart
            // --------------------------------------------------------------------
            const donutChartE = document.querySelector('#donutChartt'),
                donutChartConfigs = {
                    chart: {
                        height: 390,
                        type: 'donut'
                    },
                    labels: ['Confirmed', 'Canceled'],
                    series: [{{ $confirmed }}, {{ $rejected }}],
                    colors: [
                        chartColors.donut.series2,
                        chartColors.donut.series5,
                    ],
                    stroke: {
                        show: false,
                        curve: 'straight'
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opt) {
                            return parseInt(val, 10) + '%';
                        }
                    },
                    legend: {
                        show: true,
                        position: 'bottom',
                        markers: {
                            offsetX: -3
                        },
                        itemMargin: {
                            vertical: 3,
                            horizontal: 10
                        },
                        labels: {
                            colors: legendColor,
                            useSeriesColors: false
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                    name: {
                                        fontSize: '2rem',
                                        fontFamily: 'Open Sans'
                                    },
                                    value: {
                                        fontSize: '1.2rem',
                                        color: legendColor,
                                        fontFamily: 'Open Sans',
                                        formatter: function(val) {
                                            return parseInt(val, 10);
                                        }
                                    },
                                    total: {
                                        show: false,
                                        fontSize: '1.5rem',
                                        color: headingColor,
                                        label: 'Confirmed',
                                        formatter: function(w) {
                                            return parseInt(({{ $chartconfirmed }} / ({{ $chartconfirmed }} +
                                                {{ $chartrejected }})) * 100);
                                        }
                                    }
                                }
                            }
                        }
                    },
                    responsive: [{
                            breakpoint: 992,
                            options: {
                                chart: {
                                    height: 380
                                },
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        colors: legendColor,
                                        useSeriesColors: false
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 576,
                            options: {
                                chart: {
                                    height: 320
                                },
                                plotOptions: {
                                    pie: {
                                        donut: {
                                            labels: {
                                                show: true,
                                                name: {
                                                    fontSize: '1.5rem'
                                                },
                                                value: {
                                                    fontSize: '1rem'
                                                },
                                                total: {
                                                    fontSize: '1.5rem'
                                                }
                                            }
                                        }
                                    }
                                },
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        colors: legendColor,
                                        useSeriesColors: false
                                    }
                                }
                            }
                        },
                        {
                            breakpoint: 420,
                            options: {
                                chart: {
                                    height: 280
                                },
                                legend: {
                                    show: false
                                }
                            }
                        },
                        {
                            breakpoint: 360,
                            options: {
                                chart: {
                                    height: 250
                                },
                                legend: {
                                    show: false
                                }
                            }
                        }
                    ]
                };
            if (typeof donutChartE !== undefined && donutChartE !== null) {
                const donutCharts = new ApexCharts(donutChartE, donutChartConfigs);
                donutCharts.render();
            }
            // Heat chart data generator
            function generateDataHeat(count, yrange) {
                let i = 0;
                let series = [];
                while (i < count) {
                    let x = 'w' + (i + 1).toString();
                    let y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

                    series.push({
                        x: x,
                        y: y
                    });
                    i++;
                }
                return series;
            }



            // Radar Chart
            // --------------------------------------------------------------------
            const radarChartEl = document.querySelector('#radarChart'),
                radarChartConfig = {
                    chart: {
                        height: 350,
                        type: 'radar',
                        toolbar: {
                            show: false
                        },
                        dropShadow: {
                            enabled: false,
                            blur: 8,
                            left: 1,
                            top: 1,
                            opacity: 0.2
                        }
                    },
                    legend: {
                        show: true,
                        position: 'bottom',
                        labels: {
                            colors: legendColor,
                            useSeriesColors: false
                        }
                    },
                    plotOptions: {
                        radar: {
                            polygons: {
                                strokeColors: borderColor,
                                connectorColors: borderColor
                            }
                        }
                    },
                    yaxis: {
                        show: false
                    },
                    series: [{
                            name: 'iPhone 12',
                            data: [{{ $delivered }}, {{ $returned }}, 81, 60, 42, 42, 33, 23]
                        },
                        {
                            name: 'Samsung s20',
                            data: [65, 46, 42, 25, 58, 63, 76, 43]
                        }
                    ],
                    colors: [chartColors.donut.series1, chartColors.donut.series3],
                    xaxis: {
                        categories: ['Battery', 'Brand', 'Camera', 'Memory', 'Storage', 'Display', 'OS', 'Price'],
                        labels: {
                            show: true,
                            style: {
                                colors: [labelColor, labelColor, labelColor, labelColor, labelColor, labelColor,
                                    labelColor, labelColor
                                ],
                                fontSize: '13px',
                                fontFamily: 'Open Sans'
                            }
                        }
                    },
                    fill: {
                        opacity: [1, 0.8]
                    },
                    stroke: {
                        show: false,
                        width: 0
                    },
                    markers: {
                        size: 0
                    },
                    grid: {
                        show: false,
                        padding: {
                            top: -20,
                            bottom: -20
                        }
                    }
                };
            if (typeof radarChartEl !== undefined && radarChartEl !== null) {
                const radarChart = new ApexCharts(radarChartEl, radarChartConfig);
                radarChart.render();
            }

            // Radar Chart
            // --------------------------------------------------------------------
            const radarChartEls = document.querySelector('#radarCharts'),
                radarChartConfigs = {
                    chart: {
                        height: 350,
                        type: 'radar',
                        toolbar: {
                            show: false
                        },
                        dropShadow: {
                            enabled: false,
                            blur: 8,
                            left: 1,
                            top: 1,
                            opacity: 0.2
                        }
                    },
                    legend: {
                        show: true,
                        position: 'bottom',
                        labels: {
                            colors: legendColor,
                            useSeriesColors: false
                        }
                    },
                    plotOptions: {
                        radar: {
                            polygons: {
                                strokeColors: borderColor,
                                connectorColors: borderColor
                            }
                        }
                    },
                    yaxis: {
                        show: false
                    },
                    series: [{
                            name: 'iPhone 12',
                            data: [41, 64, 81, 60, 42, 42, 33, 23]
                        },
                        {
                            name: 'Samsung s20',
                            data: [65, 46, 42, 25, 58, 63, 76, 43]
                        }
                    ],
                    colors: [chartColors.donut.series1, chartColors.donut.series3],
                    xaxis: {
                        categories: ['Battery', 'Brand', 'Camera', 'Memory', 'Storage', 'Display', 'OS', 'Price'],
                        labels: {
                            show: true,
                            style: {
                                colors: [labelColor, labelColor, labelColor, labelColor, labelColor, labelColor,
                                    labelColor, labelColor
                                ],
                                fontSize: '13px',
                                fontFamily: 'Open Sans'
                            }
                        }
                    },
                    fill: {
                        opacity: [1, 0.8]
                    },
                    stroke: {
                        show: false,
                        width: 0
                    },
                    markers: {
                        size: 0
                    },
                    grid: {
                        show: false,
                        padding: {
                            top: -20,
                            bottom: -20
                        }
                    }
                };
            if (typeof radarChartEls !== undefined && radarChartEls !== null) {
                const radarCharts = new ApexCharts(radarChartEls, radarChartConfigs);
                radarChart.render();
            }


            // Line Area Chart
            // --------------------------------------------------------------------
            const areaChartEl = document.querySelector('#lineAreaChart'),
                areaChartConfig = {
                    chart: {
                        height: 400,
                        type: 'area',
                        parentHeightOffset: 0,
                        toolbar: {
                            show: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: false,
                        curve: 'straight'
                    },
                    legend: {
                        show: true,
                        position: 'top',
                        horizontalAlign: 'start',
                        labels: {
                            colors: legendColor,
                            useSeriesColors: false
                        }
                    },
                    grid: {
                        borderColor: borderColor,
                        xaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    colors: [chartColors.area.series3, chartColors.area.series2, chartColors.area.series1],
                    series: [{
                            name: 'Visits',
                            data: [100, 120, 90, 170, 130, 160, 140, 240, 220, 180, 270, 280, 375]
                        },
                        {
                            name: 'Clicks',
                            data: [60, 80, 70, 110, 80, 100, 90, 180, 160, 140, 200, 220, 275]
                        },
                        {
                            name: 'Sales',
                            data: [20, 40, 30, 70, 40, 60, 50, 140, 120, 100, 140, 180, 220]
                        }
                    ],
                    xaxis: {
                        categories: [
                            '7/12',
                            '8/12',
                            '9/12',
                            '10/12',
                            '11/12',
                            '12/12',
                            '13/12',
                            '14/12',
                            '15/12',
                            '16/12',
                            '17/12',
                            '18/12',
                            '19/12',
                            '20/12'
                        ],
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '13px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '13px'
                            }
                        }
                    },
                    fill: {
                        opacity: 1,
                        type: 'solid'
                    },
                    tooltip: {
                        shared: false
                    }
                };
            if (typeof areaChartEl !== undefined && areaChartEl !== null) {
                const areaChart = new ApexCharts(areaChartEl, areaChartConfig);
                areaChart.render();
            }

            // Bar Chart
            // --------------------------------------------------------------------
            const barChartEl = document.querySelector('#barCharts'),
                barChartConfig = {
                    chart: {
                        height: 400,
                        type: 'bar',
                        stacked: true,
                        parentHeightOffset: 0,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '15%',
                            colors: {
                                backgroundBarColors: [
                                    chartColors.column.bg,
                                    chartColors.column.bg,
                                    chartColors.column.bg,
                                    chartColors.column.bg,
                                    chartColors.column.bg
                                ],
                                backgroundBarRadius: 10
                            }
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: true,
                        position: 'top',
                        horizontalAlign: 'start',
                        labels: {
                            colors: legendColor,
                            useSeriesColors: false
                        }
                    },
                    colors: [chartColors.column.series1, chartColors.column.series2],
                    stroke: {
                        show: true,
                        colors: ['transparent']
                    },
                    grid: {
                        borderColor: borderColor,
                        xaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    series: [{
                            name: 'Apple',
                            data: [90, 120, 55, 100, 80, 125, 175, 70, 88, 180]
                        },
                        {
                            name: 'Samsung',
                            data: [85, 100, 30, 40, 95, 90, 30, 110, 62, 20]
                        }
                    ],
                    xaxis: {
                        categories: ['7/12', '8/12', '9/12', '10/12', '11/12', '12/12', '13/12', '14/12', '15/12',
                            '16/12'
                        ],
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '13px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '13px'
                            }
                        }
                    },
                    fill: {
                        opacity: 1
                    }
                };
            if (typeof barChartEl !== undefined && barChartEl !== null) {
                const barChart = new ApexCharts(barChartEl, barChartConfig);
                barChart.render();
            }

            // Radial Bar Chart
            // --------------------------------------------------------------------
            const radialBarChartEl = document.querySelector('#radialBarChart'),
                radialBarChartConfig = {
                    chart: {
                        height: 380,
                        type: 'radialBar'
                    },
                    colors: [chartColors.donut.series1, chartColors.donut.series2, chartColors.donut.series4],
                    plotOptions: {
                        radialBar: {
                            size: 185,
                            hollow: {
                                size: '40%'
                            },
                            track: {
                                margin: 10,
                                background: config.colors_label.secondary
                            },
                            dataLabels: {
                                name: {
                                    fontSize: '2rem',
                                    fontFamily: 'Open Sans'
                                },
                                value: {
                                    fontSize: '1.2rem',
                                    color: legendColor,
                                    fontFamily: 'Open Sans'
                                },
                                total: {
                                    show: true,
                                    fontWeight: 400,
                                    fontSize: '1.3rem',
                                    color: headingColor,
                                    label: 'Comments',
                                    formatter: function(w) {
                                        return '80%';
                                    }
                                }
                            }
                        }
                    },
                    grid: {
                        borderColor: borderColor,
                        padding: {
                            top: -25,
                            bottom: -20
                        }
                    },
                    legend: {
                        show: true,
                        position: 'bottom',
                        labels: {
                            colors: legendColor,
                            useSeriesColors: false
                        }
                    },
                    stroke: {
                        lineCap: 'round'
                    },
                    series: [80, 50, 35],
                    labels: ['Comments', 'Replies', 'Shares']
                };
            if (typeof radialBarChartEl !== undefined && radialBarChartEl !== null) {
                const radialChart = new ApexCharts(radialBarChartEl, radialBarChartConfig);
                radialChart.render();
            }


        })();
    </script>
    <script>
        $(function(){
            Morris.Donut({
                element: 'donutCharts',
                data: [{
                    value: 70,
                    label: "foo"
                },
                    {
                        value: 15,
                        label: "bar"
                    },
                    {
                        value: 10,
                        label: "baz"
                    },
                    {
                        value: 5,
                        label: "A really really long label"
                    }],
                backgroundColor: "rgba(68, 102, 242, 0.5)",
                labelColor: "#999999",
                colors: [TivoAdminConfig.primary , TivoAdminConfig.secondary ,"#f8d62b" ,"#51bb25" ,"rgba(248, 214, 43, 1)", "#51bb25" ,"#f8d62b"],
                formatter: function(a) {
                    return a + "%"
                }
            });
        });
    </script>
@endsection
@endsection
