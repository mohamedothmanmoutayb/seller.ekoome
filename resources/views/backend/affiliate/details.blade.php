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
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-8 align-self-center">
                        <h3 class="page-title"><span
                            class="text-muted fw-light">Affiliates /</span> Affiliate Situation </h3>
                        <div class="form-group mt-2 text-left">
                            <select id="pagination" class="form-control" style="width:90px">
                                <option value="100" @if ($items == 100) selected @endif>100</option>
                                <option value="250" @if ($items == 250) selected @endif>250</option>
                                <option value="500" @if ($items == 500) selected @endif>500</option>
                                <option value="900" @if ($items == 900) selected @endif>900</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group mb-0 text-right">
                            <a type="button" class="btn btn-primary btn-rounded my-2 text-white"
                                id="paymentwithout">Paid Order Without invoice</a>
                            <a type="button" class="btn btn-primary btn-rounded my-2 text-white"
                                data-bs-toggle="modal" data-bs-target="#add-contact">Paid Order Selected</a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- ============================================================== -->
            <div class="row my-4">
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
                                                <button class="btn btn-primary" type="button"
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="row text-center">
                                    {{-- <input type='text' name="storage" id="storage" placeholder="Storage"
                                        class="form-control"> --}}
                                       <center> Are  you sure you want to generate this invoice for orders selected ?</center>
                                </div>
                                <label for="">Transaction Date</label>
                                <div class="row">
                                    <input type='date' name="date" id="date" value=" "
                                        class="form-control" >
                                </div>
                              
                            </div>

                        </div>
                        <div class="modal-body">
                            <center>
                            <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light"
                                id="paid">Paid</button></center>
                        </div>
                        <div class="modal-footer">
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
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="" class="table table-bordered table-striped table-hover contact-list"
                                    data-paging="true" data-paging-size="7">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="selectall custom-control-input"
                                                        id="chkCheckAll" required>
                                                    <label class="custom-control-label" for="chkCheckAll"></label>
                                                    <input type="hidden" id="seller" value="{{ $id }}" />
                                                </div>
                                            </th>
                                            <th>NLead</th>
                                            <th>Name Customer</th>
                                            <th>Status Payment</th>
                                            <th>Total Payment</th>
                                            <th>Comission</th>
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
                                                <td>{{ $v_lead->payment }}</td>
                                                <td>{{ $v_lead->Value }} {{ $countri->currency }}</td>
                                                <td>{{ $v_lead->comission }} {{ $countri->currency }}</td>
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
   
        </div>

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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
    <script type="text/javascript">
        $(function(e) {
            $("#chkCheckAll").click(function() {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });
            $('#paid').click(function(e) {
                e.preventDefault();
                var allids = [];
                $("input:checkbox[name=ids]:checked").each(function() {
                    allids.push($(this).val());
                });
                var affiliate = $('#seller').val();
                var storage = $('#storage').val();
                var transaction = $('#date').val();
                if (confirm("Are you sure you  want to paid orders")) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('affiliates.paied') }}',
                        cache: false,
                        data: {
                            ids: allids,
                            seller: affiliate,
                            storage: storage,
                            transaction: transaction,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.', 'Orders Has been Paied Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                                window.location.reload();
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
        document.getElementById('pagination').onchange = function() {
            if (window.location.href == "https://www.admin.ecomfulfilment.eu/customers/situation/" +
                {{ $id }}) {
                //alert(window.location.href);
                window.location = window.location.href + "?&items=" + this.value;
            } else {
                window.location = window.location.href + "&items=" + this.value;
            }

        };
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
@endsection
