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
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
           
                <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-8 align-self-center ">
                            <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                    class="text-muted fw-light">Dashboard /</span> Invoices&nbsp;

                            </h4>
                        </div>
                        <div class="col-5 align-self-center">
                            <h4 class="page-title">Total Amount : {{ $invoices->sum('amount') }} / Amount Paid :
                                {{ $invoices->where('status', 'paid')->sum('amount') }}</h4>
                        </div>
                    </div>
                </div>

                
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <form>
                                            <div class="row">
                                                <div class="col-md-11 col-sm-12">
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="search"
                                                            id="search" placeholder="Ref , Price" aria-label=""
                                                            aria-describedby="basic-addon1">
                                                    </div>
                                                </div>
                                                <div class="col-md-1 col-sm-12">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" style="line-height: 20.05px;"
                                                            type="submit">Search</button>
                                                        <button class="btn bg-white" type="button" id="down"
                                                            onclick="toggleText()"><i class="mdi mdi-arrow-down-drop-circle"
                                                                style="font-size: 34px;color: #822685;line-height: 20.05px;"></i></button>
                                                        <button class="btn bg-white" type="button" id="up"
                                                            onclick="toggleText2()"><i class="mdi mdi-arrow-up-drop-circle"
                                                                style="font-size: 34px;color: #822685;line-height: 20.05px;"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="form-group multi" id="multi" style="display:none;margin-top: 20px;">
                                        <form style="display: table;margin-left: auto;margin-right: auto;">
                                            <div class="row">
                                                <div class="col-md-3 col-sm-12 m-b-20">
                                                    <input type="text" class="form-control" id="search_ref"
                                                        name="ref" placeholder="Ref">
                                                </div>
                                                <div class="col-md-3 col-sm-12 m-b-20">
                                                    <input type="text" class="form-control" name="customer"
                                                        placeholder="Customer Name">
                                                </div>
                                                <div class="col-md-3 col-sm-12 m-b-20">
                                                    <select class="form-control" name="payment"
                                                        placeholder="Status Confirmation" style="width: 100%;height: 36px;">
                                                        <option value="">Status Payment</option>
                                                        <option value="Processing">Processing</option>
                                                        <option value="paid ">Paid </option>
                                                    </select>
                                                </div>
                                                <div class="col-3 align-self-center">
                                                    <div class='input-group mb-3'>
                                                        <input type='text' name="date"
                                                            class="form-control timeseconds" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <span class="ti-calendar"></span>
                                                            </span>
                                                        </div>
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
                                    <div class="form-group mb-2 text-right">
                                        <a type="button"
                                            class="btn btn-primary btn-rounded waves-effect waves-light text-white"
                                            id="export">Export</a>
                                        <a type="button"
                                            class="btn btn-primary btn-rounded waves-effect waves-light text-white"
                                            id="paid">Paid Invoice</a>
                                        <a type="button"
                                            class="btn btn-primary btn-rounded waves-effect waves-light text-white"
                                            id="downloadpdf">Download Invoice</a>
                                    </div>
                                    <div class="table-responsive mt-4">
                                        <table id=""
                                            class="table table-bordered table-striped table-hover contact-list"
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
                                                    <th>Customer</th>
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
                                                                    value="{{ $v_invoice->id }}"
                                                                    id="pid-{{ $counter }}">
                                                                <label class="custom-control-label"
                                                                    for="pid-{{ $counter }}"></label>
                                                            </div>
                                                        </td>
                                                        <td>{{ $v_invoice->ref }}</td>
                                                        <td>
                                                            @foreach ($v_invoice['leadinvoice'] ?? [] as $leadinvoice)
                                                                @foreach ($leadinvoice['Lead'] ?? [] as $lead)
                                                                    @foreach ($lead['leadbyvendor'] ?? [] as $v_customer)
                                                                        @if($loop->iteration < 2)
                                                                            {{ $v_customer->name }}
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                            @endforeach
                                                            {{-- @foreach ($v_invoice['leadinvoice'][0]['Lead'][0]['leadbyvendor'] as $v_customer)
                                                    {{ $v_customer->name }}
                                                    @endforeach --}}
                                                        </td>
                                                        <td>
                                                            {{ $v_invoice['leadinvoice']->count() }}
                                                        </td>
                                                        <td>{{ $v_invoice->date_payment }}</td>
                                                        <td>
                                                            {{ number_format((float) $v_invoice->amount, 2) }}
                                                        </td>
                                                        <td>
                                                            @if ($v_invoice->status == 'active')
                                                                <span class="badge bg-success">active</span>                                                           
                                                            @else
                                                                <span class="badge bg-danger">Unpaid</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('invoicesaffiliate.print', $v_invoice->id) }}"
                                                                class="text-inverse pr-2" data-toggle="tooltip"
                                                                title="Print"><i class="ti ti-printer"></i></a>
                                                            {{-- <a href="{{ route('invoicesaffiliate.downloadInvoice', $v_invoice->id) }}"
                                                                    class="text-inverse pr-2" data-toggle="tooltip"
                                                                    title="Print"><i class="ti ti-download"></i></a> --}}
                                                            @if ($v_invoice->status != 'paid')
                                                                <a href="{{ route('invoices.delete', $v_invoice->id) }}"
                                                                    class="text-inverse pr-2" data-toggle="tooltip"
                                                                    title="Deleted"><i class="mdi mdi-delete"></i></a>
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
            <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
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
                    url: '{{ route('invoicesaffiliate.paied') }}',
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
            $('#downloadpdf').click(function(e) {
                e.preventDefault();
                var allids = [];
                $("input:checkbox[name=ids]:checked").each(function() {
                    allids.push($(this).val());
                });
                alert('Continue ...');
                $.ajax({
                    type: 'GET',
                    url: '{{ route('invoicesaffiliate.downloadInvoice') }}',
                    cache: false,
                    data: {
                        ids: allids,
                    },
                    xhrFields: {
                         responseType: 'blob'
                    },
                    
                    success: function(response) {
                        var blob = new Blob([response]);
                        var link  = document.createElement('a');
                        link.href  = window.URL.createObjectURL(blob);
                        link.download  = 'sample.zip';
                        link.click();                    
                    },
                    error: function(blob){
                     console.log(blob);
                    }
                });
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
