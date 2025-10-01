@extends('backend.layouts.app')
@section('css')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
    <style>
        :root {
            --sidebar-width: 330px;
            --canvas-bg: #f8f9fa;
            --node-color: #a6abb9;
            --node-hover: #2e59d9;
            --action-color: #36b9cc;
            --message-color: #1cc88a;
            --start-color: #6f42c1;
            --minimap-size: 180px;
        }

        .body {
            background-color: #f5f7fb;
            overflow: hidden;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100vh;
        }

        .app-container {
            display: flex;
            height: 100vh;
            width: 100%;
            overflow: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: #f6f4f4;
            border-right: 1px solid #e3e6f0;
            display: flex;
            flex-direction: column;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .sidebar-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e3e6f0;
            background: #a6abb9;
            color: white;
        }

        /* Tab Styles */
        .components-tabs {
            padding: 0.5rem 1rem 0;
        }

        .nav-underline {
            border-bottom: none;
            justify-content: center;
            padding: 10px;
        }

        .nav-underline .nav-link {
            color: #6e707e;
            padding: 0.75rem 1rem;
            font-weight: 400;
            font-size: 0.9rem;
            border: none;
            position: relative;
            font-size: 20px;
        }

        .nav-underline .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: transparent;
            transition: all 0.3s;
        }

        .nav-underline .nav-link.active {
            color: black;
            font-weight: 500 !important;
        }

        .nav-underline .nav-link.active::after {
            background: black;
        }

        .components-container {
            flex: 1;
            overflow-y: auto;
            padding: 1rem 0;
        }

        /* Tab content styling */
        .tab-pane {
            padding: 0.5rem 0;
        }

        .component-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
            padding: 0 1rem;
        }

        .grid-item {
            padding: 0.8rem;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: move;
            transition: all 0.2s;
        }

        .grid-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .grid-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #AFB5C2;
            font-size: 24px;
            margin-bottom: 8px;
        }

        .grid-name {
            font-size: 1rem;
            font-weight: 400;
            color: black;
            text-align: center;
        }

        .canvas-container {
            flex: 1;
            position: relative;
            background: var(--canvas-bg);
            overflow: hidden;
            width: 100%;
            height: calc(100% - 60px);
        }

        .canvas-header {
            background: white;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e3e6f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .canvas-header h4 {
            margin: 0;
            font-weight: 600;
        }

        .flow-title-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .edit-icon {
            color: #6c757d;
            cursor: pointer;
            font-size: 16px;
            transition: color 0.2s;
        }

        .edit-icon:hover {
            color: #2e59d9;
        }

        .flow-title {
            margin: 0;
            font-weight: 600;
            display: inline-block;
        }

        /* Style for the editable title */
        .flow-title-input {
            border: 1px solid #ced4da;
            border-radius: 10px;
            padding: 4px 8px;
            font-size: 1.25rem;
            font-weight: 600;
            width: 200px;
            outline: none;
        }

        #chatflow-canvas {
            width: 5000px;
            height: 5000px;
            position: absolute;
            transform-origin: 0 0;
            background-size: 20px 20px;
            user-select: none;
            -webkit-user-select: none;
            background-color: var(--canvas-bg);
            /* Add grid pattern */
            background-image:
                linear-gradient(rgba(0, 0, 0, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        #chatflow-connection-container {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 5;
            top: 0;
            left: 0;
        }

        .canvas-controls {
            position: absolute;
            bottom: 8px;
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
            transition: all 0.2s;
        }

        .canvas-control-btn:hover {
            background: #f8f9fc;
            color: var(--node-color);
        }

        /* Node Styles */
        .flow-start {
            position: absolute;
            width: 320px;
            border-radius: 8px;
            background: white;
            background: #DDEDFA;
            padding: 12px;
            box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, .15);
            overflow: hidden;
            cursor: move;
            transform: translate(0, 0);
            z-index: 10;
            transition: box-shadow 0.2s;
            border: 1px solid #76B0CC;
        }


        .flow-node {
            position: absolute;
            width: 372px;
            border-radius: 8px;
            background: #F3F3F3;
            padding: 15px 25px;
            box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, .15);
            overflow: hidden;
            cursor: move;
            transform: translate(0, 0);
            z-index: 10;
            transition: box-shadow 0.2s;
            border: 1px solid #D1DDE3;
            user-select: none;
            -webkit-user-select: none;
        }

        .node-header {
            padding: 12px 15px;
            color: black;
            font-weight: 600;
            font-size: 1.2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .node-body {
            padding: 15px;
            font-size: 0.85rem;
            color: #5a5c69;
            background: white;
            border-radius: 12px;
        }

        .node-section {
            margin-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 15px;
        }

        .node-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 8px;
            color: #a6abb9;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 8px;
            font-size: 0.9rem;
        }

        .node-actions {
            display: flex;
            gap: 6px;
            font-size: 0.9rem;
            align-items: center;
        }

        .node-actions i {
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: background 0.2s;
            color: #5a5c69;
            font-size: 17px;
        }

        .node-actions i:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Connection port */
        .connection-line {
            position: absolute;
            height: 3px;
            background: none;
            border: none;
            transform-origin: 0 0;
            z-index: 10;
            pointer-events: none;
            overflow: visible;
        }

        .connection-line svg {
            overflow: visible;
        }

        .connection-line.temp-connection {
            position: absolute;
            pointer-events: none;
            z-index: 15;
        }

        .connection-line.temp-connection svg {
            overflow: visible;
        }

        .connection-line.temp-connection path {
            stroke: #666;
            stroke-width: 2;
            stroke-dasharray: 5, 3;
            fill: none;
        }


        .connection-arrow {
            position: absolute;
            right: 0;
            top: 50%;
            width: 10px;
            height: 10px;
            transform: translateY(-50%) rotate(45deg);
            background-color: #666;
            clip-path: polygon(0 0, 100% 0, 100% 100%);
            z-index: 11;
        }

        .delete-connection {
            position: absolute;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            pointer-events: auto;
            z-index: 11;
        }

        .delete-connection i {
            font-size: 10px;
            color: #dc3545;
        }

        .node-port {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid var(--node-color);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 20;
            transition: all 0.2s;
        }

        .node-port:hover {
            transform: scale(1.1);
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.2);
        }

        .node-port i {
            font-size: 12px;
            color: var(--node-color);
        }

        .input-port {
            width: 14px !important;
            height: 14px !important;
            left: 2px;
            top: 50%;
            transform: translateY(-50%);
            position: absolute;
        }

        background: var(--action-color);
        }

        */

        /* Connection Styles */
        .connection {
            position: absolute;
            background: #858796;
            transform-origin: 0 0;
            z-index: 5;
        }

        .connection-path {
            fill: none;
            stroke: #666;
            stroke-width: 2;
            stroke-dasharray: 6, 4;
        }

        .connection-label {
            background: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 20px;
            height: 20px;
            font-size: 14px;
            text-align: center;
            line-height: 20px;
            font-weight: bold;
            pointer-events: auto;
            cursor: pointer;
        }

        .connection-wrapper {
            position: absolute;
            width: 100%;
            height: 100%;
            background: black top: 0;
            left: 0;
            pointer-events: none;
            z-index: 5;
        }

        .arrowhead {
            fill: #a6abb9;
        }

        /* Flow Start Specific Styles */
        .keywords-list {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 10px;
        }

        .trigger-summary .alert {
            margin-bottom: 0;
            font-size: 0.85rem;
        }

        .status-selection,
        .keywords-section,
        .regex-section {
            transition: all 0.3s ease;
        }

        .keyword-item {
            background: #eef2ff;
            border: 1px solid #d1d5f7;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            margin: 2px;
        }

        .keyword-item .delete-keyword {
            margin-left: 5px;
            cursor: pointer;
            color: #6c757d;
        }

        .keyword-item .delete-keyword:hover {
            color: #dc3545;
        }

        .section-title i {
            margin-right: 8px;
            width: 16px;
            text-align: center;
        }

        .input-group {
            display: flex;
            margin-bottom: 8px;
        }

        .input-group input {
            flex: 1;
            padding: 6px 10px;
            border: 1px solid #ced4da;
            border-radius: 4px 0 0 4px;
            font-size: 0.85rem;
        }

        .input-group button {
            border-radius: 0 4px 4px 0;
            background: #a6abb9;
            color: white;
            border: none;
            padding: 0 12px;
            cursor: pointer;
        }

        .regex-options {
            display: flex;
            align-items: center;
            margin-top: 8px;
            font-size: 0.8rem;
        }

        .regex-options input {
            margin-right: 6px;
        }

        .template-item {
            background: #f8f9fc;
            border: 1px dashed #d1d5f7;
            border-radius: 4px;
            padding: 8px;
            margin-top: 10px;
            text-align: center;
            font-size: 0.85rem;
        }

        .template-preview-container {
            transition: all 0.3s ease;
        }

        .template-preview {
            background: #f8f9fa;
            border: 1px solid #e3e6f0;
        }

        .change-template-btn {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }

        .template-preview-container h6 {
            color: #2e59d9;
            font-weight: 600;
        }

        .add-template-btn {
            width: 100%;
            background: transparent;
            border: 1px solid #52acd5;
            border-radius: 4px;
            padding: 8px;
            margin-top: 10px;
            cursor: pointer;
            color: #52acd5;
            transition: all 0.3s ease;
        }

        .add-template-btn:hover {
            border-color: #6DC1E8;
            color: #6DC1E8;
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
            /* Add grid pattern to minimap */
            background-image:
                linear-gradient(rgba(0, 0, 0, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 0, 0, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .minimap-viewport {
            position: absolute;
            border: 2px solid var(--node-color);
            background: rgba(78, 115, 223, 0.1);
            z-index: 10;
            cursor: move;
        }

        .toolbar {
            padding: 0.75rem 1.5rem;
            background: #fff;
            border-top: 1px solid #e3e6f0;
            display: flex;
            justify-content: space-between;
        }

        .btn-primary:hover {
            background: #2e59d9;
        }

        .welcome-section {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            z-index: 1;
            color: #5a5c69;
            max-width: 500px;
        }

        .welcome-section h3 {
            font-weight: 600;
            margin-bottom: 15px;
            color: #a6abb9;
        }

        .welcome-section p {
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .welcome-section .drag-hint {
            margin-top: 30px;
            padding: 15px;
            background: #f8f9fc;
            border-radius: 8px;
            display: inline-block;
            color: #6e707e;
        }

        /* Textarea styles */
        .node-textarea {
            width: 100%;
            min-height: 80px;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            resize: vertical;
            font-size: 0.85rem;
        }

        /* Select dropdown styles */
        .node-select {
            width: 100%;
            padding: 6px 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 0.85rem;
        }

        /* Checkbox styles */
        .checkbox-group {
            margin-top: 8px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
        }

        .checkbox-item input {
            margin-right: 8px;
        }

        /* Button styles */
        .node-btn {
            width: 100%;
            padding: 8px;
            background: #f8f9fc;
            border: 1px solid #e3e6f0;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
            margin-top: 8px;
        }

        .node-btn:hover {
            background: #e9ecef;
        }

        /* Media upload preview */
        .media-preview {
            width: 100%;
            height: 120px;
            background: #f8f9fc;
            border: 1px dashed #d1d5f7;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 10px;
            cursor: pointer;
        }

        .media-preview i {
            font-size: 2rem;
            color: #a6abb9;
        }

        /* List item styles */
        .list-item {
            /* display: flex; */
            align-items: center;
            margin-bottom: 8px;
            padding: 8px;
            background: #f8f9fc;
            border-radius: 4px;
        }

        .list-item-handle {
            margin-right: 8px;
            cursor: move;
            color: #a6abb9;
        }

        .list-item-content {
            flex: 1;
        }

        .list-item-delete {
            cursor: pointer;
            color: #dc3545;
        }

        /* API request styles */
        .api-method-select {
            width: 80px;
            margin-right: 8px;
        }

        .api-url-input {
            flex: 1;
        }

        /* Condition styles */
        .condition-rule {
            display: flex;
            margin-bottom: 8px;
        }

        .condition-variable {
            flex: 1;
            margin-right: 8px;
        }

        .condition-operator {
            width: 100px;
            margin-right: 8px;
        }

        .condition-value {
            flex: 1;
        }

        /* Minimap styles */
        .minimap-node {
            position: absolute;
            background-color: var(--node-color);
            border-radius: 2px;
            z-index: 5;
            pointer-events: none;
        }

        .start-node.minimap-node {
            background-color: var(--start-color);
        }

        .message-node.minimap-node {
            background-color: var(--message-color);
        }

        .action-node.minimap-node {
            background-color: var(--action-color);
        }

        /* Dropzone Styles */
        .dropzone {
            border: 2px dashed #d1d5f7;
            border-radius: 5px;
            background: #f8f9fc;
            min-height: 120px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }

        .dropzone .dz-message {
            color: #a6abb9;
            font-size: 1rem;
        }

        .dropzone .dz-message i {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
        }

        .dropzone .dz-preview {
            margin: 10px;
        }

        .dropzone .dz-preview .dz-image {
            border-radius: 5px;
        }

        .dropzone .dz-preview .dz-details {
            opacity: 1;
            background: rgba(0, 0, 0, 0.7);
        }

        .dropzone .dz-preview .dz-progress {
            top: 50%;
            left: 50%;
            margin-top: -10px;
            margin-left: -50px;
            width: 100px;
        }

        /* Neon Styles */
        @keyframes neon-pulse {
            0% {
                box-shadow: 0 0 10px #00ffff, 0 0 20px #00ffff, 0 0 30px #00ffff;
            }

            50% {
                box-shadow: 0 0 15px #00ffff, 0 0 30px #00ffff, 0 0 45px #00ffff;
            }

            100% {
                box-shadow: 0 0 10px #00ffff, 0 0 20px #00ffff, 0 0 30px #00ffff;
            }
        }

        .connection-highlight path {
            stroke: #00ffff !important;
            stroke-width: 3 !important;
            stroke-dasharray: none !important;
            filter: drop-shadow(0 0 5px #00ffff);
            transition: all 0.3s ease-out;
        }

        .connection-highlight polygon {
            fill: #00ffff !important;
            filter: drop-shadow(0 0 5px #00ffff) !important;
        }

        .node-highlight {
            animation: neon-pulse 0.6s infinite alternate;
        }

        /* Connection menu Styles */
        #connectionMenu {
            position: absolute;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, .15);
            width: 200px;
            z-index: 1000;
            display: none;
        }

        .connection-menu-header {
            padding: 10px;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 600;
        }

        .connection-menu-items {
            display: grid;
            grid-template-columns: 1fr;
            gap: 5px;
            padding: 10px;
        }

        .connection-menu-item {
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .connection-menu-item:hover {
            background: #f8f9fc;
        }

        .connection-menu-item i {
            width: 20px;
            text-align: center;
        }

        .content-menu {
            position: absolute;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, .15);
            width: 257px;
            z-index: 1000;
            display: none;
        }

        .content-menu-header {
            padding: 10px;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 600;
        }

        .content-menu-items {
            display: grid;
            grid-template-columns: 1fr;
            gap: 5px;
            padding: 10px;
        }

        .content-menu-item {
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .content-menu-item:hover {
            background: #f8f9fc;
        }

        .content-menu-item i {
            width: 20px;
            text-align: center;
        }


        .content-section {
            padding: 15px;
            border: 1px solid #b3e0e021;
            background: #b3e0e021;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            gap: 22px;
            display: none !important;
        }

        .template-preview {
            background: #f8f9fa;
            border: 1px solid #e3e6f0;
            border-radius: 8px;
            padding: 15px;
        }

        .template-preview h6 {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #4e73df;
        }

        .template-name {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .template-content-preview {
            font-size: 0.85rem;
            line-height: 1.5;
        }

        .ai-agent-node {
            border-color: #6f42c1;
        }

        .ai-agent-node .node-header {
            background-color: #f3e8ff;
            color: #6f42c1;
        }

        .ai-agent-preview {
            padding: 10px;
            background-color: #f8f9fc;
            border-radius: 8px;
            border: 1px solid #e3e6f0;
        }

        .agent-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e9d8fd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6f42c1;
        }

        .header-media {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 2px dashed #dee2e6;
        }

        .header-media .media-placeholder {
            color: #6c757d;
        }

        .header-media .media-placeholder i {
            margin-bottom: 10px;
            display: block;
        }

        .header-media .media-placeholder p {
            margin: 0;
            font-size: 0.9rem;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 15px;
        }

        .button {
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

        .button:hover {
            background: #f0f0f0;
            transform: translateY(-1px);
        }

        /* Different button styles based on type */
        .url-button {
            border-color: #007bff;
            color: #007bff;
        }

        .phone-button {
            border-color: #28a745;
            color: #28a745;
        }

        .quick-reply-button {
            border-color: #6f42c1;
            color: #6f42c1;
        }

        .copy-button {
            border-color: #fd7e14;
            color: #fd7e14;
        }

        .catalog-button {
            border-color: #e83e8c;
            color: #e83e8c;
        }

        .default-button {
            border-color: #6c757d;
            color: #6c757d;
        }

        .template-buttons-container {
            margin-top: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e3e6f0;
        }

        .template-button {
            background: white;
            border: 1px solid #d1d5f7;
            border-radius: 6px;
            padding: 10px;
        }

        .template-button .template-button-text {
            background-color: #f8f9fc;
        }

        .template-button-port {
            border-color: #6f42c1;
        }

        .template-button-port:hover {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
        }

        .flowstart-template-button {
            background: white;
            border: 1px solid #d1d5f7;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 8px;
        }

        .flowstart-template-button .button-text {
            font-weight: 500;
            color: #333;
        }

        .flowstart-button-port {
            border-color: #6f42c1;
            margin-left: 10px;
        }

        .flowstart-button-port:hover {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
        }

        .template-buttons-container {
            margin-top: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #e3e6f0;
        }

        .template-buttons-container h6 {
            color: #4e73df;
            font-weight: 600;
            margin-bottom: 10px;
        }
    </style>
@endsection
@section('content')
    @php $noContainer = true @endphp
    <!-- ============================================================== -->
    <div class="body">
        <div class="app-container">
            <!-- Left Sidebar -->
            <div class="sidebar">
                <!-- Tab Navigation -->
                <div class="components-tabs">
                    <ul class="nav nav-underline" id="componentsTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="messages-tab" data-bs-toggle="tab"
                                data-bs-target="#messages" type="button" role="tab" aria-controls="messages"
                                aria-selected="true">
                                <span>Messages</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="actions-tab" data-bs-toggle="tab" data-bs-target="#actions"
                                type="button" role="tab" aria-controls="actions" aria-selected="false">
                                <span>Actions</span>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Tab Content -->
                <div class="components-container">
                    <div class="tab-content" id="componentsTabContent">
                        <!-- Messages Tab -->
                        <div class="tab-pane fade show active" id="messages" role="tabpanel"
                            aria-labelledby="messages-tab">
                            <div class="component-grid">
                                <!-- Text Button Component -->
                                <div class="grid-item message-component" data-type="text">
                                    <div class="grid-icon">
                                        <i class="fas fa-font"></i>
                                    </div>
                                    <div class="grid-name">Text Button</div>
                                </div>

                                <!-- Media Component -->
                                <div class="grid-item message-component" data-type="media">
                                    <div class="grid-icon">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    <div class="grid-name">Media</div>
                                </div>

                                <!-- List Component -->
                                <div class="grid-item message-component" data-type="list">
                                    <div class="grid-icon">
                                        <i class="fas fa-list"></i>
                                    </div>
                                    <div class="grid-name">List</div>
                                </div>

                                <!-- Template Component -->
                                <div class="grid-item message-component" data-type="template">
                                    <div class="grid-icon">
                                        <i class="fas fa-clone"></i>
                                    </div>
                                    <div class="grid-name">Template</div>
                                </div>

                                <!-- AI Agent Component -->
                                <div class="grid-item message-component" data-type="ai-agent">
                                    <div class="grid-icon">
                                        <i class="fas fa-robot"></i>
                                    </div>
                                    <div class="grid-name">AI Agent</div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions Tab -->
                        <div class="tab-pane fade" id="actions" role="tabpanel" aria-labelledby="actions-tab">
                            <div class="component-grid">
                                <!-- Condition Component -->
                                <div class="grid-item action-component" data-type="condition">
                                    <div class="grid-icon">
                                        <i class="fas fa-code-branch"></i>
                                    </div>
                                    <div class="grid-name">Condition</div>
                                </div>

                                <!-- Ask Address Component -->
                                <div class="grid-item action-component" data-type="ask-address">
                                    <div class="grid-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="grid-name">Ask Address</div>
                                </div>

                                <!-- Ask Location Component -->
                                <div class="grid-item action-component" data-type="ask-location">
                                    <div class="grid-icon">
                                        <i class="fas fa-location-dot"></i>
                                    </div>
                                    <div class="grid-name">Ask Location</div>
                                </div>

                                <!-- Ask Question Component -->
                                <div class="grid-item action-component" data-type="ask-question">
                                    <div class="grid-icon">
                                        <i class="fas fa-question-circle"></i>
                                    </div>
                                    <div class="grid-name">Ask Question</div>
                                </div>

                                <!-- Ask Media Component -->
                                <div class="grid-item action-component" data-type="ask-media">
                                    <div class="grid-icon">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                    <div class="grid-name">Ask Media</div>
                                </div>

                                <!-- API Request Component -->
                                <div class="grid-item action-component" data-type="api-request">
                                    <div class="grid-icon">
                                        <i class="fas fa-plug"></i>
                                    </div>
                                    <div class="grid-name">API Request</div>
                                </div>

                                <!-- Connect Flow Component -->
                                <div class="grid-item action-component" data-type="connect-flow">
                                    <div class="grid-icon">
                                        <i class="fas fa-share-alt"></i>
                                    </div>
                                    <div class="grid-name">Connect Flow</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Canvas Area -->
            <div class="canvas-container">
                <div class="canvas-header">
                    <div class="flow-title-container">
                        <h4 class="flow-title">Untitled Flow</h4>
                        <i class="fas fa-pencil-alt edit-icon" title="Edit flow name"></i>
                    </div>
                    <button class="btn btn-primary save-btn">
                        Save
                    </button>
                </div>
                <div id="chatflow-canvas">
                    <!-- SVG for connections -->
                    <div id="chatflow-connection-container">

                    </div>
                </div>
                <div class="connection-menu" id="connectionMenu">
                    <div class="connection-menu-header">
                        Create New Node
                    </div>
                    <div class="connection-menu-items">
                        <div class="connection-menu-item" data-type="text">
                            <i class="fas fa-font"></i>
                            <span>Text Message</span>
                        </div>
                        <div class="connection-menu-item" data-type="media">
                            <i class="fas fa-image"></i>
                            <span>Media Message</span>
                        </div>
                        <div class="connection-menu-item" data-type="list">
                            <i class="fas fa-list"></i>
                            <span>List Message</span>
                        </div>
                        <div class="connection-menu-item" data-type="template">
                            <i class="fas fa-clone"></i>
                            <span>Template</span>
                        </div>
                    </div>
                </div>

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

                <div class="minimap-container">
                    <div id="minimap">
                        <div class="minimap-viewport"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- jQuery UI -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            let canvasState = {
                scale: 1,
                offsetX: 0,
                offsetY: 0,
                isDragging: false,
                dragStartX: 0,
                dragStartY: 0,
                selectedNode: null,
                connecting: false,
                connectionSource: null,
                nextNodeId: 1,
                connections: [],
                currentPort: null
            };

            let connectionState = {
                isConnecting: false,
                tempConnection: null,
                startPort: null,
                connections: []
            };

            @if (isset($flowData))
                // Set flow title
                $('.flow-title').text('{{ $flow->name }}');

                const flowData = @json($flowData);

                if (flowData.nodes && flowData.nodes.length) {
                    canvasState.nextNodeId = flowData.nodes.length + 1;
                }

                if (flowData.nodes) {
                    flowData.nodes.forEach(node => {
                        const nodeId = node.id;
                        const x = node.position?.x || 100;
                        const y = node.position?.y || 100;

                        switch (node.type) {
                            case 'start':
                                createFlowStartNode(nodeId, x, y, node.data);
                                break;
                            case 'text':
                                createTextNode(nodeId, x, y, node.data);
                                break;
                            case 'media':
                                createMediaNode(nodeId, x, y, node.data);
                                break;
                            case 'list':
                                createListNode(nodeId, x, y, node.data);
                                break;
                            case 'template':
                                createTemplateNode(nodeId, x, y, node.data);
                                break;
                            case 'ai-agent':
                                createAiAgentNode(nodeId, x, y, node.data);
                                break;
                            case 'condition':
                                createConditionNode(nodeId, x, y, node.data);
                                break;
                            case 'ask-address':
                                createAskAddressNode(nodeId, x, y, node.data);
                                break;
                            case 'ask-location':
                                createAskLocationNode(nodeId, x, y, node.data);
                                break;
                            case 'ask-question':
                                createAskQuestionNode(nodeId, x, y, node.data);
                                break;
                            case 'ask-media':
                                createAskMediaNode(nodeId, x, y, node.data);
                                break;
                            case 'api-request':
                                createApiRequestNode(nodeId, x, y, node.data);
                                break;
                            case 'connect-flow':
                                createConnectFlowNode(nodeId, x, y, node.data);
                                break;
                        }
                    });
                }

                if (flowData.connections) {
                    setTimeout(() => {
                        flowData.connections.forEach(connection => {
                            let startPort;

                            if (connection.button_number) {
                                startPort = $(
                                    `[data-node="${connection.from}"][data-button="${connection.button_number}"]`
                                );
                            } else if (connection.from === 'node_start') {
                                startPort = $(`#${connection.from} .output-port`);
                            } else {
                                startPort = $(
                                    `#${connection.from} .output-port:not([data-button])`);
                            }

                            const endPort = $(`#${connection.to} .input-port`);

                            if (startPort.length && endPort.length) {
                                createConnection(startPort, endPort);
                            } else {
                                console.warn('Could not find ports for connection:', connection);
                            }
                        });

                        updateAllConnections();
                    }, 100);
                }
            @else
                createFlowStartNode();
            @endif

            $('#chatflow-canvas').css({
                'width': '5000px',
                'height': '5000px'
            });

            updateCanvasTransform();

            $('.grid-item').draggable({
                revert: 'invalid',
                helper: 'clone',
                cursor: 'move',
                zIndex: 100,
                appendTo: '#chatflow-canvas',
                containment: 'document',
                start: function() {
                    $('.welcome-section').hide();
                },
                drag: function(event, ui) {
                    updateAllConnections();
                },
                stop: function() {
                    updateAllConnections();
                }
            });

            $('#chatflow-canvas').droppable({
                accept: '.grid-item',
                drop: function(event, ui) {
                    const type = ui.draggable.data('type');
                    const category = ui.draggable.hasClass('message-component') ? 'message' :
                        ui.draggable.hasClass('action-component') ? 'action' : 'template';

                    const canvasOffset = $('#chatflow-canvas').offset();
                    const x = (event.pageX - canvasOffset.left - canvasState.offsetX) / canvasState
                        .scale;
                    const y = (event.pageY - canvasOffset.top - canvasState.offsetY) / canvasState
                        .scale;

                    const nodeId = 'node_' + canvasState.nextNodeId++;

                    switch (type) {
                        case 'text':
                            createTextNode(nodeId, x, y);
                            break;
                        case 'media':
                            createMediaNode(nodeId, x, y);
                            break;
                        case 'list':
                            createListNode(nodeId, x, y);
                            break;
                        case 'template':
                            createTemplateNode(nodeId, x, y);
                            break;
                        case 'ai-agent':
                            createAiAgentNode(nodeId, x, y);
                            break;
                        case 'condition':
                            createConditionNode(nodeId, x, y);
                            break;
                        case 'ask-address':
                            createAskAddressNode(nodeId, x, y);
                            break;
                        case 'ask-location':
                            createAskLocationNode(nodeId, x, y);
                            break;
                        case 'ask-question':
                            createAskQuestionNode(nodeId, x, y);
                            break;
                        case 'ask-media':
                            createAskMediaNode(nodeId, x, y);
                            break;
                        case 'api-request':
                            createApiRequestNode(nodeId, x, y);
                            break;
                        case 'connect-flow':
                            createConnectFlowNode(nodeId, x, y);
                            break;
                        default:
                            createGenericNode(nodeId, type, x, y);
                    }
                }
            });

            function createFlowStartNode(nodeId = 'node_start', x = window.innerWidth / 10 - 110, y = window
                .innerHeight / 3 - 100, data = null) {
                if (!nodeId) nodeId = 'node_start';

                const nodeHtml = `
                  <div class="flow-start start-node" id="${nodeId}" style="left:${x}px; top:${y}px;">
    <div class="node-header">
        <div>Flow Trigger</div>
        <div class="node-port output-port" data-node="${nodeId}"></div>
    </div>
    <div class="node-body">
        <!-- Trigger Type Selection -->
        <div class="node-section">
            <div class="section-title">
                <i class="fas fa-bolt"></i> Trigger Type
            </div>
            <div class="form-floating mb-3">
                <select class="form-control trigger-type-select" id="trigger-type-${nodeId}">
                    <option value="">Select a trigger...</option>
                    <option value="client_send" ${data?.trigger_type === 'client_send' ? 'selected' : ''}>Client Sends Message</option>
                    <option value="lead_created" ${data?.trigger_type === 'lead_created' ? 'selected' : ''}>Lead Created</option>
                    <option value="confirmation_status" ${data?.trigger_type === 'confirmation_status' ? 'selected' : ''}>Confirmation Status Change</option>
                    <option value="suivi_status" ${data?.trigger_type === 'suivi_status' ? 'selected' : ''}>Suivi Status Change</option>
                </select>
                <label for="trigger-type-${nodeId}">Trigger Type</label>
            </div>
        </div>

        <!-- Dynamic Status Selection -->
        <div class="node-section status-selection" id="status-selection-${nodeId}" style="display: none;">
            <div class="section-title">
                <i class="fas fa-cog"></i> Status Configuration
            </div>
            <div class="form-floating mb-3">
                <select class="form-control status-select" id="status-select-${nodeId}">
                    <option value="">Select status...</option>
                    <!-- Options will be populated dynamically -->
                </select>
                <label for="status-select-${nodeId}">Select Status</label>
            </div>
        </div>

        <!-- Keywords Section (for client_send trigger) -->
        <div class="node-section keywords-section" id="keywords-section-${nodeId}" style="display: none;">
            <div class="section-title">
                <i class="fas fa-key"></i> Enter Keywords
            </div>
            <div class="form-floating">
                <input type="text" class="form-control keyword-input" id="tb-keywords-${nodeId}" 
                       placeholder="Type, press enter to add keyword">
                <label for="tb-keywords-${nodeId}">Keywords</label>
            </div>
            <div class="keywords-list">
                <!-- Keywords will be added here -->
            </div>
        </div>
        
        <!-- Regex Section -->
        <div class="node-section regex-section" id="regex-section-${nodeId}" style="display: none;">
            <div class="section-title">
                <i class="fas fa-code"></i> Enter Regex
            </div>
            <p class="small text-muted">Enter regex to match substring trigger. Enable toggle for case sensitive regex.</p>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="tb-regex-${nodeId}" placeholder="Enter regex" 
                       value="${data?.regex?.pattern || ''}">
                <label for="tb-regex-${nodeId}">Regex</label>
            </div>
            <div class="regex-options">
                <input type="checkbox" id="caseSensitive-${nodeId}" ${data?.regex?.case_sensitive ? 'checked' : ''}>
                <label for="caseSensitive-${nodeId}">Case Sensitive</label>
            </div>
        </div>
        
        <!-- Template Selection -->
        <div class="node-section template-section" id="template-section-${nodeId}">
            <div class="section-title">
                <i class="fas fa-clone"></i> Choose Template
            </div>
            <p class="small text-muted">Add up to 1 template to begin flow</p>
            
            <!-- Add Template Button (shown when no template is selected) -->
            <button class="btn btn-outline-primary w-100 add-template-btn" data-node="${nodeId}" style="display: block;">
                <i class="fas fa-plus"></i> Choose Template
            </button>
            
            <!-- Template Preview and Change Button (shown when template is selected) -->
            <div class="template-preview-container" style="display: none;">
                <div class="template-preview mt-3 p-3 border rounded">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="mb-0">Selected Template:</h6>
                        <button class="btn btn-sm btn-outline-warning change-template-btn" data-node="${nodeId}">
                            <i class="fas fa-exchange-alt"></i> Change Template
                        </button>
                    </div>
                    <div class="template-name font-weight-bold"></div>
                    <div class="template-content-preview mt-2"></div>
                </div>
            </div>
        </div>

        <!-- Trigger Summary -->
        <div class="node-section trigger-summary" id="trigger-summary-${nodeId}" style="display: none;">
            <div class="section-title">
                <i class="fas fa-info-circle"></i> Trigger Summary
            </div>
            <div class="alert alert-info small">
                <strong>Trigger Role:</strong> <span id="trigger-role-${nodeId}"></span><br>
                <strong>When:</strong> <span id="trigger-when-${nodeId}"></span>
            </div>
        </div>
    </div>
</div>
                `;

                $('#chatflow-canvas').append(nodeHtml);

                initializeTriggerFunctionality(nodeId, data);

                if (data) {
                    if (data.trigger_type) {
                        $(`#trigger-type-${nodeId}`).val(data.trigger_type).trigger('change');

                        if (data.selected_status) {
                            $(`#status-select-${nodeId}`).val(data.selected_status);
                        }

                        if (data.keywords && data.keywords.length) {
                            data.keywords.forEach(keyword => {
                                addKeyword(nodeId, keyword);
                            });
                        }
                    }

                    if (data.template) {
                        updateFlowStartNodeWithTemplate(nodeId, data.template.name, data.template.components || data
                            .template.content);
                    }

                    if (data.regex) {
                        $('#' + nodeId + ' #tb-regex').val(data.regex.pattern);
                        $('#' + nodeId + ' #caseSensitive').prop('checked', data.regex.case_sensitive);
                    }

                    // if (data.template) {
                    //     $('#' + nodeId + ' .add-template-btn').hide();
                    //     const $preview = $('#' + nodeId + ' .template-preview');
                    //     $preview.show();
                    //     $preview.find('.template-name').text(data.template.name);
                    //     $preview.find('.template-content-preview').html(data.template.content);
                    // }
                }

                $('#' + nodeId).draggable({
                    cursor: 'move',
                    drag: function(event, ui) {
                        updateMinimap();
                        updateAllConnections();
                        updateMinimapNodePosition(nodeId);
                    },
                    stop: function() {
                        updateAllConnections();
                        updateMinimapNodePosition(nodeId);
                    }
                });

                const node = $(`#${nodeId}`);
                let nodeType = 'node';
                if (node.hasClass('start-node')) nodeType = 'start';
                else if (node.hasClass('message-node')) nodeType = 'message';
                else if (node.hasClass('action-node')) nodeType = 'action';

                createMinimapNode(
                    nodeId,
                    nodeType,
                    parseInt(node.css('left')),
                    parseInt(node.css('top')),
                    node.outerWidth(),
                    node.outerHeight()
                );

                $('#' + nodeId + ' .delete-btn').click(function() {
                    removeMinimapNode(nodeId);
                    $(this).closest('.flow-node').remove();
                    removeNodeConnections(nodeId);
                });

                $('#' + nodeId + ' .keyword-input').keypress(function(e) {
                    if (e.which == 13) addKeyword();
                });

                $('#' + nodeId + ' .node-port').mousedown(startConnection);
            }

            function updateFlowStartNodeWithTemplate(nodeId, templateName, templateData) {
                const $node = $(`#${nodeId}`);

                if (!$node.length) {
                    console.error('Flow Start Node not found:', nodeId);
                    return;
                }

                console.log('Updating Flow Start Node template:', nodeId, templateName);

                // Hide the "Add Template" button
                $node.find('.add-template-btn').hide();

                // Show the template preview container (specific to Flow Start Node)
                const $previewContainer = $node.find('.template-preview-container');
                console.log('Flow Start Preview container found:', $previewContainer.length);

                $previewContainer.show();

                const $preview = $previewContainer.find('.template-preview');
                $preview.find('.template-name').text(templateName || 'Unnamed Template');

                let previewHtml = '';
                let hasButtons = false;

                try {
                    // Use components array if available, otherwise fallback to direct properties
                    if (templateData.components && Array.isArray(templateData.components)) {
                        templateData.components.forEach(component => {
                            if (!component || !component.type) return;

                            switch (component.type) {
                                case 'HEADER':
                                    previewHtml += generateHeaderComponent(component);
                                    break;
                                case 'BODY':
                                    previewHtml += generateBodyComponent(component);
                                    break;
                                case 'FOOTER':
                                    previewHtml += generateFooterComponent(component);
                                    break;
                                case 'BUTTONS':
                                    previewHtml += generateButtonsComponent(component);
                                    hasButtons = true;

                                    // Add buttons with ports to the Flow Start Node
                                    if (component.buttons && Array.isArray(component.buttons)) {
                                        previewHtml +=
                                            `<div class="template-buttons-container mt-3" id="template-buttons-${nodeId}">`;
                                        previewHtml += `<h6 class="mb-2">Template Buttons:</h6>`;

                                        component.buttons.forEach((button, index) => {
                                            if (button.text) {
                                                previewHtml += generateFlowStartButtonWithPort(
                                                    nodeId, button.text, index + 1, button.type);
                                            }
                                        });

                                        previewHtml += `</div>`;
                                    }
                                    break;
                            }
                        });
                    } else {
                        // Fallback to direct properties
                        if (templateData.header) {
                            previewHtml += `<div class="header"><strong>${templateData.header}</strong></div>`;
                        }
                        if (templateData.body) {
                            previewHtml += `<div class="content">${templateData.body.replace(/\n/g, '<br>')}</div>`;
                        }
                        if (templateData.footer) {
                            previewHtml += `<div class="footer"><small>${templateData.footer}</small></div>`;
                        }

                        // Add buttons if available in direct properties
                        if (templateData.buttons && Array.isArray(templateData.buttons)) {
                            hasButtons = true;
                            previewHtml +=
                                `<div class="template-buttons-container mt-3" id="template-buttons-${nodeId}">`;
                            previewHtml += `<h6 class="mb-2">Template Buttons:</h6>`;

                            templateData.buttons.forEach((button, index) => {
                                if (button.text) {
                                    previewHtml += generateFlowStartButtonWithPort(nodeId, button.text,
                                        index + 1, button.type);
                                }
                            });

                            previewHtml += `</div>`;
                        }
                    }

                    if (!previewHtml) {
                        previewHtml = `<div class="alert alert-warning">No template content available</div>`;
                    }

                } catch (e) {
                    console.error('Error parsing template:', e);
                    previewHtml = `<div class="alert alert-warning">Could not display template preview</div>`;
                }

                $preview.find('.template-content-preview').html(previewHtml);

                // Initialize button ports after the HTML is added
                if (hasButtons) {
                    setTimeout(() => {
                        initializeFlowStartButtonPorts(nodeId);
                    }, 100);
                }

                // Store template data
                $node.find('.template-data').remove();
                $node.append(
                    `<input type="hidden" class="template-data" value='${JSON.stringify(templateData)}'>`
                );

                // Add click handler for change template button
                $node.find('.change-template-btn').off('click').on('click', function() {
                    showTemplatePickerModal(nodeId, 'flow-start');
                });

                console.log('Flow Start Node template updated:', nodeId, templateData);
            }

            function generateFlowStartButtonWithPort(nodeId, buttonText, buttonNumber, buttonType = 'QUICK_REPLY') {
                const buttonId = `flowstart-btn-${nodeId}-${buttonNumber}`;

                return `
        <div class="flowstart-template-button mb-2 d-flex align-items-center justify-content-between position-relative" data-button="${buttonId}">
            <div class="d-flex align-items-center flex-grow-1">
                <span class="badge bg-secondary me-2">${buttonType}</span>
                <span class="button-text">${buttonText}</span>
            </div>
            <div class="d-flex align-items-center">
                <div class="node-port output-port flowstart-button-port" data-node="${nodeId}" data-button="${buttonId}" title="Connect from this button"></div>
            </div>
        </div>
    `;
            }

            function initializeFlowStartButtonPorts(nodeId) {
                const buttonsContainer = $(`#template-buttons-${nodeId}`);

                if (buttonsContainer.length) {
                    buttonsContainer.find('.flowstart-button-port').each(function() {
                        $(this).mousedown(startConnection).css({
                            'cursor': 'crosshair',
                            'z-index': '100'
                        });
                    });
                }
            }

            function initializeTriggerFunctionality(nodeId, data = null) {
                const $node = $(`#${nodeId}`);

                // Trigger type change handler
                $node.find('.trigger-type-select').on('change', function() {
                    const triggerType = $(this).val();
                    updateTriggerSections(nodeId, triggerType);
                    updateTriggerSummary(nodeId, triggerType);
                });

                // Status selection change handler
                $node.find('.status-select').on('change', function() {
                    updateTriggerSummary(nodeId, $node.find('.trigger-type-select').val());
                });

                // Keyword input handler
                $node.find('.keyword-input').keypress(function(e) {
                    if (e.which == 13) {
                        addKeyword(nodeId);
                        updateTriggerSummary(nodeId, $node.find('.trigger-type-select').val());
                    }
                });

                // Template selection handler
                $node.find('.add-template-btn').click(function() {
                    showTemplatePickerModal(nodeId, 'flow-start');
                });

                // Initialize sections based on data or default
                const initialTriggerType = data?.trigger_type || '';
                if (initialTriggerType) {
                    updateTriggerSections(nodeId, initialTriggerType);
                    updateTriggerSummary(nodeId, initialTriggerType);
                }
            }

            function updateTriggerSections(nodeId, triggerType) {
                const $node = $(`#${nodeId}`);

                // Hide all sections first
                $node.find('.status-selection, .keywords-section, .regex-section').hide();

                // Show relevant sections based on trigger type
                switch (triggerType) {
                    case 'confirmation_status':
                    case 'suivi_status':
                        $node.find('.status-selection').show();
                        populateStatusOptions(nodeId, triggerType);
                        break;

                    case 'client_send':
                        $node.find('.keywords-section, .regex-section').show();
                        break;

                    case 'lead_created':
                        // No additional sections needed for lead created
                        break;
                }

                // Always show template section and trigger summary if a trigger is selected
                if (triggerType) {
                    $node.find('.trigger-summary').show();
                } else {
                    $node.find('.trigger-summary').hide();
                }
            }

            function populateStatusOptions(nodeId, triggerType) {
                const $statusSelect = $(`#status-select-${nodeId}`);
                $statusSelect.empty().append('<option value="">Select status...</option>');

                let statusOptions = [];

                if (triggerType === 'confirmation_status') {
                    statusOptions = [
                        'pending',
                        'confirmed',
                        'cancelled',
                        'completed',
                        'rescheduled'
                    ];
                } else if (triggerType === 'suivi_status') {
                    statusOptions = [
                        'new',
                        'in_progress',
                        'follow_up',
                        'completed',
                        'cancelled'
                    ];
                }

                statusOptions.forEach(status => {
                    $statusSelect.append(
                        `<option value="${status}">${status.charAt(0).toUpperCase() + status.slice(1)}</option>`
                    );
                });
            }

            function createTextNode(nodeId, x, y, data = null) {
                const nodeHtml = `
                    <div class="flow-node message-node text-node" id="${nodeId}" style="left:${x}px; top:${y}px;">
                        <div class="node-header">
                            <div>Text Message</div>
                            <div class="node-actions">
                                <i class="fas fa-trash delete-btn" title="Delete"></i>
                            </div>
                        </div>
                        <div class="node-body">
                            <div class="node-section">
                                <div class="section-title">
                                    Message Content
                                </div>
                                <textarea class="form-control node-textarea" placeholder="Enter your text message here..." id="text-message-${nodeId}" style="height: 100px">${data?.text || ''}</textarea>
                            </div>
                            
                            <div class="node-section">
                                <div class="section-title d-flex justify-content-between align-items-center">
                                    <span>Buttons (max 3)</span>
                                    <button class="btn btn-sm btn-outline-primary add-button-btn">
                                        <i class="fas fa-plus me-1"></i> Add Button
                                    </button>
                                </div>
                                <div class="buttons-container" id="buttons-${nodeId}">
                                    <!-- Buttons will be added here -->
                                </div>
                            </div>
                            <!-- Add Content Button -->
                            <div class="node-section content-section">
                                <button class="btn btn-outline-success w-100 add-content-btn" data-node="${nodeId}">
                                    <i class="fas fa-plus me-1"></i> Add Content
                                </button>
                                <div id="content-${nodeId}"></div>
                            </div>
                        </div>
                        <div class="node-port input-port" data-node="${nodeId}">
                        </div>
                    </div>`;

                $('#chatflow-canvas').append(nodeHtml);
                setupNode(nodeId);

                if (data?.buttons && data.buttons.length) {
                    data.buttons.forEach(button => {
                        addButtonToTextNode(nodeId, button.number, button.text);
                    });
                } else {
                    addButtonToTextNode(nodeId, 1);
                }

                if (data?.additional_content) {
                    $(`#${nodeId} .add-content-btn`).click();
                    switch (data.additional_content.type) {
                        case 'text':
                            addTextContent(nodeId, data.additional_content);
                            break;
                        case 'media':
                            addMediaContent(nodeId, data.additional_content);
                            break;
                        case 'list':
                            addListContent(nodeId, data.additional_content);
                            break;
                        case 'template':
                            addTemplateContent(nodeId, data.additional_content);
                            break;
                    }
                }

                $(`#${nodeId} .add-button-btn`).on('click', function() {
                    const buttonsContainer = $(`#buttons-${nodeId}`);
                    const buttonCount = buttonsContainer.find('.message-button').length;

                    if (buttonCount >= 3) {
                        alert('Maximum of 3 buttons allowed');
                        return;
                    }

                    addButtonToTextNode(nodeId, buttonCount + 1);
                });

                $(`#${nodeId} .add-content-btn`).on('click', function() {
                    showContentMenu($(this), nodeId);
                });
            }

            function showContentMenu(button, nodeId) {
                const menuHtml = `
        <div class="content-menu" style="
            position: absolute;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0.15rem 0.5rem rgba(0, 0, 0, .15);
            width: 200px;
            z-index: 1000;
            display: none;
        ">
            <div class="connection-menu-header p-2 border-bottom">
                Add Content
            </div>
            <div class="connection-menu-items p-2">
                <div class="connection-menu-item" data-type="text">
                    <i class="fas fa-font me-2"></i>
                    <span>Text</span>
                </div>
                <div class="connection-menu-item" data-type="media">
                    <i class="fas fa-image me-2"></i>
                    <span>Media</span>
                </div>
                <div class="connection-menu-item" data-type="list">
                    <i class="fas fa-list me-2"></i>
                    <span>List</span>
                </div>
                <div class="connection-menu-item" data-type="template">
                    <i class="fas fa-clone me-2"></i>
                    <span>Template</span>
                </div>
            </div>
        </div>
    `;

                $('.content-menu').remove();

                const menu = $(menuHtml);
                $('body').append(menu);

                const buttonPos = button.offset();
                menu.css({
                    left: buttonPos.left + 'px',
                    top: (buttonPos.top + button.outerHeight() + 5) + 'px',
                    display: 'block'
                });

                menu.find('.connection-menu-item').click(function() {
                    const type = $(this).data('type');
                    addContentToNode(nodeId, type);
                    menu.remove();
                });

                $(document).on('click.contentMenu', function(e) {
                    if (!$(e.target).closest('.content-menu, .add-content-btn').length) {
                        menu.remove();
                        $(document).off('click.contentMenu');
                    }
                });
            }

            function deleteContent(nodeId) {
                const contentContainer = $(`#content-${nodeId}`);
                contentContainer.empty();

                const addContentBtn = $(`#${nodeId} .add-content-btn`);
                addContentBtn.html('<i class="fas fa-plus me-1"></i> Add Content');
                addContentBtn.removeClass('btn-outline-warning').addClass('btn-outline-success');

                connectionState.connections = connectionState.connections.filter(conn => {
                    if (conn.startNodeId === nodeId && conn.buttonNumber) {
                        conn.element.remove();
                        return false;
                    }
                    return true;
                });
            }

            function addContentToNode(nodeId, contentType) {
                const contentContainer = $(`#content-${nodeId}`);
                const addContentBtn = $(`#${nodeId} .add-content-btn`);

                contentContainer.empty();

                addContentBtn.html('<i class="fas fa-exchange-alt me-1"></i> Change Content');
                addContentBtn.removeClass('btn-outline-success').addClass('btn-outline-warning');

                switch (contentType) {
                    case 'text':
                        addTextContent(nodeId);
                        break;
                    case 'media':
                        addMediaContent(nodeId);
                        break;
                    case 'list':
                        addListContent(nodeId);
                        break;
                    case 'template':
                        addTemplateContent(nodeId);
                        break;
                }
            }

            function addTextContent(nodeId) {
                const contentContainer = $(`#content-${nodeId}`);
                const contentButtonId = `content-buttons-${nodeId}`;

                contentContainer.html(`
                    <div class="node-section">
                        <div class="section-title">
                            Additional Text Content
                        </div>
                        <textarea class="form-control node-textarea" placeholder="Enter your additional text here..." style="height: 100px"></textarea>
                    </div>
                    
                    <div class="node-section">
                        <div class="section-title d-flex justify-content-between align-items-center">
                            <span>Buttons (max 3)</span>
                            <button class="btn btn-sm btn-outline-primary add-content-button-btn">
                                <i class="fas fa-plus me-1"></i> Add Button
                            </button>
                        </div>
                        <div class="buttons-container" id="${contentButtonId}">
                            <!-- Buttons will be added here -->
                        </div>
                    </div>
                `);

                addContentButton(nodeId, contentButtonId, 1);

                $(`#${nodeId} .add-content-button-btn`).on('click', function() {
                    const buttonsContainer = $(`#${contentButtonId}`);
                    const buttonCount = buttonsContainer.find('.message-button').length;

                    if (buttonCount >= 3) {
                        alert('Maximum of 3 buttons allowed');
                        return;
                    }

                    addContentButton(nodeId, contentButtonId, buttonCount + 1);
                });
            }

            function addContentButton(nodeId, containerId, buttonNumber) {
                updateAllConnections();
                const buttonId = `content-btn-${nodeId}-${buttonNumber}`;
                const buttonHtml = `
                    <div class="message-button mb-2 d-flex align-items-center position-relative" data-button="${buttonId}">
                        <div class="form-floating flex-grow-1 me-2">
                            <input type="text" class="form-control button-text" placeholder="Button text" value="Button ${buttonNumber}">
                            <label>Button text</label>
                        </div>
                        <div style="display: flex;flex-direction: column;align-items: center;gap: 5px;justify-content: inherit;">
                            <i class="fas fa-trash delete-button-btn" style="font-size: 17px;cursor:pointer;"></i>
                            <div class="node-port output-port" data-node="${nodeId}" data-button="${buttonId}">             
                            </div>
                        </div>
                    </div>
                `;

                const buttonElement = $(buttonHtml).appendTo(`#${containerId}`);

                buttonElement.find('.output-port').mousedown(startConnection).css({
                    'cursor': 'crosshair',
                    'z-index': '100'
                });

                buttonElement.find('.delete-button-btn').on('click', function() {
                    const buttonNum = $(this).closest('.message-button').data('button');
                    removeButtonConnections(nodeId, buttonNum);
                    $(this).closest('.message-button').remove();
                });
            }

            function addMediaContent(nodeId) {
                const contentContainer = $(`#content-${nodeId}`);

                contentContainer.html(`
        <div class="node-section">
            <div class="section-title">
                Media Type
            </div>
            <div class="form-floating mb-3">
                <select class="form-select media-type-select" id="media-type-${nodeId}">
                    <option value="image">Image</option>
                    <option value="video">Video</option>
                    <option value="audio">Audio</option>
                    <option value="document">Document</option>
                </select>
                <label for="media-type-${nodeId}">Media Type</label>
            </div>
        </div>
        <div class="node-section">
            <div class="section-title">
                Media File
            </div>
            <div class="media-upload-container mb-3">
                <div class="dropzone-container">
                    <form action="/upload-media" class="dropzone" id="media-dropzone-${nodeId}">
                        <div class="dz-message" data-dz-message>
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Drop files here or click to upload</p>
                        </div>
                    </form>
                </div>
                <div class="media-preview" id="media-preview-${nodeId}" style="display:none;">
                    <div class="media-preview-content"></div>
                    <input type="hidden" class="media-url" id="media-url-${nodeId}">
                    <button class="btn btn-outline-danger media-remove-btn w-100 mt-2">
                        <i class="fas fa-trash me-1"></i> Remove
                    </button>
                </div>
            </div>
        </div>
        <div class="node-section">
            <div class="section-title">
                Caption
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control node-textarea" placeholder="Optional caption for the media..." id="media-caption-${nodeId}"></textarea>
                <label for="media-caption-${nodeId}">Caption (optional)</label>
            </div>
        </div>
    `);

                const initialType = $(`#media-type-${nodeId}`).val();
                initDropzone(nodeId, initialType);

                $(`#media-type-${nodeId}`).on('change', function() {
                    const newType = $(this).val();
                    resetMediaUpload(nodeId);
                    initDropzone(nodeId, newType);
                });

                $(`#media-preview-${nodeId} .media-remove-btn`).on('click', function() {
                    const mediaUrl = $(`#media-url-${nodeId}`).val();
                    if (mediaUrl) {
                        $.ajax({
                            url: '/delete-media',
                            method: 'POST',
                            data: {
                                url: mediaUrl,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function() {
                                resetMediaUpload(nodeId);
                            }
                        });
                    } else {
                        resetMediaUpload(nodeId);
                    }
                });
            }

            function addListContent(nodeId) {
                const contentContainer = $(`#content-${nodeId}`);

                contentContainer.html(`
        <!-- Header Section -->
        <div class="node-section">
            <div class="section-title">
                Header
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="list-header-${nodeId}" placeholder="Enter header">
                <label for="list-header-${nodeId}">Enter header</label>
            </div>
        </div>
        
        <!-- Body Section -->
        <div class="node-section">
            <div class="section-title">
                Body
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" id="list-body-${nodeId}" placeholder="Enter body"></textarea>
                <label for="list-body-${nodeId}">Enter body</label>
            </div>
        </div>
        
        <!-- Footer Section -->
        <div class="node-section">
            <div class="section-title">
                Footer
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="list-footer-${nodeId}" placeholder="Enter footer">
                <label for="list-footer-${nodeId}">Enter footer</label>
            </div>
        </div>
        
        <!-- Sections Container -->
        <div class="node-section">
            <div class="section-title d-flex justify-content-between align-items-center">
                <span>Sections</span>
                <button class="btn btn-sm btn-outline-primary add-section-btn">
                    <i class="fas fa-plus me-1"></i> Add Section
                </button>
            </div>
            <div class="sections-container" id="sections-${nodeId}">
                <!-- Sections will be added here -->
            </div>
        </div>
    `);

                addNewSection(nodeId);

                $(`#${nodeId} .add-section-btn`).on('click', function() {
                    addNewSection(nodeId);
                });
            }

            function addTemplateContent(nodeId) {
                const contentContainer = $(`#content-${nodeId}`);

                contentContainer.html(`
        <div class="node-section">
            <button class="add-template-btn" data-node="${nodeId}">
                <i class="fas fa-plus"></i> Add Template
            </button>
            <div class="template-preview mt-3" style="display: none;">
                <h6>Selected Template:</h6>
                <div class="template-name font-weight-bold"></div>
                <div class="template-content-preview mt-2"></div>
            </div>
        </div>
    `);

                $(`#${nodeId} .add-template-btn`).click(function() {
                    showTemplatePickerModal(nodeId);
                });
            }

            function addButtonToTextNode(nodeId, buttonNumber) {
                const buttonsContainer = $(`#buttons-${nodeId}`);
                updateAllConnections();


                const newButton = $(`
                    <div class="message-button mb-2 d-flex align-items-center position-relative" data-button="${buttonNumber}">
                        <div class="form-floating flex-grow-1 me-2">
                            <input type="text" class="form-control button-text" placeholder="Button text" value="Button ${buttonNumber}">
                            <label>Button text</label>
                        </div>
                        <div style="display: flex;flex-direction: column;align-items: center;gap: 5px;justify-content: inherit;">
                            <i class="fas fa-trash delete-button-btn" style="font-size: 17px;cursor:pointer;"></i>
                            <div class="node-port output-port" data-node="${nodeId}" data-button="${buttonNumber}">             
                        </div>
                    </div>
                `);

                buttonsContainer.append(newButton);

                newButton.find('.output-port').mousedown(startConnection).css({
                    'cursor': 'crosshair',
                    'z-index': '100'
                });

                newButton.find('.delete-button-btn').on('click', function() {
                    const buttonNum = $(this).closest('.message-button').data('button');
                    removeButtonConnections(nodeId, buttonNum);
                    $(this).closest('.message-button').remove();
                });
            }

            function removeButtonConnections(nodeId, buttonNumber) {
                const buttonsContainer = $(`#buttons-${nodeId}`);
                const buttonCount = buttonsContainer.find('.message-button').length;

                if (buttonCount <= 1) {
                    alert('You must have at least 1 button');
                    return;
                }
                connectionState.connections = connectionState.connections.filter(conn => {
                    if (conn.startNodeId === nodeId && conn.buttonNumber === buttonNumber) {
                        conn.element.remove();
                        return false;
                    }
                    return true;
                });
            }

            function createMediaNode(nodeId, x, y, data = null) {
                const nodeHtml = `
        <div class="flow-node message-node media-node" id="${nodeId}" style="left:${x}px; top:${y}px;">
            <div class="node-header">
                <div>Media Message</div>
                <div class="node-actions">
                    <i class="fas fa-trash delete-btn" title="Delete"></i>
                </div>
            </div>
            <div class="node-body">
                <div class="node-section">
                    <div class="section-title">
                        Media Type
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select media-type-select" id="media-type-${nodeId}">
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                            <option value="audio">Audio</option>
                            <option value="document">Document</option>
                        </select>
                        <label for="media-type-${nodeId}">Media Type</label>
                    </div>
                </div>
                <div class="node-section">
                    <div class="section-title">
                        Media File
                    </div>
                    <div class="media-upload-container mb-3">
                        <div class="dropzone-container">
                            <form action="/upload-media" class="dropzone" id="media-dropzone-${nodeId}">
                                <div class="dz-message" data-dz-message>
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <p>Drop files here or click to upload</p>
                                </div>
                            </form>
                        </div>
                        <div class="media-preview" id="media-preview-${nodeId}" style="display:none;">
                            <div class="media-preview-content"></div>
                            <input type="hidden" class="media-url" id="media-url-${nodeId}">
                            <button class="btn btn-outline-danger media-remove-btn w-100 mt-2">
                                <i class="fas fa-trash me-1"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="node-section">
                    <div class="section-title">
                        Caption
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control node-textarea" placeholder="Optional caption for the media..." id="media-caption-${nodeId}">${data?.media?.caption || ''}</textarea>
                        <label for="media-caption-${nodeId}">Caption (optional)</label>
                    </div>
                </div>
                
                <div class="node-section">
                    <div class="section-title d-flex justify-content-between align-items-center">
                        <span>Buttons (max 3)</span>
                        <button class="btn btn-sm btn-outline-primary add-button-btn">
                            <i class="fas fa-plus me-1"></i> Add Button
                        </button>
                    </div>
                    <div class="buttons-container" id="buttons-${nodeId}">
                        <!-- Buttons will be added here -->
                    </div>
                </div>
                <!-- Add Content Button -->
                <div class="node-section content-section">
                    <button class="btn btn-outline-success w-100 add-content-btn" data-node="${nodeId}">
                        <i class="fas fa-plus me-1"></i> Add Content
                    </button>
                    <div id="content-${nodeId}"></div>
                </div>
            </div>
            <div class="node-port input-port" data-node="${nodeId}"></div>
        </div>`;

                $('#chatflow-canvas').append(nodeHtml);
                setupNode(nodeId);

                if (data?.media) {
                    $(`#media-type-${nodeId}`).val(data.media.type);
                    if (data.media.url) {
                        displayMediaPreview(nodeId, data.media.url, data.media.type, data.media.url.split('/')
                            .pop());
                        $(`#media-url-${nodeId}`).val(data.media.url);
                    }
                }

                if (data?.buttons && data.buttons.length) {
                    data.buttons.forEach(button => {
                        addButtonToMediaNode(nodeId, button.number, button.text);
                    });
                } else {
                    addButtonToMediaNode(nodeId, 1);
                }

                if (data?.additional_content) {
                    $(`#${nodeId} .add-content-btn`).click();
                    addMediaContent(nodeId, data.additional_content);
                }

                const initialType = $(`#media-type-${nodeId}`).val();
                initDropzone(nodeId, initialType);

                $(`#media-type-${nodeId}`).on('change', function() {
                    const newType = $(this).val();
                    resetMediaUpload(nodeId);
                    initDropzone(nodeId, newType);
                });

                $(`#media-preview-${nodeId} .media-remove-btn`).on('click', function() {
                    const mediaUrl = $(`#media-url-${nodeId}`).val();
                    if (mediaUrl) {
                        $.ajax({
                            url: '/delete-media',
                            method: 'POST',
                            data: {
                                url: mediaUrl,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function() {
                                resetMediaUpload(nodeId);
                            }
                        });
                    } else {
                        resetMediaUpload(nodeId);
                    }
                });
            }

            function addButtonToMediaNode(nodeId, buttonNumber) {
                const buttonsContainer = $(`#buttons-${nodeId}`);
                updateAllConnections();

                const newButton = $(`
                    <div class="message-button mb-2 d-flex align-items-center position-relative" data-button="${buttonNumber}">
                        <div class="form-floating flex-grow-1 me-2">
                            <input type="text" class="form-control button-text" placeholder="Button text" value="Button ${buttonNumber}">
                            <label>Button text</label>
                        </div>
                        <div style="display: flex;flex-direction: column;align-items: center;gap: 5px;justify-content: inherit;">
                            <i class="fas fa-trash delete-button-btn" style="font-size: 17px;cursor:pointer;"></i>
                            <div class="node-port output-port" data-node="${nodeId}" data-button="${buttonNumber}">             
                        </div>
                    </div>
                `);

                buttonsContainer.append(newButton);

                newButton.find('.output-port').mousedown(startConnection).css({
                    'cursor': 'crosshair',
                    'z-index': '100'
                });

                newButton.find('.delete-button-btn').on('click', function() {
                    const buttonNum = $(this).closest('.message-button').data('button');
                    removeButtonConnections(nodeId, buttonNum);
                    $(this).closest('.message-button').remove();
                });
            }

            function initDropzone(nodeId, mediaType) {
                const dropzoneElement = $(`#media-dropzone-${nodeId}`)[0];

                if (dropzoneElement.dropzone) {
                    dropzoneElement.dropzone.destroy();
                }

                $(dropzoneElement).find('.dz-preview').remove();
                $(dropzoneElement).removeClass('dz-started');

                const dropzone = new Dropzone(dropzoneElement, {
                    url: '/upload-media',
                    paramName: 'media',
                    maxFiles: 1,
                    acceptedFiles: getAcceptedFiles(mediaType),
                    addRemoveLinks: false,
                    dictDefaultMessage: '',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    init: function() {
                        this.on('success', function(file, response) {
                            if (response.success) {
                                displayMediaPreview(nodeId, response.url, mediaType, file
                                    .name);
                                $(`#media-url-${nodeId}`).val(response.url);
                            } else {
                                this.removeFile(file);
                                alert(response.message || 'Error uploading file');
                            }
                        });
                        this.on('error', function(file, message) {
                            this.removeFile(file);
                            alert('Error: ' + (message.message || 'File upload failed'));
                        });
                        this.on('addedfile', function(file) {
                            if (this.files.length > 1) {
                                this.removeFile(this.files[0]);
                            }
                        });
                    }
                });
            }

            function updateDropzoneAccept(dropzone, mediaType) {
                dropzone.options.acceptedFiles = getAcceptedFiles(mediaType);
            }

            function getAcceptedFiles(mediaType) {
                switch (mediaType) {
                    case 'image':
                        return 'image/jpeg,image/png,image/gif,image/webp';
                    case 'video':
                        return 'video/mp4,video/webm,video/quicktime';
                    case 'audio':
                        return 'audio/mpeg,audio/wav,audio/ogg';
                    case 'document':
                        return 'application/pdf,.doc,.docx,.txt,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                    default:
                        return '*';
                }
            }

            function displayMediaPreview(nodeId, url, mediaType, fileName) {
                const preview = $(`#media-preview-${nodeId}`);
                const previewContent = preview.find('.media-preview-content');

                previewContent.empty();

                if (mediaType === 'image') {
                    previewContent.html(
                        `<img src="https://seller.tashilcod.com/public${url}" class="img-fluid" alt="Uploaded image">`
                    );
                } else if (mediaType === 'video') {
                    previewContent.html(
                        `<video controls class="img-fluid"><source src="https://seller.tashilcod.com/public${url}" type="video/mp4"></video>`
                    );
                } else if (mediaType === 'audio') {
                    previewContent.html(
                        `<audio controls class="w-100"><source src="https://seller.tashilcod.com/public${url}" type="audio/mpeg"></audio>`
                    );
                } else {
                    previewContent.html(`
                        <div class="document-preview">
                            <i class="fas fa-file-alt fa-3x"></i>
                            <p>${fileName}</p>
                        </div>
                    `);
                }

                $(`#media-dropzone-${nodeId}`).hide();
                preview.show();
            }

            function resetMediaUpload(nodeId) {
                const dropzone = $(`#media-dropzone-${nodeId}`)[0].dropzone;
                if (dropzone) {
                    dropzone.removeAllFiles(true);
                }

                $(`#media-url-${nodeId}`).val('');
                $(`#media-preview-${nodeId}`).hide();
                $(`#media-dropzone-${nodeId}`).show();
            }

            function createListNode(nodeId, x, y, data = null) {
                const nodeHtml = `
        <div class="flow-node message-node list-node" id="${nodeId}" style="left:${x}px; top:${y}px;">
            <div class="node-header">
                <div>List Message</div>
                <div class="node-actions">
                    <i class="fas fa-trash delete-btn" title="Delete"></i>
                </div>
            </div>
            
            <div class="node-body">
                <!-- Header Section -->
                <div class="node-section">
                    <div class="section-title">
                        Header
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="list-header-${nodeId}" placeholder="Enter header" value="${data?.list?.header || ''}">
                        <label for="list-header-${nodeId}">Enter header</label>
                    </div>
                </div>
                
                <!-- Body Section -->
                <div class="node-section">
                    <div class="section-title">
                        Body
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="list-body-${nodeId}" placeholder="Enter body">${data?.list?.body || ''}</textarea>
                        <label for="list-body-${nodeId}">Enter body</label>
                    </div>
                </div>
                
                <!-- Footer Section -->
                <div class="node-section">
                    <div class="section-title">
                        Footer
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="list-footer-${nodeId}" placeholder="Enter footer" value="${data?.list?.footer || ''}">
                        <label for="list-footer-${nodeId}">Enter footer</label>
                    </div>
                </div>
                
                <!-- Sections Container -->
                <div class="node-section">
                    <div class="section-title d-flex justify-content-between align-items-center">
                        <span>Sections</span>
                        <button class="btn btn-sm btn-outline-primary add-section-btn">
                            <i class="fas fa-plus me-1"></i> Add Section
                        </button>
                    </div>
                    <div class="sections-container" id="sections-${nodeId}">
                        <!-- Sections will be added here -->
                    </div>
                </div>
                
                <!-- Add Content Button -->
                <div class="node-section content-section">
                    <button class="btn btn-outline-success w-100 add-content-btn" data-node="${nodeId}">
                        <i class="fas fa-plus me-1"></i> Add Content
                    </button>
                    <div id="content-${nodeId}"></div>
                </div>
            </div>
            
            <!-- Node Connection Ports -->
            <div class="node-port input-port" data-node="${nodeId}">
            </div>
        </div>`;

                $('#chatflow-canvas').append(nodeHtml);
                setupNode(nodeId);

                if (data?.list?.sections && data.list.sections.length) {
                    data.list.sections.forEach(section => {
                        const sectionId = addNewSection(nodeId, section.title);
                        section.items.forEach(item => {
                            addNewItem(sectionId, nodeId, item.button_number, item.title, item
                                .description);
                        });
                    });
                } else {
                    addNewSection(nodeId);
                }

                if (data?.additional_content) {
                    $(`#${nodeId} .add-content-btn`).click();
                    addListContent(nodeId, data.additional_content);
                }

                $(`#${nodeId} .add-section-btn`).on('click', function() {
                    addNewSection(nodeId);
                });
            }


            function addNewSection(nodeId) {
                const sectionCount = $(`#${nodeId} .list-section`).length + 1;
                const sectionId = `section-${nodeId}-${sectionCount}`;

                const newSection = $(`
                    <div class="list-section mb-3 border rounded p-3" id="${sectionId}">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="form-floating flex-grow-1 me-2">
                                <input type="text" class="form-control section-title" placeholder="Section title" value="Section ${sectionCount}">
                                <label>Section title</label>
                            </div>
                            <i class="fas fa-trash delete-section-btn" style="font-size: 17px;cursor:pointer;"></i>
                        </div>
                        
                        <div class="items-container">
                            <!-- Items will be added here -->
                        </div>
                        
                        <div class="d-flex justify-content-between mt-2">
                            <button class="btn btn-sm btn-outline-primary add-item-btn">
                                <i class="fas fa-plus me-1"></i> Add Item
                            </button>
                            <span class="item-count">0 items</span>
                        </div>
                    </div>
                `);

                $(`#sections-${nodeId}`).append(newSection);

                addNewItem(sectionId, nodeId, 1);

                setupSectionHandlers(sectionId, nodeId);
            }

            function setupSectionHandlers(sectionId, nodeId) {
                $(`#${sectionId} .add-item-btn`).on('click', function() {
                    const buttonNumber = $(`#${sectionId} .list-item`).length + 1;
                    if (buttonNumber > 10) {
                        alert('Maximum number of items reached');
                        return;
                    }
                    addNewItem(sectionId, nodeId, buttonNumber);
                });

                $(`#${sectionId} .delete-section-btn`).on('click', function() {
                    if ($(`#${sectionId}`).parent().find('.list-section').length > 1) {
                        const items = $(`#${sectionId} .list-item`);
                        items.each(function() {
                            const buttonNumber = $(this).find('.output-port').data('button');
                            removeItemConnections(nodeId, buttonNumber);
                        });
                        $(`#${sectionId}`).remove();
                    } else {
                        alert('You need at least one section');
                    }
                });
            }

            function addNewItem(sectionId, nodeId, buttonNumber) {
                const itemCount = $(`#${sectionId} .list-item`).length + 1;
                const itemId = `${sectionId}-item-${itemCount}`;

                const newItem = $(`
                <div class="list-item mb-3 p-2 border rounded" id="${itemId}">
                        <!-- Title Row -->
                        <div class="d-flex align-items-center mb-2">
                            <div class="form-floating flex-grow-1 me-2">
                                <input type="text" class="form-control item-title" placeholder="Enter title">
                                <label>Enter title</label>
                            </div>
                            <div class="d-flex flex-column align-items-center gap-3">
                                <i class="fas fa-trash delete-item-btn" style="font-size: 17px;cursor:pointer;"></i>
                                <div class="node-port output-port" data-node="${nodeId}" data-button="${buttonNumber}"></div>
                            </div>
                        </div>
                        
                        <!-- Description Row -->
                        <div class="form-floating">
                            <textarea class="form-control item-description" placeholder="Enter description" style="height: 80px"></textarea>
                            <label>Enter description</label>
                        </div>
                    </div>
                `);

                $(`#${sectionId} .items-container`).append(newItem);
                updateItemCount(sectionId);

                newItem.find('.output-port').mousedown(startConnection).css({
                    'cursor': 'crosshair',
                    'z-index': '100'
                });

                newItem.find('.delete-item-btn').on('click', function() {
                    if ($(`#${sectionId} .list-item`).length > 1) {
                        removeItemConnections(nodeId, buttonNumber);
                        $(`#${itemId}`).remove();
                        updateItemCount(sectionId);
                    } else {
                        alert('You need at least one item in this section');
                    }
                });
            }

            function removeItemConnections(nodeId, buttonNumber) {
                connectionState.connections = connectionState.connections.filter(conn => {
                    if (conn.startNodeId === nodeId && conn.buttonNumber === buttonNumber) {
                        conn.element.remove();
                        return false;
                    }
                    return true;
                });
            }


            function updateItemCount(sectionId) {
                const count = $(`#${sectionId} .list-item`).length;
                $(`#${sectionId} .item-count`).text(`${count} ${count === 1 ? 'item' : 'items'}`);
            }

            function createTemplateNode(nodeId, x, y, data = null) {
                const nodeHtml = `
        <div class="flow-node message-node template-node" id="${nodeId}" style="left:${x}px; top:${y}px;">
            <div class="node-header">
                <div>Template Message</div>
                <div class="node-actions">
                    <i class="fas fa-trash delete-btn" title="Delete"></i>
                </div>
            </div>
            <div class="node-body">
                <!-- Template Selection -->
                <div class="node-section template-section" id="template-section-${nodeId}">
                    <div class="section-title">
                        <i class="fas fa-clone"></i> Choose Template
                    </div>
                    <p class="small text-muted">Add a template message</p>
                    
                    <!-- Add Template Button (shown when no template is selected) -->
                    <button class="btn btn-outline-primary w-100 add-template-btn" data-node="${nodeId}" style="display: block;">
                        <i class="fas fa-plus"></i> Choose Template
                    </button>
                    
                    <!-- Template Preview and Change Button (shown when template is selected) -->
                    <div class="template-preview-container" style="display: none;">
                        <div class="template-preview mt-3 p-3 border rounded">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Selected Template:</h6>
                                <button class="btn btn-sm btn-outline-warning change-template-btn" data-node="${nodeId}">
                                    <i class="fas fa-exchange-alt"></i> Change Template
                                </button>
                            </div>
                            <div class="template-name font-weight-bold"></div>
                            <div class="template-content-preview mt-2"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Add Content Button -->
                <div class="node-section content-section">
                    <button class="btn btn-outline-success w-100 add-content-btn" data-node="${nodeId}">
                        <i class="fas fa-plus me-1"></i> Add Content
                    </button>
                    <div id="content-${nodeId}"></div>
                </div>
            </div>
            <div class="node-port input-port" data-node="${nodeId}"></div>
        </div>`;

                $('#chatflow-canvas').append(nodeHtml);
                setupNode(nodeId);

                if (data?.template) {
                    updateNodeWithTemplate(nodeId, data.template.name, data.template.components || data.template
                        .content);
                }

                $(`#${nodeId} .add-template-btn`).click(function() {
                    showTemplatePickerModal(nodeId);
                });

                $(`#${nodeId} .change-template-btn`).click(function() {
                    showTemplatePickerModal(nodeId);
                });

                if (data?.additional_content) {
                    $(`#${nodeId} .add-content-btn`).click();
                    addTemplateContent(nodeId, data.additional_content);
                }
            }

            function showTemplatePickerModal(nodeId) {
                const url = '/whatsapp/business-accounts/' + {{ $businessAccount }} + '/templates/data';

                console.log('Fetching templates from:', url);

                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('Templates API Response:', response);

                        let templates = response.data || [];

                        // Check if node already has a template
                        const $node = $(`#${nodeId}`);
                        const hasTemplate = $node.find('.template-preview-container').is(':visible');
                        const currentTemplateName = $node.find('.template-name').text();

                        const modalHtml = `
                <div class="modal fade" id="templatePickerModal-${nodeId}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    ${hasTemplate ? 'Change Template' : 'Choose a Template'}
                                    ${hasTemplate ? `<small class="text-muted">Current: ${currentTemplateName}</small>` : ''}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                ${hasTemplate ? `
                                                                                                                                                                <div class="alert alert-info d-flex justify-content-between align-items-center">
                                                                                                                                                                    <div>
                                                                                                                                                                        <i class="fas fa-info-circle"></i> 
                                                                                                                                                                        You currently have a template selected. Choose a new one or remove the current template.
                                                                                                                                                                    </div>
                                                                                                                                                                    <button class="btn btn-sm btn-outline-danger remove-template-btn" data-node="${nodeId}">
                                                                                                                                                                        <i class="fas fa-trash"></i> Remove Template
                                                                                                                                                                    </button>
                                                                                                                                                                </div>
                                                                                                                                                            ` : ''}
                                
                                ${templates.length > 0 ? `
                                                                                                                                                                <div class="table-responsive">
                                                                                                                                                                    <table class="table table-hover">
                                                                                                                                                                        <thead>
                                                                                                                                                                            <tr>
                                                                                                                                                                                <th>Name</th>
                                                                                                                                                                                <th>Category</th>
                                                                                                                                                                                <th>Language</th>
                                                                                                                                                                                <th>Status</th>
                                                                                                                                                                                <th>Actions</th>
                                                                                                                                                                            </tr>
                                                                                                                                                                        </thead>
                                                                                                                                                                        <tbody>
                                                                                                                                                                            ${templates.map(template => {
                                                                                                                                                                                const templateName = template.name || 'Unnamed Template';
                                                                                                                                                                                const templateCategory = template.category || 'N/A';
                                                                                                                                                                                const templateLanguage = template.language || 'N/A';
                                                                                                                                                                                const templateStatus = template.status || 'unknown';
                                                                                                                                                                                const templateId = template.id || '';
                                                                                                                                                                                
                                                                                                                                                                                return `
                                                        <tr>
                                                            <td>${templateName}</td>
                                                            <td>${templateCategory}</td>
                                                            <td>${templateLanguage}</td>
                                                            <td>
                                                                <span class="badge bg-${templateStatus === 'approved' ? 'success' : templateStatus === 'pending' ? 'warning' : 'secondary'}">
                                                                    ${templateStatus}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-sm btn-primary select-template-btn" 
                                                                        data-id="${templateId}" 
                                                                        data-name="${templateName}">
                                                                    ${hasTemplate ? 'Change to This' : 'Select'}
                                                                </button>
                                                                <button class="btn btn-sm btn-outline-info preview-template-btn ms-1" 
                                                                        data-template-id="${templateId}">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    `;
                                                                                                                                                                            }).join('')}
                                                                                                                                                                        </tbody>
                                                                                                                                                                    </table>
                                                                                                                                                                </div>
                                                                                                                                                            ` : `
                                                                                                                                                                <div class="alert alert-warning text-center">
                                                                                                                                                                    <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                                                                                                                                                                    <h5>No Templates Found</h5>
                                                                                                                                                                    <p>No WhatsApp templates are available for this business account.</p>
                                                                                                                                                                    <a href="{{ route('whatsapp-templates.create', $businessAccount) }}" class="btn btn-primary">
                                                                                                                                                                        Create New Template
                                                                                                                                                                    </a>
                                                                                                                                                                </div>
                                                                                                                                                            `}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

                        $('body').append(modalHtml);
                        const modalElement = document.getElementById(`templatePickerModal-${nodeId}`);
                        const modal = new bootstrap.Modal(modalElement);

                        modal.show();

                        // Template selection handler
                        $(`#templatePickerModal-${nodeId} .select-template-btn`).click(function() {
                            const templateId = $(this).data('id');
                            const templateName = $(this).data('name');
                            console.log('Template selected for node:', nodeId, templateId,
                                templateName);

                            // Check if this is a Flow Start Node
                            const isFlowStartNode = $(`#${nodeId}`).hasClass('start-node');
                            console.log('Is Flow Start Node:', isFlowStartNode);

                            fetchTemplateDetails(nodeId, templateId, templateName, modal,
                                isFlowStartNode);
                        });

                        // Remove template handler
                        $(`#templatePickerModal-${nodeId} .remove-template-btn`).click(function() {
                            const isFlowStartNode = $(`#${nodeId}`).hasClass('start-node');

                            if (isFlowStartNode) {
                                removeTemplateFromFlowStartNode(nodeId);
                            } else {
                                removeTemplateFromNode(nodeId);
                            }
                            modal.hide();

                            Swal.fire({
                                icon: 'success',
                                title: 'Template Removed',
                                text: 'The template has been removed from the node.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        });

                        // Template preview handler
                        $(`#templatePickerModal-${nodeId} .preview-template-btn`).click(function() {
                            const templateId = $(this).data('template-id');
                            previewTemplateDetails(templateId);
                        });

                        // Cleanup on modal close
                        $(`#templatePickerModal-${nodeId}`).on('hidden.bs.modal', function() {
                            $(this).remove();
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching templates:', error);
                        console.log('XHR response:', xhr.responseText); // Debug log

                        // Fallback modal with error message
                        const errorModalHtml = `
                <div class="modal fade" id="templatePickerModal-${nodeId}">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Error Loading Templates</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger">
                                    <h6>Failed to load templates</h6>
                                    <p>Error: ${error}</p>
                                    <p>Please check your connection and try again.</p>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-primary retry-load-btn">
                                        <i class="fas fa-redo"></i> Retry
                                    </button>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

                        $('body').append(errorModalHtml);
                        const modalElement = document.getElementById(`templatePickerModal-${nodeId}`);
                        const modal = new bootstrap.Modal(modalElement);
                        addVariableHelpToModal(nodeId)
                        modal.show();

                        // Retry button handler
                        $(`#templatePickerModal-${nodeId} .retry-load-btn`).click(function() {
                            $(`#templatePickerModal-${nodeId}`).remove();
                            showTemplatePickerModal(nodeId);
                        });

                        $(`#templatePickerModal-${nodeId}`).on('hidden.bs.modal', function() {
                            $(this).remove();
                        });
                    }
                });
            }

            function removeTemplateFromFlowStartNode(nodeId) {
                const $node = $(`#${nodeId}`);

                // Hide the template preview container
                $node.find('.template-preview-container').hide();

                // Show the "Add Template" button
                $node.find('.add-template-btn').show();

                // Clear template data
                $node.find('.template-data').remove();
                $node.find('.template-name').text('');
                $node.find('.template-content-preview').html('');

                // Remove any connections from template buttons
                connectionState.connections = connectionState.connections.filter(conn => {
                    if (conn.startNodeId === nodeId && conn.isTemplateButton) {
                        conn.element.remove();
                        return false;
                    }
                    return true;
                });

                console.log('Template removed from Flow Start Node:', nodeId);
            }

            function addVariableHelpToModal(modalId) {
                const helpHtml = showTemplateVariablesHelp();
                $(`#${modalId} .modal-body`).prepend(helpHtml);
            }


            function fetchTemplateDetails(nodeId, templateId, templateName, modal, isFlowStartNode = false) {
                const url = '/whatsapp/business-accounts/' + {{ $businessAccount }} + '/templates/' + templateId;

                console.log('Fetching template details for:', nodeId, 'Flow Start:', isFlowStartNode);

                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(templateDetails) {
                        console.log('Template details loaded:', templateDetails);

                        // Use the appropriate function based on node type
                        if (isFlowStartNode) {
                            updateFlowStartNodeWithTemplate(nodeId, templateName, templateDetails);
                        } else {
                            updateNodeWithTemplate(nodeId, templateName, templateDetails);
                        }
                        modal.hide();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching template details:', error);

                        // If we can't get details, still update with basic info
                        if (isFlowStartNode) {
                            updateFlowStartNodeWithTemplate(nodeId, templateName, {
                                name: templateName
                            });
                        } else {
                            updateNodeWithTemplate(nodeId, templateName, {
                                name: templateName
                            });
                        }
                        modal.hide();

                        // Show warning
                        Swal.fire({
                            icon: 'warning',
                            title: 'Limited Template Info',
                            text: 'Template was selected but full details could not be loaded.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            }

            function previewTemplateDetails(templateId) {
                const url = '/whatsapp/business-accounts/' + {{ $businessAccount }} + '/templates/' + templateId;

                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(template) {
                        const previewHtml = `
                <div class="modal fade" id="templateDetailPreview">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Template Preview - ${template.name || 'Unnamed'}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
                                            Template Preview
                                        </div>
                                        <div class="preview-message outgoing">
                                            ${generateTemplatePreviewContent(template)}
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Template Details -->
                                <div class="template-preview-container mt-4">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <h6>Basic Information</h6>
                                            <p><strong>Name:</strong> ${template.name || 'N/A'}</p>
                                            <p><strong>Category:</strong> ${template.category || 'N/A'}</p>
                                            <p><strong>Language:</strong> ${template.language || 'N/A'}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Status</h6>
                                            <span class="badge badge-${template.status === 'approved' ? 'success' : template.status === 'pending' ? 'warning' : 'secondary'}">
                                                ${template.status || 'unknown'}
                                            </span>
                                            <p class="mt-2"><strong>Template ID:</strong> ${template.template_id || 'N/A'}</p>
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
            `;

                        $('body').append(previewHtml);
                        const modal = new bootstrap.Modal(document.getElementById(
                            'templateDetailPreview'));
                        modal.show();

                        $('#templateDetailPreview').on('hidden.bs.modal', function() {
                            $(this).remove();
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching template for preview:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to load template details for preview.'
                        });
                    }
                });
            }

            $('#templateDetailPreview').on('hidden.qbs.modal', function() {
                $(this).remove();
            });


            function generateTemplatePreviewContent(template) {
                let content = '';

                // Check if we have components array
                if (template.components && Array.isArray(template.components)) {
                    template.components.forEach(component => {
                        if (!component || !component.type) return;

                        switch (component.type) {
                            case 'HEADER':
                                content += generateHeaderComponent(component);
                                break;

                            case 'BODY':
                                content += generateBodyComponent(component);
                                break;

                            case 'FOOTER':
                                content += generateFooterComponent(component);
                                break;

                            case 'BUTTONS':
                                content += generateButtonsComponent(component);
                                break;
                        }
                    });
                }
                // Fallback to direct properties if no components array
                else {
                    if (template.header) {
                        content += `<div class="header"><strong>${template.header}</strong></div>`;
                    }

                    if (template.body) {
                        content += `<div class="content">${template.body.replace(/\n/g, '<br>')}</div>`;
                    }

                    if (template.footer) {
                        content += `<div class="footer"><small>${template.footer}</small></div>`;
                    }
                }

                return content || '<div class="text-muted">No content available</div>';
            }

            // Header component generator
            function generateHeaderComponent(headerComponent) {
                let headerHtml = '';

                if (headerComponent.format === 'VIDEO' || headerComponent.format === 'IMAGE' || headerComponent
                    .format === 'DOCUMENT') {
                    headerHtml = `
            <div class="header-media">
                <div class="media-placeholder">
                    <i class="fas fa-${getMediaIcon(headerComponent.format)} fa-3x"></i>
                    <p>${headerComponent.format.charAt(0) + headerComponent.format.slice(1).toLowerCase()} Header</p>
                </div>
            </div>
        `;
                } else if (headerComponent.text) {
                    headerHtml = `<div class="header"><strong>${headerComponent.text}</strong></div>`;
                } else if (headerComponent.example && headerComponent.example.header_text) {
                    headerHtml =
                        `<div class="header"><strong>${headerComponent.example.header_text}</strong></div>`;
                }

                return headerHtml;
            }

            // Body component generator
            function generateBodyComponent(bodyComponent) {
                if (bodyComponent.text) {
                    return `<div class="content">${bodyComponent.text.replace(/\n/g, '<br>')}</div>`;
                }
                return '';
            }

            // Footer component generator
            function generateFooterComponent(footerComponent) {
                if (footerComponent.text) {
                    return `<div class="footer"><small>${footerComponent.text}</small></div>`;
                }
                return '';
            }

            // Buttons component generator
            function generateButtonsComponent(buttonsComponent) {
                if (!buttonsComponent.buttons || !Array.isArray(buttonsComponent.buttons)) {
                    return '';
                }

                let buttonsHtml = '<div class="buttons mt-3">';

                buttonsComponent.buttons.forEach(button => {
                    if (button.text) {
                        let buttonIcon = '';
                        let buttonClass = '';

                        switch (button.type) {
                            case 'URL':
                                buttonIcon = '<i class="fas fa-link"></i> ';
                                buttonClass = 'url-button';
                                break;
                            case 'PHONE_NUMBER':
                                buttonIcon = '<i class="fas fa-phone"></i> ';
                                buttonClass = 'phone-button';
                                break;
                            case 'QUICK_REPLY':
                                buttonIcon = '<i class="fas fa-reply"></i> ';
                                buttonClass = 'quick-reply-button';
                                break;
                            case 'COPY_CODE':
                                buttonIcon = '<i class="fas fa-copy"></i> ';
                                buttonClass = 'copy-button';
                                break;
                            case 'CATALOG':
                                buttonIcon = '<i class="fas fa-shopping-bag"></i> ';
                                buttonClass = 'catalog-button';
                                break;
                            default:
                                buttonIcon = '<i class="fas fa-hand-pointer"></i> ';
                                buttonClass = 'default-button';
                        }

                        buttonsHtml += `
                <div class="button ${buttonClass}">
                    ${buttonIcon}${button.text}
                </div>
            `;
                    }
                });

                buttonsHtml += '</div>';
                return buttonsHtml;
            }

            // Helper function to get media icons
            function getMediaIcon(format) {
                switch (format) {
                    case 'VIDEO':
                        return 'video';
                    case 'IMAGE':
                        return 'image';
                    case 'DOCUMENT':
                        return 'file';
                    default:
                        return 'file';
                }
            }


            function updateNodeWithTemplate(nodeId, templateName, templateData) {
                const $node = $(`#${nodeId}`);

                if (!$node.length) {
                    console.error('Node not found:', nodeId);
                    return;
                }

                console.log('Updating Template Node with template:', nodeId, templateName);

                // Hide the "Add Template" button
                $node.find('.add-template-btn').hide();

                // Show the template preview container
                const $previewContainer = $node.find('.template-preview-container');
                console.log('Template Preview container found:', $previewContainer.length);

                $previewContainer.show();

                const $preview = $previewContainer.find('.template-preview');
                $preview.find('.template-name').text(templateName || 'Unnamed Template');

                let previewHtml = '';
                let hasButtons = false;

                try {
                    // Use components array if available, otherwise fallback to direct properties
                    if (templateData.components && Array.isArray(templateData.components)) {
                        templateData.components.forEach(component => {
                            if (!component || !component.type) return;

                            switch (component.type) {
                                case 'HEADER':
                                    previewHtml += generateHeaderComponent(component);
                                    break;
                                case 'BODY':
                                    previewHtml += generateBodyComponent(component);
                                    break;
                                case 'FOOTER':
                                    previewHtml += generateFooterComponent(component);
                                    break;
                                case 'BUTTONS':
                                    previewHtml += generateButtonsComponent(component);
                                    hasButtons = true;

                                    // Add buttons with ports to the Template Node
                                    if (component.buttons && Array.isArray(component.buttons)) {
                                        previewHtml += `<div class="template-buttons-container mt-3">`;
                                        previewHtml += `<h6 class="mb-2">Template Buttons:</h6>`;

                                        component.buttons.forEach((button, index) => {
                                            if (button.text) {
                                                previewHtml += generateTemplateButtonWithPort(
                                                    nodeId, button.text, index + 1, button.type);
                                            }
                                        });

                                        previewHtml += `</div>`;
                                    }
                                    break;
                            }
                        });
                    } else {
                        // Fallback to direct properties
                        if (templateData.header) {
                            previewHtml += `<div class="header"><strong>${templateData.header}</strong></div>`;
                        }
                        if (templateData.body) {
                            previewHtml += `<div class="content">${templateData.body.replace(/\n/g, '<br>')}</div>`;
                        }
                        if (templateData.footer) {
                            previewHtml += `<div class="footer"><small>${templateData.footer}</small></div>`;
                        }

                        // Add buttons if available in direct properties
                        if (templateData.buttons && Array.isArray(templateData.buttons)) {
                            hasButtons = true;
                            previewHtml += `<div class="template-buttons-container mt-3">`;
                            previewHtml += `<h6 class="mb-2">Template Buttons:</h6>`;

                            templateData.buttons.forEach((button, index) => {
                                if (button.text) {
                                    previewHtml += generateTemplateButtonWithPort(nodeId, button.text,
                                        index + 1, button.type);
                                }
                            });

                            previewHtml += `</div>`;
                        }
                    }

                    if (!previewHtml) {
                        previewHtml = `<div class="alert alert-warning">No template content available</div>`;
                    }

                } catch (e) {
                    console.error('Error parsing template:', e);
                    previewHtml = `<div class="alert alert-warning">Could not display template preview</div>`;
                }

                $preview.find('.template-content-preview').html(previewHtml);

                // Initialize button ports after the HTML is added
                if (hasButtons) {
                    setTimeout(() => {
                        initializeTemplateButtonPorts(nodeId);
                    }, 100);
                }

                // Store template data
                $node.find('.template-data').remove();
                $node.append(
                    `<input type="hidden" class="template-data" value='${JSON.stringify(templateData)}'>`
                );

                console.log('Template Node updated:', nodeId, templateData);
            }

            function initializeTemplateButtonPorts(nodeId) {
                const buttonsContainer = $(`#${nodeId} .template-buttons-container`);

                if (buttonsContainer.length) {
                    buttonsContainer.find('.template-button-port').each(function() {
                        $(this).mousedown(startConnection).css({
                            'cursor': 'crosshair',
                            'z-index': '100'
                        });
                    });
                }
            }

            function generateTemplateButtonWithPort(nodeId, buttonText, buttonNumber, buttonType = 'QUICK_REPLY') {
                const buttonId = `template-btn-${nodeId}-${buttonNumber}`;

                return `
        <div class="template-button mb-2 d-flex align-items-center justify-content-between position-relative" data-button="${buttonId}">
            <div class="d-flex align-items-center flex-grow-1">
                <span class="badge bg-secondary me-2">${buttonType}</span>
                <span class="button-text">${buttonText}</span>
            </div>
            <div class="d-flex align-items-center">
                <div class="node-port output-port template-button-port" data-node="${nodeId}" data-button="${buttonId}" title="Connect from this button"></div>
            </div>
        </div>
    `;
            }

            function addTemplateButton(nodeId, buttonText, buttonNumber, buttonType = 'QUICK_REPLY') {
                const buttonsContainer = $(`#template-buttons-${nodeId}`);

                const buttonId = `template-btn-${nodeId}-${buttonNumber}`;
                const buttonHtml = `
        <div class="template-button mb-2 d-flex align-items-center position-relative" data-button="${buttonId}">
            <div class="form-floating flex-grow-1 me-2">
                <input type="text" class="form-control template-button-text" placeholder="Button text" value="${buttonText}" readonly>
                <label>Template Button</label>
            </div>
            <div style="display: flex;flex-direction: column;align-items: center;gap: 5px;justify-content: inherit;">
                <span class="badge bg-secondary">${buttonType}</span>
                <div class="node-port output-port template-button-port" data-node="${nodeId}" data-button="${buttonId}"></div>
            </div>
        </div>
    `;

                const buttonElement = $(buttonHtml).appendTo(buttonsContainer);

                buttonElement.find('.template-button-port').mousedown(startConnection).css({
                    'cursor': 'crosshair',
                    'z-index': '100'
                });

                return buttonElement;
            }

            function removeTemplateFromNode(nodeId) {
                const $node = $(`#${nodeId}`);

                $node.find('.template-preview-container').hide();

                $node.find('.add-template-btn').show();

                $node.find('.template-data').remove();
                $node.find('.template-name').text('');
                $node.find('.template-content-preview').html('');

                connectionState.connections = connectionState.connections.filter(conn => {
                    if (conn.startNodeId === nodeId && conn.isTemplateButton) {
                        conn.element.remove();
                        return false;
                    }
                    return true;
                });

                console.log('Template removed from Template Node:', nodeId);
            }

            function showTemplateVariablesHelp() {
                const variableHelp = `
        <div class="alert alert-info">
            <h6>Available Variables:</h6>
            <div class="row">
                <div class="col-md-6">
                    <small><strong>{{ 1 }}</strong> - Lead ID</small><br>
                    <small><strong>{{ 2 }}</strong> - Customer Name</small><br>
                    <small><strong>{{ 3 }}</strong> - Phone Number</small><br>
                    <small><strong>{{ 4 }}</strong> - Email</small><br>
                    <small><strong>{{ 5 }}</strong> - Full Address</small><br>
                    <small><strong>{{ 6 }}</strong> - City</small><br>
                    <small><strong>{{ 7 }}</strong> - Country</small><br>
                </div>
                <div class="col-md-6">
                    <small><strong>{{ 8 }}</strong> - Order ID</small><br>
                    <small><strong>{{ 9 }}</strong> - Order Reference</small><br>
                    <small><strong>{{ 10 }}</strong> - Order Date</small><br>
                    <small><strong>{{ 11 }}</strong> - Delivery Date</small><br>
                    <small><strong>{{ 12 }}</strong> - Order Total</small><br>
                    <small><strong>{{ 13 }}</strong> - Delivery Status</small><br>
                    <small><strong>{{ 14 }}</strong> - Confirmation Status</small><br>
                </div>
            </div>
        </div>
    `;

                return variableHelp;
            }


            function createAiAgentNode(nodeId, x, y, data = null) {
                const nodeHtml = `
                <div class="flow-node message-node ai-agent-node" id="${nodeId}" style="left:${x}px; top:${y}px;">
                    <div class="node-header">
                        <div>AI Agent</div>
                        <div class="node-actions">
                            <i class="fas fa-trash delete-btn" title="Delete"></i>
                        </div>
                    </div>
                    <div class="node-body">
                        <div class="node-section">
                            <div class="section-title">
                                AI Agent Configuration
                            </div>
                            <div class="form-floating mb-5">
                                <select class="form-select ai-agent-select" id="ai-agent-${nodeId}">
                                    <option value="">Select an AI Agent...</option>
                                    <!-- Agents will be loaded dynamically -->
                                </select>
                                <label for="ai-agent-${nodeId}">AI Agent</label>
                            </div>
                            <div class="ai-agent-preview" id="ai-agent-preview-${nodeId}" style="display: none;">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="agent-avatar me-2">
                                        <i class="fas fa-robot fa-2x"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 agent-name"></h6>
                                        <small class="text-muted agent-language"></small>
                                    </div>
                                </div>
                                <div class="agent-description small text-muted"></div>
                            </div>
                            <button class="btn btn-outline-primary w-100 mt-2 change-agent-btn" style="display: none;">
                                <i class="fas fa-exchange-alt me-1"></i> Change Agent
                            </button>
                        </div>
                        
                    </div>
                    <div class="node-port input-port" data-node="${nodeId}"></div>
                </div>`;

                $('#chatflow-canvas').append(nodeHtml);
                setupNode(nodeId);

                loadAiAgents(nodeId);

                if (data?.agent_id) {
                    $(`#ai-agent-${nodeId}`).val(data.agent_id).trigger('change');
                    $(`#ai-agent-message-${nodeId}`).val(data.initial_message || '');
                }

                $(`#ai-agent-${nodeId}`).on('change', function() {
                    const agentId = $(this).val();
                    if (agentId) {
                        showAgentPreview(nodeId, agentId);
                        $(this).hide();
                        $(`#${nodeId} .change-agent-btn`).show();
                    }
                });

                $(`#${nodeId} .change-agent-btn`).on('click', function() {
                    $(`#ai-agent-${nodeId}`).show().val('');
                    $(this).hide();
                    $(`#ai-agent-preview-${nodeId}`).hide();
                });
            }

            function loadAiAgents(nodeId) {
                $.ajax({
                    url: '/aiagents/list',
                    method: 'GET',
                    success: function(response) {
                        const select = $(`#ai-agent-${nodeId}`);
                        select.empty();
                        select.append('<option value="">Select an AI Agent...</option>');

                        response.forEach(agent => {
                            select.append(
                                `<option value="${agent.id}">${agent.name} (${agent.language})</option>`
                            );
                        });
                    },
                    error: function(error) {
                        console.error('Error loading AI agents:', error);
                    }
                });
            }

            function showAgentPreview(nodeId, agentId) {
                $.ajax({
                    url: `/aiagent/${agentId}/show`,
                    method: 'GET',
                    success: function(response) {
                        const preview = $(`#ai-agent-preview-${nodeId}`);
                        preview.find('.agent-name').text(response.name);
                        preview.find('.agent-language').text(response.language);
                        preview.find('.agent-description').text(response.custom_prompt ||
                            'No custom prompt set');

                        const avatarIcon = response.sexe === 'female' ? 'fa-robot' : 'fa-robot';
                        preview.find('.agent-avatar i').removeClass().addClass(
                            `fas ${avatarIcon} fa-2x`);

                        preview.show();
                    },
                    error: function(error) {
                        console.error('Error loading AI agent details:', error);
                    }
                });
            }

            function createConditionNode(nodeId, x, y, data = null) {
                const nodeHtml = `
        <div class="flow-node action-node" id="${nodeId}" style="left:${x}px; top:${y}px;">
            <div class="node-header">
                <div>Condition</div>
                <div class="node-actions">
                    <i class="fas fa-trash delete-btn" title="Delete"></i>
                </div>
            </div>
            <div class="node-body">
                <div class="condition-simple">
                    <div class="row g-3 mb-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <select class="form-control condition-field" id="condition-field-${nodeId}">
                                    <option value="">Select a field</option>
                                    <option value="custom_field" ${data?.condition?.field === 'custom_field' ? 'selected' : ''}>Custom Field</option>
                                    <option value="user_input" ${data?.condition?.field === 'user_input' ? 'selected' : ''}>User Input</option>
                                    <option value="intent" ${data?.condition?.field === 'intent' ? 'selected' : ''}>Intent</option>
                                    <option value="context" ${data?.condition?.field === 'context' ? 'selected' : ''}>Context</option>
                                    <option value="date" ${data?.condition?.field === 'date' ? 'selected' : ''}>Date</option>
                                    <option value="time" ${data?.condition?.field === 'time' ? 'selected' : ''}>Time</option>
                                </select>
                                <label for="condition-field-${nodeId}">Field</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <select style="width: 100%;" class="form-control condition-operator" id="condition-operator-${nodeId}">
                                    <option value="equals" ${data?.condition?.operator === 'equals' ? 'selected' : ''}>Equals</option>
                                    <option value="exists" ${data?.condition?.operator === 'exists' ? 'selected' : ''}>Exists</option>
                                    <option value="time_in" ${data?.condition?.operator === 'time_in' ? 'selected' : ''}>Time is in</option>
                                    <option value="date_in" ${data?.condition?.operator === 'date_in' ? 'selected' : ''}>Date is in</option>
                                </select>
                                <label for="condition-operator-${nodeId}">Operator</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control condition-value" id="condition-value-${nodeId}" placeholder="Value" value="${data?.condition?.value || ''}">
                                <label for="condition-value-${nodeId}">Value</label>
                            </div>
                        </div>
                    </div>
                    <div class="p-2" class="row condition-output-ports">
                        <div class="col-md-12" style="position: relative;padding: 0;display: flex;align-items: center;gap: 3px;">
                            <button class="btn condition-true-btn" style="border: 1px solid #46ce46; color: #46ce46; margin: 4px auto; width: 90%;" data-result="true">
                                True
                            </button>
                            <div class="node-port output-port true-port" data-node="${nodeId}" style="right: -5px; border-color: #46ce46;"></div>
                        </div>
                        <div class="col-md-12" style="position: relative;padding: 0;display: flex;align-items: center;gap: 3px;">
                            <button class="btn condition-false-btn" style="border: 1px solid #ff6692; color: #ff6692; margin: 4px auto; width: 90%;" data-result="false">
                                False
                            </button>
                            <div class="node-port output-port false-port" data-node="${nodeId}" style="right: -5px; border-color: #ff6692"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="node-port input-port" data-node="${nodeId}"></div>
        </div>`;

                $('#chatflow-canvas').append(nodeHtml);
                setupNode(nodeId);

                $(`#condition-field-${nodeId}`).on('change', function() {
                    const operatorSelect = $(`#condition-operator-${nodeId}`);
                    const fieldType = $(this).val();

                    if (fieldType === 'date' || fieldType === 'time') {
                        operatorSelect.html(`
                <option value="equals">Equals</option>
                <option value="exists">Exists</option>
                ${fieldType === 'date' ? '<option value="date_in">Date is in</option>' : '<option value="time_in">Time is in</option>'}
            `);
                    } else {
                        operatorSelect.html(`
                <option value="equals">Equals</option>
                <option value="exists">Exists</option>
            `);
                    }
                });
            }

            function createAskAddressNode(nodeId, x, y, data = null) {
                const nodeHtml = `
        <div class="flow-node action-node" id="${nodeId}" style="left:${x}px; top:${y}px;">
            <div class="node-header">
                <div>Ask Address</div>
                <div class="node-actions">
                    <i class="fas fa-trash delete-btn" title="Delete"></i>
                    <div class="node-port output-port" data-node="${nodeId}"></div>
                </div>
            </div>
            <div class="node-body">
                <div class="node-section">
                    <div class="section-title">
                        Address Request
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control node-textarea" placeholder="Enter message to request address" id="address-request-${nodeId}" style="height: 80px">${data?.ask_address?.request_message || ''}</textarea>
                        <label for="address-request-${nodeId}">Request Message</label>
                    </div>
                </div>
                <div class="node-section">
                    <div class="section-title">
                        Address Fields
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="address-field-${nodeId}">
                            <option value="">Select contact field for address</option>
                            <option value="home_address" ${data?.ask_address?.address_field === 'home_address' ? 'selected' : ''}>Home Address</option>
                            <option value="work_address" ${data?.ask_address?.address_field === 'work_address' ? 'selected' : ''}>Work Address</option>
                            <option value="shipping_address" ${data?.ask_address?.address_field === 'shipping_address' ? 'selected' : ''}>Shipping Address</option>
                            <option value="billing_address" ${data?.ask_address?.address_field === 'billing_address' ? 'selected' : ''}>Billing Address</option>
                        </select>
                        <label for="address-field-${nodeId}">Address Field</label>
                    </div>
                </div>
            </div>
            <div class="node-port input-port" data-node="${nodeId}">
            </div>
        </div>`;

                $('#chatflow-canvas').append(nodeHtml);
                setupNode(nodeId);
            }


            function createAskLocationNode(nodeId, x, y, data = null) {
                const nodeHtml = `
        <div class="flow-node action-node" id="${nodeId}" style="left:${x}px; top:${y}px;">
            <div class="node-header">
                <div>Ask Location</div>
                <div class="node-actions">
                    <i class="fas fa-trash delete-btn" title="Delete"></i>
                    <div class="node-port output-port" data-node="${nodeId}"></div>
                </div>
            </div>
            <div class="node-body">
                <div class="node-section">
                    <div class="section-title">
                        Location Request
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control node-textarea" placeholder="Enter message to request location" id="location-request-${nodeId}" style="height: 80px">${data?.ask_location?.request_message || ''}</textarea>
                        <label for="location-request-${nodeId}">Request Message</label>
                    </div>
                </div>
                <div class="node-section">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="longitude-${nodeId}">
                            <option value="">Select contact field for longitude</option>
                            <option value="longitude" ${data?.ask_location?.longitude_field === 'longitude' ? 'selected' : ''}>Longitude</option>
                        </select>
                        <label for="longitude-${nodeId}">Location Longitude</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="latitude-${nodeId}">
                            <option value="">Select contact field for latitude</option>
                            <option value="latitude" ${data?.ask_location?.latitude_field === 'latitude' ? 'selected' : ''}>Latitude</option>
                        </select>
                        <label for="latitude-${nodeId}">Location Latitude</label>
                    </div>
                </div>
            </div>
            <div class="node-port input-port" data-node="${nodeId}">
            </div>
        </div>`;

                $('#chatflow-canvas').append(nodeHtml);
                setupNode(nodeId);
            }

            function createAskQuestionNode(nodeId, x, y, data = null) {
                const nodeHtml = `
        <div class="flow-node action-node" id="${nodeId}" style="left:${x}px; top:${y}px;">
            <div class="node-header">
                <div>Ask Question</div>
                <div class="node-actions">
                    <i class="fas fa-trash delete-btn" title="Delete"></i>
                    <div class="node-port output-port" data-node="${nodeId}"></div>
                </div>
            </div>
            <div class="node-body">
                <div class="node-section">
                    <div class="section-title">
                        Question
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control node-textarea" placeholder="Enter your question..." id="question-${nodeId}" style="height: 80px">${data?.ask_question?.question || ''}</textarea>
                        <label for="question-${nodeId}">Question</label>
                    </div>
                </div>
                <div class="node-section">
                    <div class="section-title">
                        Customer Field
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="customer-field-${nodeId}">
                            <option value="email" ${data?.ask_question?.field_name === 'email' ? 'selected' : ''}>Email</option>
                            <option value="phone" ${data?.ask_question?.field_name === 'phone' ? 'selected' : ''}>Phone Number</option>
                            <option value="number" ${data?.ask_question?.field_name === 'number' ? 'selected' : ''}>Customer Name</option>
                            <option value="text" ${data?.ask_question?.field_name === 'text' ? 'selected' : ''}>Customer Address</option>
                            <option value="date" ${data?.ask_question?.field_name === 'date' ? 'selected' : ''}>Customer City</option>
                        </select>
                        <label for="customer-field-${nodeId}">Field name to save to</label>
                    </div>
                </div>
                <div class="node-section">
                    <div class="section-title">
                        Data Validation
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="data-type-${nodeId}">
                            <option value="none" ${!data?.ask_question?.validation?.type || data.ask_question.validation.type === 'none' ? 'selected' : ''}>No validation</option>
                            <option value="email" ${data?.ask_question?.validation?.type === 'email' ? 'selected' : ''}>Email</option>
                            <option value="phone" ${data?.ask_question?.validation?.type === 'phone' ? 'selected' : ''}>Phone Number</option>
                            <option value="number" ${data?.ask_question?.validation?.type === 'number' ? 'selected' : ''}>Number</option>
                            <option value="text" ${data?.ask_question?.validation?.type === 'text' ? 'selected' : ''}>Text</option>
                            <option value="date" ${data?.ask_question?.validation?.type === 'date' ? 'selected' : ''}>Date</option>
                        </select>
                        <label for="data-type-${nodeId}">Data Type Validation</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="max-attempts-${nodeId}" placeholder="Maximum attempts" min="1" value="${data?.ask_question?.validation?.max_attempts || 3}">
                        <label for="max-attempts-${nodeId}">Maximum attempts</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Enter error message for invalid format" id="error-message-${nodeId}" style="height: 80px">${data?.ask_question?.validation?.error_message || 'Please enter a valid format. Attempts remaining: {attempts}'}</textarea>
                        <label for="error-message-${nodeId}">Error message</label>
                    </div>
                </div>
            </div>
            <div class="node-port input-port" data-node="${nodeId}">
            </div>
        </div>`;

                $('#chatflow-canvas').append(nodeHtml);
                setupNode(nodeId);
            }


            function createAskMediaNode(nodeId, x, y, data = null) {
                const nodeHtml = `
        <div class="flow-node action-node" id="${nodeId}" style="left:${x}px; top:${y}px;">
            <div class="node-header">
                <div>Ask Media</div>
                <div class="node-actions">
                    <i class="fas fa-trash delete-btn" title="Delete"></i>
                    <div class="node-port output-port" data-node="${nodeId}"></div>
                </div>
            </div>
            <div class="node-body">
                <div class="node-section">
                    <div class="section-title">
                        Media Request
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control node-textarea" placeholder="Enter message to request media" id="media-request-${nodeId}" style="height: 80px">${data?.ask_media?.request_message || ''}</textarea>
                        <label for="media-request-${nodeId}">Request Message</label>
                    </div>
                </div>
                <div class="node-section">
                    <div class="section-title">
                        Customer Field
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="customer-field-${nodeId}">
                            <option value="email" ${data?.ask_media?.field_name === 'email' ? 'selected' : ''}>Email</option>
                            <option value="phone" ${data?.ask_media?.field_name === 'phone' ? 'selected' : ''}>Phone Number</option>
                            <option value="number" ${data?.ask_media?.field_name === 'number' ? 'selected' : ''}>Customer Name</option>
                            <option value="text" ${data?.ask_media?.field_name === 'text' ? 'selected' : ''}>Customer Address</option>
                            <option value="date" ${data?.ask_media?.field_name === 'date' ? 'selected' : ''}>Customer City</option>
                        </select>
                        <label for="customer-field-${nodeId}">Field name to save to</label>
                    </div>
                </div>
                <div class="node-section">
                    <div class="section-title">
                        Media Type
                    </div>
                    <div class="form-floating mb-3">
                        <select class="form-select" id="request-media-type-${nodeId}">
                            <option value="any" ${!data?.ask_media?.media_type || data.ask_media.media_type === 'any' ? 'selected' : ''}>Any media type</option>
                            <option value="image" ${data?.ask_media?.media_type === 'image' ? 'selected' : ''}>Image only</option>
                            <option value="video" ${data?.ask_media?.media_type === 'video' ? 'selected' : ''}>Video only</option>
                            <option value="document" ${data?.ask_media?.media_type === 'document' ? 'selected' : ''}>Document only</option>
                        </select>
                        <label for="request-media-type-${nodeId}">Media Type</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="max-attempts-${nodeId}" placeholder="Maximum attempts" min="1" value="${data?.ask_media?.validation?.max_attempts || 3}">
                        <label for="max-attempts-${nodeId}">Maximum attempts</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Enter error message for invalid format" id="error-message-${nodeId}" style="height: 80px">${data?.ask_media?.validation?.error_message || 'Please enter a valid format. Attempts remaining: {attempts}'}</textarea>
                        <label for="error-message-${nodeId}">Error message</label>
                    </div>
                </div>
            </div>
            <div class="node-port input-port" data-node="${nodeId}">
            </div>
        </div>`;

                $('#chatflow-canvas').append(nodeHtml);
                setupNode(nodeId);
            }

            function createApiRequestNode(nodeId, x, y) {
                const nodeHtml = `
                    <div class="flow-node action-node" id="${nodeId}" style="left:${x}px; top:${y}px;">
                        <div class="node-header">
                            <div>API Request</div>
                            <div class="node-actions">
                                <i class="fas fa-trash delete-btn" title="Delete"></i>
                                <div class="node-port output-port" data-node="${nodeId}"></div>
                            </div>
                        </div>
                        <div class="node-body">
                            <div class="node-section">
                                <div class="section-title">
                                    API Configuration
                                </div>
                                <div class="row g-2 mb-3">
                                    <div class="col-md-3">
                                        <div class="form-floating">
                                            <select class="form-control api-method-select" id="api-method-${nodeId}">
                                                <option value="GET">GET</option>
                                                <option value="POST">POST</option>
                                                <option value="PUT">PUT</option>
                                                <option value="DELETE">DELETE</option>
                                            </select>
                                            <label for="api-method-${nodeId}">Method</label>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-floating">
                                            <input type="text" class="form-control api-url-input" id="api-url-${nodeId}" placeholder="API URL">
                                            <label for="api-url-${nodeId}">API URL</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="node-section">
                                <div class="section-title">
                                    Headers
                                </div>
                                <div class="api-headers" id="api-headers-${nodeId}">
                                    <div class="api-header mb-2">
                                        <div class="row g-2">
                                            <div class="col-md-5">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" placeholder="Header name" id="header-name-${nodeId}-1">
                                                    <label for="header-name-${nodeId}-1">Header name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" placeholder="Header value" id="header-value-${nodeId}-1">
                                                    <label for="header-value-${nodeId}-1">Header value</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex align-items-center">
                                                <button class="btn btn-sm btn-outline-danger header-delete"><i class="fas fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-primary add-header-btn w-100" data-target="api-headers-${nodeId}">
                                    <i class="fas fa-plus me-1"></i> Add Header
                                </button>
                            </div>
                            <div class="node-section">
                                <div class="section-title">
                                    Body
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control node-textarea" placeholder="Request body (for POST/PUT)" id="api-body-${nodeId}" style="height: 100px"></textarea>
                                    <label for="api-body-${nodeId}">Request Body</label>
                                </div>
                            </div>
                        </div>
                        <div class="node-port input-port" data-node="${nodeId}">
                            
                        </div>

                    </div>
                    `;

                $('#chatflow-canvas').append(nodeHtml);
                setupNode(nodeId);

                $(`[data-target="api-headers-${nodeId}"]`).on('click', function() {
                    const headerCount = $(`#api-headers-${nodeId} .api-header`).length + 1;
                    const newHeader = $(`
                        <div class="api-header mb-2">
                            <div class="row g-2">
                                <div class="col-md-5">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" placeholder="Header name" id="header-name-${nodeId}-${headerCount}">
                                        <label for="header-name-${nodeId}-${headerCount}">Header name</label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" placeholder="Header value" id="header-value-${nodeId}-${headerCount}">
                                        <label for="header-value-${nodeId}-${headerCount}">Header value</label>
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <button class="btn btn-sm btn-outline-danger header-delete"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                    `);
                    $(`#api-headers-${nodeId}`).append(newHeader);
                });

                $(`#api-headers-${nodeId}`).on('click', '.header-delete', function() {
                    if ($(`#api-headers-${nodeId} .api-header`).length > 1) {
                        $(this).closest('.api-header').remove();
                    } else {
                        alert('You need at least one header');
                    }
                });
            }

            function createConnectFlowNode(nodeId, x, y) {
                const nodeHtml = `
                    <div class="flow-node action-node" id="${nodeId}" style="left:${x}px; top:${y}px;">
                        <div class="node-header">
                            <div>Connect Flow</div>
                            <div class="node-actions">
                                <i class="fas fa-trash delete-btn" title="Delete"></i>
                                <div class="node-port output-port" data-node="${nodeId}"></div>
                            </div>
                        </div>
                        <div class="node-body">
                            <div class="node-section">
                                <div class="section-title">
                                    Flow to Connect
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="connect-flow-${nodeId}">
                                        <option value="">Select a flow...</option>
                                        <option value="welcome">Welcome Flow</option>
                                        <option value="support">Support Flow</option>
                                    </select>
                                    <label for="connect-flow-${nodeId}">Flow to Connect</label>
                                </div>
                            </div>
                            <div class="node-section">
                                <div class="section-title">
                                    Transfer Options
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="transfer-data-${nodeId}">
                                    <label class="form-check-label" for="transfer-data-${nodeId}">Transfer conversation data</label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="close-current-${nodeId}">
                                    <label class="form-check-label" for="close-current-${nodeId}">Close current flow after transfer</label>
                                </div>
                            </div>
                        </div>
                        <div class="node-port input-port" data-node="${nodeId}">
                            
                        </div>

                    </div>
                    `;

                $('#chatflow-canvas').append(nodeHtml);
                setupNode(nodeId);
            }

            function setupNode(nodeId) {
                $('#' + nodeId).draggable({
                    containment: 'parent',
                    cursor: 'move',
                    drag: function(event, ui) {
                        updateMinimap();
                        updateAllConnections();
                        updateMinimapNodePosition(nodeId);
                    },
                    stop: function() {
                        updateAllConnections();
                        updateMinimapNodePosition(nodeId);
                    }
                });

                const node = $(`#${nodeId}`);
                let nodeType = 'node';
                if (node.hasClass('start-node')) nodeType = 'start';
                else if (node.hasClass('message-node')) nodeType = 'message';
                else if (node.hasClass('action-node')) nodeType = 'action';

                createMinimapNode(
                    nodeId,
                    nodeType,
                    parseInt(node.css('left')),
                    parseInt(node.css('top')),
                    node.outerWidth(),
                    node.outerHeight()
                );

                $('#' + nodeId + ' .delete-btn').click(function() {
                    removeMinimapNode(nodeId); //
                    $(this).closest('.flow-node').remove();
                    removeNodeConnections(nodeId);
                });

                $('#' + nodeId + ' .node-port').mousedown(startConnection);
            }

            function removeNodeConnections(nodeId) {
                connectionState.connections = connectionState.connections.filter(conn => {
                    if (conn.startNodeId === nodeId || conn.endNodeId === nodeId) {
                        conn.element.remove();
                        return false;
                    }
                    return true;
                });
            }


            function addKeyword(nodeId, keywordText = null) {
                const $input = $(`#tb-keywords-${nodeId}`);
                const keyword = keywordText || $input.val().trim();

                if (keyword) {
                    const keywordHtml = `
            <div class="keyword-item">
                ${keyword}
                <span class="delete-keyword"><i class="fas fa-times"></i></span>
            </div>
        `;

                    $(`#${nodeId} .keywords-list`).append(keywordHtml);

                    if (!keywordText) {
                        $input.val('');
                    }

                    $(`#${nodeId} .keywords-list .delete-keyword:last`).click(function() {
                        $(this).closest('.keyword-item').remove();
                        updateTriggerSummary(nodeId, $(`#trigger-type-${nodeId}`).val());
                    });
                }
            }

            function updateTriggerSummary(nodeId, triggerType) {
                const $node = $(`#${nodeId}`);
                const $role = $(`#trigger-role-${nodeId}`);
                const $when = $(`#trigger-when-${nodeId}`);

                let roleText = '';
                let whenText = '';

                switch (triggerType) {
                    case 'client_send':
                        roleText = 'Message Receiver';
                        const keywords = $node.find('.keyword-item').map(function() {
                            return $(this).clone().children().remove().end().text().trim();
                        }).get();
                        const regex = $node.find(`#tb-regex-${nodeId}`).val();

                        if (keywords.length > 0) {
                            whenText = `Client sends message containing: ${keywords.join(', ')}`;
                        } else if (regex) {
                            whenText = `Client sends message matching regex: ${regex}`;
                        } else {
                            whenText = 'Client sends any message';
                        }
                        break;

                    case 'lead_created':
                        roleText = 'Lead Management';
                        whenText = 'A new lead is created in the system';
                        break;

                    case 'confirmation_status':
                        roleText = 'Confirmation Monitor';
                        const confStatus = $node.find(`#status-select-${nodeId}`).val();
                        whenText = `Confirmation status changes to: ${confStatus || 'Any status'}`;
                        break;

                    case 'suivi_status':
                        roleText = 'Follow-up Monitor';
                        const suiviStatus = $node.find(`#status-select-${nodeId}`).val();
                        whenText = `Suivi status changes to: ${suiviStatus || 'Any status'}`;
                        break;

                    default:
                        roleText = 'Not configured';
                        whenText = 'Please select a trigger type';
                }

                $role.text(roleText);
                $when.text(whenText);
            }


            function startConnection(e) {
                e.stopPropagation();
                connectionState.isConnecting = true;
                connectionState.startPort = $(this);

                connectionState.tempConnection = $(`
                    <div class="temp-connection" style="
                        position: fixed;
                        left: 0;
                        top: 0;
                        width: 100vw;
                        height: 100vh;
                        pointer-events: none;
                        z-index: 9999;
                    "></div>
                `);

                $('body').append(connectionState.tempConnection);
                updateTempConnection(e);

                $(document).on('mousemove', updateTempConnection);
                $(document).on('mouseup', finishConnection);
            }

            function updateTempConnection(e) {
                if (!connectionState.isConnecting) return;

                const startPort = connectionState.startPort;
                const canvas = $('#chatflow-canvas');

                const portRect = startPort[0].getBoundingClientRect();
                const startX = portRect.left + portRect.width / 2;
                const startY = portRect.top + portRect.height / 2;

                const endX = e.clientX;
                const endY = e.clientY;

                const dx = endX - startX;
                const dy = endY - startY;
                const distance = Math.sqrt(dx * dx + dy * dy);
                const curveFactor = 0.3;

                const cp1x = startX + distance * curveFactor;
                const cp1y = startY;
                const cp2x = endX - distance * curveFactor;
                const cp2y = endY;

                const pathData = `M${startX},${startY} C${cp1x},${cp1y} ${cp2x},${cp2y} ${endX},${endY}`;

                let svg = connectionState.tempConnection.find('svg');
                if (svg.length === 0) {
                    connectionState.tempConnection.html(`
                        <svg width="100%" height="100%" style="position:fixed;top:0;left:0;pointer-events:none">
                            <path d="${pathData}" stroke="#666" stroke-width="2" fill="none" 
                                stroke-dasharray="5,3"/>
                        </svg>
                    `);
                } else {
                    svg.find('path').attr('d', pathData);
                }

                connectionState.tempConnection.css({
                    'position': 'fixed',
                    'left': 0,
                    'top': 0,
                    'width': '100vw',
                    'height': '100vh',
                    'pointer-events': 'none',
                    'z-index': 9999
                });
            }

            // function moveTempConnection(e) {
            //     if (!canvasState.connecting) return;

            //     const portPos = canvasState.currentPort.offset();
            //     const startX = portPos.left + canvasState.currentPort.width() / 2;
            //     const startY = portPos.top + canvasState.currentPort.height() / 2;

            //     const lineLength = Math.sqrt(Math.pow(e.pageX - startX, 2) + Math.pow(e.pageY - startY, 2));
            //     const angle = Math.atan2(e.pageY - startY, e.pageX - startX) * 180 / Math.PI;

            //     $('#temp-connection').css({
            //         width: lineLength + 'px',
            //         top: startY + 'px',
            //         left: startX + 'px',
            //         transform: `rotate(${angle}deg)`
            //     });
            // }

            function finishConnection(e) {
                $(document).off('mousemove', updateTempConnection);
                $(document).off('mouseup', finishConnection);

                if (!connectionState.isConnecting) return;
                connectionState.isConnecting = false;

                const endPort = $(e.target).closest('.node-port');
                const startPort = connectionState.startPort;

                connectionState.tempConnection.remove();
                connectionState.tempConnection = null;

                if (endPort.length &&
                    endPort.data('node') !== startPort.data('node') &&
                    (startPort.hasClass('output-port') && endPort.hasClass('input-port'))) {
                    createConnection(startPort, endPort);
                } else if (!endPort.length) {
                    showConnectionMenu(e.pageX, e.pageY, startPort);
                }

                connectionState.startPort = null;
            }

            function showConnectionMenu(x, y, startPort) {
                const menu = $('#connectionMenu');

                const canvas = $('#chatflow-canvas');
                const canvasOffset = canvas.offset();
                const adjustedX = x - canvasOffset.left;
                const adjustedY = y - canvasOffset.top;

                console.log('Before show:', menu.css('display'));
                menu.css({
                    left: adjustedX + 'px',
                    top: adjustedY + 'px',
                });
                menu.show();

                menu.find('.connection-menu-item').off('click').on('click', function() {
                    const type = $(this).data('type');
                    createNodeFromConnectionMenu(type, x, y, startPort);
                    menu.hide();
                });

                // $(document).on('click.connectionMenu', function(e) {
                //     if (!$(e.target).closest('#connectionMenu').length) {
                //         menu.hide();
                //         $(document).off('click.connectionMenu');
                //     }
                // });
            }

            function createNodeFromConnectionMenu(type, x, y, startPort) {
                const canvasOffset = $('#chatflow-canvas').offset();
                const adjustedX = (x - canvasOffset.left - canvasState.offsetX) / canvasState.scale;
                const adjustedY = (y - canvasOffset.top - canvasState.offsetY) / canvasState.scale;

                const offsetX = 50;
                const offsetY = 50;

                const nodeId = 'node_' + canvasState.nextNodeId++;

                switch (type) {
                    case 'text':
                        createTextNode(nodeId, adjustedX + offsetX, adjustedY + offsetY);
                        break;
                    case 'media':
                        createMediaNode(nodeId, adjustedX + offsetX, adjustedY + offsetY);
                        break;
                    case 'list':
                        createListNode(nodeId, adjustedX + offsetX, adjustedY + offsetY);
                        break;
                    case 'template':
                        createTemplateNode(nodeId, adjustedX + offsetX, adjustedY + offsetY);
                        break;
                }

                setTimeout(() => {
                    const newNode = $(`#${nodeId}`);
                    if (newNode.length) {
                        const inputPort = newNode.find('.input-port');
                        if (inputPort.length) {
                            createConnection(startPort, inputPort);
                        }
                    }
                }, 100);
            }

            function createConnection(startPort, endPort) {
                const connectionId = 'conn_' + Date.now();
                const startNodeId = startPort.data('node');
                const endNodeId = endPort.data('node');

                // Check if it's a template button connection (from Template Node or Flow Start Node)
                const isTemplateButton = startPort.hasClass('template-button-port') || startPort.hasClass(
                    'flowstart-button-port');
                const buttonNumber = isTemplateButton ? startPort.data('button') : startPort.data('button');

                const existingConnection = connectionState.connections.find(conn =>
                    conn.startNodeId === startNodeId &&
                    conn.endNodeId === endNodeId &&
                    conn.buttonNumber === buttonNumber
                );

                if (existingConnection) return;

                const connectionLine = $(`
        <div class="connection-line" id="${connectionId}">
            <svg width="100%" height="100%">
                <path stroke="#666" stroke-width="2" fill="none" 
                    stroke-dasharray="5,3" marker-end="url(#arrowhead)"/>
            </svg>
            <div class="delete-connection"><i class="fas fa-times"></i></div>
            ${buttonNumber ? `<div class="connection-label">${getButtonLabel(buttonNumber)}</div>` : ''}
        </div>
    `);

                $('#chatflow-connection-container').append(connectionLine);

                const connection = {
                    id: connectionId,
                    startNodeId: startNodeId,
                    endNodeId: endNodeId,
                    startPort: startPort,
                    endPort: endPort,
                    element: connectionLine,
                    buttonNumber: buttonNumber,
                    isTemplateButton: isTemplateButton
                };

                connectionState.connections.push(connection);
                updateConnection(connection);

                connectionLine.find('.delete-connection').on('click', function(e) {
                    e.stopPropagation();
                    removeConnection(connectionId);
                });
            }

            function getButtonLabel(buttonIdentifier) {
                if (typeof buttonIdentifier === 'number') {
                    return `B${buttonIdentifier}`;
                } else if (typeof buttonIdentifier === 'string') {
                    if (buttonIdentifier.includes('template-btn')) {
                        // Extract button number from template button ID
                        const match = buttonIdentifier.match(/template-btn-[^-]+-(\d+)/);
                        return match ? `T${match[1]}` : 'TB';
                    } else if (buttonIdentifier.includes('flowstart-btn')) {
                        // Extract button number from flow start button ID
                        const match = buttonIdentifier.match(/flowstart-btn-[^-]+-(\d+)/);
                        return match ? `FS${match[1]}` : 'FS';
                    }
                }
                return 'Btn';
            }

            function updateConnection(connection) {
                const startPort = connection.startPort;
                const endPort = connection.endPort;

                const startNode = startPort.closest('.flow-node, .flow-start');
                const endNode = endPort.closest('.flow-node, .flow-start');

                const startPortPos = getPortPosition(startPort, startNode);
                const endPortPos = getPortPosition(endPort, endNode);

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

                let svg = connection.element.find('svg');
                if (svg.length === 0) {
                    connection.element.html(`
            <svg width="100%" height="100%" style="position:absolute;top:0;left:0;overflow:visible">
                <defs>
                    <marker id="arrowhead" markerWidth="10" markerHeight="7" refX="9" refY="3.5" orient="auto">
                        <polygon points="0 0, 10 3.5, 0 7" fill="#666"/>
                    </marker>
                </defs>
                <path d="${pathData}" stroke="#666" stroke-width="2" fill="none" 
                    stroke-dasharray="5,3" marker-end="url(#arrowhead)"/>
            </svg>
            <div class="delete-connection"><i class="fas fa-times"></i></div>
            ${connection.buttonNumber ? `<div class="connection-label"></div>` : ''}
        `);
                } else {
                    svg.find('path').attr('d', pathData);
                }

                const midX = (startPortPos.left + endPortPos.left) / 2;
                const midY = (startPortPos.top + endPortPos.top) / 2;
                connection.element.find('.delete-connection').css({
                    left: `${midX}px`,
                    top: `${midY}px`
                });

                if (connection.buttonNumber) {
                    connection.element.find('.connection-label').css({
                        left: `${midX}px`,
                        top: `${midY - 15}px`
                    });
                }
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

            $('#chatflow-canvas').prepend(`
                <svg style="display:none">
                    <defs>
                        <marker id="arrowhead" markerWidth="10" markerHeight="7" 
                                refX="9" refY="3.5" orient="auto">
                            <polygon points="0 0, 10 3.5, 0 7" fill="#666"/>
                        </marker>
                    </defs>
                </svg>
            `);

            function updateAllConnections() {
                connectionState.connections.forEach(conn => {
                    updateConnection(conn);
                });
            }

            function removeConnection(connectionId) {
                const index = connectionState.connections.findIndex(conn => conn.id === connectionId);
                if (index >= 0) {
                    connectionState.connections[index].element.remove();
                    connectionState.connections.splice(index, 1);
                }
            }

            function calculateCurvedPath(x1, y1, x2, y2) {
                const dx = x2 - x1;
                const dy = y2 - y1;
                const mx = x1 + dx * 0.5;
                const my = y1 + dy * 0.5;

                const curveFactor = 0.25;
                const cpx1 = mx - dy * curveFactor;
                const cpy1 = my + dx * curveFactor;
                const cpx2 = mx + dy * curveFactor;
                const cpy2 = my - dx * curveFactor;

                return `M${x1},${y1} C${cpx1},${cpy1} ${cpx2},${cpy2} ${x2},${y2}`;
            }

            function updateConnections() {
                const canvasOffset = $('#chatflow-canvas').offset();

                canvasState.connections.forEach(conn => {
                    const sourcePort = conn.sourcePort;
                    const targetPort = conn.targetPort;

                    const sourcePos = sourcePort.offset();
                    const targetPos = targetPort.offset();

                    const sourceX = (sourcePos.left - canvasOffset.left - canvasState.offsetX) /
                        canvasState
                        .scale;
                    const sourceY = (sourcePos.top - canvasOffset.top - canvasState.offsetY) /
                        canvasState
                        .scale;
                    const targetX = (targetPos.left - canvasOffset.left - canvasState.offsetX) /
                        canvasState
                        .scale;
                    const targetY = (targetPos.top - canvasOffset.top - canvasState.offsetY) /
                        canvasState
                        .scale;

                    const pathData = calculateCurvedPath(sourceX, sourceY, targetX, targetY);

                    $(`#${conn.id}`).attr('d', pathData);

                    const foreignObj = $(`[data-conn="${conn.id}"]`).closest('foreignObject');
                    foreignObj.attr('x', (sourceX + targetX) / 2 - 10);
                    foreignObj.attr('y', (sourceY + targetY) / 2 - 10);
                });
            }

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

            $('#chatflow-canvas').mousedown(function(e) {
                if (e.target === this) {
                    canvasState.isDragging = true;
                    canvasState.dragStartX = e.pageX - canvasState.offsetX;
                    canvasState.dragStartY = e.pageY - canvasState.offsetY;
                    $(this).css('cursor', 'grabbing');
                }
            });

            $(document).mousemove(function(e) {
                if (canvasState.isDragging) {
                    canvasState.offsetX = e.pageX - canvasState.dragStartX;
                    canvasState.offsetY = e.pageY - canvasState.dragStartY;
                    updateCanvasTransform();
                }
            });

            $(document).mouseup(function() {
                if (canvasState.isDragging) {
                    canvasState.isDragging = false;
                    $('#chatflow-canvas').css('cursor', 'grab');
                    updateMinimap();
                }
            });

            function updateCanvasTransform() {
                const container = $('.canvas-container');
                const containerWidth = container.width();
                const containerHeight = container.height();

                const maxOffsetX = 0;
                const minOffsetX = containerWidth - 5000 * canvasState.scale;
                const maxOffsetY = 0;
                const minOffsetY = containerHeight - 5000 * canvasState.scale;

                canvasState.offsetX = Math.min(maxOffsetX, Math.max(minOffsetX, canvasState.offsetX));
                canvasState.offsetY = Math.min(maxOffsetY, Math.max(minOffsetY, canvasState.offsetY));

                $('#chatflow-canvas').css('transform',
                    `translate(${canvasState.offsetX}px, ${canvasState.offsetY}px) scale(${canvasState.scale})`
                );
                updateAllConnections();
                updateMinimap();
            }

            function createMinimapNode(nodeId, nodeType, x, y, width, height) {
                const minimap = $('#minimap');
                const canvas = $('#chatflow-canvas');
                const minimapSize = minimap.width();
                const canvasWidth = canvas.width();
                const canvasHeight = canvas.height();

                const minimapX = (x / canvasWidth) * minimapSize;
                const minimapY = (y / canvasHeight) * minimapSize;
                const minimapWidth = (width / canvasWidth) * minimapSize;
                const minimapHeight = (height / canvasHeight) * minimapSize;

                let nodeClass = 'minimap-node';
                if (nodeType === 'start') nodeClass += ' minimap-start-node';
                else if (nodeType === 'message') nodeClass += ' minimap-message-node';
                else if (nodeType === 'action') nodeClass += ' minimap-action-node';

                const minimapNode = $(`<div class="${nodeClass}" data-node="${nodeId}"></div>`);
                minimapNode.css({
                    left: minimapX + 'px',
                    top: minimapY + 'px',
                    width: Math.max(4, minimapWidth) + 'px',
                    height: Math.max(4, minimapHeight) + 'px'
                });

                minimap.append(minimapNode);
                return minimapNode;
            }

            function updateMinimapNodePosition(nodeId) {
                const node = $(`#${nodeId}`);
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

            function removeMinimapNode(nodeId) {
                $(`.minimap-node[data-node="${nodeId}"]`).remove();
            }

            function updateMinimap() {
                const canvas = $('#chatflow-canvas');
                const minimap = $('#minimap');
                const viewport = $('.minimap-viewport');

                const minimapSize = 180;

                minimap.css({
                    width: minimapSize + 'px',
                    height: minimapSize + 'px'
                });

                const canvasWidth = 5000;
                const canvasHeight = 5000;

                const containerWidth = $('.canvas-container').width();
                const containerHeight = $('.canvas-container').height();

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

                $('.flow-node, .flow-start').each(function() {
                    updateMinimapNodePosition($(this).attr('id'));
                });
            }

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
            $('#chatflow-canvas').css('cursor', 'grab');

            $('.edit-icon').click(function() {
                const titleContainer = $(this).closest('.flow-title-container');
                const currentTitle = titleContainer.find('.flow-title').text();

                titleContainer.find('.flow-title').replaceWith(`
                        <input type="text" class="flow-title-input" value="${currentTitle}">
                    `);

                const inputField = titleContainer.find('.flow-title-input');
                inputField.focus();

                inputField.on('keyup', function(e) {
                    if (e.key === 'Enter') {
                        saveTitle();
                    }
                });

                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.flow-title-container').length) {
                        saveTitle();
                    }
                });

                function saveTitle() {
                    const newTitle = inputField.val().trim() || 'Untitled Flow';
                    inputField.replaceWith(`<h4 class="flow-title">${newTitle}</h4>`);
                    $(document).off('click');
                }
            });

            $('.save-btn').click(async function() {
                const saveBtn = $(this);
                saveBtn.prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin"></i> Saving...');

                try {
                    const flowName = $('.flow-title').text().trim() || 'Untitled Flow';
                    const startNode = $('.flow-start')[0];

                    if (!startNode) {
                        throw new Error('No start node found!');
                    }

                    const flowData = {
                        name: flowName,
                        business_account_id: {{ $businessAccount }},
                        nodes: [],
                        connections: connectionState.connections.map(conn => ({
                            from: conn.startNodeId,
                            to: conn.endNodeId,
                            from_port: conn.startPort.hasClass('output-port') ?
                                'output' : 'input',
                            to_port: conn.endPort.hasClass('output-port') ? 'output' :
                                'input',
                            button_number: conn.buttonNumber || null,
                            button_text: getButtonText(conn.startNodeId, conn
                                .buttonNumber),
                            is_template_button: conn.isTemplateButton || false
                        }))
                    };

                    @if (isset($flow))
                        flowData.id = {{ $flow->id }};
                    @endif



                    const url =
                        @if (isset($flow))
                            '/business-accounts/{{ $businessAccount }}/flows/' + {{ $flow->id }};
                        @else
                            '/business-accounts/{{ $businessAccount }}/flows';
                        @endif


                    $('.flow-node, .flow-start').each(function() {
                        const nodeId = $(this).attr('id');
                        const nodeType = getNodeType($(this));

                        const node = {
                            id: nodeId,
                            type: nodeType,
                            position: {
                                x: parseInt($(this).css('left')),
                                y: parseInt($(this).css('top'))
                            },
                            title: $(this).find('.node-header div').first().text()
                                .trim(),
                            data: {}
                        };

                        switch (nodeType) {
                            case 'start':
                                processStartNode($(this), node);
                                break;

                            case 'text':
                                processTextNode($(this), node);
                                break;

                            case 'media':
                                processMediaNode($(this), node);
                                break;

                            case 'list':
                                processListNode($(this), node);
                                break;

                            case 'template':
                                processTemplateNode($(this), node);
                                break;

                            case 'condition':
                                processConditionNode($(this), node);
                                break;

                            case 'ask-address':
                                processAskAddressNode($(this), node);
                                break;

                            case 'ask-location':
                                processAskLocationNode($(this), node);
                                break;

                            case 'ask-question':
                                processAskQuestionNode($(this), node);
                                break;

                            case 'ask-media':
                                processAskMediaNode($(this), node);
                                break;

                            case 'api-request':
                                processApiRequestNode($(this), node);
                                break;

                            case 'connect-flow':
                                processConnectFlowNode($(this), node);
                                break;
                        }

                        flowData.nodes.push(node);
                    });

                    function getNodeType($node) {
                        if ($node.hasClass('start-node')) return 'start';
                        if ($node.hasClass('text-node')) return 'text';
                        if ($node.hasClass('media-node')) return 'media';
                        if ($node.hasClass('list-node')) return 'list';
                        if ($node.hasClass('template-node')) return 'template';
                        if ($node.hasClass('ai-agent-node')) return 'ai-agent';
                        if ($node.hasClass('condition-node')) return 'condition';
                        if ($node.hasClass('ask-address-node')) return 'ask-address';
                        if ($node.hasClass('ask-location-node')) return 'ask-location';
                        if ($node.hasClass('ask-question-node')) return 'ask-question';
                        if ($node.hasClass('ask-media-node')) return 'ask-media';
                        if ($node.hasClass('api-request-node')) return 'api-request';
                        if ($node.hasClass('connect-flow-node')) return 'connect-flow';
                        return 'unknown';
                    }

                    function getButtonText(nodeId, buttonNumber) {
                        if (!buttonNumber) return null;
                        const $node = $(`#${nodeId}`);
                        return $node.find(
                                `.message-button[data-button="${buttonNumber}"] .button-text`)
                            .val() ||
                            $node.find(`.message-button:nth-child(${buttonNumber}) .button-text`)
                            .val() ||
                            `Button ${buttonNumber}`;
                    }

                    function processStartNode($node, nodeData) {
                        const triggerType = $node.find('.trigger-type-select').val();
                        nodeData.data.trigger_type = triggerType;

                        // Store trigger-specific data
                        switch (triggerType) {
                            case 'confirmation_status':
                            case 'suivi_status':
                                nodeData.data.selected_status = $node.find('.status-select').val();
                                break;

                            case 'client_send':
                                nodeData.data.keywords = [];
                                $node.find('.keyword-item').each(function() {
                                    nodeData.data.keywords.push(
                                        $(this).clone().children().remove().end().text()
                                        .trim()
                                    );
                                });

                                nodeData.data.regex = {
                                    pattern: $node.find(`#tb-regex-${nodeData.id}`).val(),
                                    case_sensitive: $node.find(`#caseSensitive-${nodeData.id}`).is(
                                        ':checked')
                                };
                                break;
                        }

                        // Template data - store template info including buttons
                        if ($node.find('.template-preview-container').is(':visible')) {
                            nodeData.data.template = {
                                name: $node.find('.template-name').text(),
                                content: $node.find('.template-content-preview').html(),
                                buttons: []
                            };

                            // Save template button information from Flow Start Node
                            $node.find('.flowstart-template-button').each(function(index) {
                                const buttonNumber = index + 1;
                                const buttonText = $(this).find('.button-text').text();
                                nodeData.data.template.buttons.push({
                                    text: buttonText,
                                    number: buttonNumber,
                                    button_id: $(this).data('button')
                                });
                            });

                            const templateData = $node.find('.template-data').val();
                            if (templateData) {
                                try {
                                    nodeData.data.template.components = JSON.parse(templateData);
                                } catch (e) {
                                    console.error('Error parsing template data:', e);
                                }
                            }
                        }

                        // Trigger summary for display
                        nodeData.data.trigger_summary = {
                            role: $node.find('#trigger-role-' + nodeData.id).text(),
                            when: $node.find('#trigger-when-' + nodeData.id).text()
                        };
                    }


                    function processTextNode($node, nodeData) {
                        nodeData.data.text = $node.find('.node-textarea').val();

                        nodeData.data.buttons = [];
                        $node.find('.message-button').each(function(index) {
                            const buttonNumber = index + 1;
                            nodeData.data.buttons.push({
                                text: $(this).find('.button-text').val(),
                                number: buttonNumber
                            });
                        });

                        if ($node.find('.content-section').is(':visible')) {
                            const $content = $node.find(`#content-${nodeData.id}`);
                            if ($content.find('textarea.node-textarea').length) {
                                nodeData.data.additional_content = {
                                    type: 'text',
                                    text: $content.find('textarea.node-textarea').val(),
                                    buttons: []
                                };

                                $content.find('.message-button').each(function(index) {
                                    const buttonNumber = index + 1;
                                    nodeData.data.additional_content.buttons.push({
                                        text: $(this).find('.button-text').val(),
                                        number: buttonNumber
                                    });
                                });
                            }
                        }
                    }

                    function processMediaNode($node, nodeData) {
                        nodeData.data.media = {
                            type: $node.find('.media-type-select').val(),
                            url: $node.find('.media-url').val(),
                            caption: $node.find('#media-caption-' + nodeData.id).val()
                        };

                        nodeData.data.buttons = [];
                        $node.find('.message-button').each(function(index) {
                            const buttonNumber = index + 1;
                            nodeData.data.buttons.push({
                                text: $(this).find('.button-text').val(),
                                number: buttonNumber
                            });
                        });

                        if ($node.find('.content-section').is(':visible')) {
                            const $content = $node.find(`#content-${nodeData.id}`);
                            if ($content.find('.media-upload-container').length) {
                                nodeData.data.additional_content = {
                                    type: 'media',
                                    media_type: $content.find('.media-type-select').val(),
                                    url: $content.find('.media-url').val(),
                                    caption: $content.find('textarea').val()
                                };
                            }
                        }
                    }

                    function processListNode($node, nodeData) {
                        nodeData.data.list = {
                            header: $node.find('#list-header-' + nodeData.id).val(),
                            body: $node.find('#list-body-' + nodeData.id).val(),
                            footer: $node.find('#list-footer-' + nodeData.id).val(),
                            sections: []
                        };

                        $node.find('.list-section').each(function(sectionIndex) {
                            const section = {
                                title: $(this).find('.section-title').val(),
                                items: []
                            };

                            $(this).find('.list-item').each(function(itemIndex) {
                                const buttonNumber = itemIndex + 1;
                                section.items.push({
                                    title: $(this).find('.item-title')
                                        .val(),
                                    description: $(this).find(
                                        '.item-description').val(),
                                    button_number: buttonNumber
                                });
                            });

                            nodeData.data.list.sections.push(section);
                        });

                        if ($node.find('.content-section').is(':visible')) {
                            const $content = $node.find(`#content-${nodeData.id}`);
                            if ($content.find('.list-section').length) {
                                nodeData.data.additional_content = {
                                    type: 'list',
                                    sections: []
                                };

                                $content.find('.list-section').each(function() {
                                    const section = {
                                        title: $(this).find('.section-title').val(),
                                        items: []
                                    };

                                    $(this).find('.list-item').each(function() {
                                        section.items.push({
                                            title: $(this).find(
                                                    '.item-title')
                                                .val(),
                                            description: $(this).find(
                                                    '.item-description')
                                                .val()
                                        });
                                    });

                                    nodeData.data.additional_content.sections.push(section);
                                });
                            }
                        }
                    }

                    function processTemplateNode($node, nodeData) {
                        if ($node.find('.template-preview:visible').length) {
                            nodeData.data.template = {
                                name: $node.find('.template-name').text(),
                                content: $node.find('.template-content-preview').html(),
                                buttons: []
                            };

                            // Save template button information
                            $node.find('.template-button').each(function(index) {
                                const buttonNumber = index + 1;
                                nodeData.data.template.buttons.push({
                                    text: $(this).find('.template-button-text').val(),
                                    number: buttonNumber,
                                    button_id: $(this).data('button')
                                });
                            });

                            const templateData = $node.find('.template-data').val();
                            if (templateData) {
                                try {
                                    nodeData.data.template.components = JSON.parse(templateData);
                                } catch (e) {
                                    console.error('Error parsing template data:', e);
                                }
                            }
                        }

                        if ($node.find('.content-section').is(':visible')) {
                            const $content = $node.find(`#content-${nodeData.id}`);
                            if ($content.find('.template-preview').length) {
                                nodeData.data.additional_content = {
                                    type: 'template',
                                    name: $content.find('.template-name').text(),
                                    content: $content.find('.template-content-preview').html()
                                };
                            }
                        }
                    }

                    function processAiAgentNode($node, nodeData) {
                        nodeData.data.ai_agent = {
                            agent_id: $node.find('.ai-agent-select').val(),
                            initial_message: $node.find('#ai-agent-message-' + nodeData.id).val()
                        };
                    }

                    function processConditionNode($node, nodeData) {
                        nodeData.data.condition = {
                            field: $node.find('#condition-field-' + nodeData.id).val(),
                            operator: $node.find('#condition-operator-' + nodeData.id).val(),
                            value: $node.find('#condition-value-' + nodeData.id).val(),
                            outputs: {
                                true: connectionState.connections
                                    .filter(conn => conn.startNodeId === nodeData.id && conn
                                        .startPort.hasClass('true-port'))
                                    .map(conn => conn.endNodeId),
                                false: connectionState.connections
                                    .filter(conn => conn.startNodeId === nodeData.id && conn
                                        .startPort.hasClass('false-port'))
                                    .map(conn => conn.endNodeId)
                            }
                        };
                    }

                    function processAskAddressNode($node, nodeData) {
                        nodeData.data.ask_address = {
                            request_message: $node.find('#address-request-' + nodeData.id)
                                .val(),
                            address_field: $node.find('#address-field-' + nodeData.id).val()
                        };
                    }

                    function processAskLocationNode($node, nodeData) {
                        nodeData.data.ask_location = {
                            request_message: $node.find('#location-request-' + nodeData.id)
                                .val(),
                            longitude_field: $node.find('#longitude-' + nodeData.id).val(),
                            latitude_field: $node.find('#latitude-' + nodeData.id).val()
                        };
                    }

                    function processAskQuestionNode($node, nodeData) {
                        nodeData.data.ask_question = {
                            question: $node.find('#question-' + nodeData.id).val(),
                            field_name: $node.find('#customer-field-' + nodeData.id).val(),
                            validation: {
                                type: $node.find('#data-type-' + nodeData.id).val(),
                                max_attempts: parseInt($node.find('#max-attempts-' + nodeData
                                        .id)
                                    .val()) || 3,
                                error_message: $node.find('#error-message-' + nodeData.id).val()
                            }
                        };
                    }

                    function processAskMediaNode($node, nodeData) {
                        nodeData.data.ask_media = {
                            request_message: $node.find('#media-request-' + nodeData.id).val(),
                            field_name: $node.find('#customer-field-' + nodeData.id).val(),
                            media_type: $node.find('#request-media-type-' + nodeData.id).val(),
                            validation: {
                                max_attempts: parseInt($node.find('#max-attempts-' + nodeData
                                        .id)
                                    .val()) || 3,
                                error_message: $node.find('#error-message-' + nodeData.id).val()
                            }
                        };
                    }

                    function processApiRequestNode($node, nodeData) {
                        nodeData.data.api_request = {
                            method: $node.find('.api-method-select').val(),
                            url: $node.find('.api-url-input').val(),
                            headers: [],
                            body: $node.find('#api-body-' + nodeData.id).val()
                        };

                        $node.find('.api-header').each(function() {
                            nodeData.data.api_request.headers.push({
                                name: $(this).find(
                                        'input[placeholder="Header name"]')
                                    .val(),
                                value: $(this).find(
                                        'input[placeholder="Header value"]')
                                    .val()
                            });
                        });
                    }

                    function processConnectFlowNode($node, nodeData) {
                        nodeData.data.connect_flow = {
                            flow_id: $node.find('#connect-flow-' + nodeData.id).val(),
                            options: {
                                transfer_data: $node.find('#transfer-data-' + nodeData.id).is(
                                    ':checked'),
                                close_current: $node.find('#close-current-' + nodeData.id).is(
                                    ':checked')
                            }
                        };
                    }

                    await animateFlowTraversal(startNode.id);

                    const payload = {
                        flow: flowData,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    };

                    console.log('Flow data to be saved:', JSON.stringify(flowData, null, 2));

                    const response = await $.ajax({
                        url: url,
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(payload),
                        success: function(response) {
                            console.log('Save successful:', response);
                            showSuccess('Flow saved successfully!');
                        },
                        error: function(error) {
                            console.error('Save error:', error);
                            showError(error.responseJSON?.message ||
                                'Failed to save flow');
                        }
                    });

                    saveBtn.prop('disabled', false).html('Save');
                    alert('Flow data collected successfully! Check console for details.');

                } catch (error) {
                    console.error('Save error:', error);
                    saveBtn.prop('disabled', false).html('Save');
                    alert('Error: ' + (error.message || 'Failed to save flow'));
                }
            });

            async function animateFlowTraversal(nodeId, visited = new Set()) {
                if (visited.has(nodeId)) return;
                visited.add(nodeId);

                const $node = $(`#${nodeId}`);
                if (!$node.length) return;

                $node.addClass('node-highlight');

                const outgoingConnections = connectionState.connections
                    .filter(conn => conn.startNodeId === nodeId);

                for (const conn of outgoingConnections) {
                    conn.element.addClass('connection-highlight');
                    await new Promise(resolve => setTimeout(resolve, 800));
                    conn.element.removeClass('connection-highlight');
                    await animateFlowTraversal(conn.endNodeId, visited);
                }

                await new Promise(resolve => setTimeout(resolve, 300));
                $node.removeClass('node-highlight');
            }

        });
    </script>
@endsection
