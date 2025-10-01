@extends('backend.layouts.app')
@section('content')
<style>
    .dropdown-menu.show {
    display: block;
}

</style>
        <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- Add User Popup Model -->
            <div id="addguide" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Add New Guide</h4>
                          
                        </div>
                        <form class="form-horizontal form-material" action="{{ route('guides.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                    <div class="form-group">
                                        
                                    
                                        <div class="col-md-12 my-2">
                                            <lable>Title</lable>
                                            <input type="text" class="form-control"  name="name" placeholder="Title">
                                        </div>
                                    
                                        <div class="col-md-12 my-2">
                                            <lable>PDf</lable>
                                            <input type="file" class="form-control"  name="pdf" >
                                        </div>

                                        <div class="col-md-12 my-2">
                                            <lable>Thumbline</lable>
                                            <input type="file" class="form-control" name="tumbline">
                                        </div>
                                        
                                    </div>
                            </div>
                            <div class="modal-body">
                                <button type="submit" class="btn btn-primary waves-effect" >Save</button>
                                <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Add User Popup Model -->
            
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-5 align-self-center ">
                            <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                    class="text-muted fw-light">Dashboard /</span> Guides list&nbsp;
                               
                            </h4>
                        </div> 
                        <div class="col-7 d-flex justify-content-end">
                            <div class="form-group mb-0 text-right">
                                <a type="button" class="btn btn-primary btn-rounded waves-effect waves-light text-white" data-bs-toggle="modal" data-bs-target="#addguide">Add New Guide</a>
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
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Thumbline</th>
                                                <th>Name</th>
                                                <th>Created at</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $counter = 1 ?>
                                            @foreach($guides as $v_guide)
                                            <tr>
                                                <td>{{ $counter}}</td>
                                                <td><img src="{{ asset('uploads/guides/tumbline/'.$v_guide->tumbline.'') }}" style="width: 73px;"/></td>
                                                <td>{{ $v_guide->name}}</td>
                                                <td>{{ $v_guide->created_at}}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <div class="dropdown">
                                                            <button class="btn p-0" type="button" id="earningReports" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">
                                                                <a class="dropdown-item" href="{{ route('guides.delete', $v_guide->id) }}"> Deleted</a>   
                                                            </div>
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
                            {{ $guides->withQueryString()->links('vendor.pagination.courier')  }}
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript">
            

            
     

        </script>
@endsection