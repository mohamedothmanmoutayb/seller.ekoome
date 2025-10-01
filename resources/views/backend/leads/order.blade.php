@extends('backend.layouts.app')
@section('content')
    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                        <i class="ti ti-arrow-left fs-5"></i> 
                    </a>
                    <div>
  <h4 class="mb-4 mb-sm-0 card-title">Orders</h4>
                     <p class="mb-0 text-muted"> Manage and track all your customer orders in one place.</p>

                    </div>
                  
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex" href="{{ route('home') }}">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
    <ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row">
        <li class="nav-item">
            <a href="javascript:void(0)" onclick="toggleText()"
                class="nav-link gap-6 note-link d-flex align-items-center justify-content-center px-3 px-md-3 me-0 me-md-2 fs-11 active"
                id="all-category">
                <i class="ti ti-list fill-white"></i>
                <span class="d-none d-md-block fw-medium">Filter</span>
            </a>
        </li>
        <li class="nav-item ms-auto">
            <a href="javascript:void(0)" class="btn btn-success d-flex align-items-center px-3 gap-6"
                id="sendBulkOffersBtn">
                <i class="ti ti-brand-whatsapp fs-4"></i>
                <span class="d-none d-md-block fw-medium fs-3">Send WhatsApp Offers</span>
            </a>
        </li>

        <div class="col-12 row form-group multi mt-2" id="multi">
            <form>
                <div class="row">
                    <div class="col-md-3 col-sm-12 m-b-20">
                        <label for="search_ref" style="margin-bottom: 5px;">Lead Reference</label>
                        <input type="text" class="form-control" id="search_ref" name="ref"
                            value="{{ request()->input('ref') }}" placeholder="Ref">
                    </div>
                    <div class="col-md-3 col-sm-12 m-b-20">
                        <label for="customer" style="margin-bottom: 5px;">Customer Name</label>
                        <input type="text" class="form-control" name="customer"
                            value="{{ request()->input('customer') }}" placeholder="Customer Name">
                    </div>
                    <div class="col-md-3 col-sm-12 m-b-20">
                        <label for="phone1" style="margin-bottom: 5px;">Phone</label>
                        <input type="text" class="form-control" name="phone1" value="{{ request()->input('phone1') }}"
                            placeholder="Phone ">
                    </div>
                    <div class="col-md-3 col-sm-12 m-b-20">
                        <label for="id_cit" style="margin-bottom: 5px;">Choose City</label>
                        <select class="select2 form-control" id="id_cit" name="city">
                            <option value=" ">Select City</option>
                            @foreach ($cities as $v_city)
                                <option value="{{ $v_city->id }}">{{ $v_city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-3 col-sm-12 m-b-20">
                        <label for="shipping" style="margin-bottom: 5px;">Shipping Status</label>
                        <select class="select2 form-control" name="shipping">
                            <option value="">Status Shipping</option>
                            <option value="unpacked" {{ 'unpacked' == request()->input('shipping') ? 'selected' : '' }}>
                                Unpacked</option>
                            <option value="picking process"
                                {{ 'picking process' == request()->input('shipping') ? 'selected' : '' }}>Picking Process
                            </option>
                            <option value="item packed"
                                {{ 'item packed' == request()->input('shipping') ? 'selected' : '' }}>Item Packed</option>
                            <option value="shipped" {{ 'shipped' == request()->input('shipping') ? 'selected' : '' }}>
                                Shipped</option>
                            <option value="in transit"
                                {{ 'in transit' == request()->input('shipping') ? 'selected' : '' }}>In Transit</option>
                            <option value="in delivery"
                                {{ 'in delivery' == request()->input('shipping') ? 'selected' : '' }}>In Delivery</option>
                            <option value="proseccing"
                                {{ 'proseccing' == request()->input('shipping') ? 'selected' : '' }}>Processing</option>
                            <option value="delivered" {{ 'delivered' == request()->input('shipping') ? 'selected' : '' }}>
                                Delivered</option>
                            <option value="incident" {{ 'incident' == request()->input('shipping') ? 'selected' : '' }}>
                                Incident</option>
                            <option value="rejected" {{ 'rejected' == request()->input('shipping') ? 'selected' : '' }}>
                                Rejected</option>
                            <option value="returned" {{ 'returned' == request()->input('shipping') ? 'selected' : '' }}>
                                Returned</option>
                        </select>
                    </div>
                    <div class="col-3 align-self-center">
                        <div class='theme-form mb-3'>
                            <label for="datepicker-range" style="margin-bottom: 5px;">Date Range (start date – end date)</label>
                            <input type="text" class="form-control flatpickr-input" name="date"
                                value="{{ request()->input('date') }}" id="datepicker-range" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 m-b-20">
                        <label for="select_product" style="margin-bottom: 5px;">Choose Product</label>
                        <select class="select2 form-control" id="select_product" name="id_prod"
                            placeholder="Selecte Product">
                            <option value="">Select Product</option>
                            @foreach ($proo as $v_product)
                                <option value="{{ $v_product->id }}"
                                    {{ $v_product->id == request()->input('id_prod') ? 'selected' : '' }}>
                                    {{ $v_product->name }} / {{ $v_product->sku }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-12 m-b-20">
                        <label for="select_market" style="margin-bottom: 5px;">Choose Market</label>
                        <select class="select2 form-control" id="select_market" name="market" placeholder="Selecte Market">
                            <option value="">Select Market</option>
                            <option value="Manual" {{ 'Manual' == request()->input('market') ? 'selected' : '' }}>
                                Manual</option>
                            <option value="Excel" {{ 'Excel' == request()->input('market') ? 'selected' : '' }}>
                                Excel</option>
                            <option value="Google Sheet"
                                {{ 'Google Sheet' == request()->input('market') ? 'selected' : '' }}>
                                Google Sheet</option>
                            <option value="Lightfunnels"
                                {{ 'Lightfunnels' == request()->input('market') ? 'selected' : '' }}>
                                Lightfunnels</option>
                            <option value="YouCan" {{ 'YouCan' == request()->input('market') ? 'selected' : '' }}>
                                YouCan</option>
                            <option value="Shopify" {{ 'Shopify' == request()->input('market') ? 'selected' : '' }}>
                                Shopify</option>
                            <option value="WooCommerce"
                                {{ 'WooCommerce' == request()->input('market') ? 'selected' : '' }}>
                                WooCommerce</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-3 col-sm-12 m-b-20 " style="margin-top:-25px;">
                        <label for="shipping_company" style="margin-bottom: 5px; ">Choose Shipping Company</label>
                        <select class="select2 form-control" id="shipping_company" name="shipping_company" placeholder="Selecte Shipping Company">
                            <option value="">Select Last Mille</option>
                            @foreach($lastmille as $v_lastmille)
                            <option value="{{ $v_lastmille->id}}" {{ $v_lastmille->id == request()->input('shipping_company') ? 'selected' : '' }}>{{ $v_lastmille->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 align-self-center">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary waves-effect btn-rounded m-t-10 mb-2"
                                style="width:100%">Search</button>
                        </div>
                    </div>
                    <div class="col-md-3 align-self-center">
                        <div class="form-group mb-0">
                            <a href="{{ route('leads.index') }}"
                                class="btn btn-primary waves-effect btn-rounded m-t-10 mb-2 " style="width:100%">Reset</a>
                        </div>
                    </div>
                    <div class="col-md-3 align-self-center">
                        <div class="form-group mb-0 ">
                            <a id="exportss2"
                                class="btn btn-primary btn-rounded m-t-10 mb-2 text-white"style="width:100%">Export data</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </ul>

    <!-- List History Popup Model -->
    <div class="modal fade" id="leadHistoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leadNameTitle">Lead History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="timeline" id="timelineContainer">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- List change status Popup Model -->
    <div class="modal fade" id="OrderChangeStatus" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leadNameTitle">Change Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="timeline" >
                        <input type="hidden" id="order-id" />
                        <select class="form-control" id="shipping-statu">
                            <option value="">Status Shipping</option>
                            <option value="in transit"
                                {{ 'in transit' == request()->input('shipping') ? 'selected' : '' }}>In Transit</option>
                            <option value="in delivery"
                                {{ 'in delivery' == request()->input('shipping') ? 'selected' : '' }}>In Delivery</option>
                            <option value="proseccing"
                                {{ 'proseccing' == request()->input('shipping') ? 'selected' : '' }}>Processing</option>
                            <option value="delivered" {{ 'delivered' == request()->input('shipping') ? 'selected' : '' }}>
                                Delivered</option>
                            <option value="incident" {{ 'incident' == request()->input('shipping') ? 'selected' : '' }}>
                                Incident</option>
                            <option value="rejected" {{ 'rejected' == request()->input('shipping') ? 'selected' : '' }}>
                                Rejected</option>
                            <option value="returned" {{ 'returned' == request()->input('shipping') ? 'selected' : '' }}>
                                Returned</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-primary" id="changestatu">Save</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body p-4 pb-0" data-simplebar="init">
                <div class="simplebar-wrapper" style="margin: -24px -24px 0px;">
                    <div class="simplebar-height-auto-observer-wrapper">
                        <div class="simplebar-height-auto-observer"></div>
                    </div>
                    <div class="simplebar-mask">
                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                            <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: auto; overflow: hidden;">
                                <div class="simplebar-content" style="padding: 24px 24px 0px;">
                                    <div class="row flex-nowrap">
                                        <div class="col-md-2">
                                            <div class="card primary-gradient">
                                                <div class="card-body text-center px-9 pb-4">
                                                    <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-primary flex-shrink-0 mb-3 mx-auto">
                                                    <iconify-icon icon="solar:dollar-minimalistic-linear" class="fs-7 text-white"></iconify-icon>
                                                    </div>
                                                    <h6 class="fw-normal fs-3 mb-1">Total Orders</h6>
                                                    <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">{{ $allLead->OrderCount('',request()->input('city'),request()->input('date'),request()->input('market'),request()->input('id_prod'))}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="card secondary-gradient">
                                                <div class="card-body text-center px-9 pb-4">
                                                    <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-info flex-shrink-0 mb-3 mx-auto">
                                                    <iconify-icon icon="ic:outline-forest" class="fs-7 text-white"></iconify-icon>
                                                    </div>
                                                    <h6 class="fw-normal fs-3 mb-1">Total Orders Unpacked</h6>
                                                    <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">{{ $allLead->OrderCount('unpacked',request()->input('city'),request()->input('date'),request()->input('market'),request()->input('id_prod'))}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="card success-gradient">
                                                <div class="card-body text-center px-9 pb-4">
                                                    <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-success flex-shrink-0 mb-3 mx-auto">
                                                    <iconify-icon icon="ic:outline-forest" class="fs-7 text-white"></iconify-icon>
                                                    </div>
                                                    <h6 class="fw-normal fs-3 mb-1">Total Orders Delivered</h6>
                                                    <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">{{ $allLead->OrderCount('delivered',request()->input('city'),request()->input('date'),request()->input('market'),request()->input('id_prod'))}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="card warning-gradient">
                                                <div class="card-body text-center px-9 pb-4">
                                                    <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-warning flex-shrink-0 mb-3 mx-auto">
                                                    <iconify-icon icon="solar:recive-twice-square-linear" class="fs-7 text-white"></iconify-icon>
                                                    </div>
                                                    <h6 class="fw-normal fs-3 mb-1">Total Orders Call Later</h6>
                                                    <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">{{ $allLead->OrderCount('call later',request()->input('city'),request()->input('date'),request()->input('market'),request()->input('id_prod'))}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="card secondary-gradient">
                                                <div class="card-body text-center px-9 pb-4">
                                                    <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-secondary flex-shrink-0 mb-3 mx-auto">
                                                    <iconify-icon icon="ic:outline-backpack" class="fs-7 text-white"></iconify-icon>
                                                    </div>
                                                    <h6 class="fw-normal fs-3 mb-1">Total leads No Answer</h6>
                                                    <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">{{ $allLead->OrderCount('no answer',request()->input('city'),request()->input('date'),request()->input('market'),request()->input('id_prod'))}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="card danger-gradient">
                                                <div class="card-body text-center px-9 pb-4">
                                                    <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-danger flex-shrink-0 mb-3 mx-auto">
                                                    <iconify-icon icon="ic:baseline-sync-problem" class="fs-7 text-white"></iconify-icon>
                                                    </div>
                                                    <h6 class="fw-normal fs-3 mb-1">Total Orders Returned</h6>
                                                    <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1">{{ $allLead->OrderCount('returned',request()->input('city'),request()->input('date'),request()->input('market'),request()->input('id_prod'))}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="simplebar-placeholder" style="width: 1170px; height: 249px;"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- start Default Size Light Table -->
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <div class="flex-grow-1">
                    <select id="pagination" class="form-control" style="width:80px">
                        <option value="10" @if ($items == 10) selected @endif>10</option>
                        <option value="50" @if ($items == 50) selected @endif>50</option>
                        <option value="100" @if ($items == 100) selected @endif>100</option>
                        <option value="250" @if ($items == 250) selected @endif>250</option>
                        <option value="500" @if ($items == 500) selected @endif>500</option>
                        <option value="1000" @if ($items == 1000) selected @endif>1000</option>
                    </select>
                </div>
                <div class="setting-list">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex mb-2 align-items-center">
                <div class="ms-auto flex-shrink-0">
                </div>
            </div>
            <div class="table-responsive border rounded-1" style="margin-top:-20px">
                <table class="table text-nowrap customize-table mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="selectall custom-control-input" id="chkCheckAll"
                                        required>
                                    <label class="custom-control-label" for="chkCheckAll"></label>
                                </div>
                            </th>
                            <th>ID</th>
                            <th>Market</th>
                            <th>Tracking Number</th>
                            <th>Products</th>
                            <th>Customer Name</th>
                            <th>City</th>
                            <th>Phone</th>
                            <th>Order Value</th>
                            <th>Shipping</th>
                            <th>Payment</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1;
                        ?>
                        @if (!$leads->isempty())
                            @foreach ($leads as $key => $v_lead)
                                <tr class="accordion-toggle data-item" data-id="{{ $v_lead['id'] }}">
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="ids"
                                                class="custom-control-input checkBoxClass" value="{{ $v_lead['id'] }}"
                                                id="pid-{{ $counter }}">
                                            <label class="custom-control-label" for="pid-{{ $counter }}"></label>
                                            {{-- {{ $v_lead['id_order'] }} --}}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $v_lead['n_lead'] }}</span>
                                    </td>
                                    <td>
                                        @if ($v_lead['market'] == 'Shopify')
                                            <i class="tf-icons ti ti-brand-shopee"
                                                style="margin-right: 10px;font-size: 33px;"></i>
                                        @elseif($v_lead['market'] == 'Google Sheet')
                                            <i class="tf-icons ti ti-brand-google"
                                                style="margin-right: 10px;font-size: 33px;"></i>
                                            {{-- @elseif($v_lead['market'] == 'WooCommerce')
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                style="margin-right: 10px;font-size: 33px;"
                                                class="icon icon-tabler icon-tabler-brand-wordpress"
                                                class="menu-icon icon icon-tabler icon-tabler-headset" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M9.5 9h3" />
                                                <path d="M4 9h2.5" />
                                                <path d="M11 9l3 11l4 -9" />
                                                <path d="M5.5 9l3.5 11l3 -7" />
                                                <path
                                                    d="M18 11c.177 -.528 1 -1.364 1 -2.5c0 -1.78 -.776 -2.5 -1.875 -2.5c-.898 0 -1.125 .812 -1.125 1.429c0 1.83 2 2.058 2 3.571z" />
                                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                            </svg> --}}
                                        @elseif($v_lead['market'] == 'Manual')
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                style="margin-right: 10px;font-size: 33px;" width="30" height="30"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class=" icon icon-tabler icons-tabler-outline icon-tabler-hand-click">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M8 13v-8.5a1.5 1.5 0 0 1 3 0v7.5" />
                                                <path d="M11 11.5v-2a1.5 1.5 0 0 1 3 0v2.5" />
                                                <path d="M14 10.5a1.5 1.5 0 0 1 3 0v1.5" />
                                                <path
                                                    d="M17 11.5a1.5 1.5 0 0 1 3 0v4.5a6 6 0 0 1 -6 6h-2h.208a6 6 0 0 1 -5.012 -2.7l-.196 -.3c-.312 -.479 -1.407 -2.388 -3.286 -5.728a1.5 1.5 0 0 1 .536 -2.022a1.867 1.867 0 0 1 2.28 .28l1.47 1.47" />
                                                <path d="M5 3l-1 -1" />
                                                <path d="M4 7h-1" />
                                                <path d="M14 3l1 -1" />
                                                <path d="M15 6h1" />
                                            </svg>
                                        @elseif($v_lead['market'] == 'Excel')
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                style="margin-right: 10px;font-size: 33px;" width="30" height="30"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-table-export">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M12.5 21h-7.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v7.5" />
                                                <path d="M3 10h18" />
                                                <path d="M10 3v18" />
                                                <path d="M16 19h6" />
                                                <path d="M19 16l3 3l-3 3" />
                                            </svg>
                                        @elseif($v_lead['market'] == 'api')
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                style="margin-right: 10px;font-size: 33px;" width="30" height="30"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-api">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 13h5" />
                                                <path d="M12 16v-8h3a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-3" />
                                                <path d="M20 8v8" />
                                                <path d="M9 16v-5.5a2.5 2.5 0 0 0 -5 0v5.5" />
                                            </svg>
                                        @elseif($v_lead['market'] == 'Lightfunnels')
                                            <img src="{{ asset('public/plateformes/lightlogo.png') }}" width="30"
                                                height="30" alt="Lightfunnels" style="filter: grayscale(100%);">
                                        @elseif($v_lead['market'] == 'YouCan')
                                            <img src="{{ asset('public/plateformes/youcanlogo.png') }}" width="30"
                                                height="30" alt="YouCan"
                                                style="background-color: rgb(178, 172, 172);">
                                        @elseif($v_lead['market'] == 'WooCommerce')
                                            <img src="{{ asset('public/plateformes/woocommerce-logo.png') }}"
                                                width="30" height="30" alt="YouCan"
                                                style="filter: grayscale(100%);">
                                        @else
                                            {{ $v_lead['market'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($v_lead['tracking'] != null)
                                            <a href="javascript:void(0)" id="tracking">
                                                {{ Str::limit($v_lead['tracking'], 20) }}</a>
                                        @elseif ($v_lead['tracking'] == null)
                                            <a href="javascript:void(0)">No Tracking</a>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($v_lead['product'] as $v_product)
                                            {{ Str::limit($v_product['name'], 20) }}
                                        @endforeach
                                    </td>
                                    <td>{{ $v_lead['name'] }}</td>
                                    <td>
                                        @if (!empty($v_lead['id_city']))
                                            @if (!empty($v_lead['cities'][0]['name']))
                                                @foreach ($v_lead['cities'] as $v_city)
                                                    {{ $v_city['name'] }}
                                                    <br>
                                                @endforeach
                                            @else
                                                {{ $v_lead['city'] }}
                                                <br>
                                            @endif
                                        @else
                                            {{ $v_lead['city'] }}
                                            <br>
                                        @endif
                                        {{ Str::limit($v_lead['address'], 10) }}
                                    </td>
                                    <td><a href="tel:{{ $v_lead['phone'] }}">{{ $v_lead['phone'] }}</a></td>
                                    <td>{{ $v_lead['lead_value'] }} {{ $countri->currency }}</td>
                                    <td>
                                        @if ($v_lead['status_livrison'] == 'unpacked')
                                            <span class="badge bg-warning">{{ $v_lead['status_livrison'] }}</span>
                                        @elseif($v_lead['status_livrison'] == 'delivered')
                                            <span class="badge bg-success">{{ $v_lead['status_livrison'] }}</span>
                                        @elseif($v_lead['status_livrison'] == 'returned')
                                            <span class="badge bg-danger">{{ $v_lead['status_livrison'] }}</span>
                                        @elseif($v_lead['status_livrison'] == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-danger">{{ $v_lead['status_livrison'] }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($v_lead['status_livrison'] == 'paid')
                                            <span class="badge bg-success">{{ $v_lead['status_livrison'] }}</span>
                                        @else
                                            <span class="badge bg-info">In Paid</span>
                                        @endif

                                    </td>
                                    <td>{{ $v_lead['created_at'] }}</td>
                                    <td>{{ $v_lead['updated_at'] }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle show" type="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i
                                                    class="icon-settings"></i></button>
                                            <div class="dropdown-menu" bis_skin_checked="1"
                                                style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(184px, -325.203px, 0px);"
                                                data-popper-placement="top-start">

                                                <a class="dropdown-item seehystory" id="seehystory" data-id="{{ $v_lead['id'] }}"> History</a>
                                                @if($v_lead['status_livrison'] != "delivered" && $v_lead['status_livrison'] != "returned")
                                                    <a class="dropdown-item shippingchange" data-id="{{ $v_lead['id']}}">Change Statu</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $counter = $counter + 1; ?>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="12">
                                    <div class="col-12">
                                        <img src="{{ asset('public/Empty-amico.svg') }}"
                                            style="margin-left: auto ; margin-right: auto; display: block;"
                                            width="500" />
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <span>Showing {{ $count }} of {{ $items }} orders</span>
             {{ $leads->links('vendor.pagination.courier') }}
        </div>
                <!-- Bulk Offers Modal -->
                <div class="modal fade" id="bulkOffersModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Send Bulk Offers</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="bulkOffersForm">
                                @csrf
                                <div class="modal-body">
                                    <div class="alert alert-info">
                                        <i class="ti ti-info-circle"></i> This will send offers to <span
                                            id="selectedLeadsCount">0</span> selected leads
                                    </div>
        
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Select Offer Template</label>
                                                <select class="form-select" id="bulkOfferTemplate" name="template_id" required>
                                                    <option value="">-- Select Template --</option>
                                                    @foreach ($offerTemplates as $template)
                                                        <option value="{{ $template->id }}">{{ $template->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
        
                                            <div class="mb-3">
                                                <label class="form-label">WhatsApp Account</label>
                                                <select class="form-select" name="whatsapp_account_id" required>
                                                    <option value="">-- Select WhatsApp Account --</option>
                                                    @foreach ($whatsappAccounts as $account)
                                                        <option value="{{ $account->id }}"
                                                            @if ($account->status != 'active') disabled @endif>
                                                            {{ $account->phone_number }}
                                                            @if ($account->status != 'active')
                                                                - {{ ucfirst($account->status) }}
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Select Product (Optional)</label>
                                                <select class="form-select" id="offerProduct" name="product_id">
                                                    <option value="">-- No Product --</option>
                                                    @foreach ($proo as $product)
                                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                            {{ $product->name }} ({{ $product->price }} DH)
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
        
                                            <div id="bulkVariablesContainer">
                                                <!-- Dynamic variables will be inserted here -->
                                            </div>
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6>Message Preview</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div id="bulkMessagePreview" class="bg-light p-3 rounded"
                                                        style="min-height: 200px;">
                                                        Select a template to preview
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="ti ti-brand-whatsapp"></i> Send to Selected Leads
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    </div>
    <!-- end Default Size Light Table -->
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="{{ asset('public/assets/libs/prismjs/prism.js') }}"></script>
    <!-- Page JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(function(e) {
                $('#changestatu').click(function(e) {
                    var id = $('#order-id').val();
                    var statu = $('#shipping-statu').val();
                    $.ajax({
                        url: '{{ route('orders.change') }}',
                        type: 'post',
                        data: {
                            'id': id,
                            'statu': statu,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            toastr.success('Good Job.', 'Order Has been Update Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });

                            location.reload();
                        }
                    });
                });
            });

        $(function(e) {
            $('.seehystory').click(function(e) {
                const leadId = $(this).data('id');
                loadLeadHistory(leadId);
            });
        });
        function loadLeadHistory(leadId) {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '');

            $('.modal.show').each(function() {
                const modalInstance = bootstrap.Modal.getInstance(this);
                if (modalInstance) {
                    modalInstance.hide();
                }
            });

            $.ajax({
                url: '{{ route('leads.seehistory') }}',
                type: 'GET',
                data: {
                    'id': leadId,
                },
                success: function(response) {
                    console.log(response);
                    const timeline = $('#timelineContainer');
                    timeline.empty();

                    if (response.length > 0) {
                        response.forEach(function(history) {
                            const leadNumber = history.lead[0]?.n_lead ?? 'N/A';
                            let statusDisplay = history.status ?
                            `<p><strong>Status:</strong> ${history.status}</p>` :
                            '';
                            let commentDisplay = history.comment ?
                            `<p><strong>Comment:</strong> ${history.comment}</p>` :
                            'There is no comment';

                            let agentDisplay = history.agent.length != 0 ?
                            `<p><strong>Agent:</strong> ${history.agent}</p>` :
                            '';

                            let deliveryDisplay = '';
                            if (history.delivery.length != 0) {
                                deliveryDisplay = `
                                <p><strong>Delivery:</strong></p>
                                <ul>
                                    <li><strong>Date:</strong> ${history.delivery.delivery_date || 'N/A'}</li>
                                    <li><strong>Time:</strong> ${history.delivery.delivery_time || 'N/A'}</li>
                                    <li><strong>Address:</strong> ${history.delivery.delivery_address || 'N/A'}</li>
                                </ul>
                                `;
                            }

                            timeline.append(`
                                    <div class="timeline-item">
                                        <div class="timeline-time">
                                              ${moment(history.created_at).format('YYYY-MM-DD')} 
                                              <strong>${moment(history.created_at).format('H:mm')}</strong>
                                        </div>
                                        <div class="timeline-content">
                                            <h6><a href="/leads/edit/${leadId}" target="_blank">Lead #${leadNumber}</a></h6>
                                            ${statusDisplay}
                                            ${commentDisplay}
                                            ${deliveryDisplay}
                                            ${agentDisplay}
                                        </div>
                                    </div>
                                `);
                        });
                    } else {
                            timeline.html('<p>No activity recorded for this lead.</p>');
                    }

                        const modal = new bootstrap.Modal(document.getElementById('leadHistoryModal'));
                        modal.show();
                },
                error: function() {
                    alert('Error loading lead history');
                }
            });
        }

        function formatTime(timestamp) {
            const date = new Date(timestamp);
            return date.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
            });
        }
    </script>
    @verbatim
    <script type="text/javascript">
        $(function(e) {
            $('.shippingchange').click(function(e) {
                $('#order-id').val($(this).data('id'));
                $('#OrderChangeStatus').modal('show');
            });
        });
    </script>
    <script type="text/javascript">
        

        $(function(e) {
            $('#confirmed').click(function(e) {
                //console.log(namecustomer);
                $('#searchdetails').modal('show');
            });
        });
        

        $(function(e) {
            $('#cancel').click(function(e) {
                //console.log(namecustomer);
                $('#canceledform').modal('show');
            });
        });

    </script>
    <script type="text/javascript">


        //Export
        $(function(e) {
            $("#chkCheckAll").click(function() {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });
            $('#exportss').click(function(e) {
                e.preventDefault();
                var allids = [];
                $("input:checkbox[name=ids]:checked").each(function() {
                    allids.push($(this).val());
                });
                if (allids != '') {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('leads.export') }}",
                        cache: false,
                        data: {
                            ids: allids,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response, leads) {
                            $.each(allids, function(key, val, leads) {
                                var a = JSON.stringify(allids);
                                window.location = ('leads/export-download/' + a);
                            });
                        }
                    });
                } else {
                    toastr.warning('Opss.', 'Please Selected Leads!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                }
            });
            //export date
            $('#exportss2').click(function(e) {
                e.preventDefault();
                var allids = [];
                $("input:checkbox[name=ids]:checked").each(function() {
                    allids.push($(this).val());
                });
                var date = $('#flatpickr-range').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('leads.exports') }}",
                    cache: false,
                    data: {
                        date: date,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response, leads) {
                        $.each(response, function(key, val, leads) {
                            var a = response;
                            window.location = ('leads/export-downloads/' + a);
                        });
                    }
                });
            });

        });



        $('#searchdetai').click(function(e) {
            e.preventDefault();
            var n_lead = $('#search_2').val();
            $('#listlead').modal('show');
            //console.log(agent);
            $.ajax({
                type: "get",
                url: "{{ route('leads.leadsearch') }}",
                data: {
                    n_lead: n_lead,
                },
                success: function(data) {
                    $('#listleadss').html(data);
                }
            });
        });



        function toggleText() {
            var x = document.getElementById("multi");
            $('#timeseconds').val('');
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>


    <script>
        $("#chkCheckAll").click(function() {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
        });
        document.getElementById('pagination').onchange = function() {
            const url = new URL(window.location.href);
            const params = url.searchParams;
            
            [...params.keys()].forEach(key => {
                if(params.get(key) === '' || params.get(key) === ' ') {
                    params.delete(key);
                }
            });
            params.set('items', this.value);
            url.search = params.toString();
            window.location.href = url.toString();

        };
        $('#sendBulkOffersBtn').click(function() {
            const selectedLeads = $('input[name="ids"]:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedLeads.length === 0) {
                toastr.warning('Please select at least one lead');
                return;
            }

            $('#selectedLeadsCount').text(selectedLeads.length);
            $('#bulkOffersModal').modal('show');
        });

        $('#bulkOfferTemplate').change(function() {
            const templateId = $(this).val();
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            
            if (!templateId) {
                $('#bulkVariablesContainer').empty();
                $('#bulkMessagePreview').text('Select a template to preview');
                return;
            }

            $.ajax({
                url: '/whatsapp-offers/get-template-details',
                method: 'POST',
                data: {
                    _token: csrfToken,
                    id: templateId,
                },
                success: function(response) {
                    if (response.success) {
                        $('#bulkMessagePreview').html(response.template);
                        const variables = extractVariables(response.template);
                        generateBulkVariableInputs(variables);
                    }
                }
            });
        });

        function generateBulkVariableInputs(variables) {
            const container = $('#bulkVariablesContainer');
            container.empty();

            variables.forEach(variable => {
                const label = variable.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                const inputId = `bulk-var-${variable}`;
                
                const inputGroup = `
                    <div class="mb-3">
                        <label for="${inputId}" class="form-label">${label}</label>
                        <input type="text" class="form-control" 
                            id="${inputId}" name="${variable}" 
                            oninput="updateBulkPreview()">
                    </div>
                `;
                
                container.append(inputGroup);
            });
        }

        window.updateBulkPreview = function() {
            let template = $('#bulkMessagePreview').html();
            const variables = extractVariables(template);
            
            variables.forEach(variable => {
                const value = $(`#bulkOffersModal input[name="${variable}"]`).val() || '';
                const regex = new RegExp(`{{\\s*${variable}\\s*}}`, 'g');
                template = template.replace(regex, value);
            });
            
            $('#bulkMessagePreview').html(template);
        };

        $('#bulkOffersForm').submit(function(e) {
            e.preventDefault();
            
            const selectedLeads = $('input[name="ids"]:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedLeads.length === 0) {
                toastr.warning('Please select at least one lead');
                return;
            }

            const formData = $(this).serializeArray();
            formData.push({name: 'lead_ids', value: selectedLeads.join(',')});

            $.ajax({
                url: '/whatsapp-offers/send-bulk-offers',
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    $('#bulkOffersForm button[type="submit"]').prop('disabled', true)
                        .prepend('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>');
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(`Offers sent successfully to ${response.sent_count} leads`);
                        $('#bulkOffersModal').modal('hide');
                    } else {
                        toastr.error(response.message || 'Failed to send offers');
                    }
                },
                error: function(xhr) {
                    toastr.error('An error occurred while sending offers');
                },
                complete: function() {
                    $('#bulkOffersForm button[type="submit"]').prop('disabled', false)
                        .find('.spinner-border').remove();
                }
            });
        });

        $('#offerProduct').change(function() {
                const product = $(this).find(':selected');
                console.log()
                if (product.val()) {
                    $('input[name="product-name"]').val(product.text().split('(')[0].trim());
                    $('input[name="special-price"]').val(product.data('price'));
                    updatePreview();
                }
        });

        function extractVariables(template) {
            const regex = /{{\s*([^}\s]+)\s*}}/g;
            const variables = [];
            let match;
            
            while ((match = regex.exec(template)) !== null) {
                variables.push(match[1]);
            }
            
            return [...new Set(variables)];
        }
    </script>
    @endverbatim

@endsection
@endsection
