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
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-8 align-self-center text-right">
                        <h4 class="fw-bold py-3 mb-0 " style="display: -webkit-inline-box;"><span
                                class="text-muted fw-light">Dashboard /</span> Speends &nbsp;
                            
                        </h4>
                    </div>
                    <div class="col-4 d-flex justify-content-end">
                        <div class="form-group mb-0 text-end">
                            <button type="button" class="btn btn-primary btn-rounded my-1" data-bs-toggle="modal" data-bs-target="#add-contact">Add New Detail</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Product Popup Model -->
            <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  style="height:900px;">
                <div class="modal-dialog" style="height:900px;">
                    <div class="modal-content">
                        <form action="{{ route('speends.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Add New pack</h4>
                                
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12 my-2">
                                            <input type="text" class="form-control" name="amount_speend" id="amount_speend" placeholder="Speend" required>
                                        </div>
                                    </div>
                                    <input type="hidden" name="chaneel_product"  value="{{$id}}" />
                                    <div class="row">
                                        <div class="col-md-12 my-2">
                                            <input type="date" class="form-control" name="date_speend" id="date_speend" placeholder="date" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 my-2">
                                            <textarea type="text" class="form-control" name="note_speend" id="note_speend"
                                                placeholder="Note" required></textarea>
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
           
            <div id="overlay" style="display:none;">
                <div class="spinner"></div>
                <br />
                Loading...
            </div>
            <!-- Bordered Table -->
            <div class="card">
                <div class="card-body">
                    <div class="form-group-1">
                        <form>
                            <div class="row">
                                <div class="col-md-5 col-sm-10">
                                    <div class='theme-form mb-3'>
                                        <input type="text" class="form-control flatpickr-input" name="date"
                                            value="{{ request()->input('date') }}" id="datepicker-range" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-10">
                                    <div class="input-group">
                                        <input type="text" class="form-control dated" name="search"
                                            placeholder="Note" aria-label=""
                                            aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                            <button class="btn btn-primary w-100" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--/ Bordered Table -->

            <div class="col-xl-12 col-lg-12 col-md-12 box-col-12">
                <div class="card order-card">
                  <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                      <div class="flex-grow-1">
                        <p class="square-after f-w-600">Our Total Sold<i class="fa fa-circle"></i></p>
                      </div>
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
                    <div class="table-responsive theme-scrollbar">
                      <table class="table table-bordernone">
                        <thead>
                          <tr>
                            <th>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="selectall custom-control-input"
                                        id="chkCheckAll" required>
                                    <label class="custom-control-label" for="chkCheckAll"></label>
                                </div>
                            </th>                           
                            <th>Amount Speend</th>
                            <th>Date</th>
                            <th>Note</th>
                            <th>Created at</th>
                          </tr>
                        </thead>
                        @if(!$speends->isempty())
                            <tbody>
                                <?php $counter = 1; ?>
                                @foreach ($speends as $v_speend)
                                    <tr>
                                        <td>
                                            <div class="custom-control custom-checkbox editProduct">
                                                <input type="checkbox" name="ids"
                                                    class="custom-control-input checkBoxClass"
                                                    value="{{ $v_speend->id }}" id="pid-{{ $counter }}">
                                                <label class="custom-control-label"
                                                    for="pid-{{ $counter }}"></label>
                                            </div>
                                        </td>
                                        <td>{{ $v_speend->amount }}</td>
                                        <td>
                                            <span class="badge bg-warning"> {{ $v_speend->date }}</span>
                                        </td>
                                        <td>{{ Str::limit($v_speend->note, 30) }}</td>
                                        <td>{{ $v_speend->created_at }}</td>
                                    </tr>
                                    <?php $counter++; ?>
                                @endforeach
                            </tbody>
                        @else
                            <tbody>
                                <tr><td colspan="7"><img src="{{ asset('public/Empty-amico.png')}}" class="img-fluid mb-n7 mt-2" width=400 style="margin-left: auto;margin-right: auto;display:flex"/></td></tr>
                            </tbody>
                        @endif
                      </table>
                        {{ $speends->withQueryString()->links('vendor.pagination.courier') }}
                    </div>
                    <div class="code-box-copy">
                      <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#total-sold"><i class="icofont icofont-copy-alt"></i></button>
                      
                    </div>
                  </div>
                </div>
              </div>

        </div>
        <!-- / Content -->


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
                                    placeholder="Product Image">
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
