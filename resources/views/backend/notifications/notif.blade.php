@extends('backend.layouts.app')

@section('content')
<div class="container-fluid ">

       
<div class="card card-body py-3 bg-white">
             <div class="row align-items-center ">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="mb-4 mb-sm-0 card-title">Notifications  ({{ $count }})</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                {{-- <a class="text-muted text-decoration-none d-flex" href="{{ route('home') }}">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a> --}}

                                
 <!-- SETTINGS NOTIF -->
<div class="d-flex justify-content-end mb-2">
  <button class="btn btn-no-border fs-5"  style="border: none; background: none;" data-bs-toggle="modal" data-bs-target="#notificationSettingsModal" title="Notification Settings">
    <i class="fas fa-cog"></i>
  </button>
</div>

<div class="modal fade" id="notificationSettingsModal" tabindex="-1" aria-labelledby="notificationSettingsLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header d-flex align-items-center">
        <h5 class="modal-title" id="notificationSettingsLabel">Notification Settings</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="notification-settings-form">
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="toggle-sound" checked>
            <label class="form-check-label" for="toggle-sound">Enable Sound</label>
          </div>

          <label class="form-label fw-bold">Show Notifications For:</label>

          <div class="form-check">
            <input class="form-check-input notif-title" type="checkbox" value="success" id="success" checked>
            <label class="form-check-label" for="success"> ✅ Success notifications</label>
          </div>

          <div class="form-check">
            <input class="form-check-input notif-title" type="checkbox" value="warning" id="warning" checked>
            <label class="form-check-label" for="warning"> ⚠️ Warning notifications</label>
          </div>

          <div class="form-check">
            <input class="form-check-input notif-title" type="checkbox" value="error" id="error" checked>
            <label class="form-check-label" for="error"> ❗ Error notifications</label>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button type="button" id="save-settings" class="btn btn-primary">Save Settings</button>
      </div>
    </div>
  </div>
</div>

                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
            <ul class="nav nav-pills p-3 mb-3 rounded align-items-center card flex-row w-100">
        <li class="nav-item">
            <a href="javascript:void(0)" onclick="toggleText()"
                class="nav-link gap-6 note-link d-flex align-items-center justify-content-center px-3 px-md-3 me-0 me-md-2 fs-11 active"
                id="all-category">
                <i class="ti ti-list fill-white"></i>
                <span class="d-none d-md-block fw-medium">Filter</span>
            </a>
        </li>
    
            <!-- Filter Section -->
        <div class="filter-section w-100" id="multi">
            <form method="GET" action="{{ route('notifications.index') }}" id="filter-form">
                <!-- Date Range Picker -->
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label for="start-date">Start Date:</label>
                        <input type="date" id="start-date" name="start_date" class="form-control" value="{{ request()->input('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end-date">End Date:</label>
                        <input type="date" id="end-date" name="end_date" class="form-control" value="{{ request()->input('end_date') }}">
                    </div>

                    <div class="col-md-4" style="margin-left:6%;">
                        <label for="type">Type:</label>
                        <div class="row mx-auto d-flex align-items-center justify-content-center border rounded" style="height:70%;">
                            <div class="col-auto text-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="success-filter" name="type[]" value="success" {{ in_array('success', request()->input('type', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark" for="success-filter">Success ✅</label>
                                </div>
                            </div>
                            <div class="col-auto text-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="warning-filter" name="type[]" value="warning" {{ in_array('warning', request()->input('type', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark" for="warning-filter">Warning ⚠️</label>
                                </div>
                            </div>
                            <div class="col-auto text-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="error-filter" name="type[]" value="error" {{ in_array('error', request()->input('type', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label text-dark" for="error-filter">Error ❗</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="row mt-3">
                    <div class="col-md-6 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Search </button>
                        <button type="button" id="reset-filters" class="btn btn-outline-secondary">Reset </button>
                    </div>
                </div>
            </form>
        </div>
    </ul>
      

    <div class="d-flex justify-content-end">
    <button id="delete-all-btn" class="btn btn-danger" style="background-color: rgb(215, 89, 89); display: none;">Delete All</button>
