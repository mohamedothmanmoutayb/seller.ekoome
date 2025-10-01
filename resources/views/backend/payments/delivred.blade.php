@extends('backend.layouts.app')
@section('content')
    <style>
        .hiddenRow {
            padding: 0 !important;
        }
    </style>

    <!-- ============================================================== -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-4 align-self-center ">
                        <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                class="text-muted fw-light">Dashboard /</span> Situation Delivred &nbsp;

                        </h4>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <div class="row mb-2">
                <div class="col-12">
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <form>
                                    <div class="row">
                                        <div class="col-md-11 col-sm-12">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" name="search"
                                                    value="{{ old('search') }}" id="search"
                                                    placeholder=" Name , Phone , Email" aria-label=""
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-sm-12">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="form-group multi mt-3">
                                <form>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 my-2">
                                            <input type="text" class="form-control" id="search_ref" name="ref"
                                                placeholder="name">
                                        </div>
                                        <div class="col-md-3 col-sm-12 my-2">
                                            <input type="text" class="form-control" name="customer" placeholder="email">
                                        </div>
                                        <div class="col-md-3 col-sm-12 my-2">
                                            <input type="text" class="form-control" name="phone1" placeholder="Phone ">
                                        </div>
                                        <div class="col-md-3 col-sm-12 align-self-center">
                                            <div class='input-group'>
                                                <input type="text" class="form-control dated" id="flatpickr-range" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 col-sm-4 align-self-center">
                                            <div class="form-group mb-0">
                                                <button type="submit"
                                                    class="btn btn-primary waves-effect btn-rounded m-t-10 mb-2 "
                                                    style="width:100%">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-4 align-self-center">
                                            <div class="form-group mb-0">
                                                <a href="{{ route('payment.delivred') }}"
                                                    class="btn btn-primary waves-effect btn-rounded m-t-10 mb-2 "
                                                    style="width:100%">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-12">
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="" class="table table-bordered table-striped table-hover contact-list"
                                    data-paging="true" data-paging-size="7">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="selectall custom-control-input"
                                                        id="chkCheckAll" required>
                                                    <label class="custom-control-label" for="chkCheckAll"></label>
                                                </div>
                                            </th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Telephone</th>
                                            <th>Order</th>
                                            <th>Order Shipped</th>
                                            <th>Order Delivered</th>
                                            <th>Order Canceled</th>
                                            <th>Order Returned</th>
                                            <th>Amount Paid</th>
                                            <th>Amount Not Paid</th>
                                            <th>Created at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="alldata">
                                        <?php
                                        $counter = 1;
                                        ?>
                                        @foreach ($delivred as $v_delivred)
                                            <tr class="accordion-toggle data-item" data-id="{{ $v_delivred->id }}">
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="ids"
                                                            class="custom-control-input checkBoxClass"
                                                            value="{{ $v_delivred->id }}" id="pid-{{ $counter }}">
                                                        <label class="custom-control-label"
                                                            for="pid-{{ $counter }}"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $v_delivred->name }}</td>
                                                <td>{{ $v_delivred->email }}</td>
                                                <td>{{ $v_delivred->telephone }}</td>
                                                <td>
                                                    @if ($dated == $datef)
                                                        {{ $v_delivred['History']->where('id_delivery', $v_delivred->id)->where('created_at', $dated)->count() }}
                                                    @else
                                                        {{ $v_delivred['History']->where('id_delivery', $v_delivred->id)->whereBetween('created_at', [$dated, $datef])->count() }}
                                                    @endif

                                                </td>
                                                <td>
                                                    @if ($dated == $datef)
                                                        {{ $v_delivred['History']->where('status', 'shipped')->where('created_at', $dated)->count() }}
                                                    @else
                                                        {{ $v_delivred['History']->where('status', 'shipped')->whereBetween('created_at', [$dated, $datef])->count() }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($dated == $datef)
                                                        {{ $v_delivred['History']->where('status', 'delivered')->where('created_at', $dated)->count() }}
                                                    @else
                                                        {{ $v_delivred['History']->where('status', 'delivered')->whereBetween('created_at', [$dated, $datef])->count() }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($dated == $datef)
                                                        {{ $v_delivred['History']->where('status', 'canceled')->where('created_at', $dated)->count() }}
                                                    @else
                                                        {{ $v_delivred['History']->where('status', 'canceled')->whereBetween('created_at', [$dated, $datef])->count() }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($dated == $datef)
                                                        {{ $v_delivred['History']->where('id_delivery', $v_delivred->id)->where('status', 'return')->where('created_at', $dated)->count() }}
                                                    @else
                                                        {{ $v_delivred['History']->where('id_delivery', $v_delivred->id)->where('status', 'return')->whereBetween('created_at', [$dated, $datef])->count() }}
                                                    @endif
                                                </td>
                                                <td><?php $paid = 0; ?>
                                                    @foreach ($v_delivred['History'] as $v_su)
                                                        @foreach ($v_su['leadlivreur'] as $v_sus)
                                                            <?php $paid =
                                                                $paid +
                                                                $v_sus
                                                                    ->where('livreur_id', $v_delivred->id)
                                                                    ->where('status_livrison', 'delivered')
                                                                    ->whereIn('status_payment', ['paid service', 'paid'])
                                                                    ->sum('lead_value'); ?>
                                                        @endforeach
                                                    @endforeach
                                                    {{ $paid }}
                                                </td>
                                                <td><?php $notpaid = 0; ?>
                                                    @foreach ($v_delivred['History'] as $v_su)
                                                        @foreach ($v_su['leadlivreur'] as $v_sus)
                                                            <?php $notpaid =
                                                                $notpaid +
                                                                $v_sus
                                                                    ->where('livreur_id', $v_delivred->id)
                                                                    ->where('status_livrison', 'delivered')
                                                                    ->where('status_payment', 'no paid')
                                                                    ->sum('lead_value'); ?>
                                                        @endforeach
                                                    @endforeach
                                                    {{ $notpaid }}
                                                </td>
                                                <td>{{ $v_delivred->created_at }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle show" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="icon-settings"></i></button>
                                                        <div class="dropdown-menu" bis_skin_checked="1" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(184px, -325.203px, 0px);" data-popper-placement="top-start">                          
                                                            <a class="dropdown-item" href="{{ route('payment.details', $v_delivred->id) }}" > Order Not Paid</a>
                                                            <a class="dropdown-item " href="{{ route('payment.orders', $v_delivred->id) }}" id="">All Order</a>
                                                        </div>
                                                        <button class="btn p-0" type="button" id="earningReports" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">                          
                                                        </div>
                                                    </div> 

                                                </td>
                                            </tr>
                                            <?php $counter = $counter + 1; ?>
                                        @endforeach
                                    </tbody>
                                    <tbody id="contentdata" class="datasearch"></tbody>
                                </table>
                                {{ $delivred->withQueryString()->links('vendor.pagination.courier') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right sidebar -->
            <!-- ============================================================== -->
            <!-- .right-sidebar -->
            <!-- ============================================================== -->
            <!-- End Right sidebar -->
            <!-- ============================================================== -->
        </div>

    <div class="content-backdrop fade"></div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
@endsection
