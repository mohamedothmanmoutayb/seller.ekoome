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
    <div class="page-wrapper">
      
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- ============================================================== -->

            <!-- Start Page Content -->
            <div class="row my-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group-1">
                                <form>
                                    <div class="row">
                                        <div class="col-md-11 col-sm-12">
                                            <div class="input-group">
                                                <select class="select2 form-control custom-select"
                                                    style="width: 100%; height:36px;" name="product">
                                                    <option value=" ">Select Delivery</option>
                                                    @foreach ($users as $v_lead)
                                                        <option value="{{ $v_lead->id }}">{{ $v_lead->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-sm-12">
                                            <div class="input-group-append">
                                                <button class="btn btn-info" type="submit">Search</button>
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
                    <div class="card">
                        <div class="card-body">
                            <div class="row"
                                style="justify-content: space-between; align-content: space-around;align-items: center;    margin-bottom: 19px;">
                                <h4 class="page-title" style="font-size: 27px;">Analyses Delivery</h4>
                            </div>

                            <div class="table-responsive theme-scrollbar h-200" style="min-height:600px">
                                <table class="table table-bordernone">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>NB.Order Traits</th>
                                            <th>Delivered</th>
                                            <th>Unpacked</th>
                                            <th>canceled</th>
                                            <th>In Process</th>
                                            <th>Shipped</th>
                                            <th>Return</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $counter = 1; ?>
                                        @foreach ($agents as $items => $v_lead)
                                            <tr>
                                                <td>{{ $counter }}</td>
                                                <td>
                                                    {{ $v_lead['name'] }}
                                                </td>

                                                <td>
                                                    <div data-label="" class="css-bar m-b-0 css-bar-primary"><i
                                                            class=" text-info">
                                                            <?php
                                                            $nbr = 0;
                                                            foreach ($v_lead['leadlivreurs'] as $v_nbr) {
                                                                $nbr = $nbr + $v_nbr->count();
                                                            }
                                                            
                                                            ?>{{ $v_lead['leadlivreurs']->count() }}
                                                        </i></div>
                                                </td>

                                                <td>
                                                    <?php
                                                    $delivered = $v_lead['leadlivreurs']->where('status_livrison', 'delivered')->count();
                                                    if ($delivered != 0) {
                                                        $perdelivered = number_format(($delivered / $v_lead['leadlivreurs']->count()) * 100, 0);
                                                    } else {
                                                        $perdelivered = number_format($v_lead['leadlivreurs']->where('status_livrison', 'delivered')->count(), 0);
                                                    }
                                                    
                                                    ?>
                                                    <div id="chart2{{ $counter }}"
                                                        class="css-bar m-b-0 css-bar-primary"></div></br><span
                                                        class="text-center">Total : {{ $delivered }}</span>

                                                </td>
                                                <td>
                                                    <?php
                                                    $unpacked = $v_lead['leadlivreurs']->where('status_livrison', 'unpacked')->count();
                                                    if ($unpacked != 0) {
                                                        $perunpacked = number_format(($unpacked / $v_lead['leadlivreurs']->count()) * 100, 0);
                                                    } else {
                                                        $perunpacked = number_format($v_lead['leadlivreurs']->where('status_livrison', 'unpacked')->count(), 0);
                                                    }
                                                    
                                                    ?>
                                                    <div id="chart3{{ $counter }}"
                                                        class="css-bar m-b-0 css-bar-primary"></div></br><span
                                                        class="text-center">Total : {{ $unpacked }}</span>

                                                </td>
                                                <td>
                                                    <?php
                                                    $canceled = $v_lead['leadlivreurs']->where('status_livrison', 'canceled')->count();
                                                    if ($canceled != 0) {
                                                        $percanceled = number_format(($canceled / $v_lead['leadlivreurs']->count()) * 100, 0);
                                                    } else {
                                                        $percanceled = number_format($v_lead['leadlivreurs']->where('status_livrison', 'canceled')->count(), 0);
                                                    }
                                                    ?>
                                                    <div id="chart4{{ $counter }}"
                                                        class="css-bar m-b-0 css-bar-primary css-bar-20"></div></br><span
                                                        class="text-center">Total : {{ $canceled }}</span>
                                                </td>
                                                <td>
                                                    <?php
                                                    $process = $v_lead['leadlivreurs']->whereIn('status_livrison', ['no answer', 'postponed', 'ready to ship', '2nd delivery attempt', '3rd delivery attempt'])->count();
                                                    if ($process != 0) {
                                                        $perprocess = number_format(($process / $v_lead['leadlivreurs']->count()) * 100, 0);
                                                    } else {
                                                        $perprocess = number_format($v_lead['leadlivreurs']->whereIn('status_livrison', ['item packed', 'no answer', 'postponed', 'ready to ship', '2nd delivery attempt', '3rd delivery attempt'])->count(), 0);
                                                    }
                                                    
                                                    ?>
                                                    <div id="chart5{{ $counter }}"
                                                        class="css-bar m-b-0 css-bar-primary"></div></br><span
                                                        class="text-center">Total : {{ $process }}</span>

                                                </td>
                                                <td>
                                                    <?php
                                                    $shipped = $v_lead['leadlivreurs']->where('status_livrison', 'shipped')->count();
                                                    if ($shipped != 0) {
                                                        $pershipped = number_format(($shipped / $v_lead['leadlivreurs']->count()) * 100, 0);
                                                    } else {
                                                        $pershipped = number_format($v_lead['leadlivreurs']->where('status_livrison', 'shipped')->count(), 0);
                                                    }
                                                    
                                                    ?>
                                                    <div id="chart6{{ $counter }}"
                                                        class="css-bar m-b-0 css-bar-primary"></div></br><span
                                                        class="text-center">Total : {{ $shipped }}</span>

                                                </td>
                                                <td>
                                                    <?php
                                                    $return = $v_lead['leadlivreurs']->where('status_livrison', 'return')->count();
                                                    if ($return != 0) {
                                                        $perreturn = number_format(($return / $v_lead['leadlivreurs']->count()) * 100, 0);
                                                    } else {
                                                        $perreturn = number_format($v_lead['leadlivreurs']->where('status_livrison', 'return')->count(), 0);
                                                    }
                                                    
                                                    ?>
                                                    <div id="chart7{{ $counter }}"
                                                        class="css-bar m-b-0 css-bar-primary"></div></br><span
                                                        class="text-center">Total : {{ $return }}</span>

                                                </td>

                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-info" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            <i class="ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu animated slideInUp"
                                                            x-placement="bottom-start"
                                                            style="position: absolute; will-change: transform; transform: translate3d(0px, 35px, 0px);margin-left: -60px!important;">
                                                            <a class="dropdown-item" href=""><i
                                                                    class="mdi mdi-cards-variant"></i> Details</a>
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
        <!-- footer -->
        <!-- ============================================================== -->
        <div id="chart"></div>
          <!-- Footer -->
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
        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $('body').on('click', '.editProduct', function() {
                var product_id = $(this).data('id');
                //console.log(product_id);
                $.get("{{ route('products.index') }}" + '/' + product_id + '/edit', function(data) {
                    //console.log(product_id);
                    $('#edit_user').modal('show');
                    $('#product_id').val(data.id);
                    $('#product_nam').val(data.name);
                    $('#product_link').val(data.link);
                    $('#description_produc').val(data.description);
                });
            });
            $('body').on('click', '#multi', function() {
                $('.multi').show();
            })
        });


        $(function() {
            $('body').on('click', '.configupsel', function() {
                var product_id = $(this).data('id');
                //console.log(product_id);
                $('#config_upsel').modal('show');
                $('#upsel_product_id').val(product_id);

            });
        });



        $(document).ready(function() {
            $("#seller_name").select2({
                dropdownParent: $("#add-contac")
            });
        });
    </script>
    <style>
        .apexcharts-canvas {
            width: 150px !important;
            height: 90px !important;
        }

        td {
            text-align: center
        }

        .apexcharts-datalabel-value {
            display: none;
        }
    </style>
@endsection
