@extends('backend.layouts.app')
@section('content')
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
                    <div class="col-9 align-self-center">
                        <h3 class="page-title">Orders</h3>

                    </div>
                    <form class="row col-3">
                        <div class="col-8 align-self-center">
                            <div class='input-group mb-3'>
                                <input type='text' name="date" class="form-control dated" />
                            </div>
                        </div>
                        <div class="col-4 align-self-center">
                            <div class='input-group mb-3'>
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </div>
                    </form>

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
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search" id="search"
                                                    placeholder="Ref , Name Customer , Phone , Price" aria-label=""
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-sm-12">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button"
                                                    onclick="toggleText()">Multi</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="form-group  mt-3">
                                <form>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 m-b-20">
                                            <input type="text" class="form-control" id="search_ref" name="ref"
                                                placeholder="Ref">
                                        </div>
                                        <div class="col-md-3 col-sm-12 m-b-20">
                                            <input type="text" class="form-control" name="customer"
                                                placeholder="Customer Name">
                                        </div>
                                        <div class="col-md-3 col-sm-12 m-b-20">
                                            <input type="text" class="form-control" name="phone1" placeholder="Phone ">
                                        </div>
                                        <div class="col-md-3 col-sm-12 m-b-20">
                                            <select class="form-control" name="livraison[]">
                                                <option value="unpacked">Unpacked</option>
                                                <option value="picking process">Picking Process</option>
                                                <option value="item packed">Item Packed</option>
                                                <option value="shipped">Shipped</option>
                                                <option value="in transit">In Transit</option>
                                                <option value="in delivery">In Delivery</option>
                                                <option value="proseccing">Processing</option>
                                                <option value="delivered">Delivered</option>
                                                <option value="incident">Incident</option>
                                                <option value="rejected">Rejected</option>
                                                <option value="returned">Returned</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-12 m-b-20">
                                            <select class="form-control" name="payment" >
                                                <option value=" ">Status Payment</option>
                                                <option value="no paid">Not Paid</option>
                                                <option value="paid">Paid</option>
                                                <option value="prepaid">Prepaid</option>
                                            </select>
                                        </div>
                                        <div class="col-3 align-self-center">
                                            <div class='input-group mb-3'>
                                                <input type='text' name="date" value=" "
                                                    class="form-control dated" id="timeseconds" />
                                            </div>
                                        </div>
                                        <div class="col-2 align-self-center">
                                            <div class="form-group mb-0">
                                                <button type="submit"
                                                    class="btn btn-primary waves-effect btn-rounded m-t-10 mb-2 "
                                                    style="width:100%">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-2 align-self-center">
                                            <div class="form-group mb-0">
                                                <button id="exportss2"
                                                    class="btn btn-primary btn-rounded m-t-10 mb-2 ">Export</button>
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
                                                </div>
                                            </th>
                                            <th>NLead</th>
                                            <th>Name Customer</th>
                                            <th>City</th>
                                            <th>Total Payment</th>
                                            <th>Status Payment</th>
                                        </tr>
                                    </thead>
                                    <tbody class="alldata">
                                        <?php
                                        $counter = 1;
                                        ?>
                                        @foreach ($leads as $v_lead)
                                            <tr class="accordion-toggle data-item" data-id="{{ $v_lead->id }}">
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="ids"
                                                            class="custom-control-input checkBoxClass"
                                                            value="{{ $v_lead->Id }}" id="pid-{{ $counter }}">
                                                        <label class="custom-control-label"
                                                            for="pid-{{ $counter }}"></label>
                                                    </div>
                                                </td>
                                                <td>{{ $v_lead->Lead }}</td>
                                                <td>{{ $v_lead->name }}</td>
                                                <td>{{ $v_lead->city }}</td>
                                                <td>{{ $v_lead->Value }}</td>
                                                <td>{{ $v_lead->payment }}</td>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
                $.ajax({
                    type: 'POST',
                    url: '{{ route('payment.paied') }}',
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
                    }
                });
            });
            //export date
            $('#exportss2').click(function(e) {
                e.preventDefault();
                var allids = [];
                $("input:checkbox[name=ids]:checked").each(function() {
                    allids.push($(this).val());
                });
                var date = $('#timeseconds').val();
                var id = {{ $id }};
                $.ajax({
                    type: 'POST',
                    url: '{{ route('leads.export2') }}',
                    cache: false,
                    data: {
                        date: date,
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response, leads) {
                        $.each(response, function(key, val, leads) {
                            var a = response;
                            window.location = ('/leads/export-download2/' + a);
                        });
                    }
                });
            });
        });

        function toggleText() {
            var x = document.getElementById("multi");
            $('#timeseconds').val('');
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
@endsection
