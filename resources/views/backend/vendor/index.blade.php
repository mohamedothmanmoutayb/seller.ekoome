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
        <div class="content-wrapper">
          

            <!-- Add User Popup Model -->
            <div id="adduser" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Add New Vendor</h4>
                          
                        </div>
                        <div class="modal-body">
                            <from class="form-horizontal form-material">
                                <div class="form-group">
                                    <div class="col-md-12 my-2">
                                        <select class="select2 form-control" id="assigne_manager" style="width: 100%;height: 36px;">
                                            <option value=" ">Select Account Manager</option>
                                            @foreach($managers as $v_manager)
                                            <option value="{{ $v_manager->id}}">{{ $v_manager->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for=""> Full Name</label>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" id="assigne_name" placeholder="User Name">
                                    </div>
                                    <label for=""> Phone</label>
                                    <div class="col-md-12 my-2">
                                        <input type="phone" class="form-control" id="assigne_phone" placeholder="Phone">
                                    </div>
                                    <label for=""> Departement</label>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" id="assigne_departement" placeholder="Departement">
                                    </div>
                                    <label for=""> Email</label>
                                    <div class="col-md-12 my-2">
                                        <input type="email" class="form-control" id="assigne_email" placeholder="Email">
                                    </div>
                                    <label for=""> Password</label>
                                    <div class="col-md-12 my-2">
                                        <input type="password" class="form-control" id="assigne_password" placeholder="password">
                                    </div>
                                </div>
                            </from>
                        </div>
                        <div class="modal-body">
                            <button type="button" class="btn btn-primary waves-effect" id="addusers">Save</button>
                            <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Add User Popup Model -->
            <div id="orderpaid" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Upload Tracking Numbre</h4>
                          
                        </div>
                        <form action="{{ route('payment.trackingnumber')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                            <div class="modal-body">
                                    <div class="form-group">
                                        <div class="col-md-12 my-2">
                                            <input type="file" class="form-control" name="csv_file" placeholder="User Name">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-body">
                                <button type="submit" class="btn btn-primary waves-effect">Save</button>
                                <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
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
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-8 align-self-center ">
                            <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                    class="text-muted fw-light">Dashboard /</span> Vendors list&nbsp;
                               
                            </h4>
                        </div> 
                        <div class="col-4 d-flex justify-content-end">
                            <div class="form-group mb-0 text-right">
                                <!-- <a type="button" class="btn btn-info btn-rounded waves-effect waves-light text-white" id="paid">Paid Order Selected</a> -->
                                <a type="button" class="btn btn-primary btn-rounded waves-effect waves-light text-white my-2" data-bs-toggle="modal" data-bs-target="#orderpaid">Upload Order Paid</a>
                                <a type="button" class="btn btn-primary btn-rounded waves-effect waves-light text-white my-2" data-bs-toggle="modal" data-bs-target="#adduser">Add New Vendor</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Start Page Content -->
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group-1">
                                    <form>
                                    <div class="row">                                        
                                        <div class="col-md-11 col-sm-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search" id="search" placeholder="Name Customer ,  Email , Telephone" aria-label="" aria-describedby="basic-addon1">
                                            </div>
                                        </div>                                        
                                        <div class="col-md-1 col-sm-12">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
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
                                                <th>Departement</th>
                                                <th>Name</th>
                                                <th>Unpaid Order</th>
                                                <th>Email</th>
                                                <th>Fees</th>
                                                <th>Active</th>
                                                <th>Countries</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $counter = 1 ?>
                                            @foreach($customers as $v_customer)
                                            <tr>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="ids" class="custom-control-input checkBoxClass"  value="{{$v_customer->id}}" id="pid-{{$counter}}">
                                                        <label class="custom-control-label" for="pid-{{$counter}}"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $counter}}</td>
                                                <td>{{ $v_customer->departement}}</td>
                                                <td>{{ $v_customer->name}}</td>
                                                <td>{{ $v_customer['leadss']->where('status_confirmation','confirmed')->wherein('status_livrison',['delivered','returned'])->where('id_country', Auth::user()->country_id)->whereIn('status_payment',['paid service','prepaid','return'])->count()}}</td>
                                                <td>{{ $v_customer->email}}</td>
                                                <td>
                                                    @if(count($v_customer['fees']))
                                                    <span class="badge bg-success">Valid</span>
                                                    @else
                                                    <span class="badge bg-warning">Not Valid</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($v_customer->is_active == "1")
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-warning">InActive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($v_customer['fees'])
                                                    @foreach($v_customer['fees'] as $v_fee)
                                                    @if($v_fee['countr'])
                                                    {{ $v_fee['countr']['name']}} /
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                </td>
                                                <td>{{ $v_customer->created_at}}</td>
                                                <td>
                                                    
                                                     
                                                    <div class="dropdown">
                                                        <button class="btn p-0" type="button" id="earningReports" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                          <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">
                                                            @if($v_customer->is_active == "0")
                                                            <a class="dropdown-item" href="{{ route('vendors.active', $v_customer->id)}}" > Active</a>
                                                        @else
                                                        <a class="dropdown-item" href="{{ route('vendors.inactive', $v_customer->id)}}" > InActive</a>
                                                        @endif
                                                        <a class="dropdown-item" href="{{ route('vendors.situation', $v_customer->id)}}" > Order need to paied</a>
                                                        <a class="dropdown-item" href="{{ route('vendors.orders', $v_customer->id)}}" > All Orders</a>
                                                        <a class="dropdown-item detailcustomer" data-id="{{$v_customer->id}}" > Details</a>
                                                        <a class="dropdown-item detailcustomer" href="{{ route('vendors.fees', $v_customer->id)}}" > Fees</a>
                                                        <a class="dropdown-item detailcustomer" href="{{ route('vendors.document', $v_customer->id)}}" > Docuemnts</a>
                                                        <a class="dropdown-item detailcustomer" href="{{ route('vendors.parameter', $v_customer->id)}}" > Parameters</a>
                                                        </div>
                                                    </div> 
                                                </td>
                                            </tr>
                                            <?php $counter ++ ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $customers->withQueryString()->links('vendor.pagination.courier')  }}
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
                           
                        </div>
                        <div class="modal-body">
                            <from class="form-horizontal form-material">
                                <div class="form-group">
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" id="detail_departement" placeholder="Departement">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="hidden" class="form-control" id="detail_id">
                                        <input type="text" class="form-control" id="detail_name" placeholder="User Name">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="phone" class="form-control" id="detail_phone" placeholder="Phone">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="email" class="form-control" id="detail_email" placeholder="Email">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" id="detail_bank" placeholder="Bank">
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <input type="text" class="form-control" id="detail_rib" placeholder="Rib">
                                    </div>
                                    <div class="modal-body d-flex justify-content-center">
                                        <button type="button" class="btn btn-primary waves-effect mx-4" id="details">Save</button>
                                        <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
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
        $('#addusers').click(function(e){
            var manager = $('#assigne_manager').val();
            var name = $('#assigne_name').val();
            var email = $('#assigne_email').val();
            var password = $('#assigne_password').val();
            var phone = $('#assigne_phone').val();
            var departement = $('#assigne_departement').val();
            $.ajax({
                type : 'POST',
                url:'{{ route('vendors.store')}}',
                cache: false,
                data:{
                    manager: manager,
                    name: name,
                    email: email,
                    password: password,
                    phone: phone,
                    departement : departement,
                    _token : '{{ csrf_token() }}'
                },
                success:function(response){
                    if(response.success == true){
                        toastr.success('Good Job.', 'User Has been Addess Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                            window.location = ('customers/fees/'+response.id);
                    }
                    if(response.email == false){
                        toastr.error('Opps.', 'This Email Aready Existing!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                    }
                    if(response.departement == false){
                        toastr.error('Opps.', 'This Departement Aready Existing!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                    }
            }});
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
    $(function(e){
        $('.reset').click(function(e){
            var id = $(this).data('id');
            $.ajax({
                type : 'POST',
                url:'{{ route('users.reset')}}',
                cache: false,
                data:{
                    id: id,
                    _token : '{{ csrf_token() }}'
                },
                success:function(response){
                    if(response.success == true){
                        toastr.success('Good Job.', 'User Has been Reset Password Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
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
                url:'{{ route('users.inactive')}}',
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
                $('#edit_user').modal('show');
                $('#product_id').val(data.id);
                $('#product_nam').val(data.name);
                $('#product_link').val(data.link);
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
    
    $(function () {
        $('body').on('click', '.detailcustomer', function () {
        var customer = $(this).data('id');
        console.log(customer);
        $.get("{{ route('customers.index') }}" +'/' + customer +'/details', function (data) {
                //console.log(product_id);
                $('#detailuser').modal('show');
                $('#detail_id').val(data.id);
                $('#detail_departement').val(data.departement);
                $('#detail_name').val(data.name);
                $('#detail_email').val(data.email);
                $('#detail_phone').val(data.telephone);
                $('#detail_bank').val(data.bank);
                $('#detail_rib').val(data.rib);
            });
                $('#config_upsel').modal('show');
                $('#upsel_product_id').val(product_id);
            
        });
        $('#details').click(function(e){
            var id = $('#detail_id').val();
            var departement = $('#detail_departement').val();
            var name = $('#detail_name').val();
            var email = $('#detail_email').val();
            var phone = $('#detail_phone').val();
            var bank = $('#detail_bank').val();
            var rib = $('#detail_rib').val();
            $.ajax({
                type : 'POST',
                url:'{{ route('customers.details')}}',
                cache: false,
                data:{
                    id: id,
                    departement : departement,
                    name: name,
                    email: email,
                    phone: phone,
                    bank: bank,
                    rib : rib,
                    _token : '{{ csrf_token() }}'
                },
                success:function(response){
                    if(response.success == true){
                        toastr.success('Good Job.', 'User Has been Updated Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                        location.reload();
                    }
            }});
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