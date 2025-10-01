@extends('backend.layouts.app')
@section('style')
    <style>
        .badge {
            position: absolute;
            top: 10px;
            left: 10px;
        }
    </style>
@endsection
@section('content')
    <!-- Content wrapper -->
 
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-lg-9 col-6">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / Campaignes / </span> Scenarios </h4>
                        
                    </div>
                   
                  
                   
                </div>
                
            </div>
            <div class="row mb-5">
                <div class="col-12 mb-3">
                    <div class="row">                              
                            <div class="col-lg-12 col-sm-12  mb-3 d-flex justify-content-center">
                                <div class="card h-100 px-4">
                                    <form id="Form" method="POST" action=""
                                         class="row">
                                        @csrf
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label mt-4" for="">Country</label>
                                            <select name="id_country" class="form-control" id="country" required>
                                                <option value="" disabled selected>{{$campaigne->country->name}}</option>
                                               
                                                
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label mt-4" for="">Product</label>
                                            <select name="id_product" class="form-control" id="product" required>
                                                <option value="" disabled selected>{{$campaigne->product->name}}</option>
                                              
                                               
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label mt-4" for="Quantity">Quantity</label>
                                            <input type="number" id="Quantity" name="quantity" class="form-control  px-2"
                                                placeholder="Quantity" required  min="0" value="{{$campaigne->quantity}}"/>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Price Sale</label>
                                            <input type="number" id="price_sale" name="price_sale" class="form-control  px-2"
                                                placeholder="Price Sale" required   min="0" value="{{$campaigne->price_sale}}"/>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Cost Product</label>
                                            <input type="number" id="cost_product" name="cost_product" class="form-control  px-2"
                                                placeholder="Cost Product" required   min="0" value="{{$campaigne->cost_product}}"/>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Cost Ad</label>
                                            <input type="number" id="cost_ad" name="cost_ad" class="form-control  px-2"
                                                placeholder="Cost Ad" required   min="0" value="{{$campaigne->cost_ad}}"/>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Total Leads</label>
                                            <input type="number" id="cost_ad" name="totalLeads" class="form-control  px-2"
                                                placeholder="Total Leads" required   min="0" value="{{$campaigne->totalLeads}}"/>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Fees</label>
                                            <input type="number" id="fees" name="fees" class="form-control  px-2"
                                                placeholder="Fees" required   min="0" value="{{$campaigne->fees}}"/>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Confirmation Rate(%)</label>
                                            <input type="number" id="confirmation_rate" name="confirmation_rate" class="form-control  px-2"
                                                placeholder="Confirmation Rate (%)" required  min="0" value="{{$campaigne->confirmation_rate}}"/>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Delivery Rate(%)</label>
                                            <input type="number" id="delivery_rate" name="delivery_rate" class="form-control  px-2"
                                                placeholder="Delivery Rate (%)" required  min="0" value="{{$campaigne->delivery_rate}}"/>
                                        </div>
                                        
                                            <div class="card-body">
                                                
                                                <center id="center">

                                                        <div  style="margin-bottom:10px;margin-right:10px"><span id="estimationLeads"  class="badge bg-primary mb-2">Estimation of leads for your situation : {{$campaigne->totalLeads}}</span></div>
                                                        <div style="margin-right:10px"><span id="estimationProfit" class="badge bg-primary">Estimation Profit : {{$campaigne->result}}</span></div>
                                                    
                                                </center>                                       
                                            </div>
                                       
                                       
                                    </form>
                                   
                                </div>                                     
                            </div>    
                            <div class="col-lg-4 col-sm-12  mb-3 d-flex justify-content-center">
                                <div class="card px-4 pt-2" style="height: 350px">
                                    <form 
                                         class="row">
                                            <br>
                                            <center>
                                                
                                                 <span class="badge bg-primary">Up sell (For two Units)</span>
                                            </center>                                                                                                                                        
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Price Sale</label>
                                            <input type="number" id="price_sale_upsell" name="quantity" class="form-control  px-2"
                                                placeholder="Price Sale"  value="{{$scenarioUpsell->price_sale}}"/>
                                        </div>                                              
                                       
                                    
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Confirmation Rate(%)</label>
                                            <input type="number" id="confirmation_rate_upsell" name="quantity" class="form-control  px-2"
                                                placeholder="Confirmation Rate (%)" value="{{$scenarioUpsell->confirmation_rate}}" />
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Delivery Rate(%)</label>
                                            <input type="number" id="delivery_rate_upsell" name="quantity" class="form-control  px-2"
                                                placeholder="Delivery Rate (%)"  value="{{$scenarioUpsell->delivery_rate}}"/>
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <div style="margin-top:10px">
                                                <span class="badge bg-success py-2" id="profit_callcenter">Profit : {{$scenarioUpsell->profit}}  </span>
                                            </div>      
                                        </div>
                                       
                                    </form>
                                   
                                </div>
                                
                            </div>     
                            <div class="col-lg-4 col-sm-12  mb-3 d-flex justify-content-center">
                                <div class="card px-4 pt-2" style="height: 350px">
                                    <form 
                                         class="row">
                                            <br>
                                            <center>
                                                
                                                 <span class="badge bg-primary">Call Center</span>
                                            </center>                                                                                                                                        
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Price Sale</label>
                                            <input type="number" id="price_sale_callcenter" name="quantity" class="form-control  px-2"
                                                placeholder="Price Sale" value="{{$scenarioCallCenter->price_sale}}"/>
                                        </div>                                              
                                       
                                    
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Confirmation Rate(%)</label>
                                            <input type="number" id="confirmation_rate_callcenter" name="quantity" class="form-control  px-2"
                                                placeholder="Confirmation Rate (%)" value="{{$scenarioCallCenter->confirmation_rate}}" />
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Delivery Rate(%)</label>
                                            <input type="number" id="delivery_rate_callcenter" name="quantity" class="form-control  px-2"
                                                placeholder="Delivery Rate (%)"  value="{{$scenarioCallCenter->delivery_rate}}"/>
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <div style="margin-top:10px">
                                                <span class="badge bg-success py-2" id="profit_callcenter">Profit : {{$scenarioCallCenter->profit}}  </span>
                                            </div>      
                                        </div>
                                       
                                    </form>
                                   
                                </div>
                                
                            </div>  
                            <div class="col-lg-4 col-sm-12  mb-3 d-flex justify-content-center">
                                <div class="card px-4 pt-2" style="height: 350px">
                                    <form 
                                         class="row">
                                            <br>
                                            <center>
                                                
                                                 <span class="badge bg-primary">Shipping</span>
                                            </center>                                                                                                                                        
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Price Sale</label>
                                            <input type="number" id="price_sale_shipping" name="quantity" class="form-control  px-2"
                                                placeholder="Price Sale" value="{{$scenarioShipping->price_sale}}"/>
                                        </div>                                              
                                      
                                    
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Confirmation Rate (%)</label>
                                            <input type="number" id="confirmation_rate_shipping" name="quantity" class="form-control  px-2"
                                                placeholder="Confirmation Rate (%)" value="{{$scenarioShipping->confirmation_rate}}"/>
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Delivery Rate (%)</label>
                                            <input type="number" id="delivery_rate_shipping" name="quantity" class="form-control  px-2"
                                                placeholder="Delivery Rate (%)"   value="{{$scenarioShipping->delivery_rate}}"/>
                                        </div>
                                     
                                        <div class="col-lg-12 col-sm-6">
                                            <div style="margin-top:10px">
                                                <span class="badge bg-success py-2" id="profit_callcenter">Profit : {{$scenarioShipping->profit}}  </span>
                                            </div>      
                                        </div>
                                    </form>
                                   
                                </div>
                                
                            </div>     
                            <div class="col-lg-12 col-sm-12  mb-3 d-flex justify-content-center">
                                <div class="px-4">
                                   
                                   
                                </div>                                     
                            </div>                                                       
                    </div>

                </div>
               
            </div>



            <!--/ Bordered Table -->

        </div>
        <!-- / Content -->


        <div class="content-backdrop fade"></div>
    
    <!-- Content wrapper -->
    <style>
        .dropdown-menu.show {
            display: block;
        }
    </style>

@endsection
