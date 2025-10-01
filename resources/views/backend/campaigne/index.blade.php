@extends('backend.layouts.app')
@section('content')
            <div class="card card-body py-3">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-sm-flex align-items-center justify-space-between">
                            <h4 class="mb-4 mb-sm-0 card-title">ROI Simulator</h4>
                            <nav aria-label="breadcrumb" class="ms-auto">
                                <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a class="text-muted text-decoration-none d-flex" href="{{ route('home')}}">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                    </a>
                                </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row">
                <li class="nav-item">
                <a href="javascript:void(0)" onclick="toggleText()" class="nav-link gap-6 note-link d-flex align-items-center justify-content-center px-3 px-md-3 me-0 me-md-2 fs-11 active" id="all-category">
                    <i class="ti ti-list fill-white"></i>
                    <span class="d-none d-md-block fw-medium">Filter</span>
                </a>
                </li>
                <li class="nav-item ms-auto">
                    <a type="button" class="btn btn-primary btn-rounded my-1" href="{{ route('campaigne.create') }}">Generate Scenarios</a>
                </li>
                <div class="col-12 form-group multi mt-2" id="multi" >
                    <div class="form-group">
                        <form>
                            <div class="row">
                                <div class="col-md-10 col-sm-12">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="search"
                                            value="{{ request()->input('search') }}" placeholder="product,country"
                                            aria-label="" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <button class="btn btn-primary w-100" type="submit">Search </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </ul>

            <!-- Bordered Table -->
            <div class="card">
                <div class="card-body">
                    
                   
                    <div class="table-responsive theme-scrollbar" style="min-height: 400px;">
                        <table class="table table-bordernone">
                            <thead>
                                <tr>
                                    <th>*</th>
                                    <th>Product</th>
                                    <th>Profit</th>
                                    <th>Cost Product</th>
                                    <th>Price Sale</th>
                                    <th>Quantity</th>
                                    <th>Fees</th>
                                    <th>Cost ADs</th>
                                    <th>Confirmation Rate</th>
                                    <th>Delivery Rate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                ?>
                                @foreach ($campaignesData as $campaigne)
                                    <tr>
                                        <td>
                                            {{ $counter }}
                                        </td>
                                        <td>
                                            {{ $campaigne->product['name'] }}
                                        </td>
                                        <td>
                                            {{ $campaigne->result }}
                                        </td>
                                        <td>
                                            {{ $campaigne['cost_product'] }}
                                        </td>
                                        <td>
                                            {{ $campaigne['price_sale'] }}
                                        </td>
                                        <td>
                                            {{ $campaigne['quantity'] }}
                                        </td>
                                        <td>
                                            {{ $campaigne['fees'] }}
                                        </td>
                                        <td>
                                            {{ $campaigne['cost_ad'] }}
                                        </td>
                                        <td>
                                            {{ $campaigne['confirmation_rate'] }}
                                        </td>
                                        <td>
                                            {{ $campaigne['delivery_rate'] }}
                                        </td>

                                        <td>
                                            <a href="{{ route('campaigne.view', $campaigne->id) }}"
                                                class="btn btn-primary btn-rounded m-t-10 mb-2 text-white"
                                                style="font-size: 14px">View Scenarios <i
                                                    class="menu-icon mx-2  ti ti-eye"></i></a>
                                        </td>

                                    </tr>
                                    <?php
                                    $counter++;
                                    ?>
                                @endforeach
                            </tbody>
                            <tbody id="contentdata" class="datasearch"></tbody>
                        </table>
                        {{-- <span>Total requests : {{ $requests->total()}}</span> --}}
                        <br>
                        {{ $campaignesData->withQueryString()->links('vendor.pagination.courier') }}
                    </div>
                </div>
            </div>
            <!--/ Bordered Table -->

    <style>
        .label-process {
            background-color: #ff6334;
        }
    </style>

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script type='text/javascript'>
        $("#search").keyup(function() {
            $value = $(this).val();
            if ($value) {
                $('.alldata').hide();
                $('.datasearch').show();
            } else {
                $('.alldata').show();
                $('.datasearch').hide();
            }
            $.ajax({
                type: 'get',
                url: '{{ route('leads.search') }}',
                data: {
                    'search': $value,
                },
                success: function(data) {
                    $('#contentdata').html(data);
                }
            });
        });
        $(document).ready(function() {

            // Department Change
            $('#id_cit').change(function() {

                // Department id
                var id = $(this).val();

                // Empty the dropdown
                $('#id_zone').find('option').not(':first').remove();
                //console.log(id);
                // AJAX request 
                $.ajax({
                    url: 'zone/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {

                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].name;

                                var option = "<option value='" + id + "'>" + name + "</option>";

                                $("#id_zone").append(option);
                            }
                        }

                    }
                });
            });
            // Department Change
            $('#id_cityy').change(function() {

                // Department id
                var id = $(this).val();

                // Empty the dropdown
                $('#id_zonee').find('option').not(':first').remove();
                //console.log(id);
                // AJAX request 
                $.ajax({
                    url: 'zone/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {

                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].name;

                                var option = "<option value='" + id + "'>" + name + "</option>";

                                $("#id_zonee").append(option);
                            }
                        }

                    }
                });
            });
            // Department Change
            $('#id_city').change(function() {

                // Department id
                var id = $("#id_city").val();

                // Empty the dropdown
                $('#id_zonee').find('option').not(':first').remove();
                //console.log(id);
                // AJAX request 
                $.ajax({
                    url: 'zone/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {

                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].name;

                                var option = "<option value='" + id + "'>" + name + "</option>";

                                $("#id_zonee").append(option);
                            }
                        }

                    }
                });
            });
            // Department Change
            $('#id_citys').change(function() {
                // Department id
                var id = $("#id_citys").val();

                // Empty the dropdown
                $('#id_zones').find('option').not(':first').remove();
                //console.log(id);
                // AJAX request 
                $.ajax({
                    url: 'zone/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {

                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].name;

                                var option = "<option value='" + id + "'>" + name + "</option>";

                                $("#id_zones").append(option);
                            }
                        }

                    }
                });
            });

        });

        $(function(e) {
            $("#chkCheckAll").click(function() {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });
        });
    </script>
    <script type="text/javascript">
        $(function(e) {
            $("#chkCheckAll").click(function() {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            });
            $('#exportss').click(function(e) {
                e.preventDefault();
                var allids = [];
                $("input:checkbox[name=ids]:checked").each(function() {
                    allids.push($(this).val());
                });
                if (allids != '') {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('leads.export') }}',
                        cache: false,
                        data: {
                            ids: allids,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response, leads) {
                            $.each(allids, function(key, val, leads) {
                                var a = JSON.stringify(allids);
                                window.location = ('leads/export-download/' + a);
                            });
                        }
                    });
                } else {
                    toastr.warning('Opss.', 'Please Selected Leads!', {
                        "showMethod": "slideDown",
                        "hideMethod": "slideUp",
                        timeOut: 2000
                    });
                }
            });
        });



        $(function() {

            $('body').on('click', '#multi', function() {
                $('.multi').show();
            });
        });


        $(document).ready(function() {
            $('#Delivery').multiselect({
                nonSelectedText: 'Select Framework',
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                buttonWidth: '400px'
            });

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example-getting-started').multiselect();
        });
    </script>
@endsection
@endsection
