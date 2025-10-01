@extends('backend.layouts.app')
@section('content')
<style>
    .hiddenRow {
        padding: 0 !important;
        }
   
</style>
@if(Auth::user()->id_role != "3")
<style>
    .multi{
        display: none;
    }
</style>
@endif
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">

            <!-- ============================================================== -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-10 align-self-center">
                            <h3 class="page-title">Situation Delivred</h3>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <div class="row my-4">
                    <div class="col-12">
                        <!-- Column -->
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <form>
                                    <div class="row">                                        
                                        <div class="col-md-11 col-sm-12">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" name="search" id="search" placeholder="Ref , Price" aria-label="" aria-describedby="basic-addon1">
                                            </div>
                                        </div>                                        
                                        <div class="col-md-1 col-sm-12">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" onclick="toggleText()">Multi</button>
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
                                    <table id=""  class="table table-bordered table-striped table-hover contact-list" data-paging="true" data-paging-size="7">
                                        <thead >
                                            <tr>
                                                <th>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="selectall custom-control-input" id="chkCheckAll" required>
                                                        <label class="custom-control-label" for="chkCheckAll"></label>
                                                    </div>
                                                </th>
                                                <th>N Order</th>
                                                <th>Name Customer</th>
                                                <th>Status Livrison</th>
                                                <th>Status Payment</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="alldata">
                                            <?php
                                            $counter = 1;
                                            ?>
                                            @foreach($orders as $v_delivred)
                                            <tr class="accordion-toggle data-item" data-id="{{ $v_delivred->id}}">
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="ids" class="custom-control-input checkBoxClass"  value="{{$v_delivred->id}}" id="pid-{{$counter}}">
                                                        <label class="custom-control-label" for="pid-{{$counter}}"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $v_delivred->n_lead }}</td>
                                                <td>{{ $v_delivred->name }}</td>
                                                <td>{{ $v_delivred->status_livrison}}</td>
                                                <td>{{ $v_delivred->status_payment }}</td>
                                                <td>
                                                    <a href="{{ route('payment.details', $id )}}" class="text-inverse pr-2" data-toggle="tooltip" title="All Orders"><i class="ti-marker-alt"></i></a>
                                                </td>
                                            </tr>
                                            <?php $counter = $counter + 1; ?>
                                            @endforeach
                                        </tbody>
                                        <tbody id="contentdata" class="datasearch"></tbody>
                                    </table>
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
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                All Rights Reserved by FULFILLEMENT ADMIN. Designed and Developed by <a href="Palace Agency.eu">Palace Agency</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->

@endsection