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

        .template-builder {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 30px;
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
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
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
        }

        .preview-container {
            background: #E5DDD5;
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-top: 25px;
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
            max-width: 80%;
            padding: 15px;
            border-radius: 8px;
            position: relative;
            font-size: 14px;
            line-height: 1.5;
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

        .coupon-text {
            font-size: 0.9rem;
            color: var(--gray);
            margin-top: 10px;
        }

        .coupon-input-container {
            display: none;
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
            padding: 15px;
            background: #f8fafb;
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        .media-upload {
            display: none;
            margin-top: 20px;
            text-align: center;
            padding: 20px;
            border: 2px dashed var(--border);
            border-radius: 8px;
            cursor: pointer;
        }

        .media-upload i {
            font-size: 48px;
            color: var(--gray);
            margin-bottom: 15px;
        }

        .media-upload p {
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

        .remove-media {
            color: var(--danger);
            cursor: pointer;
            margin-top: 5px;
            display: block;
        }
    </style>
@endsection

@section('content')
    <div class="template-builder">
        <div class="template-header">
            <h1>New Template</h1>
            <p>Create new template as per your needs. <a href="#" class="help-link">Learn more</a></p>
        </div>

        <div class="template-body">
            <div class="row">
                <div class="col-md-8">
                    <!-- Add New Template Section -->
                    <div class="form-card">
                        <div class="section-title">
                            {{-- <i class="fas fa-plus-circle"></i> --}}
                            Add New Template
                        </div>

                        <div class="form-group">
                            <label class="form-label">Select Template Category</label>
                            <select class="form-control" id="template-category">
                                <option value="utility">Utility</option>
                                <option value="marketing">Marketing</option>
                            </select>
                            <div class="form-note">
                                Select the template category for your template among Marketing, Utility.
                                <a href="#" class="help-link">Learn more</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Template Name</label>
                            <input type="text" class="form-control" id="template-name"
                                placeholder="e.g. product_feedback">
                            <div class="form-note">
                                Name can only be in lowercase alphanumeric characters and numbers.
                                Special characters and white-space are not allowed.
                                <a href="#" class="help-link">Learn more</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Select Language (Required)</label>
                            <select class="form-control" id="template-language">
                                <option value="en_US">English</option>
                                <option value="es_ES">Spanish</option>
                                <option value="fr_FR">French</option>
                                <option value="de_DE">German</option>
                                <option value="pt_BR">Portuguese</option>
                            </select>
                            <div class="form-note">
                                Select the language for the template.
                                <a href="#" class="help-link">Learn more</a>
                            </div>
                        </div>
                    </div>

                    <!-- Template Type Section -->
                    <div class="form-card">
                        <div class="section-title">
                            {{-- <i class="fas fa-sliders-h"></i>  --}}
                            Template Type
                        </div>

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

                        <div id="text-header-container">
                            <div class="form-group">
                                <label class="form-label">Template Header (optional)</label>
                                <input type="text" class="form-control" id="header-content"
                                    placeholder="e.g. Thank You for Shopping!">
                                <div class="form-note">
                                    You are allowed a maximum of 60 characters.
                                    <a href="#" class="help-link">Learn more</a>
                                </div>
                            </div>
                        </div>

                        <div id="media-upload-container" class="media-upload">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Click to upload media file</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Template Format</label>
                            <textarea class="form-control" id="template-body" rows="6" placeholder="Enter your message content here...">Hello, {{ 1 }}
we hope you're enjoying your new {{ 2 }}.

We'd love to hear your feedback. Please rate your experience with the product by selecting an option below. Your feedback helps us improve!</textarea>
                            <div class="form-note">
                                Use text formatting: bold, italic, strikethrough. You are allowed a maximum of 1024
                                characters.
                                <a href="#" class="help-link">Learn more</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Template Footer (optional)</label>
                            <input type="text" class="form-control" id="template-footer"
                                placeholder="e.g. Thanks and Regards, Company Name">
                            <div class="form-note">
                                You are allowed a maximum of 60 characters.
                                <a href="#" class="help-link">Learn more</a>
                            </div>
                        </div>

                        <div id="variables-container" class="variables-container">
                            <h4>Variables</h4>
                            <div id="variable-fields"></div>
                        </div>
                    </div>

                    <!-- Interactive Actions Section -->
                    <div class="form-card">
                        <div class="section-title">
                            {{-- <i class="fas fa-hand-pointer"></i> --}}
                            Interactive Actions
                        </div>

                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" id="action-none" name="interactive-action" value="none" checked>
                                <label for="action-none">None</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="action-quick-replies" name="interactive-action"
                                    value="quick-replies">
                                <label for="action-quick-replies">Quick Replies</label>
                            </div>
                            <div class="radio-item" id="coupon-radio-item" style="display: none;">
                                <input type="radio" id="action-coupon" name="interactive-action" value="coupon">
                                <label for="action-coupon">Coupon</label>
                            </div>
                        </div>

                        <div id="coupon-input-container" class="coupon-input-container">
                            <div class="form-group">
                                <label class="form-label">Coupon Text</label>
                                <input type="text" class="form-control" id="coupon-text"
                                    placeholder="e.g. Use code SUMMER20 for 20% off">
                                <div class="form-note">
                                    Enter the coupon text that will be displayed to users.
                                    <a href="#" class="help-link">Learn more</a>
                                </div>
                            </div>
                        </div>

                        <div id="quick-replies-container" class="quick-reply-container" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">Quick Replies</label>
                                <div class="form-note">Enter quick reply here. It will appear as a button in the template.
                                    <a href="#" class="help-link">Learn more</a>
                                </div>
                            </div>

                            <div id="quick-replies-list">
                                <div class="quick-reply-item">
                                    <input type="text" class="form-control" placeholder="Enter quick reply">
                                    <button class="btn-add-reply">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button class="btn-submit">
                            <i class="fas fa-paper-plane"></i> Submit Template
                        </button>
                    </div>
                </div>

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
                                        <div class="header_wtsp" id="preview-header-text"></div>
                                        <div class="content" id="preview-body-content">
                                            Hello, Smart User<br>
                                            we hope you're enjoying your new Wireless Headphone.<br><br>

                                            We'd love to hear your feedback. Please rate your experience with the product by
                                            selecting an option below. Your feedback helps us improve!
                                        </div>
                                        <div class="footer" id="preview-footer-text"></div>
                                        <div class="buttons" id="preview-buttons">
                                            <div class="button">Loved It</div>
                                            <div class="button">It's okay</div>
                                            <div class="button">Needs improvement</div>
                                        </div>
                                        <div id="preview-coupon-text" style="display: none;">
                                            Use coupon code <strong>SUMMER20</strong> for 20% off your next purchase!
                                        </div>
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
    <script>
        $(document).ready(function() {
            function extractVariables(text) {
                const regex = /\{\{(.*?)\}\}/g;
                const matches = text.match(regex);
                if (!matches) return [];

                return [...new Set(matches)];
            }

            function generateVariableFields(vars) {
                $('#variable-fields').empty();

                if (vars.length === 0) {
                    $('#variables-container').hide();
                    return;
                }

                $('#variables-container').show();

                vars.forEach(function(variable) {
                    const varName = variable.replace(/\{\{|\}\}/g, '');
                    const field = `
                    <div class="form-group">
                        <label class="form-label">${variable} - Sample Value</label>
                        <input type="text" class="form-control variable-sample" data-variable="${variable}" 
                               placeholder="Enter sample value for ${varName}">
                    </div>
                `;
                    $('#variable-fields').append(field);
                });
            }

            function updateQuickReplyButtons() {
                $('#quick-replies-list .quick-reply-item').each(function(index) {
                    const $item = $(this);
                    $item.find('.btn-add-reply, .btn-remove-reply').remove();

                    if (index === 0 || $('#quick-replies-list .quick-reply-item').length === 1) {
                        $item.append(`
                            <button class="btn-add-reply">
                                <i class="fas fa-plus"></i>
                            </button>
                        `);
                    } else {
                        $item.append(`
                            <button class="btn-remove-reply">
                                <i class="fas fa-times"></i>
                            </button>
                        `);
                    }
                });
            }

            function updatePreview() {
                const headerType = $('input[name="header-type"]:checked').val();
                const headerContent = $('#header-content').val();
                const footerContent = $('#template-footer').val();


                let headerHTML = '';
                if (headerType === 'text' && headerContent) {
                    headerHTML = `<h5 class="header_wtsp_text">${headerContent}</h5>`;
                } else if (headerType !== 'text') {
                    let icon = 'fa-image';
                    if (headerType === 'video') icon = 'fa-video';
                    if (headerType === 'document') icon = 'fa-file';

                    headerHTML = `
        <div class="header" style="text-align: center; padding: 15px; background: #f0f0f0; border-radius: 8px; margin-bottom: 15px;">
            <i class="fas ${icon}" style="font-size: 36px; color: #666;"></i>
            <div style="font-size: 12px; margin-top: 8px;">${headerType.charAt(0).toUpperCase() + headerType.slice(1)} Content</div>
        </div>
        `;
                }
                $('#preview-header-text').html(headerHTML);

                $('#preview-footer-text').text(footerContent);
                if (footerContent) {
                    $('#preview-footer-text').show();
                } else {
                    $('#preview-footer-text').hide();
                }

                let bodyContent = $('#template-body').val();
                const sampleValues = {};
                $('.variable-sample').each(function() {
                    const variable = $(this).data('variable');
                    const value = $(this).val() || variable.replace(/\{\{|\}\}/g, '');
                    sampleValues[variable] = value;
                });

                for (const [variable, value] of Object.entries(sampleValues)) {
                    const escapedVariable = variable.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                    const regex = new RegExp(escapedVariable, 'g');
                    bodyContent = bodyContent.replace(regex, value);
                }

                $('#preview-body-content').html(bodyContent.replace(/\n/g, '<br>'));

                const actionType = $('input[name="interactive-action"]:checked').val();
                let buttonsHTML = '';
                let couponTextHTML = '';

                if (actionType === 'quick-replies') {
                    buttonsHTML = '<div class="buttons">';
                    $('#quick-replies-list input').each(function() {
                        if ($(this).val().trim() !== '') {
                            buttonsHTML += `<div class="button">${$(this).val()}</div>`;
                        }
                    });
                    buttonsHTML += '</div>';
                    $('#preview-coupon-text').hide();
                } else if (actionType === 'coupon') {
                    const couponText = $('#coupon-text').val() || 'SUMMER20';
                    buttonsHTML = `
            <div class="buttons">
                <div class="button" style="background: white; border-color: #ffc107; font-weight: bold;">
                    <i class="fas fa-tag"></i> Copy Coupon Code
                </div>
            </div>
        `;
                    couponTextHTML = `
            <div class="coupon-preview">
                ${couponText}
            </div>
        `;
                    $('#preview-coupon-text').show();
                } else {
                    $('#preview-coupon-text').hide();
                }

                $('#preview-buttons').html(buttonsHTML);
                $('#preview-coupon-text').html(couponTextHTML);
            }
            updateQuickReplyButtons();

            $('#template-category').change(function() {
                if ($(this).val() === 'marketing') {
                    $('#coupon-radio-item').show();
                } else {
                    $('#coupon-radio-item').hide();
                    if ($('#action-coupon').is(':checked')) {
                        $('#action-none').prop('checked', true).trigger('change');
                    }
                }
            }).trigger('change');

            $('input[name="interactive-action"]').change(function() {
                if ($(this).val() === 'coupon') {
                    $('#coupon-input-container').show();
                } else {
                    $('#coupon-input-container').hide();
                }

                if ($(this).val() === 'quick-replies') {
                    $('#quick-replies-container').show();
                } else {
                    $('#quick-replies-container').hide();
                }
                updatePreview();
            });

            $('#template-body').on('input', function() {
                const variables = extractVariables($(this).val());
                generateVariableFields(variables);
                updatePreview();
            });

            $('input[name="header-type"]').change(function() {
                if ($(this).val() === 'text') {
                    $('#text-header-container').show();
                    $('#media-upload-container').hide();
                } else {
                    $('#text-header-container').hide();
                    $('#media-upload-container').show();
                }
                updatePreview();
            });

            $('#btn-add-reply').click(function() {
                const newReply = `
                    <div class="quick-reply-item">
                        <input type="text" class="form-control" placeholder="Enter quick reply">
                    </div>
                `;
                $('#quick-replies-list').append(newReply);
                updateQuickReplyButtons();
                $('#quick-replies-list').find('.quick-reply-item:last input').on('input', updatePreview);
            });

            $('#quick-replies-list').on('click', '.btn-add-reply', function() {
                const newReply = `
                    <div class="quick-reply-item">
                        <input type="text" class="form-control" placeholder="Enter quick reply">
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

            $('#quick-replies-list').on('input', 'input', updatePreview);

            $(document).on('input', '.variable-sample', updatePreview);

            $('#header-content').on('input', updatePreview);

            $('#template-footer').on('input', updatePreview);

            $('#coupon-text').on('input', updatePreview);

            const initialVariables = extractVariables($('#template-body').val());
            generateVariableFields(initialVariables);
            updatePreview();
        });
    </script>
@endsection
