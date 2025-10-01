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

            <div class="card card-body py-3">
                <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="mb-4 mb-sm-0 card-title">ROI Simulator </h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item d-flex align-items-center">
                            <a class="text-muted text-decoration-none d-flex" href="{{ route('home')}}">
                            <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                            </a>
                        </li>
                        </ol>
                    </nav>
                    </div>
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
                                       
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label mt-4" for="">Product</label>
                                            <select name="id_product" class="form-control" id="product" required>
                                                <option value="" disabled selected>Select Product</option>
                                                @foreach($products as $product)
                                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                                @endforeach
                                               
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label mt-4" for="Quantity">Quantity</label>
                                            <input type="number" id="Quantity" name="quantity" class="form-control  px-2"
                                                placeholder="Quantity" required  min="0"/>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Price Sale</label>
                                            <input type="number" id="price_sale" name="price_sale" class="form-control  px-2"
                                                placeholder="Price Sale" required   min="0"/>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Cost Product</label>
                                            <input type="number" id="cost_product" name="cost_product" class="form-control  px-2"
                                                placeholder="Cost Product" required   min="0"/>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Cost Ad</label>
                                            <input type="number" id="cost_ad" name="cost_ad" class="form-control  px-2"
                                                placeholder="Cost Ad" required   min="0"/>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Total Leads</label>
                                            <input type="number" id="cost_ad" name="totalLeads" class="form-control  px-2"
                                                placeholder="Total Leads" required   min="0"/>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Fees</label>
                                            <input type="number" id="fees" name="fees" class="form-control  px-2"
                                                placeholder="Fees" required   min="0"/>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Confirmation Rate(%)</label>
                                            <input type="number" id="confirmation_rate" name="confirmation_rate" class="form-control  px-2"
                                                placeholder="Confirmation Rate (%)" required  min="0"/>
                                        </div>
                                        <div class="col-lg-6 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Delivery Rate(%)</label>
                                            <input type="number" id="delivery_rate" name="delivery_rate" class="form-control  px-2"
                                                placeholder="Delivery Rate (%)" required  min="0"/>
                                        </div>
                                        
                                            <div class="card-body">
                                                
                                                <center id="center">
                                                    @if($bool)
                                                        <button type="submit" id="generate"
                                                            class="btn btn-primary me-4" style="width: 25%;margin-bottom:10px">Generate Scenarios <i class="ti ti-arrow-down"></i></button>
                                                        <div  style="margin-bottom:10px;margin-right:10px"><span id="estimationLeads"  class="badge bg-primary mb-2"></span></div>
                                                        <div style="margin-right:10px"><span id="estimationProfit" class="badge bg-primary"></span></div>
                                                    @else
                                                        <div>
                                                            <span class="badge bg-danger">You don't have enough balance or your subscription is ended to generate scenarios</span>
                                                        </div>                                                               
                                                    @endif    
                                                </center>                                                
                                            </div>
                                       
                                       
                                    </form>
                                   
                                </div>                                     
                            </div>    
                            <div class="col-lg-4 col-sm-12  mb-3 d-flex justify-content-center">
                                <div class="card px-4 pt-2">
                                    <form 
                                         class="row">
                                            <br>
                                            <center>
                                                
                                                 <span class="badge bg-primary">Up sell (For two Units)</span>
                                            </center>                                                                                                                                        
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Price Sale</label>
                                            <input type="number" id="price_sale_upsell" name="quantity" class="form-control  px-2"
                                                placeholder="Price Sale" />
                                        </div>                                              
                                       
                                    
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Confirmation Rate(%)</label>
                                            <input type="number" id="confirmation_rate_upsell" name="quantity" class="form-control  px-2"
                                                placeholder="Confirmation Rate (%)" />
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Delivery Rate(%)</label>
                                            <input type="number" id="delivery_rate_upsell" name="quantity" class="form-control  px-2"
                                                placeholder="Delivery Rate (%)" />
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Estimation of Leads</label>
                                            <input type="number" id="estimation_upsell" name="estimation" class="form-control  px-2"
                                                placeholder="Total Leads" />
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <div style="margin-top:10px">
                                                <span class="badge bg-success py-2 d-none" id="profit_upsell">  </span>
                                            </div>      
                                        </div>
                                       
                                    </form>
                                   
                                </div>
                                
                            </div>     
                            <div class="col-lg-4 col-sm-12  mb-3 d-flex justify-content-center">
                                <div class="card px-4 pt-2" >
                                    <form 
                                         class="row">
                                            <br>
                                            <center>
                                                
                                                 <span class="badge bg-primary">Call Center</span>
                                            </center>                                                                                                                                        
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Price Sale</label>
                                            <input type="number" id="price_sale_callcenter" name="quantity" class="form-control  px-2"
                                                placeholder="Price Sale" />
                                        </div>                                              
                                       
                                    
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Confirmation Rate(%)</label>
                                            <input type="number" id="confirmation_rate_callcenter" name="quantity" class="form-control  px-2"
                                                placeholder="Confirmation Rate (%)" />
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Delivery Rate(%)</label>
                                            <input type="number" id="delivery_rate_callcenter" name="quantity" class="form-control  px-2"
                                                placeholder="Delivery Rate (%)" />
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Estimation of Leads</label>
                                            <input type="number" id="estimation_callcenter" name="estimation" class="form-control  px-2"
                                                placeholder="Total Leads" />
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <div style="margin-top:10px">
                                                <span class="badge bg-success py-2 d-none" id="profit_callcenter">  </span>
                                            </div>      
                                        </div>
                                       
                                    </form>
                                   
                                </div>
                                
                            </div>  
                            <div class="col-lg-4 col-sm-12  mb-3 d-flex justify-content-center">
                                <div class="card px-4 pt-2">
                                    <form 
                                         class="row">
                                            <br>
                                            <center>
                                                
                                                 <span class="badge bg-primary">Shipping</span>
                                            </center>                                                                                                                                        
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Price Sale</label>
                                            <input type="number" id="price_sale_shipping" name="quantity" class="form-control  px-2"
                                                placeholder="Price Sale" />
                                        </div>                                              
                                      
                                    
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Confirmation Rate (%)</label>
                                            <input type="number" id="confirmation_rate_shipping" name="quantity" class="form-control  px-2"
                                                placeholder="Confirmation Rate (%)" />
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Delivery Rate (%)</label>
                                            <input type="number" id="delivery_rate_shipping" name="quantity" class="form-control  px-2"
                                                placeholder="Delivery Rate (%)" />
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <label class="form-label  mt-4" for="Quantity">Estimation of Leads</label>
                                            <input type="number" id="estimation_shipping" name="estimation" class="form-control  px-2"
                                                placeholder="Total Leads" />
                                        </div>
                                        <div class="col-lg-12 col-sm-6">
                                            <div style="margin-top:10px">
                                                <span class="badge bg-success py-2 d-none" id="profit_shipping">  </span>
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



    
    <!-- Content wrapper -->
    <style>
        .dropdown-menu.show {
            display: block;
        }
    </style>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    <script type="text/javascript">
      
        $(document).ready(function() {
            $('#Form').submit(function(event) {
                event.preventDefault();

                var formData = new FormData($(this)[0]);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('campaigne.store') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                       
                        if (response.success) {
                            
                           
                            for(var i = 0; i < response.scenarios.length; i++){
                                var data = response.scenarios[i];
                                if(data.type == 'upsell'){

                                    $('#price_sale_upsell').val(data.price_sale);
                                    $('#confirmation_rate_upsell').val(data.confirmation_rate);
                                    $('#delivery_rate_upsell').val(data.delivery_rate);
                                    $('#estimation_upsell').val(data.totalLeads);
                                    $('#profit_upsell').removeClass('d-none');
                                    $('#profit_upsell').text('');
                                    $('#profit_upsell').text('Estimation Profit : '+data.profit);
                                }if(data.type == 'callcenter'){

                                    $('#price_sale_callcenter').val(data.price_sale);
                                    $('#confirmation_rate_callcenter').val(data.confirmation_rate);
                                    $('#delivery_rate_callcenter').val(data.delivery_rate);
                                    $('#estimation_callcenter').val(data.totalLeads);
                                    $('#profit_callcenter').removeClass('d-none');
                                    $('#profit_callcenter').text('');
                                    $('#profit_callcenter').text('Estimation Profit : '+data.profit);
                                }else{

                                    $('#price_sale_shipping').val(data.price_sale);
                                    $('#confirmation_rate_shipping').val(data.confirmation_rate);
                                    $('#delivery_rate_shipping').val(data.delivery_rate);
                                    $('#estimation_shipping').val(data.totalLeads);
                                    $('#profit_shipping').removeClass('d-none');
                                    $('#profit_shipping').text('');
                                    $('#profit_shipping').text('Estimation Profit : '+data.profit);

                                }
                            }
                            $('#balance').text('');
                            $('#balance').text(response.balance);
                            $('#estimationLeads').text('');
                            $('#estimationLeads').text('Estimation of leads for your situation : '+response.totalLeads);
                            $('#estimationProfit').text('');
                            $('#estimationProfit').text('Estimation Profit : '+response.result);                     
                            if(response.balance == 0){
                                
                                $('#center').html('');
                                $('#center').append('<div><span class="badge bg-danger">You don\'t have enough balance or your subscription is ended to generate scenarios</span></div>'); 
                            }
  
                        }else
                        {
                            toastr.warning('Good Job.', 'Opps Your balance is not enough!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                    },
                    error: function(error) {
                        toastr.warning('Good Job.', 'Opps Error!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                });
            });
        });
    </script>


@endsection
