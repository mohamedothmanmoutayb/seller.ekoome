
@extends('backend.layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="page-wrapper">

                <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                 <div class="d-sm-flex align-items-center justify-space-between">
                         <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                        <i class="ti ti-arrow-left fs-5"></i> 
                    </a>
                    <div>
                       <h4 class="mb-4 mb-sm-0 card-title">Shopify</h4>              
                    </div>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                  <button type="button"
                                class="btn btn-primary btn-rounded waves-effect waves-light text-white my-2"
                                data-bs-toggle="modal" data-bs-target="#add-shopify-modal">
                                Add New Shopify Store
                            </button>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive mt-4" style="min-height: 350px;">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Store Name</th>
                                            <th>Webhook URL</th>
                                            <th>Api Version</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($shopifyStores as $index => $store)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $store->store_name }}</td>
                                                <td>
                                                    {{ url('/webhook/shopify/' . $store->id) }}
                                                </td>
                                                <td>{{ $store->api_version }}</td>
                                                <td>
                                                    @if ($store->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-warning">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>{{ $store->created_at->format('Y-m-d H:i') }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="ti ti-settings"></i>
                                                        </button>
                                                        <div class="dropdown-menu animated slideInUp">
                                                            <a class="dropdown-item verify-webhook" href="#"
                                                                data-id="{{ $store->id }}">
                                                                <i class="ti ti-check"></i> Verify Webhook
                                                            </a>
                                                            <a class="dropdown-item delete-store" href="#"
                                                                data-id="{{ $store->id }}">
                                                                <i class="ti ti-trash"></i> Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7">
                                                    <img src="{{ asset('public/Empty-amico.svg') }}"
                                                        style="margin-left: auto; margin-right: auto; display: block;"
                                                        width="500" />
                                                    <p class="text-center mt-3">No Shopify stores found</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Webhook Setup Guide -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">How to Get Shopify API Credentials</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Step 1 -->
                                <div class="col-md-4">
                                    <div class="step-card">
                                        <div class="step-number">1</div>
                                        <h5>Create Shopify App</h5>
                                        <p>Go to your Shopify Partner Dashboard and create a new app</p>
                                        <img src="{{ asset('public/assets/1.jpg') }}"
                                            class="img-fluid border rounded" alt="Shopify Partner Dashboard">
                                    </div>
                                </div>

                                <!-- Step 2 -->
                                <div class="col-md-4">
                                    <div class="step-card">
                                        <div class="step-number">2</div>
                                        <h5>Configure API Scopes</h5>
                                        <p>Under Configuration, click on configure in the Admin API Integration
                                        </p>
                                        <img src="{{ asset('public/assets/22.jpg') }}"
                                            class="img-fluid border rounded" alt="API Scopes Configuration">
                                    </div>
                                </div>

                                 <!-- Step 2.5 -->
                                <div class="col-md-4">
                                    <div class="step-card">
                                        <div class="step-number">3</div>
                                        <h5>Configure API Scopes</h5>
                                        <p>Under Configuration, add these required scopes:<br>
                                            - read_orders<br>
                                            - write_orders<br>
                                            - read_products
                                        </p>
                                        <img src="{{ asset('public/assets/3.jpg') }}"
                                            class="img-fluid border rounded" alt="API Scopes Configuration">
                                    </div>
                                </div>
  </div>
                             

                            <!-- Additional Steps Row -->
                            <div class="row mt-4">

                                   <!-- Step 3 -->
                                <div class="col-md-4">
                                    <div class="step-card">
                                        <div class="step-number">4</div>
                                        <h5>Get API Credentials</h5>
                                        <p>Under API credentials, note down:<br>
                                            - API Key<br>
                                            - Admin API Access Token<br>
                                            - API Version
                                        </p>
                                        <img src="{{ asset('public/assets/4.jpg') }}"
                                            class="img-fluid border rounded" alt="API Credentials">
                                    </div>
                                </div>
                          

                                <!-- Step 4 -->
                                <div class="col-md-4">
                                    <div class="step-card">
                                        <div class="step-number">4</div>
                                        <h5>Install App to Store</h5>
                                        <p>Go to "App setup" and install the app to your store to generate access tokens</p>
                                        <img src="{{ asset('public/assets/5.jpg') }}"
                                            class="img-fluid border rounded" alt="Install App">
                                    </div>
                                </div>

                                <!-- Step 5 -->
                                <div class="col-md-4">
                                    <div class="step-card">
                                        <div class="step-number">5</div>
                                        <h5>Find Your Shopify Domain</h5>
                                        <p>Your Shopify domain is in the format:<br>
                                            your-store-name.myshopify.com<br>
                                            (Found in your Shopify admin URL)
                                        </p>
                                        <img src="{{ asset('public/images/shopify-app-step5.png') }}"
                                            class="img-fluid border rounded" alt="Shopify Domain">
                                    </div>
                                </div>

                                <!-- Step 6 -->
                               
                            </div>
                            <div class="row">
                                 <div class="col-md-4">
                                    <div class="step-card">
                                        <div class="step-number">6</div>
                                        <h5>Enter Details Here</h5>
                                        <p>Fill in the API Key, Access Token, Domain, and API Version in the form above</p>
                                        <img src="{{ asset('public/images/shopify-app-step6.png') }}"
                                            class="img-fluid border rounded" alt="Enter Credentials">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Shopify Modal -->
        <div class="modal fade" id="add-shopify-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Shopify Store</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="add-shopify-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Store Name</label>
                                    <input type="text" class="form-control" name="store_name" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Shopify Domain (e.g., your-store.myshopify.com)</label>
                                    <input type="text" class="form-control" name="shopify_domain" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">API Key</label>
                                    <input type="text" class="form-control" name="api_key" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Admin API Access Token</label>
                                    <input type="text" class="form-control" name="admin_api_access_token" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">API Version (e.g., 2025-07)</label>
                                    <input type="text" class="form-control" name="api_version" required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="save-shopify-btn">Save Store</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script>
            $(document).ready(function() {

                $('#save-shopify-btn').click(function() {
                    var formData = $('#add-shopify-form').serialize();

                    $.ajax({
                        url: '{{ route('shopify.store') }}',
                        type: 'POST',
                        data: formData,
                        beforeSend: function() {
                            $('#save-shopify-btn').prop('disabled', true).html(
                                '<i class="fa fa-spinner fa-spin"></i> Saving...');
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $('#add-shopify-modal').modal('hide');
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        },
                        complete: function() {
                            $('#save-shopify-btn').prop('disabled', false).html('Save Store');
                        }
                    });
                });

                $('.delete-store').click(function(e) {
                    e.preventDefault();
                    var storeId = $(this).data('id');

                    if (confirm('Are you sure you want to delete this Shopify store?')) {
                        $.ajax({
                            url: '{{ route('shopify.delete') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: storeId
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success(response.message);
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1500);
                                } else {
                                    toastr.error(response.message);
                                }
                            }
                        });
                    }
                });

                $('.verify-webhook').click(function(e) {
                    e.preventDefault();
                    var storeId = $(this).data('id');

                    $.ajax({
                        url: '{{ route('shopify.verify') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: storeId
                        },
                        beforeSend: function() {
                            toastr.info('Verifying webhook...');
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            } else {
                                toastr.error(response.message);
                            }
                        }
                    });
                });
            });
        </script>
    @endsection

    @section('style')
        <style>
            .step-card {
                text-align: center;
                padding: 20px;
                height: 100%;
            }

            .step-number {
                width: 40px;
                height: 40px;
                background: #7367f0;
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 15px;
                font-weight: bold;
            }

            .step-card h5 {
                margin-bottom: 10px;
                color: #7367f0;
            }

            .step-card p {
                color: #6e6b7b;
                margin-bottom: 15px;
            }

            .step-card img {
                max-height: 200px;
                object-fit: contain;
            }
        </style>
    @endsection
