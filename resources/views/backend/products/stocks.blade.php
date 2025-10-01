@extends('backend.layouts.app')
@section('content')

                <div class="card card-body py-3">
                    <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-sm-flex align-items-center justify-space-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Stocks</h4>
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
 
            
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-subtitle"></h6>
                                      
                                <div class="table-responsive theme-scrollbar h-200" style="min-height:600px">
                                    <table class="table table-bordernone">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Products</th>
                                                <th>Image</th>
                                                <th>Quantity Sent</th>
                                                <th>Quantity Received</th>
                                                <th>Quantity</th>
                                                <th>Note</th>
                                                <th>Created at</th>
                                                <th>Updated at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            ?>
                                            @foreach($stocks as $v_upsel)
                                            <tr>
                                                <td>{{ $counter}}</td>
                                                <td>{{ $v_upsel->name}}</td>
                                                <td><img src="{{ $v_upsel->image }}" alt="user" class="circle" width="45" /></td>
                                                <td>
                                                    {{ $v_upsel->quantity_sent}}
                                                </td>
                                                <td>
                                                    {{ $v_upsel->quantity_received}}
                                                </td>
                                                <td>
                                                    {{ $v_upsel->quantity}}
                                                </td>
                                                <td>
                                                    {{ $v_upsel->note}}
                                                </td>
                                                <td>{{ $v_upsel->created_at}}</td>
                                                <td>{{ $v_upsel->updated_at}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ti ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu animated slideInUp" x-placement="bottom-start" style="position: absolute; will-change: transform; transform: translate3d(0px, 35px, 0px);margin-left: -60px!important;">
                                                            <a class="dropdown-item updatestock" data-id="{{ $v_upsel->sku}}" id="updatestock"><i class="ti ti-eye"></i> Update Stock</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            $counter ++;
                                            ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="update_stock" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Update Stock</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </div>
                            <form class="form-horizontal form-material" enctype="multipart/form-data" novalidate="novalidate">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="col-md-12 m-b-20">
                                            <input type="text" class="form-control" name="quantity" id="quantity" placeholder="Quantity">
                                            <input type="hidden" class="form-control" name="upsel_product_id" id="upsel_product_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a type="submit" class="btn btn-primary waves-effect text-white" id="config">Save</a>
                                    <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- ============================================================== -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@section('script')
<script type="text/javascript">
    
    $(function(e){
        $('#config').click(function(e){
            var id = $('#upsel_product_id').val();
            var quantity = $('#quantity').val();
            $.ajax({
                type : 'POST',
                url:'{{ route('products.updatestock')}}',
                cache: false,
                data:{
                    id: id,
                    quantity: quantity,
                    _token : '{{ csrf_token() }}'
                },
                success:function(response){
                    if(response.success == true){
                        toastr.success('Good Job.', 'Stock Has been Update Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                    }
                    location.reload();
            }});
        });
    });
    
    $(function () {
        $('body').on('click', '.updatestock', function () {
        var product_id = $(this).data('id');
        //console.log(product_id);
                $('#update_stock').modal('show');
                $('#upsel_product_id').val(product_id);
            
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
        $('body').on('click', '.editProduct', function () {
        var product_id = $(this).data('id');
        //console.log(product_id);
            $.get("{{ route('products.index') }}" +'/' + product_id +'/upsells/edit', function (data) {
                //console.log(product_id);
                $('#update_stock').modal('show');
                $('#upsel_id').val(data.id);
                $('#upsel_quantity').val(data.quantity);
                $('#upsel_discount').val(data.discount);
                $('#upsel_note').val(data.note);
            });
        });
    });
</script>
@endsection
@endsection