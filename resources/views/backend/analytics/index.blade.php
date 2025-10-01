@extends('backend.layouts.app')
@section('content')
    <style>
        .chartjs {
            height: 366px !important;
        }
        body{
          overflow-x: hidden;
        }
    </style>
        <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                 <div class="d-sm-flex align-items-center justify-space-between">
                         <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                        <i class="ti ti-arrow-left fs-5"></i> 
                    </a>
                    <div>
                        <h4 class="mb-4 mb-sm-0 card-title">Analytics</h4>
                        <p class="mb-0 text-muted"> Track sales, leads, and performance in real time.</p>
                                    
                    </div>
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

            <div class="row">
                <div class="col-12">
                </div>
                <div class="col-12 ">
                    <div class="card">
                        <div class="row m-4 d-flex align-items-center justify-content-between">
                            <h4 class="mb-4">Calculate Net Profite</h4>
                            <form class=" align-items-center">
                                <div class="row">
                                    <div class="col-lg-3 col-md-10">
                                        <div class="dl">
                                            <div class="col-12 align-self-center">
                                             <label class="text-dark" for="date" style="margin-bottom: 5px;">Date Range</label>
                                                <div class='input-group '>
                                                    <input type='text' class="form-control dated"
                                                        name="profit_date" value="{{ request()->input('date_call') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-lg-2 col-md-10">
                                        <div class="dl w-100">
                                            <label class="text-dark" for="store" style="margin-bottom: 5px;">Select Store</label>
                                            <select class="select2 form-control"  name="store" placeholder="Select Store" id="all_product_select">
                                                <option>Select Store</option>
                                                @foreach ($stores as $v_store)
                                                    <option value="{{ $v_store->id }}" {{ $v_store->id == request()->input('store') ? 'selected' : '' }}>{{ $v_store->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class=" col-lg-2 col-md-10">
                                        <div class="dl w-100">
                                            <label class="text-dark" for="product" style="margin-bottom: 5px;">Select Product</label>
                                            <select class="form-control select2" name="profite_product">
                                                <option >Select Product</option>
                                                @foreach ($products as $v_product)
                                                    <option value="{{ $v_product->id }}"
                                                        {{ $v_product->id == request()->input('profite_product') ? 'selected' : '' }}>
                                                        {{ $v_product->name }} / {{ $v_product->sku }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class=" col-lg-2 col-md-10">
                                        <div class="dl w-100">
                                            <label class="text-dark" for="agent" style="margin-bottom: 5px;">Select Agent Confirmation</label>
                                            <select class="form-control select2" name="profite_agents">
                                                <option value=" " selected>Select Agent Confirmation</option>
                                                @foreach ($agents as $v_agent)
                                                    <option value="{{ $v_agent->id }}"
                                                        {{ $v_agent->id == request()->input('profite_agents') ? 'selected' : '' }}>
                                                        {{ $v_agent->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class=" col-lg-2 col-md-10">
                                        <div class="dl w-100">
                                            <label class="text-dark" for="shipping" style="margin-bottom: 5px;">Select Shipping Company</label>
                                            <select class="form-control select2" name="profite_shipping">
                                                <option value=" " selected>Select Shipping Company</option>
                                                @foreach ($companys as $v_company)
                                                    <option value="{{ $v_company->id }}"
                                                        {{ $v_company->id == request()->input('profite_shipping') ? 'selected' : '' }}>
                                                        {{ $v_company->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class=" col-lg-12 col-md-12">
                                        <div class="align-items-center">
                                            <div class="dl">
                                                <button class="btn btn-primary input-group-append w-100" type="submit">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-3 mb-3" bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Total Ads</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{ $speendads }}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3" bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Revenue</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{ $revenues}}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3" bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Products Fees</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{$sumproduct}}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3" bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Expenses</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{ $expensse}}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3" bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Shipping Fees</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{number_format((float)($feessdelivered) , 2)}}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3" bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Total Profit</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{ number_format((float)($revenues - ($speendads + $sumproduct + $expensse + $feessdelivered)), 2) }}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3" bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Profit per Delivered Order</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{ number_format((float)($costperdelivered) , 2)}}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 mb-3" bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Cost Per Lead</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{number_format((float)($costperlead) , 2)}}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 " bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">Cost Per Delivered Order</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="{{number_format((float)($costperdelivered) , 2)}}" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                    <div class="col-md-3 " bis_skin_checked="1">
                                        <label class="form-label" for="validationCustom01">ROI</label>
                                        <input class="form-control" id="validationCustom01" type="text" value="" required="" data-bs-original-title="" title="" disabled>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 ">
                    <div class="card">
                        <div class="row m-4 d-flex align-items-center justify-content-between">
                            <h4>Confirmation Data</h4>
                            <form class=" align-items-center">
                                <div class="row">
                                    <div class="col-lg-3 col-md-10 mt-2">
                                        <div class="dl">
                                            <div class="col-12 align-self-center">
                                                <label class="text-dark" for="date" style="margin-bottom: 5px;">Date Range</label>
                                                <div class='input-group '>
                                                    <input type='text' class="form-control dated"
                                                        name="date_call" value="{{ $date_1_call }} - {{ $date_2_call }}" id="flatpickr-range"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" col-lg-3 col-md-10 mt-2">
                                        <div class="dl w-100">
                                            <label class="text-dark" for="product" style="margin-bottom: 5px;">Select Product</label>
                                            <select class="form-control select2" name="call_product" id="call_product_select">
                                                <option value="" selected>Select Product</option>
                                                @foreach ($products as $v_product)
                                                    <option value="{{ $v_product->id }}"
                                                        {{ $v_product->id == request()->input('call_product') ? 'selected' : '' }}>
                                                        {{ $v_product->name }} / {{ $v_product->sku }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-10 mt-2">
                                        <div class="dl w-100">
                                            <label class="text-dark" for="agent" style="margin-bottom: 5px;">Select Agent Confirmation</label>
                                            <select class="form-control select2" name="call_agents">
                                                <option value=" " selected>Select Agent Confirmation</option>
                                                @foreach ($agents as $v_agent)
                                                    <option value="{{ $v_agent->id }}"
                                                        {{ $v_agent->id == request()->input('call_agents') ? 'selected' : '' }}>
                                                        {{ $v_agent->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class=" col-lg-3 col-md-10 " style="margin-top: 33px;">
                                        <div class="align-items-center">
                                            <div class="dl">
                                                <button class="btn btn-primary input-group-append w-100"
                                                    type="submit">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Cards with few info -->
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Leads</small>
                                <h5 class="mb-0 me-2">{{ $total }}</h5>
                               
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-primary rounded-pill p-2">
                                    <iconify-icon icon="uil:box" class="fs-7 text-secondary text-white"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">New leads</small>
                                <h5 class="mb-0 me-2">{{ $new }}</h5>
                               
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-warning rounded-pill p-2">
                                    <iconify-icon icon="uil:shopping-cart-alt" class="fs-7 text-secondary text-white"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                           
                                <small  style="color: #aaa8a8;">Leads confirmed</small>
                                <h5 class="mb-0 me-2">{{ $confirmed }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-success rounded-pill p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class=" icon icon-tabler icon-tabler-location-up" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 18l-2 -4l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5l-3.251 9.003" />
                                        <path d="M19 22v-6" />
                                        <path d="M22 19l-3 -3l-3 3" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Leads canceled</small>
                                <h5 class="mb-0 me-2">{{ $rejected }}</h5>
                               
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-danger rounded-pill p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class=" icon icon-tabler icon-tabler-device-ipad-cancel" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12.5 21h-6.5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v7" />
                                        <path d="M9 18h3" />
                                        <path d="M19 19m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                        <path d="M17 21l4 -4" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                             
                                <small  style="color: #aaa8a8;">Leads canceled by system</small>
                                <h5 class="mb-0 me-2">{{ $canceledbysysteme }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-danger rounded-pill p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class=" icon icon-tabler icon-tabler-device-desktop-cancel" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12.5 16h-8.5a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v7.5" />
                                        <path d="M7 20h5" />
                                        <path d="M9 16v4" />
                                        <path d="M19 19m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                        <path d="M17 21l4 -4" />
                                    </svg>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Cards with few info -->
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Leads duplicated</small>
                                <h5 class="mb-0 me-2">{{ $duplicated }}</h5>
                              
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-primary rounded-pill p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-copy-off"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M19.414 19.415a2 2 0 0 1 -1.414 .585h-8a2 2 0 0 1 -2 -2v-8c0 -.554 .225 -1.055 .589 -1.417m3.411 -.583h6a2 2 0 0 1 2 2v6" />
                                        <path
                                            d="M16 8v-2a2 2 0 0 0 -2 -2h-6m-3.418 .59c-.36 .36 -.582 .86 -.582 1.41v8a2 2 0 0 0 2 2h2" />
                                        <path d="M3 3l18 18" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Leads out of stock</small>
                                <h5 class="mb-0 me-2">{{ $outofstock }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-success rounded-pill p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-zoom-out-area" width="20" height="20"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M13 15h4" />
                                        <path d="M15 15m-5 0a5 5 0 1 0 10 0a5 5 0 1 0 -10 0" />
                                        <path d="M22 22l-3 -3" />
                                        <path d="M6 18h-1a2 2 0 0 1 -2 -2v-1" />
                                        <path d="M3 11v-1" />
                                        <path d="M3 6v-1a2 2 0 0 1 2 -2h1" />
                                        <path d="M10 3h1" />
                                        <path d="M15 3h1a2 2 0 0 1 2 2v1" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Wrong Leads</small>
                                <h5 class="mb-0 me-2">{{ $wrong }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-danger rounded-pill p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class=" icon icon-tabler icon-tabler-address-book-off" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M8 4h10a2 2 0 0 1 2 2v10m-.57 3.399c-.363 .37 -.87 .601 -1.43 .601h-10a2 2 0 0 1 -2 -2v-12" />
                                        <path d="M10 16h6" />
                                        <path d="M11 11a2 2 0 0 0 2 2m2 -2a2 2 0 0 0 -2 -2" />
                                        <path d="M4 8h3" />
                                        <path d="M4 12h3" />
                                        <path d="M4 16h3" />
                                        <path d="M3 3l18 18" />
                                    </svg>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Leads no answer</small>
                                <h5 class="mb-0 me-2">{{ $noanswer }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-warning rounded-pill p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class=" icon icon-tabler icon-tabler-phone-off" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 21l18 -18" />
                                        <path
                                            d="M5.831 14.161a15.946 15.946 0 0 1 -2.831 -8.161a2 2 0 0 1 2 -2h4l2 5l-2.5 1.5c.108 .22 .223 .435 .345 .645m1.751 2.277c.843 .84 1.822 1.544 2.904 2.078l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a15.963 15.963 0 0 1 -10.344 -4.657" />
                                    </svg>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Leads call later</small>
                                <h5 class="mb-0 me-2">{{ $call }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-warning rounded-pill p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class=" icon icon-tabler icon-tabler-device-landline-phone" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M20 3h-2a2 2 0 0 0 -2 2v14a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-14a2 2 0 0 0 -2 -2z" />
                                        <path d="M16 4h-11a3 3 0 0 0 -3 3v10a3 3 0 0 0 3 3h11" />
                                        <path d="M12 8h-6v3h6z" />
                                        <path d="M12 14v.01" />
                                        <path d="M9 14v.01" />
                                        <path d="M6 14v.01" />
                                        <path d="M12 17v.01" />
                                        <path d="M9 17v.01" />
                                        <path d="M6 17v.01" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Leads out of area</small>
                                <h5 class="mb-0 me-2">{{ $area }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-warning rounded-pill p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class=" icon icon-tabler icon-tabler-zoom-out-area" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M13 15h4" />
                                        <path d="M15 15m-5 0a5 5 0 1 0 10 0a5 5 0 1 0 -10 0" />
                                        <path d="M22 22l-3 -3" />
                                        <path d="M6 18h-1a2 2 0 0 1 -2 -2v-1" />
                                        <path d="M3 11v-1" />
                                        <path d="M3 6v-1a2 2 0 0 1 2 -2h1" />
                                        <path d="M10 3h1" />
                                        <path d="M15 3h1a2 2 0 0 1 2 2v1" />
                                    </svg>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Blacklisted Leads</small>
                                <h5 class="mb-0 me-2">{{ $blacklist }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-black rounded-pill p-2">
                                    <iconify-icon icon="tabler:device-mobile-cancel" class="fs-7 text-secondary text-white"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card table-responsive rounded-1 mb-4" >
                    <table class="table text-nowrap customize-table  align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>Agent</th>
                                <th>Status Before confirmation</th>
                                <th>Quantity Confirmed</th>
                                <th>Quantity Delivered</th>
                                <th>Revenue</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agents as $v_agent)
                            <tr>
                                <td>{{ $v_agent->name}}</td>
                                <td>
                                    <?php
                                        $confirmed = $v_agent->LeadConfirmed($v_agent->id,$date_1_call , $date_2_call);
                                        $canceled = $v_agent->LeadCancelled($v_agent->id,$date_1_call , $date_2_call);
                                        $noanswer = $v_agent->LeadNoAnswer($v_agent->id,$date_1_call , $date_2_call);
                                        $calllater = $v_agent->LeadCalllater($v_agent->id,$date_1_call , $date_2_call);
                                        $wrong = $v_agent->Leadwrong($v_agent->id,$date_1_call , $date_2_call);
                                        $tot = $confirmed + $canceled  + $noanswer + $calllater + $wrong;
                                        $confirmationquantity = $v_agent->QuanityConfirmed($v_agent->id,$date_1_call , $date_2_call);
                                    ?>
                                    @if($confirmed != 0)
                                    <span class="badge bg-success"> confirmed : {{$confirmed}} - {{ number_format(($confirmed / $tot ) * 100, 2) }} %</span><br>
                                    @endif
                                    @if($canceled != 0)
                                    <span class="badge bg-danger mt-1"> Cancelled : {{$canceled}} - {{ number_format(($canceled / $tot ) * 100 , 2) }} %</span><br>
                                    @endif
                                    @if($noanswer != 0)
                                    <span class="badge bg-warning mt-1"> No Answer : {{$noanswer}} - {{ number_format(($noanswer / $tot ) * 100 , 2) }} %</span><br>
                                    @endif
                                    @if($calllater != 0)
                                    <span class="badge bg-warning mt-1"> Call Later : {{$calllater}} - {{ number_format(($calllater / $tot ) * 100 , 2) }} %</span><br>
                                    @endif
                                    @if($wrong != 0)
                                    <span class="badge bg-danger mt-1"> Wrong : {{$wrong}} - {{ number_format(($wrong / $tot ) * 100 , 1) }} $</span><br>
                                    @endif
                                </td>
                                <td>
                                    @if($confirmationquantity)
                                    <?php $check = $v_agent->QuanityConfirmed($v_agent->id,$date_1_call , $date_2_call); ?>
                                        @foreach($check as $key => $v_check)
                                            @if($v_check)
                                            <span class="badge bg-success mt-1">Quantity : {{$v_check['quantity']. '- Count :' .$v_check['count']}}</span><br>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if($v_agent->QuanityDelivered($v_agent->id,$date_1_call , $date_2_call))
                                    <?php $check = $v_agent->QuanityDelivered($v_agent->id,$date_1_call , $date_2_call); ?>
                                        @foreach($check as $key => $v_check)
                                            @if($v_check)
                                            <span class="badge bg-success mt-1">Quantity : {{$v_check['quantity']. '- Count :' .$v_check['count']}}</span><br>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $v_agent->Revenue($v_agent->id,$date_1_call , $date_2_call) }} {{ $countri->currency }}</td>
                                <td>
                                    <a class="btn btn-sm btn-info view-instance" href="{{ route('agents.details','id_agent='.$v_agent->id.'&date1='.$date_1_call.'&date2='.$date_2_call)}}" target="_blank"><span class="ti ti-eye"></span></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-6 ">
                    <div class="card">
                        <div class="row">
                            <div class="row m-4 d-flex align-items-center justify-content-between">
                                <h4  style="color: #0c1336; font-weight: 800;">Call center overivew</h4>
                            </div>
                            <!-- Polar Area Chart -->
                            <div class="card-body">
                                <div id="donutCharts"></div>
                            </div>
                            <!-- /Polar Area Chart -->
                        </div>
                    </div>
                </div>
                <div class="col-6 ">
                    <div class="card">
                        <div class="row">
                            <div class="row m-4 d-flex align-items-center justify-content-between">
                                <h4 style="color: #0c1336; font-weight: 800;">Call center overivew</h4>
                            </div>
                            <!-- Polar Area Chart -->
                            <div class="card-body">
                                <div id="donutChartt"></div>
                            </div>
                            <!-- /Polar Area Chart -->
                        </div>
                    </div>
                </div>

                <!--- shipping -->

                <div class="col-12 ">
                    <div class="card">
                        <div class="row m-4 d-flex align-items-center justify-content-between">
                            <h4>Shipping Data</h4>
                            <form class=" align-items-center">
                                <div class="row">
                                    <div class="col-lg-3 col-md-10">
                                        <label class="text-dark" for="date" style="margin-bottom: 5px;">Date Range</label>
                                        <div class="dl">
                                            <div class="col-12 align-self-center">
                                                <div class='input-group '>
                                                    <input type="text" class="form-control dated" name="date_shipped" value="{{ request()->input('date_shipped') }}"id="flatpickr-ranges"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-lg-3 col-md-10">
                                        <div class="dl w-100">
                                            <label class="text-dark" for="product" style="margin-bottom: 5px;">Select Product</label>
                                            <select class="form-control select2" name="shipped_product">
                                                <option value="" selected>Select Product</option>
                                                @foreach ($products as $v_product)
                                                    <option value="{{ $v_product->id }}"
                                                        {{ $v_product->id == request()->input('shipped_product') ? 'selected' : '' }}>
                                                        {{ $v_product->name }}  / {{ $v_product->sku }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-10">
                                        <div class="dl w-100">
                                            <label class="text-dark" for="agent" style="margin-bottom: 5px;">Select Agent Last Mille</label>
                                            <select class="form-control select2" name="shipped_lastmille">
                                                <option value=" " selected>Select Agent Last Mille</option>
                                                @foreach ($companys as $v_companys)
                                                    <option value="{{ $v_companys->id }}"
                                                        {{ $v_companys->id == request()->input('shipped_lastmille') ? 'selected' : '' }}>
                                                        {{ $v_companys->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row col-lg-3 col-md-10">
                                        <div class="align-items-center">
                                            <div class="dl">
                                                <button class="btn btn-primary input-group-append w-100"
                                                    type="submit">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Cards with few info -->
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Orders</small>
                                <h5 class="mb-0 me-2">{{ $orders }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-primary rounded-pill p-2">
                                    <iconify-icon icon="uil:shopping-cart-alt" class="fs-7 text-secondary text-white"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Unpacked Orders </small>
                                <h5 class="mb-0 me-2">{{ $chartunpacked }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-warning rounded-pill p-2">
                                    <iconify-icon icon="tabler:location" class="fs-7 text-secondary text-white"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Picking Proccess Orders </small>
                                <h5 class="mb-0 me-2">{{ $chartpicking }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-warning rounded-pill p-2">
                                    <iconify-icon icon="tabler:packages" class="fs-7 text-secondary text-white"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Packed Orders </small>
                                <h5 class="mb-0 me-2">{{ $chartpacked }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-warning rounded-pill p-2">
                                    <iconify-icon icon="tabler:shopping-cart-share" class="fs-7 text-secondary text-white"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Shipped Orders </small>
                                <h5 class="mb-0 me-2">{{ $chartshipped }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-success rounded-pill p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cube-send"
                                        width="28" height="28" viewBox="0 0 28 28" stroke-width="1.5"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M16 12.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                                        <path d="M11 9.5v5.5l5 3" />
                                        <path d="M16 12.545l5 -3.03" />
                                        <path d="M7 9h-5" />
                                        <path d="M7 12h-3" />
                                        <path d="M7 15h-1" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Orders in transit</small>
                                <h5 class="mb-0 me-2">{{ $charttransit }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-success rounded-pill p-2">
                                    <iconify-icon icon="tabler:trolley" class="fs-7 text-secondary text-white"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Orders in delivery</small>
                                <h5 class="mb-0 me-2">{{ $chartindelivery }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-success rounded-pill p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-truck-delivery" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                                        <path d="M3 9l4 0" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Incident Orders </small>
                                <h5 class="mb-0 me-2">{{ $chartincident }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-warning rounded-pill p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-road-off"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 19l3.332 -11.661" />
                                        <path d="M16 5l2.806 9.823" />
                                        <path d="M12 8v-2" />
                                        <path d="M12 13v-1" />
                                        <path d="M12 18v-2" />
                                        <path d="M3 3l18 18" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Delivered Orders </small>
                                <h5 class="mb-0 me-2">{{ $chartdelivered }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-success rounded-pill p-2">
                                    <iconify-icon icon="solar:delivery-broken" class="moon fs-6"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cards with few info -->
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Rejected Orders </small>
                                <h5 class="mb-0 me-2">{{ $chartcanceled }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-warning rounded-pill p-2">
                                    <i class="ti ti-alert-octagon ti-sm"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mb-4">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="card-title mb-0">
                                <small  style="color: #aaa8a8;">Returned Orders </small>
                                <h5 class="mb-0 me-2">{{ $chartreturned }}</h5>
                            </div>
                            <div class="card-icon">
                                <span class="badge bg-danger rounded-pill p-2">
                                    <iconify-icon icon="tabler:rotate" class="fs-7 text-secondary text-white"></iconify-icon>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="row">
                            <div class="row m-4 d-flex align-items-center justify-content-between">
                                <h4 style="color: #0c1336; font-weight: 800;">Shipping Overivew</h4>
                            </div>
                            <!-- Polar Area Chart -->
                                <div class="card-body">
                                    <div id="polarChartt"></div>
                                </div>
                            <!-- /Polar Area Chart -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="row">
                            <div class="row m-4 d-flex align-items-center justify-content-between">
                                <h4 style="color: #0c1336; font-weight: 800;">Shipping Overivew</h4>
                            </div>
                            <!-- Radar Chart -->
                                <div class="">
                                    <div class="card-body">
                                        <div id="polarCharts"></div>
                                    </div>
                                </div>
                            <!-- /Radar Chart -->
                        </div>
                    </div>
                </div>


                <div class="row mt-4">
                    <div class="col-sm-12 col-lg-4">
                        <div class="card new-card">
                            <div class="card-body">
                                <!-- title -->
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <span style="font-weight: 700;">QTE IN WEARHOUSE</span>
                                    </div>
                                </div>
                                <!-- title -->
                                <div class="table-responsive scrollable mt-2" style="height:400px;">
                                    <table class="table v-middle">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Products</th>
                                                <th class="border-top-0">Name</th>
                                                <th class="border-top-0">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($quantity_stock as $v_stock)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @foreach ($v_stock['products'] as $v_product)
                                                                <div class="mr-2"><img src="{{ $v_product->image }}"
                                                                        alt="user" class="rounded-circle"
                                                                        width="45" /></div>
                                                                    </td> <div class="">
                                                                    <td
                                                                        class="mb-0 font-medium">{{ $v_product->name }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td class="text-center">{{ $v_stock->qunatity }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">
                                                        <img src="{{ asset('public/Empty-amico.svg') }}" class="img-fluid"
                                                            width="300" style="margin: 0 auto; display: block;">
                                                        <p class="mt-3 text-muted">No products found.</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="card new-card">
                            <div class="card-body">
                                <!-- title -->
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <span class="card-title" style="font-weight: 800;">LOW STOCK PRODUCTS</span>
                                    </div>
                                </div>
                                <!-- title -->
                                <div class="table-responsive scrollable mt-2" style="height:400px;">
                                    <table class="table v-middle">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Products</th>
                                                <th class="border-top-0">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $filteredProducts = $low_stock_product->filter(function($v_product) {
                                                return $v_product->quantity != 0 && $v_product->low_stock > $v_product->quantity;
                                            });
                                        @endphp
                                        
                                        @if ($filteredProducts->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <img src="{{ asset('public/Empty-amico.svg') }}" class="img-fluid"
                                                        width="300" style="margin: 0 auto; display: block;">
                                                    <p class="mt-3 text-muted">No products found.</p>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($filteredProducts as $v_product)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="mr-2">
                                                                <img src="{{ $v_product->image }}" alt="user"
                                                                    class="rounded-circle" width="45" />
                                                            </div>
                                                            <div>
                                                                <span class="mb-0 font-medium">{{ $v_product->name }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $v_product->quantity }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="card new-card">
                            <div class="card-body">
                                <!-- title -->
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <span class="card-title" style="font-weight: 800;">OUT OF STOCK</span>
                                    </div>
                                </div>
                                <!-- title -->
                                <div class="table-responsive scrollable mt-2" style="height:400px;">
                                    <table class="table v-middle">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Products</th>
                                                <th class="border-top-0">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $outOfStockProducts = $import_product->filter(function($v_product) {
                                                return $v_product->quantity == 0;
                                            });
                                        @endphp
                                        
                                        @if ($outOfStockProducts->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <img src="{{ asset('public/Empty-amico.svg') }}" class="img-fluid"
                                                        width="300" style="margin: 0 auto; display: block;">
                                                    <p class="mt-3 text-muted">No products out of stock found.</p>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($outOfStockProducts as $v_product)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="mr-2">
                                                                <img src="{{ $v_product->image }}" alt="user" class="rounded-circle" width="45" />
                                                            </div>
                                                            <div class="mx-2">
                                                                <span class="mb-0 font-medium">{{ $v_product->name }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $v_product->quantity }}</td>
                                                </tr>
                                            @endforeach
                                        @endif                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@section('script')
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <!-- endbuild -->


    </script>


    <script>
        $('input[name="profit_date"]').daterangepicker();
        $('input[name="date_call"]').daterangepicker();
        $('input[name="date_shipped"]').daterangepicker();
    </script>


        <script>
 var options_donut = {
    series: [{{ $chartnew }}, {{ $chartconfirmed }}, {{ $chartnoanswer }}, {{ $chartcall }},
                        {{ $chartrejected }}, {{ $chartduplicated }}, {{ $chartwrong }}, {{ $chartarea }},
                        {{ $chartcanceledbysestem }}],
    chart: {
      fontFamily: "inherit",
      type: "donut",
      width: 510,
    },labels: ['New Order', 'Confirmed', 'No Answer', 'Call Later', 'Canceled', 'Duplicated',
                        'Wrong', 'Out Of Area', 'Canceled By System','Black Listed'
                    ],
    colors: [
        "#222d6f", "#29dac7" , "#f9c20a", "#f87a0c" , "#ff0000", '#d9abda', '#7e7e7e' , '#ff6693', "#ff0000"  
    ],
    responsive: [
      {
        breakpoint: 480,
        options: {
          chart: {
            width: 200,
          },
          legend: {
            position: "bottom",
          },
        },
      },
    ],
    legend: {
      labels: {
       colors:  "#a1aab2",
      },
    },
  };

  var chart_pie_donut = new ApexCharts(
    document.querySelector("#donutCharts"),
    options_donut
  );
  chart_pie_donut.render();
        </script>
        
        <script>

        'use strict';

        (function() {
           


            // Donut Chart
            // --------------------------------------------------------------------

            var options_donut = {
                labels: ['Delivered', 'Returned'],
                series: [{{ $chartdelivered }}, {{ $chartreturned }}],
                chart: {
                fontFamily: "inherit",
                type: "donut",
                width: 470,
                },
                colors: [
                "#29dac7",
                "#ff0000",
                ],
                responsive: [
                {
                    breakpoint: 480,
                    options: {
                    chart: {
                        width: 200,
                    },
                    legend: {
                        position: "bottom",
                    },
                    },
                },
                ],
                legend: {
                labels: {
                colors:  "#a1aab2",
                },
                },
            };

            var chart_pie_donut = new ApexCharts(
                document.querySelector("#polarCharts"),
                options_donut
            );
            chart_pie_donut.render();
        })();
    </script>
    <script>
        /**
         * Charts Apex
         */

        'use strict';

        (function() {
            let cardColor, headingColor, labelColor, borderColor, legendColor;

            


            // Donut Chart
            // --------------------------------------------------------------------
            var options_donut = {
                labels: ['Unpacked', 'Picking Proccess', 'Item Packed', 'shipped', 'Proseccing', 'In Transit',
                        'In Delivery', 'Incident', 'Delivered', 'Rejected', 'Returned', 'Black Listed'
                    ],
                series: [{{ $chartunpacked }}, {{ $chartpicking }}, {{ $chartpacked }}, {{ $chartshipped }},
                        {{ $chartproseccing }}, {{ $charttransit }}, {{ $chartindelivery }},
                        {{ $chartincident }}, {{ $chartdelivered }}, {{ $chartcanceled }}, {{ $chartreturned }},
                        {{ $chartblackList }}
                    ],
                chart: {
                fontFamily: "inherit",
                type: "donut",
                width: 510,
                },
                colors: [
                    "#222d6f" , "#f9c20a", "#39c0e5", "#f87a0c" , "#834f22", '#d9abda', '#7e7e7e' , '#ff6693', "#29dac7", "#ff0000", "#ff0000", "#ff0000"
                ],
                responsive: [
                {
                    breakpoint: 480,
                    options: {
                    chart: {
                        width: 510,
                    },
                    legend: {
                        position: "bottom",
                    },
                    },
                },
                ],
                legend: {
                labels: {
                colors:  "#a1aab2",
                },
                },
            };

            var chart_pie_donut = new ApexCharts(
                document.querySelector("#polarChartt"),
                options_donut
            );
            chart_pie_donut.render();
        })();
    </script>
    <script>
        /**
         * Charts Apex
         */

            // user chart
            var options1 = {
            series: [{{ $chartconfirmed }}, {{ $chartrejected }}],
            chart: {
                type: 'donut',
                height: 330,
            },labels: ['Confirmed', 'Canceled'],
            dataLabels:{
                enabled: false
            },
            legend:{
                show: false
            },
            responsive: [{
                breakpoint: 480,
                options: {
                chart: {
                    width: 200
                },
                },
                breakpoint: 360,
                options: {
                chart: {
                    height: 280
                },
                }
            }],
            plotOptions: {
                pie: {
                donut: {
                    size: '70%'
                }
                }
            }, 
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return val  ;
                    },
                },          
            },
            colors:[ "#29dac7" , "#ff0000"],
            };
            var chart1 = new ApexCharts(document.querySelector("#donutChartt"), options1);
            chart1.render();
    </script>
    <script>
        /**
         * Charts Apex
         */

        'use strict';

        // $(document).ready(function() {
        //     $('.select2').select2({
        //         placeholder: 'Select  Product',
        //         allowClear: true
        //     });

        // });
    </script>
@endsection
@endsection
