@extends('backend.layouts.app')
@section('content')
<style>
    .dropdown-menu.show {
    display: block;
}

</style>
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
          
            <!-- ============================================================== -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-5 align-self-center">
                            <h3 class="page-title">Customers list</h3>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <div class="row my-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"></h4>
                                <h6 class="card-subtitle"></h6>
                                    <div class="form-group mb-3 text-right">
                                        <button type="button" class="btn btn-info btn-rounded waves-effect waves-light" data-toggle="modal" data-target="#adduser">Add New Customer</button>
                                    </div>
                                       
                                    <div id="adduser" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Add New Customer</h4> 
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <from class="form-horizontal form-material">
                                                        <div class="form-group">
                                                            <div class="col-md-12 m-b-20">
                                                                <input type="text" class="form-control" id="assigne_name" placeholder="Customer Name">
                                                            </div>
                                                            <div class="col-md-12 m-b-20">
                                                                <input type="phone" class="form-control" id="assigne_phone" placeholder="Phone">
                                                            </div>
                                                            <div class="col-md-12 m-b-20">
                                                                <input type="email" class="form-control" id="assigne_email" placeholder="Email">
                                                            </div>
                                                            <div class="col-md-12 m-b-20">
                                                                <input type="password" class="form-control" id="assigne_password" placeholder="password">
                                                            </div>
                                                        </div>
                                                    </from>
                                                </div>
                                                <div class="modal-body">
                                                    <button type="submit" class="btn btn-info waves-effect" id="add-assigne">Save</button>
                                                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                                                </div>
                                                <div class="modal-footer">
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                <div class="table-responsive">
                                    <table id="demo-foo-addrow" class="table table-bordered table-striped table-hover contact-list" data-paging="true" data-paging-size="7">
                                        <thead >
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Active</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $counter = 1 ?>
                                            @foreach($customers as $v_customer)
                                            <tr>
                                                <td>{{ $counter}}</td>
                                                <td>{{ $v_customer->name}}</td>
                                                <td>{{ $v_customer->email}}</td>
                                                <td>
                                                    @if($v_customer->is_active == "1")
                                                        <span class="label label-success">Active</span>
                                                    @else
                                                        <span class="label label-warning">InActive</span>
                                                    @endif
                                                </td>
                                                <td>{{ $v_customer->created_at}}</td>
                                                <td>
                                                    
                                                <div class="btn-group">
                                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu animated slideInUp" x-placement="bottom-start" style="position: absolute; will-change: transform; transform: translate3d(0px, 35px, 0px);margin-left: -60px!important;">
                                                            @if($v_customer->is_active == "0")
                                                                <a class="dropdown-item" href="{{ route('customers.active', $v_customer->id)}}" ><i class="ti-eye"></i> Active</a>
                                                            @else
                                                            <a class="dropdown-item" href="{{ route('customers.inactive', $v_customer->id)}}" ><i class="ti-eye"></i> InActive</a>
                                                            @endif
                                                            <a class="dropdown-item" href="{{ route('customers.situation', $v_customer->id)}}" ><i class="ti-eye"></i> Situation</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $counter ++ ?>
                                            @endforeach
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
            </div>
     
            <!-- ============================================================== -->
            <footer class="content-footer footer bg-footer-theme">
                <div class="container-xxl">
                    <div
                        class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                        <div>
                            ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            , made with ❤️ by <a href="https://Palace Agency.eu" target="_blank" class="fw-semibold">Palace Agency</a>
                        </div>
                        <div>
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

                                <div id="edit_product" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Edit Product</h4> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                                <form action="{{ route('products.update')}}" method="POST" class="form-horizontal form-material" enctype="multipart/form-data" novalidate="novalidate">
                                                @csrf
                                            <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="text" class="form-control" name="product_nam" id="product_nam" placeholder="Product Name">
                                                            <input type="hidden" class="form-control" name="product_id" id="product_id" placeholder="Product Name">
                                                        </div>
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="file" class="form-control" name="product_image" id="product_image" placeholder="Product Image"> </div>
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="text" class="form-control" name="product_link" id="product_link" placeholder="Link">
                                                        </div>
                                                        <div class="col-md-12 m-b-20">
                                                            <textarea type="text" class="form-control" name="description_produc" id="description_produc" placeholder="Description Product"></textarea>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info waves-effect" >Save</button>
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                                            </div>
                                                </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div id="config_upsel" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Config Upsell</h4> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                                <form class="form-horizontal form-material" enctype="multipart/form-data" novalidate="novalidate">
                                                
                                            <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="text" class="form-control" name="upsel_quantity" id="upsel_quantity" placeholder="Quantity">
                                                            <input type="hidden" class="form-control" name="upsel_product_id" id="upsel_product_id" placeholder="Product Name">
                                                        </div>
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="text" class="form-control" name="discount" id="discount" placeholder="Discount"> </div>
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="text" class="form-control" name="note" id="note" placeholder="Note"> </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info waves-effect" id="config">Save</button>
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                                            </div>
                                                </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<script type="text/javascript">
    
    $(function(e){
        $('#add-assigne').click(function(e){
            var name = $('#assigne_name').val();
            var email = $('#assigne_email').val();
            var password = $('#assigne_password').val();
            var phone = $('#assigne_phone').val();
            $.ajax({
                type : 'POST',
                url:'{{ route('customers.store')}}',
                cache: false,
                data:{
                    name: name,
                    email: email,
                    password: password,
                    phone: phone,
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