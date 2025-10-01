@extends('backend.layouts.app')
@section('content')

        <!-- ============================================================== -->


        <div class="card card-body py-3">
            <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                <h4 class="mb-4 mb-sm-0 card-title">Upsells</h4>
                <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item d-flex align-items-center">
                        <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light configupsel" data-id="{{ $product->id}}" id="configupsel">Add New Upsell</button>
                    </li>
                    </ol>
                </nav>
                </div>
            </div>
            </div>
        </div>
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-xxl flex-grow-1 container-p-y">
                {{-- <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-5 align-self-center">
                            <h4 class="page-title">Upsells</h4>
                            <div class="d-flex align-items-center">
                            </div>
                        </div>
                        <div class="col-7 align-self-center">
                            <div class="form-group mb-0 text-right">
                                <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light configupsel" data-id="{{ $product->id}}" id="configupsel">Add New Product</button>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="filter" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Search</h4> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <from class="form-horizontal form-material">
                                                    <div class="form-group">
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <input type="text" class="form-control" placeholder="Store Name"> </div>
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <input type="text" class="form-control" placeholder="Link"> </div>
                                                    </div>
                                                </from>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Search</button>
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div class="table-responsive border rounded-1" style="margin-top:-20px">
                                    <table class="table text-nowrap customize-table mb-0 align-middle">
                                        <thead class="text-dark fs-4">
                                            <tr>
                                                <th>No</th>
                                                <th>Products</th>
                                                <th>Quantity</th>
                                                <th>Discount</th>
                                                <th>Note</th>
                                                <th>Created at</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$upsells->isempty())
                                                @foreach($upsells as $v_upsel)
                                                    @if(!$v_upsel['upselles']->isempty())
                                                        @foreach($v_upsel['upselles'] as $v_app)
                                                        <tr>
                                                            <td>1</td>
                                                            <td>{{ $v_upsel->name}}</td>
                                                            <td>{{ $v_app->quantity}}</td>
                                                            <td>{{ $v_app->discount}}</td>
                                                            <td>{{ $v_app->note}}</td>
                                                            <td>{{$v_app->created_at}}</td>
                                                        </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="12">
                                                                <div class="col-12">
                                                                    <img src="{{ asset('public/Empty-amico.svg') }}"
                                                                        style="margin-left: auto ; margin-right: auto; display: block;"
                                                                        width="500" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="12">
                                                        <div class="col-12">
                                                            <img src="{{ asset('public/Empty-amico.svg') }}"
                                                                style="margin-left: auto ; margin-right: auto; display: block;"
                                                                width="500" />
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
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
            <!-- ============================================================== -->
        </div>
                                <div id="config_upsel" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Config Upsell</h4> 
                                                
                                            </div>
                                                <form class="form-horizontal form-material" enctype="multipart/form-data" novalidate="novalidate">
                                                
                                            <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <input type="text" class="form-control" name="upsel_quantity" id="upsel_quantity" placeholder="Quantity">
                                                            <input type="hidden" class="form-control" name="upsel_product_id" id="upsel_product_id" placeholder="Product Name">
                                                        </div>
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <input type="text" class="form-control" name="discount" id="discount" placeholder="Discount"> </div>
                                                        <div class="col-md-12 m-b-20 mt-4">
                                                            <input type="text" class="form-control" name="note" id="note" placeholder="Note"> </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary waves-effect" id="config">Save</button>
                                                <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                                </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
    
    $(function(e){
        $('#config').click(function(e){
            var product = $('#upsel_product_id').val();
            var quantity = $('#upsel_quantity').val();
            var discount = $('#discount').val();
            var note = $('#note').val();
            $.ajax({
                type : 'POST',
                url:'{{ route('products.upsel')}}',
                cache: false,
                data:{
                    product: product,
                    quantity: quantity,
                    discount: discount,
                    note: note,
                    _token : '{{ csrf_token() }}'
                },
                success:function(response){
                    if(response.success == true){
                        toastr.success('Good Job Product.', 'Upsell Has been Addess Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                    }
                    location.reload();
            }});
        });
    });
    
    $(function(e){
        $('#deleteupsel').click(function(e){
            var id = $(this).data('id');
            $.ajax({
                type : 'POST',
                url:'{{ route('products.deleteupsells')}}',
                cache: false,
                data:{
                    id: id,
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
    $(function () {
        $('body').on('click', '.configupsel', function () {
        var product_id = $(this).data('id');
        //console.log(product_id);
                $('#config_upsel').modal('show');
                $('#upsel_product_id').val(product_id);
            
        });
    });
    $(function () {
        $('body').on('click', '.editProduct', function () {
        var product_id = $(this).data('id');
        //console.log(product_id);
            $.get("{{ route('products.index') }}" +'/' + product_id +'/upsells/edit', function (data) {
                //console.log(product_id);
                $('#config_upsel').modal('show');
                $('#upsel_id').val(data.id);
                $('#upsel_quantity').val(data.quantity);
                $('#upsel_discount').val(data.discount);
                $('#upsel_note').val(data.note);
            });
        });
    });
</script>
@endsection