</div>


        <div class="card" style="margin-top: 30px;">
            <div class="card-body p-0">
                <div class="table-responsive bg-light">
                       @if ($allnotifications->isEmpty())
                            <div class="p-4 text-center text-muted">
                                <h5>No notifications available.</h5>
                                <p>You're all caught up!</p>
                            </div>
                        @else
                    @foreach ($allnotifications as $notification)
                        @php
                            $type = $notification->type;
                            $icon = match ($type) {
                                'success' => '✅',
                                'error' => '❗',
                                'warning' => '⚠️',
                                default => '🔔',
                            };
                            $payload = json_decode($notification->payload, true);
                            $orderId = $payload['id'] ?? 'N/A';
                            $source = $payload['source'] ?? 'Unknown';
                            $date = \Carbon\Carbon::parse($notification->created_at)->diffForHumans();
                            $iconHtml = match ($source) {
                                'lightfunnels'
                                    => '<img src="/public/plateformes/lightlogo.png" style="width: 24px; height: 24px;">',
                                'youcan' => '<img src="public/youcanlogo2.webp" style="width: 24px; height: 24px;">',
                                'woocommerce'
                                    => '<img src="/public/plateformes/woocommerce-logo.png" style="width: 24px; height: 24px;">',
                                default
                                    => '<iconify-icon icon="solar:widget-3-line-duotone" class="fs-6"></iconify-icon>',
                            };
                        @endphp

                        <div class="posdiv position-relative border rounded p-3 mb-3 shadow-sm bg-white">

<button class="top-0 end-0 mt-3 me-3 btn btn-danger delete-notification"
        data-id="{{ $notification->id }}"
        style="position: absolute; 
               width: 25px; 
               height: 25px; 
               font-size: 24px; 
               text-align: center; 
               line-height: 10px; 
               border-radius: 7px; 
               padding: 0; 
               border: none; 
               background-color: rgb(190, 64, 64); 
               color: white;">
    &times;
</button>


                            <div class="d-flex align-items-start gap-3">
                                <div class="fs-7 mt-1">{{ $icon }}</div>

                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <div class="mb-1 text-dark fw-bold d-flex align-items-center gap-2">
                                            {{ $notification->title }}
                                            {!! $iconHtml !!}
                                        </div>
                                        @if ($type == 'error')
                                            <button id="fix" class="btn btn-sm btn-success"
                                                style="margin-left: 60px">Fix</button>
                                        @endif
                                    </div>
                                    <p class="mb-1">{{ $notification->message }}</p>
                                    <small class="text-muted d-block">Order ID: {{ $orderId }}</small>
                                    @if ($source)
                                        <small class="text-muted d-block">Source: {{ ucfirst($source) }}</small>
                                    @endif
                                </div>
                            </div>
                           @php
                                $created = \Carbon\Carbon::parse($notification->created_at);
                                $now = \Carbon\Carbon::now();
                                $diffInHours = $created->diffInHours($now);
                            @endphp

                            <small class="position-absolute bottom-0 end-0 mb-2 me-3 text-muted" style="font-size:18px;">
                                @if ($diffInHours < 24)
                                    {{ $created->format('H:i') }}
                                @else
                                    {{ $created->format('Y-m-d') }}
                                @endif
                            </small>

                        </div>
               
                    @endforeach
         @endif

                
         
          <div class="d-flex justify-content-center paginate">
                {!! $allnotifications->withQueryString()->links('vendor.pagination.courier') !!}
            </div>
    
                </div>
            </div>


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


