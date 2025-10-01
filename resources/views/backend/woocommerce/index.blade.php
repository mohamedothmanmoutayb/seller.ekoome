@extends('backend.layouts.app')
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
         <div class="card card-body py-3">
             
                      <div class="row align-items-center">
                        <div class="col-12">
                            <div class="d-sm-flex align-items-center justify-space-between">
                                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                                    <i class="ti ti-arrow-left fs-5"></i> 
                                </a>
                                <div>
                                <h4 class="mb-4 mb-sm-0 card-title">WooCommerce</h4>              
                                </div>
                                <nav aria-label="breadcrumb" class="ms-auto">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item d-flex align-items-center">
                                                <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light"
                                                data-bs-toggle="modal" data-bs-target="#add-contact">
                                                <i class="mdi mdi-plus-circle me-2"></i>Add New WooCommerce
                                            </button>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

        <!-- Add Integration Modal -->
        <div id="add-contact" class="modal fade" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Integration</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="integrationForm" method="POST" action="{{ route('woocommerce.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-horizontal form-material">
                                <div class="form-group">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Store URL</label>
                                        <input type="url" name="domain" class="form-control"
                                            placeholder="https://yourstore.com" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Consumer Key</label>
                                        <input type="text" name="consumer_key" class="form-control"
                                            placeholder="ck_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Consumer Secret</label>
                                        <input type="text" name="consumer_secret" class="form-control"
                                            placeholder="cs_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Integration</button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Integration Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive text-nowrap" style="min-height: 350px;">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Seller</th>
                                <th>Domain</th>
                                <th>Consumer Key</th>
                                <th>Consumer Secret</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($integrations as $index => $integration)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $integration->user->name ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ $integration->domain }}" target="_blank" rel="noopener noreferrer">
                                            {{ parse_url($integration->domain, PHP_URL_HOST) }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 150px;"
                                            title="{{ $integration->consumer_key }}">
                                            {{ \Illuminate\Support\Str::limit($integration->consumer_key, 15, '...') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 150px;"
                                            title="{{ $integration->consumer_secret }}">
                                            {{ \Illuminate\Support\Str::limit($integration->consumer_secret, 15, '...') }}
                                        </span>
                                    </td>
                                    <td>{{ $integration->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm delete" data-id="{{ $integration->id }}">
                                            <i class="mdi mdi-delete me-1"></i> Unsubscribe
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <img src="{{ asset('public/Empty-amico.svg') }}" class="img-fluid" width="300"
                                            style="margin: 0 auto; display: block;">
                                        <p class="mt-3 text-muted">No WooCommerce integrations found</p>
                                        <button class="btn btn-primary mt-2" data-bs-toggle="modal"
                                            data-bs-target="#add-contact">
                                            <i class="mdi mdi-plus-circle me-1"></i> Add Your First Integration
                                        </button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#integrationForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    beforeSend: function() {
                        form.find('button[type="submit"]').prop('disabled', true)
                            .html(
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
                            );
                    },
                    success: function(response) {
                        $('#add-contact').modal('hide');
                        window.location.reload();
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON.message || 'An error occurred');
                        form.find('button[type="submit"]').prop('disabled', false).text(
                            'Save Integration');
                    },
                    complete: function() {
                        form.find('button[type="submit"]').prop('disabled', false).text(
                            'Save Integration');
                    }
                });
            });

            $('.delete').on('click', function() {
                if (confirm(
                        'Are you sure you want to unsubscribe from this WooCommerce store? This will remove the webhook integration.'
                    )) {
                    const button = $(this);
                    const id = button.data('id');

                    $.ajax({
                        url: '/woocommerce/' + id,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function() {
                            button.prop('disabled', true)
                                .html(
                                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                                );
                        },
                        success: function() {
                            window.location.reload();
                        },
                        error: function(xhr) {
                            alert('Failed to delete integration: ' + (xhr.responseJSON
                                .message || 'Unknown error'));
                            button.prop('disabled', false).html(
                                '<i class="mdi mdi-delete me-1"></i> Unsubscribe');
                        }
                    });
                }
            });
        });
    </script>
@endsection
