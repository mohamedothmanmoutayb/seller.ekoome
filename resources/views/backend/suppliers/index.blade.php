@extends('backend.layouts.app')
@section('content')
    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                        <i class="ti ti-arrow-left fs-5"></i> 
                    </a>
                    <h4 class="mb-4 mb-sm-0 card-title">Suppliers</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            {{-- <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex" href="{{ route('home') }}">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                                
                            </li> --}}

                            <li class="breadcrumb-item d-flex align-items-center">
                                <a href="javascript:void(0)" class="btn btn-primary d-flex align-items-center " data-bs-toggle="modal"
                                    data-bs-target="#add-manual">
                                    <i class="ti ti-plus fs-4"></i>
                                    <span class="d-none d-md-block fw-medium fs-3">Add New Supplier</span>
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div id="add-manual" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="height:auto !important;">
        <div class="modal-dialog" style="max-width: 720px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">New Supplier</h4>

                </div>
                <form action="{{ route('suppliers.store') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 my-2">
                                    <input type="text" class="form-control" name="name_supplier" placeholder="Name Supplier">
                                </div>
                                <div class="col-md-6 col-sm-12 my-2">
                                    <input type="text" class="form-control" name="mobile" placeholder="Mobile">
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 my-2">
                                <textarea type="text" class="form-control" name="address" placeholder="Address"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 my-2">
                                    <select class="form-control" name="type">
                                        <option value=" ">Select Type</option>
                                        <option value="individual" selected>Individual</option>
                                        <option value="company">Company</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary waves-effect">Save</button>
                        <button type="button" class="btn btn-primary waves-effect"
                            data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row">
        <li class="nav-item">
            <a href="javascript:void(0)" onclick="toggleText()"
                class="nav-link gap-6 note-link d-flex align-items-center justify-content-center px-3 px-md-3 me-0 me-md-2 fs-11 active"
                id="all-category">
                <i class="ti ti-list fill-white"></i>
                <span class="d-none d-md-block fw-medium">Filter</span>
            </a>
        </li>

        <div class="col-12 row form-group multi mt-2" id="multi">
            <form>
                <div class="row">
                    <div class="col-md-4 col-sm-12 m-b-20">
                        <input type="text" class="form-control" name="name" value="{{ request()->input('name') }}"
                            placeholder="Client Name">
                    </div>
                    <div class="col-md-4 col-sm-12 m-b-20">
                        <input type="text" class="form-control" name="phone" value="{{ request()->input('phone') }}"
                            placeholder="Phone">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4 align-self-center">
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary waves-effect btn-rounded m-t-10 mb-2"
                                style="width:100%">Search</button>
                        </div>
                    </div>
                    <div class="col-4 align-self-center">
                        <div class="form-group mb-0">
                            <a href="{{ route('clients.index') }}"
                                class="btn btn-primary waves-effect btn-rounded m-t-10 mb-2" style="width:100%">Reset</a>
                        </div>
                    </div>
                    <div class="col-4 align-self-center">
                        <div class="form-group mb-0">
                            <a href="{{ route('clients.export') }}"
                                class="btn btn-primary btn-rounded m-t-10 mb-2 text-white" style="width:100%">Export</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </ul>

    <!-- Clients Table -->
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <div class="flex-grow-1">
                    <select id="pagination" class="form-control" style="width:80px">
                        <option value="25" @if ($items == 25) selected @endif>25</option>
                        <option value="50" @if ($items == 50) selected @endif>50</option>
                        <option value="100" @if ($items == 100) selected @endif>100</option>
                        <option value="150" @if ($items == 150) selected @endif>150</option>
                        <option value="300" @if ($items == 300) selected @endif>300</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive border rounded-1">
                <table class="table text-nowrap customize-table mb-0 align-middle">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Revenue</th>
                            <th>Amount Not Paid</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($suppliers as $v_supplier)
                            <tr>
                                <td>{{ $v_supplier->id }}</td>
                                <td>{{ $v_supplier->name }}</td>
                                <td>{{ $v_supplier->phone }}</td>
                                <td>{{ $v_supplier->type }}</td>
                                <td>{{ $v_supplier->TotalPayment($v_supplier->id) }}</td>
                                <td>{{ $v_supplier->TotalDue($v_supplier->id)  }}</td>
                                <td>{{ $v_supplier->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('suppliers.details', $v_supplier->id) }}" class="btn btn-sm btn-info">
                                        <i class="ti ti-eye"></i> Details
                                    </a>
                                </td>
                            </tr>
                        @empty

                            <tr>
                                <td colspan="9" class="text-center">
                                    <img src="{{ asset('public/Empty-amico.svg') }}" width="300" class="img-fluid">
                                    <p class="mt-3">No Suppliers found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $suppliers->withQueryString()->links('vendor.pagination.courier') }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function toggleText() {
            var x = document.getElementById("multi");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }

        $('select[name="country"]').change(function() {
            var countryId = $(this).val();
            if (countryId) {
                $.ajax({
                    url: '/get-cities/' + countryId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="city"]').empty();
                        $('select[name="city"]').append('<option value="">Select City</option>');
                        $.each(data, function(key, value) {
                            $('select[name="city"]').append('<option value="' + key + '">' +
                                value + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="city"]').empty();
                $('select[name="city"]').append('<option value="">Select City</option>');
            }
        });

        document.getElementById('pagination').onchange = function() {
            window.location = window.location.href.split('?')[0] + "?items=" + this.value;
        };
    </script>
@endsection
