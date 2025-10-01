@extends('backend.layouts.app')
@section('content')
    @section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
   <style>
        .hiddenRow {
            padding: 0 !important;
        }

    
        .select2-container--default .select2-selection--single .select2-selection__arrow {
    display: none !important;
}

/* Remove default button background and padding */
.whatsapp-icon,
.map-icon,
.phone-icon {
    display: inline-block;
    padding: 0;
    background: none; /* No background */
    border: none; /* No border */
    cursor: pointer;
    text-decoration: none; /* No underline */
}

/* WhatsApp Icon Color */
.whatsapp-icon i {
    color: #25D366; /* WhatsApp Green */
}

/* WhatsApp Icon Hover Color */
.whatsapp-icon:hover i {
    color: #0e7569; /* Darker Green on Hover */
}

/* Map Icon Color */
.map-icon iconify-icon {
    color: #4285F4; /* Google Blue */
}

/* Map Icon Hover Color */
.map-icon:hover iconify-icon {
    color: #2a58bb; /* Darker Blue on Hover */
}

/* Phone Icon Color */
.phone-icon iconify-icon {
    color: #323b35; /* Phone Green */
}

/* Phone Icon Hover Color */
.phone-icon:hover iconify-icon {
    color: #19201a; /* Darker Green on Hover */
}


        #overlay {
            background: #ffffff;
            color: #666666;
            position: fixed;
            height: 100%;
            width: 100%;
            z-index: 5000;
            top: 0;
            left: 0;
            float: left;
            text-align: center;
            padding-top: 25%;
            opacity: .80;
        }

        .spinner {
            margin: 0 auto;
            height: 64px;
            width: 64px;
            animation: rotate 0.3s infinite linear;
            border: 5px solid firebrick;
            border-right-color: transparent;
            border-radius: 50%;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .row.operationbtn button,
        .row.operationbtn a {
            text-transform: uppercase !important;
        }
        @media (max-width: 576px) {
            .col-xs-6 {
                flex: 0 0 auto;
                width: 90%;
            }
            .btn-sm-mobile {
                padding: 0.25rem 0.5rem;
                font-size: 0.875rem;
                line-height: 1.5;
                border-radius: 0.5rem;
            }


            
        }
        @media (max-width: 1483px){
            .col-md-6{
                flex: 0 0 auto;
                width: 50%;
            }
          
        }
        @media (max-width: 900px) {
                    .userU{
                         margin-left:17%;
                 

                    }
                
                }
        @media (min-width: 900px) {
             .userU{
                margin-left:30%;
                 margin-right:10%;
            }
          
        }
       @media (max-width: 576px) {
            .card-title {
            font-size: 14px !important;
            }

            .form-group label,
            .form-control,
            .form-control::placeholder {
            font-size: 12px !important;
            }

            .btn {
            font-size: 13px !important;
            }

            .table th,
            .table td {
            font-size: 11px !important;
            }
            .cont{
                width:130%;
                padding: 3px ;
            }
     
    .mobile-negative-margin {
      margin-left: -20px;
      width: 200%;

     
    }
    .small{
        margin-right : -55px;
    }
  
    .mobile-pair {
            display: flex;
            flex-wrap: wrap;
            gap: 0.1rem;
            width: 105%;
        }

        .mobile-pair > div {
            flex: 1 1 48%;
        }
        .mobile-pair > .form-group {
            padding-right: 0rem;
        }    

    
        .mobile-link-btns {
            display: flex;
            justify-content: space-between;
            margin-top: 0.5rem;
        }

        .mobile-link-btns a {
            flex: 1;
            margin: 0 0.25rem;
        }

        .mobile-hide-input {
            display: none !important;
        }
        .card-body{
           width: 100%; 
            padding: 15px;
        }
        .cardtable{
          
            padding: 0px;
        }
    }
    
    </style>
    @if (Auth::user()->id_role != '3')
        <style>
            .multi {
                display: none;
            }
        </style>
    @endif
    @endsection
        <!-- ============================================================== -->

        <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Detail Lead</h4>
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
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            @if (!empty($lead))
                <div class="row my-4">
                    <div class="col-12">
                        <!-- Column -->
                        <div class="card">
                            <div class="card-body">
                                <!-- Add Contact Popup Model -->
                                <div id="StatusLeads" class="modal fade in" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">History</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <from class="form-horizontal form-material">
                                                    <div class="table-responsive">
                                                        <table id="demo-foo-addrow"
                                                            class="table m-t-30 table-hover contact-list" data-paging="true"
                                                            data-paging-size="7">
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
                                @if (!empty($lead->n_lead))
                                    <h4 class="card-title"style="font-size: 25px; margin-bottom: 40px;">
                                        <span class="d-block d-md-inline">
                                            <span class="d-block d-md-inline mb-2">
                                                -Date Created:
                                                <span style="color: #4f4b69;" class="me-lg-5">
                                                    {{ \Carbon\Carbon::parse($lead->created_at)->format('M d, Y') }}
                                                </span>
                                            </span>
                                        
                                            <span class="d-block d-md-inline  mb-2">
                                               - Status Confirmation:
                                                <span style="color: #70a2ca;" class="me-lg-5"> {{ $lead->status_confirmation }}</span>
                                        
                                               
                                            </span>
                                            <span class="d-block d-md-inline">
                                                @if ($lead->status_confirmation == 'call later')
                                                    <span style="color:#fb8c00;">- in {{ $lead->date_call }}</span>
                                                @endif
                                                @if ($lead->status_confirmation == 'no answer')
                                                 - in {{ $lead->date_call }}
                                                @endif
                                                @if ($lead->status_confirmation == 'confirmed')
                                                    <span class="d-block d-lg-inline" >
                                                        - Date Shipping: {{ \Carbon\Carbon::parse($lead->date_shipped)->format('M d, Y') }}
                                                    </span>
                                                @endif
                                        
                                               
                                            </span>
                                        </span>
                                        
                                        
                                        
                                    </h4>
                                    <div class="row small">
                                        <div class="col-lg-6 col-sm-12 mobile-negative-margin">
                                            <div class="card" style="box-shadow: 0px 0px 3px 1px;">
                                                <div class="card-body">
                                                    <p><!--{{ $lead->status_confirmation }}</p>-->   
     
                                             <div style="display: flex; justify-content: center; align-items: center; ">
                                                    <iconify-icon icon="ix:product" class="text-dark" style="font-size: 70px;"></iconify-icon>
                                                </div>
                                                    <h4 class="card-title" style="font-size: 25px; margin-left:25%; margin-top:15px;">
                                                         Product :
                                                        <span>
                                                            ID {{ $lead->n_lead }}
                                                            @if ($lead->isrollback)
                                                                <span style="background-color: rgb(255, 179, 0);color:rgb(246, 243, 243)"
                                                                    class="badge">Rolled back <svg
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon icon-tabler icon-tabler-alert-circle-filled"
                                                                        width="20" height="20" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M12 2c5.523 0 10 4.477 10 10a10 10 0 0 1 -19.995 .324l-.005 -.324l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm.01 13l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007zm-.01 -8a1 1 0 0 0 -.993 .883l-.007 .117v4l.007 .117a1 1 0 0 0 1.986 0l.007 -.117v-4l-.007 -.117a1 1 0 0 0 -.993 -.883z"
                                                                            stroke-width="0" fill="currentColor" />
                                                                    </svg></span>
                                                            @endif
                                                        </span>
                                                    </h4>
                                                    <form class="form pt-3"style="">
                                                        <div class="row col-sm-12 mb-2 mobile-pair">
                                                            <div class="form-group col-lg-3 mb-2 col-md-12">
                                                                <label>Product Name :</label>
                                                                <select class="form-control" name="product" id="first_product">
                                                                    <option value="">Select Product</option>
                                                                    @foreach ($productseller as $v_pro)
                                                                        <option value="{{ $v_pro->id }}" {{ $v_pro->id == $detailpro->id ? 'selected' : '' }}>
                                                                            {{ $v_pro->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-lg-3 mb-2 col-md-12">
                                                                <label>Stock:</label>
                                                                <input type="text" class="form-control" @if (!empty($lead['stock']->qunatity)) value="{{ $lead['stock']->qunatity }}" @endif />
                                                            </div>
                                                      
                                                        
                                                        
                                                       
                                                            <div class="form-group col-lg-3 mb-2 col-md-12">
                                                                <label>Quantity :</label>
                                                                <input type="text" class="form-control" id="lead_quantity" name="quantity"
                                                                    value="{{ $lead['leadpro']->quantity ?? $lead->quantity }}" />
                                                            </div>
                                                            <div class="form-group col-lg-3 mb-2 col-md-12">
                                                                <label>Product Price :</label>
                                                                <input type="number" class="form-control" id="lead_values" name="price"
                                                                    value="{{ $lead['leadpro']->lead_value ?? $lead->lead_value }}" />
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row col-12 mb-2 mobile-pair">
                                                            <div class="form-group col-lg-6 mb-2 col-md-12">
                                                                <label>Quantity Total :</label>
                                                                <input type="text" class="form-control" id="totl_lead_quantity" name="quantity" disabled
                                                                    value="{{ $lead->quantity ?? 1 }}" />
                                                            </div>
                                                            <div class="form-group col-lg-6 mb-2 col-md-12">
                                                                <label>Total Price :</label>
                                                                <input type="text" class="form-control" id="total_lead_values" name="price"
                                                                    value="{{ $lead->lead_value }}" disabled />
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row col-12 mb-2 mobile-pair">
                                                            <div class="form-group m-r-2  col-lg-6 mb-2 col-md-12">
                                                                <label>Discount :</label>
                                                                <div class="d-flex">
                                                                    <input type="text" class="form-control"
                                                                        id="discount_lead_values" name="price" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group m-r-2  col-lg-6 mt-4 col-md-12">
                                                                <div class="d-flex">
                                                                    <a class="btn btn-primary col-lg-6 waves-effect mx-1 text-white"
                                                                        style="font-size: 10px"
                                                                        data-id="{{ $lead->id }}"
                                                                        id="updateprice">Update</a>
                                                                     <a class="btn btn-primary col-lg-6 waves-effect mx-1 text-white"
                                                                        style="font-size: 10px"
                                                                        data-id="{{ $lead->id }}"
                                                                        id="discountprice">Apply
                                                                        Discount</a> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                            <div class="row col-12 mobile-pair">
                                                                <div class="form-group col-lg-6 mb-2 col-md-12">
                                                                    <label>Link Product :</label>
                                                                    <div class="d-flex align-items-center">
                                                                    <input type="text" class="form-control d-none d-lg-block" value="{{ $detailpro->link }}" readonly />
                                                                    <a class="btn btn-dark waves-effect mx-1" href="{{ $detailpro->link }}" target="_blank">

                                                                        <iconify-icon icon="ix:link-diagonal" class="fs-7 text-white"></iconify-icon>
                                                                    </a>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group col-lg-6 mb-2 col-md-12">
                                                                    <label>Link Video :</label>
                                                                    <div class="d-flex align-items-center">

                                                                        <input type="text" class="form-control d-none d-lg-block" value="{{ $detailpro->link_video }}" readonly />
                                                                        <a class="btn btn-dark waves-effect mx-1" href="{{ $detailpro->link_video }}" target="_blank">
    
                                                                            <iconify-icon icon="ix:link-diagonal" class="fs-7 text-white"></iconify-icon>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="row" style="width: 80%; margin-left: 2%;">
                                                            <div class="form-group col-lg-6 col-md-12">
                                                                <label>Description :</label>
                                                                <textarea class="form-control">{{ $detailpro->description }}</textarea>
                                                            </div>
                                                            <div class="form-group col-lg-6 col-md-12">
                                                                <img src="{{ $detailpro->image }}"
                                                                    style="width: 140px;height:120px ; margin-bottom:65px;" loading="lazy" />
                                                            </div>
                                                        </div>
                                                    </form> 
                                                </div>
                                            </div>
                                       
                                       
                                            <div class="col-lg-6 col-sm-12 mobile-negative-margin">
                                                <div class="card" style="box-shadow: 0px 0px 3px 1px;">
                                                    <div class="card-body" >
                                                     <div class="row">
                                                        <div class="col-lg-9 col-md-12 text-center mb-3 mb-lg-0   userU" style="width: 200px;">
                                                            <iconify-icon icon="ix:user-profile" class="text-dark" style="font-size: 70px;"></iconify-icon>
                                                        </div>

                                                        <div class="col-lg-3 col-md-12 d-flex justify-content-center justify-content-lg-end gap-3 mt-2">
                                                            <!-- WhatsApp Icon -->
                                                            <a id="sapp" href="https://wa.me/{{ $lead->phone }}?text=hi" target="_blank" class="whatsapp-icon" style="color: #25D366; ">
                                                                <i class="fa fa-whatsapp" style="font-size: 30px;"></i>
                                                            </a>

                                                            <!-- Location Icon -->
                                                            <a href="https://google.com/search?q={{ $lead->address }} {{ $lead->zipcod }}" target="_blank" class="map-icon">
                                                                <iconify-icon icon="carbon:location" style="font-size: 30px;"></iconify-icon>
                                                            </a>

                                                            <!-- Phone Icon -->
                                                            <a id="ccall" href="tel:{{ $lead->phone }}" class="phone-icon">
                                                                <iconify-icon icon="carbon:phone" style="font-size: 30px;"></iconify-icon>
                                                            </a>
                                                        </div>
                                                    </div>


                                                        <h4 class="card-title" style="font-size: 25px; margin-left:25%; margin-top:15px;">
                                                                   Customer Information
                                                                </h4>
                                                        <form class="form pt-3"style="">

                                                            <div class="row col-12 mobile-pair">
                                                                <div class="form-group col-lg-6 mb-2 col-md-12">
                                                                    <label>Customer Name :</label>
                                                                    <input type="text" class="form-control"
                                                                        id="customers_name" name="product"
                                                                        value="{{ $lead->name }}" />
                                                                </div>
                                                                <div class="form-group col-lg-6 mb-2 col-md-12">
                                                                    <label>Phone 1 :</label>
                                                                    <input type="text" class="form-control"
                                                                    id="customers_phone" value="{{ $lead->phone }}" />
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="form-group col-lg-12 col-md-12">
                                                                    <label>Address :</label>
                                                                    <textarea class="form-control" id="customers_address">{{ $lead->address }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-md-6 ">
                                                                    <label>City :</label>
                                                                    <select class="form-control select2" id="id_cityy">
                                                                        <option value=" ">Select City</option>
                                                                        @foreach ($cities as $v_city)
                                                                            <option value="{{ $v_city->id }}" 
                                                                                {{ $v_city->id == $lead->id_city ? 'selected' : '' }}>
                                                                                {{ $v_city->name }} / {{ $v_city->last_mille}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                <label>Zone :</label>
                                                                <select class="select2 form-control" id="id_zonee">
                                                                    <option>Select Zone</option>
                                                                </select>
                                                            </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="form-group col-12">
                                                                    <label>Note :</label>
                                                                    <textarea class="form-control" id="customer_note" style="height: 150px !important;">{{ $lead->note }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex justify-content-end mt-3" style="margin-bottom: 8px;">
                                                                <button type="button" class="btn btn-success" id="updateCustomerBtn">
                                                                    <i class="ti ti-save"></i> Update Customer Info
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                                        <div class="row mt-3" style="width: 95%; margin-left: 1%;">
                                                            <div class="col-md-12 column table-responsive" style="min-height: 100px;">
                                                                <table class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-center">Quantity</th>
                                                                            <th class="text-center">Discount</th>
                                                                            <th class="text-center">Note</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="infoupsells">
                                                                        @forelse ($detailupsell as $v_detailupsell)
                                                                            <tr>
                                                                                <td>{{ $v_detailupsell->quantity }}</td>
                                                                                <td>{{ $v_detailupsell->discount }}</td>
                                                                                <td>{{ $v_detailupsell->note }}</td>
                                                                            </tr>
                                                                        @empty
                                                                            <tr>
                                                                                
                                                                                <td colspan="3" class="text-center text-muted">No upsells available.</td>
                                                                            </tr>
                                                                           
                                                                        @endforelse
                                                                    </tbody>
                                                                    
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3 m-t2">
                                                            <div class="col-lg-12 align-self-center">
                                                                <div class="form-group mb-0 text-center">
                                                                    <input type="hidden" id="lead_id"
                                                                        value="{{ $lead->id }}" />
                                                                    <!--<button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 upsell" data-id="{{ $lead->id }}">Add Upsell</button>-->
                                                                    <button type="button"
                                                                        class="btn btn-primary btn-rounded my-2 mb-2 testupsell"
                                                                        data-id="{{ $lead->id }}">Add Upsell</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="card my-4">
                            <div class="card-body">

                                <div class="col-lg-12">
                                    <div class="row">
                                        <h3>Details Upsells</h3>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="col-md-12 column">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">Product Name</th>
                                                                <th class="text-center">Quantity</th>
                                                                <th class="text-center">Price</th>
                                                                <th class="text-center">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($leadproduct as $v_leadproduct)
                                                                <tr>
                                                                    <td class="text-center">
                                                                        @foreach ($v_leadproduct['product'] as $v_pro)
                                                                            {{ $v_pro->name }}
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $v_leadproduct->quantity }}</td>
                                                                    <td class="text-center">
                                                                        {{ $v_leadproduct->lead_value }}</td>
                                                                    <td class="text-center">
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('leads.deleteupsell', $v_leadproduct->id) }}"><i
                                                                                class="ti ti-trash"></i> Deleted</a>
                                                                    </td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="4" class="text-center text-muted">
                                                                        No products added yet.
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card my-4">
                            <div class="card-body">


                                <div class="col-lg-12">
                                    <div class="row">
                                        <h3>Details Products</h3>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <div class="col-md-12 column">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">Product Name</th>
                                                                <th class="text-center">Quantity</th>
                                                                <th class="text-center">Price</th>
                                                                <th class="text-center">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1; ?>
                                                            @forelse ($allproductlead as $v_allproductlead)
                                                                <tr>
                                                                    <td class="text-center">
                                                                        @foreach ($v_allproductlead['product'] as $v_pro)
                                                                            {{ $v_pro->name }}
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center">
                                                                        {{ $v_allproductlead->quantity }}</td>
                                                                    <td class="text-center">
                                                                        {{ $v_allproductlead->lead_value }}</td>
                                                                    <td class="text-center">
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('leads.deleteupsell', $v_allproductlead->id) }}"><i
                                                                                class="ti ti-trash"></i> Deleted</a>
                                                                    </td>
                                                                </tr>
                                                                <?php $i = $i++; ?>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="4" class="text-center text-muted">
                                                                        No products found.
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="overlay" style="display:none;">
                                    <div class="spinner"></div>
                                    <br />
                                    Loading...
                                </div>
                            </div>
                        </div>
                        <div class="card my-4">
                            <div class="card-body">

                           
                                    <div class="row operationbtn my-4">
                                        <div class="col-12 align-self-center">
                                            <div class="form-group mb-0 text-center">
                                                <input type="hidden" id="lead_id" value="{{ $lead->id }}" />
                                                <button class="btn btn-success btn-rounded m-t-10 mb-2 confiremds"
                                                    id="confirmeds">Confirmed</button>
                                                <!-- <button type="button" class="btn btn-orange btn-rounded m-t-10 mb-2 " data-id="{{ $lead->id }}" id="unrechs">no answer</button> -->
                                                <button type="button" class="btn btn-primary btn-rounded m-t-10 mb-2 "
                                                    data-id="{{ $lead->id }}" id="callater">CALL LATER</button>
                                                <button type="button" class="btn btn-danger btn-rounded m-t-10 mb-2 "
                                                    data-id="{{ $lead->id }}" id="cancels">CANCELED</button>
                                                <button type="button" class="btn btn-warning btn-rounded m-t-10 mb-2 "
                                                    data-id="{{ $lead->id }}" id="wrong">WRONG</button>
                                                <button type="button" class="btn btn-dark btn-rounded m-t-10 mb-2 "
                                                    data-id="{{ $lead->id }}" id="duplicated">DUPLICATED</button>
                                                <button style="background-color: #3d9efa" type="button"
                                                    class="btn btn-out  m-t-10 mb-2 text-white "
                                                    data-id="{{ $lead->id }}" id="Horzone"> OUT OF AREA
                                                </button>
                                                <button type="button" class="btn btn-info btn-rounded m-t-10 mb-2 "
                                                    data-id="{{ $lead->id }}" id="unrechstest">no answer</button>
                                                <button type="button" class="btn btn-primary  m-t-10 mb-2   text-white"
                                                    data-id="{{ $lead->id }}" id="outofstock">Out Of
                                                    Stock</button>
                                                <button type="button" class="btn btn-dark m-t-10 mb-2   text-white"
                                                        data-id="{{ $lead->id }}" id="blacklist">Add to Black
                                                        List</button>
                                            </div>

                                        </div>
                                    </div>
                             
                            </div>
                        </div>
                    </div>
                </div>
                <button id="start">Start Recording</button>
                <button id="stop" disabled>Stop Recording</button>
                <audio id="audio" controls></audio>
                        <div id="searchdetail" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="height:auto !important;">
                            <div class="modal-dialog">
                                <div class="modal-content" >
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Choose Date Delivred</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <from class="form-horizontal form-material">
                                        <div class="modal-body">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <h3></h3>
                                                            <div class="row">
                                                                <div class="col-md-12 col-sm-12 my-4">
                                                                    <input type="hidden" class="form-control"
                                                                        id="leadss_id" value="{{ $lead->id }}">
                                                                    <input type="date" class="form-control"
                                                                        id="date_delivredss" placeholder="">
                                                                </div>
                                                                <div class="col-md-12 col-sm-12 my-4">
                                                                    <textarea class="form-control" id="comment_stas"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary waves-effect editlead"
                                                id="datedelivred">Save</button>
                                            <button type="button" class="btn btn-primary waves-effect"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </from>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <div id="callaterpopup" class="modal fade in" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Choose Date Call Later</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <from class="form-horizontal form-material">
                                        <div class="modal-body">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <h3></h3>
                                                            <div class="row">
                                                                <div class="col-md-12 col-sm-12 my-4">
                                                                    <input type="hidden" class="form-control"
                                                                        id="leads_id" value="{{ $lead->id }}">
                                                                    <input type="date"
                                                                        class="form-control pickatime-format-label"
                                                                        id="date_call" placeholder="">
                                                                </div>
                                                                <div class="col-md-12 col-sm-12 my-4">
                                                                    <input type="time"
                                                                        class="form-control pickatime-format-label"
                                                                        id="time_call" placeholder="">
                                                                </div>
                                                                <div class="col-md-12 col-sm-12 my-4">
                                                                    <textarea class="form-control" id="comment_call"></textarea>
                                                                </div>
                                                                <span id="DataAndTime" class="text-danger">

                                                                </span>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary waves-effect editlead"
                                                id="datecall">Save</button>
                                            <button type="button" class="btn btn-primary waves-effect"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </from>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <div id="canceledforms" class="modal fade in" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Note Canceled</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <from class="form-horizontal form-material">
                                        <div class="modal-body">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <h3></h3>
                                                            <div class="row">
                                                                <div class="col-md-12 col-sm-12 my-4">
                                                                    <input type="hidden" class="form-control"
                                                                        id="leads_sid" value="{{ $lead->id }}">
                                                                </div>
                                                                <div class="col-md-12 col-sm-12 my-4">
                                                                    <textarea class="form-control" id="comment_stas_cans"></textarea >  
                                                                </div>
                                                                <span id="textarea_Canceled" class="text-danger"></span>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary waves-effect editlead" id="notecanceleds">Save</button>
                                            <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </from>
                                </div>
                                <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </div>
                                <div id="add-new-lead" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" style="max-width: 720px;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">New Lead</h4> 
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form class="form-horizontal form-material">
                                                <div class="modal-body">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-12 col-sm-12 my-2">
                                                                    <select class="form-control custom-select" style="width: 100%; height:36px;" id="new_id_product">
                                                                        <option>Select Product</option>
                                                                        @foreach ($proo as $v_product)
                                                                    <option value="{{ $v_product->id }}">{{ $v_product->name }} / {{ $v_product->price }}</option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3 col-sm-12 my-2">
                                                                    <input type="hidden" class="form-control" id="lead_id" placeholder="Name Customer">
                                                                    <input type="text" class="form-control" id="new_name_customer" placeholder="Name Customer">
                                                                </div>
                                                                <div class="col-md-3 col-sm-12 my-2">
                                                                    <input type="text" class="form-control" id="new_mobile" placeholder="Mobile">
                                                                </div>
                                                                <div class="col-md-3 col-sm-12 my-2">
                                                                    <input type="text" class="form-control" id="new_mobile2" placeholder="Mobile 2">
                                                                </div>
                                                                <div class="col-md-3 col-sm-12 my-2">
                                                                    <input type="text" class="form-control" id="new_zipcod" placeholder="ZipCod">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-12 my-2">
                                                                    <select class="select2 form-control custom-select" id="new_id_zone">
                                                                        <option>Select province</option>
                                                                        {{-- @foreach ($provinces as $v_pro)
                                                                        <option value="{{ $v_pro->id }}">
                                                                            {{ $v_pro->name }}</option>
                                                                        @endforeach --}}
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6 col-sm-12 my-2">
                                                                    <select class="select2 form-control" id="new_id_city">
                                                                        <option>Select City</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-12 col-sm-12 my-2">
                                                                <textarea type="text" class="form-control" id="new_address" placeholder="Address"></textarea>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4 col-sm-12 my-2">
                                                                        <input type="numbre" class="form-control"
                                                                            id="new_email" placeholder="Email">
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12 my-2">
                                                                        <input type="number" class="form-control"
                                                                            id="new_quantity" placeholder="Quantity">
                                                                    </div>
                                                                    <div class="col-md-4 col-sm-12 my-2">
                                                                        <input type="numbre" class="form-control"
                                                                            id="new_total" placeholder="Total Price">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                    class="btn btn-primary waves-effect"
                                                                    id="savelead">Save</button>
                                                                <button type="button"
                                                                    class="btn btn-primary waves-effect"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                @endif
                        <!-- ============================================================== -->
                        <!-- End Page wrapper  -->
                        <div id="listlead" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" style="max-width:1200px">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">List Leads</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <table id=""
                                                            class="table table-bordered table-striped table-hover contact-list"
                                                            data-paging="true" data-paging-size="7">
                                                            <thead>
                                                                <tr>
                                                                    {{-- <th>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="selectall custom-control-input"
                                                                                id="chkCheckAll" required>
                                                                            <label class="custom-control-label" for="chkCheckAll"></label>
                                                                        </div>
                                                                    </th> --}}
                                                                    <th>Réf</th>
                                                                    <th>Products</th>
                                                                    <th>Name</th>
                                                                    <th>City</th>
                                                                    <th>Phone</th>
                                                                    <th>Lead Value</th>
                                                                    <th>Confirmation</th>
                                                                    <th>Agent</th>
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
                        <!-- Add detail order Popup Model -->
                        

                        <div id="Upselliste" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel"> Upsell List</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <from class="form-horizontal form-material">
                                            <div class="row">
                                                <div class="col-md-12 column">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">Name</th>
                                                                <th class="text-center">Quantity</th>
                                                                <th class="text-center">Price</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="infoupsellss">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </from>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <div id="info-upssel" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" style="max-width:1200px">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Details Upsell</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <from class="form-horizontal form-material">
                                        <div class="modal-body">
                                            <div class="col-lg-12">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <h3>Information Upsell</h3>
                                                            <div class="col-md-12 column">
                                                                <table class="table table-bordered table-hover">
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
                                                                    <tbody id="upsellsinfo">

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary waves-effect"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </from>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- test multi upsells -->
                        <div id="multiupsells" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content" style="min-width:800px !important">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Add Upsell</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <from class="form-horizontal form-material">
                                        <div class="modal-body">
                                            <input type="hidden" id="lead_upsells" class="lead_upsells" />
                                            <div class="col-md-12 table-responsive">
                                                <table class="table table-bordered table-hover table-sortable" id="tab_logics">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">
                                                                Product
                                                            </th>
                                                            <th class="text-center">
                                                                Quantity
                                                            </th>
                                                            <th class="text-center">
                                                                Price
                                                            </th>
                                                            <th class="text-center">
                                                                <a id="add_rows"
                                                                    class="btn btn-primary float-right text-white"style="width: 83px;">Add
                                                                    Row</a>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr id='addrs0' data-id="0" class="hidden">
                                                            <td data-name="name">
                                                                <select id="product_upsellss" class="form-control product_upsellss"
                                                                    name="product_upsellss">
                                                                    <option value="">Select Option</option>
                                                                </select>
                                                            </td>
                                                            <td data-name="mail">
                                                                <input type="number" name="upsells_quantity" id="upsells_quantity"
                                                                    class="form-control upsells_quantity" placeholder='quantity' />
                                                            </td>
                                                            <td data-name="desc">
                                                                <input type="number" name="price_upsells" placeholder="price"
                                                                    id="price_upsells" class="form-control price_upsells" />
                                                            </td>
                                                            <td data-name="del">
                                                                <button name="del0"
                                                                    class='btn btn-danger glyphicon glyphicon-remove row-removes'><span
                                                                        aria-hidden="true">×</span></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <button type="submit" id="saveupsells"
                                                    class="btn btn-primary float-right text-white">Save</button>
                                            </div>
                                        </div>
                                    </from>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        @if (!empty($lead))
                            <!-- test multi upsell -->
                            <div id="multiupsell" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="min-width:800px !important">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Add Upsell</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <from class="form-horizontal form-material">
                                            <div class="modal-body">
                                                <input type="hidden" id="lead_upsell" class="lead_upsell" />
                                                <div class="col-md-12 table-responsive">
                                                    <table class="table table-bordered table-hover table-sortable" id="tab_logic">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">
                                                                    Product
                                                                </th>
                                                                <th class="text-center">
                                                                    Quantity
                                                                </th>
                                                                <th class="text-center">
                                                                    Price
                                                                </th>
                                                                <th>
                                                                    <a id="add_row" class="btn btn-primary float-right text-white"
                                                                        style="font-size:10px" style="width: 83px;">Add Row</a>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr id='addr0' data-id="0" class="hidden">
                                                                <td data-name="name">
                                                                    <select id="product_upsell" class="form-control product_upsell"
                                                                        name="product_upsell">
                                                                        <option value="">Select Option</option>
                                                                    </select>
                                                                </td>
                                                                <td data-name="mail">
                                                                    <input type="number" name="upsell_quantity" id="upsell_quantity"
                                                                        class="form-control upsell_quantity" placeholder='quantity' />
                                                                </td>
                                                                <td data-name="desc">
                                                                    <input type="number" name="price_upsell" placeholder="price"
                                                                        id="price_upsell" class="form-control price_upsell" />
                                                                </td>
                                                                <td data-name="del">
                                                                    <button name="del0"
                                                                        class='btn btn-danger glyphicon glyphicon-remove row-remove'><span
                                                                            aria-hidden="true">×</span></button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <center><button type="submit" id="saveupsell"
                                                            class="btn btn-primary float-right text-white mt-2">Save</button></center>
                                                </div>
                                            </div>
                                        </from>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <div id="datedeli" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Choose Date Delivred</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <from class="form-horizontal form-material">
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <h3></h3>
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12 my-4">
                                                                        <input type="hidden" class="form-control" id="lead_id">
                                                                        <input type="date" class="form-control" id="date_delivred"
                                                                            placeholder="">
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12 my-4">
                                                                        <textarea class="form-control" id="comment_sta"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary waves-effect editlead"
                                                    id="datedelivre">Save</button>
                                                <button type="button" class="btn btn-primary waves-effect"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </from>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- Add Contact Popup Model -->
                            <div id="autherstatus" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Note Status</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <from class="form-horizontal form-material">
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <h3></h3>
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12 my-4">
                                                                        <input type="hidden" class="form-control" id="leads_id">
                                                                        <input type="date" class="form-control" id="date_status"
                                                                            placeholder="">
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12 my-4">
                                                                        <textarea class="form-control" id="coment_sta"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary waves-effect editlead"
                                                    id="changestatus">Save</button>
                                                <button type="button" class="btn btn-primary waves-effect"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </from>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- Add Contact Popup Model -->
                            <div id="addreclamation" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog" style="max-width:1200px">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Complaint</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <from class="">
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <h3>Create Complaint</h3>
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12 my-4">
                                                                        <input type="hidden" class="form-control" id="lead_id_recla"
                                                                            placeholder="N Lead">
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12 my-4">
                                                                        <select class="form-control" id="id_service" name="id_service">
                                                                            <option value="">Select Service</option>
                                                                            <option value="">Livreur</option>
                                                                            <option value="">Stock</option>
                                                                            <option value="">Call Center</option>
                                                                            <option value="">Financier</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12 my-4">
                                                                        <textarea type="text" class="form-control" id="reclamation" placeholder="Reclamation"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary waves-effect adrecla"
                                                    id="adrecla">Save</button>
                                                <button type="button" class="btn btn-primary waves-effect"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </from>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <div id="searchdetails" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Choose Date Delivred</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <from class="form-horizontal form-material">
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <h3></h3>
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12 my-4">
                                                                        <input type="hidden" class="form-control" id="leadsss_id"
                                                                            value="{{ $lead->id }}">
                                                                        <input type="date" class="form-control" id="date_delivredsss"
                                                                            placeholder="">
                                                                        <span id="date_text" class="text-danger"></span>
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12 my-4">
                                                                        <textarea class="form-control" id="comment_stasss"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary waves-effect editlead"
                                                    id="datedelivreds">Save</button>
                                                <button type="button" class="btn btn-primary waves-effect"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </from>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <div id="callaterpopups" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Choose Date Call Later</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <from class="form-horizontal form-material">
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <h3></h3>
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12 my-4">
                                                                        <input type="hidden" class="form-control" id="leadssss_id">
                                                                        <input type="date" class="form-control pickatime-format-label"
                                                                            id="date_calls" placeholder="">
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12 my-4">
                                                                        <input type="time" class="form-control pickatime-format-label"
                                                                            id="time_calls" placeholder="">
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12 my-4">
                                                                        <textarea class="form-control" id="comment_calls"></textarea>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary waves-effect editlead"
                                                    id="datecalls">Save</button>
                                                <button type="button" class="btn btn-primary waves-effect"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </from>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <div id="canceledform" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Note Canceled</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <from class="form-horizontal form-material">
                                            <div class="modal-body">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <h3></h3>
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12 my-4">
                                                                        <input type="hidden" class="form-control" id="leads_id"
                                                                            value="{{ $lead->id }}">
                                                                    </div>
                                                                    <div class="col-md-12 col-sm-12 my-4">
                                                                        <textarea class="form-control" id="comment_stas_can"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary waves-effect editlead"
                                                    id="notecanceled">Save</button>
                                                <button type="button" class="btn btn-primary waves-effect"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </from>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                                <div id="wrongforms" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" >
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Note Wrong</h4> 
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                                <from class="form-horizontal form-material">
                                            <div class="modal-body">
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <h3></h3>
                                                                    <div class="row">
                                                                        <div class="col-md-12 col-sm-12 my-4">
                                                                            <input type="hidden" class="form-control" id="leads_sid_wrong" value="{{ $lead->id }}">
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 my-4">
                                                                            <textarea class="form-control" id="comment_stas_wrong" required></textarea > 
                                                                                
                                                                                <span id="textarea_wrong" class="text-danger"></span>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>  
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary waves-effect editlead" id="notewrong">Save</button>
                                                <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                                </from>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div> 
            @else
                <div class="col-12">
                    <img src="{{ asset('public/Empty-amico.svg')}}" style="margin-left: auto ; margin-right: auto; display: block;" width="500" />
                </div>
            @endif
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
        let mediaRecorder;
        let audioChunks = [];

        document.getElementById('start').onclick = async () => {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.ondataavailable = event => {
                audioChunks.push(event.data);
            };

            mediaRecorder.onstop = async () => {
                const blob = new Blob(audioChunks, { type: 'audio/webm' });
                const formData = new FormData();
                formData.append('voice', blob, 'recording.webm');
                // Send to Laravel
                await fetch('{{ route('leads.voice') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                const audioURL = URL.createObjectURL(blob);
                document.getElementById('audio').src = audioURL;
            };

            mediaRecorder.start();
            document.getElementById('start').disabled = true;
            document.getElementById('stop').disabled = false;
        };

        document.getElementById('stop').onclick = () => {
            mediaRecorder.stop();
            document.getElementById('start').disabled = false;
            document.getElementById('stop').disabled = true;
        };
    </script>
    <script>
        let mediaRecorder;
        let audioChunks = [];

        document.getElementById('start').onclick = async () => {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.ondataavailable = event => {
                audioChunks.push(event.data);
            };

            mediaRecorder.onstop = async () => {
                const blob = new Blob(audioChunks, { type: 'audio/webm' });
                const formData = new FormData();
                formData.append('voice', blob, 'recording.webm');

                // Send to Laravel
                await fetch('/upload-voice', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                const audioURL = URL.createObjectURL(blob);
                document.getElementById('audio').src = audioURL;
            };

            mediaRecorder.start();
            document.getElementById('start').disabled = true;
            document.getElementById('stop').disabled = false;
        };

        document.getElementById('stop').onclick = () => {
            mediaRecorder.stop();
            document.getElementById('start').disabled = false;
            document.getElementById('stop').disabled = true;
        };
    </script>
    <script type="text/javascript">
        $("#upsell_quantity").keyup(function() {
            // Check correct, else revert back to old value.
            if (!$(this).val() || (parseInt($(this).val()) <= 10 && parseInt($(this).val()) >= 1));
            else
                $(this).val(1);
        });
        $("#price_upsell").keyup(function() {
            // Check correct, else revert back to old value.
            if (!$(this).val() || (parseInt($(this).val()) <= 1000000 && parseInt($(this).val()) >= 1));
            else
                $(this).val(1);
        });
        $("#lead_quantity").keyup(function() {
            // Check correct, else revert back to old value.
            if (!$(this).val() || (parseInt($(this).val()) <= 10 && parseInt($(this).val()) >= 1));
            else
                $(this).val(1);
        });
        $("#lead_values").keyup(function() {
            // Check correct, else revert back to old value.
            if (!$(this).val() || (parseInt($(this).val()) <= 1000000 && parseInt($(this).val()) >= 1));
            else
                $(this).val(1);
        });
        $("#quantity").keyup(function() {
            // Check correct, else revert back to old value.
            if (!$(this).val() || (parseInt($(this).val()) <= 10 && parseInt($(this).val()) >= 1));
            else
                $(this).val(1);
        });
        $("#total").keyup(function() {
            // Check correct, else revert back to old value.
            if (!$(this).val() || (parseInt($(this).val()) <= 100000 && parseInt($(this).val()) >= 1));
            else
                $(this).val(1);
        });
        $("#mobile_customer").keyup(function() {
            $value = $(this).val();
            if ($value) {
                $('#whtsapp').attr("href", 'https://wa.me/' + $value);
                $('#call1').attr("href", 'tel:' + $value);
            }
        });
        $("#customers_phone2").keyup(function() {
            $value = $(this).val();
            if ($value) {
                $('#wht2').attr("href", 'https://wa.me/' + $value);
                $('#call3').attr("href", 'tel:' + $value);
            }
        });
        $("#customers_phone").keyup(function() {
            $value = $(this).val();
            if ($value) {
                $('#sapp').attr("href", 'https://wa.me/' + $value);
                $('#ccall').attr("href", 'tel:' + $value);
            }
        });
        $("#mobile2_customer").keyup(function() {
            $value = $(this).val();
            if ($value) {
                $('#wht2').attr("href", 'https://wa.me/' + $value);
                $('#call3').attr("href", 'tel:' + $value);
            }
        });
        $("#search").keyup(function() {
            $value = $(this).val();
            if ($value) {
                $('.alldata').hide();
                $('.datasearch').show();
            } else {
                $('.alldata').show();
                $('.datasearch').hide();
            }
            $.ajax({
                type: 'get',
                url: '{{ route('leads.search') }}',
                data: {
                    'search': $value,
                },
                success: function(data) {
                    $('#contentdata').html(data);
                }
            });
        });
        $(document).ready(function() {
            $('#new_id_product').change(function() {
                var id = $(this).val();
                var ur = "{{ route('leads.edit', ':id') }}";
                ur = ur.replace(':id', id);
                $.ajax({
                    url: ur,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }
                        console.log(response);
                        if (len > 0) {
                            for (var i = 0; i < len; i++) {
                                var option = "<option value='" + response['data'][i].id + "'>" +
                                    response['data'][i].name + "</option>";
                                $("#affiliate").empty
                                $("#affiliate").append(option);
                            }
                        }
                    }
                });
            });
            $(function(e) {
                $('#savelead').click(function(e) {
                    var str_value = $('#new_mobile').val();
                    var n = str_value.length;
                    if ($('#new_id_product').val() != " " && $('#new_quantity').val() != "" && $(
                            '#new_total').val() != "" && $('#new_address').val() != "") {
                        var idproduct = $('#new_id_product').val();
                        var affiliate = $("#affiliate").val();
                        var namecustomer = $('#new_name_customer').val();
                        var quantity = $('#new_quantity').val();
                        var mobile = $('#new_mobile').val();
                        var mobile2 = $('#new_mobile2').val();
                        var cityid = $('#new_id_city').val();
                        var zoneid = $('#new_id_zone').val();
                        var zipcod = $('#new_zipcod').val();
                        var email = $('#new_email').val();
                        var address = $('#new_address').val();
                        var total = $('#new_total').val();
                        var type = $('input[name="statu_confirmation"]').not(this).prop('checked',
                            false);
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('leads.store') }}',
                            cache: false,
                            data: {
                                id: idproduct,
                                namecustomer: namecustomer,
                                quantity: quantity,
                                mobile: mobile,
                                mobile2: mobile2,
                                cityid: cityid,
                                zoneid: zoneid,
                                zipcod: zipcod,
                                email: email,
                                address: address,
                                total: total,
                                affiliate: affiliate,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success == true) {
                                    toastr.success('Good Job.',
                                        'Lead Has been Addess Success!', {
                                            "showMethod": "slideDown",
                                            "hideMethod": "slideUp",
                                            timeOut: 2000
                                        });
                                }
                                location.reload();
                            }
                        });
                    } else {
                        toastr.warning('Opps.', 'Please Complet Data!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }

                });
            });
            // Department Change
          
            // Department Change
          
            // Province Change
            $('#id_province').change(function() {

                var id = $(this).val();
                // Empty the dropdown
                $('#id_cityy').find('option').remove();
                var ur = "{{ route('cities', ':id') }}";
                //console.log(id);
                ur = ur.replace(':id', id);
                // AJAX request 
                $.ajax({
                    url: ur,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {

                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {
                                
                                var id = response['data'][i].id;
                                var name = response['data'][i].name;

                                var option = "<option value='" + id + "'>" + name + "</option>";

                                $("#id_cityy").append(option);
                            }
                            $('#id_cityy').select2();
                        }

                    }
                });
               
            });
            $('#new_id_zone').change(function() {

                // Department id
                var id = $(this).val();
                // Empty the dropdown
                $('#new_id_city').find('option').remove();
                var ur = "{{ route('cities', ':id') }}";
                //console.log(id);
                ur = ur.replace(':id', id);
                // AJAX request 
                $.ajax({
                    url: ur,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {

                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {
                                
                                var id = response['data'][i].id;
                                var name = response['data'][i].name;

                                var option = "<option value='" + id + "'>" + name + "</option>";

                                $("#new_id_city").append(option);
                                $('#new_id_city').select2();
                            }
                        }

                    }
                });
            });
            
            $('body').on('change', '.myform', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var statuu = '#statu_con' + id;
                var status = $(statuu).val();
                if (status == "confirmed") {
                    $('#leads_ids').val(id);
                    $('#searchdetails').modal('show');
                    $('#statusconfirmed').modal('show');
                } else {
                    $('#leads_id').val(id);
                    $('#autherstatus').modal('show');
                }

                //console.log(id);
                $.ajax({
                    type: "POST",
                    url: '{{ route('leads.statuscon') }}',
                    cache: false,
                    data: {
                        id: id,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.', 'Lead Has been Update Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                    }
                });
            });
        });

        $(function(e) {
            $('#confirmed').click(function(e) {
                $id = $('#lead_id').val();
                $('#lead_id').val($id);
                $('#datedeli').modal('show');
            });
        });

        $(function(e) {
            $('#callaters').click(function(e) {
                //console.log(namecustomer);
                $('#callaterpopup').modal('show');
            });
        });

        //popup call later lead search
        $(function(e) {
            $('#callater').click(function(e) {
                var id = $('#leads_id').val();
                $('#leadssss_id').val(id);
                $('#callaterpopups').modal('show');
            });
        });

        //lead princepal status canceled
        $(function(e) {
            $('#cancels').click(function(e) {
                //console.log(namecustomer);
                $('#canceledform').modal('show');
            });
        });
        //lead princepal status wrong
        $(function(e) {
            $('#wrong').click(function(e) {
                //console.log(namecustomer);
                $('#wrongforms').modal('show');
            });
        });
        //lead search status canceled
        $(function(e) {
            $('#cancel').click(function(e) {
                //console.log(namecustomer);
                $('#canceledform').modal('show');
            });
        });

        $(function(e) {
            $('.addreclamationgetid').click(function(e) {
                //console.log(namecustomer);
                $('#addreclamation').modal('show');
                $('#lead_id_recla').val($(this).data('id'));
            });
        });

        $(function(e) {
            $('body').on('click', '.addreclamationgetid2', function(e) {
                //console.log(namecustomer);
                $('#addreclamation').modal('show');
                $('#lead_id_recla').val($(this).data('id'));
            });
        });

        $(function(e) {
            $('#adrecla').click(function(e) {
                var idlead = $('#lead_id_recla').val();
                var service = $('#id_service').val();
                var reclamation = $('#reclamation').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('reclamations.store') }}',
                    cache: false,
                    data: {
                        id: idlead,
                        service: service,
                        reclamation: reclamation,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.',
                                'Reclamation Has been Update Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                        }
                    }
                });
            });
        });
        $(function(e) {
            $('#datedelivreds').click(function(e) {
                var id = $('#leadsss_id').val();
                var customename = $('#customers_name').val();
                var customerphone = $('#customers_phone').val();
                var customerphone2 = $('#customers_phone2').val();
                var customeraddress = $('#customers_address').val();
                var zipcod = $('#customers_zipcod').val();
                var email = $('#customers_email').val();
                var recipient = $('#customers_recipient_number').val();
                var customercity = $('#id_cityy').val();
                var customerzone = $('#id_zonee').val();
                var leadvalue = $('#lead_values').val();
                var leadvquantity = $('#lead_quantity').val();
                var product = $('#first_product').val();
                var datedelivred = $('#date_delivredsss').val();
                var commentdeliv = $('#comment_stasss').val();

                $('#datedelivreds').prop("disabled", true);
                $('#overlay').fadeIn();
                $.ajax({
                    type: "POST",
                    url: '{{ route('leads.confirmed') }}',
                    cache: false,
                    data: {
                        id: id,
                        customename: customename,
                        customerphone: customerphone,
                        customerphone2: customerphone2,
                        customeraddress: customeraddress,
                        zipcod: zipcod,
                        email: email,
                        customercity: customercity,
                        customerzone: customerzone,
                        leadvalue: leadvalue,
                        leadvquantity: leadvquantity,
                        commentdeliv: commentdeliv,
                        datedelivred: datedelivred,
                        product: product,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.', 'Lead Has been Confirmed Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            $('#searchdetails').modal('hide');
                            location.reload();
                        }
                    }
                });

            });
        });
        $(function(e) {
            $('#confirmeds').click(function(e) {
                $id = $('#lead_id').val();
                $('#leadss_id').val($id);
                if ($('#id_cityy').val() != " ") {
                    $('#searchdetails').modal('show');
                } else {
                    toastr.warning('Opps.', 'please Select City!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                }
            });
        });

        //lead princepal popup status canceled
        $(function(e) {
            $('#notecanceleds').click(function(e) {
                var id = $('#leads_sid').val();
                var customename = $('#customers_name').val();
                var customerphone = $('#customers_phone').val();
                var customerphone2 = $('#customers_phone2').val();
                var commentecanceled = $('#comment_stas_cans').val();
                var customeraddress = $('#customers_address').val();
                var customercity = $('#id_cityy').val();
                var customerzone = $('#id_zonee').val();
                if ($('#comment_stas_cans').val() != "") {
                    $('#notecanceleds').prop("disabled", true);
                    $('#overlay').fadeIn();
                    $.ajax({
                        type: "POST",
                        url: '{{ route('leads.canceled') }}',
                        cache: false,
                        data: {
                            id: id,
                            commentecanceled: commentecanceled,
                            customerphone: customerphone,
                            customerphone2: customerphone2,
                            customename: customename,
                            customercity: customercity,
                            customerzone: customerzone,
                            customeraddress: customeraddress,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.', 'Lead Has been Update Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                                location.reload();
                            }
                        }
                    });
                } else {
                    $("#textarea_Canceled").empty();
                    $("#textarea_Canceled").append("Please insert Notes");
                }

            });
        });
        //lead princepal popup status canceled
        $(function(e) {
            $('#notewrong').click(function(e) {
                var id = $('#leads_sid_wrong').val();
                var customename = $('#customers_name').val();
                var customerphone = $('#customers_phone').val();
                var customerphone2 = $('#customers_phone2').val();
                var commentewrong = $('#comment_stas_wrong').val();
                var customeraddress = $('#customers_address').val();
                var customercity = $('#id_cityy').val();
                var customerzone = $('#id_zonee').val();
                if ($('#comment_stas_wrong').val() != "") {
                    $('#notewrong').prop("disabled", true);
                    $('#overlay').fadeIn();
                    $.ajax({
                        type: "POST",
                        url: '{{ route('leads.wrong') }}',
                        cache: false,
                        data: {
                            id: id,
                            commentewrong: commentewrong,
                            customerphone: customerphone,
                            customerphone2: customerphone2,
                            customename: customename,
                            customercity: customercity,
                            customerzone: customerzone,
                            customeraddress: customeraddress,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.', 'Lead Has been Update Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                                location.reload();
                            }
                        }
                    });
                } else {
                    $("#textarea_wrong").empty();
                    $("#textarea_wrong").append("Please insert Notes");
                }

            });
        });
        //lead search popup status canceled
        $(function(e) {
            $('#notecanceled').click(function(e) {
                var id = $('#lead_id').val();
                var commentecanceled = $('#comment_stas_can').val();
                $.ajax({
                    type: "POST",
                    url: '{{ route('leads.canceled') }}',
                    cache: false,
                    data: {
                        id: id,
                        commentecanceled: commentecanceled,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.', 'Lead Has been Update Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            location.reload();
                        }
                    }
                });
            });
        });
        //lead princepal status unrechs
        $(function(e) {
            $('#unrechs').click(function(e) {
                var idlead = $('#lead_id').val();
                //alert();
                var status = "no answer";
                //console.log(namecustomer);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('leads.statusc') }}',
                    cache: false,
                    data: {
                        id: idlead,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.', 'Lead Has been Update Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            location.reload();
                        }
                    }
                });
            });
        });

        $('#duplicated').click(function(e) {
            $('#overlay').fadeIn();
            var data_id = $(this).data('id');
            var url = "{{ route('leads.duplicated', ':id') }}";
            url = url.replace(':id', data_id);
            location.href = url;
        });
        $('#Horzone').click(function(e) {
            $('#overlay').fadeIn();
            var data_id = $(this).data('id');
            var url = "{{ route('leads.horzone', ':id') }}";
            url = url.replace(':id', data_id);
            location.href = url;
        });
        $('#Relancement').click(function(e) {
            $('#overlay').fadeIn();
            var data_id = $(this).data('id');
            var url = "{{ route('relancements.index', ':id') }}";
            url = url.replace(':id', data_id);
            location.href = url;
        });

        $(function(e) {
            $('#unrechstest').click(function(e) {
                // .delay(2000).fadeOut()

                var idlead = $('#lead_id').val();
                //alert();
                var status = "no answer";
                //console.log(namecustomer);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('leads.statusctest') }}',
                    cache: false,
                    data: {
                        id: idlead,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function(data) {
                        // console.log(data);
                        $('#overlay').fadeIn();
                    },
                    success: function(data) {
                        // console.log(leads.statusctest);
                        console.log(data);
                        toastr.success(data.success);
                        // toastr.success('Good Job.', 'Lead Has been Update Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                        $('#overlay').fadeIn().delay(20000);
                        location.reload();
                    },
                    error: function(data) {
                        $('#overlay').fadeOut();
                        toastr.error(data.statusText);
                        // toastr.success('Good Job.', 'Lead Has been Update Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                    },
                    complete: function() {
                        $('#overlay').fadeOut();
                    }
                });
            });
        });

        $(function(e) {
            $('#outofstock').click(function(e) {
                // .delay(2000).fadeOut()

                var idlead = $('#lead_id').val();
                //alert();
                var status = "outofstock";
                //console.log(namecustomer);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('leads.outofstocks') }}',
                    cache: false,
                    data: {
                        id: idlead,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function(data) {
                        // console.log(data);
                        $('#overlay').fadeIn();
                    },
                    success: function(data) {
                        // console.log(leads.statusctest);
                        console.log(data);
                        toastr.success(data.success);
                        // toastr.success('Good Job.', 'Lead Has been Update Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                        $('#overlay').fadeIn().delay(20000);
                        location.reload();
                    },
                    error: function(data) {
                        $('#overlay').fadeOut();
                        toastr.error(data.statusText);
                        // toastr.success('Good Job.', 'Lead Has been Update Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                    },
                    complete: function() {
                        $('#overlay').fadeOut();
                    }
                });
            });
        });
        //lead search status unrechs
        $(function(e) {
            $('#unrech').click(function(e) {
                var idlead = $('#leads_id').val();
                //alert();
                var status = "no answer";
                //console.log(namecustomer);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('leads.statusc') }}',
                    cache: false,
                    data: {
                        id: idlead,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.', 'Lead Has been Update Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            location.reload();
                        }
                    }
                });
            });
        });
        $(function(e) {
            $('#unrech').click(function(e) {
                var idlead = $('#lead_id').val();
                //alert();
                var status = "no answer";
                //console.log(namecustomer);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('leads.statusc') }}',
                    cache: false,
                    data: {
                        id: idlead,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.', 'Lead Has been Update Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            location.reload();
                        }
                    }
                });
            });
        });
        $(function(e) {
            $('#datecall').click(function(e) {
                var idlead = $('#leads_id').val();
                var date = $('#date_call').val();
                var time = $('#time_call').val();
                var comment = $('#comment_call').val();
                var customename = $('#customers_name').val();
                var customerphone = $('#customers_phone').val();
                var customerphone2 = $('#customers_phone2').val();
                var customeraddress = $('#customers_address').val();
                var zipcod = $('#customers_zipcod').val();
                var recipient = $('#customers_recipient_number').val();
                var customercity = $('#id_cityy').val();
                var customerzone = $('#id_zonee').val();
                var status = "call later";
                //console.log(namecustomer);
                if ($('#date_call').val() != "" && $('#time_call').val() != "") {
                    $('#datecall').prop("disabled", true);
                    $('#overlay').fadeIn();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('leads.call') }}',
                        cache: false,
                        data: {
                            id: idlead,
                            date: date,
                            time: time + ":00",
                            comment: comment,
                            status: status,
                            customename: customename,
                            customerphone: customerphone,
                            customerphone2: customerphone2,
                            customeraddress: customeraddress,
                            customercity: customercity,
                            customerzone: customerzone,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.', 'Lead Has been Update Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                                location.reload();
                            }
                        }
                    });
                } else {
                    $("#DataAndTime").empty();
                    $("#DataAndTime").append("Please insert Date and Time");
                }

            });
        });

        //update price
        $(function(e) {
            $('#updateprice').click(function(e) {
                var idlead = $(this).data('id');
                var quantity = $('#lead_quantity').val();
                var leadvalue = $('#lead_values').val();
                var product = $('#first_product').val();
                $('#overlay').fadeIn();
                //console.log(namecustomer);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('leads.updateprice') }}',
                    cache: false,
                    data: {
                        id: idlead,
                        quantity: quantity,
                        leadvalue: leadvalue,
                        product: product,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            $('#total_lead_values').val(response['update']['lead_value']);
                            $('#totl_lead_quantity').val(response['update']['quantity']);
                            toastr.success('Good Job.', 'Lead Has been Update Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            $('#overlay').fadeOut();
                        }
                    }
                });
            });


        

        });

        //call later lead search

        $(function(e) {
            $('#datecalls').click(function(e) {
                var idlead = $('#leadssss_id').val();
                var date = $('#date_calls').val();
                var time = $('#time_calls').val();
                var comment = $('#comment_calls').val();
                var status = "call later";
                var customename = $('#customers_name').val();
                var customerphone = $('#customers_phone').val();
                var customerphone2 = $('#customers_phone2').val();
                var customeraddress = $('#customers_address').val();
                var customercity = $('#id_cityy').val();
                var customerzone = $('#id_zonee').val();
                //console.log(namecustomer);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('leads.call') }}',
                    cache: false,
                    data: {
                        id: idlead,
                        date: date,
                        time: time,
                        comment: comment,
                        status: status,
                        customename: customename,
                        customerphone: customerphone,
                        customerphone2: customerphone2,
                        customeraddress: customeraddress,
                        customercity: customercity,
                        customerzone: customerzone,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.', 'Lead Has been Update Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            location.reload();
                        }
                    }
                });
            });
        });


        $(function(e) {
            $('#changestatus').click(function(e) {
                var idlead = $('#leads_id').val();
                var date = $('#date_status').val();
                var comment = $('#coment_sta').val();
                //console.log(namecustomer);
                $.ajax({
                    type: 'POST',
                    url: '{{ route('leads.notestatus') }}',
                    cache: false,
                    data: {
                        id: idlead,
                        date: date,
                        comment: comment,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            $('#datedeli').modal('hide');
                            toastr.success('Good Job.', 'Lead Has been Update Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                    }
                });
            });
        });

        $(function(e) {
            $('.seehystory').click(function(e) {
                $value = $(this).data('id');
                //alert($value);
                //console.log(namecustomer);
                $.ajax({
                    type: 'get',
                    url: '{{ route('leads.seehistory') }}',
                    cache: false,
                    data: {
                        'id': $value,
                    },
                    success: function(data) {
                        $('#StatusLeads').modal('show');
                        $('#history').html(data);
                    }
                });
            });
        });


        //table dynamic
        $(document).ready(function() {
            $("#add_row").on("click", function() {
                var newid = 0;
                $.each($("#tab_logic tr"), function() {
                    if (parseInt($(this).data("id")) > newid) {
                        newid = parseInt($(this).data("id"));
                    }
                });
                newid++;
                var tr = $("<tr></tr>", {
                    id: "addr" + newid,
                    "data-id": newid
                });
                $.each($("#tab_logic tbody tr:nth(0) td"), function() {
                    var td;
                    var cur_td = $(this);
                    var children = cur_td.children();
                    if ($(this).data("name") !== undefined) {
                        td = $("<td></td>", {
                            "data-name": $(cur_td).data("name")
                        });
                        var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
                        c.attr("name", $(cur_td).data("name") + newid);
                        c.appendTo($(td));
                        td.appendTo($(tr));
                    } else {
                        td = $("<td></td>", {
                            'text': $('#tab_logic tr').length
                        }).appendTo($(tr));
                    }
                });
                $(tr).appendTo($('#tab_logic'));
                $(tr).find("td button.row-remove").on("click", function() {
                    $(this).closest("tr").remove();
                });
            });
            // Sortable Code
            var fixHelperModified = function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();

                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width())
                });

                return $helper;
            };

            $(".table-sortable tbody").sortable({
                helper: fixHelperModified
            }).disableSelection();

            $(".table-sortable thead").disableSelection();



            $("#add_row").trigger("click");
        });

        //table dynamic
        $(document).ready(function() {
            //addrows
            $("#add_rows").on("click", function() {
                var newid = 0;
                $.each($("#tab_logics tr"), function() {
                    if (parseInt($(this).data("id")) > newid) {
                        newid = parseInt($(this).data("id"));
                    }
                });
                newid++;
                var tr = $("<tr></tr>", {
                    id: "addrs" + newid,
                    "data-id": newid
                });
                $.each($("#tab_logics tbody tr:nth(0) td"), function() {
                    var td;
                    var cur_td = $(this);
                    var children = cur_td.children();
                    if ($(this).data("name") !== undefined) {
                        td = $("<td></td>", {
                            "data-name": $(cur_td).data("name")
                        });
                        var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
                        c.attr("name", $(cur_td).data("name") + newid);
                        c.appendTo($(td));
                        td.appendTo($(tr));
                    } else {
                        td = $("<td></td>", {
                            'text': $('#tab_logics tr').length
                        }).appendTo($(tr));
                    }
                });
                $(tr).appendTo($('#tab_logics'));
                $(tr).find("td button.row-removes").on("click", function() {
                    $(this).closest("tr").remove();
                });
            });




            // Sortable Code
            var fixHelperModified = function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();

                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width())
                });

                return $helper;
            };

            $(".table-sortable tbody").sortable({
                helper: fixHelperModified
            }).disableSelection();

            $(".table-sortable thead").disableSelection();



            $("#add_rows").trigger("click");
        });

        $(function() {
            $('body').on('click', '.upsell', function(products) {
                var id = $('#lead_id').val();
                $('#lead_upsell').val(id);
                $.get("{{ route('leads.index') }}" + '/' + id + '/detailspro', function(response) {
                    $('#upsell').modal('show');
                    var len = 0;
                    if (response['data'] != null) {
                        len = response['data'].length;
                    }
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            var id = response['data'][i].id;
                            var name = response['data'][i].name;
                            var option = "<option value='" + id + "'>" + name + "</option>";

                            $("#product_upsell").append(option);
                        }
                    }
                });
            });
            //multiupsell

            $('body').on('click', '.testupsell', function(products) {
                var id = $('#lead_id').val();
                $('#lead_upsell').val(id);
                $.get("{{ route('leads.index') }}" + '/' + id + '/detailspro', function(response) {
                    $('#multiupsell').modal('show');
                    var len = 0;
                    if (response['data'] != null) {
                        len = response['data'].length;
                    }
                    if (len > 0) {
                        $("#product_upsell").empty('');
                        for (var i = 0; i < len; i++) {
                            var id = response['data'][i].id;
                            var name = response['data'][i].name;
                            var price = response['data'][i].price;
                            var option = "<option value='" + id + "'>" + name + "/" + price +
                                "</option>";
                            $("#product_upsell").append(option);
                        }
                    }
                });
            });
            //multiupsells

            $('body').on('click', '.testupsells', function(products) {
                var id = $('#lead_id').val();
                $('#lead_upsells').val(id);
                $.get("{{ route('leads.index') }}" + '/' + id + '/detailspro', function(response) {
                    $('#multiupsells').modal('show');
                    var len = 0;
                    if (response['data'] != null) {
                        len = response['data'].length;
                    }
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            var id = response['data'][i].id;
                            var name = response['data'][i].name;
                            var price = response['data'][i].price;
                            var option = "<option value='" + id + "'>" + name + "/" + price +
                                "</option>";
                            $("#product_upsellss").append(option);
                        }
                    }
                });
            });
        });

        $(function() {
            $('body').on('click', '.upselllist', function(products) {
                var id = $('#lead_id').val();
                $('#lead_upsell').val(id);
                $.get("{{ route('leads.index') }}" + '/' + id + '/listupsell', function(response) {
                    $('#Upselliste').modal('show');
                    //alert(response);
                    $('#infoupsellss').html(response);
                });
            });
        });

        $(function(e) {
            $('#editsheets').click(function(e) {
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
                    type: 'POST',
                    url: '{{ route('leads.update') }}',
                    cache: false,
                    data: {
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
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.', 'Lead Has been Update Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                    }
                });
            });
        });

        $(function() {
            $('body').on('click', '.infoupsell', function(products) {
                var id = $('#lead_id').val();
                $.get("{{ route('leads.index') }}" + '/' + id + '/infoupsell', function(data) {
                    $('#info-upssel').modal('show');
                    $('#upsellsinfo').html(data);
                });
            });
        });

        $(function() {
            $('body').on('click', '.upsell', function(products) {
                var id = $(this).data('id');
                $.get("{{ route('leads.index') }}" + '/' + id + '/details', function(data) {
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
                    for (var i in data) {
                        var quantity = data[0].leads[0].quantity;
                        var id_product = data[0].leads[0].id_product;
                        var price = data[0].leads[0].lead_value;
                        $('#addr' + i).html("<td>" + (i + 1) +
                            "</td><td><div class='form-control-wrap'><select class='form-control form-select select2-accessible' data-placeholder='sélectionnez une opltion' required='' id='product_lead' name='id_product[]' data-select2-id='fv-topics' tabindex='-1' aria-hidden='true'>@foreach ($productss as $v_product) @foreach ($v_product['products'] as $product)<option value='{{ $product['id'] }}' {{ $product['id'] == '"+ data[i].id_product +"' ? 'selected' : '' }}>{{ $product['name'] }}</option>@endforeach @endforeach</select></div> </td><td><input  name='quantity[]' id='quantity_lead' type='text' placeholder='Quantity' value='" +
                            quantity +
                            "' required class='form-control input-md'></td><td><input  name='price[]' id='total_lead' type='text' placeholder='Lead Value' value='" +
                            price + "' required class='form-control input-md'></td>");

                    }

                });
            });
        });

        $('#saveupsell').click(function(e) {
            e.preventDefault();
            var id = $('#lead_upsell').val();
            var leadquantity = $('#lead_quantity').val();
            var leadprice = $('#lead_values').val();
            var product = [];
            $('.product_upsell').find("option:selected").each(function() {
                product.push($(this).val());
            });
            var quantity = [];
            $(".upsell_quantity").each(function() {
                quantity.push($(this).val());
            });
            var price = [];
            $(".price_upsell").each(function() {
                price.push($(this).val());
            });
            //console.log(agent);
            $.ajax({
                type: "POST",
                url: '{{ route('leads.multiupsell') }}',
                cache: false,
                data: {
                    id: id,
                    product: product,
                    quantity: quantity,
                    price: price,
                    leadprice: leadprice,
                    leadquantity: leadquantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success == true) {
                        toastr.success('Good Job.', 'Upsell Has been Added Success!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                        $('#upsell').modal('hide');
                        location.reload();
                    }
                }
            });
        });

        //sve multi upsell


        $('#saveupsells').click(function(e) {
            e.preventDefault();
            var id = $('.lead_upsells').val();
            var product = [];
            $('.product_upsells').find("option:selected").each(function() {
                product.push($(this).val());
            });
            var quantity = [];
            $(".upsell_quantity").each(function() {
                quantity.push($(this).val());
            });
            var price = [];
            $(".price_upsell").each(function() {
                price.push($(this).val());
            });
            $.ajax({
                type: "POST",
                url: '{{ route('leads.multiupsell') }}',
                cache: false,
                data: {
                    'id': id,
                    'product': product,
                    'quantity': quantity,
                    'price': price,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success == true) {
                        toastr.success('Good Job.', 'Upsell Has been Added Success!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                        $('#upsell').modal('hide');
                    }
                    location.reload();
                }
            });
        });

        ///list lead search



        $('#searchdetai').click(function(e) {
            e.preventDefault();
            var n_lead = $('#search_2').val();
            $('#listlead').modal('show');
            //console.log(n_lead);
            $.ajax({
                type: "get",
                url: '{{ route('leads.leadsearch') }}',
                data: {
                    n_lead: n_lead,
                },
                success: function(data) {
                    $('#listleadss').html(data);
                }
            });
        });

        $(document).on('click', '.next', function() {
            var id = $('#next_id').val();
            $.get("{{ route('leads.index') }}" + '/' + id + '/details', function(data) {
                $('#editsheet').modal('show');

                $('#lead_id').val(data[0].leads[0].id);
                $('#name_custome').val(data[0].leads[0].name);
                $('#mobile_customer').val(data[0].leads[0].phone);
                $('#mobile2_customer').val(data[0].leads[0].phone2);
                $('#customer_adress').val(data[0].leads[0].address);
                $('#link_products').val(data[0].products[0].link);
                $('#lead_note').val(data[0].leads[0].note);
                $('#id_cityy').val(data[0].leads[0].id_city);
                $('#next_id').val(data[0].leads[0].id - 1);
                $('#previous_id').val(data[0].leads[0].id + 1);
                for (var i in data) {
                    var quantity = data[0].leads[0].quantity;
                    var id_product = data[0].leads[0].id_product;
                    var price = data[0].leads[0].lead_value;
                    $('#addr' + i).html("<td>" + (i + 1) +
                        "</td><td><div class='form-control-wrap'><select class='form-control form-select select2-accessible' data-placeholder='sélectionnez une opltion' required='' id='product_lead' name='id_product[]' data-select2-id='fv-topics' tabindex='-1' aria-hidden='true'>@foreach ($productss as $v_product) @foreach ($v_product['products'] as $product)<option value='{{ $product['id'] }}' {{ $product['id'] == '"+ data[i].id_product +"' ? 'selected' : '' }}>{{ $product['name'] }}</option>@endforeach @endforeach</select></div> </td><td><input  name='quantity[]' id='quantity_lead' type='text' placeholder='Quantity' value='" +
                        quantity +
                        "' required class='form-control input-md'></td><td><input  name='price[]' id='total_lead' type='text' placeholder='Lead Value' value='" +
                        price + "' required class='form-control input-md'></td>");
                }
            });
        });
        $(document).on('click', '.previous', function() {
            var id = $('#previous_id').val();
            $.get("{{ route('leads.index') }}" + '/' + id + '/details', function(data) {
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
                for (var i in data) {
                    var quantity = data[0].leads[0].quantity;
                    var id_product = data[0].leads[0].id_product;
                    var price = data[0].leads[0].lead_value;
                    $('#addr' + i).html("<td>" + (i + 1) +
                        "</td><td><div class='form-control-wrap'><select class='form-control form-select select2-accessible' data-placeholder='sélectionnez une opltion' required='' id='product_lead' name='id_product[]' data-select2-id='fv-topics' tabindex='-1' aria-hidden='true'>@foreach ($productss as $v_product) @foreach ($v_product['products'] as $product)<option value='{{ $product['id'] }}' {{ $product['id'] == '"+ data[i].id_product +"' ? 'selected' : '' }}>{{ $product['name'] }}</option>@endforeach @endforeach</select></div> </td><td><input  name='quantity[]' id='quantity_lead' type='text' placeholder='Quantity' value='" +
                        quantity +
                        "' required class='form-control input-md'></td><td><input  name='price[]' id='total_lead' type='text' placeholder='Lead Value' value='" +
                        price + "' required class='form-control input-md'></td>");

                }

            });
        });
        //confirmed lead search

        $(function(e) {
            $('#datedelivre').click(function(e) {
                var id = $('#lead_id').val();
                var customename = $('#customer_name').val();
                var customerphone = $('#mobile_customer').val();
                var customerphone2 = $('#mobile2_customer').val();
                var customeraddress = $('#customer_address').val();
                var customercity = $('#id_cityys').val();
                var customerzone = $('#id_zonees').val();
                var leadvalue = $('#lead_value').val();
                var datedelivred = $('#date_delivred').val();
                var commentdeliv = $('#comment_sta').val();
                $.ajax({
                    type: "POST",
                    url: '{{ route('leads.confirmed') }}',
                    cache: false,
                    data: {
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
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.', 'Lead Has been Update Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            $('#datedelivre').modal('hide');
                            location.reload();
                        }
                    }
                });
            });
        });

        $(document).on('click', '#searchdetail', function() {
            var id = $('#search_2').val();
            $.get("{{ route('leads.index') }}" + '/' + id + '/seacrhdetails', function(data) {
                $('#editsheet').modal('show');
                //console.log(data);
                $('#lead_id').val(data.id);
                $('#name_custome').val(data.name);
                $('#mobile_customer').val(data.phone);
                $('#mobile2_customer').val(data.phone2);
                $('#customer_adress').val(data.address);
                $('#lead_note').val(data.note);
                $('#id_cityy').val(data.id_city);
                var quantity = data.quantity;
                var price = data.lead_value;
                $('#addr' + 1).html("<td>" + (1) +
                    "</td><td><div class='form-control-wrap'><select class='form-control form-select select2-accessible' data-placeholder='sélectionnez une opltion' required='' id='product_lead' name='id_product[]' data-select2-id='fv-topics' tabindex='-1' aria-hidden='true'>@foreach ($productss as $v_product) @foreach ($v_product['products'] as $product)<option value='{{ $product['id'] }}' {{ $product['id'] == '"+ data.id_product +"' ? 'selected' : '' }}>{{ $product['name'] }}</option>@endforeach @endforeach</select></div> </td><td><input  name='quantity[]' id='quantity_lead' type='text' placeholder='Quantity' value='" +
                    quantity +
                    "' required class='form-control input-md'></td><td><input  name='price[]' id='total_lead' type='text' placeholder='Lead Value' value='" +
                    price + "' required class='form-control input-md'></td>");



            });
        });

        //get price product

        $(document).on('click', '#id_product', function() {
            var id = $('#id_product').val();
            $.get("{{ route('products.index') }}" + '/' + id + '/price', function(data) {
                $('#total').val(data);
            });
        });




        function toggleText() {
            var x = document.getElementById("multi");
            if (x.style.display === "none") {
                x.style.display = "block";
                $('#timeseconds').val('');
            } else {
                x.style.display = "none";
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#id_city").select2({
                dropdownParent: $("#add-new-lead")
            });
        });

        $(document).ready(function() {
            $("#id_product").select2({
                dropdownParent: $("#add-new-lead")
            });
        });

        $(document).ready(function() {
            $("#id_zone").select2({
                dropdownParent: $("#add-new-lead")
            });
        });
    </script>
@endsection
