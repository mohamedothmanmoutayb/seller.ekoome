@extends('backend.layouts.app')
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .hiddenRow {
            padding: 0 !important;
        }
    </style>
    @if (Auth::user()->id_role != '3')
        <style>
            .multi {
                display: none;
            }
        </style>
    @endif
    <!-- ============================================================== -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-6 align-self-center">
                        <h3 class="page-title">Situation Customer</h3>
                        <!-- <div class="form-group text-left">
                            <select id="pagination" class="form-select" style="width: 90px">
                                <option value="100" @if ($items == 100) selected @endif>100</option>
                                <option value="250" @if ($items == 250) selected @endif>250</option>
                                <option value="500" @if ($items == 500) selected @endif>500</option>
                                <option value="900" @if ($items == 900) selected @endif>900</option>
                            </select>
                        </div> -->
                    </div>
                    <div class="col-6">
                        <div class="form-group text-right">
                            <a type="button" class="btn btn-primary btn-rounded waves-effect waves-light text-white " data-bs-toggle="modal" data-bs-target="#orderpaid">Paid Old Order</a>
                            <a type="button" class="btn btn-primary btn-rounded text-white" id="paymentwithout">Paid Order Without invoice</a>
                            <a type="button" class="btn btn-primary btn-rounded text-white" data-bs-toggle="modal" data-bs-target="#add-contact">Paid Order Selected</a>
                        </div>
                    </div>

                </div>
            </div>
            <div id="orderpaid" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Upload Old Tracking Numbre</h4>
                          
                        </div>
                        <form action="{{ route('payment.oldtrackingnumber')}}" method="post" enctype="multipart/form-data">
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
            <div class="row">
                <div class="col-12">
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <form>
                                    <div class="row">
                                        <div class="col-md-11 col-sm-12">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" name="search" id="search"
                                                    placeholder="Ref , Price" aria-label=""
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-sm-12">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"
                                                   >Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Page Content -->


            <!-- Add Contact Popup Model -->
            <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Paid Order Selected</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row">
                                    <input type='text' name="ref" id="ref" placeholder="Ref Invoice" value="{{$ref}}" class="form-control">
                                </div>
                                <div class="row mt-2">
                                    <input type='text' name="storage" id="storage" placeholder="Storage"
                                        class="form-control">
                                </div>
                                <div class="row mt-2">
                                    <input type='text' name="date" id="date" value=" " class="form-control" >
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light"
                                id="paid">Paid</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-12">
                    <!-- Column -->
                    <div class="card">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <div class="flex-grow-1">
                                        <p class="square-after f-w-600  dropdown-toggle show" type="button" id="btnGroupDrop1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Select Action<i class="fa fa-circle"></i></p>
                                        
                                    </div>
                                    <div class="setting-list">
                                    </div>
                                </div>
                            </div>
                        <div class="card-body">
                            <div class="table-responsive theme-scrollbar h-200" style="min-height:600px">
                                <table class="table table-bordernone">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="selectall custom-control-input"
                                                        id="chkCheckAll" required>
                                                    <label class="custom-control-label" for="chkCheckAll"></label>
                                                </div>
                                            </th>
                                            <th>NLead</th>
                                            <th>Name Customer</th>
                                            <th>Status Livrison</th>
                                            <th>Status Payment</th>
                                            <th>Total Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody class="alldata">
                                        <?php
                                        $counter = 1;
                                        ?>
                                        @foreach ($leads as $v_lead)
                                            <tr class="accordion-toggle data-item" data-id="{{ $v_lead->Id }}">
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        @if ($v_lead->payment == 'paid')
                                                            <?php $sta = 'disabled'; ?>
                                                        @else
                                                            <?php $sta = ''; ?>
                                                        @endif
                                                        <input type="checkbox" name="ids"
                                                            class="custom-control-input checkBoxClass"
                                                            value="{{ $v_lead->Id }}" {{ $sta }}
                                                            id="pid-{{ $counter }}">
                                                        <label class="custom-control-label"
                                                            for="pid-{{ $counter }}"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $v_lead->Lead }}</td>
                                                <td>{{ $v_lead->name }}</td>
                                                <td>{{ $v_lead->livrison }}</td>
                                                <td>{{ $v_lead->payment }}</td>
                                                <td>{{ $v_lead->Value }} {{ $countri->currency }}</td>
                                            </tr>
                                            <?php $counter = $counter + 1; ?>
                                        @endforeach
                                    </tbody>
                                    <tbody id="contentdata" class="datasearch"></tbody>
                                    {{ $leads->withQueryString()->links('vendor.pagination.courier') }}
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
    <!-- End Page wrapper  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript">
        $(function(e) {
            $("#chkCheckAll").click(function() {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });
            $('#paid').click(function(e){
                e.preventDefault();
                var allids = [];
                $("input:checkbox[name=ids]:checked").each(function(){
                    allids.push($(this).val());
                });
                var date = $('#date').val();
                var storage = $('#storage').val();
                var ref = $('#ref').val();
                if(confirm("Are you sure you  want to paid orders" )){
                    $.ajax({
                        type : 'POST',
                        url:'{{ route('customers.paied')}}',
                        cache: false,
                        data:{
                            ids: allids,
                            date: date,
                            storage : storage,
                            ref : ref,
                            _token : '{{ csrf_token() }}'
                        },
                        success:function(response){
                            if(response.success == true){
                                toastr.success('Good Job.', 'Orders Has been Paied Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                            }
                            if(response.error == false){
                                toastr.error('Oppps.', 'Fess Customer Not Added!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                            }
                        }
                    });
                }
            });
            $('#paymentwithout').click(function(e) {
                e.preventDefault();
                var allids = [];
                $("input:checkbox[name=ids]:checked").each(function() {
                    allids.push($(this).val());
                });
                if (confirm("Are you sure you  want to paid orders")) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('payment.paidwithout') }}',
                        cache: false,
                        data: {
                            ids: allids,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.', 'Orders Has been Paied Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                            }
                            if (response.error == false) {
                                toastr.error('Oppps.', 'Fess Customer Not Added!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                            }
                        }
                    });
                }

            });
        });
    </script>
    <script>
        $(function() {
            // Initialize the date range picker
            $('input[name="date"]').daterangepicker();
           
            // Update the input field when a date range is selected
            $('input[name="date"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });
    
            // Clear the input field when the user clicks "Clear"
            $('input[name="date"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
    <script>
        document.getElementById('pagination').onchange = function() {
            if (window.location.href == "https://www.admin.ecomfulfilment.eu/customers/situation/") {
                //alert(window.location.href);
                window.location = window.location.href + "?&items=" + this.value;
            } else {
                window.location = window.location.href + "&items=" + this.value;
            }

        };
    </script>
@endsection
