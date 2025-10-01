@extends('backend.layouts.app')
@section('content')

    <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                      <div class="d-sm-flex align-items-center justify-space-between">
                         <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                        <i class="ti ti-arrow-left fs-5"></i> 
                    </a>
                    <div>
                        <h4 class="mb-4 mb-sm-0 card-title">Reclamations </h4>
                                    
                    </div>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                             <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light"
                            data-bs-toggle="modal" data-bs-target="#add-contact">+ Add New Reclamation</button>                            </li>
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
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Add Contact Popup Model -->
        <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true" style="height:100% !important;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Add New Reclamation</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material">
                            <div class="form-group">
                                <div class="col-md-12 m-b-20">
                                    <input type="text" class="form-control" id="n_lead" placeholder="N Lead" required>
                                </div>
                                <div class="col-md-12 col-sm-12 mt-2">
                                    <select class="select2" id="id_service" style="height: 100%;">
                                        <option value="0">Select Service</option>
                                        <option value="1">Sourcing</option>
                                        <option value="5">Warehoucing</option>
                                        <option value="5">Shipping</option>
                                        <option value="4">Call center</option>
                                        <option value="1">Invoicing</option>
                                    </select>
                                </div>
                                <div class="col-md-12 m-b-20 mt-2">
                                    <textarea class="form-control" id="note" placeholder="Reclamation" required></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary waves-effect" id="createReclamations">Save</button>
                        <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- Add Contact Popup Model -->
        <div id="editsheet" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true" style="height:auto !important;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Add New Sheet</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material">
                            <div class="form-group">
                                <div class="col-md-12 m-b-20">
                                    <input type="text" class="form-control" id="Reclamations_name"
                                        placeholder="Sheet Name" required>
                                    <input type="hidden" class="form-control" id="sheet_id" placeholder="Sheet Name">
                                </div>
                                <div class="col-md-12 m-b-20">
                                    <input type="text" class="form-control" id="sheetid" placeholder="Sheet ID"
                                        required>
                                </div>
                            </div>
                        </fm>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal"
                            id="editReclamations">Save</button>
                        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div id="filter" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true" style="height:auto !important;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Search</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal form-material">
                            <div class="form-group">
                                <div class="col-md-12 m-b-20">
                                    <input type="text" class="form-control" placeholder="Store Name">
                                </div>
                                <div class="col-md-12 m-b-20">
                                    <input type="text" class="form-control" placeholder="Link">
                                </div>
                            </div>
                        </fm>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Search</button>
                        <button type="button" class="btn btn-primary waves-effect"
                            data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 box-col-7">
            <div class="card order-card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                       
                        <div class="setting-list">
                            <ul class="list-unstyled setting-option">
                                <li>
                                    <div class="setting-light"><i class="icon-layout-grid2"></i></div>
                                </li>
                                <li><i class="view-html fa fa-code font-white"></i></li>
                                <li><i class="icofont icofont-maximize full-card font-white"></i></li>
                                <li><i class="icofont icofont-minus minimize-card font-white"></i></li>
                                <li><i class="icofont icofont-refresh reload-card font-white"></i></li>
                                <li><i class="icofont icofont-error close-card font-white"> </i></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="table-responsive theme-scrollbar">
                        <table class="table table-bordernone">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Lead Number</th>
                                    <th>Reclamation Note</th>
                                    <th>Status</th>
                                    <th>Created On</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter = 1; ?>
                                @forelse ($reclamations as $v_sheet)
                                    <tr>
                                        <td>{{ $counter }}</td>
                                        <td>
                                            @foreach ($v_sheet['lead'] as $v_shet)
                                                {{ $v_shet->n_lead }}
                                            @endforeach
                                        </td>
                                        <td>{{ $v_sheet->note }}</td>
                                        <td>
                                            @if ($v_sheet->status == 'done')
                                                <span class="label label-success">{{ $v_sheet->status }}</span>
                                            @elseif($v_sheet->status == 'canceled')
                                                <span class="label label-danger">{{ $v_sheet->status }}</span>
                                            @else
                                                <form class="myform" data-id="{{ $v_sheet->id }}">
                                                    <select class="form-control" id="statu_con{{ $v_sheet->id }}"
                                                        name="status">
                                                        <option value="on hold"
                                                            {{ $v_sheet->status == 'on hold' ? 'selected' : '' }}>On hold
                                                        </option>
                                                        <option value="processing"
                                                            {{ $v_sheet->status == 'processing' ? 'selected' : '' }}>
                                                            Processing</option>
                                                        <option value="done"
                                                            {{ $v_sheet->status == 'done' ? 'selected' : '' }}>Done
                                                        </option>
                                                        <option value="canceled"
                                                            {{ $v_sheet->status == 'canceled' ? 'selected' : '' }}>
                                                            Cancelled</option>
                                                    </select>
                                                </form>
                                            @endif
                                        </td>
                                        <td>{{ $v_sheet->created_at }}</td>
                                    </tr>
                                    <?php $counter++; ?>
                                   
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <img src="{{ asset('public/Empty-amico.svg') }}" class="img-fluid"
                                                width="300" style="margin: 0 auto; display: block;">
                                            <p class="mt-3 text-muted"> No Reclamations Found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                        </table>
                    </div>
             
                </div>
            </div>
        </div>

    
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {
            $('#id_service').select2({
                dropdownParent: $('#add-contact'),
               
            });
        });

        $(function(e) {
            $('#createReclamations').click(function(e) {
                var idlead = $('#n_lead').val();
                var reclamation = $('#note').val();
                var role = $('#id_service').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('reclamations.store') }}',
                    cache: false,
                    data: {
                        id: idlead,
                        reclamation: reclamation,
                        role: role,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.',
                                'Reclamation Has been Addess Success!', {
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

        $(function(e) {
            $('#deletesheet').click(function(e) {
                var id = $(this).data('id');
                if (confirm("Are you sure, you want to Delete Sheet?")) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('reclamations.delete') }}',
                        cache: false,
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.', 'Sheet Has been Deleted Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                            }
                            location.reload();
                        }
                    });
                }
            });
        });
        $(function() {
            $('body').on('click', '.editProduct', function() {
                var sheet_id = $(this).data('id');
                //console.log(product_id);
                $.get("{{ route('reclamations.index') }}" + '/' + sheet_id + '/edit', function(data) {
                    //console.log(product_id);
                    $('#editsheet').modal('show');
                    $('#sheet_id').val(data.id);
                    $('#Reclamations_name').val(data.sheetname);
                    $('#sheetid').val(data.sheetid);
                });
            });
        });

        $('body').on('change', '.myform', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var statuu = '#statu_con' + id;
            var status = $(statuu).val();
            //console.log(id);
            $.ajax({
                type: "POST",
                url: '{{ route('reclamations.statuscon') }}',
                cache: false,
                data: {
                    id: id,
                    status: status,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success == true) {
                        toastr.success('Good Job.', 'Reclamation Has been Update Success!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }
                }
            });
        });
    </script>
@endsection
