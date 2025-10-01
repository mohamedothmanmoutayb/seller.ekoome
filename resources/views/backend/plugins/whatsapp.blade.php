@extends('backend.layouts.app')

@section('content')
    <div class="container-fluid px-4">
        <!-- Header Section -->
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                            <i class="ti ti-arrow-left fs-5"></i>
                        </a>
                        <div>
                            <h4 class="mb-4 mb-sm-0 card-title">WhatsApp Business Manager</h4>
                        </div>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a class="text-muted text-decoration-none d-flex" href="{{ route('home') }}">
                                        <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Credit Dashboard -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                <i class="ti ti-wallet text-primary fs-8"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1">Message Credits</p>
                                <h3 class="mb-0">{{ number_format($credits['allocated']) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                                <i class="ti ti-check text-success fs-8"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1">Credits Used</p>
                                <h3 class="mb-0">{{ number_format($credits['consumed']) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                                <i class="ti ti-coin text-warning fs-8"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1">Credits Remaining</p>
                                <h3 class="mb-0">{{ number_format($credits['remaining']) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="row">
            <!-- Accounts Sidebar -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Connected Accounts</h5>
                            <button class="btn btn-sm btn-primary" onclick="launchWhatsAppSignup()">
                                <i class="ti ti-plus me-1"></i> Add
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($accounts as $account)
                                <a href="#" class="list-group-item list-group-item-action account-selector"
                                    data-account-id="{{ $account->id }}">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="ti ti-brand-whatsapp text-success me-2"></i>
                                                <strong>{{ $account->phone_number }}</strong>
                                            </div>
                                            <div class="text-muted small">
                                                <span class="badge bg-light text-dark me-2">
                                                    <i class="ti ti-template me-1"></i> {{ $account->templates_count }}
                                                </span>
                                                <span class="badge bg-light text-dark">
                                                    <i class="ti ti-flow-branch me-1"></i> {{ $account->flows_count }}
                                                </span>
                                            </div>
                                        </div>
                                        <span
                                            class="badge bg-{{ $account->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($account->status) }}
                                        </span>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-4">
                                    <img src="{{ asset('public/empty-state.svg') }}" width="120" class="img-fluid mb-3">
                                    <p class="text-muted">No WhatsApp accounts connected</p>
                                    <button class="btn btn-primary" onclick="launchWhatsAppSignup()">
                                        <i class="ti ti-brand-whatsapp me-2"></i> Connect Account
                                    </button>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary text-start" id="settings-btn">
                                <i class="ti ti-settings me-2"></i> General Settings
                            </button>
                            <a href="{{ route('plugins.whatsapp.analytics') }}"
                                class="btn btn-outline-secondary text-start" id="analytics-btn">
                                <i class="ti ti-chart-line me-2"></i> View Analytics
                            </a>
                            <a href="{{ route('aiagents.index') }}" class="btn btn-outline-success text-start"
                                id="analytics-btn">
                                <i class="ti ti ti-brain me-2"></i> AI Agents
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Details Panel -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 id="account-detail-title" class="mb-0">Account Overview</h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                    id="accountActionsDropdown" data-bs-toggle="dropdown">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#" id="refresh-account"><i
                                                class="ti ti-refresh me-2"></i> Refresh</a></li>
                                    <li><a class="dropdown-item" href="#" id="sync-templates"><i
                                                class="ti ti-cloud-download me-2"></i> Sync Templates</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="#" id="remove-account"><i
                                                class="ti ti-trash me-2"></i> Remove Account</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="account-details-container">
                            <div class="text-center py-5">
                                <img src="{{ asset('public/plugins/whatsapp-account.png') }}" width="200"
                                    class="img-fluid mb-3">
                                <h5 class="text-muted">Select a WhatsApp account</h5>
                                <p class="text-muted">Choose an account from the sidebar to view details</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Modal -->
    <div class="modal fade" id="settingsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">WhatsApp Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="settingsForm">
                        <div class="mb-4">
                            <h6 class="mb-3">Chatbot Status</h6>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusActive"
                                    value="active">
                                <label class="form-check-label" for="statusActive">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="statusInactive"
                                    value="inactive">
                                <label class="form-check-label" for="statusInactive">Inactive</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <h6 class="mb-3">Notification Preferences</h6>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="orderConfirmations">
                                <label class="form-check-label" for="orderConfirmations">Order Confirmations</label>
                            </div>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="deliveryUpdates">
                                <label class="form-check-label" for="deliveryUpdates">Delivery Updates</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="promotionalMessages">
                                <label class="form-check-label" for="promotionalMessages">Promotional Messages</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveSettings">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h5 class="mb-2">Connecting to WhatsApp</h5>
                    <p class="text-muted">Please wait while we connect your WhatsApp Business account</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Agent Assignment Modal -->
    <div class="modal fade" id="agentAssignmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assign WhatsApp Number to Agents</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="ti ti-info-circle me-2"></i>
                        Successfully connected WhatsApp number: <strong id="connected-phone-number"></strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Agents to Assign This Number:</label>
                        <div id="agents-list" class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                            <!-- Agents will be populated here -->
                        </div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="assign-to-all">
                        <label class="form-check-label" for="assign-to-all">
                            Assign to all agents
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Skip for Now</button>
                    <button type="button" class="btn btn-primary" id="assign-agents-btn">
                        <i class="ti ti-user-check me-1"></i> Assign to Selected Agents
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Agent Management Modal -->
    <div class="modal fade" id="manageAgentsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Agents</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="manageAgentsModalBody">
                    <!-- Agent management content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Facebook SDK -->
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

    <script>
        let waba_id = null;
        let phone_number_id = null;
        let business_id = null;
        let connectedAccountId = null;
        const agents = @json($agents);

        window.fbAsyncInit = function() {
            FB.init({
                appId: '{{ env('META_APP_ID') }}',
                autoLogAppEvents: true,
                xfbml: true,
                version: 'v22.0'
            });
        };

        window.addEventListener('message', (event) => {
            if (!event.origin.endsWith('facebook.com')) return;
            try {
                const data = JSON.parse(event.data);
                if (data.type === 'WA_EMBEDDED_SIGNUP') {
                    console.log('WhatsApp Embedded Signup event: ', data);
                    waba_id = data.data.waba_id;
                    phone_number_id = data.data.phone_number_id;
                    business_id = data.data.business_id;

                    if (data.event === 'STARTED') {
                        $('#statusModal').modal('show');
                    } else if (data.event === 'COMPLETE') {
                        $('#statusModal').modal('hide');
                        toastr.success('WhatsApp account connected successfully');
                        connectedAccountId = data.data.waba_id;
                        setTimeout(() => {
                            showAgentAssignmentModal();
                        }, 1000);
                    } else if (data.event === 'ERROR') {
                        $('#statusModal').modal('hide');
                        toastr.error('Failed to connect WhatsApp account: ' + data.data.errorMessage);
                    }
                }
            } catch {
                console.log('Message event: ', event.data);
            }
        });

        const showAgentAssignmentModal = () => {
            const agentsList = $('#agents-list');
            agentsList.empty();

            if (agents.length === 0) {
                agentsList.html(`
                    <div class="text-center text-muted py-3">
                        <i class="ti ti-users-off fs-5"></i>
                        <p class="mt-2 mb-0">No agents available</p>
                    </div>
                `);
                $('#assign-agents-btn').prop('disabled', true);
            } else {
                agents.forEach(agent => {
                    const roleBadge = agent.id_role === 4 ? 'bg-primary' : 'bg-success';
                    const roleText = agent.id_role === 4 ? 'Manager' : 'Agent';

                    agentsList.append(`
                        <div class="form-check mb-2">
                            <input class="form-check-input agent-checkbox" type="checkbox" 
                                   value="${agent.id}" id="agent-${agent.id}">
                            <label class="form-check-label d-flex justify-content-between w-100" for="agent-${agent.id}">
                                <span>
                                    <strong>${agent.name}</strong>
                                    <br>
                                    <small class="text-muted">${agent.email}</small>
                                </span>
                                <span class="badge ${roleBadge}">${roleText}</span>
                            </label>
                        </div>
                    `);
                });
                $('#assign-agents-btn').prop('disabled', false);
            }

            $('#agentAssignmentModal').modal('show');
        }

        const fbLoginCallback = (response) => {
            if (response.authResponse) {
                const code = response.authResponse.code;
                console.log('Auth response code: ', code);

                $.ajax({
                    url: '{{ route('plugins.whatsapp.exchange-token') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        code: code,
                        waba_id: waba_id,
                        phone_number_id: phone_number_id,
                        business_id: business_id
                    },
                    success: function(response) {
                        toastr.success('WhatsApp account connected successfully');
                        $('#statusModal').modal('hide');

                        connectedAccountId = response.account_id;
                    },
                    error: function(xhr) {
                        $('#statusModal').modal('hide');
                        toastr.error('Failed to complete WhatsApp connection');
                    }
                });
            } else {
                console.log('User cancelled login or did not fully authorize.');
                $('#statusModal').modal('hide');

                if (response.status === 'not_authorized') {
                    toastr.warning('You need to authorize the app to proceed');
                }
            }
        }

        const launchWhatsAppSignup = () => {
            $('#statusModal').modal('show');

            if (typeof FB === 'undefined') {
                $('#statusModal').modal('hide');
                toastr.error('Facebook SDK not loaded. Please try again.');
                return;
            }

            FB.login(fbLoginCallback, {
                config_id: '{{ env('META_CONFIG_ID') }}',
                response_type: 'code',
                override_default_response_type: true,
                redirect_uri: 'https://seller.tashilcod.com/plugins/whatsapp',
                scope: 'whatsapp_business_manage_events,whatsapp_business_messaging',
                extras: {
                    setup: {},
                    featureType: 'whatsapp_business_app_onboarding',
                    sessionInfoVersion: '3',
                }
            });
        }

        window.manageAgents = function(accountId) {
            $.ajax({
                url: '{{ route('plugins.whatsapp.agents.manage', ['account' => ':accountId']) }}'
                    .replace(':accountId', accountId),
                type: 'GET',
                success: function(response) {
                    $('#manageAgentsModalBody').html(response);
                    $('#manageAgentsModal').modal('show');
                },
                error: function(xhr) {
                    console.error('Error loading agent management:', xhr);
                    toastr.error('Error loading agent management interface');
                }
            });
        }

        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

            $('#assign-to-all').change(function() {
                $('.agent-checkbox').prop('checked', $(this).is(':checked'));
            });

            $('#assign-agents-btn').click(function() {
                const selectedAgents = [];
                $('.agent-checkbox:checked').each(function() {
                    selectedAgents.push($(this).val());
                });

                if (selectedAgents.length === 0) {
                    toastr.warning('Please select at least one agent');
                    return;
                }

                const btn = $(this);
                btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-1"></span> Assigning...');

                $.ajax({
                    url: '{{ route('plugins.whatsapp.assign-agents') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        account_id: connectedAccountId,
                        agent_ids: selectedAgents
                    },
                    success: function(response) {
                        btn.prop('disabled', false).html(
                            '<i class="ti ti-user-check me-1"></i> Assign to Selected Agents'
                        );
                        $('#agentAssignmentModal').modal('hide');
                        toastr.success(response.message);

                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html(
                            '<i class="ti ti-user-check me-1"></i> Assign to Selected Agents'
                        );
                        toastr.error(xhr.responseJSON?.message || 'Failed to assign agents');
                    }
                });
            });

            $('.account-selector').click(function(e) {
                e.preventDefault();
                $('.account-selector').removeClass('active');
                $(this).addClass('active');
                const accountId = $(this).data('account-id');
                loadAccountDetails(accountId);
            });

            $('#settings-btn').click(function() {
                $('#settingsModal').modal('show');
            });

            function loadAccountDetails(accountId) {
                $('#account-details-container').html(`
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `);

                $.ajax({
                    url: '{{ route('plugins.whatsapp.account.details') }}',
                    type: 'GET',
                    data: {
                        account_id: accountId
                    },
                    success: function(response) {
                        $('#account-detail-title').html(response.account.phone_number);

                        const lastSync = response.account.last_sync ?
                            new Date(response.account.last_sync).toLocaleString() :
                            'Never synced';

                        // Show only first 5 templates
                        const displayedTemplates = response.templates.slice(0, 5);
                        const remainingTemplates = response.templates.length - 5;

                        $('#account-details-container').html(`
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-4 border-0 shadow-sm">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Account Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <dl class="row mb-0">
                                                <dt class="col-sm-5">Status:</dt>
                                                <dd class="col-sm-7">
                                                    <span class="badge bg-${response.account.status === 'active' ? 'success' : 'secondary'}">
                                                        ${response.account.status ? response.account.status.charAt(0).toUpperCase() + response.account.status.slice(1) : 'Unknown'}
                                                    </span>
                                                </dd>
                                                
                                                <dt class="col-sm-5">Last Sync:</dt>
                                                <dd class="col-sm-7">${lastSync}</dd>
                                                
                                                <dt class="col-sm-5">Templates:</dt>
                                                <dd class="col-sm-7">${response.templates.length}</dd>
                                                
                                                <dt class="col-sm-5">Flows:</dt>
                                                <dd class="col-sm-7">${response.flows.length}</dd>
                                                
                                                <dt class="col-sm-5">Assigned Agents:</dt>
                                                <dd class="col-sm-7">
                                                    ${response.assigned_agents && response.assigned_agents.length > 0  ? 
                                                        response.assigned_agents.filter(agent => agent !== null).map(agent => agent.name).join(', ') : 
                                                        'No agents assigned'}
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                    
                                    <!-- Templates Section -->
                                    <div class="card border-0 shadow-sm mb-4">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">Message Templates</h6>
                                            <a href="{{ url('whatsapp/business-accounts/${response.account.id}/templates') }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                Manage
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            ${response.templates.length > 0 ? 
                                                `<div class="table-responsive">
                                                                                                                <table class="table table-sm table-hover">
                                                                                                                    <thead>
                                                                                                                        <tr>
                                                                                                                            <th>Name</th>
                                                                                                                            <th>Status</th>
                                                                                                                            <th>Category</th>
                                                                                                                        </tr>
                                                                                                                    </thead>
                                                                                                                    <tbody>
                                                                                                                        ${displayedTemplates.map(template => `
                                                                <tr>
                                                                    <td>${template.name || 'Unnamed'}</td>
                                                                    <td>
                                                                        <span class="badge bg-${template.status === 'APPROVED' ? 'success' : template.status === 'PENDING' ? 'warning' : 'danger'}">
                                                                            ${template.status || 'UNKNOWN'}
                                                                        </span>
                                                                    </td>
                                                                    <td>${template.category || 'UTILITY'}</td>
                                                                </tr>
                                                            `).join('')}
                                                                                                                    </tbody>
                                                                                                                </table>
                                                                                                                ${remainingTemplates > 0 ? 
                                                                                                                    `<div class="text-center mt-2">
                                                            <small class="text-muted">+ ${remainingTemplates} more templates</small>
                                                        </div>` : ''}
                                                                                                            </div>` : 
                                                `<div class="text-center py-3 text-muted">
                                                                                                                <i class="ti ti-template-off fs-5"></i>
                                                                                                                <p class="mt-2 mb-0">No templates found</p>
                                                                                                            </div>`}
                                        </div>
                                    </div>
                                    

                                </div>
                                
                                <div class="col-md-6">
                                    <!-- Flows Section -->
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">Flows</h6>
                                            <a href="{{ url('whatsapp/business-accounts/${response.account.id}/flows') }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                Manage
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            ${response.flows && response.flows.length > 0 ? 
                                                `<div class="table-responsive">
                                                                                                                <table class="table table-sm table-hover">
                                                                                                                    <thead>
                                                                                                                        <tr>
                                                                                                                            <th>Name</th>
                                                                                                                            <th>Status</th>
                                                                                                                            <th>Type</th>
                                                                                                                        </tr>
                                                                                                                    </thead>
                                                                                                                    <tbody>
                                                                                                                        ${response.flows.slice(0, 5).map(flow => `
                                                                <tr>
                                                                    <td>${flow.name || 'Unnamed'}</td>
                                                                    <td>
                                                                        <span class="badge bg-${flow.is_active == 1 ? 'success' : 'secondary'}">
                                                                            ${flow.is_active == 1 ? 'ACTIVE' : 'UNACTIVE'}
                                                                        </span>
                                                                    </td>
                                                                    <td>${flow.flow_type || 'CUSTOM'}</td>
                                                                </tr>
                                                            `).join('')}
                                                                                                                    </tbody>
                                                                                                                </table>
                                                                                                                ${response.flows.length > 5 ? 
                                                                                                                    `<div class="text-center mt-2">
                                                            <small class="text-muted">+ ${response.flows.length - 5} more flows</small>
                                                        </div>` : ''}
                                                                                                            </div>` : 
                                                `<div class="text-center py-3 text-muted">
                                                                                                                <i class="ti ti-flow-branch fs-5"></i>
                                                                                                                <p class="mt-2 mb-0">No flows found</p>
                                                                                                            </div>`}
                                        </div>
                                    </div>
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">Assigned Agents</h6>
                                            <button class="btn btn-sm btn-outline-primary" onclick="manageAgents(${response.account.id})">
                                                Manage
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            ${response.assigned_agents && response.assigned_agents.length > 0 ? 
                                                `<div class="list-group list-group-flush">
                                                                                                                ${response.assigned_agents.filter(agent => agent !== null).map(agent => `
                                                        <div class="list-group-item border-0 px-0">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <h6 class="mb-1">${agent.name || 'Unnamed Agent'}</h6>
                                                                    <small class="text-muted">${agent.email || 'No email'}</small>
                                                                </div>
                                                                <span class="badge bg-${agent.id_role == 4 ? 'primary' : 'success'}">
                                                                    ${agent.id_role == 4 ? 'Manager' : agent.id_role ? 'Agent' : 'Unknown'}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    `).join('')}
                                                                                                            </div>` : 
                                                `<div class="text-center py-3 text-muted h-100 d-flex flex-column justify-content-center">
                                                                                                                <i class="ti ti-users-off fs-5"></i>
                                                                                                                <p class="mt-2 mb-0">No agents assigned</p>
                                                                                                                <button class="btn btn-sm btn-primary mt-2" onclick="manageAgents(${response.account.id})">
                                                                                                                    Assign Agents
                                                                                                                </button>
                                                                                                            </div>`}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading account details:', error);
                        $('#account-details-container').html(`
                            <div class="alert alert-danger">
                                Failed to load account details. Please try again.
                                <br><small>Error: ${error}</small>
                            </div>
                        `);
                    }
                });
            }

            $('#saveSettings').click(function() {
                const btn = $(this);
                btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-1"></span> Saving...');

                setTimeout(function() {
                    btn.prop('disabled', false).text('Save Changes');
                    $('#settingsModal').modal('hide');
                    toastr.success('Settings saved successfully');
                }, 1500);
            });

            $('#sync-templates').click(function(e) {
                e.preventDefault();
                const accountId = $('.account-selector.active').data('account-id');
                if (!accountId) {
                    toastr.warning('Please select an account first');
                    return;
                }

                toastr.info('Syncing templates...');

                $.ajax({
                    url: '{{ route('plugins.whatsapp.templates.sync') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        account_id: accountId
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        loadAccountDetails(accountId);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Failed to sync templates');
                    }
                });
            });

            $('#refresh-account').click(function(e) {
                e.preventDefault();
                const accountId = $('.account-selector.active').data('account-id');
                if (!accountId) {
                    toastr.warning('Please select an account first');
                    return;
                }

                loadAccountDetails(accountId);
                toastr.success('Account details refreshed');
            });

            $(document).on('submit', '#assignAgentsForm', function(e) {
                e.preventDefault();

                const btn = $('#saveAgentsBtn');
                const spinner = $('#saveSpinner');

                btn.prop('disabled', true);
                spinner.removeClass('d-none');

                $.ajax({
                    url: '{{ route('plugins.whatsapp.assign-agents') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#manageAgentsModal').modal('hide');
                        toastr.success(response.message);

                        const accountId = $('.account-selector.active').data('account-id');
                        if (accountId) {
                            loadAccountDetails(accountId);
                        }
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON?.message || 'Failed to assign agents';
                        toastr.error(error);
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                        spinner.addClass('d-none');
                    }
                });
            });
        });
    </script>
@endsection
