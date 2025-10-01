@extends('backend.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="mb-0">Notifications</h1>

                    <div class="d-flex gap-2">
                        <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <iconify-icon icon="solar:check-read-line-duotone"></iconify-icon>
                                Mark All as Read
                            </button>
                        </form>

                        <form action="{{ route('notifications.clearAll') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <iconify-icon icon="solar:trash-bin-trash-line-duotone"></iconify-icon>
                                Clear All
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="60px"></th>
                                <th>Notification</th>
                                <th width="150px">Date</th>
                                <th width="120px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notifications as $notification)
                                <tr class="@if (is_null($notification->read_at)) table-active @endif">
                                    <td class="text-center">
                                        <span
                                            class="badge bg-{{ $notification->data['color'] ?? 'primary' }} rounded-circle p-2">
                                            <iconify-icon
                                                icon="{{ $notification->data['icon'] ?? 'solar:bell-bing-line-duotone' }}"></iconify-icon>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <strong>{{ $notification->data['title'] }}</strong>
                                            <small class="text-muted">{{ $notification->data['message'] }}</small>

                                            @if (isset($notification->data['lead']))
                                                <span class="badge bg-info mt-1 align-self-start">
                                                    Lead: {{ $notification->data['lead']['n_lead'] }}
                                                </span>
                                            @endif

                                            @if (isset($notification->data['severity']))
                                                <span
                                                    class="badge bg-{{ $notification->data['color'] }} mt-1 align-self-start">
                                                    {{ ucfirst($notification->data['severity']) }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <small>{{ $notification->created_at->format('M d, Y') }}</small>
                                        <br>
                                        <small class="text-muted">{{ $notification->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if (is_null($notification->read_at))
                                                <form action="{{ route('notifications.markAsRead', $notification->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-primary"
                                                        title="Mark as Read">
                                                        <iconify-icon icon="solar:check-read-line-duotone"></iconify-icon>
                                                    </button>
                                                </form>
                                            @endif

                                            @if (isset($notification->data['url']))
                                                <a href="{{ $notification->data['url'] }}"
                                                    class="btn btn-sm btn-outline-success" title="View">
                                                    <iconify-icon icon="solar:eye-line-duotone"></iconify-icon>
                                                </a>
                                            @endif

                                            <form action="{{ route('notifications.delete', $notification->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <iconify-icon icon="solar:trash-bin-trash-line-duotone"></iconify-icon>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <iconify-icon icon="solar:bell-off-line-duotone"
                                            class="fs-1 text-muted"></iconify-icon>
                                        <p class="mt-3">No notifications found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($notifications->hasPages())
                <div class="card-footer">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">New Notification</strong>
                <small>Just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toast-message"></div>
        </div>
    </div> --}}
@endsection

@push('scripts')
    <script>
        // $(document).ready(function() {
        //     $(window).on('new-notification', function() {
        //         $.get('{{ route('notifications.unreadCount') }}', function(data) {
        //             updateNotificationBadge(data.count);
        //         });
        //     });

        //     function updateNotificationBadge(count) {
        //         const $badge = $('.notification-badge');
        //         if (count > 0) {
        //             if ($badge.length) {
        //                 $badge.text(count);
        //             } else {
        //                 $('<span>')
        //                     .addClass(
        //                         'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge'
        //                     )
        //                     .text(count)
        //                     .appendTo($('.nav-link.dropdown-toggle'));
        //             }
        //         } else {
        //             $badge.remove();
        //         }
        //     }

        //     $('.toast').toast({
        //         autohide: true,
        //         delay: 5000
        //     });
        // });
    </script>
@endpush
