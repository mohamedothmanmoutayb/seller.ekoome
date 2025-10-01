@extends('backend.layouts.app')
@section('content')
    <style>
        #overlay {
            background: #ffffff;
            color: #666666;
            position: fixed;
            height: 100%;
            width: 100%;
            z-index: 5000;
            top: 0;
            left: 0;
            float: left;
            text-align: center;
            padding-top: 25%;
            opacity: .80;
        }

        .spinner {
            margin: 0 auto;
            height: 64px;
            width: 64px;
            animation: rotate 0.8s infinite linear;
            border: 5px solid firebrick;
            border-right-color: transparent;
            border-radius: 50%;
        }
    </style>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-6 align-self-center ">
                        <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                class="text-muted fw-light">Dashboard /</span> Provinces &nbsp;

                        </h4>
                    </div>
                    <div class="col-6 d-flex flex-row justify-content-end align-self-center">
                        <div class="form-group mb-0 text-right">
                            <div class="form-group mb-0 text-right">
                                <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#upload-province">Upload Province</button>
                                <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#add-province">Add New Province</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->

            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="form-group-2">
                                <form>
                                    <div class="row">
                                        <div class="col-md-11 col-sm-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search" id="search"
                                                    placeholder=" Provinces" aria-label="" aria-describedby="basic-addon1">
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
                            <!-- Add province Popup Model -->
                            <div id="add-province" class="modal fade in" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Add New Provinces</h4>
                                          <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <from class="form-horizontal form-material">
                                                <div class="form-group">

                                                    <div class="col-md-12 col-sm-12 m-b-20">
                                                        <select class="form-control" id="country">
                                                            <option value="">Select Country</option>
                                                            @foreach ($countries as $v_country)
                                                                <option value="{{ $v_country->id }}">{{ $v_country->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 m-b-20 mt-4">
                                                        <input type="text" class="form-control" id="province"
                                                            placeholder="province">
                                                    </div>
                                                </div>
                                            </from>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary waves-effect"
                                                id="saveprovince">Save</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- Add province Popup Model -->
                            <div id="upload-province" class="modal fade in" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Upload Provinces</h4>
                                            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('provinces.upload') }}" method="post"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="modal-body">
                                                <div class="form-group">

                                                    <div class="col-md-12 m-b-20 mt-4">
                                                        <select class="form-control" name="country">
                                                            <option value="">Select Country</option>
                                                            @foreach ($countries as $v_country)
                                                                <option value="{{ $v_country->id }}">{{ $v_country->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 m-b-20 mt-4"> 
                                                        <input type="file" class="form-control" name="csv_file"
                                                            id="csv_file" placeholder="province">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary waves-effect">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!---  -->
                            <!-- Add province Popup Model -->
                            <div id="update-province" class="modal fade in" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Update Provinces</h4>
                                            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <from class="form-horizontal form-material">
                                                <div class="form-group">

                                                    <div class="col-md-12 m-b-20 mt-4">
                                                        <input type="hidden" id="update_id" />
                                                        <input type="text" class="form-control" id="update_province"
                                                            placeholder="province">
                                                    </div>
                                                </div>
                                            </from>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary waves-effect"
                                                id="updaterovince">Save</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-subtitle"></h6>

                            <div class='row'>
                            <div class="form-group col-3 my-3 text-left">
                                <select id="pagination" class="form-control">
                                    <option value="10" @if ($items == 10) selected @endif>10</option>
                                    <option value="50" @if ($items == 50) selected @endif>50</option>
                                    <option value="100" @if ($items == 100) selected @endif>100</option>
                                    <option value="250" @if ($items == 250) selected @endif>250</option>
                                    <option value="500" @if ($items == 500) selected @endif>500</option>
                                    <option value="1000" @if ($items == 1000) selected @endif>1000</option>
                                </select>
                            </div>
                            </div>
                            <div class="table-responsive">
                                <table id="demo-foo-addrow" class="table table-bordered m-t-30 table-hover contact-list"
                                    data-paging="true" data-paging-size="7">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Country</th>
                                            <th>Created at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $counter = 1;
                                        ?>
                                        @foreach ($provinces as $v_province)
                                            <tr>
                                                <td>{{ $counter }}</td>
                                                <td>{{ $v_province->name }}</td>
                                                <td>
                                                    {{ $v_province['country']->name }}
                                                </td>
                                                <td>{{ $v_province->created_at }}</td>
                                                <td>
                                                    <a data-id="{{ $v_province->id }}" class="text-inverse deleted"
                                                        title="Delete" data-bs-toggle="tooltip"><i class="ti ti-trash"></i></a>
                                                    <a data-id="{{ $v_province->id }}" class="text-inverse edit"
                                                        title="edit" data-bs-toggle="tooltip"><i
                                                            class="ti ti-highlight"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                            $counter++;
                                            ?>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $provinces->withQueryString()->links('vendor.pagination.courier') }}
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
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- edit province Popup Model -->
    <div id="edit-province" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Update province</h4>
<button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <from class="form-horizontal form-material">
                        <div class="form-group">

                            <div class="col-md-12 col-sm-12 m-b-20" id="select_country">

                            </div>
                            <div class="col-md-12 m-b-20 mt-4">
                                <input type="text" class="form-control" id="citie" placeholder="province">
                            </div>
                        </div>
                    </from>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary waves-effect" id="editprovince">Save</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {

            $(function(e) {
                $('#saveprovince').click(function(e) {
                    var country = $('#country').val();
                    var province = $('#province').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('provinces.store') }}',
                        cache: false,
                        data: {
                            country: country,
                            province: province,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.',
                                    'province Has been Addess Success!', {
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
                $('#updaterovince').click(function(e) {
                    var id = $('#update_id').val();
                    var province = $('#update_province').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('provinces.update') }}',
                        cache: false,
                        data: {
                            id: id,
                            province: province,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job',
                                    'Province Has been Update Success!', {
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
                $('.deleted').click(function(e) {
                    var id = $(this).data('id');
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('provinces.delete') }}',
                        cache: false,
                        data: {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success == true) {
                                toastr.success('Good Job.',
                                    'province Has been Deleted Success!', {
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
                $('body').on('click', '.edit', function(products) {
                    var id = $(this).data('id');
                    $.get("{{ route('provinces.index') }}" + '/' + id + '/details', function(
                    data) {
                        $('#update-province').modal('show');

                        $('#update_id').val(id);
                        $('#update_province').val(data.name);

                    });
                });
            });
        });
    </script>

    <script>
        document.getElementById('pagination').onchange = function() {
            if (window.location.href == "https://www.admin.ecomfulfilment.eu/provinces") {
                //alert(window.location.href);
                window.location = window.location.href + "?&items=" + this.value;
            } else {
                window.location = window.location.href + "&items=" + this.value;
            }

        };
    </script>
@endsection
