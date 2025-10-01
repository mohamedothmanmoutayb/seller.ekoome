@extends('backend.layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
             <div class="card card-body py-3">
             
                      <div class="row align-items-center">
                        <div class="col-12">
                            <div class="d-sm-flex align-items-center justify-space-between">
                                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                                    <i class="ti ti-arrow-left fs-5"></i> 
                                </a>
                                <div>
                                <h4 class="mb-4 mb-sm-0 card-title">YouCan</h4>              
                                </div>
                                <nav aria-label="breadcrumb" class="ms-auto">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item d-flex align-items-center">
                                              <a href="{{ env('INTERMEDIATE_APP_URL') }}/youcan/redirect?domain={{ urlencode(Request::root()) }}&client_id={{ env('YOUCAN_CLIENT_ID') }}&user_id={{ Auth::id() }}"
                                                    type="button" class="btn btn-primary btn-rounded waves-effect waves-light text-white my-2">
                                                    Add New YouCan Account
                                                </a>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Add Account Modal -->
            <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" style="max-width: 720px;">
                    <form method="POST" id="youcan-auth-form" action="{{ route('youcan.auth') }}">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Add New YouCan Account</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">YouCan Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">YouCan Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="submit-btn" class="btn btn-primary">
                                    <span class="button-text">Connect Account</span>
                                    <span class="spinner-border spinner-border-sm d-none" role="status"
                                        aria-hidden="true"></span>
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive mt-4">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Store Details</th>
                                            <th>Account Email</th>
                                            <th>Store Status</th>
                                            <th>Webhook Events</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($stores as $index => $store)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <strong>ID:</strong> {{ $store->store_id }}<br>
                                                    <strong>Slug:</strong> {{ $store->slug }}<br>
                                                    @if ($store->access_token)
                                                        <strong>Token:</strong> {{ Str::limit($store->access_token, 15) }}
                                                    @endif
                                                </td>
                                                <td>{{ $store->account->email ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($store->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                    @if ($store->is_email_verified)
                                                        <span class="badge bg-info mt-1">Verified</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @forelse($store->webhooks as $webhook)
                                                        <span class="badge bg-primary mb-1">
                                                            {{ $webhook->event }}
                                                        </span><br>
                                                    @empty
                                                        <span class="text-muted">No webhooks</span>
                                                    @endforelse
                                                </td>
                                                <td>{{ $store->created_at->format('Y-m-d H:i') }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-sm btn-danger unsubscribe-btn"
                                                            data-id="{{ $store->id }}" title="Unsubscribe">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-info view-btn"
                                                            data-id="{{ $store->id }}" title="View Details">
                                                            <i class="ti ti-eye"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <img src="{{ asset('public/Empty-amico.svg') }}" class="img-fluid"
                                                        width="300" style="margin: 0 auto; display: block;">
                                                    <p class="mt-3 text-muted">No YouCan stores found</p>
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
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#youcan-auth-form').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const submitBtn = $('#submit-btn');
                const buttonText = submitBtn.find('.button-text');
                const spinner = submitBtn.find('.spinner-border');

                submitBtn.prop('disabled', true);
                buttonText.text('Connecting');
                spinner.removeClass('d-none');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#add-contact').modal('hide');
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            toastr.error(response.message || 'An error occurred');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMsg = Object.values(xhr.responseJSON.errors).join('<br>');
                        }
                        toastr.error(errorMsg);
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false);
                        buttonText.text('Connect Account');
                        spinner.addClass('d-none');
                    }
                });
            });
            $('.unsubscribe-btn').click(function() {
                const storeId = $(this).data('id');
                const button = $(this);

                if (confirm(
                        'Are you sure you want to unsubscribe this store? This will remove all webhooks from YouCan and delete the store from your system.'
                    )) {
                    button.prop('disabled', true).html(
                        '<i class="fas fa-spinner fa-spin"></i> Processing...');

                    $.ajax({
                        url: "{{ route('youcan.destroy', '') }}/" + storeId,
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.message);
                                setTimeout(() => location.reload(), 1500);
                            } else {
                                toastr.error(response.message);
                                button.prop('disabled', false).html(
                                    '<i class="ti ti-power-off"></i> Unsubscribe');
                            }
                        },
                        error: function(xhr) {
                            const errorMsg = xhr.responseJSON?.message || 'An error occurred';
                            toastr.error(errorMsg);
                            button.prop('disabled', false).html(
                                '<i class="ti ti-power-off"></i> Unsubscribe');
                        }
                    });
                }
            });

            $('.view-btn').click(function() {
                const storeId = $(this).data('id');
                alert('View details for store ID: ' + storeId);
            });
        });
    </script>
@endsection
