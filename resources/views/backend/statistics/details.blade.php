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
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->


        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-xxl flex-grow-1 container-p-y">
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
                                                <select class="form-control" name="id_prod"
                                                    style="width: 100%;height: 36px;">
                                                    <option>Select Product</option>
                                                    @foreach ($products as $v_product)
                                                        <option value="{{ $v_product->id }}">{{ $v_product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1 col-sm-12">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row"
                                style="justify-content: space-between; align-content: space-around;align-items: center;">
                                <div class="form-group mt-2 text-left">
                                </div>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table id="" class="table table-bordered table-striped table-hover contact-list"
                                data-paging="true" data-paging-size="7">
                                <thead>
                                    <tr>
                                        <th>Products</th>
                                        <th>Leads</th>
                                        <th>Leads Confirmed</th>
                                        <th>Leads Delivered</th>
                                        <th>Leads Confirmed Rate</th>
                                        <th>Leads Delivered Rate</th>
                                        <th>Order Shipped</th>
                                        <th>Order Delivered</th>
                                        <th>Order Delivered Rate</th>
                                    </tr>
                                </thead>
                                <tbody class="alldata">
                                    <?php
                                    $counter = 0;
                                    ?>
                                    @foreach ($leads as $key => $v_lead)
                                        <tr class="accordion-toggle data-item">
                                            <td>
                                                {{ $v_lead[$counter]['name'] }}
                                            </td>
                                            <td>{{ $v_lead->where('id_product', $v_lead[$counter]['id'])->count() }}</td>
                                            <td>{{ $v_lead->where('id_product', $v_lead[$counter]['id'])->where('status_confirmation', 'confirmed')->count() }}
                                            </td>
                                            <td>{{ $v_lead->where('id_product', $v_lead[$counter]['id'])->where('status_livrison', 'delivered')->count() }}
                                            </td>
                                            <td>{{ round(($v_lead->where('id_product', $v_lead[$counter]['id'])->where('status_confirmation', 'confirmed')->count() /$v_lead->where('id_product', $v_lead[$counter]['id'])->whereIn('status_confirmation', ['confirmed', 'canceled'])->count()) *100,2) }}
                                                %</td>
                                            <td>{{ round(($v_lead->where('id_product', $v_lead[$counter]['id'])->where('status_livrison', 'delivered')->count() /$v_lead->where('id_product', $v_lead[$counter]['id'])->where('status_confirmation', 'confirmed')->count()) *100,2) }}
                                                %</td>
                                            <td>{{ $v_lead->where('id_product', $v_lead[$counter]['id'])->where('status_confirmation', 'confirmed')->where('status_livrison', 'shipped')->count() }}
                                            </td>
                                            <td>{{ $v_lead->where('id_product', $v_lead[$counter]['id'])->where('status_confirmation', 'confirmed')->where('status_livrison', 'delivered')->count() }}
                                            </td>
                                            <td>
                                                {{ round(($v_lead->where('id_product', $v_lead[$counter]['id'])->whereIn('status_livrison', ['delivered', 'canceled'])->count() /$v_lead->where('id_product', $v_lead[$counter]['id'])->where('status_livrison', 'delivered')->count()) *100,2) }}
                                                %
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
    <script type="text/javascript"></script>
@endsection
