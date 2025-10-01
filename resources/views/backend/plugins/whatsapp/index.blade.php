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

        <!-- Metrics Dashboard -->
        <div class="row mb-4">
            <!-- Total Conversations -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                <i class="ti ti-messages text-primary fs-8"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1">Total Conversations</p>
                                <h3 class="mb-0" id="total-conversations">0</h3>
                                <small class="text-muted" id="active-conversations-text">0 active</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Clients -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                                <i class="ti ti-users text-success fs-8"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1">Unique Clients</p>
                                <h3 class="mb-0" id="total-clients">0</h3>
                                <small class="text-muted" id="assigned-agents-text">0 agents</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Activity -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 p-3 rounded me-3">
                                <i class="ti ti-brand-whatsapp text-info fs-8"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1">Today's Messages</p>
                                <h3 class="mb-0" id="messages-today">0</h3>
                                <small class="text-muted" id="message-breakdown-text">0 sent / 0 received</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                                <i class="ti ti-clock text-warning fs-8"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1">Avg Response Time</p>
                                <h3 class="mb-0" id="avg-response-time">0m</h3>
                                <small class="text-muted" id="response-rate-text">0% response rate</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row - Additional Metrics -->
        <div class="row mb-4">
            <div class="col-xl-2 col-md-4 col-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle d-inline-flex mb-2">
                            <i class="ti ti-template text-primary fs-6"></i>
                        </div>
                        <p class="text-muted mb-1">Templates</p>
                        <h4 class="mb-0" id="templates-used">0</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="bg-success bg-opacity-10 p-2 rounded-circle d-inline-flex mb-2">
                            <i class="ti ti-flow-branch text-success fs-6"></i>
                        </div>
                        <p class="text-muted mb-1">Flows</p>
                        <h4 class="mb-0" id="flows-used">0</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="bg-info bg-opacity-10 p-2 rounded-circle d-inline-flex mb-2">
                            <i class="ti ti-user-check text-info fs-6"></i>
                        </div>
                        <p class="text-muted mb-1">Agents</p>
                        <h4 class="mb-0" id="assigned-agents">0</h4>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="bg-warning bg-opacity-10 p-2 rounded-circle d-inline-flex mb-2">
                            <i class="ti ti-calendar text-warning fs-6"></i>
                        </div>
                        <p class="text-muted mb-1">Connected</p>
                        <h6 class="mb-0" id="connected-since">N/A</h6>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="bg-secondary bg-opacity-10 p-2 rounded-circle d-inline-flex mb-2">
                            <i class="ti ti-refresh text-secondary fs-6"></i>
                        </div>
                        <p class="text-muted mb-1">Last Sync</p>
                        <h6 class="mb-0" id="last-sync">Never</h6>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="bg-danger bg-opacity-10 p-2 rounded-circle d-inline-flex mb-2">
                            <i class="ti ti-status-change text-danger fs-6"></i>
                        </div>
                        <p class="text-muted mb-1">Status</p>
                        <h6 class="mb-0" id="account-status">
                            <span class="badge bg-success">Active</span>
                        </h6>
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
                                <a href="#" class="list-group-item list-group-item-action account-selector p-3"
                                    data-account-id="{{ $account->id }}">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="ti ti-brand-whatsapp text-success me-2"></i>
                                                <strong>{{ $account->phone_number }}</strong>
                                            </div>
                                            {{-- <div class="text-muted small">
                                                <span class="badge bg-light text-dark me-2">
                                                    <i class="ti ti-template me-1"></i> {{ $account->templates_count }}
                                                </span>
                                                <span class="badge bg-light text-dark">
                                                    <i class="ti ti-flow-branch me-1"></i> {{ $account->flows_count }}
                                                </span>
                                            </div> --}}
                                        </div>
                                        <span
                                            class="badge bg-{{ $account->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($account->status) }}
                                        </span>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-4">
                                    <img src="{{ asset('public/empty-state.svg') }}" width="120"
                                        class="img-fluid mb-3">
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
                            <button class="btn btn-outline-primary text-start" id="chatbot-status-btn">
                                <i class="ti ti-robot me-2"></i> Chatbot Status
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

    <!-- Chatbot Status Modal -->
    <div class="modal fade" id="chatbotStatusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chatbot Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="ti ti-info-circle me-2"></i>
                        Control the chatbot status for: <strong id="current-account-phone"></strong>
                    </div>

                    <form id="chatbotStatusForm">
                        <input type="hidden" id="chatbot-account-id" name="account_id">

                        <div class="mb-4">
                            <h6 class="mb-3">Chatbot Status</h6>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="chatbotStatusToggle" name="status">
                                <label class="form-check-label" for="chatbotStatusToggle" id="chatbotStatusLabel">
                                    Chatbot is <span class="text-danger">Inactive</span>
                                </label>
                            </div>
                            <small class="text-muted">
                                When active, the chatbot will automatically respond to incoming messages based on your
                                configured flows and templates.
                            </small>
                        </div>

                        <div class="alert alert-warning" id="inactive-warning" style="display: none;">
                            <i class="ti ti-alert-triangle me-2"></i>
                            When inactive, only manual responses will be sent. Automated flows and templates will not
                            trigger.
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveChatbotStatus">
                        <i class="ti ti-check me-1"></i> Save Status
                    </button>
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

        const launchWhatsAppSignup = () => {
            $('#statusModal').modal('show');

            const INTERMEDIATE_APP_URL = 'https://intermediary.ekoome.com';

            const state = Math.random().toString(36).substring(2, 15) +
                Math.random().toString(36).substring(2, 15);

            const embeddedSignupUrl = `${INTERMEDIATE_APP_URL}/whatsapp/embedded-signup?` + $.param({
                redirect_uri: window.location.href,
                state: state
            });

            const popup = window.open(
                embeddedSignupUrl,
                'whatsapp_signup',
                'width=600,height=700,scrollbars=yes,resizable=yes'
            );

            window.addEventListener('message', function(event) {
                if (!event.origin.startsWith(INTERMEDIATE_APP_URL)) return;

                try {
                    const data = JSON.parse(event.data);
                    if (data.type === 'WA_EMBEDDED_SIGNUP') {
                        handleEmbeddedSignupEvent(data);
                    }
                } catch (e) {
                    console.log('Message from popup: ', event.data);
                }
            });

        }


        function handleEmbeddedSignupEvent(data) {
            console.log('Received embedded signup event from intermediate app: ', data);

            waba_id = data.data.waba_id;
            phone_number_id = data.data.phone_number_id;
            business_id = data.data.business_id;
            code = data.code;

            if (data.event === 'STARTED') {
                $('#statusModal').modal('show');
            } else if (data.event === 'COMPLETE') {
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
                        console.log('Connected account ID:', response.account.id);
                        console.log(response.account);

                        connectedAccountId = response.account.id;

                        setTimeout(() => {
                            showAgentAssignmentModal();
                        }, 1000);
                    },
                    error: function(xhr) {
                        $('#statusModal').modal('hide');
                        toastr.error('Failed to complete WhatsApp connection');
                    }
                });
            } else if (data.event === 'ERROR') {
                $('#statusModal').modal('hide');
                toastr.error('Failed to connect WhatsApp account: ' + data.data.errorMessage);
            }
        }


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
                    const roleBadge = agent.id_role == 4 ? 'bg-primary' : 'bg-success';
                    const roleText = agent.id_role == 4 ? 'Manager' : 'Agent';

                    agentsList.append(`
                        <div class="form-check mb-2">
                            <input class="form-check-input agent-checkbox" type="checkbox" 
                                   value="${agent.id}" id="agent-${agent.id}">
                            <label class="form-check-label d-flex justify-content-between align-items-start w-100" for="agent-${agent.id}">
                                <span>
                                    <strong>${agent.name}</strong>
                                    <br>
                                    <small class="text-muted">${agent.email}</small>
                                </span>
                                <span class="badge p-2 ${roleBadge}">${roleText}</span>
                            </label>
                        </div>
                    `);
                });
                $('#assign-agents-btn').prop('disabled', false);
            }

            $('#agentAssignmentModal').modal('show');
        }

        window.manageAgents = function(accountId) {
            showAgentAssignmentModalForExisting(accountId);
        }
        const showAgentAssignmentModalForExisting = (accountId) => {
            connectedAccountId = accountId;

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
                $.ajax({
                    url: '{{ route('plugins.whatsapp.account.details') }}',
                    type: 'GET',
                    data: {
                        account_id: accountId
                    },
                    success: function(response) {
                        const assignedAgentIds = response.assigned_agents ?
                            response.assigned_agents.filter(agent => agent !== null).map(agent => agent
                                .id) : [];

                        agents.forEach(agent => {
                            const isChecked = assignedAgentIds.includes(agent.id);
                            const roleBadge = agent.id_role == 4 ? 'bg-primary' : 'bg-success';
                            const roleText = agent.id_role == 4 ? 'Manager' : 'Agent';

                            agentsList.append(`
                        <div class="form-check mb-2">
                            <input class="form-check-input agent-checkbox" type="checkbox" 
                                   value="${agent.id}" id="agent-${agent.id}" ${isChecked ? 'checked' : ''}>
                            <label class="form-check-label d-flex justify-content-between align-items-start w-100" for="agent-${agent.id}">
                                <span>
                                    <strong>${agent.name}</strong>
                                    <br>
                                    <small class="text-muted">${agent.email}</small>
                                </span>
                                <span class="badge p-2 ${roleBadge}">${roleText}</span>
                            </label>
                        </div>
                    `);
                        });

                        $('#connected-phone-number').text(response.account.phone_number);
                        $('#assign-agents-btn').prop('disabled', false);
                    },
                    error: function(xhr) {
                        console.error('Error loading account details:', xhr);
                        toastr.error('Failed to load current assignments');
                    }
                });
            }

            $('#agentAssignmentModal').modal('show');
        }

        loadChatbotStatus = function(accountId, phoneNumber) {
            $('#current-account-phone').text(phoneNumber);
            $('#chatbot-account-id').val(accountId);

            $('#chatbotStatusToggle').prop('checked', false);
            updateStatusLabel(false);

            $.ajax({
                url: '/plugins/whatsapp/account/' + accountId + '/chatbot-status',
                type: 'GET',
                success: function(response) {
                    $('#chatbotStatusToggle').prop('checked', response.status === 'active');
                    updateStatusLabel(response.status === 'active');
                },
                error: function() {
                    $('#chatbotStatusToggle').prop('checked', false);
                    updateStatusLabel(false);
                },
                complete: function() {
                    $('#chatbotStatusModal').modal('show');
                }
            });
        };

        function updateStatusLabel(isActive) {
            const label = $('#chatbotStatusLabel');
            const warning = $('#inactive-warning');

            if (isActive) {
                label.html('Chatbot is <span class="text-success">Active</span>');
                warning.hide();
            } else {
                label.html('Chatbot is <span class="text-danger">Inactive</span>');
                warning.show();
            }
        }

        function saveChatbotStatus() {
            const accountId = $('#chatbot-account-id').val();
            const isActive = $('#chatbotStatusToggle').is(':checked');
            const status = isActive ? 'active' : 'inactive';

            const btn = $('#saveChatbotStatus');
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');

            $.ajax({
                url: '/plugins/whatsapp/account/' + accountId + '/chatbot-status',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    btn.prop('disabled', false).html('<i class="ti ti-check me-1"></i> Save Status');
                    $('#chatbotStatusModal').modal('hide');
                    toastr.success('Chatbot status updated successfully');

                    updateAccountStatusUI(accountId, status);
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html('<i class="ti ti-check me-1"></i> Save Status');
                    toastr.error('Failed to update chatbot status');
                }
            });
        }

        function updateAccountStatusUI(accountId, status) {
            const accountBadge = $('.account-selector[data-account-id="' + accountId + '"] .badge');
            if (accountBadge.length) {
                const badgeClass = status === 'active' ? 'bg-success' : 'bg-secondary';
                const badgeText = status === 'active' ? 'Active' : 'Inactive';

                accountBadge.removeClass('bg-success bg-secondary').addClass(badgeClass).text(badgeText);
            }
        }


        $(document).ready(function() {
            const firstAccount = $('.account-selector').first();
            if (firstAccount.length) {
                const accountId = firstAccount.data('account-id');
                loadAccountMetrics(accountId);
                loadAccountDetails(accountId);
                firstAccount.addClass('active');
            }

            $('#chatbot-status-btn').click(function() {
                const activeAccount = $('.account-selector.active');
                if (!activeAccount.length) {
                    toastr.warning('Please select a WhatsApp account first');
                    return;
                }

                const accountId = activeAccount.data('account-id');
                const phoneNumber = activeAccount.find('strong').text();

                loadChatbotStatus(accountId, phoneNumber);
            });

            $('#chatbotStatusToggle').change(function() {
                updateStatusLabel($(this).is(':checked'));
            });

            $('#saveChatbotStatus').click(function() {
                saveChatbotStatus();
            });

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
                loadAccountMetrics(accountId);
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
                                            <button class="btn btn-sm btn-outline-primary" onclick="showAgentAssignmentModalForExisting(${response.account.id})">
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

            function loadAccountMetrics(accountId) {
                $.ajax({
                    url: `/plugins/whatsapp/account/${accountId}/metrics`,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            updateMetricsDashboard(response.metrics);
                        } else {
                            console.error('Failed to load metrics:', response.message);
                            updateMetricsDashboard(response.metrics);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading metrics:', xhr);
                        updateMetricsDashboard(getDefaultMetrics());
                    }
                });
            }

            function updateMetricsDashboard(metrics) {
                $('#total-conversations').text(metrics.total_conversations.toLocaleString());
                $('#total-clients').text(metrics.total_clients.toLocaleString());
                $('#messages-today').text(metrics.messages_today.toLocaleString());
                $('#avg-response-time').text(metrics.avg_response_time + 'm');

                $('#active-conversations-text').text(metrics.active_conversations + ' active');
                $('#assigned-agents-text').text(metrics.assigned_agents + ' agents');
                $('#message-breakdown-text').text(metrics.sent_today + ' sent / ' + metrics.received_today +
                    ' received');
                $('#response-rate-text').text(metrics.response_rate + '% response rate');

                $('#templates-used').text(metrics.templates_used);
                $('#flows-used').text(metrics.flows_used);
                $('#assigned-agents').text(metrics.assigned_agents);
                $('#connected-since').text(metrics.connected_since);
                $('#last-sync').text(metrics.last_sync);

                const statusBadge = metrics.account_status === 'active' ?
                    'bg-success' : metrics.account_status === 'inactive' ?
                    'bg-secondary' : 'bg-warning';

                $('#account-status').html(`<span class="badge ${statusBadge}">${metrics.account_status}</span>`);

                console.log('Account metrics loaded:', metrics);
            }

            function getDefaultMetrics() {
                return {
                    total_conversations: 0,
                    total_clients: 0,
                    active_conversations: 0,
                    messages_today: 0,
                    sent_today: 0,
                    received_today: 0,
                    response_rate: 0,
                    avg_response_time: 0,
                    templates_used: 0,
                    flows_used: 0,
                    assigned_agents: 0,
                    account_status: 'unknown',
                    connected_since: 'N/A',
                    last_sync: 'Never'
                };
            }

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
        });
    </script>
@endsection
