@extends('backend.layouts.app')
@section('css')
    <style>
        #flow-visualization-container {
            width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        #flow-canvas {
            position: absolute;
            width: 5000px;
            height: 5000px;
            transform-origin: 0 0;
            background-color: #f8f9fa;
            background-image:
                linear-gradient(rgba(0, 0, 0, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        #flowVisualizationModal .modal-body {
            padding: 0;
            position: relative;
        }

        .modal-xl {
            max-width: 90%;
            min-height: 90vh;
        }

        .flow-node {
            position: absolute;
            width: 250px;
            border-radius: 8px;
            background: white;
            padding: 12px;
            box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, .15);
            cursor: move;
            z-index: 10;
            border: 1px solid #D1DDE3;
        }

        .flow-start {
            background: #DDEDFA;
            border: 1px solid #76B0CC;
        }

        .text-node {
            border-left: 4px solid #1cc88a;
        }

        .media-node {
            border-left: 4px solid #36b9cc;
        }

        .list-node {
            border-left: 4px solid #f6c23e;
        }

        .template-node {
            border-left: 4px solid #6f42c1;
        }

        .condition-node {
            border-left: 4px solid #e74a3b;
        }

        .node-header {
            padding: 8px 12px;
            color: black;
            font-weight: 600;
            font-size: 1rem;
            border-bottom: 1px solid #e3e6f0;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .node-body {
            padding: 8px;
            font-size: 0.85rem;
        }

        .node-section {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        .node-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            font-weight: 600;
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .node-port {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #a6abb9;
            position: absolute;
            cursor: pointer;
        }

        .input-port {
            left: -7px;
            top: 50%;
            transform: translateY(-50%);
        }

        .output-port {
            right: -7px;
            top: 50%;
            transform: translateY(-50%);
        }

        .connection-line {
            position: absolute;
            pointer-events: none;
            z-index: 5;
        }

        .connection-line svg {
            overflow: visible;
        }

        .connection-line path {
            stroke: #666;
            stroke-width: 2;
            fill: none;
            stroke-dasharray: 5, 3;
        }

        .connection-arrow {
            fill: #666;
        }

        .canvas-controls {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: white;
            border-radius: 8px;
            padding: 8px;
            box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, .15);
            display: flex;
            gap: 8px;
            z-index: 100;
        }

        .canvas-control-btn {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            border: 1px solid #e3e6f0;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #5a5c69;
        }

        .canvas-control-btn:hover {
            background: #f8f9fc;
        }

        .connection-label {
            position: absolute;
            background: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 20px;
            height: 20px;
            font-size: 12px;
            text-align: center;
            line-height: 20px;
            font-weight: bold;
            pointer-events: auto;
            cursor: pointer;
            z-index: 11;
        }

        .minimap-container {
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 180px;
            height: 180px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, .15);
            overflow: hidden;
            z-index: 100;
            border: 1px solid #e3e6f0;
        }

        #minimap {
            width: 100%;
            height: 100%;
            position: relative;
            background: #f8f9fc;
            background-image: linear-gradient(rgba(0, 0, 0, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .minimap-viewport {
            position: absolute;
            border: 2px solid #a6abb9;
            background: rgba(78, 115, 223, 0.1);
            z-index: 10;
            cursor: move;
        }

        .minimap-node {
            position: absolute;
            background-color: #a6abb9;
            border-radius: 2px;
            z-index: 5;
            pointer-events: none;
        }

        .minimap-start-node {
            background-color: #6f42c1;
        }

        .minimap-message-node {
            background-color: #1cc88a;
        }

        .minimap-action-node {
            background-color: #36b9cc;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Flows for Business Account</h4>
                <a href="{{ route('business.flows.create', $businessAccountId) }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Flow
                </a>
            </div>
            <div class="card-body">
                @if ($flows->isEmpty())
                    <div class="alert alert-info">No flows found. Create your first flow!</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($flows as $flow)
                                    <tr>
                                        <td>{{ $flow->name }}</td>
                                        <td>{{ $flow->created_at->format('M d, Y H:i') }}</td>
                                        <td>{{ $flow->updated_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-info view-flow-btn" title="View"
                                                data-flow-id="{{ $flow->id }}" data-flow-name="{{ $flow->name }}"
                                                data-flow-data="{{ json_encode($flow->flow_data) }}">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <a href="{{ route('business.flows.edit', ['businessAccount' => $businessAccountId, 'flow' => $flow->id]) }}"
                                                class="btn btn-sm btn-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form
                                                action="{{ route('business.flows.destroy', ['businessAccount' => $businessAccountId, 'flow' => $flow->id]) }}"
                                                method="POST" style="display:inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this flow?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Flow Visualization Modal -->
    <div class="modal fade" id="flowVisualizationModal" tabindex="-1" aria-labelledby="flowVisualizationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="flowVisualizationModalLabel">Flow Visualization</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- In your modal-body -->
                <div class="modal-body" style="height: 70vh; padding: 0; overflow: hidden;">
                    <div id="flow-visualization-container"
                        style="width: 100%; height: 100%; position: relative; overflow: hidden;">
                        <div id="flow-canvas"
                            style="position: absolute; width: 5000px; height: 5000px; transform-origin: 0 0; background-color: #f8f9fa; background-image: linear-gradient(rgba(0, 0, 0, 0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(0, 0, 0, 0.1) 1px, transparent 1px); background-size: 20px 20px;">
                            <!-- Nodes and connections will be rendered here -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.view-flow-btn').click(function() {
                const flowId = $(this).data('flow-id');
                const flowName = $(this).data('flow-name');
                const flowData = $(this).data('flow-data');

                $('#flowVisualizationModalLabel').text(`Flow Visualization: ${flowName}`);
                initFlowVisualization(flowData);
                $('#flowVisualizationModal').modal('show');
            });

            function initFlowVisualization(flowData) {
                const container = $('#flow-visualization-container');
                container.empty();

                const canvas = $('<div id="flow-canvas"></div>');
                container.append(canvas);

                const nodes = flowData.nodes || [];
                const connections = flowData.connections || [];

                const connectionContainer = $('<div id="connection-container"></div>');
                canvas.append(connectionContainer);

                let canvasState = {
                    scale: 1,
                    offsetX: 0,
                    offsetY: 0,
                    isDragging: false,
                    dragStartX: 0,
                    dragStartY: 0
                };

                flowData.nodes.forEach(node => {
                    const nodeElement = createNodeElement(node);
                    canvas.append(nodeElement);

                    nodeElement.draggable({
                        containment: 'parent',
                        cursor: 'move',
                        drag: function(event, ui) {
                            updateAllConnections();
                            updateMinimapNodePosition(node.id);
                        }
                    });
                });

                flowData.connections.forEach(conn => {
                    createConnection(conn);
                });


                addCanvasControls();
                addMinimap();

                setupEventHandlers();

                updateMinimap();

                function createNodeElement(node) {
                    let nodeClass = 'flow-node';
                    if (node.type === 'start') nodeClass += ' flow-start';
                    if (node.type === 'text') nodeClass += ' text-node';
                    if (node.type === 'media') nodeClass += ' media-node';
                    if (node.type === 'list') nodeClass += ' list-node';
                    if (node.type === 'template') nodeClass += ' template-node';
                    if (node.type === 'condition') nodeClass += ' condition-node';

                    const nodeElement = $(`
                        <div class="${nodeClass}" id="node-${node.id}" 
                             style="left:${node.position.x}px; top:${node.position.y}px;">
                            <div class="node-header">
                                <div>${node.title || node.type}</div>
                                ${node.type !== 'start' ? '<div class="node-port input-port"></div>' : ''}
                                ${node.type === 'condition' ? 
                                    '<div class="node-actions">' +
                                        '<div class="node-port output-port true-port" style="border-color: #46ce46;"></div>' +
                                        '<div class="node-port output-port false-port" style="border-color: #ff6692;"></div>' +
                                    '</div>' : 
                                    '<div class="node-port output-port"></div>'}
                            </div>
                            <div class="node-body">
                                ${renderNodeBody(node)}
                            </div>
                        </div>
                    `);

                    return nodeElement;
                }

                function renderNodeBody(node) {
                    let bodyHtml = '';

                    switch (node.type) {
                        case 'start':
                            bodyHtml = `
                                <div class="node-section">
                                    <div class="section-title">Keywords</div>
                                    <div class="keywords-container">
                                        ${node.data.keywords && node.data.keywords.length > 0 ? 
                                            node.data.keywords.map(keyword => 
                                                `<span class="badge bg-primary me-1">${keyword}</span>`
                                            ).join('') : 
                                            '<span class="text-muted">No keywords</span>'}
                                    </div>
                                </div>
                                ${node.data.regex && node.data.regex.pattern ? `
                                                                                                                                                            <div class="node-section">
                                                                                                                                                                <div class="section-title">Regex</div>
                                                                                                                                                                <div>${node.data.regex.pattern}</div>
                                                                                                                                                                <small class="text-muted">${node.data.regex.case_sensitive ? 'Case sensitive' : 'Case insensitive'}</small>
                                                                                                                                                            </div>` : ''}
                                ${node.data.template ? `
                                                                                                                                                            <div class="node-section">
                                                                                                                                                                <div class="section-title">Template</div>
                                                                                                                                                                <div><strong>${node.data.template.name}</strong></div>
                                                                                                                                                                <div class="small text-muted mt-1">${node.data.template.content}</div>
                                                                                                                                                            </div>` : ''}
                            `;
                            break;

                        case 'text':
                            bodyHtml = `
                                <div class="node-section">
                                    <div class="section-title">Message</div>
                                    <div class="text-message">${node.data.text || 'No text'}</div>
                                </div>
                                ${node.data.buttons && node.data.buttons.length > 0 ? `
                                                                                                                                                            <div class="node-section">
                                                                                                                                                                <div class="section-title">Buttons</div>
                                                                                                                                                                <div class="buttons-container">
                                                                                                                                                                    ${node.data.buttons.map(button => 
                                                                                                                                                                        `<span class="badge bg-secondary me-1">${button.text}</span>`
                                                                                                                                                                    ).join('')}
                                                                                                                                                                </div>
                                                                                                                                                            </div>` : ''}
                                ${node.data.additional_content ? `
                                                                                                                                                            <div class="node-section">
                                                                                                                                                                <div class="section-title">Additional Content</div>
                                                                                                                                                                <div class="small text-muted">${getAdditionalContentPreview(node.data.additional_content)}</div>
                                                                                                                                                            </div>` : ''}
                            `;
                            break;

                        case 'media':
                            bodyHtml = `
                                <div class="node-section">
                                    <div class="section-title">Media</div>
                                    <div><strong>Type:</strong> ${node.data.media.type}</div>
                                    ${node.data.media.url ? `<div class="small text-muted">URL: ${node.data.media.url}</div>` : ''}
                                    ${node.data.media.caption ? `<div class="mt-1">${node.data.media.caption}</div>` : ''}
                                </div>
                                ${node.data.buttons && node.data.buttons.length > 0 ? `
                                                                                                                                                            <div class="node-section">
                                                                                                                                                                <div class="section-title">Buttons</div>
                                                                                                                                                                <div class="buttons-container">
                                                                                                                                                                    ${node.data.buttons.map(button => 
                                                                                                                                                                        `<span class="badge bg-secondary me-1">${button.text}</span>`
                                                                                                                                                                    ).join('')}
                                                                                                                                                                </div>
                                                                                                                                                            </div>` : ''}
                                ${node.data.additional_content ? `
                                                                                                                                                            <div class="node-section">
                                                                                                                                                                <div class="section-title">Additional Content</div>
                                                                                                                                                                <div class="small text-muted">${getAdditionalContentPreview(node.data.additional_content)}</div>
                                                                                                                                                            </div>` : ''}
                            `;
                            break;

                        case 'list':
                            bodyHtml = `
                                ${node.data.list.header ? `
                                                                                                                                                            <div class="node-section">
                                                                                                                                                                <div class="section-title">Header</div>
                                                                                                                                                                <div>${node.data.list.header}</div>
                                                                                                                                                            </div>` : ''}
                                ${node.data.list.body ? `
                                                                                                                                                            <div class="node-section">
                                                                                                                                                                <div class="section-title">Body</div>
                                                                                                                                                                <div>${node.data.list.body}</div>
                                                                                                                                                            </div>` : ''}
                                ${node.data.list.footer ? `
                                                                                                                                                            <div class="node-section">
                                                                                                                                                                <div class="section-title">Footer</div>
                                                                                                                                                                <div>${node.data.list.footer}</div>
                                                                                                                                                            </div>` : ''}
                                ${node.data.list.sections && node.data.list.sections.length > 0 ? `
                                                                                                                                                            <div class="node-section">
                                                                                                                                                                <div class="section-title">Sections</div>
                                                                                                                                                                <div class="small">
                                                                                                                                                                    ${node.data.list.sections.map(section => 
                                                                                                                                                                        `<div class="mb-2">
                                                <strong>${section.title}</strong>
                                                <div>${section.items.map(item => item.title).join(', ')}</div>
                                            </div>`
                                                                                                                                                                    ).join('')}
                                                                                                                                                                </div>
                                                                                                                                                            </div>` : ''}
                                ${node.data.additional_content ? `
                                                                                                                                                            <div class="node-section">
                                                                                                                                                                <div class="section-title">Additional Content</div>
                                                                                                                                                                <div class="small text-muted">${getAdditionalContentPreview(node.data.additional_content)}</div>
                                                                                                                                                            </div>` : ''}
                            `;
                            break;

                        case 'template':
                            bodyHtml = `
                                ${node.data.template ? `
                                                                                                                                                            <div class="node-section">
                                                                                                                                                                <div class="section-title">Template</div>
                                                                                                                                                                <div><strong>${node.data.template.name}</strong></div>
                                                                                                                                                                <div class="small text-muted mt-1">${node.data.template.content}</div>
                                                                                                                                                            </div>` : ''}
                                ${node.data.additional_content ? `
                                                                                                                                                            <div class="node-section">
                                                                                                                                                                <div class="section-title">Additional Content</div>
                                                                                                                                                                <div class="small text-muted">${getAdditionalContentPreview(node.data.additional_content)}</div>
                                                                                                                                                            </div>` : ''}
                            `;
                            break;

                        case 'condition':
                            bodyHtml = `
                                <div class="node-section">
                                    <div class="section-title">Condition</div>
                                    <div>
                                        ${node.data.condition.field} 
                                        ${node.data.condition.operator} 
                                        ${node.data.condition.value}
                                    </div>
                                </div>
                                <div class="node-section">
                                    <div class="section-title">Outputs</div>
                                    <div class="d-flex justify-content-between">
                                        <span class="badge bg-success">True</span>
                                        <span class="badge bg-danger">False</span>
                                    </div>
                                </div>
                            `;
                            break;

                        case 'ask-address':
                            bodyHtml = `
                                <div class="node-section">
                                    <div class="section-title">Request Message</div>
                                    <div>${node.data.ask_address.request_message}</div>
                                </div>
                                <div class="node-section">
                                    <div class="section-title">Address Field</div>
                                    <div>${node.data.ask_address.address_field}</div>
                                </div>
                            `;
                            break;

                        case 'ask-location':
                            bodyHtml = `
                                <div class="node-section">
                                    <div class="section-title">Request Message</div>
                                    <div>${node.data.ask_location.request_message}</div>
                                </div>
                                <div class="node-section">
                                    <div class="section-title">Location Fields</div>
                                    <div>Longitude: ${node.data.ask_location.longitude_field}</div>
                                    <div>Latitude: ${node.data.ask_location.latitude_field}</div>
                                </div>
                            `;
                            break;

                        case 'ask-question':
                            bodyHtml = `
                                <div class="node-section">
                                    <div class="section-title">Question</div>
                                    <div>${node.data.ask_question.question}</div>
                                </div>
                                <div class="node-section">
                                    <div class="section-title">Field</div>
                                    <div>${node.data.ask_question.field_name}</div>
                                </div>
                                <div class="node-section">
                                    <div class="section-title">Validation</div>
                                    <div>Type: ${node.data.ask_question.validation.type}</div>
                                    <div>Max attempts: ${node.data.ask_question.validation.max_attempts}</div>
                                </div>
                            `;
                            break;

                        case 'ask-media':
                            bodyHtml = `
                                <div class="node-section">
                                    <div class="section-title">Request Message</div>
                                    <div>${node.data.ask_media.request_message}</div>
                                </div>
                                <div class="node-section">
                                    <div class="section-title">Media Type</div>
                                    <div>${node.data.ask_media.media_type}</div>
                                </div>
                                <div class="node-section">
                                    <div class="section-title">Field</div>
                                    <div>${node.data.ask_media.field_name}</div>
                                </div>
                            `;
                            break;

                        case 'api-request':
                            bodyHtml = `
                                <div class="node-section">
                                    <div class="section-title">API Request</div>
                                    <div><strong>${node.data.api_request.method}</strong> ${node.data.api_request.url}</div>
                                </div>
                                ${node.data.api_request.headers && node.data.api_request.headers.length > 0 ? `
                                                                                                                                                            <div class="node-section">
                                                                                                                                                                <div class="section-title">Headers</div>
                                                                                                                                                                <div class="small">
                                                                                                                                                                    ${node.data.api_request.headers.map(header => 
                                                                                                                                                                        `<div>${header.name}: ${header.value}</div>`
                                                                                                                                                                    ).join('')}
                                                                                                                                                                </div>
                                                                                                                                                            </div>` : ''}
                                ${node.data.api_request.body ? `
                                                                                                                                                            <div class="node-section">
                                                                                                                                                                <div class="section-title">Body</div>
                                                                                                                                                                <div class="small text-muted">${node.data.api_request.body}</div>
                                                                                                                                                            </div>` : ''}
                            `;
                            break;

                        case 'connect-flow':
                            bodyHtml = `
                                <div class="node-section">
                                    <div class="section-title">Connect Flow</div>
                                    <div>${node.data.connect_flow.flow_id}</div>
                                </div>
                                <div class="node-section">
                                    <div class="section-title">Options</div>
                                    <div>Transfer data: ${node.data.connect_flow.options.transfer_data ? 'Yes' : 'No'}</div>
                                    <div>Close current: ${node.data.connect_flow.options.close_current ? 'Yes' : 'No'}</div>
                                </div>
                            `;
                            break;

                        default:
                            bodyHtml = '<div class="text-muted">Node details not available</div>';
                    }

                    return bodyHtml;
                }

                function getAdditionalContentPreview(content) {
                    if (!content) return '';

                    switch (content.type) {
                        case 'text':
                            return `Text: ${content.text.substring(0, 50)}...`;
                        case 'media':
                            return `Media (${content.media_type})`;
                        case 'list':
                            return `List with ${content.sections ? content.sections.length : 0} sections`;
                        case 'template':
                            return `Template: ${content.name}`;
                        default:
                            return 'Additional content';
                    }
                }

                function createConnection(conn) {
                    const connectionId = `conn-${conn.from}-${conn.to}`;
                    const startNode = $(`#node-${conn.from}`);
                    const endNode = $(`#node-${conn.to}`);

                    if (!startNode.length || !endNode.length) return;

                    let startPort;
                    if (conn.from_port === 'output') {
                        if (conn.button_number) {
                            startPort = startNode.find('.output-port');
                        } else if (startNode.hasClass('condition-node')) {
                            startPort = conn.button_text === 'True' ?
                                startNode.find('.true-port') :
                                startNode.find('.false-port');
                        } else {
                            startPort = startNode.find('.output-port');
                        }
                    } else {
                        startPort = startNode.find('.input-port');
                    }

                    const endPort = endNode.find('.input-port');

                    const connectionLine = $(`
            <div class="connection-line" id="${connectionId}">
                <svg width="100%" height="100%">
                    <path stroke="#666" stroke-width="2" fill="none" 
                          stroke-dasharray="5,3" marker-end="url(#arrowhead)"/>
                </svg>
                ${conn.button_number ? `<div class="connection-label">${conn.button_number}</div>` : ''}
            </div>
        `);

                    connectionContainer.append(connectionLine);
                    updateConnection({
                        id: connectionId,
                        startNode: startNode,
                        endNode: endNode,
                        startPort: startPort,
                        endPort: endPort,
                        element: connectionLine,
                        buttonNumber: conn.button_number
                    });
                }

                function updateConnection(conn) {
                    const startPortPos = getPortPosition(conn.startPort, conn.startNode);
                    const endPortPos = getPortPosition(conn.endPort, conn.endNode);

                    const dx = endPortPos.left - startPortPos.left;
                    const dy = endPortPos.top - startPortPos.top;
                    const distance = Math.sqrt(dx * dx + dy * dy);
                    const curveFactor = 0.3;

                    const cp1x = startPortPos.left + distance * curveFactor;
                    const cp1y = startPortPos.top;
                    const cp2x = endPortPos.left - distance * curveFactor;
                    const cp2y = endPortPos.top;

                    const pathData =
                        `M${startPortPos.left},${startPortPos.top} C${cp1x},${cp1y} ${cp2x},${cp2y} ${endPortPos.left},${endPortPos.top}`;

                    let svg = conn.element.find('svg');
                    if (svg.length === 0) {
                        conn.element.html(`
                            <svg width="100%" height="100%">
                                <defs>
                                    <marker id="arrowhead" markerWidth="10" markerHeight="7" 
                                            refX="9" refY="3.5" orient="auto">
                                        <polygon points="0 0, 10 3.5, 0 7" fill="#666"/>
                                    </marker>
                                </defs>
                                <path d="${pathData}" stroke="#666" stroke-width="2" fill="none" 
                                    stroke-dasharray="5,3" marker-end="url(#arrowhead)"/>
                            </svg>
                            ${conn.buttonNumber ? `<div class="connection-label">${conn.buttonNumber}</div>` : ''}
                        `);
                    } else {
                        svg.find('path').attr('d', pathData);
                    }

                    if (conn.buttonNumber) {
                        const midX = (startPortPos.left + endPortPos.left) / 2;
                        const midY = (startPortPos.top + endPortPos.top) / 2;
                        conn.element.find('.connection-label').css({
                            left: `${midX - 10}px`,
                            top: `${midY - 10}px`
                        });
                    }
                }

                function addCanvasControls() {
                    const controls = $(`
            <div class="canvas-controls">
                <div class="canvas-control-btn" id="zoom-in" title="Zoom In">
                    <i class="fas fa-search-plus"></i>
                </div>
                <div class="canvas-control-btn" id="zoom-out" title="Zoom Out">
                    <i class="fas fa-search-minus"></i>
                </div>
                <div class="canvas-control-btn" id="reset-view" title="Reset View">
                    <i class="fas fa-sync-alt"></i>
                </div>
            </div>
        `);
                    container.append(controls);
                }

                function addMinimap() {
                    const minimap = $(`
            <div class="minimap-container">
                <div id="minimap">
                    <div class="minimap-viewport"></div>
                </div>
            </div>
        `);
                    container.append(minimap);

                    flowData.nodes.forEach(node => {
                        createMinimapNode(node);
                    });
                }

                function setupEventHandlers() {
                    $('#zoom-in').click(function() {
                        canvasState.scale = Math.min(2, canvasState.scale + 0.1);
                        updateCanvasTransform();
                    });

                    $('#zoom-out').click(function() {
                        canvasState.scale = Math.max(0.5, canvasState.scale - 0.1);
                        updateCanvasTransform();
                    });

                    $('#reset-view').click(function() {
                        canvasState.scale = 1;
                        canvasState.offsetX = 0;
                        canvasState.offsetY = 0;
                        updateCanvasTransform();
                    });

                    // Panning
                    container.on('mousedown', function(e) {
                        if (e.target === this) {
                            canvasState.isDragging = true;
                            canvasState.dragStartX = e.pageX - canvasState.offsetX;
                            canvasState.dragStartY = e.pageY - canvasState.offsetY;
                            $(this).css('cursor', 'grabbing');
                        }
                    });

                    $(document).on('mousemove', function(e) {
                        if (canvasState.isDragging) {
                            canvasState.offsetX = e.pageX - canvasState.dragStartX;
                            canvasState.offsetY = e.pageY - canvasState.dragStartY;
                            updateCanvasTransform();
                        }
                    });

                    $(document).on('mouseup', function() {
                        if (canvasState.isDragging) {
                            canvasState.isDragging = false;
                            container.css('cursor', 'grab');
                            updateMinimap();
                        }
                    });

                    $('.minimap-viewport').draggable({
                        containment: 'parent',
                        cursor: 'move',
                        drag: function(event, ui) {
                            const minimap = $('#minimap');
                            const minimapSize = minimap.width();

                            canvasState.offsetX = -(ui.position.left / minimapSize) * 5000;
                            canvasState.offsetY = -(ui.position.top / minimapSize) * 5000;

                            updateCanvasTransform();
                        }
                    });
                }

                function updateAllConnections() {
                    connectionContainer.find('.connection-line').each(function() {
                        const connId = $(this).attr('id').replace('conn-', '');
                        const [fromId, toId] = connId.split('-');

                        const startNode = $(`#node-${fromId}`);
                        const endNode = $(`#node-${toId}`);

                        if (startNode.length && endNode.length) {
                            const startPort = startNode.find('.output-port');
                            const endPort = endNode.find('.input-port');

                            const originalConn = flowData.connections.find(conn =>
                                conn.from === fromId && conn.to === toId);
                            const buttonNumber = originalConn ? originalConn.button_number : null;

                            updateConnection({
                                id: `conn-${fromId}-${toId}`,
                                startNode: startNode,
                                endNode: endNode,
                                startPort: startPort,
                                endPort: endPort,
                                element: $(this),
                                buttonNumber: buttonNumber
                            });
                        }
                    });
                }


                function getPortPosition(port, parentNode) {
                    const nodeOffset = {
                        left: parseInt(parentNode.css('left')),
                        top: parseInt(parentNode.css('top'))
                    };

                    const portOffset = port.offset();
                    const parentOffset = parentNode.offset();

                    return {
                        left: nodeOffset.left + (portOffset.left - parentOffset.left) + port.outerWidth() / 2,
                        top: nodeOffset.top + (portOffset.top - parentOffset.top) + port.outerHeight() / 2
                    };
                }

                function createMinimapNode(node) {
                    const minimap = $('#minimap');
                    const minimapSize = minimap.width();
                    const canvasWidth = 5000;
                    const canvasHeight = 5000;

                    const minimapX = (node.position.x / canvasWidth) * minimapSize;
                    const minimapY = (node.position.y / canvasHeight) * minimapSize;
                    const minimapWidth = (250 / canvasWidth) * minimapSize;
                    const minimapHeight = (150 / canvasHeight) * minimapSize;

                    let nodeClass = 'minimap-node';
                    if (node.type === 'start') nodeClass += ' minimap-start-node';
                    else if (node.type === 'text' || node.type === 'media' || node.type === 'list' || node.type ===
                        'template')
                        nodeClass += ' minimap-message-node';
                    else
                        nodeClass += ' minimap-action-node';

                    const minimapNode = $(`<div class="${nodeClass}" data-node="${node.id}"></div>`);
                    minimapNode.css({
                        left: minimapX + 'px',
                        top: minimapY + 'px',
                        width: Math.max(4, minimapWidth) + 'px',
                        height: Math.max(4, minimapHeight) + 'px'
                    });

                    minimap.append(minimapNode);
                }

                function updateMinimapNodePosition(nodeId) {
                    const node = $(`#node-${nodeId}`);
                    const minimapNode = $(`.minimap-node[data-node="${nodeId}"]`);
                    const minimap = $('#minimap');

                    if (node.length && minimapNode.length) {
                        const minimapSize = minimap.width();
                        const canvasWidth = 5000;
                        const canvasHeight = 5000;

                        const x = parseInt(node.css('left'));
                        const y = parseInt(node.css('top'));
                        const width = node.outerWidth();
                        const height = node.outerHeight();

                        const minimapX = (x / canvasWidth) * minimapSize;
                        const minimapY = (y / canvasHeight) * minimapSize;
                        const minimapWidth = (width / canvasWidth) * minimapSize;
                        const minimapHeight = (height / canvasHeight) * minimapSize;

                        minimapNode.css({
                            left: minimapX + 'px',
                            top: minimapY + 'px',
                            width: Math.max(2, minimapWidth) + 'px',
                            height: Math.max(2, minimapHeight) + 'px'
                        });
                    }
                }

                function updateMinimap() {
                    const minimap = $('#minimap');
                    const viewport = $('.minimap-viewport');

                    const minimapSize = minimap.width();
                    const canvasWidth = 5000;
                    const canvasHeight = 5000;

                    const containerWidth = container.width();
                    const containerHeight = container.height();

                    const viewportWidth = (containerWidth / (canvasWidth * canvasState.scale)) * minimapSize;
                    const viewportHeight = (containerHeight / (canvasHeight * canvasState.scale)) * minimapSize;

                    const viewportX = (-canvasState.offsetX / canvasWidth) * minimapSize;
                    const viewportY = (-canvasState.offsetY / canvasHeight) * minimapSize;

                    viewport.css({
                        width: Math.max(10, viewportWidth) + 'px',
                        height: Math.max(10, viewportHeight) + 'px',
                        left: Math.max(0, Math.min(minimapSize - viewportWidth, viewportX)) + 'px',
                        top: Math.max(0, Math.min(minimapSize - viewportHeight, viewportY)) + 'px'
                    });
                }

                updateAllConnections();
                updateMinimap();

                function updateCanvasTransform() {
                    canvas.css('transform',
                        `translate(${canvasState.offsetX}px, ${canvasState.offsetY}px) scale(${canvasState.scale})`
                    );
                    updateAllConnections();
                    updateMinimap();
                }

            }
        });
    </script>
@endsection
