@extends('backend.layouts.app')
@section('content')
    <style>
        .label-process {
            background-color: #ff6334;
        }

        #up {
            display: none;
        }
    </style>
        <div class="container-xxl flex-grow-1 container-p-y">

            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-8 align-self-center ">
                        <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                class="text-muted fw-light">Dashboard /</span> Invoices&nbsp;
                            <select id="pagination" class="form-control" style="width: 80px">
                                <option value="20" @if ($items == 20) selected @endif>20</option>
                                <option value="50" @if ($items == 50) selected @endif>50</option>
                                <option value="100" @if ($items == 100) selected @endif>100</option>
                                <option value="250" @if ($items == 250) selected @endif>250</option>
                                <option value="500" @if ($items == 500) selected @endif>500</option>
                            </select>
                        </h4>
                    </div>
                    <div class="col-5 align-self-center">
                        <h6 class="page-title">Total Amount : {{ $invoices->sum('amount') }} / Amount Paid :
                            {{ $invoices->where('status', 'paid')->sum('amount') }}</h4>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <form action="" method="GET">
                                    <div class="row">
                                        <div class="col-md-11 col-sm-12">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" name="search" id="search"
                                                    placeholder="Ref,Status,Customer Name" aria-label=""
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-sm-12">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" style="line-height: 20.05px;"
                                                    type="submit">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="form-group multi">
                                <form class="col-12" style="display: table;margin-left: auto;margin-right: auto;">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 m-b-20">
                                            <input type="text" class="form-control" id="search_ref" name="ref"
                                                placeholder="Ref">
                                        </div>
                                        <div class="col-6 align-self-center">
                                            <div class='input-group mb-3'>
                                                <input type='text' name="date"  class="form-control dated" value="{{ request()->input('date') }}" id="flatpickr-range"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6 align-self-center">
                                            <div class="form-group mb-0 text-right">
                                                <button type="submit" class="btn btn-primary waves-effect"
                                                    style="width:100%">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-6 align-self-center">
                                            <div class="form-group mb-0 text-right">
                                                <a href="{{ route('invoices.index') }}" class="btn btn-primary waves-effect btn-rounded m-t-10 mb-2 " style="width:100%">Reset</a>
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
            <!-- ============================================================== -->
            <div class="row mt-4">
                <div class="col-12">
                    <!-- Column -->
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="table-responsive mt-4">
                                <table id="" class="table table-bordered table-striped table-hover contact-list"
                                    data-paging="true" data-paging-size="7">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="selectall custom-control-input"
                                                        id="chkCheckAll" required>
                                                    <label class="custom-control-label" for="chkCheckAll"></label>
                                                </div>
                                            </th>
                                            <th>Ref</th>
                                            {{-- <th>Customer</th> --}}
                                            <th>Nb Orders</th>
                                            <th>Date Payment</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="alldata">
                                        <?php
                                        $counter = 1;
                                        ?>
                                        @foreach ($invoices as $v_invoice)
                                            <tr class="accordion-toggle data-item" data-id="{{ $v_invoice->id }}">
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="ids"
                                                            class="custom-control-input checkBoxClass"
                                                            value="{{ $v_invoice->id }}" id="pid-{{ $counter }}">
                                                        <label class="custom-control-label"
                                                            for="pid-{{ $counter }}"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $v_invoice->reference_fiscale }}</td>
                                                {{-- <td>
                                                    @if (!empty($v_invoice['seller']))
                                                        {{ $v_invoice['seller']->name }}
                                                    @endif
                                                </td> --}}
                                                <td>
                                                    {{ $v_invoice['leadinvoice']->count() }}
                                                </td>
                                                <td>{{ $v_invoice->date_payment }}</td>
                                                <td>
                                                    {{ number_format((float) $v_invoice->amount, 2) }}
                                                </td>
                                                <td>
                                                    @if ($v_invoice->status == 'paid')
                                                        <span class="badge bg-success">paid</span>
                                                    @else
                                                        <span class="badge bg-danger">Unpaid</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('invoices.print', $v_invoice->id) }}"
                                                        class="text-warning pr-2" data-toggle="tooltip" title="Print"><svg  xmlns="http://www.w3.org/2000/svg"  width="22"  height="22"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg></a>
                                                    <a href="{{ route('invoices.printfiscal', $v_invoice->id) }}"
                                                                class="text-success pr-2" data-toggle="tooltip"
                                                                title="Print Fiscal"><svg  xmlns="http://www.w3.org/2000/svg"  width="22"  height="22"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-dollar"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M14 11h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" /><path d="M12 17v1m0 -8v1" /></svg></a>
                                                    <a data-id="{{ $v_invoice->id }}" class="text-inverse pr-2 update"
                                                        data-toggle="tooltip" title="Update ref"><svg  xmlns="http://www.w3.org/2000/svg"  width="22"  height="22"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></a>
                                                    @if($v_invoice['leadinvoice']->count() == 0)
                                                    @if($v_invoice->is_active == 1)
                                                    <a href="{{ route('invoices.inactive', $v_invoice->id)}}" class="text-success pr-2" data-toggle="tooltip" title="Print Fiscal">
                                                        <i class="fa-regular fa-eye-slash"></i>
                                                    </a>
                                                    @else
                                                    <a href="{{ route('invoices.active', $v_invoice->id)}}" class="text-success pr-2" data-toggle="tooltip" title="Print Fiscal">
                                                        <i class="fa-regular fa-eye"></i>
                                                    </a>
                                                    @endif
                                                    @endif
                                                    @if ($v_invoice->status != 'paid')
                                                            <a href="{{ route('invoices.delete', $v_invoice->id) }}"
                                                                class="text-danger pr-2" data-toggle="tooltip"
                                                                title="Deleted"><svg  xmlns="http://www.w3.org/2000/svg"  width="22"  height="22"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></a>
                                                    @endif
                                                </td>
                                            </tr>
                                            <?php $counter = $counter + 1; ?>
                                        @endforeach
                                    </tbody>
                                    <tbody id="contentdata" class="datasearch"></tbody>
                                </table>
                            </div>
                        </div>
                        {{ $invoices->withQueryString()->links('vendor.pagination.courier') }}
                    </div>
                </div>
            </div>
        </div>
    <div id="autherstatus" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Update Reference</h4>
                </div>
                <form class="form-horizontal form-material" action="{{ route('invoices.updateref') }}" method="post"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <h3></h3>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 m-b-20">
                                                <input type="hidden" class="form-control" name="invoice_id"
                                                    id="invoice_id">
                                                <input type="text" class="form-control" name="reference"
                                                    id="ref" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect ">Save</button>
                        <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="invoice" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <from class="form-horizontal">
                    <div class="modal-body">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 m-b-20">
                                                <select class="select2 form-control" id="seller" name="seller">
                                                    <option disabled selected>Select Seller</option>
                                                    @foreach ($sellers as $seller)
                                                        <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="submit" class="btn btn-info waves-effect" id="generate">Generate Invoice</button>
                        <button type="button" class="btn btn-primary waves-effect"
                            data-bs-dismiss="modal">Cancel</button>
                    </div>

                </from>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- ============================================================== -->
    
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->

    <style>
        .label-process {
            background-color: #ff6334;
        }

        #up {
            display: none;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
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
                $.ajax({
                    type: 'POST',
                    url: '{{ route('invoices.paied') }}',
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
                        location.reload();
                    }
                });
            });
            $('#export').click(function(e) {
                e.preventDefault();
                var allids = [];
                $("input:checkbox[name=ids]:checked").each(function() {
                    allids.push($(this).val());
                });
                $.ajax({
                    type: 'POST',
                    url: '{{ route('invoices.export') }}',
                    cache: false,
                    data: {
                        ids: allids,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response, invoices) {
                        $.each(allids, function(key, val, invoices) {
                            var a = JSON.stringify(allids);
                            window.location = ('invoices/export-download/' + a);
                        });
                    }
                });
            });
            $('.update').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#invoice_id').val(id);
                $('#autherstatus').modal('show');
            });
            $('#downloadpdf').click(function(e) {
                e.preventDefault();
                var allids = [];
                $("input:checkbox[name=ids]:checked").each(function() {
                    allids.push($(this).val());
                });
                alert('Continue ...');
                $.ajax({
                    type: 'GET',
                    url: '{{ route('invoices.downloadInvoice') }}',
                    cache: false,
                    data: {
                        ids: allids,
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },

                    success: function(response) {
                        var blob = new Blob([response]);
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'sample.zip';
                        link.click();
                    },
                    error: function(blob) {
                        console.log(blob);
                    }
                });
            });
            $('#addInvoice').click(function(e) {
                e.preventDefault();
                $('#invoice').modal('show');
            });
            $('#generate').click(function(e) {
                e.preventDefault();
                if ($('#seller').val() == 'Select Seller') {
                    toastr.error('Please Select Seller', 'Error', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });

                } else {

                    $.ajax({
                        url: "{{ route('customers.check') }}",
                        type: "GET",
                        data: {
                            user: $('#seller').val(),
                        },

                        success: function(response) {
                            // if (response.status === true) {

                                window.location = ('invoices/externel/' + $('#seller').val());

                            // }
                            // if (response.status === false) {
                            //     toastr.error('Error',
                            //         'Additional Informations not set for this seller!', {
                            //             "showMethod": "slideDown",
                            //             "hideMethod": "slideUp",
                            //             timeOut: 4000
                            //         });
                            // }
                        },
                    });

                }

            });
        });

        function toggleText() {
            var x = document.getElementById("multi");
            if (x.style.display === "none") {
                x.style.display = "block";
                document.getElementById('up').style.display = "block";
                document.getElementById('down').style.display = "none";
            }
        }

        function toggleText2() {
            var x = document.getElementById("multi");
            if (x.style.display === "block") {
                x.style.display = "none";
                document.getElementById('up').style.display = "none";
                document.getElementById('down').style.display = "block";
            }
        }
    </script>
@endsection
