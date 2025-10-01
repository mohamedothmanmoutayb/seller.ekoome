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
                                class="text-muted fw-light">Dashboard /</span> Announcements&nbsp;

                        </h4>
                    </div>
                    <div class="col-4 d-flex justify-content-end">
                        <div class="form-group mb-0 text-right">
                            <!-- <a type="button" class="btn btn-info btn-rounded waves-effect waves-light text-white" id="paid">Paid Order Selected</a> -->
                            <a type="button" class="btn btn-primary btn-rounded waves-effect waves-light text-white my-2"
                                data-bs-toggle="modal" data-bs-target="#adduser">Add New Announcements <i class="ti ti-plus"></i></a>

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
                            {{-- <div class="form-group mb-3 text-right">
                                        <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light" data-toggle="modal" data-target="#adduser">Add New Announcement</button>
                                    </div> --}}

                            <div id="adduser" class="modal fade in" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Add New Announcement <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg></h4>
                                            {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> --}}
                                        </div>
                                        <div class="modal-body">
                                            <from class="form-horizontal form-material">
                                                <div class="form-group">
                                                    <div class="col-md-12 m-b-20">
                                                        <input type="text" class="form-control" id="announcement"
                                                            placeholder="Annoucement">
                                                    </div>
                                                </div>
                                            </from>
                                        </div>
                                        <div class="modal-body">
                                            <button type="submit" class="btn btn-primary waves-effect"
                                                id="add-announcement">Save</button>
                                            <button type="button" class="btn btn-primary waves-effect"
                                                data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <div class="table-responsive">
                                <table id="demo-foo-addrow"
                                    class="table table-bordered table-striped table-hover contact-list" data-paging="true"
                                    data-paging-size="7">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Announcements</th>
                                            <th>Active</th>
                                            <th>Created at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $counter = 1; ?>
                                        @foreach ($announcements as $v_announcement)
                                            <tr>
                                                <td>{{ $counter }}</td>
                                                <td>{{ $v_announcement->annonce }}</td>
                                                <td>
                                                    @if ($v_announcement->is_active == '1')
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-warning">InActive</span>
                                                    @endif
                                                </td>
                                                <td>{{ $v_announcement->created_at }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn p-0" type="button" id="earningReports" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                          <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">
                                                            @if ($v_announcement->is_active == '0')
                                                                 <a class="dropdown-item"
                                                                href="{{ route('announcements.active', $v_announcement->id) }}"> Active <i class="ti ti-power  mb-2"></i></a>
                                                            @else
                                                                <a class="dropdown-item"
                                                                    href="{{ route('announcements.inactive', $v_announcement->id) }}"> InActive <i class="ti ti-off"></i></a>
                                                            @endif
                                                            <a class="dropdown-item"
                                                                href="{{ route('announcements.delete', $v_announcement->id) }}"> Delete <i class="ti ti-trash mb-2"></i></a>
                                                        </div>
                                                    </div> 
                                                    
                                                </td>
                                            </tr>
                                            <?php $counter++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        $(function(e) {
            $('#add-announcement').click(function(e) {
                var announcement = $('#announcement').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('announcements.store') }}',
                    cache: false,
                    data: {
                        announcement: announcement,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job .',
                                'Announcement Has been Addess Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                        }
                        location.reload();
                    }
                });
            });
        });
    </script>
    @if (session()->has('success'))
        <script>
            toastr.success('Good Job.', 'Announcement Has been Addess Success!', {
                "showMethod": "slideDown",
                "hideMethod": "slideUp",
                timeOut: 2000
            });
        </script>
    @endif
@endsection
