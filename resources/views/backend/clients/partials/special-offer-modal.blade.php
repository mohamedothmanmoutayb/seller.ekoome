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
                <input type="hidden" name="phone" value="{{ $client->phone }}">

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
                                <label class="form-label">Language</label>
                                <select class="form-select" id="templateLanguage" name="language" required>
                                    <option value="English">English</option>
                                    <option value="French">French</option>
                                    <option value="Arabic">Arabic</option>
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
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6>Message Preview</h6>
                                </div>
                                <div class="card-body whatsapp-preview">
                                    <div class="whatsapp-default-message">
                                        Select a template to preview
                                    </div>
                                    <div class="whatsapp-message-bubble" style="display: none;">
                                        <div class="message-text"></div>
                                        <div class="message-time">
                                            <span class="time"></span>
                                            <span class="message-status">✓✓</span>
                                        </div>
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
