<div class="card usage-meter-card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="card-title mb-0">{{ $title }}</h6>
        <span class="badge bg-{{ $statusColor }}">{{ $current }}/{{ $isUnlimited ? 'Unlimited' : $limit }}</span>
    </div>
    <div class="card-body">
        <div class="usage-progress mb-2">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="text-muted small">Usage</span>
                <span class="text-muted small">{{ $isUnlimited ? 'Unlimited' : $percentage . '%' }}</span>
            </div>
            <div class="progress" style="height: 8px;">
                <div class="progress-bar bg-{{ $statusColor }}" role="progressbar"
                    style="width: {{ $isUnlimited ? 100 : $percentage }}%"
                    aria-valuenow="{{ $isUnlimited ? 100 : $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
        <div class="usage-info">
            <small class="text-muted">
                @if ($isUnlimited)
                    <i class="ti ti-crown me-1 text-success"></i> Unlimited usage - Enjoy!
                @elseif($isOverLimit)
                    <i class="ti ti-alert-triangle text-danger me-1"></i> Limit exceeded by {{ $current - $limit }}
                @elseif($isNearLimit)
                    <i class="ti ti-alert-circle text-warning me-1"></i> {{ $remaining }} remaining
                @else
                    {{ $remaining }} remaining of your limit
                @endif
            </small>
        </div>
    </div>
</div>
