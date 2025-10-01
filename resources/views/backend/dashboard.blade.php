@extends('backend.layouts.app')
@section('css')
    <style>
        .full-page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(2px);
        }

        .loader-content {
            text-align: center;
        }

        .btn-outline-primary.active {
            background-color: var(--bs-primary);
            color: white;
            border-color: var(--bs-primary);
        }

        .usage-meter-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .usage-meter-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .usage-progress .progress {
            border-radius: 4px;
            overflow: hidden;
        }

        .usage-progress .progress-bar {
            transition: width 0.5s ease;
        }

        .usage-info {
            font-size: 0.85rem;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div id="fullPageLoader" class="full-page-loader">
            <div class="loader-content">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h5 class="mt-3">Loading Dashboard Data...</h5>
            </div>
        </div>
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <form id="dashboardFilterForm" method="GET">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_from">From Date</label>
                                    <input type="date" class="form-control" id="date_from" name="date_from"
                                        value="{{ request('date_from') ?? date('Y-m-01') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_to">To Date</label>
                                    <input type="date" class="form-control" id="date_to" name="date_to"
                                        value="{{ request('date_to') ?? date('Y-m-t') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="hstack gap-2">
                                    <button type="submit" class="btn btn-primary">Apply</button>
                                    <a href="{{ route('home') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="button-grp">Quick Filters</label>
                                <div id="button-grp" class="btn-group w-100" role="group">
                                    <button type="button" class="btn btn-outline-primary quick-filter"
                                        data-from="{{ date('Y-m-d') }}" data-to="{{ date('Y-m-d') }}">
                                        Today
                                    </button>
                                    <button type="button" class="btn btn-outline-primary quick-filter"
                                        data-from="{{ date('Y-m-d', strtotime('-1 days')) }}" data-to="{{ date('Y-m-d') }}">
                                        Yesterday
                                    </button>
                                    <button type="button" class="btn btn-outline-primary quick-filter"
                                        data-from="{{ date('Y-m-d', strtotime('-7 days')) }}" data-to="{{ date('Y-m-d') }}">
                                        Last 7 Days
                                    </button>
                                    <button type="button" class="btn btn-outline-primary quick-filter"
                                        data-from="{{ date('Y-m-01') }}" data-to="{{ date('Y-m-t') }}">
                                        This Month
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <!-- -------------------------------------------- -->
            <!-- Welcome Card -->
            <!-- -------------------------------------------- -->
            <div class="card text-bg-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="d-flex flex-column h-100">
                                <div class="hstack gap-3">
                                    <h5 class="text-white fs-8 mb-0 text-nowrap">Welcome Back 
                                       {{ Auth::user()->name }} 👋 ,
                                    </h5>
                                </div>
                                <div class="mt-4 mt-sm-auto">
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="opacity-75">Revenue</span>
                                            <h4 id="totalRevenueValue"
                                                class="mb-0 text-white mt-1 text-nowrap fs-13 fw-bolder">
                                                {{ $totalValue[0] }} {{ $countri->currency }}</h4>
                                        </div>
                                        <div class="col-6 border-start border-light" style="--bs-border-opacity: .15;">
                                            <span class="opacity-75">Expenses</span>
                                            <h4 id="totalExpenseValue"
                                              class="mb-0 text-white mt-1 text-nowrap fs-13 fw-bolder">
                                                {{ $amountexpensses }} {{ $countri->currency }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-md-end">
                            <img src="{{ asset('public/assets/images/backgrounds/welcome-bg.png') }}" alt="welcome"
                                class="img-fluid mb-n7 mt-2" width="180" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- -------------------------------------------- -->
                <!-- Customers -->
                <!-- -------------------------------------------- -->
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="card bg-secondary-subtle overflow-hidden shadow-none">
                        <div class="card-body p-4">
                            <span class="text-dark-light">Delivered Orders</span>
                            <div class="hstack gap-6">
                                <h5 id="ordersDeliveredValue" class="mb-0 fs-7">{{ $SumDelivered }}
                                    {{ $countri->currency }}</h5>
                                <!-- <span class="fs-11 text-dark-light fw-semibold">-12%</span> -->
                            </div>
                        </div>
                        <div id="customers"></div>
                    </div>
                </div>
                <!-- -------------------------------------------- -->
                <!-- Projects -->
                <!-- -------------------------------------------- -->
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="card bg-danger-subtle overflow-hidden shadow-none">
                        <div class="card-body p-4">
                            <span class="text-dark-light">Confirmed Leads</span>
                            <div class="hstack gap-6 mb-4">
                                <h5 id="leadsConfirmedValue" class="mb-0 fs-7">
                                    {{ $SumConfirmed }}{{ $countri->currency }}</h5>
                                <!-- <span class="fs-11 text-dark-light fw-semibold">+31.8%</span> -->
                            </div>
                            <div class="mx-n1">
                                <div id="projects"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <!-- -------------------------------------------- -->
            <!-- Revenue Forecast -->
            <!-- -------------------------------------------- -->
            <div class="card">
                <div class="card-body pb-4">
                    <div class="d-md-flex align-items-center justify-content-between mb-4">
                        <div class="hstack align-items-center gap-3">
                            <span
                                class="d-flex align-items-center justify-content-center round-48 bg-primary-subtle rounded flex-shrink-0">
                                <iconify-icon icon="solar:layers-linear" class="fs-7 text-primary"></iconify-icon>
                            </span>
                            <div>
                                <h5 class="card-title">Profit Overview</h5>
                                <p class="card-subtitle mb-0">full overview</p>
                            </div>
                        </div>

                        <div class="hstack gap-9 mt-4 mt-md-0">
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-block flex-shrink-0 round-8 bg-primary rounded-circle"></span>
                                <span class="text-nowrap text-muted">Expensse</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-block flex-shrink-0 round-8 bg-danger rounded-circle"></span>
                                <span class="text-nowrap text-muted">Ads Fees</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="d-block flex-shrink-0 round-8 bg-secondary rounded-circle"></span>
                                <span class="text-nowrap text-muted">Revenue</span>
                            </div>
                        </div>
                    </div>
                    <div style="height: 330px;" class="me-n7">
                        <div id="revenue-forecasts"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <!-- -------------------------------------------- -->
            <!-- Your Performance -->
            <!-- -------------------------------------------- -->
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title fw-semibold">Overview of Confirmation</h5>
                    <p class="card-subtitle mb-0 lh-base">Current Overview</p>
                    <div class="row mt-4 mb-4">
                        <div class="col-md-6">
                            <div class="vstack gap-9 mt-2">
                                <div class="hstack align-items-center gap-3">
                                    <div
                                        class="d-flex align-items-center justify-content-center round-48 rounded bg-primary-subtle flex-shrink-0">
                                        <iconify-icon icon="solar:pen-new-round-broken"
                                            class="fs-7 text-primary"></iconify-icon>
                                    </div>
                                    <div>
                                        <h6 id="newOrdersCount" class="mb-0 text-nowrap">{{ $rate[4] }} orders</h6>
                                        <span>New</span>
                                    </div>

                                </div>
                                <div class="hstack align-items-center gap-3">
                                    <div
                                        class="d-flex align-items-center justify-content-center round-48 rounded bg-danger-subtle">
                                        <iconify-icon icon="material-symbols:cancel-outline-rounded"
                                            class="fs-7 text-danger"></iconify-icon>
                                    </div>
                                    <div>
                                        <h6 id="canceledOrdersCount" class="mb-0">{{ $rate[2] }} orders</h6>
                                        <span>Canceled</span>
                                    </div>

                                </div>
                                <div class="hstack align-items-center gap-3">
                                    <div
                                        class="d-flex align-items-center justify-content-center round-48 rounded bg-danger-subtle">
                                        <iconify-icon icon="material-symbols:cancel-outline-rounded"
                                            class="fs-7 text-danger"></iconify-icon>
                                    </div>
                                    <div>
                                        <h6 id="systemCanceledCount" class="mb-0">{{ $rate[5] }} orders</h6>
                                        <span>Canceled By System</span>
                                    </div>

                                </div>
                                <div class="hstack align-items-center gap-3">
                                    <div
                                        class="d-flex align-items-center justify-content-center round-48 rounded bg-secondary-subtle">
                                        <iconify-icon icon="solar:check-circle-line-duotone"
                                            class="fs-7 text-secondary"></iconify-icon>
                                    </div>
                                    <div>
                                        <h6 id="confirmedOrdersCount" class="mb-0">{{ $rate[0] }} orders</h6>
                                        <span>Confirmed</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center mt-sm-n7">
                                <div id="chart-radial-semi-circles" style="margin-left: -70px;margin-top:50px"></div>
                                <p class="mb-0">Confirmation Rate.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Overview of Shipping</h5>
                    <p class="card-subtitle">Current Overview</p>

                    <div class="">
                        <div id="most-visited"></div>
                    </div>
                    <div class="pt-2 border-top">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="hstack gap-6 mb-3 mb-md-0">
                                    <span
                                        class="d-flex align-items-center justify-content-center round-48 flex-shrink-0 bg-danger-subtle rounded">
                                        <iconify-icon icon="solar:course-down-linear"
                                            class="fs-7 text-danger"></iconify-icon>
                                    </span>
                                    <div>
                                        <span class="text-muted">Orders Returned</span>
                                        <h6 id="returnedOrdersCount" class="fw-bolder mb-0">{{ $livrisonrate[4] }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="hstack gap-6">
                                    <span
                                        class="d-flex align-items-center justify-content-center round-48 flex-shrink-0 bg-primary-subtle rounded">
                                        <iconify-icon icon="solar:delivery-bold-duotone"
                                            class="fs-7 text-primary"></iconify-icon>
                                    </span>
                                    <div>
                                        <span class="text-muted">Orders Delivered</span>
                                        <h6 id="deliveredOrdersCount" class="fw-bolder mb-0">{{ $livrisonrate[2] }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- -------------------------------------------- -->
            <!-- Revenue by Product -->
            <!-- -------------------------------------------- -->
            <div class="card mb-lg-0">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-3 mb-9 justify-content-between align-items-center">
                        <h5 class="card-title fw-semibold mb-0">Revenue by Product</h5>
                    </div>

                    <div class="table-responsive">
                        <ul class="nav nav-tabs theme-tab gap-3 flex-nowrap" role="tablist">
                            <?php
                            $p = 1;
                            ?>
                            @foreach ($stores as $v_store)
                                <li class="nav-item">
                                    <a class="nav-link @if ($p == 1) active @endif"
                                        data-bs-toggle="tab" href="#{{ $v_store->id }}" role="tab">
                                        <div class="hstack gap-2">
                                            <iconify-icon icon="solar:widget-linear" class="fs-4"></iconify-icon>
                                            <span>{{ $v_store->name }}</span>
                                        </div>

                                    </a>
                                </li>
                                <?php
                                $p = $p + 1;
                                ?>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-content mb-n3">
                        <?php
                        $i = 1;
                        ?>
                        @foreach ($stores as $v_store)
                            <div class="tab-pane @if ($i == 1) active @endif"
                                id="{{ $v_store->id }}" role="tabpanel">
                                <div class="table-responsive" data-simplebar style="min-height: 350px;max-height: 400px;">
                                    @if (count($v_store['Products']) > 0)
                                        <table
                                            class="table text-nowrap align-middle table-custom mb-0 last-items-borderless">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="fw-normal ps-0">Product
                                                    </th>
                                                    <th scope="col" class="fw-normal">Confirmation Rate</th>
                                                    <th scope="col" class="fw-normal">Delivered Rate</th>
                                                    <th scope="col" class="fw-normal">Priority Level</th>
                                                    <th scope="col" class="fw-normal">Revenue</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($v_store['Products'] as $v_product)
                                                    @php
                                                        $revenue = $v_product->Revenue($v_product->id);
                                                        $taux_delivered = $v_product->Tauxdev($v_product->id);
                                                        if ($taux_delivered < 45) {
                                                            $badgeClass = 'bg-danger-subtle text-danger';
                                                            $badgeLabel = 'Low';
                                                        } elseif ($taux_delivered < 65) {
                                                            $badgeClass = 'bg-warning-subtle text-warning';
                                                            $badgeLabel = 'Medium';
                                                        } else {
                                                            $badgeClass = 'bg-success-subtle text-success';
                                                            $badgeLabel = 'High';
                                                        }
                                                    @endphp
                                                    <tr>
                                                        <td class="ps-0">
                                                            <div class="d-flex align-items-center gap-6">
                                                                <img src="{{ $v_product->image }}" alt="prd1"
                                                                    width="48" class="rounded" />
                                                                <div>
                                                                    <h6 class="mb-0">{{ $v_product->name }}</h6>
                                                                    {{-- <span>Jason Roy</span> --}}
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span>{{ $v_product->Tauxconf($v_product->id) }}%</span>
                                                        </td>
                                                        <td>
                                                            <span>{{ $v_product->Tauxdev($v_product->id) }}%</span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="text-dark-light">
                                                                {{ $revenue }} {{ $countri->currency }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <img src="{{ asset('public/Empty-amico.svg') }}" class="img-fluid"
                                                        width="300" style="margin: 0 auto; display: block;">
                                                    <p class="mt-3 text-muted text-center p-5 fs-5">No products found</p>
                                                </td>

                                            </tr>
                                    @endif
                                    </table>

                                </div>
                            </div>
                            <?php $i = $i + 1; ?>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <!-- -------------------------------------------- -->
            <!-- Total settlements -->
            <!-- -------------------------------------------- -->
            <div class="card">
                <div class="card-body">
                    <div class="hstack align-items-center gap-3">
                        <span
                            class="d-flex align-items-center justify-content-center round-48 bg-primary-subtle rounded flex-shrink-0">
                            <iconify-icon icon="solar:city-broken" class="fs-7 text-primary"></iconify-icon>
                        </span>
                        <div>
                            <h5 class="card-title">Top Cities by Delivered Orders</h5>
                            <p class="card-subtitle mb-0">Current Overview </p>
                        </div>
                    </div>
                    <div id="chart-bar-basic"></div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Plan Usage Overview</h5>
                        <p class="card-subtitle">Track how you’re using your plan limits</p>
                    </div>
                    <div class="card-body">
                        <div class="row" id="usage-meters-container">
                            <div class="col-12 text-center py-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading usage data...</span>
                                </div>
                                <p class="mt-2">Loading your usage information...</p>
                            </div>
                        </div>

                        {{-- @if ($subscription->plan->isUnlimited())
                            <div class="alert alert-info mt-4">
                                <i class="ti ti-crown me-2"></i>
                                You're on an unlimited plan! Enjoy all features without restrictions.
                            </div>
                        @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('script')
    <script type="text/javascript">
        var revenueChartInstance, ordersChartInstance, radialChartInstance, chart_bar_basic;

        const elementIds = {
            loader: 'fullPageLoader',
            dateFrom: 'date_from',
            dateTo: 'date_to',
            filterForm: 'dashboardFilterForm',
            revenueValue: 'totalRevenueValue',
            expenseValue: 'totalExpenseValue',
            deliveredValue: 'ordersDeliveredValue',
            confirmedValue: 'leadsConfirmedValue',
            newOrdersCount: 'newOrdersCount',
            canceledOrdersCount: 'canceledOrdersCount',
            systemCanceledCount: 'systemCanceledCount',
            confirmedOrdersCount: 'confirmedOrdersCount',
            returnedOrdersCount: 'returnedOrdersCount',
            deliveredOrdersCount: 'deliveredOrdersCount',
            productsTableBody: 'productsTableBody',
            revenueForecastChart: 'revenue-forecasts',
            ordersChart: 'most-visited',
            radialChart: 'chart-radial-semi-circles',
            citiesChart: 'chart-bar-basic'
        };

        function showLoader() {
            $('#' + elementIds.loader).show();
        }

        function hideLoader() {
            $('#' + elementIds.loader).hide();
        }

        function updateDashboardElements(data) {
            $('#' + elementIds.revenueValue).text(data.totalValue[0] + ' {{ $countri->currency }}');
            $('#' + elementIds.expenseValue).text(data.amountexpensses + ' {{ $countri->currency }}');
            $('#' + elementIds.deliveredValue).text(data.SumDelivered + ' {{ $countri->currency }}');
            $('#' + elementIds.confirmedValue).text(data.SumConfirmed + ' {{ $countri->currency }}');

            $('#' + elementIds.newOrdersCount).text(data.rate[4] + ' orders');
            $('#' + elementIds.canceledOrdersCount).text(data.rate[2] + ' orders');
            $('#' + elementIds.systemCanceledCount).text(data.rate[5] + ' orders');
            $('#' + elementIds.confirmedOrdersCount).text(data.rate[0] + ' orders');

            $('#' + elementIds.returnedOrdersCount).text(data.livrisonrate[4]);
            $('#' + elementIds.deliveredOrdersCount).text(data.livrisonrate[2]);
        }

        function initializeRevenueChart(data) {
            if (revenueChartInstance) {
                revenueChartInstance.destroy();
            }

            revenueChartInstance = new ApexCharts(
                document.querySelector("#" + elementIds.revenueForecastChart), {
                    series: [{
                            name: "Expense",
                            data: data.expensses
                        },
                        {
                            name: "Free Ads",
                            data: data.freeads
                        },
                        {
                            name: "Revenue",
                            data: data.revenues.map(r => r.value)
                        }
                    ],
                    chart: {
                        toolbar: {
                            show: false
                        },
                        type: "area",
                        fontFamily: "inherit",
                        foreColor: "#adb0bb",
                        height: 300,
                        width: "100%",
                        stacked: false,
                        offsetX: -10,
                    },
                    colors: ["var(--bs-primary)", "var(--bs-danger)", "var(--bs-secondary)"],
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: false
                    },
                    stroke: {
                        width: 2,
                        curve: "monotoneCubic"
                    },
                    grid: {
                        show: true,
                        padding: {
                            top: 0,
                            bottom: 0
                        },
                        borderColor: "rgba(0,0,0,0.05)",
                        xaxis: {
                            lines: {
                                show: true
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            }
                        }
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            shadeIntensity: 0,
                            inverseColors: false,
                            opacityFrom: 0.1,
                            opacityTo: 0.01,
                            stops: [0, 100]
                        }
                    },
                    xaxis: {
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        categories: data.revenues.map(r => r.day ? r.day : r.date),
                        labels: {
                            formatter: function(value) {
                                return value;
                            }
                        }
                    },
                    markers: {
                        strokeColor: ["var(--bs-danger)", "var(--bs-secondary)", "var(--bs-primary)"],
                        strokeWidth: 2
                    },
                    tooltip: {
                        theme: "dark",
                        x: {
                            formatter: function(value, {
                                dataPointIndex,
                                w
                            }) {
                                return w.globals.categoryLabels[dataPointIndex] +
                                    (data.revenues[dataPointIndex].day ? ' (' + '{{ date('M Y') }}' + ')' : '');
                            }
                        }
                    }
                }
            );
            revenueChartInstance.render();
        }

        function initializeOrdersChart(data) {
            if (ordersChartInstance) {
                ordersChartInstance.destroy();
            }

            ordersChartInstance = new ApexCharts(
                document.querySelector("#" + elementIds.ordersChart), {
                    series: [{
                            name: "Returned",
                            data: data.returned.map(r => r.total_leads)
                        },
                        {
                            name: "Delivered",
                            data: data.orders.map(o => o.total_leads)
                        }
                    ],
                    chart: {
                        height: 265,
                        type: "bar",
                        fontFamily: "inherit",
                        foreColor: "#adb0bb",
                        toolbar: {
                            show: false
                        },
                        stacked: true
                    },
                    colors: ["var(--bs-primary)", "var(--bs-secondary)"],
                    plotOptions: {
                        bar: {
                            borderRadius: [6],
                            horizontal: false,
                            barHeight: "60%",
                            columnWidth: "40%",
                            borderRadiusApplication: "end",
                            borderRadiusWhenStacked: "all"
                        }
                    },
                    stroke: {
                        show: false
                    },
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: false
                    },
                    grid: {
                        show: false,
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        }
                    },
                    yaxis: {
                        tickAmount: 4
                    },
                    xaxis: {
                        categories: data.orders.map(o => o.month),
                        axisTicks: {
                            show: false
                        }
                    },
                    tooltip: {
                        theme: "dark",
                        fillSeriesColor: false,
                        x: {
                            show: false
                        }
                    }
                }
            );
            ordersChartInstance.render();
        }

        function initializeRadialChart(data) {
            if (radialChartInstance) {
                radialChartInstance.destroy();
            }

            radialChartInstance = new ApexCharts(
                document.querySelector("#" + elementIds.radialChart), {
                    series: [data.rateconf],
                    chart: {
                        fontFamily: "inherit",
                        type: "radialBar",
                        offsetY: -20,
                        width: 400,
                        height: 300,
                        sparkline: {
                            enabled: true
                        }
                    },
                    plotOptions: {
                        radialBar: {
                            startAngle: -90,
                            endAngle: 90,
                            track: {
                                background: "#615dff",
                                strokeWidth: "97%",
                                margin: 5,
                                dropShadow: {
                                    enabled: true,
                                    top: 2,
                                    left: 0,
                                    color: "#999",
                                    opacity: 1,
                                    blur: 2
                                }
                            },
                            dataLabels: {
                                name: {
                                    show: false
                                },
                                value: {
                                    offsetY: -2,
                                    fontSize: "22px",
                                    color: "#a1aab2"
                                }
                            }
                        }
                    },
                    grid: {
                        padding: {
                            top: -10
                        }
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            color: "#6610f2",
                            shade: "light",
                            shadeIntensity: 0.4,
                            inverseColors: false,
                            opacityFrom: 1,
                            opacityTo: 1,
                            stops: [0, 50, 53, 91]
                        }
                    },
                    labels: ["Average Results"]
                }
            );
            radialChartInstance.render();
        }

        function initializeCitiesChart(data) {
            if (chart_bar_basic) {
                chart_bar_basic.destroy();
            }

            chart_bar_basic = new ApexCharts(
                document.querySelector("#" + elementIds.citiesChart), {
                    series: [{
                        name: "Delivered",
                        data: data.ordersCount,
                    }],
                    chart: {
                        fontFamily: "inherit",
                        type: "bar",
                        height: 350,
                        toolbar: {
                            show: false
                        },
                    },
                    grid: {
                        borderColor: "transparent"
                    },
                    colors: ["var(--bs-primary)"],
                    plotOptions: {
                        bar: {
                            horizontal: true
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: data.cities,
                        labels: {
                            style: {
                                colors: "#a1aab2"
                            }
                        },
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: "#a1aab2"
                            }
                        }
                    },
                    tooltip: {
                        theme: "dark"
                    },
                }
            );
            chart_bar_basic.render();
        }

        function updateProductsTable(products) {
            let tableHtml = '';

            if (products && products.length > 0) {
                products.forEach(product => {
                    let badgeClass, badgeLabel;
                    const taux_delivered = product.taux_delivered || 0;

                    if (taux_delivered < 45) {
                        badgeClass = 'bg-danger-subtle text-danger';
                        badgeLabel = 'Low';
                    } else if (taux_delivered < 65) {
                        badgeClass = 'bg-warning-subtle text-warning';
                        badgeLabel = 'Medium';
                    } else {
                        badgeClass = 'bg-success-subtle text-success';
                        badgeLabel = 'High';
                    }

                    tableHtml += `
                    <tr>
                        <td class="ps-0">
                            <div class="d-flex align-items-center gap-6">
                                <img src="${product.image}" width="48" class="rounded" />
                                <div>
                                    <h6 class="mb-0">${product.name}</h6>
                                    <span>${product.seller || 'N/A'}</span>
                                </div>
                            </div>
                        </td>
                        <td>${product.taux_conf || 0}%</td>
                        <td>${taux_delivered}%</td>
                        <td><span class="badge ${badgeClass}">${badgeLabel}</span></td>
                        <td>${product.revenue || 0} {{ $countri->currency }}</td>
                    </tr>
                `;
                });
            } else {
                tableHtml = `
                <tr>
                    <td colspan="5" class="text-center">
                        <img src="{{ asset('public/Empty-amico.svg') }}" width="300">
                        <p class="mt-3 text-muted">No products found</p>
                    </td>
                </tr>
            `;
            }

            $('#' + elementIds.productsTableBody).html(tableHtml);
        }

        function loadDashboardData(date_from, date_to) {
            showLoader();

            $.ajax({
                url: "{{ route('dashboard.ajax') }}",
                type: "POST",
                data: {
                    date_from: date_from,
                    date_to: date_to,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    initializeRevenueChart(response);
                    initializeOrdersChart(response);
                    initializeRadialChart(response);
                    initializeCitiesChart(response);

                    updateDashboardElements(response);

                    if (response.stores && response.stores.length > 0) {
                        updateProductsTable(response.stores[0].Products);
                    } else {
                        updateProductsTable([]);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Error loading dashboard data');
                },
                complete: function() {
                    hideLoader();
                }
            });
        }

        $(document).ready(function() {
            const today = new Date().toISOString().split('T')[0];
            $('#' + elementIds.dateTo).attr('max', today);
            $('#' + elementIds.dateFrom).attr('max', today);

            $('.quick-filter').on('click', function(e) {
                e.preventDefault();
                $('.quick-filter').removeClass('active');
                $(this).addClass('active');

                $('#date_from').val($(this).data('from'));
                $('#date_to').val($(this).data('to'));
                $('#dashboardFilterForm').submit();
            });

            function setInitialActiveButton() {
                const date_from = $('#date_from').val();
                const date_to = $('#date_to').val();

                $('.quick-filter').each(function() {
                    if ($(this).data('from') === date_from && $(this).data('to') === date_to) {
                        $(this).addClass('active');
                    }
                });
            }

            setInitialActiveButton();

            $('#' + elementIds.dateFrom).on('change', function() {
                $('#' + elementIds.dateTo).attr('min', $(this).val());
                if (new Date($('#' + elementIds.dateTo).val()) < new Date($(this).val())) {
                    $('#' + elementIds.dateTo).val($(this).val());
                }
            });

            $('#' + elementIds.dateTo).on('change', function() {
                if (new Date($(this).val()) < new Date($('#' + elementIds.dateFrom).val())) {
                    $(this).val($('#' + elementIds.dateFrom).val());
                }
            });

            $('#' + elementIds.filterForm).on('submit', function(e) {
                e.preventDefault();
                loadDashboardData($('#' + elementIds.dateFrom).val(), $('#' + elementIds.dateTo).val());
            });

            loadDashboardData(
                $('#' + elementIds.dateFrom).val(),
                $('#' + elementIds.dateTo).val()
            );

        });

        function loadUsageMetrics() {
            $.ajax({
                url: '{{ route('usage.metrics') }}',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        renderUsageMeters(response.metrics);
                    } else {
                        $('#usage-meters-container').html(`
                <div class="col-12 text-center py-4 text-danger">
                    <i class="ti ti-alert-circle fs-1"></i>
                    <p class="mt-2">Failed to load usage data</p>
                </div>
            `);
                    }
                },
                error: function() {
                    $('#usage-meters-container').html(`
            <div class="col-12 text-center py-4 text-danger">
                <i class="ti ti-alert-circle fs-1"></i>
                <p class="mt-2">Error loading usage information</p>
            </div>
        `);
                }
            });
        }

        function renderUsageMeters(metrics) {
            if (metrics.length === 0) {
                $('#usage-meters-container').html(`
            <div class="col-12 text-center py-4 text-muted">
                <i class="ti ti-chart-bar-off fs-1"></i>
                <p class="mt-2">No usage metrics available</p>
            </div>
        `);
                return;
            }

            let metersHtml = '';

            metrics.forEach(metric => {
                const isUnlimited = metric.is_unlimited || metric.limit === 'Unlimited' || metric.limit >= 1000000;
                const current = metric.current_usage || 0;
                const limit = isUnlimited ? 'Unlimited' : metric.limit;
                const percentage = isUnlimited ? 100 : Math.min(100, Math.round((current / metric.limit) * 100));
                const remaining = isUnlimited ? 'Unlimited' : Math.max(0, metric.limit - current);

                let statusColor = 'success';
                if (!isUnlimited) {
                    if (current > metric.limit) {
                        statusColor = 'danger';
                    } else if (current >= metric.limit * 0.8) {
                        statusColor = 'warning';
                    }
                }

                const metricName = metric.metric.replace(/_/g, ' ')
                    .split(' ')
                    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                    .join(' ');

                metersHtml += `
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card usage-meter-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">${metricName}</h6>
                        <span class="badge bg-${statusColor}">${current}/${limit}</span>
                    </div>
                    <div class="card-body">
                        ${!isUnlimited ? `
                                    <div class="usage-progress mb-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="text-muted small">Usage</span>
                                            <span class="text-muted small">${percentage}%</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-${statusColor}" role="progressbar" 
                                                 style="width: ${percentage}%" aria-valuenow="${percentage}" 
                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    ` : `
                                    <div class="usage-progress mb-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="text-muted small">Usage</span>
                                            <span class="text-muted small">Unlimited</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                 style="width: 100%" aria-valuenow="100" 
                                                 aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    `}
                        <div class="usage-info">
                            <small class="text-muted">
                                ${isUnlimited ? 
                                    '<i class="ti ti-crown me-1 text-success"></i> Unlimited usage - Enjoy!' :
                                current > metric.limit ? 
                                    `<i class="ti ti-alert-triangle text-danger me-1"></i> Limit exceeded by ${current - metric.limit}` :
                                current >= metric.limit * 0.8 ? 
                                    `<i class="ti ti-alert-circle text-warning me-1"></i> ${remaining} remaining` :
                                    `${remaining} remaining of your limit`
                                }
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        `;
            });

            $('#usage-meters-container').html(metersHtml);
        }

        $(document).ready(function() {
            loadUsageMetrics();

            setInterval(loadUsageMetrics, 300000);
        });
    </script>
@endsection
@endsection
