@extends('backend.layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --primary: #25D366;
            --primary-dark: #128C7E;
            --secondary: #075E54;
            --light: #F0F2F5;
            --dark: #3C3C3C;
            --gray: #667781;
            --border: #E6E6E6;
            --success: #34B7F1;
            --danger: #FF3B30;
            --warning: #FF9500;
        }

        .template-preview-container {
            padding: 15px;
        }

        .template-preview-container h6 {
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .preview-section {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .preview-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .modal-lg {
            max-width: 800px;
        }

        .bulk-actions {
            display: none;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .dataTables_wrapper .row {
            margin: 10px 0;
        }

        table.dataTable tbody tr.selected {
            background-color: rgba(13, 110, 253, 0.1);
        }

        .filter-card {
            margin-bottom: 20px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .filter-header {
            cursor: pointer;
            padding: 10px 15px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
        }

        .filter-body {
            padding: 15px;
        }

        .filter-row {
            margin-bottom: 15px;
        }

        .card-header {
            background-color: rgba(0, 0, 0, 0.03);
        }

        .badge-approved {
            background-color: #198754;
        }

        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }

        .badge-rejected {
            background-color: #dc3545;
        }

        .badge-disabled {
            background-color: #6c757d;
        }

        .btn-filter {
            background-color: #6f42c1;
            color: white;
        }

        .btn-filter:hover {
            background-color: #5a2d9c;
            color: white;
        }

        .loading-overlay {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .pagination-info {
            margin-top: 8px;
        }

        /* WhatsApp Preview Styles */
        .preview-sticky-container {
            position: sticky;
            top: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            will-change: transform;
        }

        .preview-container {
            background: #E5DDD5;
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-top: 25px;
            transition: all 0.3s ease;
        }

        .preview-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(0, 0, 0, 0.1);
        }

        .preview-header {
            background: var(--secondary);
            padding: 15px 20px;
            color: white;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .preview-header .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .preview-header .name {
            font-weight: 500;
            font-size: 16px;
        }

        .preview-body {
            padding: 25px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            background: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png') center;
            background-size: 500px;
            min-height: 400px;
        }

        .preview-message {
            max-width: 88%;
            padding: 7px 15px;
            border-radius: 8px;
            position: relative;
            font-size: 15px;
            line-height: 1.2;
        }

        .preview-message.incoming {
            background: white;
            align-self: flex-start;
            border-top-left-radius: 0;
        }

        .preview-message.outgoing {
            background: #DCF8C6;
            align-self: flex-end;
            border-top-right-radius: 0;
            width: 79%;
        }

        .preview-message .header {
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--secondary);
        }

        .preview-message .content {
            line-height: 1.6;
        }

        .preview-message .footer {
            margin-top: 15px;
            font-size: 0.8rem;
            color: var(--gray);
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            padding-top: 10px;
        }

        .preview-message .buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 15px;
            width: 100%;
        }

        .preview-message .button {
            width: 100%;
            text-align: center;
            padding: 10px 15px;
            border-radius: 20px;
            background: white;
            border: 1px solid var(--border);
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .preview-message .button:hover {
            background: #f0f0f0;
        }

        .offer-preview {
            background: #fff8e1;
            border: 1px solid #ffd54f;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .offer-preview-title {
            font-weight: bold;
            color: var(--secondary);
            margin-bottom: 5px;
        }

        .offer-preview-timer {
            font-size: 0.8rem;
            color: var(--danger);
            margin-top: 5px;
        }

        .header-media img,
        .header-media video {
            max-width: 100%;
            border-radius: 8px;
        }

        .header-media {
            text-align: center;
            padding: 15px;
            background: #f0f0f0;
            border-radius: 8px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-space-between">
                        <div class="d-flex align-items-center gap-4">
                            <h4 class="mb-4 mb-sm-0 card-title"> WhatsApp Templates for Business Account
                                #{{ $businessAccount->name }}
                            </h4>
                            <a href="{{ route('whatsapp-templates.create', $accountId) }}"
                                class="btn btn-primary btn-sm">Create New Template</a>
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
        <div class="card mt-4">
            <div class="card-body position-relative">
                <div class="loading-overlay" id="loadingOverlay">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <!-- Filters Card -->
                <div class="card filter-card mb-4">
                    <div class="filter-header d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                        href="#filterCollapse">
                        <h5 class="m-0">Filters</h5>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="collapse show" id="filterCollapse">
                        <div class="filter-body">
                            <div class="row filter-row">
                                <div class="col-md-3">
                                    <label for="nameFilter" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="nameFilter" placeholder="Search by name">
                                </div>
                                <div class="col-md-3">
                                    <label for="categoryFilter" class="form-label">Category</label>
                                    <select class="form-select" id="categoryFilter">
                                        <option value="">All Categories</option>
                                        <option value="MARKETING">Marketing</option>
                                        <option value="UTILITY">Utility</option>
                                        <option value="AUTHENTICATION">Authentication</option>
                                        <option value="TRANSACTIONAL">Transactional</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="statusFilter" class="form-label">Status</label>
                                    <select class="form-select" id="statusFilter">
                                        <option value="">All Statuses</option>
                                        <option value="approved">Approved</option>
                                        <option value="pending">Pending</option>
                                        <option value="rejected">Rejected</option>
                                        <option value="disabled">Disabled</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="languageFilter" class="form-label">Language</label>
                                    <select class="form-select" id="languageFilter">
                                        <option value="">All Languages</option>
                                        <option value="en_US">English</option>
                                        <option value="ar_AR">Arabic</option>
                                        <option value="es_ES">Spanish</option>
                                        <option value="fr_FR">French</option>
                                        <option value="de_DE">German</option>
                                        <option value="pt_BR">Portuguese</option>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button id="applyFilters" class="btn btn-filter me-2">
                                    <i class="bi bi-funnel"></i> Apply Filters
                                </button>
                                <button id="clearFilters" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Clear Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bulk Actions -->
                <div id="bulkActions" class="bulk-actions">
                    <p style="margin: 0">
                        <span id="selectedCount">0</span> template(s) selected
                    </p>
                    <div>
                        <button id="deleteSelected" class="btn btn-sm btn-danger ms-3">
                            <i class="fas fa-trash"></i> Delete Selected
                        </button>
                        <button id="clearSelection" class="btn btn-sm btn-secondary ms-2">
                            <i class="fas fa-times"></i> Clear Selection
                        </button>
                    </div>
                </div>

                <!-- Templates Table -->
                <table id="templatesTable" class="table table-hover w-100">
                    <thead>
                        <tr>
                            <th width="30px">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Language</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th width="100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Template Preview Modal -->
    <div class="modal fade" id="templatePreviewModal" tabindex="-1" aria-labelledby="templatePreviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="templatePreviewModalLabel">Template Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="preview-container">
                        <div class="preview-header">
                            <div class="avatar">
                                <i class="fas fa-store"></i>
                            </div>
                            <div class="name">Business Name</div>
                        </div>
                        <div class="preview-body">
                            <div class="preview-message incoming">
                                Hello! Here's your template preview
                            </div>
                            <div class="preview-message outgoing" id="preview-content">
                                <!-- Preview content will be loaded here -->
                            </div>
                        </div>
                    </div>

                    <!-- Template Details -->
                    <div class="template-preview-container mt-4">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6>Basic Information</h6>
                                <p><strong>Name:</strong> <span id="preview-name"></span></p>
                                <p><strong>Category:</strong> <span id="preview-category"></span></p>
                                <p><strong>Language:</strong> <span id="preview-language"></span></p>
                            </div>
                            <div class="col-md-6">
                                <h6>Status</h6>
                                <span class="badge" id="preview-status"></span>
                                <p class="mt-2"><strong>Template ID:</strong> <span id="preview-template-id"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var templatesTable = $('#templatesTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('whatsapp-templates.data', $accountId) }}',
                    data: function(d) {
                        d.name = $('#nameFilter').val();
                        d.category = $('#categoryFilter').val();
                        d.status = $('#statusFilter').val();
                        d.language = $('#languageFilter').val();
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row) {
                            return '<input type="checkbox" class="template-checkbox" value="' + row
                                .id + '">';
                        },
                        orderable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'language',
                        name: 'language'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row) {
                            var badgeClass = 'badge-';
                            switch (data) {
                                case 'approved':
                                    badgeClass += 'approved';
                                    break;
                                case 'pending':
                                    badgeClass += 'pending';
                                    break;
                                case 'rejected':
                                    badgeClass += 'rejected';
                                    break;

                                case 'failed':
                                    badgeClass += 'rejected';
                                    break;
                                case 'disabled':
                                    badgeClass += 'disabled';
                                    break;
                                default:
                                    badgeClass += 'secondary';
                            }
                            return '<span class="badge ' + badgeClass + '">' + data.charAt(0)
                                .toUpperCase() + data.slice(1) + '</span>';
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            return new Date(data).toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <button class="btn btn-sm btn-info view-template-btn" data-template-id="${row.id}" data-account-id="${row.business_account_id}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-template-btn" data-template-id="${row.id}" data-account-id="${row.business_account_id}" data-template-name="${row.name}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            `;
                        },
                        orderable: false
                    }
                ],
                dom: '<"row"<"col-md-6"B><"col-md-6"f>>rtip',
                buttons: [{
                        extend: 'copy',
                        className: 'btn btn-sm btn-outline-secondary'
                    },
                    {
                        extend: 'csv',
                        className: 'btn btn-sm btn-outline-secondary'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-sm btn-outline-secondary'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-sm btn-outline-secondary'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-sm btn-outline-secondary'
                    }
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                order: [
                    [5, 'desc']
                ],
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
                }
            });


            // Filter functionality
            function applyFilters() {
                templatesTable.ajax.reload();
            }

            $('#applyFilters').on('click', function() {
                applyFilters();
            });

            $('#clearFilters').on('click', function() {
                $('#nameFilter').val('');
                $('#categoryFilter').val('');
                $('#statusFilter').val('');
                $('#languageFilter').val('');
                templatesTable.ajax.reload();
            });

            $('#selectAll').on('click', function() {
                var isChecked = $(this).prop('checked');
                $('.template-checkbox').prop('checked', isChecked);
                updateBulkActions();
            });

            $('#templatesTable tbody').on('change', '.template-checkbox', function() {
                updateBulkActions();
            });

            function updateBulkActions() {
                var selectedCount = $('.template-checkbox:checked').length;
                $('#selectedCount').text(selectedCount);

                if (selectedCount > 0) {
                    $('#bulkActions').addClass("d-flex align-items-center justify-content-between");
                } else {
                    $('#bulkActions').hide();
                }
            }

            $('#clearSelection').on('click', function() {
                $('.template-checkbox').prop('checked', false);
                $('#selectAll').prop('checked', false);
                updateBulkActions();
            });

            $('#deleteSelected').on('click', function() {
                var selectedIds = [];
                $('.template-checkbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length === 0) {
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete ${selectedIds.length} template(s). This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteTemplates(selectedIds);
                    }
                });
            });

            $(document).on('click', '.delete-template-btn', function() {
                var templateId = $(this).data('template-id');
                var accountId = $(this).data('account-id');
                var templateName = $(this).data('template-name');

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete template "${templateName}". This will also delete it from WhatsApp if it was approved.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteTemplates([templateId]);
                    }
                });
            });

            function deleteTemplates(templateIds) {
                $('#loadingOverlay').show();

                $.ajax({
                    url: '{{ route('whatsapp-templates.bulk-delete', $accountId) }}',
                    type: 'POST',
                    data: {
                        template_ids: templateIds
                    },
                    success: function(response) {
                        $('#loadingOverlay').hide();

                        if (response.success) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            ).then(() => {
                                templatesTable.ajax.reload();
                                updateBulkActions();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.error || 'Failed to delete templates.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        $('#loadingOverlay').hide();
                        Swal.fire(
                            'Error!',
                            xhr.responseJSON?.error ||
                            'An error occurred while deleting templates.',
                            'error'
                        );
                    }
                });
            }

            $(document).on('click', '.view-template-btn', function() {
                const templateId = $(this).data('template-id');
                const accountId = $(this).data('account-id');

                $('#loadingOverlay').show();

                $.get(`/whatsapp/business-accounts/${accountId}/templates/${templateId}`, function(data) {
                    $('#loadingOverlay').hide();

                    // Update template details
                    $('#preview-name').text(data.name);
                    $('#preview-category').text(data.category);
                    $('#preview-language').text(data.language);
                    $('#preview-template-id').text(data.template_id || 'N/A');

                    // Update status badge
                    const statusBadge = $('#preview-status');
                    statusBadge.removeClass(
                        'badge-approved badge-pending badge-rejected badge-disabled');

                    switch (data.status) {
                        case 'approved':
                            statusBadge.addClass('badge-approved').text('Approved');
                            break;
                        case 'pending':
                            statusBadge.addClass('badge-pending').text('Pending');
                            break;
                        case 'rejected':
                            statusBadge.addClass('badge-rejected').text('Rejected');
                            break;
                        case 'disabled':
                            statusBadge.addClass('badge-disabled').text('Disabled');
                            break;
                        default:
                            statusBadge.addClass('badge-secondary').text(data.status);
                    }

                    let previewHtml = '';

                    if (data.header) {
                        previewHtml += `
                            <div class="header">
                                <strong>${data.header}</strong>
                            </div>
                        `;
                    }

                    if (data.body) {
                        previewHtml += `
                            <div class="content">
                                ${data.body.replace(/\n/g, '<br>')}
                            </div>
                        `;
                    }

                    if (data.footer) {
                        previewHtml += `
                            <div class="footer">
                                ${data.footer}
                            </div>
                        `;
                    }

                    if (data.components && data.components.length > 0) {
                        let buttonsHtml = '<div class="buttons">';

                        data.components.forEach(component => {
                            if (component.type === 'BUTTONS' && component.buttons) {
                                component.buttons.forEach(button => {
                                    let buttonText = button.text || '';
                                    let buttonIcon = '';

                                    if (button.type === 'URL') {
                                        buttonIcon = '<i class="fas fa-link"></i> ';
                                    } else if (button.type === 'PHONE_NUMBER') {
                                        buttonIcon =
                                            '<i class="fas fa-phone"></i> ';
                                    } else if (button.type === 'QUICK_REPLY') {
                                        buttonIcon =
                                            '<i class="fas fa-reply"></i> ';
                                    }

                                    buttonsHtml += `
                                        <div class="button">
                                            ${buttonIcon}${buttonText}
                                        </div>
                                    `;
                                });
                            }
                        });

                        buttonsHtml += '</div>';
                        previewHtml += buttonsHtml;
                    }

                    $('#preview-content').html(previewHtml);
                    $('#templatePreviewModal').modal('show');

                }).fail(function() {
                    $('#loadingOverlay').hide();
                    Swal.fire(
                        'Error!',
                        'Failed to load template details.',
                        'error'
                    );
                });
            });
        });
    </script>
@endsection
