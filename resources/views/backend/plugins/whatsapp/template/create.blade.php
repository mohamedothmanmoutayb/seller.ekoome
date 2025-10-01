@extends('backend.layouts.app')
@section('css')
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

        html {
            scroll-behavior: smooth;
        }

        /* Base Template Styles */
        .template-builder {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 30px;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .template-header {
            padding: 25px 30px;
            background: #f8f9fa;
            border-bottom: 1px solid var(--border);
        }

        .template-header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .template-header p {
            color: var(--gray);
            margin-bottom: 0;
        }

        .template-body {
            padding: 30px;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary);
        }

        .form-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 211, 102, 0.2);
        }

        .form-note {
            font-size: 0.85rem;
            color: var(--gray);
            margin-top: 6px;
        }

        .help-link {
            font-size: 0.85rem;
            color: var(--primary);
            text-decoration: none;
            margin-left: 8px;
        }

        .help-link:hover {
            text-decoration: underline;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .radio-item input[type="radio"] {
            width: 18px;
            height: 18px;
        }

        .quick-reply-container {
            margin-top: 20px;
        }

        .quick-reply-item {
            background: #f8fafb;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quick-reply-item input {
            flex: 1;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 15px;
        }

        .btn-add-reply {
            background: var(--primary);
            color: white;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-add-reply:hover {
            background: var(--primary-dark);
        }

        .btn-add-reply:disabled {
            background: var(--gray);
            cursor: not-allowed;
        }

        .btn-remove-reply {
            background: var(--danger);
            color: white;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            cursor: pointer;
        }

        .preview-sticky-container {
            position: sticky;
            top: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            will-change: transform;
        }

        .preview-sticky-container.scrolling {
            top: 10px;
            transform: translateY(5px);
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

        #preview-header {
            margin: auto;
        }

        #preview-buttons {
            margin: auto;
            width: 100%;
        }

        #preview-body {
            font-size: 19px;
            color: var(--bs-heading-color);
        }

        #preview-footer {
            color: #7e8b96;
        }

        .coupon-text {
            font-size: 0.9rem;
            color: var(--gray);
            margin-top: 10px;
        }

        .coupon-input-container {
            margin-top: 15px;
            padding: 15px;
            background: #f8fafb;
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        .coupon-preview {
            background: white;
            border: 1px dashed #ffd54f;
            padding: 10px;
            border-radius: 8px;
            margin-top: 10px;
            font-size: 0.9rem;
        }

        .btn-submit {
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background: var(--secondary);
        }

        .btn-cancel {
            background: white;
            color: var(--dark);
            border: 1px solid var(--border);
            padding: 12px 25px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            margin-right: 10px;
        }

        .btn-cancel:hover {
            background: #f8f9fa;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid var(--border);
        }

        .variables-container {
            display: none;
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8fafb;
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        .media-upload-container {
            text-align: center;
            padding: 20px;
            border: 2px dashed var(--border);
            border-radius: 8px;
            cursor: pointer;
            margin-top: 20px;
        }

        .media-upload-container i {
            font-size: 48px;
            color: var(--gray);
            margin-bottom: 15px;
        }

        .media-upload-container p {
            color: var(--gray);
            margin-bottom: 0;
        }

        .media-preview {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            margin-top: 10px;
            display: none;
        }

        .remove-media {
            color: var(--danger);
            cursor: pointer;
            margin-top: 5px;
            display: block;
        }

        .offer-preview {
            background: #fff8e1;
            border: 1px solid #ffd54f;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        
        .offer-preview-title {
            font-weight: bold;
            color: var(--secondary);
            margin-bottom: 8px;
        }
        
        .offer-preview-timer {
            font-size: 0.9rem;
            color: var(--danger);
            margin-top: 10px;
            font-weight: 500;
        }

        .offer-code-preview {
            background: white;
            padding: 10px;
            border-radius: 6px;
            border: 1px dashed #ffd54f;
            margin-top: 10px;
            font-family: monospace;
        }
        
        .form-note.warning {
            color: var(--warning);
            font-weight: 500;
        }

        .preview-section {
            display: none;
        }

        .button-type-select {
            width: 120px;
            margin-right: 10px;
        }

        .button-input-container {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
        }

        .button-limit-warning {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 5px;
            display: none;
        }

        .max-buttons-reached .btn-add-reply {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .input-with-actions {
            position: relative;
        }

        .add-variable-btn {
            position: absolute;
            right: 10px;
            top: 10px;
            background: var(--primary);
            color: white;
            border: none;
            height: 30px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .add-variable-btn:hover {
            background: var(--primary-dark);
        }

        .character-counter {
            font-size: 0.8rem;
            color: var(--gray);
            text-align: right;
            margin-top: 5px;
        }

        .character-counter.near-limit {
            color: var(--warning);
        }

        .character-counter.over-limit {
            color: var(--danger);
            font-weight: bold;
        }

        .variable-list {
            margin-top: 10px;
            padding: 10px;
            background: #f8fafb;
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        .variable-item {
            display: inline-block;
            background: var(--light);
            padding: 4px 8px;
            border-radius: 4px;
            margin-right: 8px;
            margin-bottom: 8px;
            font-size: 0.85rem;
            color: var(--secondary);
            border: 1px solid var(--border);
        }

        .text-input-container {
            position: relative;
        }
        
        .offer-expiry-container {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        
        .offer-expiry-container input {
            flex: 1;
        }
        
        .offer-expiry-container select {
            width: 120px;
        }
        
        .variable-validation-error {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 8px;
            display: none;
        }

        /* New styles for variable selection */
        .variable-type-selector {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .variable-type-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .variable-type-option.selected {
            border-color: var(--primary);
            background-color: rgba(37, 211, 102, 0.1);
        }
        
        .variable-type-option input[type="radio"] {
            margin: 0;
        }
        
        .snake-case-hint {
            font-size: 0.8rem;
            color: var(--gray);
            margin-top: 5px;
        }

        .has-error {
            border-color: var(--danger) !important;
            box-shadow: 0 0 0 3px rgba(255, 59, 48, 0.2) !important;
        }
        
        .snake-case-error {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 5px;
            display: none;
        }
        
        .global-variable-type-selector {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8fafb;
            border-radius: 8px;
            border: 1px solid var(--border);
        }
    </style>
@endsection

@section('content')
    <div class="d-none">
        <input type="hidden" id="business-account-id" value="{{ $accountId }}">
    </div>
       <div class="template-builder">
            <div class="template-header">
                <h1>New Template</h1>
                <p>Create new template as per your needs. <a href="#" class="help-link">Learn more</a></p>
            </div>

            <div class="template-body">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Template Configuration Section -->
                        <div class="form-card">
                            <div class="section-title">Template Configuration</div>

                            <div class="form-group">
                                <label class="form-label">Template Category</label>
                                <select class="form-control" id="template-category">
                                    <option value="utility">Utility</option>
                                    <option value="marketing">Marketing</option>
                                    <option value="limited-time-offer">Limited Time Offer</option>
                                    <option value="catalogue">Catalogue</option>
                                </select>
                                <div class="form-note" id="category-description">
                                    Select the appropriate category for your template
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Template Name</label>
                                <input type="text" class="form-control" id="template-name" 
                                    placeholder="e.g. product_feedback">
                                <div class="snake-case-error" id="template-name-error" style="display: none;"></div>
                                <div class="form-note">Must be in snake_case format (e.g., order_confirmation, product_feedback)</div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Language</label>
                                <select class="form-control" id="template-language">
                                    <option value="en_US">English</option>
                                    <option value="ar_AR">Arabic</option>
                                    <option value="es_ES">Spanish</option>
                                    <option value="fr_FR">French</option>
                                    <option value="de_DE">German</option>
                                    <option value="pt_BR">Portuguese</option>
                                </select>
                            </div>
                        </div>

                        <!-- Global Variable Type Selection -->
                        <div class="form-card">
                            <div class="section-title">Variable Type</div>
                            <div class="global-variable-type-selector">
                                <div class="form-group">
                                    <label class="form-label">Choose Variable Type for Entire Template</label>
                                    <div class="variable-type-selector">
                                        <div class="variable-type-option selected" id="global-number-option">
                                            <input type="radio" id="global-variable-type-number" name="global-variable-type" value="number" checked>
                                            <label for="global-variable-type-number" style="cursor: pointer">Number Variables ({{1}}, {{2}}, etc.)</label>
                                        </div>
                                        <div class="variable-type-option" id="global-name-option">
                                            <input type="radio" id="global-variable-type-name" name="global-variable-type" value="name">
                                            <label for="global-variable-type-name" style="cursor: pointer">Named Variables ({{"first_name"}}, {{"order_number"}}, etc.)</label>
                                        </div>
                                    </div>
                                    <div class="snake-case-hint" id="global-snake-case-hint" style="display: none;">
                                        Use snake_case format for variable names (lowercase letters, numbers, and underscores)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Template Content Section -->
                        <div class="form-card">
                            <div class="section-title">Template Content</div>
                            <div id="template-header-container">
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" id="header-text" name="header-type" value="text" checked>
                                        <label for="header-text">Text</label>
                                    </div>  
                                    <div class="radio-item">
                                        <input type="radio" id="header-image" name="header-type" value="image">
                                        <label for="header-image">Image</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" id="header-video" name="header-type" value="video">
                                        <label for="header-video">Video</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" id="header-document" name="header-type" value="document">
                                        <label for="header-document">Document</label>
                                    </div>
                                </div>

                                <!-- Header Content -->
                                <div id="text-header-container">
                                    <div class="form-group">
                                        <label class="form-label">Header Text <span class="text-danger">*</span></label>
                                        <div class="text-input-container">
                                            <input type="text" class="form-control" id="header-content"
                                                placeholder="e.g. Thank You for Shopping!" maxlength="60">
                                            <button type="button" class="add-variable-btn" data-target="header-content">
                                                <i class="fas fa-plus" style="margin-right: 6px"></i> Add Variable
                                            </button>
                                        </div>
                                        <div class="character-counter" id="header-counter">0/60 characters</div>
                                        <div class="snake-case-error" id="header-content-snake-case-error" style="display: none;"></div>

                                        <div class="variable-list" id="header-variable-list" style="display: none;">
                                            <div class="form-note">Variables in this field:</div>
                                            <div id="header-variables-display"></div>
                                        </div>
                                    </div>

                                    <div id="header-variables-container" class="header-variables-container">
                                        <h6>Header Variables</h6>
                                        <div id="header-variable-fields"></div>
                                    </div>
                                </div>

                                <!-- Media Upload Containers (one for each type) -->
                                <div id="image-upload-container" class="media-upload-container" style="display:none">
                                    <i class="fas fa-image"></i>
                                    <p>Click to upload image (JPG, PNG)</p>
                                    <input type="file" id="image-upload-input" style="display: none;" accept="image/*">
                                    <img id="image-preview" class="media-preview" src="" alt="Image Preview">
                                    <a href="#" id="remove-image" class="remove-media" style="display:none">Remove
                                        image</a>
                                </div>

                                <div id="video-upload-container" class="media-upload-container" style="display:none">
                                    <i class="fas fa-video"></i>
                                    <p>Click to upload video (MP4)</p>
                                    <input type="file" id="video-upload-input" style="display: none;" accept="video/*">
                                    <video id="video-preview" class="media-preview" controls style="display:none"></video>
                                    <a href="#" id="remove-video" class="remove-media" style="display:none">Remove
                                        video</a>
                                </div>

                                <div id="document-upload-container" class="media-upload-container" style="display:none">
                                    <i class="fas fa-file-alt"></i>
                                    <p>Click to upload document (PDF, DOC)</p>
                                    <input type="file" id="document-upload-input" style="display: none;"
                                        accept=".pdf,.doc,.docx">
                                    <div id="document-preview" class="media-preview" style="display:none">
                                        <i class="fas fa-file-pdf" style="font-size: 48px; color: #e74c3c;"></i>
                                        <p id="document-name"></p>
                                    </div>
                                    <a href="#" id="remove-document" class="remove-media" style="display:none">Remove
                                        document</a>
                                </div>
                            </div>

                            <!-- Limited Time Offer Template -->
                            <div id="limited-time-offer-container" class="template-type-container" style="display: none;">
                                <div class="form-group">
                                    <label class="form-label">Header Image (Required)</label>
                                    <div id="offer-media-upload-container" class="media-upload-container">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <p>Click to upload header image</p>
                                        <input type="file" id="offer-media-upload-input" style="display: none;"
                                            accept="image/*">
                                        <img id="offer-media-preview" class="media-preview" src="" alt="Preview">
                                        <a href="#" id="remove-offer-media" class="remove-media">Remove image</a>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Offer Text <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="offer-text" 
                                        placeholder="e.g. Expiring offer!" maxlength="16">
                                    <div class="character-counter" id="offer-text-counter">0/16 characters</div>
                                    <div class="form-note">Maximum 16 characters. This text will appear in the offer section.</div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Enable Expiration</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="offer-has-expiration" checked>
                                        <label class="form-check-label" for="offer-has-expiration">
                                            Show expiration timer in message
                                        </label>
                                    </div>
                                    <div class="form-note">
                                        When enabled, WhatsApp will display an expiration timer if the offer is about to expire
                                    </div>
                                </div>
                                
                            </div>

                            <!-- Body Content -->
                            <div class="form-group mt-3">
                                <label class="form-label">Message Content <span class="text-danger">*</span></label>
                                <div class="text-input-container">
                                    <textarea class="form-control" id="template-body" rows="6" placeholder="Enter your message content here..."
                                        maxlength="1028"></textarea>
                                    <button type="button" class="add-variable-btn" data-target="template-body"
                                        style="top: 15px; right: 15px;">
                                        <i class="fas fa-plus" style="margin-right: 6px"></i> Add Variable
                                    </button>
                                </div>
                                <div class="character-counter" id="body-counter">0/1028 characters</div>
                                <div class="snake-case-error" id="template-body-snake-case-error" style="display: none;"></div>
                                <div class="variable-validation-error" id="variable-validation-error">
                                    This template contains too many variable parameters relative to the message length. You need to decrease the number of variable parameters or increase the message length.
                                </div>

                                <div class="variable-list" id="body-variable-list" style="display: none;">
                                    <div class="form-note">Variables in this field:</div>
                                    <div id="body-variables-display"></div>
                                </div>
                            </div>

                            <!-- Variables Container -->
                            <div id="variables-container" class="variables-container">
                                <h6>Template Variables</h6>
                                
                                <div id="variable-fields"></div>
                            </div>

                            <!-- Footer -->
                            <div id="footer-container" class="form-group">
                                <label class="form-label">Footer Text</label>
                                <div class="text-input-container">
                                    <input type="text" class="form-control" id="template-footer"
                                        placeholder="e.g. Thanks and Regards, Company Name" maxlength="60">
                                    {{-- <button type="button" class="add-variable-btn" data-target="template-footer">
                                        <i class="fas fa-plus" style="margin-right: 6px"></i> Add Variable
                                    </button> --}}
                                </div>
                                <div class="character-counter" id="footer-counter">0/60 characters</div>

                                {{-- <div class="variable-list" id="footer-variable-list" style="display: none;">
                                    <div class="form-note">Variables in this field:</div>
                                    <div id="footer-variables-display"></div>
                                </div> --}}
                            </div>
                        </div>

                        <!-- Interactive Actions Section -->
                        <div class="form-card">
                            <div class="section-title">Interactive Actions</div>

                            <div class="radio-group">
                                <div class="radio-item action-none">
                                    <input type="radio" id="action-none" name="interactive-action" value="none" checked>
                                    <label for="action-none">None</label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" id="action-all" name="interactive-action" value="all">
                                    <label for="action-all">All</label>
                                </div>
                            </div>

                            <!-- Quick Replies -->
                            <div id="quick-replies-container" class="quick-reply-container" style="display: none;">
                                <div id="quick-replies-list">
                                    <div class="quick-reply-item">
                                        <div class="button-input-container">
                                            <select class="form-control button-type-select">
                                                <option value="quick_reply">Quick Reply</option>
                                                <option value="url">URL Button</option>
                                                <option value="copy_code">Copy Code</option>
                                                <option value="phone_number">Phone Number</option>
                                            </select>
                                            <input type="text" class="form-control" placeholder="Enter button text">
                                        </div>
                                        <div class="button-extra-input" style="width: 434px;display:none" data-type="url">
                                            <input type="url" class="form-control" placeholder="Enter URL (https://example.com)">
                                        </div>
                                        <div class="button-extra-input" style="width: 434px;display:none" data-type="copy_code">
                                            <input type="text" class="form-control" value="Copy Code" placeholder="Button text" disabled>
                                        </div>
                                        <div class="button-extra-input" style="width: 434px;display:none" data-type="phone_number">
                                            <input type="tel" class="form-control" placeholder="Enter phone number (e.g., 15550051310)">
                                        </div>
                                        <button class="btn-add-reply">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="button-limit-warning" id="mix-warning" style="display: none; color: var(--danger);">
                                    Warning: WhatsApp does not allow mixing quick replies and call-to-action buttons in the same template
                                </div>
                            </div>

                            <div id="catalogue-actions-container" style="display: none;">
                                <div class="form-note" style="color: var(--primary); font-weight: 500;">
                                    <i class="fas fa-info-circle"></i> Catalogue template includes a fixed "View Catalog" button
                                </div>
                                <div id="catalogue-button-preview" class="quick-reply-container">
                                    <div class="quick-reply-item" style="opacity: 0.7; background: #f8f9fa;">
                                        <div class="button-input-container">
                                            <select class="form-control button-type-select" disabled>
                                                <option value="catalogue" selected>Catalogue</option>
                                            </select>
                                            <input type="text" class="form-control" id="catalogue-button-text" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="action-buttons">
                            <button type="button" class="btn-cancel" id="reset-template">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                            <button class="btn-submit" id="submit-template">
                                <i class="fas fa-paper-plane"></i> Submit Template
                            </button>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="col-md-4">
                        <div class="preview-sticky-container">
                            <div class="form-card">
                                <div class="section-title">
                                    <i class="fas fa-eye"></i> Template Preview
                                </div>

                                <div class="preview-container">
                                    <div class="preview-header">
                                        <div class="avatar">
                                            <i class="fas fa-store"></i>
                                        </div>
                                        <div class="name">Business Name</div>
                                    </div>

                                    <div class="preview-body">
                                        <div class="preview-message incoming">
                                            Hello! Here's your feedback request
                                        </div>
                                        <div class="preview-message outgoing">
                                            <!-- Header Preview -->
                                            <div id="preview-header-text" class="preview-message outgoing"></div>
                                            <div id="preview-header" class="preview-message outgoing"></div>

                                            <!-- Limited Time Offer Preview -->
                                            <div id="limited-time-offer-preview" class="preview-section preview-message outgoing"></div>

                                            <!-- Body Preview -->
                                            <div id="preview-body" class="preview-message outgoing"></div>

                                            <!-- Footer Preview -->
                                            <div id="preview-footer" class="preview-message outgoing"></div>

                                            <!-- Buttons Preview -->
                                            <div id="preview-buttons" class="preview-message outgoing"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('script')
    @verbatim
    <script>
$(document).ready(function() {
    const fieldVariables = {
        'header-content': { count: 0, variables: [] },
        'template-body': { count: 0, variables: [] },
        'template-footer': { count: 0, variables: [] }
    };
    
    let variableType = 'number'; 
    let namedVariables = {}; 
    let isAddingVariable = false;
    const usedVariableNames = new Set();

$(document).on('click', '.variable-type-option', function(e) {
    e.stopPropagation();
    
    const radioInput = $(this).find('input[type="radio"]');
    const newVariableType = radioInput.val();
    
    if (newVariableType !== variableType) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Changing variable type will remove all existing variables. Continue?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, continue!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $('.variable-type-option').removeClass('selected');
                $(this).addClass('selected');
                radioInput.prop('checked', true);
                variableType = newVariableType;
                
                clearAllVariables();
                
                if (variableType === 'name') {
                    $('#global-snake-case-hint').show();
                } else {
                    $('#global-snake-case-hint').hide();
                }
                
                updatePreview();
                
                Swal.fire(
                    'Changed!',
                    'Variable type has been changed.',
                    'success'
                );
            } else {
                $(`#global-variable-type-${variableType}`).prop('checked', true);
                $(`.variable-type-option`).removeClass('selected');
                $(`#global-${variableType}-option`).addClass('selected');
            }
        });
    }
});

    function clearAllVariables() {
        fieldVariables['header-content'].variables = [];
        fieldVariables['header-content'].count = 0;
        fieldVariables['template-body'].variables = [];
        fieldVariables['template-body'].count = 0;
        fieldVariables['template-footer'].variables = [];
        fieldVariables['template-footer'].count = 0;
        namedVariables = {};
        
        $('#header-variables-display').empty();
        $('#body-variables-display').empty();
        $('#footer-variables-display').empty();
        $('#header-variable-list').hide();
        $('#body-variable-list').hide();
        $('#footer-variable-list').hide();
        
        $('#header-variable-fields').empty();
        $('#variable-fields').empty();
        
        $('#header-content').val('');
        $('#template-body').val('');
        $('#template-footer').val('');
        
        $('#header-counter').text('0/60 characters');
        $('#body-counter').text('0/1028 characters');
        $('#footer-counter').text('0/60 characters');
    }

    $('#header-content, #template-body, #template-footer').on('input', function() {
        if (isAddingVariable) {
            setTimeout(() => { isAddingVariable = false; }, 0);
            return;
        }
        if (variableType === 'number') {
            let text = $(this).val();

            const invalidVarRegex = /\{\{[^}]*\}\}/g;
            text = text.replace(invalidVarRegex, match => {
                return /^\{\{\d+\}\}$/.test(match) ? match : ''; 
            });

            const matches = text.match(/\{\{\d+\}\}/g) || [];
            if (matches.length > 0) {
                const lastToken = matches[matches.length - 1];
                if ($(this).val().endsWith(lastToken) && !isAddingVariable) {
                    text = text.replace(lastToken, '');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Manual Variable Entry',
                        text: 'Please use the "Add Variable" button to add numbered variables.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            }

            if (text !== $(this).val()) {
                $(this).val(text);
            }
        }

     if (variableType === 'name') {
            const fieldId = this.id;
            const text = $(this).val();
            
            const cleanedText = removeDuplicateVariables(text, fieldId);
            if (text !== cleanedText) {
                $(this).val(cleanedText);
                Swal.fire({
                    icon: 'warning',
                    title: 'Duplicate Variable Removed',
                    text: 'Variable names must be unique. The duplicate has been removed.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
            
            const variables = extractVariables(cleanedText);
            let hasError = false;
            
            variables.forEach(variable => {
                const varName = variable.replace(/\{\{|\}\}/g, '');
                if (!validateVariableName(varName, fieldId)) {
                    hasError = true;
                }
            });
            
            updateUsedVariables();
            
            if (!hasError && variables.length > 0) {
                $(`#${fieldId}-snake-case-error`).hide();
            }
    }
});


    function validateAndRenumberVariables(fieldId) {
        if (variableType !== 'number') return;
        
        const field = $(`#${fieldId}`);
        let text = field.val();
        const variables = extractVariables(text);
        
        // Check if variables are sequential starting from 1
        const numbers = variables.map(v => {
            const match = v.match(/\{?\{?(\d+)\}?\}?/);
            return match ? parseInt(match[1]) : 0;
        }).filter(n => n > 0).sort((a, b) => a - b);
        
        if (numbers.length === 0) return;
        
        // Check if numbers are sequential (1, 2, 3, ...)
        const isSequential = numbers.every((num, index) => num === index + 1);
        
        if (!isSequential) {
            // Renumber variables sequentially
            const numberMap = {};
            numbers.forEach((oldNum, index) => {
                numberMap[oldNum] = index + 1;
            });
            
            for (const [oldNum, newNum] of Object.entries(numberMap)) {
                const oldVar = `{{${oldNum}}}`;
                const newVar = `{{${newNum}}}`;
                text = text.replace(new RegExp(oldVar, 'g'), newVar);
            }
            
            field.val(text).trigger('input');
        }
    }

    $('#header-content, #template-body, #template-footer').on('input', function() {
        const fieldId = this.id;
        validateAndRenumberVariables(fieldId);
    });


    function isValidSnakeCase(name) {
        return /^[a-z][a-z0-9]*(_[a-z0-9]+)*$/.test(name) && !/__/.test(name);
    }


    function validatePhoneNumber(phone) {
        return /^[0-9+]{1,20}$/.test(phone);
    }

    function validateTemplateName() {
        const templateName = $('#template-name').val().trim();
        const errorElement = $('#template-name-error');
        
        if (!templateName) {
            errorElement.show().text('Template name is required');
            return false;
        }
        
        if (!isValidSnakeCase(templateName)) {
            errorElement.show().text('Template name must be in snake_case format (lowercase letters, numbers, and underscores)');
            return false;
        }
        
        errorElement.hide();
        return true;
    }

    function validateVariableName(varName, fieldId) {
        const errorElement = $(`#${fieldId}-snake-case-error`);
        
        if (!isValidSnakeCase(varName)) {
            errorElement.show().text(`"${varName}" must be valid snake_case (start with lowercase letter, only lowercase letters, numbers, underscores)`);
            return false;
        }
        
        if (usedVariableNames.has(varName)) {
            errorElement.show().text(`"${varName}" is already used. Variable names must be unique.`);
            return false;
        }
        
        errorElement.hide();
        return true;
    }

    function removeDuplicateVariables(text, fieldId) {
        const variables = extractVariables(text);
        const seen = new Set();
        let newText = text;
        
        variables.forEach(variable => {
            const varName = variable.replace(/\{\{|\}\}/g, '');
            
            if (seen.has(varName)) {
                const escapedVariable = variable.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                const regex = new RegExp(escapedVariable, 'g');
                newText = newText.replace(regex, '');
            } else {
                seen.add(varName);
            }
        });
        
        return newText;
    }

    function updateUsedVariables() {
        usedVariableNames.clear();
        
        ['header-content', 'template-body', 'template-footer'].forEach(fieldId => {
            const text = $(`#${fieldId}`).val();
            const variables = extractVariables(text);
            
            variables.forEach(variable => {
                const varName = variable.replace(/\{\{|\}\}/g, '');
                if (isValidSnakeCase(varName)) {
                    usedVariableNames.add(varName);
                }
            });
        });
    }

    $('#template-name').on('input', function() {
        const isValid = validateTemplateName();
        $(this).toggleClass('has-error', !isValid);
    });

    function updateVariableFields() {
        $('#variable-fields').empty();
        
        if (variableType === 'number') {
            const bodyVariables = extractVariables($('#template-body').val());
            
            if (bodyVariables.length === 0 )  {
                $('#variables-container').hide();
                return;
            }
            
            $('#variables-container').show();
            
            bodyVariables.forEach(function(variable, index) {
                const varNum = variable.replace(/\{\{|\}\}/g, '');
                const field = `
                    <div class="form-group">
                        <label class="form-label">${variable}} - Sample Value</label>
                        <input type="text" class="form-control variable-sample" data-variable="${variable}" 
                            placeholder="Enter sample value for variable ${varNum}">
                        <small class="form-note">This will be used for preview only</small>
                    </div>
                `;
                $('#variable-fields').append(field);
            });
        } else {
            const bodyVariables = extractVariables($('#template-body').val());
            
            if (bodyVariables.length === 0) {
                $('#variables-container').hide();
                return;
            }
            
            $('#variables-container').show();
            
            bodyVariables.forEach(function(variable, index) {
                const varName = variable.replace(/\{\{|\}\}/g, '');
                const field = `
                    <div class="form-group">
                        <label class="form-label">${variable}} - Sample Value</label>
                        <input type="text" class="form-control variable-sample" data-variable="${variable}" 
                            placeholder="Enter sample value for ${varName}" value="${namedVariables[varName] || ''}">
                        <small class="form-note">This will be used for preview only</small>
                    </div>
                `;
                $('#variable-fields').append(field);
            });
        }
        
        $('.variable-sample').on('input', function() {
            const variable = $(this).data('variable');
            const varName = variable.replace(/\{\{|\}\}/g, '');
            
            if (variableType === 'name') {
                namedVariables[varName] = $(this).val();
            }
            
            updatePreview();
        });
    }

    function initCharacterCounters() {
        $('#header-content').on('input', function() {
            const length = $(this).val().length;
            const maxLength = 60;
            updateCounter('header', length, maxLength);
            checkHeaderVariables();
            updatePreview();
        });

        $('#template-body').on('input', function() {
            const length = $(this).val().length;
            const maxLength = 1028;
            updateCounter('body', length, maxLength);
            checkBodyVariables();
            validateVariableToLengthRatio();
            updatePreview();
        });

        $('#template-footer').on('input', function() {
            const length = $(this).val().length;
            const maxLength = 60;
            updateCounter('footer', length, maxLength);
            checkFooterVariables();
            updatePreview();
        });

        $('#offer-text').on('input', function() {
            const length = $(this).val().length;
            const maxLength = 16;
            updateCounter('offer-text', length, maxLength);
            updatePreview();
        });
        
        $('#offer-code').on('input', function() {
            const length = $(this).val().length;
            const maxLength = 15;
            updateCounter('offer-code', length, maxLength);
            updatePreview();
        });

        $('#header-content').trigger('input');
        $('#template-body').trigger('input');
        $('#template-footer').trigger('input');
        $('#offer-text').trigger('input');
        $('#offer-code').trigger('input');
    }

    function validateVariableToLengthRatio() {
        const bodyText = $('#template-body').val();
        const variables = extractVariables(bodyText);
        
        const minCharsPerVariable = 30;
        const totalChars = bodyText.length;
        const variableCount = variables.length;
        
        const requiredChars = variableCount * minCharsPerVariable;
        const isValid = totalChars >= requiredChars;
        
        $('#variable-validation-error').toggle(!isValid);

        return isValid;
    }

    function updateCounter(field, length, maxLength) {
        const counter = $(`#${field}-counter`);
        counter.text(`${length}/${maxLength} characters`);

        if (length > maxLength * 0.9) {
            counter.addClass('near-limit');
        } else {
            counter.removeClass('near-limit');
        }

        if (length > maxLength) {
            counter.addClass('over-limit');
        } else {
            counter.removeClass('over-limit');
        }
    }

    $('.add-variable-btn').click(function() {
        const targetField = $(this).data('target');
        addVariableToField(targetField);
    });

function addVariableToField(fieldId) {
    isAddingVariable = true;
    
    if (variableType === 'number') {
        const fieldText = $(`#${fieldId}`).val();
        const existingVariables = extractVariables(fieldText);
        
        let maxNum = 0;
        existingVariables.forEach(variable => {
            const numMatch = variable.match(/\{?\{?(\d+)\}?\}?/);
            if (numMatch && numMatch[1]) {
                const num = parseInt(numMatch[1]);
                if (num > maxNum) maxNum = num;
            }
        });
        
        const nextNum = maxNum + 1;
        const variable = '{{' + nextNum + '}}';
        
        const field = document.getElementById(fieldId);
        const cursorPosition = field.selectionStart;
        const currentValue = field.value;

        field.value = currentValue.substring(0, cursorPosition) +
            variable +
            currentValue.substring(field.selectionEnd);

        fieldVariables[fieldId].count = nextNum;
        fieldVariables[fieldId].variables.push(variable);

        updateVariableDisplay(fieldId);

        $(field).trigger('input');

        if (fieldId === 'header-content') {
            checkHeaderVariables();
        } else if (fieldId === 'template-body') {
            checkBodyVariables();
            validateVariableToLengthRatio();
        } else if (fieldId === 'template-footer') {
            checkFooterVariables();
        }
    } else {
        const variable = '{{}}';
        const field = document.getElementById(fieldId);
        const cursorPosition = field.selectionStart;
        const currentValue = field.value;

        field.value = currentValue.substring(0, cursorPosition) +
            variable +
            currentValue.substring(field.selectionEnd);

        field.selectionStart = cursorPosition + 2;
        field.selectionEnd = cursorPosition + 2;

        $(field).trigger('input');
    }
    
    updatePreview();
}

    function updateVariableDisplay(fieldId) {
        const displayElement = $(`#${fieldId.replace('-', '-')}-display`);
        const listElement = $(`#${fieldId.replace('-', '-')}-list`);

        if (fieldVariables[fieldId].variables.length > 0) {
            listElement.show();
            let html = '';

            fieldVariables[fieldId].variables.forEach((variable, index) => {
                html += `<span class="variable-item">${variable}</span>`;
            });

            displayElement.html(html);
        } else {
            listElement.hide();
        }
    }

    function extractVariables(text) {
        const variables = [];
        const regex = /\{\{(\d+|[a-z][a-z0-9_]*(_[a-z0-9]+)*)\}\}/g;
        let match;

        while ((match = regex.exec(text)) !== null) {
            variables.push(`{{${match[1]}}}`);
        }
        return variables;
    }

    function checkHeaderVariables() {
        const headerText = $('#header-content').val();
        const variables = extractVariables(headerText);
        
        fieldVariables['header-content'].variables = variables;
        
        if (variableType === 'number') {
            let maxNum = 0;
            variables.forEach(variable => {
                const numMatch = variable.match(/\{?\{?(\d+)\}?\}?/);
                if (numMatch && numMatch[1]) {
                    const num = parseInt(numMatch[1]);
                    if (num > maxNum) maxNum = num;
                }
            });
            fieldVariables['header-content'].count = maxNum;
            
            const expectedNumbers = Array.from({length: maxNum}, (_, i) => i + 1);
            const actualNumbers = variables.map(v => {
                const numMatch = v.match(/\{?\{?(\d+)\}?\}?/);
                return numMatch ? parseInt(numMatch[1]) : 0;
            }).filter(n => n > 0);
            
            if (actualNumbers.length > 0 && !arraysEqual(actualNumbers.sort(), expectedNumbers)) {
                if (confirm('Your variables are not in sequential order. Would you like to renumber them automatically?')) {
                    renumberVariables('header-content');
                    return; 
                }
            }
        } else {
            variables.forEach(variable => {
                const varName = variable.replace(/\{\{|\}\}/g, '');
                if (!namedVariables[varName]) {
                    namedVariables[varName] = '';
                }
            });
        }
        
        generateHeaderVariableFields(variables);
        updateVariableDisplay('header-content');
    }

    function checkBodyVariables() {
        const bodyText = $('#template-body').val();
        const variables = extractVariables(bodyText);
        
        fieldVariables['template-body'].variables = variables;
        
        if (variableType === 'number') {
            let maxNum = 0;
            variables.forEach(variable => {
                const numMatch = variable.match(/\{?\{?(\d+)\}?\}?/);
                if (numMatch && numMatch[1]) {
                    const num = parseInt(numMatch[1]);
                    if (num > maxNum) maxNum = num;
                }
            });
            fieldVariables['template-body'].count = maxNum;
            
            const expectedNumbers = Array.from({length: maxNum}, (_, i) => i + 1);
            const actualNumbers = variables.map(v => {
                const numMatch = v.match(/\{?\{?(\d+)\}?\}?/);
                return numMatch ? parseInt(numMatch[1]) : 0;
            }).filter(n => n > 0);
            
            if (actualNumbers.length > 0 && !arraysEqual(actualNumbers.sort(), expectedNumbers)) {
                if (confirm('Your variables are not in sequential order. Would you like to renumber them automatically?')) {
                    renumberVariables('template-body');
                    return; 
                }
            }
        } else {
            variables.forEach(variable => {
                const varName = variable.replace(/\{\{|\}\}/g, '');
                if (!namedVariables[varName]) {
                    namedVariables[varName] = '';
                }
            });
        }
        
        updateVariableFields();
        updateVariableDisplay('template-body');
    }

    function arraysEqual(a, b) {
        if (a.length !== b.length) return false;
        for (let i = 0; i < a.length; i++) {
            if (a[i] !== b[i]) return false;
        }
        return true;
    }

    function renumberVariables(fieldId) {
        const field = $(`#${fieldId}`);
        let text = field.val();
        const variables = extractVariables(text);
        
        const numberMap = {};
        variables.forEach((variable, index) => {
            const numMatch = variable.match(/\{?\{?(\d+)\}?\}?/);
            if (numMatch && numMatch[1]) {
                const oldNum = parseInt(numMatch[1]);
                numberMap[oldNum] = index + 1;
            }
        });
        
        for (const [oldNum, newNum] of Object.entries(numberMap)) {
            const oldVar = `{{${oldNum}}}`;
            const newVar = `{{${newNum}}}`;
            text = text.replace(new RegExp(oldVar, 'g'), newVar);
        }
        
        field.val(text).trigger('input');
    }

    function checkFooterVariables() {
        const footerText = $('#template-footer').val();
        const variables = extractVariables(footerText);
        
        fieldVariables['template-footer'].variables = variables;
        
        if (variableType === 'number') {
            let maxNum = 0;
            variables.forEach(variable => {
                const numMatch = variable.match(/\{?\{?(\d+)\}?\}?/);
                if (numMatch && numMatch[1]) {
                    const num = parseInt(numMatch[1]);
                    if (num > maxNum) maxNum = num;
                }
            });
            fieldVariables['template-footer'].count = maxNum;
        } else {
            variables.forEach(variable => {
                const varName = variable.replace(/\{\{|\}\}/g, '');
                if (!namedVariables[varName]) {
                    namedVariables[varName] = '';
                }
            });
        }
        
        updateVariableDisplay('template-footer');
    }

    function initTemplateType() {
        let lastScrollTop = 0;
        const previewContainer = $('.preview-sticky-container');
        const scrollThreshold = 100;

        $(window).scroll(function() {
            const scrollTop = $(this).scrollTop();

            if (Math.abs(scrollTop - lastScrollTop) > 5) {
                if (scrollTop > scrollThreshold) {
                    previewContainer.addClass('scrolling');
                } else {
                    previewContainer.removeClass('scrolling');
                }
            }

            lastScrollTop = scrollTop;
        });

        const category = $('#template-category').val();
        $('.template-type-container').hide();
        $('#standard-actions-container').show();
        $('#catalogue-actions-container').hide();
        $('#template-header-container').show();
        $('#footer-container').show();
        $('#quick-replies-container').hide();

        $('#action-none').prop('checked', true);

        if (category === 'limited-time-offer') {
            $('#limited-time-offer-container').show();
            $('#template-header-container').hide();
            $('#footer-container').hide();
            $('.radio-group').hide();
            $('#quick-replies-list').html(`
                <div class="quick-reply-item">
                    <div class="button-input-container">
                        <select class="form-control button-type-select" disabled>
                            <option value="copy_code" selected>Copy Code</option>
                        </select>
                        <input type="text" class="form-control" value="Copy Code" placeholder="Button text" disabled>
                    </div>
                    <div class="button-extra-input" data-type="copy_code" style="display: block;">
                        <input type="text" class="form-control offer-code-input" 
                            placeholder="Enter Offer Code (SUMMER20)" maxlength="15">
                    </div>
                </div>
                <div class="quick-reply-item">
                    <div class="button-input-container">
                        <select class="form-control button-type-select" disabled>
                            <option value="url" selected>URL Button</option>
                        </select>
                        <input type="text" class="form-control url-button-text" 
                            placeholder="Enter button text (e.g., Book now!)" maxlength="25">
                    </div>
                    <div class="button-extra-input" data-type="url" style="display: block;">
                        <input type="url" class="form-control url-input" 
                            placeholder="Enter URL (https://example.com)" maxlength="2000">
                        <div class="form-note" style="margin-top: 5px;">
                            You can add a variable at the end like: https://example.com/offers?code={{1}}
                        </div>
                    </div>
                    <button class="btn-remove-reply" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `);
            
            $('.btn-add-reply').hide();
            $('#quick-replies-container').show();
            
            $('#cta-warning').text('Limited Time Offer requires exactly 2 buttons: Copy Code and URL').show();

            updateCategoryDescription('Limited Time Offer templates promote special offers with expiration dates. They require a header image and can include offer codes.');
        } else if (category === 'catalogue') {
            $('#template-header-container').hide();
            $('#standard-actions-container').hide();
            $(".radio-group").hide();
            $('#catalogue-actions-container').show();
            updateCategoryDescription('Catalogue templates showcase your product catalog with a fixed "View Catalog" button.');
            updateCatalogueButtonText();
        } else if (category === 'marketing') {
            updateCategoryDescription('Marketing templates promote your products or services. They can include images, videos, and call-to-action buttons.');
        } else {
            updateCategoryDescription('Utility templates facilitate specific transactions or updates. They can include text, documents, and quick reply buttons.');
        }


        updatePreview();
    }

    function updateCategoryDescription(text) {
       $('#category-description').text(text);
    }

    function updateCatalogueButtonText() {
        const language = $('#template-language').val();
        const buttonText = getCatalogueButtonText(language);
        $('#catalogue-button-text').val(buttonText);
    }

    function getCatalogueButtonText(language) {
        const translations = {
            'en_US': 'View catalog',
            'ar_AR': 'عرض الكتالوج',
            'es_ES': 'Ver catálogo',
            'fr_FR': 'Voir le catalogue',
            'de_DE': 'Katalog anzeigen',
            'pt_BR': 'Ver catálogo'
        };
        return translations[language] || 'View catalog';
    }

    $('#template-language').change(function() {
        if ($('#template-category').val() === 'catalogue') {
            updateCatalogueButtonText();
        }
        updatePreview();
    });

    $('input[name="header-type"]').change(function() {
        const headerType = $(this).val();

        $('#text-header-container, #image-upload-container, #video-upload-container, #document-upload-container')
            .hide();

        if (headerType === 'text') {
            $('#text-header-container').show();
            checkHeaderVariables();
        } else if (headerType === 'image') {
            $('#image-upload-container').show();
            $('#header-variables-container').hide();
        } else if (headerType === 'video') {
            $('#video-upload-container').show();
            $('#header-variables-container').hide();
        } else if (headerType === 'document') {
            $('#document-upload-container').show();
            $('#header-variables-container').hide();
        }

        updatePreview();
    });

    function generateHeaderVariableFields(vars) {
        $('#header-variable-fields').empty();

        if (vars.length === 0) {
            $('#header-variables-container').hide();
            return;
        }

        $('#header-variables-container').show();

        vars.forEach(function(variable, index) {
            const varNum = variable.replace(/\{\{|\}\}/g, '');
            const field = `
                <div class="form-group">
                    <label class="form-label">${variable}} - Sample Value</label>
                    <input type="text" class="form-control header-variable-sample" data-variable="${variable}" 
                        placeholder="Enter sample value for ${variableType === 'number' ? 'variable ' + varNum : varNum}">
                    <small class="form-note">This will be used for preview only</small>
                </div>
            `;
            $('#header-variable-fields').append(field);
        });
        
        $('.header-variable-sample').on('input', function() {
            updatePreview();
        });
    }

    $('#image-upload-container').on('click', function(e) {
        if (!$(e.target).is('input') && !$(e.target).is('a')) {
            $('#image-upload-input').click();
        }
    });

    $('#image-upload-input').on('change', function(e) {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            const reader = new FileReader();

            reader.onload = function(event) {
                $('#image-preview').attr('src', event.target.result).show();
                $('#image-upload-container p').text(file.name);
                $('#remove-image').show();
                updatePreview();
            };

            reader.readAsDataURL(file);
        }
    });

    $('#remove-image').on('click', function(e) {
        e.preventDefault();
        $('#image-upload-input').val('');
        $('#image-preview').attr('src', '').hide();
        $('#image-upload-container p').text('Click to upload image (JPG, PNG)');
        $(this).hide();
        updatePreview();
    });

    $('#video-upload-container').on('click', function(e) {
        if (!$(e.target).is('input') && !$(e.target).is('a')) {
            $('#video-upload-input').click();
        }
    });

        $('#video-upload-input').on('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const videoURL = URL.createObjectURL(file);
                $('#video-preview').attr('src', videoURL).show();
                $('#video-upload-container p').text(file.name);
                $('#remove-video').show();
                updatePreview();
            }
        });
        
        $('#remove-video').on('click', function(e) {
            e.preventDefault();
            $('#video-upload-input').val('');
            $('#video-preview').attr('src', '').hide();
            $('#video-upload-container p').text('Click to upload video (MP4)');
            $(this).hide();
            updatePreview();
        });

        $('#document-upload-container').on('click', function(e) {
            if (!$(e.target).is('input') && !$(e.target).is('a')) {
                $('#document-upload-input').click();
            }
        });

        $('#document-upload-input').on('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                let iconClass = 'fa-file-alt';
                if (file.type.includes('pdf')) iconClass = 'fa-file-pdf';
                if (file.type.includes('document')) iconClass = 'fa-file-word';
                $('#document-preview i').removeClass().addClass('fas ' + iconClass);
                $('#document-name').text(file.name);
                $('#document-preview').show();
                $('#document-upload-container p').text(file.name);
                $('#remove-document').show();
                updatePreview();
            }
        });

        $('#remove-document').on('click', function(e) {
            e.preventDefault();
            $('#document-upload-input').val('');
            $('#document-preview').hide();
            $('#document-name').text('');
            $('#document-upload-container p').text('Click to upload document (PDF, DOC)');
            $(this).hide();
            updatePreview();
        });

        $('#offer-media-upload-container').on('click', function(e) {
            if (!$(e.target).is('input') && !$(e.target).is('a')) {
                $('#offer-media-upload-input').click();
            }
        });

        $('#offer-media-upload-input').on('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const reader = new FileReader();
                reader.onload = function(event) {
                    $('#offer-media-preview').attr('src', event.target.result).show();
                    $('#offer-media-upload-container p').text(file.name);
                    $('#remove-offer-media').show();
                    updatePreview();
                };
                reader.readAsDataURL(file);
            }
        });

        $('#remove-offer-media').on('click', function(e) {
            e.preventDefault();
            $('#offer-media-upload-input').val('');
            $('#offer-media-preview').attr('src', '').hide();
            $('#offer-media-upload-container p').text('Click to upload header image');
            $(this).hide();
            updatePreview();
        });

        function updateQuickReplyButtons() {
            const buttons = $('#quick-replies-list .quick-reply-item');
            let quickReplyCount = 0;
            let ctaCount = 0;

            buttons.each(function() {
                const buttonType = $(this).find('.button-type-select').val();
                if (buttonType === 'quick_reply') {
                    quickReplyCount++;
                } else {
                    ctaCount++;
                }
            });

            buttons.each(function(index) {
                const $item = $(this);
                const buttonType = $item.find('.button-type-select').val();
                $item.find('.btn-add-reply, .btn-remove-reply').remove();

                const canAddMoreQuickReplies = buttonType === 'quick_reply' && quickReplyCount < 3;
                const canAddMoreCTAs = buttonType !== 'quick_reply' && ctaCount < 2;
                const canAddMore = (buttonType === 'quick_reply' && quickReplyCount < 3) ||
                                (buttonType !== 'quick_reply' && ctaCount < 2);

                if (index === buttons.length - 1 && canAddMore) {
                    $item.append(`
                        <button class="btn-add-reply">
                            <i class="fas fa-plus"></i>
                        </button>
                    `);
                } else if (index > 0) {
                    $item.append(`
                        <button class="btn-remove-reply">
                            <i class="fas fa-times"></i>
                        </button>
                    `);
                }
            });

            $('#quick-reply-warning').toggle(quickReplyCount >= 3);
            $('#cta-warning').toggle(ctaCount >= 2);

            if (quickReplyCount > 0 && ctaCount > 0) {
                $('#mix-warning').show();
            } else {
                $('#mix-warning').hide();
            }
        }

    $(document).on('change', '.button-type-select', function() {
        const $container = $(this).closest('.quick-reply-item');
        const buttonType = $(this).val();
        
        $container.find('.button-extra-input').hide();
        
        if (buttonType === 'url' || buttonType === 'copy_code') {
            $container.find(`.button-extra-input[data-type="${buttonType}"]`).show();
        }
        
        updatePreview();
    });

    let diffDays;

    function updatePreview() {
        const category = $('#template-category').val();
        $('.preview-section').hide();
        const headerType = $('input[name="header-type"]:checked').val();

        $('#preview-header-text').empty();
        $('#preview-header').empty();

        if (headerType === 'text') {
            let headerContent = $('#header-content').val();

            const headerSampleValues = {};
            $('.header-variable-sample').each(function() {
                const variable = $(this).data('variable');
                const value = $(this).val() || variable.replace(/\{\{|\}\}/g, '');
                headerSampleValues[variable] = value;
            });

            if (variableType === 'number') {
                for (const [variable, value] of Object.entries(headerSampleValues)) {
                    const escapedVariable = variable.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                    const regex = new RegExp(escapedVariable, 'g');
                    headerContent = headerContent.replace(regex, value);
                }
            } else {
                const variables = extractVariables(headerContent);
                variables.forEach(variable => {
                    const varName = variable.replace(/\{\{|\}\}/g, '');
                    const sampleInput = $(`.header-variable-sample[data-variable="${variable}"]`);
                    const sampleValue = sampleInput.length ? sampleInput.val() : (namedVariables[varName] || varName);
                    
                    const escapedVariable = variable.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                    const regex = new RegExp(escapedVariable, 'g');
                    headerContent = headerContent.replace(regex, sampleValue);
                });
            }


            if (headerContent) {
                $('#preview-header-text').html(`<h5 class="header_wtsp_text">${headerContent}</h5>`).show();
            }
        } else if (headerType === 'image' && $('#image-preview').attr('src')) {
            $('#preview-header').html(`
                <div class="header-media">
                    <img src="${$('#image-preview').attr('src')}" style="max-width: 100%; border-radius: 8px;">
                </div>
            `).show();
        } else if (headerType === 'video' && $('#video-preview').attr('src')) {
            $('#preview-header').html(`
                <div class="header-media">
                    <video src="${$('#video-preview').attr('src')}" style="max-width: 100%; border-radius: 8px;" controls></video>
                </div>
            `).show();
        } else if (headerType === 'document' && $('#document-name').text()) {
            const fileName = $('#document-name').text();
            const iconClass = $('#document-preview i').attr('class');
            $('#preview-header').html(`
                <div class="header-media" style="text-align: center; padding: 15px; background: #f0f0f0; border-radius: 8px;">
                    <i class="${iconClass}" style="font-size: 36px; color: #666;"></i>
                    <div style="font-size: 14px; margin-top: 8px;">${fileName}</div>
                </div>
            `).show();
        }

        if (category === 'limited-time-offer') {
            const headerImg = $('#offer-media-preview').attr('src');
            let buttonsHTML = '<div class="buttons">';
            const offerCode = $('.offer-code-input').val().trim() || 'OFFERCODE';

            if (headerImg) {
                $('#preview-header').html(`
                    <div style="text-align: center; margin-bottom: 15px;">
                        <img src="${headerImg}" style="max-width: 100%; border-radius: 8px;">
                    </div>
                `).show();
            }
            
            let offerHTML = '<div class="offer-preview">';
            
            if ($('#offer-text').val()) {
                offerHTML += `<div class="offer-preview-title">${$('#offer-text').val()}</div>`;
            }
            
            if ($('#offer-has-expiration').is(':checked')) {
                offerHTML += `<div class="offer-preview-timer">Expires in 24 hours</div>`;
            }
            
            if ($('#offer-code').val()) {
                offerHTML += `
                    <div style="margin-top: 10px;">
                        <div style="font-size: 0.9rem; margin-bottom: 5px;">Use code:</div>
                        <div class="offer-code-preview">${$('#offer-code').val()}</div>
                    </div>
                `;
            }
            
            offerHTML += '</div>';
            $('#limited-time-offer-preview').html(offerHTML).show();

            buttonsHTML += `
                <div class="button" style="background: white; border-color: #ffc107; font-weight: bold;">
                    <i class="fas fa-tag"></i> Copy Code
                </div>
            `;
            
            const urlButtonText = $('.url-button-text').val().trim() || 'Learn More';
            buttonsHTML += `
                <div class="button" style="background: white; border-color: var(--primary);">
                    <i class="fas fa-link"></i> ${urlButtonText}
                </div>
            `;
            
            buttonsHTML += '</div>';
            $('#preview-buttons').html(buttonsHTML).show();
        }

        let bodyContent = $('#template-body').val();
        
        if (variableType === 'number') {
            const bodySampleValues = {};
            $('.variable-sample').each(function() {
                const variable = $(this).data('variable');
                const value = $(this).val() || variable.replace(/\{\{|\}\}/g, '');
                bodySampleValues[variable] = value;
            });

            for (const [variable, value] of Object.entries(bodySampleValues)) {
                const escapedVariable = variable.replace(/[-\/\\^$*+?.()|[][]{}]/g, '\\$&');
                const regex = new RegExp(escapedVariable, 'g');
                bodyContent = bodyContent.replace(regex, value);
            }
        } else {
             const variables = extractVariables(bodyContent);
            variables.forEach(variable => {
                const varName = variable.replace(/\{\{|\}\}/g, '');
                const sampleValue = namedVariables[varName] || varName;
                const escapedVariable = variable.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                const regex = new RegExp(escapedVariable, 'g');
                bodyContent = bodyContent.replace(regex, sampleValue);
            });
        }

        $('#preview-body').html(bodyContent.replace(/\n/g, '<br>'));

        let footerContent = $('#template-footer').val();
        
        if (variableType === 'number') {
            const footerSampleValues = {};
            $('.footer-variable-sample').each(function() {
                const variable = $(this).data('variable');
                const value = $(this).val() || variable.replace(/\{\{|\}\}/g, '');
                footerSampleValues[variable] = value;
            });

            for (const [variable, value] of Object.entries(footerSampleValues)) {
                const escapedVariable = variable.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                const regex = new RegExp(escapedVariable, 'g');
                footerContent = footerContent.replace(regex, value);
            }
        } else {
            for (const [varName, value] of Object.entries(namedVariables)) {
                const variable = `{{${varName}}}`;
                const escapedVariable = variable.replace(/[-\/\\^$*+?.()|[][{}]/g, '\\$&');
                const regex = new RegExp(escapedVariable, 'g');
                footerContent = footerContent.replace(regex, value || varName);
            }
        }

        $('#preview-footer').html(footerContent || '');

        const actionType = $('input[name="interactive-action"]:checked').val();
        let buttonsHTML = '';

        if (category === 'catalogue') {
            const buttonText = $('#catalogue-button-text').val();
            buttonsHTML = `
                <div class="buttons">
                    <div class="button" style="background: white; border-color: var(--primary);">
                        <i class="fas fa-shopping-cart"></i> ${buttonText}
                    </div>
                </div>
            `;
        }

        if (actionType === 'all') {
            const quickReplies = [];
            const ctas = [];

            $('#quick-replies-list .quick-reply-item').each(function() {
                const buttonType = $(this).find('.button-type-select').val();
                const buttonText = $(this).find('input[type="text"]').val().trim();

                if (buttonText) {
                    if (buttonType === 'quick_reply') {
                        quickReplies.push({
                            type: buttonType,
                            text: buttonText
                        });
                    } else if (buttonType === 'phone_number') {
                           const phoneNumber = $(this).find('.button-extra-input[data-type="phone_number"] input').val() || '15550051310';
                            ctas.push({
                                 type: buttonType,
                                 text: buttonText,
                                 data: phoneNumber
                            });
                    } 
                    else {
                        let extraData = '';
                        if (buttonType === 'url') {
                            extraData = $(this).find('.button-extra-input[data-type="url"] input').val() || 'https://example.com';
                        } else if (buttonType === 'copy_code') {
                            extraData = $(this).find('.button-extra-input[data-type="copy_code"] input').val() || 'COUPON123';
                        } 

                        ctas.push({
                            type: buttonType,
                            text: buttonText,
                            data: extraData
                        });
                    } 
                }
            });

            buttonsHTML = '<div class="buttons">';

            if (quickReplies.length > 0) {
                quickReplies.slice(0, 3).forEach(button => {
                    buttonsHTML += `<div class="button">${button.text}</div>`;
                });
            } else if (ctas.length > 0) {
                ctas.slice(0, 2).forEach(button => {
                    let icon = '';
                    let style = '';

                    if (button.type === 'url') {
                        icon = '<i class="fas fa-link"></i> ';
                        style = 'background: white; border-color: var(--primary);';
                        buttonsHTML += `<div class="button" style="${style}">${icon}${button.text}</div>`;
                    } else if (button.type === 'copy_code') {
                        icon = '<i class="fas fa-tag"></i> ';
                        style = 'background: white; border-color: #ffc107; font-weight: bold;';
                        buttonsHTML += `<div class="button" style="${style}">${icon}Copy Code</div>`;
                    } else if (button.type === 'phone_number') {
                        icon = '<i class="fas fa-phone"></i> ';
                        style = 'background: white; border-color: #25D366;';  
                        buttonsHTML += `<div class="button" style="${style}">${icon}${button.text}</div>`;
                    }

                });
            } 

            buttonsHTML += '</div>';
        }

        $('#preview-buttons').html(buttonsHTML).toggle(!!buttonsHTML);
    }


            async function prepareTemplateData() {
                const category = $('#template-category').val().toUpperCase();
                const templateData = {
                    name: $('#template-name').val(),
                    category: category,
                    language: $('#template-language').val(),
                    body: $('#template-body').val(),
                    components: []
                };


                if (!validateVariableToLengthRatio()) {
                    throw new Error('This template contains too many variable parameters relative to the message length. You need to decrease the number of variable parameters or increase the message length.');
                }

                const headerType = $('input[name="header-type"]:checked').val();

            if (category === 'CATALOGUE') {
                templateData.category = 'MARKETING';
                const bodyComponent = {
                    type: 'BODY',
                    text: templateData.body
                };

                const bodyVariables = extractVariables(templateData.body);
                if (bodyVariables.length > 0) {
                    if (variableType === 'number') {
                        const bodyExamples = [];
                        bodyVariables.forEach(variable => {
                            const sampleInput = $(`.variable-sample[data-variable="${variable}"]`);
                            bodyExamples.push(sampleInput.length ? sampleInput.val() : variable.replace(/\{\{|\}\}/g, ''));
                        });
                        bodyComponent.example = { 
                            body_text: [bodyExamples]
                        };
                    }  else {
                        const bodyExamples = [];
                        const exampleSet = {};
                        
                        bodyVariables.forEach(variable => {
                            const varName = variable.replace(/\{\{|\}\}/g, '');
                            exampleSet[varName] = namedVariables[varName] || varName;
                        });
                        
                        bodyComponent.example = { 
                            body_text: [exampleSet] 
                        };
                    }
                }

                templateData.components.push(bodyComponent);

                if ($('#template-footer').val()) {
                    templateData.components.push({
                        type: 'FOOTER',
                        text: $('#template-footer').val()
                    });
                }

                const buttonText = getCatalogueButtonText(templateData.language);
                templateData.components.push({
                    type: 'BUTTONS',
                    buttons: [
                        {
                            type: 'CATALOG',
                            text: buttonText
                        }
                    ]
                });

                return templateData;
            }

                
                if (category === 'LIMITED-TIME-OFFER') {
                    templateData.category = "MARKETING";
                    const buttons = [];
                    const offerCode = $('.offer-code-input').val().trim();
                    const urlButtonText = $('.url-button-text').val().trim() || 'Learn More';
                    const urlValue = $('.url-input').val().trim();
                    
                    if (!urlValue) {
                        throw new Error('URL is required for Limited Time Offer templates');
                    }
                    if (!offerCode) {
                        throw new Error('Offer code is required for Limited Time Offer templates');
                    }
                    if ($('#offer-media-upload-input')[0].files.length > 0) {
                        try {
                            const mediaHandle = await uploadMedia($('#offer-media-upload-input')[0].files[0], 'image');
                            if (mediaHandle && mediaHandle.media_id) {
                                templateData.components.push({
                                    type: 'header',
                                    format: 'IMAGE',
                                    example: {
                                        header_handle: [mediaHandle.media_id]
                                    }
                                });
                            }
                        } catch (error) {
                            console.error('Header image upload failed:', error);
                            throw new Error('Failed to upload header image');
                        }
                    }
                    
                    templateData.components.push({
                        type: 'LIMITED_TIME_OFFER',
                        limited_time_offer: {
                            text: $('#offer-text').val(),
                            has_expiration: $('#offer-has-expiration').is(':checked')
                        }
                    });

                    buttons.push({
                        type: 'COPY_CODE',
                        example: [offerCode]
                    });

                    const urlMatches = urlValue.match(/\{\{(\d+)\}\}/);
                    let urlExample = urlValue;
                    
                    if (urlMatches) {
                        urlExample = urlValue.replace(/\{\{\d+\}\}/, 'example123');
                    }
                    
                    buttons.push({
                        type: 'URL',
                        text: urlButtonText,
                        url: urlValue,
                        example: [urlExample]
                    });

                    templateData.components.push({
                        type: 'BUTTONS',
                        buttons: buttons
                    });
                } else {
                    if (headerType === 'text' && $('#header-content').val()) {
                        templateData.header = $('#header-content').val();
                        
                        const headerVariables = extractVariables($('#header-content').val());
                        if (headerVariables.length > 0) {
                            if (variableType === 'number') {
                                const headerExamples = [];
                                headerVariables.forEach(variable => {
                                    const sampleInput = $(`.header-variable-sample[data-variable="${variable}"]`);
                                    headerExamples.push(sampleInput.length ? sampleInput.val() : variable.replace(/\{\{|\}\}/g, ''));
                                });

                                templateData.components.push({
                                    type: 'HEADER',
                                    format: 'TEXT',
                                    text: templateData.header,
                                    example: {
                                        header_text: headerExamples
                                    }
                                });
                            } else {
                                const headerExamples = {};
                                headerVariables.forEach(variable => {
                                    const varName = variable.replace(/\{\{|\}\}/g, '');
                                    headerExamples[varName] = namedVariables[varName] || varName;
                                });

                                templateData.components.push({
                                    type: 'HEADER',
                                    format: 'TEXT',
                                    text: templateData.header,
                                    example: {
                                        header_text: [headerExamples]
                                    }
                                });
                            }
                        } else {
                            templateData.components.push({
                                type: 'HEADER',
                                format: 'TEXT',
                                text: templateData.header
                            });
                        }
                    } else if (['image', 'video', 'document'].includes(headerType)) {
                        const inputMap = {
                            'image': '#image-upload-input',
                            'video': '#video-upload-input',
                            'document': '#document-upload-input'
                        };

                        const inputSelector = inputMap[headerType];
                        if ($(inputSelector)[0].files.length > 0) {
                            try {
                                const mediaHandle = await uploadMedia($(inputSelector)[0].files[0], headerType);
                                if (mediaHandle && mediaHandle.media_id) {
                                    templateData.components.push({
                                        type: 'HEADER',
                                        format: headerType.toUpperCase(),
                                        example: {
                                            header_handle: [mediaHandle.media_id]
                                        }
                                    });
                                }
                            } catch (error) {
                                console.error(`${headerType} upload failed:`, error);
                                throw new Error(`Failed to upload header ${headerType}`);
                            }
                        }
                    }
                }

                const bodyComponent = {
                    type: 'BODY',
                    text: templateData.body
                };

                if (variableType === 'number') {
                    const bodyVariables = extractVariables(templateData.body);
                    if (bodyVariables.length > 0) {
                        const bodyExamples = [];
                        bodyVariables.forEach(variable => {
                            const sampleInput = $(`.variable-sample[data-variable="${variable}"]`);
                            bodyExamples.push(sampleInput.length ? sampleInput.val() : variable.replace(/\{\{|\}\}/g, ''));
                        });

                        bodyComponent.example = {
                            body_text: [bodyExamples]
                        };
                    }
                } else {
                    const bodyVariables = extractVariables(templateData.body);
                    if (bodyVariables.length > 0) {
                        const bodyExamples = {};
                        bodyVariables.forEach(variable => {
                            const varName = variable.replace(/\{\{|\}\}/g, '');
                            bodyExamples[varName] = namedVariables[varName] || varName;
                        });

                        bodyComponent.example = {
                            body_text: [bodyExamples]
                        };
                    }
                }

                templateData.components.push(bodyComponent);

                if ($('#template-footer').val() && category !== 'LIMITED-TIME-OFFER') {
                    const footerComponent = {
                        type: 'FOOTER',
                        text: $('#template-footer').val()
                    };

                    const footerVariables = extractVariables($('#template-footer').val());
                    if (footerVariables.length > 0) {
                        if (variableType === 'number') {
                            const footerExamples = [];
                            footerVariables.forEach(variable => {
                                const sampleInput = $(`.footer-variable-sample[data-variable="${variable}"]`);
                                footerExamples.push(sampleInput.length ? sampleInput.val() : variable.replace(/\{\{|\}\}/g, ''));
                            });

                            footerComponent.example = {
                                footer_text: footerExamples
                            };
                        } else {
                            const footerExamples = {};
                            footerVariables.forEach(variable => {
                                const varName = variable.replace(/\{\{|\}\}/g, '');
                                footerExamples[varName] = namedVariables[varName] || varName;
                            });

                            footerComponent.example = {
                                footer_text: [footerExamples]
                            };
                        }
                    }

                    templateData.components.push(footerComponent);
                }

                const actionType = $('input[name="interactive-action"]:checked').val();
                if (actionType === 'all') {
                    const buttons = [];
                    $('#quick-replies-list .quick-reply-item').each(function() {
                        const buttonType = $(this).find('.button-type-select').val();
                        const buttonText = $(this).find('input[type="text"]').val().trim();

                        if (buttonText) {
                            if (buttonType === 'quick_reply') {
                                buttons.push({
                                    type: 'QUICK_REPLY',
                                    text: buttonText
                                });
                            } else if (buttonType === 'url') {
                                const url = $(this).find('.button-extra-input[data-type="url"] input').val() || 'https://example.com';
                                buttons.push({
                                    type: 'URL',
                                    text: buttonText,
                                    url: url,
                                    example: [url]
                                });
                            } else if (buttonType === 'copy_code') {
                                const code = $(this).find('.button-extra-input[data-type="copy_code"] input').val() || 'COUPON123';
                                buttons.push({
                                    type: 'COPY_CODE',
                                    text: 'Copy Code',
                                    example: [code]
                                });
                            } else if (buttonType === 'phone_number') {
                                const phoneNumber = $(this).find('.button-extra-input[data-type="phone_number"] input').val() || '15550051310';
                                buttons.push({
                                    type: 'PHONE_NUMBER',
                                    text: buttonText,
                                    phone_number: phoneNumber
                                });
                            }
                        }
                    });

                    if (buttons.length > 0) {
                        templateData.components.push({
                            type: 'BUTTONS',
                            buttons: buttons
                        });
                    }
                }

                return templateData;
            }

            // function validateSnakeCaseFields() {
            //     let isValid = true;
                
            //     if ($('input[name="header-type"]:checked').val() === 'text') {
            //         const headerText = $('#header-content').val();
            //         const variables = extractVariables(headerText);
                    
            //         variables.forEach(variable => {
            //             const varName = variable.replace(/\{\{|\}/g, '');
            //             if (!isValidSnakeCase(varName)) {
            //                 $('#header-content-snake-case-error').show().text(`"${varName}" is not valid snake_case format`);
            //                 isValid = false;
            //             } 
            //         });
            //     }
                
            //     const bodyText = $('#template-body').val();
            //     const bodyVariables = extractVariables(bodyText);
                
            //     bodyVariables.forEach(variable => {
            //         const varName = variable.replace(/\{\{|\}/g, '');
            //         if (!isValidSnakeCase(varName)) {
            //             $('#template-body-snake-case-error').show().text(`"${varName}" is not valid snake_case format`);
            //             isValid = false;
            //         }
            //     });
                
            //     return isValid;
            // }

            $('#header-content, #template-body').on('input', function() {
                if (variableType === 'name') {
                    const text = $(this).val();
                    const convertedText = text.replace(/\{\{([^}]+)\}\}/g, function(match, variableName) {
                        return `{{${variableName.toLowerCase()}}}`;
                    });
                    
                    if (text !== convertedText) {
                        $(this).val(convertedText);
                    }
                    const variables = extractVariables(text);
                    
                    const errorElement = $(`#${this.id}-snake-case-error`);
                    
                    if (variables.length === 0) {
                        errorElement.hide();
                        return;
                    }
                    
                    let hasError = false;
                    variables.forEach(variable => {
                        const varName = variable.replace(/\{\{|\}/g, '');
                        if (!isValidSnakeCase(varName)) {
                            hasError = true;
                            errorElement.show().text(`"${varName}" is not valid snake_case format`);
                        }
                    });
                    
                    if (!hasError) {
                        errorElement.hide();
                    }
                }
            });

            $('#template-category').change(function() {
                initTemplateType();
                updatePreview();
            }).trigger('change');

            $('input[name="interactive-action"]').change(function() {
                const category = $('#template-category').val();
                
                if (category !== 'catalogue') {
                    if ($(this).val() === 'all') {
                        $('#quick-replies-container').show();
                    } else {
                        $('#quick-replies-container').hide();
                    }
                }
                updatePreview();
            });

            $('#quick-replies-list').on('click', '.btn-add-reply', function() {
                const buttons = $('#quick-replies-list .quick-reply-item');
                const selectedType = $(this).closest('.quick-reply-item').find('.button-type-select').val();
                
                let quickReplyCount = 0;
                let ctaCount = 0;
                
                buttons.each(function() {
                    const buttonType = $(this).find('.button-type-select').val();
                    if (buttonType === 'quick_reply') {
                        quickReplyCount++;
                    } else {
                        ctaCount++;
                    }
                });
                
                if (selectedType === 'quick_reply' && quickReplyCount >= 3) {
                    alert('Maximum 3 quick reply buttons allowed');
                    return;
                }
                
                if (selectedType !== 'quick_reply' && ctaCount >= 2) {
                    alert('Maximum 2 call-to-action buttons allowed');
                    return;
                }

                const newReply = `
                    <div class="quick-reply-item">
                        <div class="button-input-container">
                            <select class="form-control button-type-select">
                                <option value="quick_reply">Quick Reply</option>
                                <option value="url">URL Button</option>
                                <option value="copy_code">Copy Code</option>
                            </select>
                            <input type="text" class="form-control" placeholder="Enter button text">
                        </div>
                        <div class="button-extra-input" data-type="url">
                            <input type="url" class="form-control" placeholder="https://example.com">
                        </div>
                        <div class="button-extra-input" data-type="copy_code">
                            <input type="text" class="form-control" placeholder="SUMMER20">
                        </div>
                    </div>
                `;
                $(this).closest('.quick-reply-item').after(newReply);
                updateQuickReplyButtons();
                updatePreview();
            });

            $('#quick-replies-list').on('click', '.btn-remove-reply', function() {
                $(this).closest('.quick-reply-item').remove();
                updateQuickReplyButtons();
                updatePreview();
            });

            $('#quick-replies-list').on('change', '.button-type-select', function() {
                updateQuickReplyButtons();
                updatePreview();
            });

            $('#quick-replies-list').on('input', '.url-button-text, .url-input', function() {
                const buttonText = $('.url-button-text').val().trim();
                const urlValue = $('.url-input').val().trim();
                
                if (buttonText.length > 25) {
                    $(this).addClass('has-error');
                    alert('URL button text cannot exceed 25 characters');
                } else if (urlValue.length > 2000) {
                    $(this).addClass('has-error');
                    alert('URL cannot exceed 2000 characters');
                } else {
                    $(this).removeClass('has-error');
                }
                
                updatePreview();
            });

            $(document).on('input change',
                '#header-content, #template-footer, #template-body, #quick-replies-list input, ' +
                '.variable-sample, .header-variable-sample, #offer-text, #offer-expiry-date, ' +
                '#offer-expiry-time, .button-extra-input input', updatePreview);

            async function uploadMedia(file, type) {
                const formData = new FormData();
                const accountId = $('#business-account-id').val();  
                formData.append('media', file);
                formData.append('account_id', accountId);
                formData.append('type', type);
                try {
                    const response = await $.ajax({
                        url: '/upload-media/meta',
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content'),
                        }
                    });

                    if (response.success) {
                        return {
                            url: response.url,
                            path: response.path,
                            media_id: response.media_id
                        };
                    } else {
                        throw new Error(response.message || 'Media upload failed');
                    }
                } catch (error) {
                    console.error('Media upload error:', error);
                    throw error;
                }
            }

            $('#submit-template').click(async function() {
                const $btn = $(this);
                const originalText = $btn.html();
                const buttonType = $(this).find('.button-type-select').val();

                try {
                    $btn.html('<i class="fas fa-spinner fa-spin"></i> Submitting...').prop('disabled', true);

                    if (!validateTemplateName()) {
                        throw new Error('Please fix template name validation errors');
                    }

                    if (!validateVariableToLengthRatio()) {
                        throw new Error('Too many variables relative to message length');
                    }

                    if (buttonType === 'phone_number') {
                        const phoneNumber = $(this).find('.button-extra-input[data-type="phone_number"] input').val();
                        if (!validatePhoneNumber(phoneNumber)) {
                            throw new Error('Invalid phone number format');
                        }
                    }

                    if (!validateForm()) {
                         throw new Error('Please fix validation errors before submitting');
                    }

                    const accountId = $('#business-account-id').val();
                    if (!accountId) {
                        throw new Error('Business account not found');
                    }

                    const templateData = await prepareTemplateData();

                    const response = await $.ajax({
                        url: `/whatsapp/business-accounts/${accountId}/templates`,
                        method: 'POST',
                        data: JSON.stringify(templateData),
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json'
                        }
                    });

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Template submitted successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = `/whatsapp/business-accounts/${accountId}/templates`;
                        });
                    } else {
                        throw new Error(response.error || 'Failed to submit template');
                    }
                } catch (error) {
                    console.error('Template submission error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Failed to submit template',
                        confirmButtonText: 'OK'
                    });
                } finally {
                    $btn.html(originalText).prop('disabled', false);
                }
            });

            function validateForm() {
                const category = $('#template-category').val();
                
                const templateName = $('#template-name').val().trim();
                if (!templateName) {
                    Swal.fire('Error', 'Template name is required', 'error');
                    return false;
                }
                
                if (category === 'limited_time_offer') {
                    if (!$('#offer-media-upload-input')[0].files.length) {
                        Swal.fire('Error', 'Header image is required for Limited Time Offer templates', 'error');
                        return false;
                    }
                    
                    const offerText = $('#offer-text').val().trim();
                    if (!offerText) {
                        Swal.fire('Error', 'Offer text is required for Limited Time Offer templates', 'error');
                        return false;
                    }
                    
                    if (offerText.length > 16) {
                        Swal.fire('Error', 'Offer text cannot exceed 16 characters', 'error');
                        return false;
                    }
                    
                    const offerCode = $('#offer-code').val().trim();
                    if (offerCode && offerCode.length > 15) {
                        Swal.fire('Error', 'Offer code cannot exceed 15 characters', 'error');
                        return false;
                    }
                }

                if (category === 'UTILITY') {
                    const hasMarketingFeatures = $('.button-type-select').filter(function() {
                        return $(this).val() === 'copy_code' || $(this).val() === 'url';
                    }).length > 0;
                    
                    if (hasMarketingFeatures) {
                        throw new Error('Utility templates cannot contain marketing features like URL or Copy Code buttons');
                    }
                }
            
                const bodyText = $('#template-body').val().trim();
                if (!bodyText) {
                    Swal.fire('Error', 'Message content is required', 'error');
                    return false;
                }
                
                if (bodyText.length > 1024) {
                    Swal.fire('Error', 'Message content cannot exceed 1024 characters', 'error');
                    return false;
                }
                
                return true;
        }


            $('#reset-template').click(function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to reset the form, all your changes will be lost!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, continue!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                            resetFormState();
                        
                        Swal.fire(
                            'Changed!',
                            'Form has been reset.',
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'Cancelled',
                            'Your form is safe :)',
                            'info'
                        );
                }
                });
            });

            function resetFormState() {
                variableType = 'number';
                $('input[name="global-variable-type"][value="number"]').prop('checked', true);
                $('.variable-type-option').removeClass('selected');
                $('#global-number-option').addClass('selected');
                $('#global-snake-case-hint').hide();
                
                $('input[name="header-type"][value="text"]').prop('checked', true);
                $('#text-header-container').show();
                $('#image-upload-container, #video-upload-container, #document-upload-container').hide();
                
                $('input[name="interactive-action"][value="none"]').prop('checked', true);
                $('#quick-replies-container').hide();
                
                fieldVariables['header-content'].variables = [];
                fieldVariables['header-content'].count = 0;
                fieldVariables['template-body'].variables = [];
                fieldVariables['template-body'].count = 0;
                fieldVariables['template-footer'].variables = [];
                fieldVariables['template-footer'].count = 0;
                namedVariables = {};
                
                $('#header-variables-display').empty();
                $('#body-variables-display').empty();
                $('#footer-variables-display').empty();
                $('#header-variable-list').hide();
                $('#body-variable-list').hide();
                $('#footer-variable-list').hide();
                
                $('#header-variable-fields').empty();
                $('#variable-fields').empty();
                
                $('#header-content').val('');
                $('#template-body').val('');
                $('#template-footer').val('');
                
                $('#header-counter').text('0/60 characters');
                $('#body-counter').text('0/1028 characters');
                $('#footer-counter').text('0/60 characters');
                
                $('#image-preview').attr('src', '').hide();
                $('#image-upload-input').val('');
                $('#remove-image').hide();
                $('#image-upload-container p').text('Click to upload image (JPG, PNG)');
                
                $('#video-preview').attr('src', '').hide();
                $('#video-upload-input').val('');
                $('#remove-video').hide();
                $('#video-upload-container p').text('Click to upload video (MP4)');
                
                $('#document-preview').hide();
                $('#document-name').text('');
                $('#document-upload-input').val('');
                $('#remove-document').hide();
                $('#document-upload-container p').text('Click to upload document (PDF, DOC)');
                
                $('#offer-media-preview').attr('src', '').hide();
                $('#offer-media-upload-input').val('');
                $('#remove-offer-media').hide();
                $('#offer-media-upload-container p').text('Click to upload header image');
                
                $('#quick-replies-list').html(`
                    <div class="quick-reply-item">
                        <div class="button-input-container">
                            <select class="form-control button-type-select">
                                <option value="quick_reply">Quick Reply</option>
                                <option value="url">URL Button</option>
                                <option value="copy_code">Copy Code</option>
                            </select>
                            <input type="text" class="form-control" placeholder="Enter button text">
                        </div>
                        <div class="button-extra-input" style="width: 434px;display:none" data-type="url">
                            <input type="url" class="form-control" placeholder="Enter URL (https://example.com)">
                        </div>
                        <div class="button-extra-input" style="width: 434px;display:none" data-type="copy_code">
                            <input type="text" class="form-control" placeholder="Enter Code (SUMMER20)">
                        </div>
                        <button class="btn-add-reply">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                `);
                
                $('#template-name').val('');
                $('#offer-text').val('');
                $('#offer-expiry-date').val('');
                $('#offer-expiry-time').val('');
                
                $('#template-category').val('utility');
                $('#limited-time-offer-container').hide();
                $('#template-header-container').show();
                $('#footer-container').show();
                
                updatePreview();
            }


            updateUsedVariables();
            resetFormState()
            initTemplateType();
            initCharacterCounters();
            updateQuickReplyButtons();
            updatePreview();
        });
    </script>
    @endverbatim
@endsection