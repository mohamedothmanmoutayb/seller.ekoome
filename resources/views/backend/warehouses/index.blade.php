@extends('backend.layouts.app')
@section('content')
    <style>
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
            animation: rotate 0.8s infinite linear;
            border: 5px solid firebrick;
            border-right-color: transparent;
            border-radius: 50%;
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
                        <h4 class="mb-4 mb-sm-0 card-title">Warehouses</h4>
                        <p class="mb-0 text-muted"> Manage storage locations and product stock.</p>
                                    
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

            <ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row">
                <li class="nav-item">
                <a href="javascript:void(0)" onclick="toggleText()" class="nav-link gap-6 note-link d-flex align-items-center justify-content-center px-3 px-md-3 me-0 me-md-2 fs-11 active" id="all-category">
                    <i class="ti ti-list fill-white"></i>
                    <span class="d-none d-md-block fw-medium">Filter</span>
                </a>
                </li>
                <li class="nav-item ms-auto">
                    <button type="button" class="btn btn-primary btn-rounded my-1" data-bs-toggle="modal" data-bs-target="#add-warehouse">+ Add New Warehouse</button>
                </li>
                <div class="col-12 form-group multi mt-2" id="multi" >
                    <div class="form-group-1">
                        <form>
                            <div class="row">
                                <div class="col-md-10 col-sm-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search"
                                            placeholder="Search by SKU, Warehouse Name, or Product" aria-label=""
                                            aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                            <button class="btn btn-primary w-100" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="form-group ">
                        <form>
                            <div class="row">
                                <div class="col-md-5 col-sm-12 mt-4">
                                    <label for="Sku" style="margin-left: 8px; margin-bottom: 5px;">SKU Code</label>
                                    <input type="text" class="form-control" name="sku" placeholder="SKU">
                                </div>
                                <div class="col-md-2 col-sm-12 mt-5">
                                    <button type="submit" class="btn btn-primary waves-effect"
                                        style="width:100%">Advanced Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </ul>
            <!-- Add Product Popup Model -->
            <div id="add-warehouse" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  style="height:1200px;">
                <div class="modal-dialog" style="max-width: 900px;height:900px;">
                    <div class="modal-content">
                        <form action="{{ route('warehouses.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Add New Warehouse</h4>
                                
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="row">
                                        
                                        <div class="col-md-6 my-2">
                                            <label for="name_warehouse" class="form-label">Warehouse Name</label>
                                            <input type="text" class="form-control" name="name_warehouse" id="name_warehouse" placeholder="Warehouse Name" required>
                                        </div>
                                        <div class="col-md-6 my-2">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" class="form-control" name="city" id="city"
                                                placeholder="city" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 my-2">
                                            <label for="phone" class="form-label">Phone</label>
                                            <input type="text" class="form-control" name="phone"
                                                id="phone" placeholder="Warehouse phone" required>
                                        </div>
                                        <div class="col-md-6 my-2">
                                            <div>
                                                <label for="image_product" class="form-label">Warehouse Image</label>
                                                <input type="file" class="form-control" name="image_product" id="image_product" accept="image/*" onchange="previewImage(event)">
                                                <span id="file-placeholder" class="text-muted position-absolute top-50 translate-middle-y ps-1 mt-3" style="pointer-events: none;">Please upload an image</span>
                                                <div class="mt-2">
                                                    <img id="image_preview" src="#" alt="Image Preview" style="max-height: 150px; display: none;" class="rounded shadow-sm border">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="row">
                                        <div class="col-md-12 my-2">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea type="text" class="form-control" name="address"
                                                id="address" placeholder="Warehouse address" required></textarea>
                                        </div>
                                    </div>
                                      <div class="row">
                                        <div class="col-md-6 my-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck1" name="islastmille">
                                                <label class="custom-" for="customCheck1">is a Last Mille</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect">Save</button>
                                <button type="button" class="btn btn-primary waves-effect"
                                    data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Add Import Popup Model -->
            <div id="add-ex" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  style="height:auto !important;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Add New Stock</h4>
                            
                        </div>
                        <div class="modal-body">
                            <from class="form-horizontal form-material">
                                <div class="form-group">
                                    <div class="col-md-12 my-2">
                                        <input type="number" class="form-control" id="quantity"
                                            placeholder="Quantity">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" id="country"
                                            placeholder="Shipping Country">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="date" class="form-control" id="expidition_date"
                                            placeholder="Date">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" id="expidition_name"
                                            placeholder="Name Transporteur">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" id="expidition_phone"
                                            placeholder="Phone">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" id="nbr_packagin"
                                            placeholder="NBR PACHING">
                                    </div>
                                </div>
                            </from>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary waves-effect" id="existin_product">Save</button>
                            <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
           
            <div id="overlay" style="display:none;">
                <div class="spinner"></div>
                <br />
                Loading...
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 box-col-12">
                <div class="card order-card">
                  <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                     
                      <div class="setting-list">
                        <ul class="list-unstyled setting-option">
                          <li>
                            <div class="setting-light"><i class="icon-layout-grid2"></i></div>
                          </li>
                          <li><i class="view-html fa fa-code font-white"></i></li>
                          <li><i class="icofont icofont-maximize full-card font-white"></i></li>
                          <li><i class="icofont icofont-minus minimize-card font-white"></i></li>
                          <li><i class="icofont icofont-refresh reload-card font-white"></i></li>
                          <li><i class="icofont icofont-error close-card font-white"> </i></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                        @if(!$warehouses->isempty())
                        @foreach ($warehouses as $v_warehouse)
                        <div class="col-sm-4 col-xxl-3">
                            <div class="card overflow-hidden rounded-2 border">
                                <div class="position-relative">
                                    <a href="" class="hover-img d-block overflow-hidden">
                                    <img src="{{$v_warehouse->image}}" class="card-img-top rounded-0" alt="matdash-img" style="max-height: 323px;">
                                    </a>
                                    <div class="dropup  d-inline-flex position-absolute bottom-0 end-0 mb-n4 me-3"  style="bottom: -40px !important;">
                                        <button class="btn text-bg-primary rounded-circle text-white dropdown-toggle show" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="border-color: transparent !importante;"><i class="icon-settings"></i></button>
                                        <div class="dropdown-menu" bis_skin_checked="1" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(184px, -325.203px, 0px);" data-popper-placement="top-start">                          
                                            <a class="dropdown-item" href="{{ route('warehouses.overview', $v_warehouse->id)}}"> Overview</a>
                                            <a class="dropdown-item" href="{{ route('warehouses.cities', $v_warehouse->id)}}"> Cities</a>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-3 p-4">
                                    <h6 class="fw-semibold fs-4">{{ $v_warehouse->name }} - {{ $v_warehouse->city }} </h6>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6 class="fw-semibold fs-4 mb-0"><span class="ms-2 fw-normal text-muted fs-3">Total Products : {{ $v_warehouse->CountProduct($v_warehouse->id)}}</span><br>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="col-12">
                            <img src="{{ asset('public/Empty-amico.svg')}}" style="margin-left: auto ; margin-right: auto; display: block;" width="500" />
                        </div>
                        @endif
                    </div>
                        {{ $warehouses->withQueryString()->links('vendor.pagination.courier') }}
                  </div>
                </div>
            </div>



            <div class="content-backdrop fade"></div>
            <!-- Content wrapper -->
            <div id="edit_product" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Edit Product</h4>
                            
                        </div>
                        <form action="{{ route('products.update') }}" method="POST" class="form-horizontal form-material"
                            enctype="multipart/form-data" novalidate="novalidate">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" name="product_nam" id="product_nam"
                                            placeholder="Product Name">
                                        <input type="hidden" class="form-control" name="product_id" id="product_id"
                                            placeholder="Product Name">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="file" class="form-control" name="product_image" id="product_image"
                                            placeholder="Product Image" required>
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" name="product_link" id="product_link"
                                            placeholder="Link">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" name="product_linkvideo"
                                            id="product_linkvideo" />
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" name="product_price" id="product_price"
                                            placeholder="Price">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" name="product_weight" id="product_weight"
                                            placeholder="weight">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <textarea type="text" class="form-control" name="description_produc" id="description_produc"
                                            placeholder="Description Product"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect">Save</button>
                                <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
