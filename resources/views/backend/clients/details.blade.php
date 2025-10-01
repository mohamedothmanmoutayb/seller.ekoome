@extends('backend.layouts.app')
@section('css')
    <style>
        .avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: black
        }

        .avatar-initial {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
        }

        .avatar-xl {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }

        .avatar-sm {
            width: 30px;
            height: 30px;
            font-size: 0.875rem;
        }

        .alert {
            padding: 0.5rem 1rem;
            margin-bottom: 0;
            border-radius: 0.25rem;
        }

        .alert-success {
            color: #0f5132;
            background-color: #d1e7dd;
            border-color: #badbcc;
        }

        .alert-danger {
            color: #842029;
            background-color: #f8d7da;
            border-color: #f5c2c7;
        }

        .spinner-border {
            vertical-align: middle;
        }

        .variable-input:disabled {
            background-color: #f8f9fa;
            opacity: 1; 
            cursor: not-allowed;
        }

        select option:disabled {
            color: #ccc;
            background-color: #f8f9fa;
        }
    </style>
@endsection
@section('content')
    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-8">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="mb-4 mb-sm-0 card-title">Client Details: {{ $client->name }}</h4>
                </div>
            </div>
            <div class="col-4 text-end">
                <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#specialOfferModal">
                    <i class="ti ti-brand-whatsapp"></i> Send Special Offer
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Client Info Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between">
                    <h5>Client Information</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="avatar avatar-xl">
                            <span
                                class="avatar-initial rounded-circle bg-label-primary">{{ substr($client->name, 0, 1) }}</span>
                        </div>
                        <h4 class="mt-2">{{ $client->name }}</h4>
                        <p class="text-muted">
                            <a href="tel:{{ $client->phone }}">{{ $client->phone }}</a>
                            @if ($client->phone2)
                                <br><a href="tel:{{ $client->phone2 }}">{{ $client->phone2 }}</a>
                            @endif
                        </p>
                    </div>

                    <div class="mb-3">
                        <h6>Address</h6>
                        <p>{{ $client->address }}</p>
                        <p>{{ $client->city ?? 'The City Not Provided' }}, {{ $client->country->name ?? 'N/A' }}</p>
                    </div>

                    <div class="mb-3">
                        <h6>Customer Since</h6>
                        <p>{{ $client->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="mb-3">
                        <h6>Last Order</h6>
                        <p>{{ $lastOrderDate ? $lastOrderDate->format('M d, Y') : 'No orders yet' }}</p>
                    </div>
                </div>
            </div>

            <!-- Purchase Stats Card -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h5>Purchase Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <h4>{{ $totalOrders }}</h4>
                            <p class="text-muted mb-0">Total Orders</p>
                        </div>
                        <div class="col-6">
                            <h4>{{ number_format($totalSpent, 2) }} DH</h4>
                            <p class="text-muted mb-0">Total Spent</p>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <h4>{{ number_format($averageOrderValue, 2) }} DH</h4>
                        <p class="text-muted mb-0">Average Order Value</p>
                    </div>
                    @if ($averageDaysBetweenOrders)
                        <hr>
                        <div class="text-center">
                            <h4>{{ $averageDaysBetweenOrders }} days</h4>
                            <p class="text-muted mb-0">Avg. days between orders</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Seller Notes Card -->
            <div class="card mt-4">
                <div class="card-header bg-secondary text-white">
                    <h5>Seller Notes</h5>
                </div>
                <div class="card-body">
                    <form id="sellerNotesForm">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" id="seller_notes" name="seller_notes" rows="3"
                                placeholder="Add private notes about this client">{{ $client->seller_notes }}</textarea>
                            <div id="notesFeedback" class="mt-2"></div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2" id="saveNotesBtn">
                            <span id="saveNotesText">Save Notes</span>
                            <span id="saveNotesSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Favorite Products Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between">
                    <h5>Favorite Products</h5>
                    @if ($favoriteCategory)
                        <span>Prefers: {{ $favoriteCategory->name }}</span>
                    @endif
                </div>
                <div class="card-body">
                    @if ($favoriteProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Orders</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($favoriteProducts as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <img src="{{ $product->image }}" class="rounded" width="30"
                                                            height="30">
                                                    </div>
                                                    <span>{{ $product->name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $product->order_count }}</td>
                                            <td>
                                                <a href="https://wa.me/{{ $client->phone }}?text={{ urlencode("Hi $client->name, we have new stock of $product->name! Special price just for you!") }}"
                                                    class="btn btn-sm btn-success" target="_blank">
                                                    <i class="ti ti-brand-whatsapp"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No favorite products yet</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Potential Upsells Card -->
            <div class="card mt-4">
                <div class="card-header bg-warning text-white">
                    <h5>Recommended Upsells</h5>
                </div>
                <div class="card-body">
                    @php
                        $recommendedProducts = App\Models\Product::where('id_category', optional($favoriteCategory)->id)
                            ->whereNotIn('id', $favoriteProducts->pluck('id'))
                            ->inRandomOrder()
                            ->limit(3)
                            ->get();
                    @endphp

                    @if ($recommendedProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    @foreach ($recommendedProducts as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm me-2">
                                                        <img src="{{ $product->image }}" class="rounded" width="30"
                                                            height="30">
                                                    </div>
                                                    <span>{{ $product->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="https://wa.me/{{ $client->phone }}?text={{ urlencode("Hi $client->name, we think you'll love our $product->name! Special offer just for you!") }}"
                                                    class="btn btn-sm btn-success" target="_blank">
                                                    <i class="ti ti-brand-whatsapp"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No recommendations available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Orders Card -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5>Recent Orders</h5>
                </div>
                <div class="card-body">
                    @if ($leads->count() > 0)
                        <div class="timeline">
                            @foreach ($leads->take(3) as $lead)
                                <div class="timeline-item">
                                    <div class="timeline-time">{{ $lead->created_at->format('M d, Y') }}</div>
                                    <div class="timeline-content">
                                        <h6><a href="{{ route('leads.edit', $lead->id) }}">Order #{{ $lead->n_lead }}</a>
                                        </h6>
                                        <p><strong>Status:</strong>
                                            <span
                                                class="badge bg-{{ $lead->status_livrison == 'delivered' ? 'success' : 'warning' }}">
                                                {{ $lead->status_livrison }}
                                            </span>
                                        </p>
                                        <p><strong>Amount:</strong> {{ $lead->lead_value }} DH</p>
                                        @if ($lead->products->count() > 0)
                                            <p><strong>Products:</strong>
                                                {{ $lead->products->pluck('name')->implode(', ') }}
                                            </p>
                                        @endif
                                        <a href="{{ route('leads.edit', $lead->id) }}"
                                            class="btn btn-sm btn-primary mt-2">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if ($leads->count() > 3)
                            <div class="text-center mt-3">
                                <a href="#all-orders" class="btn btn-sm btn-primary">View All Orders</a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No orders found</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Communication History -->
            <div class="card mt-4">
                <div class="card-header bg-dark ">
                    <h5 class="text-white">Communication History</h5>
                </div>
                <div class="card-body">
                    @php
                        $communications = \App\Models\Communication::where('client_id', $client->id)
                            ->orderBy('created_at', 'DESC')
                            ->limit(3)
                            ->get();
                    @endphp

                    @if ($communications->count() > 0)
                        <div class="timeline">
                            @foreach ($communications as $comm)
                                <div class="timeline-item">
                                    <div class="timeline-time">{{ $comm->created_at->format('M d, Y') }}</div>
                                    <div class="timeline-content">
                                        <h6>{{ ucfirst($comm->type) }}</h6>
                                        <p><strong>By:</strong> {{ $comm->user->name ?? 'System' }}</p>
                                        <p><strong>Subject:</strong> {{ $comm->subject }}</p>
                                        <button class="btn btn-sm btn-info mt-2 view-message"
                                            data-message="{{ $comm->message }}">
                                            View Message
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No communication history</p>
                        </div>
                    @endif

                    <div class="text-center mt-3">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addCommunicationModal">
                            <i class="ti ti-plus"></i> Add Communication
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- All Orders Section with Pagination -->
    <div class="card mt-4" id="all-orders">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>All Orders</h5>
            <span>Showing {{ $leads->firstItem() }} to {{ $leads->lastItem() }} of {{ $leads->total() }} orders</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Products</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                            <tr>
                                <td>{{ $lead->n_lead }}</td>
                                <td>{{ $lead->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if ($lead->products->count() > 0)
                                        {{ $lead->products->pluck('name')->implode(', ') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="badge bg-{{ $lead->status_livrison == 'delivered' ? 'success' : 'warning' }}">
                                        {{ $lead->status_livrison }}
                                    </span>
                                </td>
                                <td>{{ $lead->lead_value }} DH</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-sm btn-primary">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="https://wa.me/{{ $client->phone }}?text={{ urlencode("Hi $client->name, regarding your order #$lead->n_lead from " . $lead->created_at->format('M d, Y')) }}"
                                            class="btn btn-sm btn-success" target="_blank">
                                            <i class="ti ti-brand-whatsapp"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Showing {{ $leads->firstItem() }} to {{ $leads->lastItem() }} of {{ $leads->total() }} orders
                </div>
                <div>
                    {{ $leads->withQueryString()->links('vendor.pagination.courier') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Add Communication Modal -->
    <div class="modal fade" id="addCommunicationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Communication</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('communications.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="type" required>
                                <option value="email">Email</option>
                                <option value="call">Phone Call</option>
                                <option value="whatsapp">WhatsApp</option>
                                <option value="sms">SMS</option>
                                <option value="meeting">Meeting</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" name="message" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Communication</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Message Modal -->
    <div class="modal fade" id="viewMessageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Communication Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="messageContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Special Offer Modal -->
    <div class="modal fade" id="specialOfferModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send Special Offer to {{ $client->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="sendOfferForm">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $client->id }}">
                    <input type="hidden" name="client_name" value="{{ $client->name }}">
                    <input type="hidden" name="phone" value="{{ $client->phone1 }}">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Select Offer Template</label>
                                    <select class="form-select" id="offerTemplate" name="template_id" required>
                                        <option value="">-- Select Template --</option>
                                        @foreach ($offerTemplates as $template)
                                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">WhatsApp Account</label>
                                    <select class="form-select" name="whatsapp_account_id" required>
                                        <option value="">-- Select WhatsApp Account --</option>
                                        @foreach ($whatsappAccounts as $account)
                                            <option value="{{ $account->id }}" 
                                                @if($account->status != 'active') disabled @endif>
                                                 {{ $account->phone_number }}
                                                @if($account->status != 'active') - {{ ucfirst($account->status) }} @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Select Product (Optional)</label>
                                    <select class="form-select" id="offerProduct" name="product_id">
                                        <option value="">-- No Product --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                {{ $product->name }} ({{ $product->price }} DH)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="variablesContainer">
                                    <!-- Dynamic variables will be inserted here -->
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Message Preview</h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="messagePreview" class="bg-light p-3 rounded" style="min-height: 200px;">
                                            Select a template to preview
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-brand-whatsapp"></i> Send Offer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div style="display: none" id="clientData" 
        data-name="{{ $client->name }}"
        data-phone="{{ $client->phone }}"
        data-city="{{ $client->city ?? '' }}"
        data-address="{{ $client->address }}">
    </div>

@endsection

        {{-- $(document).ready(function() {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            $('.view-message').click(function() {
                $('#messageContent').text($(this).data('message'));
                $('#viewMessageModal').modal('show');
            });

            $('.whatsapp-btn').click(function(e) {
                e.preventDefault();
                var phone = $(this).data('phone');
                var message = $(this).data('message');
                window.open('https://wa.me/' + phone + '?text=' + encodeURIComponent(message), '_blank');
            });




            $('#specialOfferModal').on('show.bs.modal', function() {
                $('#offerTemplate').val('');
                $('#templateLanguage').val('English');
                $('#offerProduct').val('');
                $('#variablesContainer').empty();
                $('#messagePreview').text('Select a template to preview');
            });

            $('#offerTemplate').change(function() {
                const templateId = $(this).val();
                const language = $('#templateLanguage').val();
                
                if (!templateId) {
                    $('#variablesContainer').empty();
                    $('#messagePreview').text('Select a template to preview');
                    return;
                }
                
                $.ajax({
                    url: '/whatsapp-offers/get-template-details',
                    method: 'POST',
                    data: {
                        _token: csrfToken,
                        id: templateId,
                        language: language
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.success) {
                            $('#messagePreview').html(response.template);
                            
                            const variables = extractVariables(response.template);
                            
                            generateVariableInputs(variables);
                        }
                    }
                });
            });

    $('#templateLanguage').change(function() {
        if ($('#offerTemplate').val()) {
            $('#offerTemplate').trigger('change');
        }
    });

    $('#offerProduct').change(function() {
        const product = $(this).find(':selected');
        const productName = product.text().split('(')[0].trim();
        const productPrice = product.data('price');
        
        $('input[name="product-name"]').val(productName);
        $('input[name="special-price"]').val(productPrice);
        
        updatePreview();
    });

    $('#sendOfferForm').submit(function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        
        $.ajax({
            url: '/whatsapp-offers/send-offer',
            method: 'POST',
            data: formData,
            beforeSend: function() {
            },
            success: function(response) {
                if (response.success) {
                    toastr.success('Offer sent successfully!');
                    $('#specialOfferModal').modal('hide');
                    
                    window.open(response.whatsapp_url, '_blank');
                } else {
                    toastr.error(response.message || 'Failed to send offer');
                }
            },
            error: function(xhr) {
                toastr.error('An error occurred while sending the offer');
            }
        });
    });

    function extractVariables(template) {
        const regex = /{{\s*([^}\s]+)\s*}}/g;
        const variables = [];
        let match;
        
        while ((match = regex.exec(template)) !== null) {
            variables.push(match[1]);
        }
        
        return [...new Set(variables)]; 
    }

    function generateVariableInputs(variables) {
        const container = $('#variablesContainer');
        container.empty();
        
        const commonVariables = {
            'customer-name': '',
            'customer-phone': '',
            'customer-city': '',
            'customer-address': ''
        };
        
        variables.forEach(variable => {
            const label = variable.replace(/-/g, ' ');
            let value = '';
            
            if (commonVariables[variable]) {
                value = commonVariables[variable];
            }
            
            const inputGroup = `
                <div class="mb-3">
                    <label class="form-label">${label}</label>
                    <input type="text" class="form-control" name="${variable}" value="${value}" 
                           oninput="updatePreview()">
                </div>
            `;
            
            container.append(inputGroup);
        });
        
        container.find('input').on('input', updatePreview);
    }

    window.updatePreview = function() {
        let template = $('#messagePreview').html();
        const variables = extractVariables(template);
        
        variables.forEach(variable => {
            const value = $(`input[name="${variable}"]`).val() || '';
            const regex = new RegExp(`{{\\s*${variable}\\s*}}`, 'g');
            template = template.replace(regex, value);
        });
        
        $('#messagePreview').html(template);
    };
        }); --}}
@section('script')
@verbatim

<script>
    $(document).ready(function() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        let currentTemplateContent = ''; 
        let currentVariables = []; 

        $('.view-message').click(function() {
            $('#messageContent').text($(this).data('message'));
            $('#viewMessageModal').modal('show');
        });

                    // $('#sellerNotesForm').submit(function(e) {
            //     e.preventDefault();

            //     var btn = $('#saveNotesBtn');
            //     var feedback = $('#notesFeedback');

            //     btn.prop('disabled', true);
            //     $('#saveNotesText').addClass('d-none');
            //     $('#saveNotesSpinner').removeClass('d-none');

            //     feedback.removeClass('alert-danger alert-success').html('');

            //     $.ajax({
            //         url: '{{ route('clients.addNote', $client->id) }}',
            //         type: 'POST',
            //         data: $(this).serialize(),
            //         success: function(response) {
            //             if (response.success) {
            //                 feedback.addClass('alert alert-success').html(
            //                     'Notes saved successfully!');

            //                 setTimeout(function() {
            //                     feedback.removeClass('alert alert-success').html('');
            //                 }, 3000);
            //             } else {
            //                 feedback.addClass('alert alert-danger').html(
            //                     'Error saving notes: ' + response.message);
            //             }
            //         },
            //         error: function(xhr) {
            //             var errorMessage = xhr.responseJSON?.message ||
            //                 'An error occurred while saving notes';
            //             feedback.addClass('alert alert-danger').html(errorMessage);
            //         },
            //         complete: function() {
            //             btn.prop('disabled', false);
            //             $('#saveNotesText').removeClass('d-none');
            //             $('#saveNotesSpinner').addClass('d-none');
            //         }
            //     });
            // });

        $('#specialOfferModal').on('show.bs.modal', function() {
            resetOfferForm();
        });

        $('#offerTemplate').change(function() {
            loadTemplate();
        });

        $('#templateLanguage').change(function() {
            if ($('#offerTemplate').val()) {
                loadTemplate();
            }
        });

        $('#offerProduct').change(function() {
            const product = $(this).find(':selected');
            if (product.val()) {
                $('input[name="product-name"]').val(product.text().split('(')[0].trim());
                $('input[name="special-price"]').val(product.data('price'));
                updatePreview();
            }
        });

        $('#sendOfferForm').submit(function(e) {
            e.preventDefault();
            if (!$('select[name="whatsapp_account_id"]').val()) {
                toastr.error('Please select a WhatsApp account');
                return;
            }
            sendOffer();
        });

        function resetOfferForm() {
            $('#offerTemplate').val('');
            $('#templateLanguage').val('English');
            $('#offerProduct').val('');
            $('#variablesContainer').empty();
            $('#messagePreview').text('Select a template to preview');
            currentTemplateContent = '';
            currentVariables = [];
        }

        function loadTemplate() {
    const templateId = $('#offerTemplate').val();
    const language = $('#templateLanguage').val();
    
    if (!templateId) {
        resetOfferForm();
        return;
    }
    
    showLoading(true);
    
    $.ajax({
        url: '/whatsapp-offers/get-template-details',
        method: 'POST',
        data: {
            _token: csrfToken,
            id: templateId,
            language: language
        },
        success: function(response) {
            if (response.success) {
                currentTemplateContent = response.template;
                $('#messagePreview').html(response.template);
                
                currentVariables = extractVariables(response.template);
                generateVariableInputs(currentVariables);
                prefillClientInfo();
            } else {
                toastr.error(response.message || 'Failed to load template');
            }
        },
        error: function() {
            toastr.error('Error loading template');
        },
        complete: function() {
            showLoading(false);
        }
    });
}
        function extractVariables(template) {
            const regex = /{{\s*([^}\s]+)\s*}}/g;
            const variables = [];
            let match;
            
            while ((match = regex.exec(template)) !== null) {
                variables.push(match[1]);
            }
            
            return [...new Set(variables)]; 
        }

        function generateVariableInputs(variables) {
            const container = $('#variablesContainer');
            container.empty();
            
            const disabledFields = [
                'customer-name',
                'customer-phone',
                'customer-city',
                'customer-address'
            ];
            
            variables.forEach(variable => {
                const label = variable.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                const inputId = `var-${variable}`;
                
                const isDisabled = disabledFields.includes(variable);
                
                const inputGroup = `
                    <div class="mb-3">
                        <label for="${inputId}" class="form-label">${label}</label>
                        <input type="text" class="form-control variable-input" 
                            id="${inputId}" name="${variable}" 
                            ${isDisabled ? 'disabled' : ''}
                            oninput="updatePreview()">
                        ${isDisabled ? '<input type="hidden" name="' + variable + '" value="">' : ''}
                    </div>
                `;
                
                container.append(inputGroup);
            });
        }

        function prefillClientInfo() {
            const clientData = $('#clientData');
            const clientInfo = {
                'customer-name': clientData.data('name'),
                'customer-phone': clientData.data('phone'),
                'customer-city': clientData.data('city'),
                'customer-address': clientData.data('address')
            };
            
            Object.keys(clientInfo).forEach(key => {
                const input = $(`input[name="${key}"]`);
                const hiddenInput = $(`input[name="${key}"][type="hidden"]`);
                
                if (input.length && clientInfo[key]) {
                    if (input.is(':disabled')) {
                        input.val(clientInfo[key]);
                        hiddenInput.val(clientInfo[key]);
                    } else {
                        input.val(clientInfo[key]);
                    }
                    updatePreview();
                }
            });
        }

        window.updatePreview = function() {
            if (!currentTemplateContent) return;
            
            let updatedContent = currentTemplateContent;
            
            currentVariables.forEach(variable => {
                const value = $(`input[name="${variable}"]`).val() || '';
                const regex = new RegExp(`{{\\s*${variable}\\s*}}`, 'g');
                updatedContent = updatedContent.replace(regex, value);
            });
            
            $('#messagePreview').html(updatedContent);
        };

        function sendOffer() {
            showLoading(true);
            
            $.ajax({
                url: '/whatsapp-offers/send-offer',
                method: 'POST',
                data: $('#sendOfferForm').serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success('Offer sent successfully!');
                        $('#specialOfferModal').modal('hide');
                        window.open(response.whatsapp_url, '_blank');
                    } else {
                        toastr.error(response.message || 'Failed to send offer');
                    }
                },
                error: function() {
                    toastr.error('An error occurred while sending the offer');
                },
                complete: function() {
                    showLoading(false);
                }
            });
        }

        function showLoading(show) {
            if (show) {
                $('#specialOfferModal').find('button[type="submit"]').prop('disabled', true).prepend(
                    '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>'
                );
            } else {
                $('#specialOfferModal').find('button[type="submit"]').prop('disabled', false).find('.spinner-border').remove();
            }
        }

        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    });
</script>
@endverbatim
@endsection
