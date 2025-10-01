@extends('backend.layouts.app')
@section('content')
    <style>
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

        .form-group {

            margin-bottom: 1rem !important;
        }
    </style>
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="content-wrapper">

        <!-- ============================================================== -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 align-self-center ">
                        <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                class="text-muted fw-light">Leads /</span> Order Details &nbsp;
                        </h4>
                    </div>
                </div>
            </div>
            {{-- <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-5 align-self-center">
                            <h4 class="page-title" style="font-size: 27px;"><a href="{{ url()->previous()}}"> <i class="mdi mdi-arrow-left-drop-circle-outline"></i></a>Order Details</h4>
                        </div>
                    </div>
                </div> --}}
            <!-- ============================================================== -->
            <div class="row my-4">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"style="font-size: 25px;">
                                <i class="mdi mdi-menu font-50" style="margin-right: 30px;"></i>Details
                            </h4>
                            <form class="form pt-3"style="margin-left: 39px;">

                                <div class="form-group">
                                    <label>Seller : <span class="info">{{ $lead->seller->name }}</span></label>
                                </div>
                                <div class="form-group">
                                    <label>Shipping Address : <span class="info">{{ $lead->address }}</span></label>
                                </div>
                                <div class="form-group">
                                    <label>Total Price : <span class="info">{{ $lead->lead_value }}</span></label>
                                </div>
                                <div class="form-group">
                                    <label>Shipping date : <span class="info">{{ $lead->date_delivred }}</span></label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card" style="height: 280px;">
                        <div class="card-body">
                            <h4 class="card-title"style="font-size: 25px;">
                                <i class="mdi mdi-account-circle" style="margin-right: 30px;"></i>Customer Information
                            </h4>
                            <form class="form pt-3"style="margin-left: 39px;">
                                <div class="form-group">
                                    <label>Full Name : <span class="info">{{ $lead->name }}</span></label>
                                </div>
                                <div class="form-group">
                                    <label>Shipping Address : <span class="info">{{ $lead->address }}</span></label>
                                </div>
                                <div class="form-group">
                                    <label>Phone Number 1 : <span class="info">{{ $lead->phone }}</span></label>
                                </div>
                                <div class="form-group">
                                    <label>Phone Number 2 : <span class="info">{{ $lead->phone2 }}</span></label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title"style="font-size: 25px;">
                                <i class="mdi mdi-shopping font-50" style="margin-right: 30px;"></i>Product Details
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
                                        @foreach ($lead->leadproduct as $v_upsel)
                                            <tr>
                                                @foreach ($v_upsel['product'] as $v_product)
                                                    <td>{{ $v_product->name }}</td>
                                                    <td><img src="https://client.FULFILLEMENT.com/uploads/products/{{ $v_product->image }}"
                                                            style="width: 51px;" /></td>
                                                @endforeach
                                                <td>{{ $v_upsel->quantity }}</td>
                                                @foreach ($v_upsel['product'] as $v_product)
                                                    <td>{{ $v_product->price }}</td>
                                                @endforeach
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
            {{-- <div class="row my-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title"style="font-size: 25px;">
                                <i class="mdi mdi-cart-plus font-50" style="margin-right: 30px;"></i>Upsell Details
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
                                        @foreach ($upsel->where('isupsell', '1') as $v_upsel)
                                            <tr>
                                                @foreach ($v_upsel['product'] as $v_product)
                                                    <td>{{ $v_product->name }}</td>
                                                    <td><img src="https://client.FULFILLEMENT.com/uploads/products/{{ $v_product->image }}"
                                                            style="width: 51px;" /></td>
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title"style="font-size: 25px;">
                                <i class="mdi mdi-basket-unfill font-50" style="margin-right: 30px;"></i>Crosell Details
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
                                        @foreach ($upsel->where('iscrosell', '1') as $v_upsel)
                                            <tr>
                                                @foreach ($v_upsel['product'] as $v_product)
                                                    <td>{{ $v_product->name }}</td>
                                                    <td><img src="https://client.FULFILLEMENT.com/uploads/products/{{ $v_product->image }}"
                                                            style="width: 51px;" /></td>
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
            </div> --}}
            <div class="row my-4">
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
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Date Action</th>
                                            <th>Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody class="alldata">
                                        @foreach ($history as $v_history)
                                            <tr>
                                                <td>{{ $v_history->creaetd_at }}</td>
                                                <td>{{ $v_history->status }}</td>
                                                <td>{{ $v_history->date }}</td>
                                                <td>{{ $v_history->comment }}</td>
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title"style="font-size: 25px;">
                                <i class="mdi-information-outline-circle font-50" style="margin-right: 30px;"></i>List
                                Reclamations
                            </h4>
                            <div class="table-responsive">
                                <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-paging="true"
                                    data-paging-size="7">
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
