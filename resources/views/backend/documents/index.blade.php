@extends('backend.layouts.app')
@section('content')
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="content-wrapper">
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-9 align-self-center ">
                        <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                class="text-muted fw-light">Dashboard /</span> Documents &nbsp;
                            
                        </h4>
                    </div>
                    <div class="col-3 d-flex justify-content-end align-self-center">
                        <div class="form-group mb-0 text-right">
                            <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light configupsel"
                                id="configupsel">Add New Document</button>
                        </div>
                    </div>
                </div>
            </div>          
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-subtitle"></h6>

                            <div id="filter" class="modal fade in" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Search</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <from class="form-horizontal form-material">
                                                <div class="form-group">
                                                    <div class="col-md-12 m-b-20">
                                                        <input type="text" class="form-control" placeholder="Store Name">
                                                    </div>
                                                    <div class="col-md-12 m-b-20">
                                                        <input type="text" class="form-control" placeholder="Link">
                                                    </div>
                                                </div>
                                            </from>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary waves-effect"
                                                data-dismiss="modal">Search</button>
                                            <button type="button" class="btn btn-default waves-effect"
                                                data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <div class="table-responsive">
                                <table id="demo-foo-addrow" class="table table-bordered m-t-30 table-hover contact-list"
                                    data-paging="true" data-paging-size="7">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nmae</th>
                                            <th>Document</th>
                                            <th>Created at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($documents as $v_document)
                                            <tr>
                                                <td>1</td>
                                                <td>{{ $v_document->name }}</td>
                                                <td><a href="{{ $v_document->document }}"
                                                        download>{{ $v_document->document }}</a></td>
                                                <td>{{ $v_document->created_at }}</td>
                                            </tr>
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
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">
            All Rights Reserved by FULFILLEMENT ADMIN. Designed and Developed by <a href="Palace Agency.eu">Palace Agencyy</a>.
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <div id="config_upsel" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Add Document</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form class="form-horizontal form-material" action="{{ route('documents.store') }}" method="POST"
                    enctype="multipart/form-data" novalidate="novalidate">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-md-12 m-b-20">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                                <input type="hidden" name="id_seller" value="{{ $id }}" />
                            </div>
                            <div class="col-md-12 m-b-20">
                                <input type="file" class="form-control" name="document" id="document"
                                    placeholder="document">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect">Save</button>
                        <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script type="text/javascript">
        $(function(e) {
            $('#config').click(function(e) {
                var product = $('#upsel_product_id').val();
                var quantity = $('#upsel_quantity').val();
                var discount = $('#discount').val();
                var note = $('#note').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('products.upsel') }}',
                    cache: false,
                    data: {
                        product: product,
                        quantity: quantity,
                        discount: discount,
                        note: note,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job Product.',
                                'Upsell Has been Addess Success!', {
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
            $('#deleteupsel').click(function(e) {
                var id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: '{{ route('products.deleteupsells') }}',
                    cache: false,
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success == true) {
                            toastr.success('Good Job.', 'Upsell Has been Addess Success!', {
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
        $(function() {
            $('body').on('click', '.configupsel', function() {
                var product_id = $(this).data('id');
                //console.log(product_id);
                $('#config_upsel').modal('show');
                $('#upsel_product_id').val(product_id);

            });
        });
        $(function() {
            $('body').on('click', '.editProduct', function() {
                var product_id = $(this).data('id');
                //console.log(product_id);
                $.get("{{ route('products.index') }}" + '/' + product_id + '/upsells/edit', function(
                data) {
                    //console.log(product_id);
                    $('#config_upsel').modal('show');
                    $('#upsel_id').val(data.id);
                    $('#upsel_quantity').val(data.quantity);
                    $('#upsel_discount').val(data.discount);
                    $('#upsel_note').val(data.note);
                });
            });
        });
    </script>
@endsection
