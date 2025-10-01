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
        <div class="content-wrapper">
           
            <!-- create lead manule -->
            <div id="add-manual" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 720px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">New Lead</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <form class="form-horizontal form-material">
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 m-b-20">
                                            <input type="hidden" class="form-control" id="lead_id" placeholder="Name Customer">
                                            <input type="text" class="form-control" id="name_customer" placeholder="Name Customer">
                                        </div>
                                        <div class="col-md-4 col-sm-12 m-b-20">
                                            <input type="text" class="form-control" id="mobile" placeholder="Mobile">
                                        </div>
                                        <div class="col-md-4 col-sm-12 m-b-20">
                                            <input type="text" class="form-control" id="mobile2" placeholder="Mobile 2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 m-b-20">
                                            <select class="form-control" placeholder="Select Country" id="id_country">
                                                <option>Select Country</option>
                                                @foreach($countries as $v_country)
                                                <option value="{{ $v_country->id}}">{{ $v_country->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 m-b-20">
                                            <select class="form-control" id="id_city">
                                                <option>Select City</option>
                                                @foreach($cities as $v_city)
                                                <option value="{{ $v_city->id}}">{{ $v_city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 m-b-20">
                                            <select class="form-control" id="id_zone">
                                                <option>Select Zone</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 m-b-20">
                                            <select class="form-control" id="id_product">
                                                <option>Select Product</option>
                                                @foreach($products as $v_product)
                                                @foreach($v_product['products'] as $products)
                                                <option value="{{ $products['id']}}">{{ $products['name']}}</option>
                                                @endforeach
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-12 m-b-20">
                                            <input type="number" class="form-control" id="quantity" placeholder="Quantity">
                                        </div>
                                        <div class="col-md-4 col-sm-12 m-b-20">
                                            <input type="text" class="form-control" id="total" placeholder="Total Price">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 m-b-20">
                                        <textarea type="text" class="form-control" id="address" placeholder="Address"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info waves-effect" id="savelead">Save</button>
                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-10 align-self-center">
                            <h3 class="page-title">Leads</h3>
                        </div>
                        <div class="col-2 align-self-center">
                            <div class="form-group mb-0 text-right">
                                <button type="button" class="btn btn-info btn-rounded waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#add-manual">Add New Lead</button>
                            </div>
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
                                                <input type="text" class="form-control" name="search" id="search" placeholder="Ref , Name Customer , Phone , Price" aria-label="" aria-describedby="basic-addon1">
                                            </div>
                                        </div>                                        
                                        <div class="col-md-1 col-sm-12">
                                            <div class="input-group-append">
                                                <button class="btn btn-info" type="button" onclick="toggleText()">Multi</button>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="form-group multi" id="multi" >
                                    <form>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 m-b-20">
                                            <input type="text" class="form-control" id="search_ref" name="ref" placeholder="Ref">
                                        </div>
                                        <div class="col-md-3 col-sm-12 m-b-20">
                                            <input type="text" class="form-control" name="customer" placeholder="Customer Name">
                                        </div>
                                        <div class="col-md-3 col-sm-12 m-b-20">
                                            <input type="text" class="form-control" name="phone1" placeholder="Phone ">
                                        </div>
                                        <div class="col-md-3 col-sm-12 m-b-20">
                                            <select class="form-control" id="id_cit" name="city" >
                                                <option value="">Select City</option>
                                                @foreach($cities as $v_city)
                                                <option value="{{ $v_city->id}}">{{ $v_city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 m-b-20">
                                            <label>Status Confirmation</label>
                                            <select class="select2 form-control" name="confirmation[]" multiple="multiple" style="width: 100%;height: 36px;">
                                                <option value="">Status Confirmation</option>
                                                <option value="new order">New Order</option>
                                                <option value="confirmed">Confirmed</option>
                                                <option value="no answer">No answer</option>
                                                <option value="call later">Call later</option>
                                                <option value="canceled">Canceled</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-12 m-b-20">
                                            <label>Status Shipping</label>
                                            <select class="select2 form-control" name="livraison[]" multiple="multiple" style="width: 100%;height: 36px;">
                                                <option value="">Status Livraison</option>
                                                <option value="unpacked">Unpacked</option>
                                                <option value="picking process">Picking Process</option>
                                                <option value="shipped">Shipped</option>
                                                <option value="item packed">Item Packed</option>
                                                <option value="delivered">Delivered</option>
                                                <option value="ready to ship">Ready to ship</option>
                                                <option value="postponed">Postponed</option>
                                                <option value="no answer">No answer</option>
                                                <option value="2nd delivery attempt">2nd delivery Attempt</option>
                                                <option value="3rd delivery attempt">3rd delivery Attempt</option>
                                                <option value="canceld">Canceld</option>
                                            </select>
                                        </div>
                                        <div class="col-3 align-self-center">
                                            <label>Date Range</label>
                                            <div class='input-group mb-3'>
                                                <input type='text' name="date" class="form-control timeseconds"/>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <span class="ti-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-12 m-b-20">
                                            <label>Select Product</label>
                                            <select class="form-control" name="id_prod" style="width: 100%;height: 36px;">
                                                <option>Select Product</option>
                                                @foreach($productss as $v_product)
                                                @foreach($v_product['products'] as $v_pro)
                                                <option value="{{ $v_pro->id}}">{{ $v_pro->name}}</option>
                                                @endforeach
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-1 align-self-center">
                                            <div class="form-group mb-0">
                                                <button type="submit" class="btn btn-info waves-effect btn-rounded m-t-10 mb-2 " style="width:100%">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-1 align-self-center">
                                            <div class="form-group mb-0">
                                                <a href="{{ route('leads.index')}}" class="btn btn-info waves-effect btn-rounded m-t-10 mb-2 " style="width:100%">Reset</a>
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
                                <!-- Add Contact Popup Model -->        
                                <div id="StatusLeads" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Add New Contact</h4> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <from class="form-horizontal form-material">
                                                    <div class="table-responsive">
                                                        <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-paging="true" data-paging-size="7">
                                                            <thead>
                                                                <tr>
                                                                    <th>Date</th>
                                                                    <th>Status</th>
                                                                    <th>Date Action</th>
                                                                    <th>Comment</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="" id="history">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </from>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
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
                                                <th>Seller</th>
                                                <th>Products</th>
                                                <th>Image</th>
                                                <th>Link</th>
                                                <th>Total Received</th>
                                                <th>Total Lead</th>
                                                <th>Total Confirmed</th>
                                                <th>Total Delivred</th>
                                                <th>Profit</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="alldata">
                                            <?php
                                            $counter = 1;
                                            ?>
                                            @if(!$leads->isempty())
                                            @foreach($leads as $key => $v_lead[0])
                                            <tr class="accordion-toggle data-item" data-id="">
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="ids" class="custom-control-input checkBoxClass"  value="" id="pid-{{$counter}}">
                                                        <label class="custom-control-label" for="pid-{{$counter}}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    @foreach($v_lead[0]['product'][0]['users'] as $v_user)
                                                    {{ $v_user->name}}
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($v_lead[0]['product'] as $v_product)
                                                    {{ $v_product->name}}
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($v_lead[0]['product'] as $v_product)
                                                    <img src="https://client.FULFILLEMENT.com/uploads/products/{{ $v_product->image}}" width="45"/>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach($v_lead[0]['product'] as $v_product)
                                                    {{ $v_product->link}}
                                                    @endforeach
                                                </td>
                                                <td>{{ ( $v_lead->where('status_confirmation','confirmed')->count() * 100 ) /  $v_lead->count()}} %</td>
                                                <td>{{ $v_lead->count()}}</td>
                                                <td>
                                                    {!! $v_lead->where('date_delivered','!=', null)->count() !!}
                                                </td>
                                                <td>{{ $v_lead->where('status_confirmation','confirmed')->where('status_livrison','delivered')->count() }}</td>
                                                <td>{{ $v_lead->sum('lead_value')}} CFA</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ti-settings"></i>
                                                        </button>
                                                        
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $counter = $counter + 1; ?>
                                            @endforeach
                                            @else
                                            <div class="col-12">
                                                <img src="{{ asset('public/Empty-amico.svg')}}" style="margin-left: auto ; margin-right: auto; display: block;" width="500" />
                                            </div>
                                            @endif
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
        </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="content-footer footer bg-footer-theme">
                <div class="container-xxl">
                    <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                        <div>
                            ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            , made with ❤️ by <a href="https://Palace Agency.eu" target="_blank" class="fw-semibold">Palace Agency</a>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        
                                <div id="listlead" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" style="max-width:1200px">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">List Leads</h4> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <table id=""  class="table table-bordered table-striped table-hover contact-list" data-paging="true" data-paging-size="7">
                                                                    <thead >
                                                                        <tr>
                                                                            <th>
                                                                                <div class="custom-control custom-checkbox">
                                                                                    <input type="checkbox" class="selectall custom-control-input" id="chkCheckAll" required>
                                                                                    <label class="custom-control-label" for="chkCheckAll"></label>
                                                                                </div>
                                                                            </th>
                                                                            <th>Réf</th>
                                                                            <th>Products</th>
                                                                            <th>Name</th>
                                                                            <th>City</th>
                                                                            <th>Phone</th>
                                                                            <th>Lead Value</th>
                                                                            <th>Confirmation</th>
                                                                            <th>Created At</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="listleadss" class="datasearch"></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- Add Contact Popup Model -->  
                                <!-- Add Contact Popup Model -->        
                                <div id="editsheet" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" style="max-width:1500px">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Details Lead : <span id="statusleadss"></sapn></h4> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                                <from class="form-horizontal form-material">
                                            <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <div class="">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="card" style="box-shadow: 0px 0px 8px 3px;">
                                                                        <div class="card-body">
                                                                            <h4 class="card-title"style="font-size: 25px;">
                                                                                <i class="mdi mdi-menu font-50" style="margin-right: 30px;"></i>Detail Product -  <span id="n_order">N Command : </span>
                                                                            </h4>
                                                                            <form class="form pt-3"style="margin-left: 39px;">
                                                                                <div class="row col-12">
                                                                                    <div class="col-md-6 m-b-20">
                                                                                        <label>Product Name :</label>
                                                                                        <input type="text" class="form-control" id="product" name="product" value=""/>
                                                                                    </div>
                                                                                    <div class="form-group m-r-2 col-6">
                                                                                        <label>Total Price :</label>
                                                                                        <input type="text" class="form-control" id="lead_value" name="price" value="" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6 m-b-20">
                                                                                        <label>Link Product :</label>
                                                                                        <input type="text" class="form-control" id="link_products" value=""/>
                                                                                    </div>
                                                                                    <div class="col-md-6 m-b-20">
                                                                                        <label>Link Video :</label>
                                                                                        <input type="text" class="form-control" id="link_video"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6 m-b-20">
                                                                                        <label>Description :</label>
                                                                                        <textarea class="form-control" id="description_product"></textarea>
                                                                                    </div>
                                                                                    <div class="form-group col-6" id="product_image">
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="row">
                                                                                    <div class="col-12 align-self-center">
                                                                                        <div class="form-group mb-0 text-center">
                                                                                            <input type="hidden" id="lead_id" />
                                                                                            <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2 upsell">Add Upsell</button>
                                                                                            <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2 infoupsell">Information Upsell</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="card" style="box-shadow: 0px 0px 8px 3px;">
                                                                        <div class="card-body">
                                                                            <div class="row">
                                                                                <div class="col-8">
                                                                                    <h4 class="card-title"style="font-size: 25px;">
                                                                                        <i class="mdi mdi-account-circle" style="margin-right: 30px;"></i>Customer Information 
                                                                                    </h4>
                                                                                </div>
                                                                                <div class="col-4">
                                                                                    <a class="btn btn-success waves-effect" href="https://wa.me/" target="_blank"><i class="mdi mdi-whatsapp"></i>Whtsapp</a>
                                                                                    <a class="btn btn-success waves-effect" href="tel:"><i class="mdi mdi-call-made"></i>Call</a>
                                                                                </div>
                                                                                
                                                                            </div>
                                                                            
                                                                            <form class="form pt-3"style="margin-left: 39px;">
                                                                                <div class="row">
                                                                                    <div class="col-md-6 m-b-20">
                                                                                        <label>Customer Name :</label>
                                                                                        <input type="text" class="form-control" id="customer_name" name="product" value=""/>
                                                                                    </div>
                                                                                    <div class="col-md-6 m-b-20">
                                                                                        <label>Phone 1 :</label>
                                                                                        <input type="text" class="form-control" id="mobile_customer" value="" />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6 m-b-20">
                                                                                        <label>Phone 2 :</label>
                                                                                        <input type="text" class="form-control" id="mobile2_customer" value="" />
                                                                                    </div>
                                                                                    <div class="col-md-6 m-b-20">
                                                                                        <label>Address :</label>
                                                                                        <textarea class="form-control" id="customer_address"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6 m-b-20">
                                                                                        <label>City :</label>
                                                                                        <select class="form-control" id="id_cityy" placeholder="Select City">
                                                                                            <option>Select City</option>
                                                                                            @foreach($cities as $v_city)
                                                                                            <option value="{{ $v_city->id}}">{{ $v_city->name}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label>Zone :</label>
                                                                                        <select class="form-control" id="id_zonee">
                                                                                            <option>Select Zone</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="form-group col-12">
                                                                                        <label>Note :</label>
                                                                                        <textarea class="form-control" id="customer_note"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12 align-self-center">
                                                                    <div class="form-group mb-0 text-center">
                                                                        <input type="hidden" id="lead_id" />
                                                                        <button class="btn btn-success btn-rounded m-t-10 mb-2 confiremd" id="confirmed">Confirmed</button>
                                                                        <button type="button" class="btn btn-orange btn-rounded m-t-10 mb-2 "  id="unrech">no answer</button>
                                                                        <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2 " id="callater">CALL LATER</button>
                                                                        <button type="button" class="btn btn-danger btn-rounded m-t-10 mb-2 " id="cancel">CANCEL</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                                </from>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>        
                                <div id="datedeli" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" >
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Choose Date Delivred</h4> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                                <from class="form-horizontal form-material">
                                            <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <h3></h3>
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-sm-12 m-b-20">
                                                                            <input type="hidden" class="form-control" id="lead_id">
                                                                            <input type="date" class="form-control" id="date_delivred" placeholder="">
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 m-b-20">
                                                                            <textarea class="form-control" id="comment_sta" ></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info waves-effect editlead" id="datedelivred">Save</button>
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                                            </div>
                                                </from>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div> 
                                <!-- Add status Popup Model -->
                                <div id="autherstatus" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" >
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Note Status</h4> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                                <from class="form-horizontal form-material">
                                            <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <h3></h3>
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-sm-12 m-b-20">
                                                                            <input type="hidden" class="form-control" id="leads_id">
                                                                            <input type="date" class="form-control" id="date_status" placeholder="">
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 m-b-20">
                                                                            <textarea class="form-control" id="coment_sta" ></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info waves-effect editlead" id="changestatus">Save</button>
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                                            </div>
                                                </from>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- Add reclamation Popup Model -->        
                                <div id="addreclamation" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" style="max-width:1200px">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Complaint</h4> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                                <from class="">
                                            <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <h3>Create Complaint</h3>
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-sm-12 m-b-20">
                                                                            <input type="hidden" class="form-control" id="lead_id_recla"  placeholder="N Lead">
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 m-b-20">
                                                                            <select class="form-control" id="id_service" name="id_service" >
                                                                                <option value="">Select Service</option>
                                                                                <option value="">Livreur</option>
                                                                                <option value="">Stock</option>
                                                                                <option value="">Call Center</option>
                                                                                <option value="">Financier</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 m-b-20">
                                                                            <textarea type="text" class="form-control" id="reclamation" placeholder="Reclamation"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info waves-effect adrecla" id="adrecla">Save</button>
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                                            </div>
                                                </from>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- Add upsell Popup Model -->        
                                <div id="upsell" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Add New Upsell</h4> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <from class="form-horizontal form-material">
                                                    <div class="form-group">
                                                        <div class="col-md-12 m-b-20">
                                                            <select class="form-control" id="product_upsell">
                                                                <option>Select Product</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="hidden" class="form-control" id="lead_upsell" placeholder="Quantity">
                                                            <input type="text" class="form-control" id="upsell_quantity" placeholder="Quantity">
                                                        </div>
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="text" class="form-control" id="price_upsell" placeholder="Price"> </div>
                                                    </div>
                                                </from>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info waves-effect" id="saveupsell">Save</button>
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- Add payment app Popup Model -->        
                                <div id="paymentapp" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Payment Using App</h4> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <from class="form-horizontal form-material">
                                                    <div class="form-group">
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="hidden" class="form-control" id="lead_payment" placeholder="Quantity">
                                                            <textarea class="form-control" id="not_payment" placeholder="Note"></textarea>
                                                        </div>
                                                    </div>
                                                </from>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info waves-effect" id="savepaymentnot">Save</button>
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                    
                                    <div id="info-upssel" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" style="max-width:1200px">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Details Upsell</h4> 
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                    <from class="form-horizontal form-material">
                                                <div class="modal-body">
                                                        <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <h3>Information Product</h3>
                                                                            <div class="col-md-12 column">
                                                                                <table class="table table-bordered table-hover" id="tab_logic">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th class="text-center">
                                                                                                Quantity
                                                                                            </th>
                                                                                            <th class="text-center">
                                                                                                Discount
                                                                                            </th>
                                                                                            <th class="text-center">
                                                                                                Note
                                                                                            </th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody id="infoupsells">
                                                                                        
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-info waves-effect editlead" id="editsheets">Save</button>
                                                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                                                </div>
                                                    </from>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div> 
                                <!-- popup status -->
                                <div id="searchdetails" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" >
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Choose Date Delivred</h4> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                                <from class="form-horizontal form-material">
                                            <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <h3></h3>
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-sm-12 m-b-20">
                                                                            <input type="hidden" class="form-control" id="leads_id">
                                                                            <input type="date" class="form-control" id="date_delivredss" placeholder="">
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 m-b-20">
                                                                            <textarea class="form-control" id="comment_stas" ></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info waves-effect editlead" id="datedelivreds">Save</button>
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                                            </div>
                                                </from>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div> 
                                <div id="canceledform" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" >
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Note Canceled</h4> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                                <from class="form-horizontal form-material">
                                            <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <h3></h3>
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-sm-12 m-b-20">
                                                                            <input type="hidden" class="form-control" id="leads_id">
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 m-b-20">
                                                                            <textarea class="form-control" id="comment_stas_can" ></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info waves-effect editlead" id="notecanceled">Save</button>
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                                            </div>
                                                </from>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
$("#search").keyup( function(){
    $value = $(this).val();
    if($value){
        $('.alldata').hide();
        $('.datasearch').show();
    }else{
        $('.alldata').show();
        $('.datasearch').hide();
    }
    $.ajax({
        type: 'get',
        url: '{{ route('leads.search')}}',
        data: {'search': $value,},
        success:function(data)
        {
            $('#contentdata').html(data);
        }
    });
});
$(document).ready(function(){

    
    $(function(e){
        $('#savelead').click(function(e){
            var idproduct = $('#id_product').val();
            var namecustomer = $('#name_customer').val();
            var quantity = $('#quantity').val();
            var mobile = $('#mobile').val();
            var mobile2 = $('#mobile2').val();
            var country = $('#id_country').val();
            var cityid = $('#id_city').val();
            var zoneid = $('#id_zone').val();
            var address = $('#address').val();
            var total = $('#total').val();
            $.ajax({
                type : 'POST',
                url:'{{ route('leads.store')}}',
                cache: false,
                data:{
                    id: idproduct,
                    namecustomer: namecustomer,
                    quantity: quantity,
                    mobile: mobile,
                    mobile2: mobile2,
                    country: country,
                    cityid: cityid,
                    zoneid: zoneid,
                    address: address,
                    total: total,
                    _token : '{{ csrf_token() }}'
                },
                success:function(response){
                    if(response.success == true){
                        toastr.success('Good Job.', 'Upsell Has been Addess Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                    }
                    location.reload();
            }});
        });
    });
// Department Change
$('#id_country').change(function(){

// Department id
var id = $(this).val();

// Empty the dropdown
$('#id_city').find('option').not(':first').remove();
//console.log(id);
// AJAX request 
$.ajax({
  url: 'city/'+id,
  type: 'get',
  dataType: 'json',
  success: function(response){

    var len = 0;
    if(response['data'] != null){
      len = response['data'].length;
    }

    if(len > 0){
      // Read data and create <option >
      for(var i=0; i<len; i++){

        var id = response['data'][i].id;
        var name = response['data'][i].name;

        var option = "<option value='"+id+"'>"+name+"</option>"; 

        $("#id_city").append(option); 
      }
    }

  }
});
});
$('#id_cit').change(function(){

   // Department id
   var id = $(this).val();

   // Empty the dropdown
   $('#id_zone').find('option').not(':first').remove();
   //console.log(id);
   // AJAX request 
   $.ajax({
     url: 'zone/'+id,
     type: 'get',
     dataType: 'json',
     success: function(response){

       var len = 0;
       if(response['data'] != null){
         len = response['data'].length;
       }

       if(len > 0){
         // Read data and create <option >
         for(var i=0; i<len; i++){

           var id = response['data'][i].id;
           var name = response['data'][i].name;

           var option = "<option value='"+id+"'>"+name+"</option>"; 

           $("#id_zone").append(option); 
         }
       }

     }
  });
});
// Department Change
$('#id_cityy').change(function(){

   // Department id
   var id = $(this).val();

   // Empty the dropdown
   $('#id_zonee').find('option').not(':first').remove();
   //console.log(id);
   // AJAX request 
   $.ajax({
     url: 'zone/'+id,
     type: 'get',
     dataType: 'json',
     success: function(response){

       var len = 0;
       if(response['data'] != null){
         len = response['data'].length;
       }

       if(len > 0){
         // Read data and create <option >
         for(var i=0; i<len; i++){

           var id = response['data'][i].id;
           var name = response['data'][i].name;

           var option = "<option value='"+id+"'>"+name+"</option>"; 

           $("#id_zonee").append(option); 
         }
       }

     }
  });
});
$('#id_city').change(function(){

   // Department id
   var id = $(this).val();

   // Empty the dropdown
   $('#id_zone').find('option').not(':first').remove();
   //console.log(id);
   // AJAX request 
   $.ajax({
     url: 'zone/'+id,
     type: 'get',
     dataType: 'json',
     success: function(response){

       var len = 0;
       if(response['data'] != null){
         len = response['data'].length;
       }

       if(len > 0){
         // Read data and create <option >
         for(var i=0; i<len; i++){

           var id = response['data'][i].id;
           var name = response['data'][i].name;

           var option = "<option value='"+id+"'>"+name+"</option>"; 

           $("#id_zone").append(option); 
         }
       }

     }
  });
});
$('body').on('change', '.myform', function(e) {
   e.preventDefault();
   var id = $(this).data('id');
   var statuu = '#statu_con'+id;
   var status = $(statuu).val();
   if(status == "confirmed"){
       $('#lead_id').val(id);
   }else{
       $('#leads_id').val(id);
       $('#autherstatus').modal('show');
   }
    
    //console.log(id);
   $.ajax({
      type: "POST",
      url:'{{ route('leads.statuscon')}}',
      cache: false,
      data:{
          id: id,
          status: status,
          _token : '{{ csrf_token() }}'
        },
            success:function(response){
                if(response.success == true){
                    toastr.success('Good Job.', 'Lead Has been Update Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                }
        }
   });
});
});

$(function(e){
    $('#confirmed').click(function(e){
        //console.log(namecustomer);
        $('#searchdetails').modal('show');
    });
});

$(function(e){
    $('#cancel').click(function(e){
        //console.log(namecustomer);
        $('#canceledform').modal('show');
    });
});

$(function(e){
    $('.addreclamationgetid').click(function(e){
        //console.log(namecustomer);
        $('#addreclamation').modal('show');
        $('#lead_id_recla').val($(this).data('id'));
    });
});

$(function(e){
    $('.payment').click(function(e){
        //console.log(namecustomer);
        $('#paymentapp').modal('show');
        $('#lead_payment').val($(this).data('id'));
    });
});

$(function(e){
    $('body').on('click', '.addreclamationgetid2', function(e){
        //console.log(namecustomer);
        $('#addreclamation').modal('show');
        $('#lead_id_recla').val($(this).data('id'));
    });
});

$(function(e){
    $('#adrecla').click(function(e){
        var idlead = $('#lead_id_recla').val();
        var reclamation = $('#reclamation').val();
        $.ajax({
            type : 'POST',
            url:'{{ route('reclamations.store')}}',
            cache: false,
            data:{
                id: idlead,
                reclamation: reclamation,
                _token : '{{ csrf_token() }}'
            },
            success:function(response){
                if(response.success == true){
                    toastr.success('Good Job.', 'Lead Has been Update Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                }
        }});
    });
});

$(function(e){
    $('#savepaymentnot').click(function(e){
        var idlead = $('#lead_payment').val();
        var note = $('#not_payment').val();
        $.ajax({
            type : 'POST',
            url:'{{ route('leads.paymentapp')}}',
            cache: false,
            data:{
                id: idlead,
                note: note,
                _token : '{{ csrf_token() }}'
            },
            success:function(response){
                if(response.success == true){
                    toastr.success('Good Job.', 'Lead Has been Update Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                }
        }});
    });
});
$(function(e){
    $('#datedelivreds').click(function(e){
        var id = $('#lead_id').val();console.log(id);
        var customename = $('#customer_name').val();
        var customerphone = $('#customer_phone').val();
        var customerphone2 = $('#customer_phone2').val();
        var customeraddress = $('#customer_address').val();
        var customercity = $('#id_cityy').val();
        var customerzone = $('#id_zonee').val();
        var leadvalue = $('#lead_value').val();
        var datedelivred = $('#date_delivredss').val();
        var commentdeliv = $('#comment_stas').val();
   $.ajax({
      type: "POST",
      url:'{{ route('leads.confirmed')}}',
      cache: false,
      data:{
          id: id,
          customename: customename,
          customerphone: customerphone,
          customerphone2: customerphone2,
          customeraddress: customeraddress,
          customercity: customercity,
          customerzone: customerzone,
          leadvalue: leadvalue,
          commentdeliv: commentdeliv,
          datedelivred: datedelivred,
          status: status,
          _token : '{{ csrf_token() }}'
        },
            success:function(response){
                if(response.success == true){
                    toastr.success('Good Job.', 'Lead Has been Update Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                    $('#searchdetails').modal('hide');
                    location.reload();
                }
        }
   });
    });
});
$(function(e){
    $('#notecanceled').click(function(e){
        var id = $('#leads_id').val();
        var commentecanceled = $('#comment_stas_can').val();
   $.ajax({
      type: "POST",
      url:'{{ route('leads.canceled')}}',
      cache: false,
      data:{
          id: id,
          commentecanceled: commentecanceled,
          _token : '{{ csrf_token() }}'
        },
            success:function(response){
                if(response.success == true){
                    toastr.success('Good Job.', 'Lead Has been Update Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                    location.reload();
                }
        }
   });
    });
});

$(function(e){
    $('#unrech').click(function(e){
        var idlead = $('#lead_id').val();
        var status = "no answer";
        //console.log(namecustomer);
        $.ajax({
            type : 'POST',
            url:'{{ route('leads.statusc')}}',
            cache: false,
            data:{
                id: idlead,
                status: status,
                _token : '{{ csrf_token() }}'
            },
            success:function(response){
                if(response.success == true){
                    toastr.success('Good Job.', 'Lead Has been Update Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                }
        }});
    });
});
$(function(e){
    $('#callater').click(function(e){
        var idlead = $('#lead_id').val();
        var status = "call later";
        //console.log(namecustomer);
        $.ajax({
            type : 'POST',
            url:'{{ route('leads.statusc')}}',
            cache: false,
            data:{
                id: idlead,
                status: status,
                _token : '{{ csrf_token() }}'
            },
            success:function(response){
                if(response.success == true){
                    toastr.success('Good Job.', 'Lead Has been Update Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                }
        }});
    });
});


$(function(e){
    $('#changestatus').click(function(e){
        var idlead = $('#leads_id').val();
        var date = $('#date_status').val();
        var comment = $('#coment_sta').val();
        //console.log(namecustomer);
        $.ajax({
            type : 'POST',
            url:'{{ route('leads.notestatus')}}',
            cache: false,
            data:{
                id: idlead,
                date: date,
                comment: comment,
                _token : '{{ csrf_token() }}'
            },
            success:function(response){
                if(response.success == true){
                    $('#datedeli').modal('hide');
                    toastr.success('Good Job.', 'Lead Has been Update Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                }
        }});
    });
});

$(function(e){
    $('.seehystory').click(function(e){
        $value = $(this).data('id');
        //alert($value);
        //console.log(namecustomer);
        $.ajax({
            type : 'get',
            url:'{{ route('leads.seehistory')}}',
            cache: false,
            data: {'id': $value,},
            success:function(data){
                $('#StatusLeads').modal('show');
                $('#history').html(data);
        }});
    });
});

    
$(function () {
        $('body').on('click', '.upsell', function (products) {
        var id = $('#lead_id').val();
                $('#lead_upsell').val(id);
            $.get("{{ route('leads.index') }}" +'/' + id +'/detailspro', function (response) {
                $('#upsell').modal('show');
                
                var len = 0;
                if(response['data'] != null){
                    len = response['data'].length;
                }

                if(len > 0){
                    // Read data and create <option >
                    for(var i=0; i<len; i++){

                    var id = response['data'][i].id;
                    var name = response['data'][i].name;

                    var option = "<option value='"+id+"'>"+name+"</option>"; 

                    $("#product_upsell").append(option); 
                    }
                }
            });
        });
    });
$(function(e){
    $('#datedelivred').click(function(e){
        var idlead = $('#lead_id').val();
        var date = $('#date_delivred').val()
        //console.log(namecustomer);
        $.ajax({
            type : 'POST',
            url:'{{ route('leads.date')}}',
            cache: false,
            data:{
                id: idlead,
                date: date,
                _token : '{{ csrf_token() }}'
            },
            success:function(response){
                if(response.success == true){
                    $('#datedeli').modal('hide');
                    toastr.success('Good Job.', 'Lead Has been Update Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                }
        }});
    });
});

$(function(e){
    $('#editsheets').click(function(e){
        var idlead = $('#lead_id').val();
        var namecustomer = $('#name_custome').val();
        var quantity = $('#quantity_lead').val();
        var mobile = $('#mobile_customer').val();
        var mobile2 = $('#mobile2_customer').val();
        var cityid = $('#id_cityy').val();
        var zoneid = $('#id_zonee').val();
        var address = $('#customer_adress').val();
        var total = $('#total_lead').val();
        var note = $('#lead_note').val();
        //console.log(namecustomer);
        $.ajax({
            type : 'POST',
            url:'{{ route('leads.update')}}',
            cache: false,
            data:{
                id: idlead,
                namecustomer: namecustomer,
                quantity: quantity,
                mobile: mobile,
                mobile2: mobile2,
                cityid: cityid,
                zoneid: zoneid,
                address: address,
                total: total,
                note: note,
                _token : '{{ csrf_token() }}'
            },
            success:function(response){
                if(response.success == true){
                    toastr.success('Good Job.', 'Lead Has been Update Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                }
        }});
    });
});
    $(function () {
        $('body').on('click', '.detaillead', function (products) {
        var id = $(this).data('id');
            $.get("{{ route('leads.index') }}" +'/' + id +'/details', function (data) {
                $('#editsheet').modal('show');
                
                $('#lead_id').val(data[0].leads[0].id);
                $('#leads_id').val(data[0].leads[0].id);
                $('#statusleadss').html(data[0].leads[0].status_confirmation);
                $('#n_order').html(data[0].leads[0].n_lead);
                $('#customer_name').val(data[0].leads[0].name);
                $('#mobile_customer').val(data[0].leads[0].phone);
                $('#mobile2_customer').val(data[0].leads[0].phone2);
                $('#customer_address').val(data[0].leads[0].address);
                $('#link_products').val(data[0].product[0].link);
                $('#product').val(data[0].product[0].name);
                $('#lead_value').val(data[0].leads[0].lead_value);
                $('#product_image').html("<img src='https://client.FULFILLEMENT.com/uploads/products/"+ data[0].product[0].image+"' width='80px' />");
                $('#link_video').val(data[0].product[0].link_video);
                $('#customer_note').val(data[0].leads[0].note);
                $('#id_cityy').val(data[0].leads[0].id_city);
                $('#description_product').val(data[0].product[0].description);
                $('#seedetailupsell').val(data[0].leads[0].id);
                $('#next_id').val(data[0].leads[0].id - 1);
                $('#previous_id').val(data[0].leads[0].id + 1);
                for(var i in data){
                    var quantity = data[0].leads[0].quantity;
                    var id_product = data[0].leads[0].id_product;
                    var price = data[0].leads[0].lead_value;
                    $('#addr'+i).html("<td>"+ (i+1) +"</td><td><div class='form-control-wrap'><select class='form-control form-select select2-accessible' data-placeholder='sélectionnez une opltion' required='' id='product_lead' name='id_product[]' data-select2-id='fv-topics' tabindex='-1' aria-hidden='true'>@foreach($productss as $v_product) @foreach($v_product['products'] as $product)<option value='{{ $product['id']}}' {{ $product['id'] == '"+ data[i].id_product +"' ? 'selected':'' }}>{{ $product['name']}}</option>@endforeach @endforeach</select></div> </td><td><input  name='quantity[]' id='quantity_lead' type='text' placeholder='Quantity' value='"+quantity+"' required class='form-control input-md'></td><td><input  name='price[]' id='total_lead' type='text' placeholder='Lead Value' value='"+price+"' required class='form-control input-md'></td>");
                
                }
                
            });
        });
    });
    //popup detail upsell
    $(function () {
        $('body').on('click', '.infoupsell', function (products) {
        var id = $('#lead_id').val();
            $.get("{{ route('leads.index') }}" +'/' + id +'/infoupsell', function (data) {
                $('#info-upssel').modal('show');
                
                    $('#infoupsells').html(data);
                
                
            });
        });
    });
    
    $(function () {
        $('body').on('click', 'upsell', function (products) {
        var id = $('#lead_id').val();
            $.get("{{ route('leads.index') }}" +'/' + id +'/details', function (data) {
                $('#upsell').modal('show');
                
                $('#lead_id').val(data[0].leads[0].id);
                $('#name_custome').val(data[0].leads[0].name);
                $('#mobile_customer').val(data[0].leads[0].phone);
                $('#mobile2_customer').val(data[0].leads[0].phone2);
                $('#customer_adress').val(data[0].leads[0].address);
                $('#lead_note').val(data[0].leads[0].note);
                $('#id_cityy').val(data[0].leads[0].id_city);
                $('#next_id').val(data[0].leads[0].id - 1);
                $('#previous_id').val(data[0].leads[0].id + 1);
                for(var i in data){
                    var quantity = data[0].leads[0].quantity;
                    var id_product = data[0].leads[0].id_product;
                    var price = data[0].leads[0].lead_value;
                    $('#addr'+i).html("<td>"+ (i+1) +"</td><td><div class='form-control-wrap'><select class='form-control form-select select2-accessible' data-placeholder='sélectionnez une opltion' required='' id='product_lead' name='id_product[]' data-select2-id='fv-topics' tabindex='-1' aria-hidden='true'>@foreach($productss as $v_product) @foreach($v_product['products'] as $product)<option value='{{ $product['id']}}' {{ $product['id'] == '"+ data[i].id_product +"' ? 'selected':'' }}>{{ $product['name']}}</option>@endforeach @endforeach</select></div> </td><td><input  name='quantity[]' id='quantity_lead' type='text' placeholder='Quantity' value='"+quantity+"' required class='form-control input-md'></td><td><input  name='price[]' id='total_lead' type='text' placeholder='Lead Value' value='"+price+"' required class='form-control input-md'></td>");
                
                }
                
            });
        });
    });
    
    $('#saveupsell').click(function(e){
            e.preventDefault();
            var id = $('#lead_upsell').val();
            var product = $('#product_upsell').val();
            var quantity = $('#upsell_quantity').val();
            var price = $('#price_upsell').val();
            //console.log(agent);
            $.ajax({
                type: "POST",
                url:'{{ route('leads.upsellstore')}}',
                cache: false,
                data:{
                    id: id,
                    product: product,
                    quantity: quantity,
                    price: price,
                    _token : '{{ csrf_token() }}'
                    },
                        success:function(response){
                            if(response.success == true){
                                toastr.success('Good Job.', 'Upsell Has been Added Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                            }
                    }
            });
        });

        ///list lead search

        
    
    $('#searchdetai').click(function(e){
            e.preventDefault();
            var n_lead = $('#search_2').val();
            $('#listlead').modal('show');
            //console.log(agent);
            $.ajax({
                type: "get",
                url:'{{ route('leads.leadsearch')}}',
                data:{
                    n_lead: n_lead,
                    },
                        success:function(data){
                            $('#listleadss').html(data);
                    }
            });
        });

    $(document).on('click', '.next', function(){
        var id = $('#next_id').val();
        $.get("{{ route('leads.index') }}" +'/' + id +'/details', function (data) {
                        $('#editsheet').modal('show');
                        
                        $('#lead_id').val(data[0].leads[0].id);
                        $('#name_custome').val(data[0].leads[0].name);
                        $('#mobile_customer').val(data[0].leads[0].phone);
                        $('#mobile2_customer').val(data[0].leads[0].phone2);
                        $('#customer_adress').val(data[0].leads[0].address);
                        $('#lead_note').val(data[0].leads[0].note);
                        $('#id_cityy').val(data[0].leads[0].id_city);
                        $('#next_id').val(data[0].leads[0].id - 1);
                        $('#previous_id').val(data[0].leads[0].id + 1);
                        for(var i in data){
                            var quantity = data[0].leads[0].quantity;
                            var id_product = data[0].leads[0].id_product;
                            var price = data[0].leads[0].lead_value;
                            $('#addr'+i).html("<td>"+ (i+1) +"</td><td><div class='form-control-wrap'><select class='form-control form-select select2-accessible' data-placeholder='sélectionnez une opltion' required='' id='product_lead' name='id_product[]' data-select2-id='fv-topics' tabindex='-1' aria-hidden='true'>@foreach($productss as $v_product) @foreach($v_product['products'] as $product)<option value='{{ $product['id']}}' {{ $product['id'] == '"+ data[i].id_product +"' ? 'selected':'' }}>{{ $product['name']}}</option>@endforeach @endforeach</select></div> </td><td><input  name='quantity[]' id='quantity_lead' type='text' placeholder='Quantity' value='"+quantity+"' required class='form-control input-md'></td><td><input  name='price[]' id='total_lead' type='text' placeholder='Lead Value' value='"+price+"' required class='form-control input-md'></td>");
                        
                        }
                        
                    });
                });
                $(document).on('click', '.previous', function(){
        var id = $('#previous_id').val();
        $.get("{{ route('leads.index') }}" +'/' + id +'/details', function (data) {
                        $('#editsheet').modal('show');
                        
                        $('#lead_id').val(data[0].leads[0].id);
                        $('#name_custome').val(data[0].leads[0].name);
                        $('#mobile_customer').val(data[0].leads[0].phone);
                        $('#mobile2_customer').val(data[0].leads[0].phone2);
                        $('#customer_adress').val(data[0].leads[0].address);
                        $('#lead_note').val(data[0].leads[0].note);
                        $('#id_cityy').val(data[0].leads[0].id_city);
                        $('#next_id').val(data[0].leads[0].id - 1);
                        $('#previous_id').val(data[0].leads[0].id + 1);
                        for(var i in data){
                            var quantity = data[0].leads[0].quantity;
                            var id_product = data[0].leads[0].id_product;
                            var price = data[0].leads[0].lead_value;
                            $('#addr'+i).html("<td>"+ (i+1) +"</td><td><div class='form-control-wrap'><select class='form-control form-select select2-accessible' data-placeholder='sélectionnez une opltion' required='' id='product_lead' name='id_product[]' data-select2-id='fv-topics' tabindex='-1' aria-hidden='true'>@foreach($productss as $v_product) @foreach($v_product['products'] as $product)<option value='{{ $product['id']}}' {{ $product['id'] == '"+ data[i].id_product +"' ? 'selected':'' }}>{{ $product['name']}}</option>@endforeach @endforeach</select></div> </td><td><input  name='quantity[]' id='quantity_lead' type='text' placeholder='Quantity' value='"+quantity+"' required class='form-control input-md'></td><td><input  name='price[]' id='total_lead' type='text' placeholder='Lead Value' value='"+price+"' required class='form-control input-md'></td>");
                        
                        }
                        
        });
    });

$(document).on('click', '#searchdetail', function(){
    var id = $('#search_2').val();
    $.get("{{ route('leads.index') }}" +'/' + id +'/seacrhdetails', function (data) {
                    $('#editsheet').modal('show');
                    //console.log(data);
                    $('#leads_id').val(data[0].leads[0].id);
                    $('#statusleadss').html(data[0].leads[0].status_confirmation);
                    $('#n_order').html(data[0].leads[0].n_lead);
                    $('#customer_name').val(data[0].leads[0].name);
                    $('#mobile_customer').val(data[0].leads[0].phone);
                    $('#mobile2_customer').val(data[0].leads[0].phone2);
                    $('#customer_address').val(data[0].leads[0].address);
                    $('#link_products').val(data[0].product[0].link);
                    $('#product').val(data[0].product[0].name);
                    $('#lead_value').val(data[0].leads[0].lead_value);
                    $('#product_image').html("<img src='https://client.FULFILLEMENT.com/uploads/products/"+ data[0].product[0].image+"' width='80px' />");
                    $('#link_video').val(data[0].product[0].link_video);
                    $('#customer_note').val(data[0].leads[0].note);
                    $('#id_cityy').val(data[0].leads[0].id_city);
                    $('#description_product').val(data[0].product[0].description);
                    $('#seedetailupsell').val(data[0].leads[0].id);
                    $('#next_id').val(data[0].leads[0].id - 1);
                    $('#previous_id').val(data[0].leads[0].id + 1);
                    for(var i in data){
                        var quantity = data[0].leads[0].quantity;
                        var id_product = data[0].leads[0].id_product;
                        var price = data[0].leads[0].lead_value;
                        $('#addr'+i).html("<td>"+ (i+1) +"</td><td><div class='form-control-wrap'><select class='form-control form-select select2-accessible' data-placeholder='sélectionnez une opltion' required='' id='product_lead' name='id_product[]' data-select2-id='fv-topics' tabindex='-1' aria-hidden='true'>@foreach($productss as $v_product) @foreach($v_product['products'] as $product)<option value='{{ $product['id']}}' {{ $product['id'] == '"+ data[i].id_product +"' ? 'selected':'' }}>{{ $product['name']}}</option>@endforeach @endforeach</select></div> </td><td><input  name='quantity[]' id='quantity_lead' type='text' placeholder='Quantity' value='"+quantity+"' required class='form-control input-md'></td><td><input  name='price[]' id='total_lead' type='text' placeholder='Lead Value' value='"+price+"' required class='form-control input-md'></td>");
                    
                    }
                });
            });
            




function toggleText(){
  var x = document.getElementById("multi");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>
@endsection