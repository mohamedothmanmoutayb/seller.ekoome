@extends('backend.layouts.app')
@section('content')
    <style>
        .form-group-1 {
            margin-bottom: 16px;
        }


        .label-process {
            background-color: #ff6334;
        }

        .card-box {
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 10%), 0 1px 2px 0 rgb(0 0 0 / 6%);
        }

        .rounded-lg {
            border-radius: 0.5rem;
        }

        .space-x-3>:not(template)~:not(template) {
            --space-x-reverse: 0;
            margin-right: calc(0.25rem*var(--space-x-reverse));
            margin-left: calc(0.25rem*(1 - var(--space-x-reverse)))
        }

        .w-full {
            width: 100%;
        }

        .flex {
            display: flex;
        }

        .w-12 {
            width: 3rem;
        }

        .h-12 {
            height: 3rem;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .bg-gray-100 {
            --bg-opacity: 1;
            background-color: #f7fafc;
            background-color: rgba(247, 250, 252, var(--bg-opacity));
        }

        .text-blue-400 {
            --text-opacity: 1;
            color: #63b3ed;
            color: rgba(99, 179, 237, var(--text-opacity));
        }

        .p-3 {
            padding: 0.75rem;
        }

        .material-icons {
            font-family: Material Icons;
            font-weight: 400;
            font-style: normal;
            font-size: 24px;
            display: inline-block;
            line-height: 1;
            text-transform: none;
            letter-spacing: normal;
            word-wrap: normal;
            white-space: nowrap;
            direction: ltr;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
            -moz-osx-font-smoothing: grayscale;
            font-feature-settings: "liga";
        }

        .w-full {
            width: 100%;
        }

        .ml-5 {
            margin-left: 1.25rem;
        }

        .text-gray-700 {
            --text-opacity: 1;
            color: #4a5568;
            color: rgba(74, 85, 104, var(--text-opacity));
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        .text-base {
            font-size: 1rem;
        }

        .font-semibold {
            font-weight: 600;
        }

        .space-y-2>:not(template)~:not(template) {
            --space-y-reverse: 0;
            margin-top: calc(0.5rem*(1 - var(--space-y-reverse)));
            margin-bottom: calc(0.5rem*var(--space-y-reverse));
        }

        .text-gray-600 {
            --text-opacity: 1;
            color: #718096;
            color: rgba(113, 128, 150, var(--text-opacity));
        }

        .text-sm {
            font-size: .875rem;
        }

        .w-auto {
            width: auto;
        }

        .normal-case {
            text-transform: none;
        }

        .text-gray-700 {
            --text-opacity: 1;
            color: #4a5568;
            color: rgba(74, 85, 104, var(--text-opacity));
        }

        .text-center {
            text-align: center;
        }

        .pl-3 {
            padding-left: 0.75rem;
        }

        .pr-2 {
            padding-right: 0.5rem;
        }

        .p-1 {
            padding: 0.25rem;
        }

        .text-xs {
            font-size: .75rem;
        }

        .font-semibold {
            font-weight: 600;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        span.info {
            text-decoration: underline;
            font-size: revert;
        }
    </style>
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="content-wrapper">

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 align-self-center ">
                        <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                class="text-muted fw-light">Leads /</span> Order details &nbsp;
                        </h4>
                    </div>
                </div>
            </div>
            {{-- <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-5 align-self-center">
                            <h4 class="page-title">Order details</h4>
                            <div class="d-flex align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Library</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        
                        <div class="col-7 align-self-center">
                        <div class="form-group mb-0 text-right">
    
                        </div>
                    </div>
                </div> --}}
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"style="font-size: 25px;">
                                <i class="mdi mdi-menu font-50" style="margin-right: 30px;"></i>Details
                            </h4>
                            <form class="form pt-3"style="margin-left: 39px;">
                                <div class="form-group-1">
                                    <label>Lead Number : <span class="info">{{ $lead->n_lead }}</span></label>
                                </div>
                                <div class="form-group-1">
                                    <label>Total Price : <span class="info">{{ $lead->lead_value }}</span></label>
                                </div>
                                <div class="form-group-1">
                                    <label>Payment methode : <span class="info">
                                            @if ($lead->ispaidapp == 1)
                                                Prepaid
                                            @else
                                                COD
                                            @endif
                                        </span></label>
                                </div>
                                <div class="form-group-1">
                                    <label>Created at : <span class="info">{{ $lead->created_at }}</span></label>
                                </div>
                                <div class="form-group-1">
                                    <label>Confirmation date : <span class="info">
                                            @if ($lead->status_confirmation != 'new order')
                                                {{ $lead->last_status_change }}
                                            @endif
                                        </span></label>
                                </div>
                                <div class="form-group-1">
                                    <label>Shipping date : <span class="info">
                                            @if ($lead->status_livrison != 'unpacked')
                                                {{ $lead->date_shipped }}
                                            @endif
                                        </span></label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"style="font-size: 25px;">
                                <i class="mdi mdi-account-circle" style="margin-right: 30px;"></i>Customer Information
                            </h4>
                            <form class="form pt-3"style="margin-left: 39px;">
                                <div class="form-group-1">
                                    <label>Full Name : <span class="info">{{ $lead->name }}</span></label>
                                </div><!--
                                        <div class="form-group-1">
                                            <label>Shipping Address : <span class="info">{{ $lead->address }}</span></label>
                                        </div>-->
                                <div class="form-group-1">
                                    <label>Address : <span class="info">{{ $lead->address }}</span></label>
                                </div>
                                <div class="form-group-1">
                                    <label>City : <span class="info">
                                            @if (!empty($lead->id_city))
                                                @if (!empty($lead['cities'][0]['name']))
                                                    {{ $lead['cities'][0]['name'] }}
                                                @else
                                                    {{ $lead->city }}
                                                @endif
                                            @else
                                                {{ $lead->city }}
                                            @endif
                                        </span></label> &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp<label>Province : <span
                                            class="info"> {{ $lead->province }}</span></label>
                                </div>
                                <div class="form-group-1">
                                    <label>Postal Code : <span class="info">{{ $lead->zipcod }}</span></label>
                                </div>
                                <div class="form-group-1">
                                    <label>Phone Number: <span class="info">{{ $lead->phone }}</span></label>
                                </div>
                                <div class="form-group-1">
                                    <label>Email : <span class="info">{{ $lead->email }}</span></label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title"style="font-size: 25px;">
                                <i class="mdi mdi-shopping font-50" style="margin-right: 30px;"></i>Product Detail
                            </h4>
                            <div class="table-responsive">
                                <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-paging="true"
                                    data-paging-size="7">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Product Image</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="alldata">
                                        @foreach ($leadproduct as $v_product)
                                            <tr>
                                                @foreach ($v_product['product'] as $v_pro)
                                                    <td>{{ $v_pro->name }}</td>
                                                    <td><img src="{{ $v_pro->image }}" style="width: 51px;" /></td>
                                                @endforeach
                                                <td>{{ $v_product->quantity }}</td>
                                                <td>{{ $v_product->lead_value }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody id="contentdata" class="datasearch"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title"style="font-size: 25px;">
                                <i class="mdi mdi-shopping font-50" style="margin-right: 30px;"></i>Upsell Detail
                            </h4>
                            <div class="table-responsive">
                                <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-paging="true"
                                    data-paging-size="7">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Product Image</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="alldata">
                                        @foreach ($upsel as $v_upsel)
                                            <tr>
                                                @foreach ($v_upsel['product'] as $v_product)
                                                    <td>{{ $v_product->name }}</td>
                                                    <td><img src="{{ $v_product->image }}" style="width: 51px;" /></td>
                                                @endforeach
                                                <td>{{ $v_upsel->quantity }}</td>
                                                <td>{{ $v_upsel->lead_value }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody id="contentdata" class="datasearch"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title"style="font-size: 25px;">
                                <i class="mdi mdi-history font-50" style="margin-right: 30px;"></i>Status History
                            </h4>
                            <div class="table-responsive">
                                <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-paging="true"
                                    data-paging-size="7">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Comment</th>
                                            <th>Date Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="alldata">
                                        @foreach ($history as $v_history)
                                            <tr>
                                                <td>{{ $v_history->status }}</td>
                                                <td>{{ $v_history->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    @if ($v_history->status == 'call later')
                                                        {{ $v_history->date }}
                                                    @elseif($v_history->status == 'postponed')
                                                        {{ $v_history->date }}
                                                    @else
                                                        {{ $v_history->comment }}
                                                    @endif
                                                </td>
                                                <td>{{ $v_history->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody id="contentdata" class="datasearch"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title"style="font-size: 25px;">
                                <i class="mdi mdi-history font-50" style="margin-right: 30px;"></i>List Reclamations
                            </h4>
                            <div class="table-responsive">
                                <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list"
                                    data-paging="true" data-paging-size="7">
                                    <thead>
                                        <tr>
                                            <th>Note</th>
                                            <th>Status</th>
                                            <th>Created at</th>
                                        </tr>
                                    </thead>
                                    <tbody class="alldata">
                                        @foreach ($reclamation as $v_reclamation)
                                            <tr>
                                                <td>{{ $v_reclamation->note }}</td>
                                                <td>{{ $v_reclamation->status }}</td>
                                                <td>{{ $v_reclamation->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
