<div class="col-lg-5">
    <!-- Welcome Card -->
    <div class="card text-bg-primary">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-7">
                    <div class="d-flex flex-column h-100">
                        <div class="hstack gap-3">
                            <span
                                class="d-flex align-items-center justify-content-center round-48 bg-white rounded flex-shrink-0">
                                <iconify-icon icon="solar:course-up-outline" class="fs-7 text-muted"></iconify-icon>
                            </span>
                            <h5 class="text-white fs-6 mb-0 text-nowrap">Welcome Back
                                <br />{{ Auth::user()->name }}
                            </h5>
                        </div>
                        <div class="mt-4 mt-sm-auto">
                            <div class="row">
                                <div class="col-6">
                                    <span class="opacity-75">Revenue</span>
                                    <h4 class="mb-0 text-white mt-1 text-nowrap fs-13 fw-bolder">
                                        {{ $totalValue[0] }} {{ $countri->currency }}</h4>
                                </div>
                                <div class="col-6 border-start border-light" style="--bs-border-opacity: .15;">
                                    <span class="opacity-75">Expense</span>
                                    <h4 class="mb-0 text-white mt-1 text-nowrap fs-13 fw-bolder">
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
        <!-- Orders Delivered -->
        <div class="col-md-6 col-sm-6 col-xs-6">
            <div class="card bg-secondary-subtle overflow-hidden shadow-none">
                <div class="card-body p-4">
                    <span class="text-dark-light">Orders Delivered</span>
                    <div class="hstack gap-6">
                        <h5 class="mb-0 fs-7">{{ $SumDelivered }} {{ $countri->currency }}</h5>
                    </div>
                </div>
                <div id="customers"></div>
            </div>
        </div>
        <!-- Leads Confirmed -->
        <div class="col-md-6 col-sm-6 col-xs-6">
            <div class="card bg-danger-subtle overflow-hidden shadow-none">
                <div class="card-body p-4">
                    <span class="text-dark-light">Leads Confirmed</span>
                    <div class="hstack gap-6 mb-4">
                        <h5 class="mb-0 fs-7">{{ $SumConfirmed }}{{ $countri->currency }}</h5>
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
    <!-- Revenue Forecast -->
    <div class="card">
        <div class="card-body pb-4">
            <div class="d-md-flex align-items-center justify-content-between mb-4">
                <div class="hstack align-items-center gap-3">
                    <span
                        class="d-flex align-items-center justify-content-center round-48 bg-primary-subtle rounded flex-shrink-0">
                        <iconify-icon icon="solar:layers-linear" class="fs-7 text-primary"></iconify-icon>
                    </span>
                    <div>
                        <h5 class="card-title">Revenue Forecast</h5>
                        <p class="card-subtitle mb-0">Overview of Profit</p>
                    </div>
                </div>

                <div class="hstack gap-9 mt-4 mt-md-0">
                    <div class="d-flex align-items-center gap-2">
                        <span class="d-block flex-shrink-0 round-8 bg-primary rounded-circle"></span>
                        <span class="text-nowrap text-muted">Expensse</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="d-block flex-shrink-0 round-8 bg-danger rounded-circle"></span>
                        <span class="text-nowrap text-muted">Free Ads</span>
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
    <!-- Confirmation Performance -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold">Confirmation Performance</h5>
            <p class="card-subtitle mb-0 lh-base">Last check on this</p>

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
                                <h6 class="mb-0 text-nowrap">{{ $rate[4] }} orders</h6>
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
                                <h6 class="mb-0">{{ $rate[2] }} orders</h6>
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
                                <h6 class="mb-0">{{ $rate[2] }} orders</h6>
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
                                <h6 class="mb-0">{{ $rate[0] }} orders</h6>
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
            <h5 class="card-title">Shipping Performance</h5>
            <p class="card-subtitle">Overview of shipping</p>

            <div class="">
                <div id="most-visited"></div>
            </div>
            <div class="pt-2 border-top">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="hstack gap-6 mb-3 mb-md-0">
                            <span
                                class="d-flex align-items-center justify-content-center round-48 flex-shrink-0 bg-danger-subtle rounded">
                                <iconify-icon icon="solar:course-down-linear" class="fs-7 text-danger"></iconify-icon>
                            </span>
                            <div>
                                <span class="text-muted">Returned</span>
                                <h6 class="fw-bolder mb-0">{{ $livrisonrate[4] }}</h5>
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
                                <span class="text-muted">Delivered</span>
                                <h6 class="fw-bolder mb-0">{{ $livrisonrate[2] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-8">
    <!-- Revenue by Product -->
    <div class="card mb-lg-0">
        <div class="card-body">
            <div class="d-flex flex-wrap gap-3 mb-9 justify-content-between align-items-center">
                <h5 class="card-title fw-semibold mb-0">Revenue by Product</h5>
            </div>

            <div class="table-responsive">
                <ul class="nav nav-tabs theme-tab gap-3 flex-nowrap" role="tablist">
                    @foreach ($stores as $v_store)
                        <li class="nav-item">
                            <a class="nav-link @if ($loop->first) active @endif" data-bs-toggle="tab"
                                href="#{{ $v_store->id }}" role="tab">
                                <div class="hstack gap-2">
                                    <iconify-icon icon="solar:widget-linear" class="fs-4"></iconify-icon>
                                    <span>{{ $v_store->name }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="tab-content mb-n3">
                @foreach ($stores as $v_store)
                    <div class="tab-pane @if ($loop->first) active @endif" id="{{ $v_store->id }}"
                        role="tabpanel">
                        <div class="table-responsive" data-simplebar style="min-height: 350px;max-height: 400px;">
                            @if (count($v_store['Products']) > 0)
                                <table class="table text-nowrap align-middle table-custom mb-0 last-items-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="fw-normal ps-0">Product</th>
                                            <th scope="col" class="fw-normal">Confirmation Rate</th>
                                            <th scope="col" class="fw-normal">Delivered Rate</th>
                                            <th scope="col" class="fw-normal">Priority</th>
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
                                                            <span>Jason Roy</span>
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
                                </table>
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <img src="{{ asset('public/Empty-amico.svg') }}" class="img-fluid"
                                            width="300" style="margin: 0 auto; display: block;">
                                        <p class="mt-3 text-muted text-center p-5 fs-5">No products found</p>
                                    </td>
                                </tr>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <!-- Top Performing Cities -->
    <div class="card">
        <div class="card-body">
            <div class="hstack align-items-center gap-3">
                <span
                    class="d-flex align-items-center justify-content-center round-48 bg-primary-subtle rounded flex-shrink-0">
                    <iconify-icon icon="solar:city-broken" class="fs-7 text-primary"></iconify-icon>
                </span>
                <div>
                    <h5 class="card-title">Top Performing Cities</h5>
                    <p class="card-subtitle mb-0">By Delivered Orders</p>
                </div>
            </div>
            <div id="chart-bar-basic"></div>
        </div>
    </div>
</div>
