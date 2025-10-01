@extends('backend.layouts.app')
@section('content')
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="page-wrapper">
                <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-8 align-self-center ">
                            <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                    class="text-muted fw-light">Dashboard /</span> Shipping Companies&nbsp;

                            </h4>
                        </div>
                        <div class="col-4 d-flex justify-content-end">
                            <div class="form-group mb-0 text-right">
                                <!-- <a type="button" class="btn btn-info btn-rounded waves-effect waves-light text-white" id="paid">Paid Order Selected</a> -->
                                <a type="button"
                                    class="btn btn-primary btn-rounded waves-effect waves-light text-white my-2"
                                    data-bs-toggle="modal" data-bs-target="#add-contact">Add New Company</a>

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
                                        <div class="col-md-9 col-sm-12 ">
                                            <input type="text" class="form-control" name="name" placeholder="Name">
                                        </div>
                                        <div class="col-md-3 col-sm-12">
                                            <button type="submit" class="btn btn-primary waves-effect"
                                                style="width:100%">Search</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                                <!-- Add Contact Popup Model -->
                                <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Add New Company</h4>
                                                {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> --}}
                                            </div>
                                            <div class="modal-body">
                                                <from class="form-horizontal form-material">
                                                    <div class="form-group">
                                                        <!-- Primary -->
                                                        <div class="col-md-12 mb-4">
                                                            <div class="select2-primary">
                                                                <select id="select2Primary" class="select2 form-select"
                                                                    required multiple data-placeholder="Countries">
                                                                    <option>Select Countries</option>
                                                                    @foreach ($countries as $country)
                                                                        <option value="{{ $country->id }}">
                                                                            {{ $country->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <input type="text" class="form-control" id="name"
                                                                placeholder="Shipping company name" required>

                                                        </div>
                                                    </div>
                                                </from>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary waves-effect"
                                                    id="createsheets">Save</button>
                                                <button type="button" class="btn btn-primary waves-effect"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- Update Sheet Popup Model -->
                                <!-- Update Row Popup Model -->
                                <div id="sheetrow" class="modal fade in" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Update Company</h4>
                                            </div>
                                            <div class="modal-body">
                                                <from class="form-horizontal form-material">
                                                    <div class="form-group">
                                                        <div class="col-md-12 mb-4">
                                                            <div class="select2-primary">
                                                                <select id="select2Success" class="select2 form-select"
                                                                    required multiple data-placeholder="Countries">


                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <input type="text" class="form-control" id="company_name"
                                                                placeholder="Shipping company name" required>
                                                            <input type="hidden" class="form-control" id="company_id"
                                                                required>
                                                        </div>
                                                    </div>
                                                </from>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary waves-effect"
                                                    data-dismiss="modal" id="editsheets">Save</button>
                                                <button type="button" class="btn btn-primary waves-effect"
                                                    data-dismiss="modal">Cancel</button>
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
                        <div class="flex-grow-1">
                          <p class="square-after f-w-600">Our Total Sold<i class="fa fa-circle"></i></p>
                        </div>
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
                                <th>Name</th>
                                <th>Countries</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $counter = 1; ?>
                            @foreach ($companies as $v_company)
                            <tr>
                                <td>{{ $counter }}</td>
                                <td>{{ $v_company->name }}</td>
                                <td>
                                    @if ($v_company->countries)
                                    @foreach ($v_company->countries as $country)
                                    {!! $v_company->Country($country) !!}
                                    @endforeach
                                    @else
                                    <span class="badge bg-danger">No Countries assigned</span>
                                    @endif
                                </td>
                                <td>{{ $v_company->created_at }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle show" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="icon-settings"></i></button>
                                        <div class="dropdown-menu " bis_skin_checked="1" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(184px, -325.203px, 0px);" data-popper-placement="top-start">                          
                                            
                                            <a class="dropdown-item pr-2 editProduct" data-id="{{ $v_company->id }}" data-name="{{ $v_company->name }}" data-countries="{{ json_encode($v_company->Countries($v_company->countries)) }}" id="editProduct"> Edit</a>
                                            <a class="dropdown-item deletesheet" id="deletesheet" data-id="{{ $v_company->id }}"> Delete</a>
                                        </div>
                                        <button class="btn p-0" type="button" id="earningReports" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">                          
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php $counter++; ?>
                            @endforeach
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
        $(document).ready(function() {
            $('#select2Primary').select2({
                minimumResultsForSearch: -1,
                placeholder: function() {
                    $(this).data('placeholder');
                }
            });
        });
        $(function(e) {
            $('#createsheets').click(function(e) {

                var countries = $('#select2Primary').val();
                var name = $('#name').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('companies.store') }}',
                    cache: false,
                    data: {
                        countries: countries,
                        name: name,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.', 'Company Has been Addess Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            location.reload();
                        }
                        if (response.success == error) {
                            toastr.error('Error.', 'Name already Exist!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }

                    }
                });


            });
        });

        $(function(e) {
            $('.deletesheet').click(function(e) {
                var id = $(this).data('id');
                if (confirm("Are you sure, you want to Delete Sheet?")) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('companies.delete') }}',
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
                var id = $(this).data('id');
                var name = $(this).data('name');
                var countries = $(this).data('countries');
                //console.log(product_id);
                $('#sheetrow').modal('show');
                $('#company_id').val(id);
                $('#company_name').val(name);

                $('#select2Success').empty();
                for (var i = 0; i < countries.length; i++) {

                    $('#select2Success').append(countries[i]);
                }


            });
        });

        $(function(e) {
            $('#editsheets').click(function(e) {
                var id = $('#company_id').val();
                var name = $('#company_name').val();
                var countries = $('#select2Success').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('companies.update') }}',
                    cache: false,
                    data: {
                        id: id,
                        name: name,
                        countries: countries,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.', 'Sheet Has been Addess Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                            location.reload();
                        }

                    }
                });
            });
        });
    </script>
@endsection
