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
                                <h4 class="mb-4 mb-sm-0 card-title">Lightfunnels</h4>              
                                </div>
                                <nav aria-label="breadcrumb" class="ms-auto">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item d-flex align-items-center">
                                             <a type="button" class="btn btn-primary btn-rounded waves-effect waves-light text-white my-2"
                                                href="{{ env('INTERMEDIATE_APP_URL') }}/lightfunnels/redirect?domain={{ urlencode(Request::root()) }}&client_id={{ env('LIGHTFUNNELS_CLIENT_ID') }}&auth={{ urlencode(Auth::user()->id) }}">
                                                Add New Lightfunnels</a>
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
                            <form>
                                <div class="row">
                                    <div class="col-md-9 col-sm-12 m-b-20">
                                        <input type="text" class="form-control" name="search" placeholder="Search...">
                                    </div>
                                    <div class="col-md-3 col-sm-12 m-b-20">
                                        <button type="submit" class="btn btn-primary waves-effect"
                                            style="width:100%">Search</button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive mt-4" style="min-height: 350px;">
                                <table id="demo-foo-addrow"
                                    class="table table-bordered table-striped table-hover contact-list" data-paging="true"
                                    data-paging-size="7">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Domain </th>
                                            <th>Account ID</th>
                                            <th>Access Token</th>
                                            <th>Created At</th>
                                            <th>Events</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $counter = 1; @endphp
                                        @forelse($stores as $store)
                                            <tr>
                                                <td>{{ $counter++ }}</td>
                                                <td>{{ $store->domaine_url }}</td>
                                                <td>{{ $store->account_id }}</td>
                                                <td>{{ Str::limit($store->access_token, 30) }}</td>
                                                <td>{{ $store->created_at->format('Y-m-d H:i') }}</td>
                                                <td>
                                                    @if ($store->lightfunnelWebhooks->isNotEmpty())
                                                        <ul>
                                                            @foreach ($store->lightfunnelWebhooks as $webhook)
                                                                <li>{{ $webhook->webhook_event }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <em>No events</em>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($store->is_active)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button
                                                        class="btn btn-toggle-status {{ $store->is_active ? 'btn-danger' : 'btn-success' }}"
                                                        data-id="{{ $store->id }}">
                                                        <i class="ti ti-power"></i>
                                                        {{ $store->is_active ? 'Inactive' : 'Active' }}
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6">
                                                    <img src="{{ asset('public/Empty-amico.svg') }}"
                                                        style="margin-left: auto ; margin-right: auto; display: block;"
                                                        width="500" />
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
            $('.btn-toggle-status').click(function() {
                const button = $(this);
                const storeId = button.data('id');

                button.prop('disabled', true);
                const originalHtml = button.html();
                button.html('<i class="fas fa-spinner fa-spin"></i> Processing');

                $.ajax({
                    url: "{{ route('lightfunnels.toggle-status') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        store_id: storeId,
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        location.reload();
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'An error occurred');
                        button.html(originalHtml);
                    },
                    complete: function() {
                        button.prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