@section('script')
    <!-- Page JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
    
        $(function(e){
            $('#existin_product').click(function(e){
                var product = $('#product_name').val();
                var quantity = $('#quantity').val();
                var country = $('#country').val();
                var expidition = $('#expidition_name').val();
                var mode = $('#expidition_mode').val();
                var date = $('#expidition_date').val();
                var phone = $('#expidition_phone').val();
                var packagin = $('#nbr_packagin').val();
                var warehouse = $('#warehouse_send').val();
                $.ajax({
                    type : 'POST',
                    url:'{{ route('products.warehousestore')}}',
                    cache: false,
                    data:{
                        product: product,
                        quantity: quantity,
                        country: country,
                        expidition: expidition,
                        mode: mode,
                        date: date,
                        phone: phone,
                        packagin: packagin,
                        warehouse: warehouse,
                        _token : '{{ csrf_token() }}'
                    },
                    success:function(response){
                        if(response.success == true){
                            toastr.success('Good Job Product.', 'Stock Has been Addess Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                        }
                        location.reload();
                }});
            });
        });
    
        //deleted
    
        $(function(e){
            $('.deleted').on('click', function(e){
                var product = $(this).data('id');
                $.ajax({
                    type : 'POST',
                    url:'{{ route('products.delete')}}',
                    cache: false,
                    data:{
                        id: product,
                        _token : '{{ csrf_token() }}'
                    },
                    success:function(response){
                        if(response.success == true){
                            toastr.success('Good Job Product.', 'Product Has been deleted Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                        location.reload();
                        }
                        if(response.error == false){
                            toastr.error('Good Job Product.', 'You cant deleted product!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                        }
                }});
            });
        });
    
        $(function () {
            $('body').on('click', '.update', function () {
            var product_id = $(this).data('id');
            //console.log(product_id);
                $.get("{{ route('products.index') }}" +'/' + product_id +'/edit', function (data) {
                    //console.log(product_id);
                    $('#edit_product').modal('show');
                    $('#product_id').val(data.id);
                    $('#product_nam').val(data.name);
                    $('#product_link').val(data.link);
                    $('#product_linkvideo').val(data.link_video);
                    $('#product_price').val(data.price);
                    $('#product_weight').val(data.weight);
                    $('#description_produc').val(data.description);
                });
            });
            $('body').on('click','#multi', function(){
                $('.multi').show();
            })
        });
        
         
        $(function () {
            $('body').on('click', '.configupsel', function () {
            var product_id = $(this).data('id');
            //console.log(product_id);
                    $('#config_upsel').modal('show');
                    $('#upsel_product_id').val(product_id);
                
            });
        });
    
    
    
        //Export
        $(function(e){
            $("#chkCheckAll").click(function(){
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });
            $('#exportss').click(function(e){
                e.preventDefault();
                var allids = [];
                $("input:checkbox[name=ids]:checked").each(function(){
                    allids.push($(this).val());
                });
            if(allids != ''){
                $.ajax({
                        type : 'GET',
                        url:'{{ route('products.export')}}',
                        cache: false,
                        data:{
                            ids: allids,
                        },
                        success:function(response,leads){
                            $.each(allids, function(key,val,leads){
                                var a = JSON.stringify(allids);
                                window.location = ('products/export-download/'+a);
                            });
                        }
                    });
            }else{
                toastr.warning('Opss.', 'Please Selected Leads!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
            }
            });
        });
    
    $(document).ready(function() {
      $("#seller_name").select2({
        dropdownParent: $("#add-contac")
      });
    });

    function previewImage(event) {
    const input = event.target;
    const file = input.files[0];
    const preview = document.getElementById('image_preview');
    const placeholder = document.getElementById('file-placeholder');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
        placeholder.style.display = 'none'; // hide placeholder
    } else {
        preview.src = '#';
        preview.style.display = 'none';
        placeholder.style.display = 'block'; // show placeholder
    }
}
    </script>
    @if (session()->has('success'))
    <div class="alert alert-success">
        @if(is_array(session('success')))
            <ul>
                @foreach (session('success') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @else
            {{ session('success') }}
        @endif
    </div>
    @endif
    @if(session()->has('success'))
    <script>
        toastr.success('Good Job Product.', 'Product Has been Addess Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
   
   
    </script>
    @endif
@endsection
@endsection
