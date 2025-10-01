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
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-8 align-self-center">
                        <h3 class="page-title">Customers Fees</h3>
                    
                    </div>
                    <div class="col-4 align-self-center">
                        <div class="form-group mb-0 text-right">
                            <a type="button" class="btn btn-info btn-rounded waves-effect waves-light text-white" data-toggle="modal" data-target="#adduser">Add New Fees</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add User Popup Model -->
            <div id="adduser" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Add New Fees</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <from class="form-horizontal form-material">
                                <div class="form-group">
                                    <div class="col-md-12 m-b-20">
                                        <select class="form-control" placeholder="Select Country" id="id_country">
                                            <option value="">Select Country</option>
                                            @foreach($countries as $v_country)
                                            <option value="{{ $v_country->id}}">{{ $v_country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="assigne_entred" placeholder="Entred Fees">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="hidden" id="assigne_id" value="{{ $id}}">
                                        <input type="number" class="form-control" id="assigne_confirmation" placeholder="Fees Counfirmation">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="assigne_delivered" placeholder="Delivered Fees">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="assigne_upsell" placeholder="Upsell - Crosell Fees">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="assigne_shipping_delivered" placeholder="Fees Delivered Shipping">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="assigne_shipping_return" placeholder="Shipping Return Fees">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="assigne_shipping_island" placeholder="Shipping Island Fees">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="assigne_shipping_return_island" placeholder="Shipping Return Island Fees">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="assigne_fullfilment" placeholder="Fullfilemnt Fees">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="assigne_COD" placeholder="COD Fees">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="return_mangement" placeholder="Return Mangement">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="assigne_vat" placeholder="VAT">
                                    </div>
                                </div>
                            </from>
                        </div>
                        <div class="modal-body">
                            <button type="button" class="btn btn-info waves-effect" id="add-fees">Save</button>
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <div id="updatefees" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Update Fees</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <from class="form-horizontal form-material">
                                <div class="form-group">
                                    <div class="col-md-12 m-b-20">
                                        <input type="hidden" id="fees_id" />
                                        <input type="number" class="form-control" id="update_entred" placeholder="Entred Fees">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="update_confirmation" placeholder="Fees Counfirmation">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="update_delivered" placeholder="Delivered Fees">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="update_upsell" placeholder="Upsell - Crosell Fees">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="update_shipping_delivered" placeholder="Fees Shipping">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="update_shipping_delivered_island" placeholder="Fees Shipping Island">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="update_shipping_return" placeholder=" Return Fees">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="update_shipping_return_island" placeholder="Return Island Fees">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="update_fullfilment" placeholder="Fullfilemnt Fees">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="update_COD" placeholder="COD Fees">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="update_return_mangement" placeholder="Return Mangement">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="number" class="form-control" id="update_vat" placeholder="VAT">
                                    </div>
                                </div>
                            </from>
                        </div>
                        <div class="modal-body">
                            <button type="button" class="btn btn-info waves-effect" id="update-fees">Save</button>
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"></h4>
                                <h6 class="card-subtitle"></h6>
                                
                                <div class="table-responsive">
                                    <table id="demo-foo-addrow" class="table table-bordered table-striped table-hover contact-list" data-paging="true" data-paging-size="7">
                                        <thead >
                                            <tr>
                                                <th>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="selectall custom-control-input" id="chkCheckAll" required>
                                                        <label class="custom-control-label" for="chkCheckAll"></label>
                                                    </div>
                                                </th>
                                                <th>No</th>
                                                <th>NAME</th>
                                                <th>ENTERED FEES</th>
                                                <th>CONFIRMED FEES</th>
                                                <th>DELIVERED FFES</th>
                                                <th>UPSELL FEES</th>
                                                <th>SHIPPING DELIVERED</th>
                                                <th>SHIPPING RETURNED</th>
                                                <th>FULFILLEMNT FEES</th>
                                                <th>COD FEES</th>
                                                <th>VAT</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $counter = 1 ?>
                                            @foreach($fees as $v_fees)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="ids" class="custom-control-input checkBoxClass"  value="{{$v_fees->id}}" id="pid-{{$counter}}">
                                                        <label class="custom-control-label" for="pid-{{$counter}}"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $counter}}</td>
                                                <td>
                                                    @foreach($v_fees['country'] as $v_country)
                                                    {{ $v_country->name}}
                                                    @endforeach
                                                </td>
                                                <td>{{ $v_fees->entred_fees}}</td>
                                                <td>{{ $v_fees->fees_confirmation}}</td>
                                                <td>{{ $v_fees->delivered_fees}}</td>
                                                <td>{{ $v_fees->upsell}}</td>
                                                <td>{{ $v_fees->delivered_shipping}}</td>
                                                <td>{{ $v_fees->returned_shipping}}</td>
                                                <td>{{ $v_fees->fullfilment}}</td>
                                                <td>
                                                    {{ $v_fees->percentage}}
                                                </td>
                                                <td>{{ $v_fees->vat}}</td>
                                                <td>{{ $v_fees->created_at}}</td>
                                                <td>
                                                    
                                                <div class="btn-group">
                                                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu animated slideInUp" x-placement="bottom-start" style="position: absolute; will-change: transform; transform: translate3d(0px, 35px, 0px);margin-left: -60px!important;">
                                                            
                                                            <a class="dropdown-item editfees" data-id="{{$v_fees->id}}" ><i class="ti-eye"></i> Update</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $counter ++ ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $fees->withQueryString()->links('vendor.pagination.courier')  }}
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

        <div id="detailuser" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Details Customer</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <from class="form-horizontal form-material">
                                <div class="form-group">
                                    <div class="col-md-12 m-b-20">
                                        <input type="text" class="form-control" id="detail_name" placeholder="User Name">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="phone" class="form-control" id="detail_phone" placeholder="Phone">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="email" class="form-control" id="detail_email" placeholder="Email">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="text" class="form-control" id="detail_bank" placeholder="Bank">
                                    </div>
                                    <div class="col-md-12 m-b-20">
                                        <input type="text" class="form-control" id="detail_rib" placeholder="Rib">
                                    </div>
                                </div>
                            </from>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<script type="text/javascript">
    
    $(function(e){
        $('#add-fees').click(function(e){
            if($('#id_country').val() != ""){
               var country = $('#id_country').val();
                var user = $('#assigne_id').val();
                var entred = $('#assigne_entred').val();
                var shipping = $('#assigne_delivered').val();
                var confirmation = $('#assigne_confirmation').val();
                var upsell = $('#assigne_upsell').val();
                var shippingdelivered = $('#assigne_shipping_delivered').val();
                var shippingreturned = $('#assigne_shipping_return').val();
                var shippingreturnedisland = $('#assigne_shipping_return_island').val();
                var shippingisland = $('#assigne_shipping_island').val();
                var fullfilment = $('#assigne_fullfilment').val();
                var percentage = $('#assigne_COD').val();
                var vat = $('#assigne_vat').val();
                var returnmangement = $('#return_mangement').val();
                $.ajax({
                    type : 'POST',
                    url:'{{ route('customers.feesstore')}}',
                    cache: false,
                    data:{
                        country: country,
                        user: user,
                        entred: entred,
                        shipping: shipping,
                        confirmation: confirmation,
                        upsell: upsell,
                        shippingdelivered: shippingdelivered,
                        shippingreturned: shippingreturned,
                        shippingreturnedisland : shippingreturnedisland,
                        shippingisland :shippingisland,
                        fullfilment: fullfilment,
                        percentage: percentage,
                        returnmangement : returnmangement,
                        vat: vat,
                        _token : '{{ csrf_token() }}'
                    },
                    success:function(response){
                        if(response.success == true){
                            toastr.success('Good Job.', 'Fees Has been Addess Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                        }
                        location.reload();
                }}); 
            }
            
        });
    });
    $(function(e){
        $('.active').click(function(e){
            var id = $(this).data('id');
            $.ajax({
                type : 'POST',
                url:'{{ route('users.active')}}',
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

    $(function () {
        $('body').on('click', '.editfees', function () {
        var id = $(this).data('id');
        //console.log(product_id);
            $.get("{{ route('customers.index') }}" +'/' + id +'/fees', function (data) {
                //console.log(product_id);
                $('#updatefees').modal('show');
                $('#fees_id').val(data.id);
                $('#update_entred').val(data.entred_fees);
                $('#update_confirmation').val(data.fees_confirmation);
                $('#update_delivered').val(data.delivered_fees);
                $('#update_upsell').val(data.upsell);
                $('#update_shipping').val(data.fess_shipping);
                $('#update_shipping_delivered').val(data.delivered_fees);
                $('#update_shipping_delivered_island').val(data.island_shipping);
                $('#update_shipping_return').val(data.island_return);
                $('#update_shipping_return_island').val(data.island_return);
                $('#update_fullfilment').val(data.fullfilment);
                $('#update_COD').val(data.percentage);
                $('#update_return_mangement').val(data.return_management);
                $('#update_vat').val(data.vat);
            });
        });

        $('#update-fees').click(function(){
            var id = $('#fees_id').val();
            var entred = $('#update_entred').val();
            var shipping = $('#update_delivered').val();
            var confirmation = $('#update_confirmation').val();
            var upsell = $('#update_upsell').val();
            var shippingdelivered = $('#update_shipping_delivered').val();
            var shippingdeliveredisland = $('#update_shipping_delivered_island').val();
            var shippingreturned = $('#update_shipping_return').val();
            var shippingreturnedisland = $('#update_shipping_return_island').val();
            var fullfilment = $('#update_fullfilment').val();
            var percentage = $('#update_COD').val();
            var returnmangement = $('#update_return_mangement').val();
            var vat = $('#update_vat').val();
            $.ajax({
                type : 'POST',
                url:'{{ route('customers.feesedit')}}',
                cache: false,
                data:{
                    id: id,
                    entred: entred,
                    shipping: shipping,
                    confirmation: confirmation,
                    upsell: upsell,
                    shippingdelivered: shippingdelivered,
                    shippingdeliveredisland: shippingdeliveredisland,
                    shippingreturned: shippingreturned,
                    shippingreturnedisland: shippingreturnedisland,
                    fullfilment: fullfilment,
                    percentage: percentage,
                    returnmangement : returnmangement,
                    vat: vat,
                    _token : '{{ csrf_token() }}'
                },
                success:function(response){
                    if(response.success == true){
                        toastr.success('Good Job.', 'Fess has been update Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                    }
                }
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
    
    $(function () {
        $('body').on('click', '.detailcustomer', function () {
        var customer = $(this).data('id');
        console.log(customer);
        $.get("{{ route('customers.index') }}" +'/' + customer +'/details', function (data) {
                //console.log(product_id);
                $('#detailuser').modal('show');
                $('#detail_name').val(data.name);
                $('#detail_email').val(data.email);
                $('#detail_phone').val(data.telephone);
                $('#detail_bank').val(data.bank);
                $('#detail_rib').val(data.rib);
            });
                $('#config_upsel').modal('show');
                $('#upsel_product_id').val(product_id);
            
        });
    });
</script>
<script type="text/javascript">
    $(function(e){
        $("#chkCheckAll").click(function(){
            $(".checkBoxClass").prop('checked', $(this).prop('checked'));
        });
        $('#paid').click(function(e){
            e.preventDefault();
            var allids = [];
            $("input:checkbox[name=ids]:checked").each(function(){
                allids.push($(this).val());
            });
            if(confirm("Are you sure, you want to Paid Orders?")){
                $.ajax({
                    type : 'POST',
                    url:'{{ route('customers.paiedall')}}',
                    cache: false,
                    data:{
                        ids: allids,
                        _token : '{{ csrf_token() }}'
                    },
                    success:function(response){
                        if(response.success == true){
                            toastr.success('Good Job.', 'Orders Has been Paied Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                            location.reload();
                        }
                    }
                });
            }
            
        });
    });
</script>
@endsection