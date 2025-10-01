   <div id="notif-list" class="notif-list d-flex flex-column message-body w-100 overflow-auto
                                                data-simplebar">
                                                @foreach ($notifications as $index => $notification)
                                                    @php
                                                        $payload = json_decode($notification->payload, true);
                                                        $source = $payload['source'] ?? null;
                                                        $iconPath = match ($source) {
                                                            'lightfunnels' => asset('public/plateformes/lightlogo.png'),
                                                            'youcan' => asset('public/youcanlogo2.webp'),
                                                            'woocommerce' => asset(
                                                                'public/plateformes/woocommerce-logo.png',
                                                            ),
                                                            default => null,
                                                        };
                                                    @endphp

                                                    <a href="javascript:void(0)"
                                                        class="py-6 px-7 d-flex align-items-center dropdown-item gap-3  notification-item"
                                                        data-index="{{ $index }}"
                                                        data-notification-id="{{ $notification->id }}"
                                                          data-is-read="{{ $notification->is_read }}">
                                                        <span
                                                            class="flex-shrink-0 bg-light rounded-circle round d-flex align-items-center justify-content-center fs-6 text-danger">
                                                            @if ($iconPath)
                                                                <img src="{{ $iconPath }}"
                                                                    alt="{{ $source }}"
                                                                    style="width: 24px; height: 24px;">
                                                            @else
                                                                <iconify-icon icon="solar:widget-3-line-duotone"
                                                                    class="fs-6"></iconify-icon>
                                                            @endif
                                                        </span>
                                                        <div class="w-75">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between">
                                                                <h6 class="mb-1 fw-semibold">
                                                                    {{ $notification->title }}</h6>
                                                                <span
                                                                    class="d-block fs-2">
                                                                    @if ($notification->created_at->diffInHours(now()) < 24)
                                                                        {{ $notification->created_at->format('H:i') }}
                                                                    @else
                                                                        {{ $notification->created_at->diffForHumans() }}
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <span
                                                                class="d-block text-truncate fs-11">{{ $notification->message }}</span>
                                                        </div>
                                                    </a>
                                                @endforeach