{{-- @section('script')
    <script>
        $(document).on('click', '#fix', function() {
            
        });
    </script>
@endsection --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


 <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('reset-filters').addEventListener('click', function () {
                    console.log('Reset button clicked');

                    document.getElementById('start-date').value = '';
                    document.getElementById('end-date').value = '';

                    document.querySelectorAll('.form-check-input').forEach(checkbox => {
                        checkbox.checked = false;
                    });

                    document.getElementById('filter-form').submit();
                });
            });

    
        function toggleText() {
        var x = document.getElementById("multi");

        $('#timeseconds').val('');
        if (x.style.display === "none") {
            x.style.display = "block"; 
        } else {
            x.style.display = "none";  
        }
    } 

        

    $(document).ready(function () {
            function toggleDeleteAllButton() {
                    if ($('.posdiv').length === 0) {
                        $('#delete-all-btn').hide();
                    } else {
                        $('#delete-all-btn').show();
                    }
                }

                toggleDeleteAllButton();

        $('#delete-all-btn').on('click', function () {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You are about to delete all notifications!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete them!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/notifications/delete-all',
                                method: 'GET',
                                success: function (response) {
                                    $('.posdiv').remove();
                                    $('.notification-count').text('').css('display', 'none');
                                    $('.notif-list').empty();
                                    $('.notif-count-badge').text('0 new');
                                    $('.paginate').remove();


                                    showToast("All notifications deleted!");
                                    setTimeout(toggleDeleteAllButton, 300);
                                },
                                error: function (xhr) {
                                    alert("Failed to delete notifications.");
                                }
                            });
                        }
                    });
                });

            $('.delete-notification').on('click', function (e) {
            e.preventDefault();

            const id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will delete the notification permanently.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/notifications/delete/${id}`,
                        method: 'GET',
                        success: function (response) {
                            $(`button[data-id="${id}"]`).closest('.posdiv').remove();

                            const $badge = $('.notification-count');
                            let count = parseInt($badge.text());

                            if (!isNaN(count) && count > 0) {
                                count -= 1;

                                if (count > 99) {
                                    $badge.text('+99').show();
                                } else if (count > 0) {
                                    $badge.text(count).show();
                                } else {
                                    $badge.hide().text('');
                                }
                            }

                            showToast("Notification deleted!");
                            setTimeout(toggleDeleteAllButton, 300);
                        },
                        error: function (xhr) {
                            alert("Failed to delete notification.");
                        }
                    });
                }
            });
        });



        function showToast(message) {
            const toast = $('<div></div>')
                .text(message)
                .css({
                    position: 'fixed',
                    top: '20px', 
                    right: '20px',
                    background: '#28a745',
                    color: 'white',
                    padding: '10px 20px',
                    borderRadius: '5px',
                    zIndex: 9999,
                    boxShadow: '0 0 10px rgba(0,0,0,0.2)'
                });

            $('body').append(toast);
            setTimeout(() => toast.remove(), 3000);  
        }
    });

     
    </script>

    
  <script>
    $(document).ready(function () {


            $('#notificationSettingsModal').on('show.bs.modal', function () {
            $.ajax({
                url: '{{ route("notifications.get") }}',
                method: 'GET',
                success: function (data) {
                    console.log(data)
                    $('#toggle-sound').prop('checked', data.sound);

                    $('.notif-title').prop('checked', false);
                    if (Array.isArray(data.titles)) {
                        data.titles.forEach(function (title) {
                            $('.notif-title[value="' + title + '"]').prop('checked', true);
                        });
                    }
                },
                error: function (xhr) {
                    console.error('Failed to load settings:', xhr.responseText);
                }
            });
        });



        $('#save-settings').on('click', function () {
            const soundEnabled = $('#toggle-sound').is(':checked') ? 1 : 0;
            const selectedTitles = [];

            $('.notif-title:checked').each(function () {
                selectedTitles.push($(this).val());
            });

            $.ajax({
                url: '{{ route("notifications.settings") }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    sound: soundEnabled,
                    titles: selectedTitles
                },
                success: function (response) {
                    $('#notificationSettingsModal').modal('hide');
                },
                error: function (xhr, status, error) {
                    alert('Failed to save preferences: ' + error);
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>








 @endsection