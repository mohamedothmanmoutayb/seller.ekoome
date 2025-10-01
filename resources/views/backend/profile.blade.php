@extends('backend.layouts.app')
@section('content')
    <style>
        .label-process {
            background-color: #ff6334;
        }

        #down {
            display: none;
        }

        .input-group-text {
            height: 40px !important;
        }

        .subscription-card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: none;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .subscription-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .subscription-header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 20px;
            position: relative;
        }

        .subscription-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 12px;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        .bg-active {
            background-color: #00d97e;
        }

        .bg-expired {
            background-color: #e63757;
        }

        .bg-pending {
            background-color: #f6c343;
            color: #000;
        }

        .progress-container {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }

        .progress-time {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background-color: #e9ecef;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 4px;
            background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
        }

        .subscription-detail-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f1f1f1;
        }

        .subscription-detail-item:last-child {
            border-bottom: none;
        }

        .history-item {
            padding: 15px;
            border-left: 4px solid #6a11cb;
            margin-bottom: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .history-date {
            font-size: 12px;
            color: #6c757d;
        }

        .price-tag {
            font-size: 24px;
            font-weight: 700;
            color: #2c7be5;
        }

        .discount-badge {
            background-color: #00d97e;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .plan-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .no-subscriptions {
            text-align: center;
            padding: 40px;
            background-color: #f8f9fa;
            border-radius: 12px;
        }

        .no-subscriptions i {
            font-size: 64px;
            color: #dee2e6;
            margin-bottom: 16px;
        }

        .plan-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .plan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .plan-card .card-header {
            border-bottom: 1px solid #e9ecef;
        }

        .plan-features {
            max-height: 200px;
            overflow-y: auto;
        }

        .plan-features li {
            padding: 2px 0;
            font-size: 0.9rem;
        }

        .plan-features li i {
            color: #6a11cb;
        }

        .price-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }

        .price-tag small {
            font-size: 0.7em;
            font-weight: normal;
            color: #6c757d;
        }
    </style>

    <!-- Content wrapper -->

    <!-- Content -->
    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                      <div class="d-sm-flex align-items-center justify-space-between">
                         <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                        <i class="ti ti-arrow-left fs-5"></i> 
                    </a>
                    <div>
                        <h4 class="mb-4 mb-sm-0 card-title"> Account Settings </h4>                                    
                    </div>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex" href="../horizontal/index.html">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Account Setting
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <ul class="nav nav-pills user-profile-tab" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-3"
                    id="pills-account-tab" data-bs-toggle="pill" data-bs-target="#pills-account" type="button"
                    role="tab" aria-controls="pills-account" aria-selected="true">
                    <i class="ti ti-user-circle me-2 fs-6"></i>
                    <span class="d-none d-md-block">Account</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-3"
                    id="pills-bills-tab" data-bs-toggle="pill" data-bs-target="#pills-bills" type="button" role="tab"
                    aria-controls="pills-bills" aria-selected="false" tabindex="-1">
                    <i class="ti ti-article me-2 fs-6"></i>
                    <span class="d-none d-md-block">Billing</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-3"
                    id="pills-security-tab" data-bs-toggle="pill" data-bs-target="#pills-security" type="button"
                    role="tab" aria-controls="pills-security" aria-selected="false" tabindex="-1">
                    <i class="ti ti-lock me-2 fs-6"></i>
                    <span class="d-none d-md-block">Security</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-3"
                    id="pills-notification-tab" data-bs-toggle="pill" data-bs-target="#pills-notification" type="button"
                    role="tab" aria-controls="pills-notification" aria-selected="false" tabindex="-1">
                    <i class="fas fa-cog" style="margin-right:6px;"></i>
                    <span class="d-none d-md-block">Notifications</span>
                </button>
            </li>
        </ul>
        <div class="card-body">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-account" role="tabpanel"
                    aria-labelledby="pills-account-tab" tabindex="0">
                    <div class="row">
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="card w-100 border position-relative overflow-hidden">
                                <div class="card-body p-4">
                                    <h4 class="card-title">Change Profile</h4>
                                    <p class="card-subtitle mb-4">Upload or reset your profile picture.</p>
                                    <div class="text-center">
                                        <img src="{{ asset('public/assets/images/profile/user-1.jpg') }}" alt="matdash-img"
                                            class="img-fluid rounded-circle" width="120" height="120">
                                        <div class="d-flex align-items-center justify-content-center my-4 gap-6">
                                            <button class="btn btn-primary">Upload</button>
                                            <button class="btn bg-danger-subtle text-danger">Reset</button>
                                        </div>
                                        <p class="mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="card w-100 border position-relative overflow-hidden">
                                <div class="card-body p-4">
                                    <h4 class="card-title">Change Password</h4>
                                    <p class="card-subtitle mb-4">Update your password below.</p>
                                    <form>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword1" class="form-label">Current Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword1"
                                                value="">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleInputPassword2" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword2"
                                                value="">
                                        </div>
                                        <div>
                                            <label for="exampleInputPassword3" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword3"
                                                value="">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card w-100 border position-relative overflow-hidden mb-0">
                                <div class="card-body p-4">
                                    <h4 class="card-title">Personal Details</h4>
                                    <p class="card-subtitle mb-4">Edit and update your account information.
                                    </p>
                                    <form>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputtext" class="form-label">Email</label>
                                                    <input type="email" class="form-control form-control-line"
                                                        value="{{ $user->email }}" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleInputtext1" class="form-label">UserName</label>
                                                    <input type="text" value="{{ $user->name }}"
                                                        class="form-control form-control-line" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Full Name</label>
                                                    <input type="text" value="{{ $user->name }}" id="full_name"
                                                        class="form-control form-control-line">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputtext2" class="form-label">Role</label>
                                                    <input type="text" value="{{ $user->rol->name }}"
                                                        class="form-control form-control-line" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleInputtext3" class="form-label">Company</label>
                                                    <input type="text" class="form-control form-control-line"
                                                        value="{{ $user->company }}" id="company">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Telephone</label>
                                                    <input type="mobile" value="{{ $user->telephone }}"
                                                        class="form-control form-control-line" id="phone">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputtext3" class="form-label">Bank</label>
                                                    <input type="text" class="form-control form-control-line"
                                                        value="{{ $user->company }}" id="company">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">RIB</label>
                                                    <input type="text" class="form-control form-control-line"
                                                        value="{{ $user->rib }}" minlength="24" maxlength="24"
                                                        id="rib">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex align-items-center justify-content-end mt-4 gap-6">
                                                    <button class="btn btn-primary" type="submit"
                                                        id="update">Save</button>
                                                    <button class="btn bg-danger-subtle text-danger">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-bills" role="tabpanel" aria-labelledby="pills-bills-tab"
                    tabindex="0">
                    <div class="row justify-content-center">
                        <div class="row">

                            <div class="card">
                                <div class="card-body">
                                    <!-- Current Subscriptions -->
                                    <h4 class="mb-4">Current Subscriptions</h4>

                                    @if (count($subscriptions) > 0)
                                        @foreach ($subscriptions as $subscription)
                                            <div class="card subscription-card">
                                                <div class="subscription-header">
                                                    <div class="d-flex align-items-center">
                                                        <div class="plan-icon">
                                                            <i class="ti ti-crown text-white fs-4"></i>
                                                        </div>
                                                        <div>
                                                            <h3 class="text-white mb-1">{{ $subscription->plan_name }}</h3>
                                                            <p class="mb-0">Active until
                                                                {{ \Carbon\Carbon::parse($subscription->end_date)->format('M d, Y') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    @if ($subscription->is_active)
                                                        <span class="subscription-badge bg-active">Active</span>
                                                    @else
                                                        <span class="subscription-badge bg-expired">Expired</span>
                                                    @endif
                                                </div>

                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div
                                                                class="d-flex justify-content-between align-items-center mb-4">
                                                                <div>
                                                                    <span class="text-muted">Billing Cycle</span>
                                                                    <h5 class="mb-0 text-capitalize">
                                                                        {{ $subscription->payment_type }}</h5>
                                                                </div>
                                                                <div class="text-end">
                                                                    <span class="text-muted">Price</span>
                                                                    <h4 class="price-tag mb-0">
                                                                        ${{ number_format($subscription->total_price, 2) }}
                                                                    </h4>
                                                                    @if ($subscription->discount > 0)
                                                                        <span class="discount-badge">Save
                                                                            ${{ number_format($subscription->discount, 2) }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="progress-container mb-4">
                                                                <div class="d-flex justify-content-between">
                                                                    <span class="progress-time">Started:
                                                                        {{ \Carbon\Carbon::parse($subscription->start_date)->format('M d, Y') }}</span>
                                                                    <span class="progress-time">Ends:
                                                                        {{ \Carbon\Carbon::parse($subscription->end_date)->format('M d, Y') }}</span>
                                                                </div>
                                                                @php
                                                                    $startDate = \Carbon\Carbon::parse(
                                                                        $subscription->start_date,
                                                                    );
                                                                    $endDate = \Carbon\Carbon::parse(
                                                                        $subscription->end_date,
                                                                    );
                                                                    $today = \Carbon\Carbon::now();
                                                                    $totalDays = $startDate->diffInDays($endDate);
                                                                    $daysPassed = $startDate->diffInDays($today);

                                                                    if ($daysPassed > $totalDays) {
                                                                        $percentage = 100;
                                                                        $daysRemaining = 0;
                                                                    } else {
                                                                        $percentage = ($daysPassed / $totalDays) * 100;
                                                                        $daysRemaining = $totalDays - $daysPassed;
                                                                    }
                                                                @endphp
                                                                <div class="progress-bar mt-2">
                                                                    <div class="progress-fill"
                                                                        style="width: {{ $percentage }}%"></div>
                                                                </div>
                                                                <div class="text-center mt-2">
                                                                    @if ($subscription->is_active)
                                                                        <span
                                                                            class="text-primary fw-bold">{{ $daysRemaining }}
                                                                            days remaining</span>
                                                                    @else
                                                                        <span class="text-danger fw-bold">Subscription
                                                                            expired</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 border-start">
                                                            <h6 class="mb-3">Subscription Details</h6>
                                                            {{-- <div class="subscription-detail-item">
                                                                <span>Subscription ID</span>
                                                                <span
                                                                    class="fw-medium">#{{ $subscription->external_subscriber_id }}</span>
                                                            </div>
                                                            <div class="subscription-detail-item">
                                                                <span>Client ID</span>
                                                                <span
                                                                    class="fw-medium">#{{ $subscription->external_client_id }}</span>
                                                            </div>
                                                            <div class="subscription-detail-item">
                                                                <span>Plan ID</span>
                                                                <span
                                                                    class="fw-medium">#{{ $subscription->external_plan_id }}</span>
                                                            </div> --}}
                                                            <div class="subscription-detail-item">
                                                                <span>Status</span>
                                                                <span
                                                                    class="fw-medium text-capitalize">{{ $subscription->is_active ? 'Active' : 'Inactive' }}</span>
                                                            </div>
                                                            <div class="subscription-detail-item">
                                                                <span>Created</span>
                                                                <span
                                                                    class="fw-medium">{{ \Carbon\Carbon::parse($subscription->created_at)->format('M d, Y') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex gap-2 mt-4">
                                                        @if ($daysRemaining == 0 && $subscription->is_active)
                                                            <button class="btn btn-primary">Renew Subscription</button>
                                                        @endif
                                                        <button class="btn btn-outline-secondary btn-upgrade-plan"
                                                            data-subscriber-id="{{ $subscription->id }}">Upgrade
                                                            Plan</button>
                                                        {{-- <button class="btn btn-outline-primary ms-auto">Download
                                                            Invoice</button> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="no-subscriptions">
                                            <i class="ti ti-article-off"></i>
                                            <h4>No Active Subscriptions</h4>
                                            <p class="text-muted">You don't have any active subscriptions at the moment.
                                            </p>
                                            <button class="btn btn-primary mt-2">Browse Plans</button>
                                        </div>
                                    @endif

                                    <!-- Subscription History -->
                                    @if (count($allSubscriptions) > 0)
                                        <h4 class="mb-4 mt-5">Subscription History</h4>

                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Plan</th>
                                                                <th>Period</th>
                                                                <th>Price</th>
                                                                <th>Status</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($allSubscriptions as $sub)
                                                                <tr>
                                                                    <td>
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="avatar avatar-sm me-2">
                                                                                <span
                                                                                    class="avatar-initial rounded bg-label-primary">
                                                                                    <i class="ti ti-crown"></i>
                                                                                </span>
                                                                            </div>
                                                                            <div>
                                                                                <div class="fw-medium">
                                                                                    {{ $sub->plan_name }}
                                                                                </div>
                                                                                <div class="text-muted small">
                                                                                    #{{ $sub->external_subscriber_id }}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex flex-column">
                                                                            <span>{{ \Carbon\Carbon::parse($sub->start_date)->format('M d, Y') }}</span>
                                                                            <span class="text-muted small">to
                                                                                {{ \Carbon\Carbon::parse($sub->end_date)->format('M d, Y') }}</span>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="fw-medium">${{ number_format($sub->total_price, 2) }}</span>
                                                                        @if ($sub->discount > 0)
                                                                            <div class="text-success small">Saved
                                                                                ${{ number_format($sub->discount, 2) }}
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if ($sub->is_active)
                                                                            <span class="badge bg-active">Active</span>
                                                                        @else
                                                                            <span class="badge bg-expired">Expired</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-sm btn-outline-primary">View
                                                                            Details</button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Pagination -->
                                                @if ($allSubscriptions->hasPages())
                                                    <div class="d-flex justify-content-center mt-4">
                                                        {{ $allSubscriptions->links() }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="content-backdrop fade"></div>


                        </div>
                    </div>
                </div>

                <!-- Upgrade Plan Modal -->
                <div class="modal fade" id="upgradePlanModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Upgrade Your Plan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row" id="plans-container">
                                    <div class="col-12 text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading plans...</span>
                                        </div>
                                        <p class="mt-3">Loading available plans...</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-security" role="tabpanel" aria-labelledby="pills-security-tab"
                    tabindex="0">

                </div>
                <div class="tab-pane fade" id="pills-notification" role="tabpanel"
                    aria-labelledby="pills-notification-tab" tabindex="0">
                    <div class="row">
                        <div class="col-12">
                            <div class="card w-100 border position-relative overflow-hidden mb-0">
                                <div class="card-body p-4">
                                    <h4 class="card-title">Notifications</h4>
                                    <p class="card-subtitle mb-4">Manage how and when you receive notifications</p>

                                    <form id="notification-settings-form">
                                        <div class="form-check form-switch mb-4">
                                            <input class="form-check-input" type="checkbox" id="toggle-sound">
                                            <label class="form-check-label" for="toggle-sound">Enable Sound</label>
                                        </div>

                                        <div class="form-check form-switch mb-4">
                                            <input class="form-check-input" type="checkbox" id="toggle-notifications">
                                            <label class="form-check-label fw-bold" for="toggle-notifications">Enable
                                                Notifications</label>
                                        </div>

                                        <label class="form-label fw-bold mb-2">Show Notifications For:</label>

                                        <div class="form-check mb-2">
                                            <input class="form-check-input notif-checkbox" type="checkbox"
                                                value="success" id="success" checked>
                                            <label class="form-check-label" for="success">✅ Success notifications</label>
                                        </div>

                                        <div class="form-check mb-2">
                                            <input class="form-check-input notif-checkbox" type="checkbox"
                                                value="warning" id="warning" checked>
                                            <label class="form-check-label" for="warning">⚠️ Warning
                                                notifications</label>
                                        </div>

                                        <div class="form-check mb-4">
                                            <input class="form-check-input notif-checkbox" type="checkbox" value="error"
                                                id="error" checked>
                                            <label class="form-check-label" for="error">❗ Error notifications</label>
                                        </div>

                                        <div class="d-flex justify-content-end gap-3">
                                            <button class="btn btn-primary" type="submit"
                                                id="save-preferences">Save</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>






            </div>
        </div>
    </div>

    <div class="content-backdrop fade"></div>
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const soundToggle = document.getElementById('toggle-sound');
            const notifToggle = document.getElementById('toggle-notifications');
            const checkboxes = document.querySelectorAll('.notif-checkbox');
            let currentSubscriberId = null;

            function setCheckboxState(enabled) {
                checkboxes.forEach(cb => {
                    cb.disabled = !enabled;
                    if (!enabled) {
                        cb.checked = false;
                        cb.dataset.initialized = "";
                    }

                });
            }

            notifToggle.addEventListener('change', () => {
                setCheckboxState(notifToggle.checked);
            });

            fetch("{{ route('notifications.get') }}")
                .then(res => res.json())
                .then(data => {
                    console.log("Loaded notification preferences:", data);

                    const soundEnabled = !!data?.sound;
                    const titles = Array.isArray(data?.titles) ? data.titles : [];

                    soundToggle.checked = soundEnabled;
                    notifToggle.checked = titles.length > 0;

                    setCheckboxState(notifToggle.checked);


                    if (notifToggle.checked && titles.length > 0) {
                        titles.forEach(val => {
                            const cb = document.querySelector(`.notif-checkbox[value="${val}"]`);
                            if (cb) cb.checked = true;
                        });
                    } else {
                        checkboxes.forEach(cb => cb.checked = false);
                    }
                })
                .catch(err => {
                    alert('Error loading preferences');
                    console.error(err);
                });


            document.getElementById('notification-settings-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const sound = soundToggle.checked ? 1 : 0;
                const titles = [];

                if (notifToggle.checked) {
                    document.querySelectorAll('.notif-checkbox:checked').forEach(cb => {
                        titles.push(cb.value);
                    });
                }



                $.ajax({
                    url: '{{ route('notifications.settings') }}',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        sound: sound,
                        titles: titles
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Preferences Saved',
                            text: 'Your notification settings have been updated.',
                            timer: 2000,
                            showConfirmButton: false
                        });

                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to Save',
                            text: 'Error: ' + error,
                            footer: '<code>' + xhr.responseText + '</code>'
                        });
                    }
                });
            });
        });

        function openUpgradeModal(subscriberId) {
            currentSubscriberId = subscriberId;
            $('#upgradePlanModal').modal('show');
            loadAvailablePlans();
        }

        function loadAvailablePlans() {
            $.ajax({
                url: '{{ route('plans.available') }}',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        renderPlans(response.plans);
                    } else {
                        $('#plans-container').html(`
                    <div class="col-12 text-center py-5">
                        <i class="ti ti-alert-circle fs-1 text-danger"></i>
                        <p class="mt-3">Failed to load plans. Please try again.</p>
                    </div>
                `);
                    }
                },
                error: function() {
                    $('#plans-container').html(`
                <div class="col-12 text-center py-5">
                    <i class="ti ti-alert-circle fs-1 text-danger"></i>
                    <p class="mt-3">Error loading plans. Please try again.</p>
                </div>
            `);
                }
            });
        }

        function renderPlans(plans) {
            if (plans.length === 0) {
                $('#plans-container').html(`
            <div class="col-12 text-center py-5">
                <i class="ti ti-package-off fs-1 text-muted"></i>
                <p class="mt-3">No plans available at the moment.</p>
            </div>
        `);
                return;
            }

            let plansHtml = '';
            plans.forEach(plan => {
                const isCurrentPlan = plan.is_current || false;
                const monthlyPrice = plan.monthly_price == 0 ? 'Speial Price' :
                    `$${parseFloat(plan.monthly_price).toFixed(2)}<small>/month</small>`;
                const yearlyPrice = plan.yearly_price == 0 ? 'Speial Price' :
                    `$${parseFloat(plan.yearly_price).toFixed(2)}<small>/year</small>`;
                const monthlyDiscount = plan.monthly_price_before_discount == 0 ? 'Speial Price' : `$${parseFloat(plan
                    .monthly_price_before_discount).toFixed(2)}<small>/month</small>`;
                const yearlyDiscount = plan.yearly_price_before_discount == 0 ? 'Speial Price' : `$${parseFloat(plan
                    .yearly_price_before_discount).toFixed(2)}<small>/year</small>`;

                plansHtml += `
            <div class="col-md-6 mb-4">
                <div class="card plan-card h-100 ${isCurrentPlan ? 'border-primary' : ''}">
                    <div class="card-header bg-transparent ${isCurrentPlan ? 'border-primary' : ''}">
                        <h5 class="card-title mb-1">${plan.name}</h5>
                        ${isCurrentPlan ? '<span class="badge bg-primary">Current Plan</span>' : ''}
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted">${plan.description || 'No description available.'}</p>
                        
                        <div class="price-section mb-3">
                            <h4 class="price-tag mb-1">${monthlyPrice}</h4>
                            ${monthlyDiscount > monthlyPrice ? `
                                                                                                                                                                    <div class="text-muted text-decoration-line-through small">
                                                                                                                                                                        ${monthlyDiscount}
                                                                                                                                                                    </div>
                                                                                                                                                                ` : ''}
                            
                            <div class="mt-2">
                                <h5 class="price-tag mb-1">${yearlyPrice}</h5>
                                ${yearlyDiscount > yearlyPrice ? `
                                                                                                                                                                        <div class="text-muted text-decoration-line-through small">
                                                                                                                                                                            ${yearlyDiscount}
                                                                                                                                                                        </div>
                                                                                                                                                                    ` : ''}
                            </div>
                        </div>
                        
                        <div class="plan-features mb-3">
                            <h6 class="text-muted mb-2">Features:</h6>
                            <ul class="list-unstyled">
                                <li><i class="ti ti-users me-1"></i> ${plan.users} Users</li>
                                <li><i class="ti ti-shopping-cart me-1"></i> ${plan.max_monthly_sales} Max Monthly Sales</li>
                                <li><i class="ti ti-truck me-1"></i> ${plan.shipping_companies} Shipping Companies</li>
                                <li><i class="ti ti-user me-1"></i> ${plan.deliverymen} Deliverymen</li>
                                <li><i class="ti ti-building-store me-1"></i> ${plan.stores} Stores</li>
                                <li><i class="ti ti-businessplan me-1"></i> ${plan.agents} Agents</li>
                                <li><i class="ti ti-device-desktop me-1"></i> ${plan.sales_channels} Sales Channels</li>
                                <li><i class="ti ti-package me-1"></i> ${plan.products} Products</li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        ${isCurrentPlan ? `
                                                                                                                                                                <button class="btn btn-outline-primary w-100" disabled>Current Plan</button>
                                                                                                                                                            ` : `
                                                                                                                                                                <button class="btn btn-primary w-100" onclick="upgradeToPlan(${plan.id}, ${currentSubscriberId})">
                                                                                                                                                                    Upgrade to this Plan
                                                                                                                                                                </button>
                                                                                                                                                            `}
                    </div>
                </div>
            </div>
        `;
            });

            $('#plans-container').html(plansHtml);
        }

        function upgradeToPlan(planId, subscriberId) {
            Swal.fire({
                title: 'Confirm Upgrade',
                text: 'Are you sure you want to upgrade to this plan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, upgrade!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing Upgrade',
                        text: 'Please wait while we process your upgrade...',
                        icon: 'info',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    window.location.href =
                        `https://ekoome.com/upgrade/plan/${subscriberId}?plan_id=${planId}`;
                }
            });
        }

        $(document).on('click', '.btn-upgrade-plan', function() {
            const subscriberId = $(this).data('subscriber-id');
            openUpgradeModal(subscriberId);
        });
    </script>


    <!-- Content wrapper -->
    <style>
        .btn-pro {
            margin-left: auto;
            margin-right: auto;
            display: table;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type='text/javascript'>
        $(function(e) {
            $('#update').click(function(e) {
                e.preventDefault();
                var fullname = $('#full_name').val();
                var phone = $('#phone').val();
                var company = $('#company').val();
                var bank = $('#bank').val();
                var rib = $('#rib').val();
                var newpass = $('#new_password').val();
                var conpass = $('#con_pass').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('update') }}',
                    cache: false,
                    data: {
                        fullname: fullname,
                        phone: phone,
                        company: company,
                        bank: bank,
                        rib: rib,
                        newpass: newpass,
                        conpass: conpass,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response, leads) {
                        location.reload();
                        if (response.success == true) {
                            toastr.success('Good Job.',
                                'Information Has been Update Success!', {
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp",
                                    timeOut: 2000
                                });
                        }
                        if (response.success == 'remplier') {
                            toastr.error('Opps.', 'Pleas Complete information!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                        if (response.pass == 'pass') {
                            toastr.error('Opps.', 'Password Not Confirmed', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                        if (response.rib == false) {
                            toastr.warning('Opps.', 'Chnage rib . Number RIB 24', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 2000
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
@endsection
