@extends('backend.layouts.app')
@section('content')
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="page-wrapper">
                   <div class="card card-body py-3">
             
                      <div class="row align-items-center">
                        <div class="col-12">
                            <div class="d-sm-flex align-items-center justify-space-between">
                                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                                    <i class="ti ti-arrow-left fs-5"></i> 
                                </a>
                                <div>
                                <h4 class="mb-4 mb-sm-0 card-title">Sheets</h4>              
                                </div>
                                <nav aria-label="breadcrumb" class="ms-auto">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item d-flex align-items-center">
                                         <a type="button" class="btn btn-primary btn-rounded waves-effect waves-light text-white my-2"
                                                 data-bs-toggle="modal" data-bs-target="#add-contact">Add New Sheet</a>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
           
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-9 col-sm-12 m-b-20">
                                                <label class="mb-1">Sheet Name</label>
                                                <input type="text" class="form-control" name="sheet_name" placeholder="Sheet Name">
                                            </div>
                                            <div class="col-md-3 col-sm-12 m-b-20">
                                                <button type="submit" class="btn btn-primary waves-effect mt-4" style="width:100%">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- Add Contact Popup Model -->        
                                    <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="height:auto !important;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Add New Sheet</h4> 
                                                    {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> --}}
                                                </div>
                                                <div class="modal-body">
                                                    <from class="form-horizontal form-material">
                                                        <div class="form-group">
                                                            <div class="col-md-12 mb-3">
                                                                <input type="text" class="form-control" id="sheet_name" placeholder="Sheet Name" required>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <input type="text" class="form-control" id="sheet_id" placeholder="Sheet ID" required>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <a type="button" href="/public/googlesheet.xlsx" class="btn btn-primary waves-effect" download>download</a>
                                                            </div>
                                                        </div>
                                                    </from>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary waves-effect" id="createsheets">Save</button>
                                                    <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- Update Sheet Popup Model -->        
                                    <div id="editsheet" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="height:auto !important;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Add New Sheet</h4> 
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <from class="form-horizontal form-material">
                                                        <div class="form-group">
                                                            <div class="col-md-12 m-b-20">
                                                                <input type="text" class="form-control" id="sheets_name" placeholder="Sheet Name" required>
                                                                <input type="hidden" class="form-control" id="sheet_id" placeholder="Sheet Name" >
                                                            </div>
                                                            <div class="col-md-12 m-b-20">
                                                                <input type="text" class="form-control" id="sheetid" placeholder="Sheet ID" required> </div>
                                                        </div>
                                                    </from>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal" id="editsheets">Save</button>
                                                    <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- Update Row Popup Model -->        
                                    <div id="sheetrow" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="height:auto !important;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Update Row</h4> 
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <from class="form-horizontal form-material">
                                                        <div class="form-group">
                                                            <div class="col-md-12 m-b-20">
                                                                <input type="text" class="form-control" id="index_sheet" placeholder="Sheet Name" required>
                                                                <input type="hidden" class="form-control" id="sheet_id" placeholder="Sheet Name" >
                                                            </div>
                                                        </div>
                                                    </from>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal" id="editrow">Save</button>
                                                    <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
              <div class="col-xl-12 col-lg-12 col-md-12 box-col-7">
                <div class="card order-card">
                  <div class="card-body pt-0">
                    <div class="table-responsive theme-scrollbar" style="min-height: 350px;">
                      <table class="table table-bordernone">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Last Rows Sheet</th>
                            <th>Sheets Name</th>
                            <th>Sheets ID</th>
                            <th>Created at</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php $counter = 1; ?>
                            @if(!$sheets->isempty())
                            @foreach($sheets as $v_sheet)
                            <tr>
                                <td>{{ $counter}}</td>
                                <td>
                                    @if($v_sheet['leads'] != null)
                                    {{ $v_sheet['leads']['index_sheet'] + 2}}
                                    @endif
                                </td>
                                <td>{{ $v_sheet->sheetname}}</td>
                                <td><a href="https://docs.google.com/spreadsheets/d/{{ $v_sheet->sheetid }}" target="_blank">{{ $v_sheet->sheetid }}</a></td>
                                <td>{{ $v_sheet->created_at}}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle show" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="icon-settings"></i></button>
                                        <div class="dropdown-menu" bis_skin_checked="1" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(184px, -325.203px, 0px);" data-popper-placement="top-start">                          
                                            <a class="dropdown-item pr-2 editProduct" data-id="{{ $v_sheet->id}}" id="editProduct"> Edit</a>
                                            <a class="dropdown-item deletesheet" id="deletesheet" data-id="{{ $v_sheet->id}}"> Deleted</a>
                                            <a class="dropdown-item updaterow" id="updaterow" data-id="{{ $v_sheet->id}}"> Update Row</a>
                                        </div>
                                        <button class="btn p-0" type="button" id="earningReports" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">                          
                                        </div>
                                    </div> 
                                </td>
                            </tr>
                            <?php
                            $counter ++;
                            ?>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6">
                                    <img src="{{ asset('public/Empty-amico.svg')}}" style="margin-left: auto ; margin-right: auto; display: block;" width="500" />
                                </td>
                            </tr>
                            @endif
                        </tbody>
                      </table>
                    </div>
                    <div class="code-box-copy">
                      <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#total-sold"><i class="icofont icofont-copy-alt"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
    
    $(function(e){
        $('#createsheets').click(function(e){
            if($('#sheet_name').val() != '' && $('#sheet_id').val() != ''){
                var sheetname = $('#sheet_name').val();
                var sheetid = $('#sheet_id').val();
                $.ajax({
                    type : 'POST',
                    url:'{{ route('sheets.store')}}',
                    cache: false,
                    data:{
                        sheetname: sheetname,
                        sheetid: sheetid,
                        _token : '{{ csrf_token() }}'
                    },
                    success:function(response){
                        if(response.success == true){
                            toastr.success('Good Job.', 'Google Sheet Has been Addess Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                        }
                        location.reload();
                }});
            }
            
        });
    });
    
    $(function(e){
        $('.deletesheet').click(function(e){
            var id = $(this).data('id');
            if(confirm("Are you sure, you want to Delete Sheet?")){
            $.ajax({
                type : 'POST',
                url:'{{ route('sheets.delete')}}',
                cache: false,
                data:{
                    id: id,
                    _token : '{{ csrf_token() }}'
                },
                success:function(response){
                    if(response.success == true){
                        toastr.success('Good Job.', 'Sheet Has been Deleted Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                    }
                    location.reload();
            }});
            }
        });
    });
    $(function () {
        $('body').on('click', '.editProduct', function () {
        var sheet_id = $(this).data('id');
        //console.log(product_id);
            $.get("{{ route('sheets.index') }}" +'/' + sheet_id +'/edit', function (data) {
                //console.log(product_id);
                $('#editsheet').modal('show');
                $('#sheet_id').val(data.id);
                $('#sheets_name').val(data.sheetname);
                $('#sheetid').val(data.sheetid);
            });
        });
        $('body').on('click', '.updaterow', function () {
        var sheet_id = $(this).data('id');
        //console.log(product_id);
            $.get("{{ route('sheets.index') }}" +'/' + sheet_id +'/rows', function (data) {
                //console.log(data.index_sheet);
                var sh = data.index_sheet;
                var index = parseInt(sh) + 2 ;
                $('#sheetrow').modal('show');
                $('#sheet_id').val(sheet_id);
                $('#index_sheet').val(index);
            });
        });
    });
    $(function(e){
        $('#editrow').click(function(e){
            var idsheet = $('#sheet_id').val();
            var rows = $('#index_sheet').val();
            $.ajax({
                type : 'POST',
                url: '{{ route('sheets.rowsupdate')}}',
                cache: false,
                data:{
                    id: idsheet,
                    rows: rows,
                    _token : '{{ csrf_token() }}'
                },
                success:function(response){
                    if(response.success == true){
                        toastr.success('Good Job.', 'Row Has been Addess Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                    }
                    location.reload();
                }
            })
        })
    })
    $(function(e){
        $('#editsheets').click(function(e){
            var idsheet = $('#sheet_id').val();
            var sheetname = $('#sheets_name').val();
            var sheetid = $('#sheetid').val();
            $.ajax({
                type : 'POST',
                url:'{{ route('sheets.update')}}',
                cache: false,
                data:{
                    id: idsheet,
                    sheetname: sheetname,
                    sheetid: sheetid,
                    _token : '{{ csrf_token() }}'
                },
                success:function(response){
                    if(response.success == true){
                        toastr.success('Good Job.', 'Sheet Has been Addess Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                    }
                    location.reload();
                }
            });
        });
    });
</script>
@endsection