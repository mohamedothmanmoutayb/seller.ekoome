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
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-5 align-self-center ">
                            <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                    class="text-muted fw-light">Dashboard /</span> New Users&nbsp;
                               
                            </h4>
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
                                               
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Active</th>
                                                <th>Reference</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $counter = 1 ?>
                                            @foreach($newusers as $v_customer)
                                            <tr>                                              
                                                <td>{{ $counter}}</td>                                             
                                                <td>{{ $v_customer->name}}</td>
                                               
                                                <td>{{ $v_customer->email}}</td>                                            
                                                <td>

                                                    <span class="badge bg-warning">InActive</span>
                                                </td>
                                                <td>

                                                    <span class="badge bg-primary">{{ $v_customer->ref}}</span>
                                                </td>
                                                <td>{{ $v_customer->created_at}}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn p-0" type="button" id="earningReports" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                          <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">
                                                            @if(Auth::user()->id_role == 1 )
                                                                <a class="dropdown-item" href="{{ route('customers.active', $v_customer->id)}}" > Activate</a>
                                                            @endif

                                                        </div>
                                                    </div> 
                                                </td>
                                            </tr>
                                            <?php $counter ++ ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {{ $newusers->withQueryString()->links('vendor.pagination.courier')  }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


        <script type="text/javascript">
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
            
        </script>

@endsection