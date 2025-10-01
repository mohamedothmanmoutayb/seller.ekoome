@extends('backend.layouts.app')
@section('content')
<style>
    .dropdown-menu.show {
    display: block;
    left: -50px !important;
}
</style>
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-5 align-self-center">
                        <h4 class="page-title">Roles</h4>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Library</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Roles list</h4>
                                <h6 class="card-subtitle"></h6>
                                    <div class="form-group mb-0 text-right">
                                        <button type="button" class="btn btn-info btn-rounded waves-effect waves-light" data-toggle="modal" data-target="#adduser">Add New Role</button>
                                    </div>
                                
                                <!-- Add Contact Popup Model -->        
                                <div id="adduser" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Add Role</h4> 
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <from class="form-horizontal form-material">
                                                    <div class="form-group">
                                                        <div class="col-md-12 m-b-20">
                                                            <input type="text" class="form-control" id="name" placeholder="Name">
                                                        </div>
                                                        <div class="col-md-12 m-b-20">
                                                            <textarea class="form-control" id="description" placeholder="Description"></textarea>
                                                        </div>
                                                    </div>
                                                </from>
                                            </div>
                                            <div class="modal-body">
                                                <button type="submit" class="btn btn-info waves-effect" data-dismiss="modal" id="add-role">Save</button>
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
                                    <table id="demo-foo-addrow" class="table table-bordered m-t-30 table-hover contact-list" data-paging="true" data-paging-size="7">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1 ;
                                            ?>
                                            @foreach($users as $v_role)
                                            <tr>
                                                <td>{{ $counter}}</td>
                                                <td>{{ $v_role->name}}</td>
                                                <td>{{ $v_role->description}}</td>
                                                <td>{{ $v_role->created_at}}</td>
                                                <td>
                                                    
                                                <div class="btn-group">
                                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu animated slideInUp" x-placement="bottom-start" style="position: absolute; will-change: transform; transform: translate3d(0px, 35px, 0px);">
                                                            <a class="dropdown-item" href="{{ route('Staff.permissions', $v_role->id)}}" data-id="{{ $v_role->id}}"><i class="ti-edit"></i> Add Permission</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            $counter ++ ;
                                            ?>
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
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                All Rights Reserved by FULFILLEMENT ADMIN. Designed and Developed by <a href="Palace Agency.eu">Palace Agencyy</a>.
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
                                                            <input type="text" class="form-control" name="product_link" id="product_link" placeholder="Link"> </div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info waves-effect" >Save</button>
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
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
        $('#add-role').click(function(e){
            var name = $('#name').val();
            var description = $('#description').val();
            $.ajax({
                type : 'POST',
                url:'{{ route('Staff.rolestore')}}',
                cache: false,
                data:{
                    name: name,
                    description: description,
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
    $(function(e){
        $('.active').click(function(e){
            var id = $(this).data('id');
            $.ajax({
                type : 'POST',
                url:'{{ route('Staff.active')}}',
                cache: false,
                data:{
                    id: id,
                    _token : '{{ csrf_token() }}'
                },
                success:function(response){
                    if(response.success == true){
                        toastr.success('Good Job.', 'User Status Has been Change Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                    }
                    location.reload();
            }});
        });
    });
    $(function(e){
        $('.inactive').click(function(e){
            var ids = $(this).data('id');
            $.ajax({
                type : 'POST',
                url:'{{ route('Staff.inactive')}}',
                cache: false,
                data:{
                    id: ids,
                    _token : '{{ csrf_token() }}'
                },
                success:function(response){
                    if(response.success == true){
                        toastr.success('Good Job.', 'User Status Has been Change Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                    }
                    location.reload();
            }});
        });
    });

    $(function () {
        $('body').on('click', '.editProduct', function () {
        var product_id = $(this).data('id');
        //console.log(product_id);
            $.get("{{ route('products.index') }}" +'/' + product_id +'/edit', function (data) {
                //console.log(product_id);
                $('#edit_product').modal('show');
                $('#product_id').val(data.id);
                $('#product_nam').val(data.name);
                $('#product_link').val(data.link);
            });
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