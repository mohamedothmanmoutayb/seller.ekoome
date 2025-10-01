<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="horizontal">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="fb:app_id" content="{{ env('META_APP_ID') }}" />

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/notify.css') }}" />


    <link rel="stylesheet" href="{{ asset('assets/css/plugins/prettify.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/prismjs/themes/prism-okaidia.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



    <!-- Toastr -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    @yield('css')

    <title>EKOOME SOLUTION APP</title>
    <style>
        #notif-list {
            position: relative;
            /* Make sure the element is positioned */
            z-index: 9999;
            /* Set a high z-index */
        }

        #notif-list a {
            position: relative;
            z-index: 9999;
            /* Ensure the inserted notifications are on top */
        }


        .limit-warning-item {
            background-color: #fffaf0;
            border-left: 3px solid #ffc107 !important;
        }

        .limit-warning-item.text-danger {
            background-color: #fff5f5;
            border-left: 3px solid #dc3545 !important;
        }

        .limit-warning-item:hover {
            background-color: #f8f9fa;
        }

        .buy-now .btn-buy-now {
            position: fixed;
            z-index: 1080;
            box-shadow: 0 1px 20px 1px #222d6f;
            inset-block-end: 3rem;
            inset-inline-end: 1.5rem;
        }

        .buy-now .btn-buy-now {
            position: fixed;
            bottom: 3rem;
            right: 1.5rem;
            z-index: 1080;
            box-shadow: 0 1px 20px 1px #222d6f !important;
        }

        .btn-check:focus+.btn-danger,
        .btn-danger:focus,
        .btn-danger.focus {
            color: #fff;
            background-color: #516aff !important;
            border-color: #4862ff !important;
            box-shadow: none;
        }

        .select2-selection__arrow {
            display: none !important;
        }

        .floating-chat-container {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 9998;
            display: flex;
            align-items: flex-end;
        }

        .chat-button {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #25D366;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            border: none;
            position: relative;
            z-index: 2;
        }

        .chat-button i {
            font-size: 24px;
        }

        .chat-button:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .chat-menu {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 15px;
            margin-left: 15px;
            width: 0;
            opacity: 0;
            overflow: hidden;
            transition: all 0.1s ease;
            transform-origin: left center;
            position: relative;
            z-index: 1;
        }

        .chat-menu.open {
            width: 320px;
            opacity: 1;
            max-height: 360px;
            overflow-y: auto;
        }

        .menu-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .menu-header img {
            width: 30px;
            height: 30px;
            margin-right: 10px;
            border-radius: 50%;
        }

        .menu-header h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 8px 0;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s ease;
        }

        .menu-item:last-child {
            border-bottom: none;
        }

        .menu-item:hover {
            background-color: #f9f9f9;
        }

        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .menu-item .form-check-input {
            margin-right: 10px;
        }

        .online-status {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-left: 8px;
        }

        .online {
            background-color: #28a745;
        }

        .offline {
            background-color: #dc3545;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #dee2e6;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -30px;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #0d6efd;
            border: 3px solid white;
        }

        .timeline-time {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .timeline-content {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 3px solid #0d6efd;
        }

        .timeline-content h6 {
            margin-top: 0;
            color: #0d6efd;
        }

        .timeline-content p {
            margin-bottom: 0;
        }

        .agent-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .agent-item:hover {
            background-color: #f8f9fa;
        }

        .agent-name {
            font-weight: 500;
        }

        .agent-status {
            font-size: 12px;
            color: #6c757d;
        }

        .topbar .navbar .navbar-nav .nav-item.dropdown .dropdown-menu-end {
            overflow-y: auto;
        }

        .inmobile {
            width: 180px !important;
            height: 40px !important;
        }


        .mini-nav-item .submenu {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            padding-left: 0;
            margin: 0;
            transition: max-height 0.4s ease, opacity 0.3s ease;
        }


        .mini-nav-item.open .submenu {
            max-height: 500px;
            opacity: 1;
        }


        .mini-nav-item .submenu .mini-nav-item {
            margin-top: 6px;
            text-align: center;
        }
    </style>

</head>

<body>
    <!-- Toast -->
    {{-- <div class="toast toast-onload align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body hstack align-items-start gap-6">
      <i class="ti ti-alert-circle fs-6"></i>
      <div>
        <h5 class="text-white fs-3 mb-1">Welcome to MatDash</h5>
        <h6 class="text-white fs-2 mb-0">Easy to costomize the Template!!!</h6>
      </div>
      <button type="button" class="btn-close btn-close-white fs-2 m-0 ms-auto shadow-none" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div> --}}
    <!-- Preloader -->
    <div class="preloader">
        <img src="{{ asset('assets/images/logos/favicon.png') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">
        <!-- Sidebar Start -->
        <aside class="side-mini-panel with-vertical scroll-auto" style="z-index: 9999;">
            <!-- ---------------------------------- -->
            <!-- Start Vertical Layout Sidebar -->
            <!-- ---------------------------------- -->
            <div class="iconbar ">
                <div>
                    <div class="mini-nav">
                        <div class="brand-logo d-flex align-items-center justify-content-center">
                            <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                                <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-7"></iconify-icon>
                            </a>
                        </div>
                        <ul class="mini-nav-ul" data-simplebar>

                            <!-- --------------------------------------------------------------------------------------------------------- -->
                            <!-- Dashboards -->
                            <!-- --------------------------------------------------------------------------------------------------------- -->
                            <li class="mini-nav-item" id="mini-1">
                                <a href="{{ route('home') }}" data-bs-toggle="tooltip"
                                    data-bs-custom-class="custom-tooltip" data-bs-placement="right"
                                    data-bs-title="Dashboard">
                                    <iconify-icon icon="solar:layers-line-duotone" class="ti"></iconify-icon>
                                </a>
                            </li>

                            <!-- --------------------------------------------------------------------------------------------------------- -->
                            <!-- Pages -->
                            <!-- --------------------------------------------------------------------------------------------------------- -->
                            <li class="mini-nav-item" id="mini-3">
                                <a href="{{ route('leads.index') }}" data-bs-toggle="tooltip"
                                    data-bs-custom-class="custom-tooltip" data-bs-placement="right"
                                    data-bs-title="Leads">
                                    <iconify-icon icon="nimbus:box-packed" class="ti"></iconify-icon>
                                </a>
                            </li>
                            <!-- --------------------------------------------------------------------------------------------------------- -->
                            <!-- Forms  -->
                            <!-- --------------------------------------------------------------------------------------------------------- -->
                            <li class="mini-nav-item" id="mini-4">
                                <a href="{{ route('orders.index') }}" data-bs-toggle="tooltip"
                                    data-bs-custom-class="custom-tooltip" data-bs-placement="right"
                                    data-bs-title="Orders">
                                    <iconify-icon icon="system-uicons:cart" class="ti"></iconify-icon>
                                </a>
                            </li>

                            <li>
                                <span class="sidebar-divider lg"></span>
                            </li>
                            <!-- --------------------------------------------------------------------------------------------------------- -->
                            <!-- Tables -->
                            <!-- --------------------------------------------------------------------------------------------------------- -->
                            <li class="mini-nav-item" id="mini-5">
                                <a href="{{ route('stores.index') }}" data-bs-toggle="tooltip"
                                    data-bs-custom-class="custom-tooltip" data-bs-placement="right"
                                    data-bs-title="Stores">
                                    <iconify-icon icon="solar:notes-line-duotone" class="ti"></iconify-icon>
                                </a>
                            </li>
                            <!-- --------------------------------------------------------------------------------------------------------- -->
                            <!-- Charts -->
                            <!-- --------------------------------------------------------------------------------------------------------- -->

                            <li class="mini-nav-item has-submenu" id="mini-hr">
                                <a href="javascript:void(0)" class="submenu-toggle" data-bs-toggle="tooltip"
                                    data-bs-custom-class="custom-tooltip" data-bs-placement="right"
                                    data-bs-title="Analytics">
                                    <iconify-icon icon="solar:chart-line-duotone" class="ti"></iconify-icon>
                                </a>
                                <ul class="submenu" style="background-color: #f4f0ff;">
                                    <li>
                                        <span class="sidebar-divider lg"
                                            style="display:block; height:4px; background-color:#2c3e50; margin: 0; border-radius:2px;">
                                        </span>

                                    </li>
                                    <li class="mini-nav-item ">
                                        <a href="{{ route('analytics.netprofite') }}" data-bs-toggle="tooltip"
                                            data-bs-custom-class="custom-tooltip" style="background-color:  #f4f0ff;;"
                                            data-bs-placement="right" data-bs-title="Net Profite">
                                            <iconify-icon icon="mdi:finance" class="ti"></iconify-icon>
                                        </a>
                                    </li>
                                    <li class="mini-nav-item ">
                                        <a href="{{ route('analytics.confirmation') }}" data-bs-toggle="tooltip"
                                            data-bs-custom-class="custom-tooltip" style="background-color:  #f4f0ff;"
                                            data-bs-placement="right" data-bs-title="Confirmation Data">
                                            <iconify-icon icon="mdi:check-decagram" class="ti"></iconify-icon>
                                        </a>
                                    </li>
                                    <li class="mini-nav-item ">
                                        <a href="{{ route('analytics.shipping') }}" data-bs-toggle="tooltip"
                                            data-bs-custom-class="custom-tooltip" style="background-color:  #f4f0ff;"
                                            data-bs-placement="right" data-bs-title="Shipping Data">
                                            <iconify-icon icon="mdi:truck-fast-outline" class="ti"></iconify-icon>
                                        </a>
                                    </li>

                                    <li>
                                        <span class="sidebar-divider lg"
                                            style="display:block; height:4px; background-color:#2c3e50; margin: 0; border-radius:2px;">
                                        </span>
                                    </li>
                                </ul>
                            </li>



                            <!-- HR -->
                            <li class="mini-nav-item has-submenu" id="mini-hr">
                                <a href="javascript:void(0)" class="submenu-toggle" data-bs-toggle="tooltip"
                                    data-bs-custom-class="custom-tooltip" data-bs-placement="right"
                                    data-bs-title="HR">
                                    <iconify-icon icon="f7:person-2" class="ti"></iconify-icon>
                                </a>
                                <ul class="submenu" style="background-color: #f4f0ff;">
                                    <li>
                                        <span class="sidebar-divider lg"
                                            style="display:block; height:4px; background-color:#2c3e50; margin: 0; border-radius:2px;">
                                        </span>

                                    </li>
                                    <li class="mini-nav-item ">
                                        <a href="{{ route('users.index') }}" data-bs-toggle="tooltip"
                                            data-bs-custom-class="custom-tooltip" style="background-color:  #f4f0ff;;"
                                            data-bs-placement="right" data-bs-title="Users">
                                            <iconify-icon icon="solar:user-circle-line-duotone"
                                                class="ti"></iconify-icon>
                                        </a>
                                    </li>
                                    <li class="mini-nav-item ">
                                        <a href="{{ route('clients.index') }}" data-bs-toggle="tooltip"
                                            data-bs-custom-class="custom-tooltip" style="background-color:  #f4f0ff;"
                                            data-bs-placement="right" data-bs-title="Clients">
                                            <iconify-icon icon="mdi:account-multiple-outline"
                                                class="ti"></iconify-icon>
                                        </a>
                                    </li>
                                    <li class="mini-nav-item ">
                                        <a href="{{ route('suppliers.index') }}" data-bs-toggle="tooltip"
                                            data-bs-custom-class="custom-tooltip" style="background-color:  #f4f0ff;"
                                            data-bs-placement="right" data-bs-title="Suppliers">
                                            <iconify-icon icon="mdi:truck-outline" class="ti"></iconify-icon>
                                        </a>
                                    </li>

                                    <li>
                                        <span class="sidebar-divider lg"
                                            style="display:block; height:4px; background-color:#2c3e50; margin: 0; border-radius:2px;">
                                        </span>
                                    </li>
                                </ul>
                            </li>

                            <!-- Locations -->
                            <li class="mini-nav-item has-submenu" id="mini-locations">
                                <a href="javascript:void(0)" class="submenu-toggle" data-bs-toggle="tooltip"
                                    data-bs-custom-class="custom-tooltip" data-bs-placement="right"
                                    data-bs-title="Locations">
                                    <iconify-icon icon="f7:placemark" class="ti"></iconify-icon>
                                </a>
                                <ul class="submenu" style="background-color: #f4f0ff;">
                                    <li>
                                        <span class="sidebar-divider lg"
                                            style="display:block; height:4px; background-color:#2c3e50; margin: 0; border-radius:2px;">
                                        </span>

                                    </li>
                                    <li class="mini-nav-item">
                                        <a href="{{ route('countries.index') }}" data-bs-toggle="tooltip"
                                            data-bs-custom-class="custom-tooltip" style="background-color:  #f4f0ff;"
                                            data-bs-placement="right" data-bs-title="Countries">
                                            <iconify-icon icon="mdi:earth" class="ti"></iconify-icon>
                                        </a>
                                    </li>
                                    <li class="mini-nav-item">
                                        <a href="{{ route('cities.index') }}" data-bs-toggle="tooltip"
                                            data-bs-custom-class="custom-tooltip" style="background-color:  #f4f0ff;"
                                            data-bs-placement="right" data-bs-title="Cities">
                                            <iconify-icon icon="mdi:city" class="ti"></iconify-icon>
                                        </a>
                                    </li>
                                    <li class="mini-nav-item">
                                        <a href="{{ route('warehouses.index') }}" data-bs-toggle="tooltip"
                                            data-bs-custom-class="custom-tooltip" style="background-color:  #f4f0ff;"
                                            data-bs-placement="right" data-bs-title="Warehouses">
                                            <iconify-icon icon="mdi:warehouse" class="ti"></iconify-icon>
                                        </a>
                                    <li>
                                        <span class="sidebar-divider lg"
                                            style="display:block; height:4px; background-color:#2c3e50; margin: 0; border-radius:2px;">
                                        </span>

                                    </li>
                            </li>
                        </ul>
                        </li>


                        <!-- Integration -->
                        <li class="mini-nav-item has-submenu" id="mini-integration">
                            <a href="javascript:void(0)" class="submenu-toggle" data-bs-toggle="tooltip"
                                data-bs-custom-class="custom-tooltip" data-bs-placement="right"
                                data-bs-title="Integration">
                                <iconify-icon icon="f7:link" class="ti"></iconify-icon>
                            </a>

                            <!-- Submenu -->
                            <ul class="submenu" style="background-color: #f4f0ff;">
                                <!-- Divider (inside, hidden by default) -->
                                <li>
                                    <span class="sidebar-divider lg divider"
                                        style="display:block; height:4px; background-color:#2c3e50; margin: 0; border-radius:2px;">
                                    </span>
                                </li>

                                <li class="mini-nav-item">
                                    <a href="{{ route('last-mille.index') }}" data-bs-toggle="tooltip"
                                        data-bs-custom-class="custom-tooltip" style="background-color:  #f4f0ff;"
                                        data-bs-placement="right" data-bs-title="Last Mille">
                                        <iconify-icon icon="mdi:truck-delivery-outline" class="ti"></iconify-icon>
                                    </a>
                                </li>
                                <li class="mini-nav-item">
                                    <a href="{{ route('plateformes.index') }}" data-bs-toggle="tooltip"
                                        data-bs-custom-class="custom-tooltip" style="background-color:  #f4f0ff;"
                                        data-bs-placement="right" data-bs-title="Platforms">
                                        <iconify-icon icon="mdi:cloud-outline" class="ti"></iconify-icon>
                                    </a>
                                </li>
                                <li class="mini-nav-item">
                                    <a href="{{ route('plugins.index') }}" data-bs-toggle="tooltip"
                                        data-bs-custom-class="custom-tooltip" style="background-color:  #f4f0ff;"
                                        data-bs-placement="right" data-bs-title="Plugins">
                                        <iconify-icon icon="mdi:puzzle-outline" class="ti"></iconify-icon>
                                    </a>
                                </li>

                                <!-- Divider (bottom, hidden by default) -->
                                <li>
                                    <span class="sidebar-divider lg divider"
                                        style="display:block; height:4px; background-color:#2c3e50; margin: 0; border-radius:2px;">
                                    </span>
                                </li>
                            </ul>
                        </li>




                        <!-- Expensses -->
                        <li class="mini-nav-item has-submenu" id="mini-expenses">
                            <a href="javascript:void(0)" class="submenu-toggle" data-bs-toggle="tooltip"
                                data-bs-custom-class="custom-tooltip" data-bs-placement="right"
                                data-bs-title="Expenses">
                                <iconify-icon icon="ix:product-management" class="ti"></iconify-icon>
                            </a>
                            <ul class="submenu" style="background-color: #f4f0ff;">
                                <li>
                                    <span class="sidebar-divider lg"
                                        style="display:block; height:4px; background-color:#2c3e50; margin: 0; border-radius:2px;">
                                    </span>

                                </li>
                                <li class="mini-nav-item">
                                    <a href="{{ route('categoryexpense.index') }}" data-bs-toggle="tooltip"
                                        data-bs-custom-class="custom-tooltip" style="background-color:  #f4f0ff;"
                                        data-bs-placement="right" data-bs-title="Category Expenses">
                                        <iconify-icon icon="mdi:format-list-bulleted-type"
                                            class="ti"></iconify-icon>
                                    </a>
                                </li>
                                <li class="mini-nav-item">
                                    <a href="{{ route('expenses.index') }}" data-bs-toggle="tooltip"
                                        data-bs-custom-class="custom-tooltip" style="background-color:  #f4f0ff;"
                                        data-bs-placement="right" data-bs-title="List Expenses">
                                        <iconify-icon icon="mdi:currency-usd" class="ti"></iconify-icon>
                                    </a>
                                </li>
                                <li class="mini-nav-item">
                                    <a href="{{ route('speends.index') }}" data-bs-toggle="tooltip"
                                        data-bs-custom-class="custom-tooltip" style="background-color:  #f4f0ff;"
                                        data-bs-placement="right" data-bs-title="Spend Ads">
                                        <iconify-icon icon="mdi:bullhorn-outline" class="ti"></iconify-icon>
                                    </a>
                                <li>
                                    <span class="sidebar-divider lg"
                                        style="display:block; height:4px; background-color:#2c3e50; margin: 0; border-radius:2px;">
                                    </span>

                                </li>
                        </li>
                        </ul>
                        </li>


                        <!-- Reclamations -->
                        <li class="mini-nav-item" id="mini-10">
                            <a href="{{ route('reclamations.index') }}" data-bs-toggle="tooltip"
                                data-bs-custom-class="custom-tooltip" data-bs-placement="right"
                                data-bs-title="Reclamations">
                                <iconify-icon icon="solar:airbuds-case-minimalistic-line-duotone"
                                    class="ti"></iconify-icon>
                            </a>
                        </li>
                        <!-- --------------------------------------------------------------------------------------------------------- -->
                        </ul>

                    </div>

                </div>
            </div>
        </aside>
        <!--  Sidebar End -->
        <div class="page-wrapper">
            <!--  Header Start -->
            <header class="topbar">
                <div class="with-vertical">
                    <!-- ---------------------------------- -->
                    <!-- Start Vertical Layout Header -->
                    <!-- ---------------------------------- -->
                    <nav class="navbar navbar-expand-lg p-0">
                        <ul class="navbar-nav">
                            <li class="nav-item d-flex d-xl-none">
                                <a class="nav-link nav-icon-hover-bg rounded-circle  sidebartoggler "
                                    id="headerCollapse" href="javascript:void(0)">
                                    <iconify-icon icon="solar:hamburger-menu-line-duotone"
                                        class="fs-6"></iconify-icon>
                                </a>
                            </li>
                            <li class="nav-item d-none d-xl-flex nav-icon-hover-bg rounded-circle">
                                <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <iconify-icon icon="solar:magnifer-linear" class="fs-6"></iconify-icon>
                                </a>
                            </li>
                            <li class="nav-item d-none d-lg-flex dropdown nav-icon-hover-bg rounded-circle">
                                <div class="hover-dd">
                                    <a class="nav-link" id="drop2" href="javascript:void(0)"
                                        aria-haspopup="true" aria-expanded="false">
                                        <iconify-icon icon="solar:widget-3-line-duotone"
                                            class="fs-6"></iconify-icon>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-nav dropdown-menu-animate-up py-0 overflow-hidden"
                                        aria-labelledby="drop2">
                                        <div class="position-relative">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="p-4 pb-3">

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="position-relative">
                                                                    <a href="../horizontal/app-chat.html"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="bg-primary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                            <iconify-icon
                                                                                icon="solar:chat-line-bold-duotone"
                                                                                class="fs-7 text-primary"></iconify-icon>
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0">Chat Application</h6>
                                                                            <span
                                                                                class="fs-11 d-block text-body-color">New
                                                                                messages arrived</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="../horizontal/app-invoice.html"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="bg-secondary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                            <iconify-icon
                                                                                icon="solar:bill-list-bold-duotone"
                                                                                class="fs-7 text-secondary"></iconify-icon>
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0">Invoice App</h6>
                                                                            <span
                                                                                class="fs-11 d-block text-body-color">Get
                                                                                latest invoice</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="../horizontal/app-contact2.html"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="bg-warning-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                            <iconify-icon
                                                                                icon="solar:phone-calling-rounded-bold-duotone"
                                                                                class="fs-7 text-warning"></iconify-icon>
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0">Contact Application</h6>
                                                                            <span
                                                                                class="fs-11 d-block text-body-color">2
                                                                                Unsaved Contacts</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="../horizontal/app-email.html"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="bg-danger-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                            <iconify-icon
                                                                                icon="solar:letter-bold-duotone"
                                                                                class="fs-7 text-danger"></iconify-icon>
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0">Email App</h6>
                                                                            <span
                                                                                class="fs-11 d-block text-body-color">Get
                                                                                new emails</span>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="position-relative">
                                                                    <a href="{{ route('profil') }}"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="bg-success-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                            <iconify-icon
                                                                                icon="solar:user-bold-duotone"
                                                                                class="fs-7 text-success"></iconify-icon>
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0">User Profile</h6>
                                                                            <span
                                                                                class="fs-11 d-block text-body-color">More
                                                                                information</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="{{ route('countries.index') }}"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="bg-primary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                            <iconify-icon
                                                                                icon="solar:calendar-minimalistic-bold-duotone"
                                                                                class="fs-7 text-primary"></iconify-icon>
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0">Countries</h6>
                                                                            <span
                                                                                class="fs-11 d-block text-body-color">List
                                                                                Countries</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="{{ route('last-mille.index') }}"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="bg-secondary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                            <iconify-icon
                                                                                icon="solar:smartphone-2-bold-duotone"
                                                                                class="fs-7 text-secondary"></iconify-icon>
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0">Last Mille</h6>
                                                                            <span
                                                                                class="fs-11 d-block text-body-color">List
                                                                                Last Mille</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="../horizontal/app-notes.html"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="bg-warning-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                            <iconify-icon
                                                                                icon="solar:notes-bold-duotone"
                                                                                class="fs-7 text-warning"></iconify-icon>
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0">Notes Application</h6>
                                                                            <span
                                                                                class="fs-11 d-block text-body-color">To-do
                                                                                and Daily tasks</span>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 d-none d-lg-flex">
                                                    <img src="{{ asset('assets/images/backgrounds/mega-dd-bg.jpg') }}"
                                                        alt="mega-dd" class="img-fluid mega-dd-bg" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>

                        <div class="d-block d-lg-none py-9 py-xl-0">
                            <img src="{{ asset('logo.png') }}" alt="matdash-img" width="200" />
                        </div>
                        <a class="navbar-toggler p-0 border-0 nav-icon-hover-bg rounded-circle"
                            href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <iconify-icon icon="solar:menu-dots-bold-duotone" class="fs-6"></iconify-icon>
                        </a>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <div class="d-flex align-items-center justify-content-between">
                                <ul
                                    class="navbar-nav flex-row mx-auto ms-lg-auto align-items-center justify-content-center">
                                    <li class="nav-item dropdown">
                                        <a href="javascript:void(0)"
                                            class="nav-link nav-icon-hover-bg rounded-circle d-flex d-lg-none align-items-center justify-content-center"
                                            type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                                            aria-controls="offcanvasWithBothOptions">
                                            <iconify-icon icon="solar:sort-line-duotone"
                                                class="fs-6"></iconify-icon>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link moon dark-layout nav-icon-hover-bg rounded-circle"
                                            href="javascript:void(0)">
                                            <iconify-icon icon="solar:moon-line-duotone"
                                                class="moon fs-6"></iconify-icon>
                                        </a>
                                        <a class="nav-link sun light-layout nav-icon-hover-bg rounded-circle"
                                            href="javascript:void(0)" style="display: none">
                                            <iconify-icon icon="solar:sun-2-line-duotone"
                                                class="sun fs-6"></iconify-icon>
                                        </a>
                                    </li>

                                    <!-- ------------------------------- -->
                                    <!-- start language Dropdown -->
                                    <!-- ------------------------------- -->
                                    <li class="nav-item dropdown nav-icon-hover-bg rounded-circle">
                                        <?php
                                        $country = DB::table('countries')
                                            ->where('id', Auth::user()->country_id)
                                            ->first();
                                        $countries = DB::table('countries')->get();
                                        ?>
                                        <a class="nav-link" href="javascript:void(0)" id="drop2"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="flag-icon flag-icon-{{ $country->flag }}  object-fit-cover round-20"
                                                width="30px" height="30px"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                            aria-labelledby="drop2">
                                            <div class="message-body">
                                                @foreach ($countries as $v_country)
                                                    <a href="{{ route('countries', $v_country->id) }}"
                                                        class="d-flex align-items-center gap-2 py-3 px-4 dropdown-item">
                                                        <div class="position-relative">
                                                            <i class="flag-icon flag-icon-{{ $v_country->flag }} rounded-circle object-fit-cover round-20"
                                                                width="20px" height="20px"></i><span
                                                                class="lang-txt">{{ $v_country->name }}<span>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </li>
                                    <!-- ------------------------------- -->
                                    <!-- end language Dropdown -->
                                    <!-- ------------------------------- -->

                                    <!-- ------------------------------- -->
                                    <!-- start profile Dropdown -->
                                    <!-- ------------------------------- -->
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="javascript:void(0)" id="drop1"
                                            aria-expanded="false">
                                            <div class="d-flex align-items-center gap-2 lh-base">
                                                <img src="{{ asset('assets/images/profile/user-1.jpg') }}"
                                                    class="rounded-circle" width="35" height="35"
                                                    alt="matdash-img" />
                                                <iconify-icon icon="solar:alt-arrow-down-bold"
                                                    class="fs-2"></iconify-icon>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu profile-dropdown dropdown-menu-end dropdown-menu-animate-up"
                                            aria-labelledby="drop1">
                                            <div class="position-relative px-4 pt-3 pb-2">
                                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom gap-6">
                                                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}"
                                                        class="rounded-circle" width="56" height="56"
                                                        alt="matdash-img" />
                                                    <div>
                                                        <h5 class="mb-0 fs-12">{{ Auth::user()->name }} <span
                                                                class="text-success fs-11">Pro</span>
                                                        </h5>
                                                        <p class="mb-0 text-dark">
                                                            {{ Auth::user()->email }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="message-body">
                                                    <a href="{{ route('profil') }}"
                                                        class="p-2 dropdown-item h6 rounded-1">
                                                        Profile
                                                    </a>
                                                    <a href="../horizontal/page-pricing.html"
                                                        class="p-2 dropdown-item h6 rounded-1">
                                                        Subscription
                                                    </a>
                                                    <a href="{{ route('logout') }}"
                                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                                        class="p-2 dropdown-item h6 rounded-1">
                                                        <form id="logout-form" action="{{ route('logout') }}"
                                                            method="POST" class="d-none">
                                                            @csrf
                                                        </form>
                                                        Sign Outt
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- ------------------------------- -->
                                    <!-- end profile Dropdown -->
                                    <!-- ------------------------------- -->
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <!-- ---------------------------------- -->
                    <!-- End Vertical Layout Header -->
                    <!-- ---------------------------------- -->

                    <!-- ------------------------------- -->
                    <!-- apps Dropdown in Small screen -->
                    <!-- ------------------------------- -->
                    <!--  Mobilenavbar -->
                    <div class="offcanvas offcanvas-start pt-0" data-bs-scroll="true" tabindex="-1"
                        id="mobilenavbar" aria-labelledby="offcanvasWithBothOptionsLabel">
                        <nav class="sidebar-nav scroll-sidebar">
                            <div class="offcanvas-header justify-content-between">
                                <a href="{{ route('home') }}" class="text-nowrap logo-img ">
                                    <img src="{{ asset('logo.png') }}" alt="Logo" class="inmobile" />
                                </a>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body pt-0" data-simplebar style="height: calc(100vh - 80px)">
                                <ul id="sidebarnav">
                                    <li class="sidebar-item">
                                        <a class="sidebar-link has-arrow ms-0" href="javascript:void(0)"
                                            aria-expanded="false">
                                            <span>
                                                <iconify-icon icon="solar:slider-vertical-line-duotone"
                                                    class="fs-7"></iconify-icon>
                                            </span>
                                            <span class="hide-menu">Apps</span>
                                        </a>
                                        <ul aria-expanded="false" class="collapse first-level my-3 ps-3">
                                            <li class="sidebar-item py-2">
                                                <a href="{{ route('stores.index') }}"
                                                    class="d-flex align-items-center">
                                                    <div
                                                        class="bg-primary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                        <iconify-icon icon="solar:chat-line-bold-duotone"
                                                            class="fs-7 text-primary"></iconify-icon>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 bg-hover-primary">Stores</h6>
                                                        <span class="fs-11 d-block text-body-color">List Stores</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="sidebar-item py-2">
                                                <a href="{{ route('warehouses.index') }}"
                                                    class="d-flex align-items-center">
                                                    <div
                                                        class="bg-secondary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                        <iconify-icon icon="solar:bill-list-bold-duotone"
                                                            class="fs-7 text-secondary"></iconify-icon>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 bg-hover-primary">Warehouses</h6>
                                                        <span class="fs-11 d-block text-body-color">Get latest
                                                            invoice</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="sidebar-item py-2">
                                                <a href="../horizontal/app-contact2.html"
                                                    class="d-flex align-items-center">
                                                    <div
                                                        class="bg-warning-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                        <iconify-icon icon="solar:phone-calling-rounded-bold-duotone"
                                                            class="fs-7 text-warning"></iconify-icon>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 bg-hover-primary">Contact Application</h6>
                                                        <span class="fs-11 d-block text-body-color">2 Unsaved
                                                            Contacts</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="sidebar-item py-2">
                                                <a href="../horizontal/app-email.html"
                                                    class="d-flex align-items-center">
                                                    <div
                                                        class="bg-danger-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                        <iconify-icon icon="solar:letter-bold-duotone"
                                                            class="fs-7 text-danger"></iconify-icon>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 bg-hover-primary">Email App</h6>
                                                        <span class="fs-11 d-block text-body-color">Get new
                                                            emails</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="sidebar-item py-2">
                                                <a href="{{ route('profil') }}" class="d-flex align-items-center">
                                                    <div
                                                        class="bg-success-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                        <iconify-icon icon="solar:user-bold-duotone"
                                                            class="fs-7 text-success"></iconify-icon>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 bg-hover-primary">User Profile</h6>
                                                        <span class="fs-11 d-block text-body-color">More
                                                            information</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="sidebar-item py-2">
                                                <a href="{{ route('countries.index') }}"
                                                    class="d-flex align-items-center">
                                                    <div
                                                        class="bg-primary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                        <iconify-icon icon="solar:calendar-minimalistic-bold-duotone"
                                                            class="fs-7 text-primary"></iconify-icon>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 bg-hover-primary">Countries</h6>
                                                        <span class="fs-11 d-block text-body-color">List
                                                            Countries</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="sidebar-item py-2">
                                                <a href="{{ route('last-mille.index') }}"
                                                    class="d-flex align-items-center">
                                                    <div
                                                        class="bg-secondary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                        <iconify-icon icon="solar:smartphone-2-bold-duotone"
                                                            class="fs-7 text-secondary"></iconify-icon>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 bg-hover-primary">Last Mille</h6>
                                                        <span class="fs-11 d-block text-body-color">List Last
                                                            Mille</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="sidebar-item py-2">
                                                <a href="../horizontal/app-notes.html"
                                                    class="d-flex align-items-center">
                                                    <div
                                                        class="bg-warning-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                        <iconify-icon icon="solar:notes-bold-duotone"
                                                            class="fs-7 text-warning"></iconify-icon>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 bg-hover-primary">Notes Application</h6>
                                                        <span class="fs-11 d-block text-body-color">To-do and Daily
                                                            tasks</span>
                                                    </div>
                                                </a>
                                            </li>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>

                </div>
                <div class="app-header with-horizontal">
                    <nav class="navbar navbar-expand-xl container-fluid p-0">
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item d-flex d-xl-none">
                                <a class="nav-link sidebartoggler nav-icon-hover-bg rounded-circle"
                                    id="sidebarCollapse" href="javascript:void(0)">
                                    <iconify-icon icon="solar:hamburger-menu-line-duotone"
                                        class="fs-7"></iconify-icon>
                                </a>
                            </li>
                            <li class="nav-item d-none d-xl-flex align-items-center">
                                <a href="{{ asset('logo.png') }}" class="text-nowrap nav-link">
                                    <img src="{{ asset('logo.png') }}" alt="matdash-img" width="200" />
                                </a>
                            </li>
                            {{-- <li class="nav-item d-none d-xl-flex align-items-center nav-icon-hover-bg rounded-circle">
                                <a class="nav-link" href="javascript:void(0)" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <iconify-icon icon="solar:magnifer-linear" class="fs-6"></iconify-icon>
                                </a>
                            </li> --}}
                            <li
                                class="nav-item d-none d-lg-flex align-items-center dropdown nav-icon-hover-bg rounded-circle">
                                <div class="hover-dd">
                                    <a class="nav-link" id="drop2" href="javascript:void(0)"
                                        aria-haspopup="true" aria-expanded="false">
                                        <iconify-icon icon="solar:widget-3-line-duotone"
                                            class="fs-6"></iconify-icon>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-nav dropdown-menu-animate-up py-0 overflow-hidden"
                                        aria-labelledby="drop2">
                                        <div class="position-relative">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="p-4 pb-3">

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="position-relative">
                                                                    <a href="{{ route('stores.index') }}"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="bg-primary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                            <iconify-icon
                                                                                icon="solar:chat-line-bold-duotone"
                                                                                class="fs-7 text-primary"></iconify-icon>
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0">Stores</h6>
                                                                            <span
                                                                                class="fs-11 d-block text-body-color">list
                                                                                stores</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="{{ route('warehouses.index') }}"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="bg-secondary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                            <iconify-icon
                                                                                icon="solar:bill-list-bold-duotone"
                                                                                class="fs-7 text-secondary"></iconify-icon>
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0">Warehouses</h6>
                                                                            <span
                                                                                class="fs-11 d-block text-body-color">List
                                                                                Warehouse</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="{{ route('plateformes.index') }}"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="bg-warning-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                            <iconify-icon
                                                                                icon="solar:phone-calling-rounded-bold-duotone"
                                                                                class="fs-7 text-warning"></iconify-icon>
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0">Platform</h6>
                                                                            <span
                                                                                class="fs-11 d-block text-body-color">List
                                                                                Platform</span>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="position-relative">
                                                                    <a href="{{ route('profil') }}"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="bg-success-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                            <iconify-icon
                                                                                icon="solar:user-bold-duotone"
                                                                                class="fs-7 text-success"></iconify-icon>
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0">User Profile</h6>
                                                                            <span
                                                                                class="fs-11 d-block text-body-color">More
                                                                                information</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="{{ route('countries.index') }}"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="bg-primary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                            <iconify-icon
                                                                                icon="solar:calendar-minimalistic-bold-duotone"
                                                                                class="fs-7 text-primary"></iconify-icon>
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0">Location</h6>
                                                                            <span
                                                                                class="fs-11 d-block text-body-color">List
                                                                                Countries</span>
                                                                        </div>
                                                                    </a>
                                                                    <a href="{{ route('last-mille.index') }}"
                                                                        class="d-flex align-items-center pb-9 position-relative">
                                                                        <div
                                                                            class="bg-secondary-subtle rounded round-48 me-3 d-flex align-items-center justify-content-center">
                                                                            <iconify-icon
                                                                                icon="solar:smartphone-2-bold-duotone"
                                                                                class="fs-7 text-secondary"></iconify-icon>
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0">Last Mille</h6>
                                                                            <span
                                                                                class="fs-11 d-block text-body-color">List
                                                                                Last Mille</span>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 d-none d-lg-flex">
                                                    <img src="{{ asset('assets/images/backgrounds/mega-dd-bg.jpg') }}"
                                                        alt="mega-dd" class="img-fluid mega-dd-bg" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="d-block d-xl-none">
                            <a href="{{ route('home') }}" class="text-nowrap nav-link">
                                <img src="{{ asset('logo.png') }}" alt="matdash-img" />
                            </a>
                        </div>
                        <a class="navbar-toggler nav-icon-hover p-0 border-0 nav-icon-hover-bg rounded-circle"
                            href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="p-2">
                                <i class="ti ti-dots fs-7"></i>
                            </span>
                        </a>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <div class="d-flex align-items-center justify-content-between px-0 px-xl-8">
                                <ul
                                    class="navbar-nav flex-row mx-auto ms-lg-auto align-items-center justify-content-center">
                                    <li class="nav-item dropdown">
                                        <a href="javascript:void(0)"
                                            class="nav-link nav-icon-hover-bg rounded-circle d-flex d-lg-none align-items-center justify-content-center"
                                            type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                                            aria-controls="offcanvasWithBothOptions">
                                            <iconify-icon icon="solar:sort-line-duotone"
                                                class="fs-6"></iconify-icon>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link nav-icon-hover-bg rounded-circle moon dark-layout"
                                            href="javascript:void(0)">
                                            <iconify-icon icon="solar:moon-line-duotone"
                                                class="moon fs-6"></iconify-icon>
                                        </a>
                                        <a class="nav-link nav-icon-hover-bg rounded-circle sun light-layout"
                                            href="javascript:void(0)" style="display: none">
                                            <iconify-icon icon="solar:sun-2-line-duotone"
                                                class="sun fs-6"></iconify-icon>
                                        </a>
                                    </li>
                                    <li class="nav-item d-block d-xl-none">
                                        <a class="nav-link nav-icon-hover-bg rounded-circle" href="javascript:void(0)"
                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                            <iconify-icon icon="solar:magnifer-line-duotone"
                                                class="fs-6"></iconify-icon>
                                        </a>
                                    </li>
                                    <!-- ------------------------------- -->
                                    <!-- start notification Dropdown -->
                                    <!-- ------------------------------- -->
                                    <li id="notification-toggle" class=" nav-icon-hover-bg rounded-circle">
                                        <a class="load-notifications nav-link position-relative"
                                            href="javascript:void(0)" aria-expanded="false">
                                            <div style="position: relative; padding-top: -2px;">
                                                <iconify-icon icon="solar:bell-bing-line-duotone" class="fs-6"
                                                    style="margin-top: 3px;"></iconify-icon>
                                                <!-- Always render the badge element but hide it when empty -->

                                            </div>
                                            <span id="notification-count"
                                                class="notification-count position-absolute top-0 start-100 translate-middle badge rounded-circle"
                                                style="margin-left: -11px; margin-top: 9px; padding: 3px 6px; background-color: #dc3545; color: white; display: {{ $notifications->count() > 0 ? 'inline-block' : 'none' }};">
                                                {{ $notifications->count() > 99 ? '+99' : $notifications->count() }}
                                            </span>

                                        </a>
                                        <audio id="mysoundclip2" src="{{ asset('notification.mp3') }}"
                                            preload="auto"></audio>
                                        <audio id="mysoundclip3" src="{{ asset('error.mp3') }}"
                                            preload="auto"></audio>
                                        <audio id="mysoundclip4" src="{{ asset('warning.mp3') }}"
                                            preload="auto"></audio>
                                        <div id="notification-dropdown"
                                            class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up mt-3"
                                            style="display: none; margin-right: 22%;" aria-labelledby="drop2">
                                            <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                                <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                                                <span id="notif-count-badge"
                                                    class="notif-count-badge badge text-bg-primary rounded-4 px-3 py-1 lh-sm">
                                                    {{ $notifications->count() > 99 ? '+99' : $notifications->count() }}
                                                    new
                                                </span>

                                            </div>


                                            @include('backend.notifications.notifictionbar', [
                                                'notifications' => $notifications,
                                            ])




                                            {{-- heyyyyyyyyyyyyyyyy --}}


                                        </div>
                                        <div class="px-7 py-4 text-center text-muted notif-not-found"
                                            style="{{ $notifications->count() > 0 ? 'display: none;' : '' }}">
                                            No notifications found.
                                        </div>

                                        <div class="py-6 px-7" style="margin-bottom: -20px;">
                                            <a href="javascript:void(0)" id="mark-all-read"
                                                class="btn btn-secondary w-100"
                                                style="{{ $notifications->count() > 0 ? '' : 'display: none;' }}">
                                                Mark All as Read
                                            </a>
                                        </div>

                                        <div class="py-6 px-7 mb-1">
                                            <a href=" {{ route('notifications.index') }}  "
                                                class="btn btn-primary w-100">See All Notifications</a>
                                        </div>
                            </div>
                            </li>
                            <!-- ------------------------------- -->
                            <!-- end notification Dropdown -->
                            <!-- ------------------------------- -->
                            <li id="limit-warning-toggle" class="nav-icon-hover-bg rounded-circle">
                                <a class="load-limit-warnings nav-link position-relative" href="javascript:void(0)"
                                    aria-expanded="false">
                                    <div style="position: relative; padding-top: -2px;">
                                        <iconify-icon icon="solar:danger-triangle-line-duotone" class="fs-6"
                                            style="margin-top: 3px;"></iconify-icon>
                                        <span id="limit-warning-count"
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-warning"
                                            style="margin-left: -2px;margin-top: 5px;padding: 2px 6px;color: white;">
                                            !
                                        </span>
                                    </div>
                                </a>

                                <div id="limit-warning-dropdown"
                                    class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up mt-3"
                                    style="display: none; margin-right: 22%; width: 350px;" aria-labelledby="drop2">
                                    <div
                                        class="d-flex align-items-center justify-content-between py-3 px-4 border-bottom">
                                        <h5 class="mb-0 fs-5 fw-semibold">Plan Limits</h5>
                                        <span id="limit-warning-badge"
                                            class="badge text-bg-warning rounded-4 px-2 py-1 lh-sm"
                                            style="display: none;">
                                            0 exceeded
                                        </span>
                                    </div>

                                    <div id="limit-warning-list" class="px-4 py-3">
                                        <div class="text-center py-4">
                                            <div class="spinner-border text-warning" role="status">
                                                <span class="visually-hidden">Loading limits...</span>
                                            </div>
                                            <p class="mt-2 text-muted">Checking your usage...</p>
                                        </div>
                                    </div>

                                    <div class="px-4 py-3 border-top text-center">
                                        <a href="{{ route('profil') }}" class="btn btn-warning w-100">Upgrade
                                            Plan</a>
                                    </div>
                                </div>
                            </li>
                            <!-- ------------------------------- -->
                            <!-- start language Dropdown -->
                            <!-- ------------------------------- -->
                            <li class="nav-item dropdown nav-icon-hover-bg rounded-circle">
                                <?php
                                $country = DB::table('countries')
                                    ->where('id', Auth::user()->country_id)
                                    ->first();
                                $countries = DB::table('countries')->get();
                                ?>
                                <a class="nav-link" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="flag-icon flag-icon-{{ $country->flag }}  object-fit-cover round-20"
                                        width="30px" height="30px"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        @foreach ($countries as $v_country)
                                            <a href="{{ route('countries', $v_country->id) }}"
                                                class="d-flex align-items-center gap-2 py-3 px-4 dropdown-item">
                                                <div class="position-relative">
                                                    <i class="flag-icon flag-icon-{{ $v_country->flag }} rounded-circle object-fit-cover round-20"
                                                        width="20px" height="20px"></i><span
                                                        class="lang-txt">{{ $v_country->name }}<span>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                            <!-- ------------------------------- -->
                            <!-- end language Dropdown -->
                            <!-- ------------------------------- -->

                            <!-- ------------------------------- -->
                            <!-- start profile Dropdown -->
                            <!-- ------------------------------- -->
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="javascript:void(0)" id="drop1" aria-expanded="false">
                                    <div class="d-flex align-items-center gap-2 lh-base">
                                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}"
                                            class="rounded-circle" width="35" height="35"
                                            alt="matdash-img" />
                                        <iconify-icon icon="solar:alt-arrow-down-bold" class="fs-2"></iconify-icon>
                                    </div>
                                </a>
                                <div class="dropdown-menu profile-dropdown dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop1">
                                    <div class="position-relative px-4 pt-3 pb-2">
                                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom gap-6">
                                            <img src="{{ asset('assets/images/profile/user-1.jpg') }}"
                                                class="rounded-circle" width="56" height="56"
                                                alt="matdash-img" />
                                            <div>
                                                <h5 class="mb-0 fs-12">{{ Auth::user()->name }} <span
                                                        class="text-success fs-11">Pro</span>
                                                </h5>
                                                <p class="mb-0 text-dark">
                                                    {{ Auth::user()->email }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="message-body">
                                            <a href="{{ route('profil') }}" class="p-2 dropdown-item h6 rounded-1">
                                                Profile
                                            </a>
                                            <a href="" class="p-2 dropdown-item h6 rounded-1">
                                                Subscription
                                            </a>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                                class="p-2 dropdown-item h6 rounded-1">
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                </form>
                                                Sign Out
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!-- ------------------------------- -->
                            <!-- end profile Dropdown -->
                            <!-- ------------------------------- -->
                            </ul>
                        </div>
                </div>
                </nav>
        </div>
        </header>
        <!--  Header End -->

        <aside class="left-sidebar with-horizontal">
            <!-- Sidebar scroll-->
            <div>
                <!-- Sidebar navigation-->
                <nav id="sidebarnavh" class="sidebar-nav scroll-sidebar container-fluid">
                    <ul id="sidebarnav">
                        <!-- ============================= -->
                        <!-- Home -->
                        <!-- ============================= -->
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        <!-- =================== -->
                        <!-- Dashboard -->
                        <!-- =================== -->
                        <li class="sidebar-item">
                            <a class="sidebar-link " href="{{ route('home') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:layers-line-duotone" class="ti"></iconify-icon>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <!-- =================== -->
                        <!-- Icon -->
                        <!-- =================== -->
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('leads.index') }}" aria-expanded="false">
                                <span class="rounded-3">
                                    <iconify-icon icon="nimbus:box-packed" class="ti"></iconify-icon>
                                </span>
                                <span class="hide-menu">Leads</span>
                            </a>
                        </li>

                        <!-- ============================= -->
                        <!-- Orders -->
                        <!-- ============================= -->
                        <li class="sidebar-item">
                            <a class="sidebar-link two-column" href="{{ route('orders.index') }}"
                                aria-expanded="false">
                                <span>
                                    <iconify-icon icon="system-uicons:cart" class="ti"></iconify-icon>
                                </span>
                                <span class="hide-menu">Orders</span>
                            </a>
                        </li>
                        <!-- ============================= -->
                        <!-- Stores -->
                        <!-- ============================= -->
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Stores</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link " href="{{ route('stores.index') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:notes-line-duotone" class="ti"></iconify-icon>
                                </span>
                                <span class="hide-menu">Stores</span>
                            </a>
                        </li>
                        <!-- =================== -->
                        <!-- UI Elements -->
                        <!-- =================== -->



                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="rounded-3">
                                    <iconify-icon icon="f7:person-2" class="ti"></iconify-icon>
                                </span>
                                <span class="hide-menu">Statistics</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('analytics.netprofite') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">Net Profite</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('analytics.confirmation') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">Confirmation Data</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('analytics.shipping') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">Shipping Data</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- 

                       

                        <!-- ============================= -->
                        <!-- Users -->
                        <!-- =================== -->
                        <!-- Forms -->
                        <!-- =================== -->
                        {{-- <li class="sidebar-item">
                            <a class="sidebar-link two-column " href="{{ route('users.index') }}"
                                aria-expanded="false">
                                <span class="rounded-3">
                                    <iconify-icon icon="f7:person-2" class="ti"></iconify-icon>
                                </span>
                                <span class="hide-menu"></span>
                            </a>
                        </li> --}}
                        <!-- ============================= -->
                        <!-- Clients -->
                        <!-- =================== -->
                        <!-- Forms -->
                        <!-- =================== -->
                        {{-- <li class="sidebar-item">
                            <a class="sidebar-link two-column " href="{{ route('clients.index') }}"
                                aria-expanded="false">
                                <span class="rounded-3">
                                    <iconify-icon icon="f7:person-2" class="ti"></iconify-icon>
                                </span>
                                <span class="hide-menu">Clients</span>
                            </a>
                        </li> --}}
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="rounded-3">
                                    <iconify-icon icon="f7:person-2" class="ti"></iconify-icon>
                                </span>
                                <span class="hide-menu">Users</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('users.index') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">My users</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('clients.index') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">Clients</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('suppliers.index') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">Suppliers</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="rounded-3">
                                    <iconify-icon icon="f7:person-2" class="ti"></iconify-icon>
                                </span>
                                <span class="hide-menu">Messages</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('whatsapp-template.index') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">Whatsapp</span>
                                    </a>
                                </li>
                                {{-- <li class="sidebar-item">
                                    <a href="{{ route('clients.index') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">Chat</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </li>
                        <!-- ============================= -->
                        <!-- Tables -->
                        <!-- =================== -->
                        <!-- Bootstrap Table -->
                        <!-- =================== -->
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="rounded-3">
                                    <iconify-icon icon="f7:placemark" class="ti"></iconify-icon>
                                </span>
                                <span class="hide-menu">Locations</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('countries.index') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">Countries</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('cities.index') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">Cities</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('warehouses.index') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">Warehouses</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- ============================= -->
                        <!-- Charts -->
                        <!-- =================== -->
                        <!-- Apex Chart -->
                        <!-- =================== -->
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="rounded-3">
                                    <iconify-icon icon="f7:link" class="ti"></iconify-icon>
                                </span>
                                <span class="hide-menu">Integration</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('last-mille.index') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">Last Mille</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('plateformes.index') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">Platforms</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('plugins.index') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">Plugins</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- ============================= -->
                        <!-- Expensses -->
                        <!-- ============================= -->
                        <!-- Expensses -->
                        <!-- =================== -->
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="rounded-3">
                                    <iconify-icon icon="ix:product-management" class="ti"></iconify-icon>
                                </span>
                                <span class="hide-menu">Expenses</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('categoryexpense.index') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">Category Expenses</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('expenses.index') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">List Expenses</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('speends.index') }}" class="sidebar-link">
                                        <i class="ti ti-circle"></i>
                                        <span class="hide-menu">Speend Ads</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- relamation -->
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('reclamations.index') }}"
                                aria-expanded="false">
                                <span class="rounded-3">
                                    <iconify-icon icon="solar:airbuds-case-minimalistic-line-duotone"
                                        class="ti"></iconify-icon>
                                </span>
                                <span class="hide-menu">Reclamations</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>

        <div class="body-wrapper">
            @if (!isset($noContainer) || !$noContainer)
                <div class="container-fluid">
                    @yield('content')
                </div>
            @else
                @yield('content')
            @endif
        </div>

        <script>
            function handleColorTheme(e) {
                document.documentElement.setAttribute("data-color-theme", e);
            }
        </script>
    </div>

    {{-- <!--  Search Bar -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-bottom">
                        <input type="search" class="form-control" placeholder="Search here" id="search" />
                        <a href="javascript:void(0)" data-bs-dismiss="modal" class="lh-1">
                            <i class="ti ti-x fs-5 ms-3"></i>
                        </a>
                    </div>
                    <div class="modal-body message-body" data-simplebar="">
                        <h5 class="mb-0 fs-5 p-1">Quick Page Links</h5>
                        <ul class="list mb-0 py-2">
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Analytics</span>
                                    <span class="fs-2 d-block text-body-secondary">/dashboards/dashboard1</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">eCommerce</span>
                                    <span class="fs-2 d-block text-body-secondary">/dashboards/dashboard2</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">CRM</span>
                                    <span class="fs-2 d-block text-body-secondary">/dashboards/dashboard3</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Contacts</span>
                                    <span class="fs-2 d-block text-body-secondary">/apps/contacts</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Posts</span>
                                    <span class="fs-2 d-block text-body-secondary">/apps/blog/posts</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Detail</span>
                                    <span
                                        class="fs-2 d-block text-body-secondary">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Shop</span>
                                    <span class="fs-2 d-block text-body-secondary">/apps/ecommerce/shop</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Modern</span>
                                    <span class="fs-2 d-block text-body-secondary">/dashboards/dashboard1</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Dashboard</span>
                                    <span class="fs-2 d-block text-body-secondary">/dashboards/dashboard2</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Contacts</span>
                                    <span class="fs-2 d-block text-body-secondary">/apps/contacts</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Posts</span>
                                    <span class="fs-2 d-block text-body-secondary">/apps/blog/posts</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Detail</span>
                                    <span
                                        class="fs-2 d-block text-body-secondary">/apps/blog/detail/streaming-video-way-before-it-was-cool-go-dark-tomorrow</span>
                                </a>
                            </li>
                            <li class="p-1 mb-1 bg-hover-light-black rounded px-2">
                                <a href="javascript:void(0)">
                                    <span class="text-dark fw-semibold d-block">Shop</span>
                                    <span class="fs-2 d-block text-body-secondary">/apps/ecommerce/shop</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
    <div class="dark-transparent sidebartoggler"></div>
    <div class="buy-now" bis_skin_checked="1">
        <a href="#" data-bs-toggle="modal" data-bs-target="#modalCenter"
            class="btn btn-danger btn-buy-now waves-effect waves-light"> <i class="ti ti-headset tI-lg mx-1"></i>
            Contact Us</a>
    </div>
    <div class="floating-chat-container">
        <button class="chat-button" id="chatButton">
            <img src="{{ asset('support.png') }}" alt="Logo">
        </button>
        <div class="chat-menu" id="chatMenu">
            <div class="menu-header">
                <h5>Agents Status</h5>
            </div>

            <div id="agentList">
                <div class="text-center py-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="agentHistoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agentNameTitle">Agent History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="timeline" id="timelineContainer">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="modalCenter" tabindex="-1" bis_skin_checked="1" aria-modal="true"
        role="dialog" style="display: none;">
        <div class="modal-dialog modal-dialog-centered" role="document" bis_skin_checked="1">
            <div class="modal-content" bis_skin_checked="1">
                <div class="modal-header" bis_skin_checked="1">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <h4 class="modal-title text-center">

                </h4>


                <div class="modal-body" bis_skin_checked="1">
                    <div class="row text-center" bis_skin_checked="1">


                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60"
                            viewBox="0 0 24 24" class="text-primary" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M4 14v-3a8 8 0 1 1 16 0v3"></path>
                            <path d="M18 19c0 1.657 -2.686 3 -6 3"></path>
                            <path d="M4 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2v-3z">
                            </path>
                            <path d="M15 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2v-3z">
                            </path>
                        </svg>
                        <h4 class="text-primary">Customer Support</h4>
                    </div>
                    <div class="row d-flex justify-content-center" bis_skin_checked="1">
                        We’re available Monday through Friday, from 9:00 AM&nbsp;to&nbsp;7:00&nbsp;PM
                    </div>
                    <div class="row  d-flex justify-content-center align-items-center mt-4" bis_skin_checked="1">

                        <a href="https://www.instagram.com/ekoome/" target="_blank" style="width: 85px"
                            class="btn btn-icon rounded-pill btn-instagram waves-effect waves-light">
                            <i class="tf-icons ti ti-brand-instagram ti-md" style="font-size:17px !important "></i>
                            <span style="font-weight: bold;font-size: 10px" class="mx-1">
                                Instagram</span>
                        </a>
                        <a href="https://wa.me/+21718751708?text=hi" target="_blank" style="width: 85px"
                            class="btn btn-success btn-icon rounded-pill  mx-2  my-2 waves-effect waves-light">
                            <i class="tf-icons ti ti-brand-whatsapp  ti-md" style="font-size:17px !important "></i>
                            <span style="font-weight: bold;font-size: 10px" class="mx-1">
                                Whatsapp</span>
                        </a>
                        <a target="_blank"
                            href="https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to=info@ekoom.com&amp;su=Your%20Subject&amp;body=Hello%20there!"
                            style="width: 85px"
                            class="btn btn-secondary btn-icon rounded-pill mx-2 waves-effect waves-light">
                            <i class="tf-icons ti ti-brand-google ti-md" style="font-size:17px !important "></i>
                            <span style="font-weight: bold;font-size: 10px" class="mx-1">
                                Google</span>
                        </a>
                        <a target="_blank" href="https://ekoome.com/" style="width: 85px"
                            class="btn btn-dark btn-icon rounded-pill waves-effect waves-light">

                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-world-www">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M19.5 7a9 9 0 0 0 -7.5 -4a8.991 8.991 0 0 0 -7.484 4"></path>
                                <path d="M11.5 3a16.989 16.989 0 0 0 -1.826 4"></path>
                                <path d="M12.5 3a16.989 16.989 0 0 1 1.828 4"></path>
                                <path d="M19.5 17a9 9 0 0 1 -7.5 4a8.991 8.991 0 0 1 -7.484 -4"></path>
                                <path d="M11.5 21a16.989 16.989 0 0 1 -1.826 -4"></path>
                                <path d="M12.5 21a16.989 16.989 0 0 0 1.828 -4"></path>
                                <path d="M2 10l1 4l1.5 -4l1.5 4l1 -4"></path>
                                <path d="M17 10l1 4l1.5 -4l1.5 4l1 -4"></path>
                                <path d="M9.5 10l1 4l1.5 -4l1.5 4l1 -4"></path>
                            </svg>
                            <span style="font-weight: bold;font-size: 10px" class="mx-1">
                                Website</span>
                        </a>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <audio id="mysoundclip1" preload="auto">
        <source src="{{ url('entred-lead.mp3') }}">
        </source>
    </audio>
    <audio id="mysoundclip2" preload="auto">
        <source src="{{ url('entred-lead.mp3') }}">
        </source>
    </audio>
    <!-- Import Js Files -->
    <script>
        $('input[name="date"]').daterangepicker();
    </script>

    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.horizontal.init.js') }}"></script>
    <script src="{{ asset('assets/js/theme/theme.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/sidebarmenu.js') }}"></script>

    <!-- solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboards/dashboard1.js') }}"></script>
    <script src="{{ asset('assets/libs/fullcalendar/index.global.min.js') }}"></script>

    <!-- This Page JS -->
    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/forms/select2.init.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/prettify.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/plugins/notify.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>


    <script>
        setTimeout(function() {
            var script = document.createElement('script');
            script.src = "{{ asset('assets/js/plugins/notify.js') }}";
            document.head.appendChild(script);

        }, 20);

        document.querySelectorAll(".submenu-toggle").forEach(toggle => {
            toggle.addEventListener("click", function(e) {
                e.preventDefault();
                const parent = this.closest(".mini-nav-item");

                document.querySelectorAll(".mini-nav-item.has-submenu").forEach(item => {
                    if (item !== parent) item.classList.remove("open");
                });

                parent.classList.toggle("open");
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#chatButton').click(function() {
                $('#chatMenu').toggleClass('open');
            });

            $(document).click(function(event) {
                if (!$(event.target).closest('.floating-chat-container').length) {
                    $('#chatMenu').removeClass('open');
                }
            });
            $('#chatButton').click(function() {
                if ($('#chatMenu').hasClass('open')) {
                    loadAgents();
                }
            });

            function loadAgents() {
                $.ajax({
                    url: '/agent-status/agents',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#agentList').empty();
                        if (response.length > 0) {
                            response.forEach(function(agent) {
                                const isOnline = isAgentOnline(agent.last_activity);
                                const statusText = isOnline ? 'Online' : formatLastSeen(agent
                                    .last_activity);

                                $('#agentList').append(`
                                <div class="agent-item" data-agent-id="${agent.id_user}" data-agent-name="${agent.name}">
                                    <div>
                                        <span class="agent-name">${agent.name}</span>
                                        <span class="online-status ${isOnline ? 'online' : 'offline'}"></span>
                                    </div>
                                    <span class="agent-status">${statusText}</span>
                                </div>
                            `);
                            });

                            $('.agent-item').click(function() {
                                const agentId = $(this).data('agent-id');
                                const agentName = $(this).data('agent-name');
                                loadAgentHistory(agentId, agentName);
                            });
                        } else {
                            $('#agentList').html('<div class="menu-item">No agents found</div>');
                        }
                    },
                    error: function() {
                        $('#agentList').html('<div class="menu-item">Error loading agents</div>');
                    }
                });
            }

            function isAgentOnline(lastActivity) {
                if (!lastActivity) return false;
                const lastActive = new Date(lastActivity);
                const now = new Date();
                const diffMinutes = (now - lastActive) / (1000 * 60);
                return diffMinutes < 5;
            }

            function formatLastSeen(lastActivity) {
                if (!lastActivity) return 'Never active';

                const lastActive = new Date(lastActivity);
                const now = new Date();
                const diffSeconds = Math.floor((now - lastActive) / 1000);

                if (diffSeconds < 60) return 'Just now';
                if (diffSeconds < 3600) return `${Math.floor(diffSeconds / 60)}m ago`;
                if (diffSeconds < 86400) return `${Math.floor(diffSeconds / 3600)}h ago`;
                return `${Math.floor(diffSeconds / 86400)}d ago`;
            }

            function loadAgentHistory(agentId, agentName) {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open').css('padding-right', '');

                $('.modal.show').each(function() {
                    const modalInstance = bootstrap.Modal.getInstance(this);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                });

                $.ajax({
                    url: `/agent-status/history/${agentId}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#agentNameTitle').text(`${agentName}'s Activity Today`);
                        const timeline = $('#timelineContainer');
                        timeline.empty();

                        if (response.length > 0) {
                            response.forEach(function(history) {
                                const leadId = history.lead[0]?.id ?? 'N/A';
                                const leadNumber = history.lead[0]?.n_lead ?? 'N/A';
                                timeline.append(`
                                    <div class="timeline-item">
                                        <div class="timeline-time">${formatTime(history.created_at)}</div>
                                        <div class="timeline-content">
                                            <h6><a href="/leads/edit/${leadId}" target="_blank">Lead #${leadNumber}</a></h6>
                                            <p><strong>Status:</strong> ${history.status}</p>
                                            ${history.comment ? `<p><strong>Comment:</strong> ${history.comment}</p>` : ''}
                                        </div>
                                    </div>
                                `);
                            });
                        } else {
                            timeline.html('<p>No activity recorded for today.</p>');
                        }

                        const modal = new bootstrap.Modal(document.getElementById('agentHistoryModal'));
                        modal.show();
                    },
                    error: function() {
                        alert('Error loading agent history');
                    }
                });
            }

            function formatTime(timestamp) {
                const date = new Date(timestamp);
                return date.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }

            $('#limit-warning-toggle > a').on('click', function(e) {
                e.stopPropagation();
                const dropdown = $('#limit-warning-dropdown');
                const isVisible = dropdown.css('display') === 'block';

                dropdown.css('display', isVisible ? 'none' : 'block');

                if (!isVisible) {
                    loadLimitWarnings();
                }
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#limit-warning-toggle').length) {
                    $('#limit-warning-dropdown').hide();
                }
            });

            $('#limit-warning-dropdown').on('click', function(e) {
                e.stopPropagation();
            });

            function loadLimitWarnings() {
                $('#limit-warning-list').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-warning" role="status">
                    <span class="visually-hidden">Loading limits...</span>
                </div>
                <p class="mt-2 text-muted">Checking your usage...</p>
            </div>
        `);

                $.ajax({
                    url: '{{ route('usage.limits.check') }}',
                    method: 'GET',
                    success: function(response) {
                        updateLimitWarningsUI(response);
                    },
                    error: function() {
                        $('#limit-warning-list').html(`
                    <div class="text-center py-3">
                        <iconify-icon icon="solar:danger-triangle-line-duotone" class="fs-1 text-muted"></iconify-icon>
                        <p class="mt-2 text-muted">Error loading limit information</p>
                    </div>
                `);
                    }
                });
            }

            function updateLimitWarningsUI(data) {
                let exceededCount = 0;
                let warningsHtml = '';

                // Check each metric
                if (data.users && (data.users.is_over_limit || data.users.is_near_limit)) {
                    exceededCount++;
                    warningsHtml += createLimitWarningItem('users', data.users);
                }

                if (data.sales && (data.sales.is_over_limit || data.sales.is_near_limit)) {
                    exceededCount++;
                    warningsHtml += createLimitWarningItem('sales', data.sales);
                }


                if (exceededCount > 0) {
                    $('#limit-warning-list').html(warningsHtml);
                    $('#limit-warning-badge').text(`${exceededCount} exceeded`).show();
                    $('#limit-warning-count').show();
                } else {
                    $('#limit-warning-list').html(`
                <div class="text-center py-3">
                    <iconify-icon icon="solar:check-circle-line-duotone" class="fs-1 text-success"></iconify-icon>
                    <p class="mt-2 text-success">All limits are within range</p>
                </div>
            `);
                    $('#limit-warning-badge').hide();
                    $('#limit-warning-count').hide();
                }
            }

            function createLimitWarningItem(metric, data) {
                const metricNames = {
                    'users': 'Users',
                    'sales': 'Monthly Sales'
                };

                const metricName = metricNames[metric] || metric;
                const isOver = data.is_over_limit;
                const icon = isOver ? 'solar:danger-triangle-line-duotone' : 'solar:info-circle-line-duotone';
                const textClass = isOver ? 'text-danger' : 'text-warning';
                const statusText = isOver ? 'Limit Exceeded!' : 'Near Limit';

                return `
            <div class="limit-warning-item mb-3 p-3 border rounded ${textClass}">
                <div class="d-flex align-items-center mb-2">
                    <iconify-icon icon="${icon}" class="fs-5 me-2"></iconify-icon>
                    <strong>${metricName} ${statusText}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Usage: ${data.current_usage} / ${data.limit}</span>
                    <span class="badge ${isOver ? 'bg-danger' : 'bg-warning'}">${Math.round(data.percentage)}%</span>
                </div>
                ${isOver ? 
                    `<div class="mt-2 small">You cannot create more ${metricName} until you upgrade.</div>` : 
                    `<div class="mt-2 small">You're approaching your limit. Consider upgrading soon.</div>`
                }
            </div>
        `;
            }

            setInterval(function() {
                $.ajax({
                    url: '{{ route('usage.limits.check') }}',
                    method: 'GET',
                    success: function(response) {
                        let exceededCount = 0;

                        if (response.users && (response.users.is_over_limit || response.users
                                .is_near_limit)) exceededCount++;
                        if (response.sales && (response.sales.is_over_limit || response.sales
                                .is_near_limit)) exceededCount++;

                        if (exceededCount > 0) {
                            $('#limit-warning-count').show();
                        } else {
                            $('#limit-warning-count').hide();
                        }
                    }
                });
            }, 300000);
        });

        document.addEventListener("DOMContentLoaded", function() {
            const savedTheme = localStorage.getItem("theme") || "light";
            setTheme(savedTheme);

            document.querySelectorAll(".light-layout").forEach((btn) => {
                btn.addEventListener("click", () => {
                    setTheme("light");
                });
            });

            document.querySelectorAll(".dark-layout").forEach((btn) => {
                btn.addEventListener("click", () => {
                    setTheme("dark");
                });
            });

            function setTheme(theme) {
                document.documentElement.setAttribute("data-bs-theme", theme);
                localStorage.setItem("theme", theme);

                if (theme === "dark") {
                    document.querySelectorAll(".moon").forEach(el => el.style.display = "none");
                    document.querySelectorAll(".sun").forEach(el => el.style.display = "flex");
                } else {
                    document.querySelectorAll(".moon").forEach(el => el.style.display = "flex");
                    document.querySelectorAll(".sun").forEach(el => el.style.display = "none");
                }
            }
        });
    </script>





    <script>
        let audioUnlocked = false;

        const unlockAudio = function() {
            if (!audioUnlocked) {
                const audio = document.getElementById("mysoundclip2");
                if (audio) {
                    audio.play().then(() => {
                        audio.pause();
                        audio.currentTime = 0;
                        audioUnlocked = true;
                    }).catch((error) => {
                        console.warn("Audio autoplay was blocked:", error);
                    });
                }
            }
        };

        document.addEventListener('DOMContentLoaded', unlockAudio);
        document.addEventListener('mousemove', unlockAudio, {
            once: true
        });
        document.addEventListener('click', unlockAudio, {
            once: true
        });
        document.addEventListener('touchstart', unlockAudio, {
            once: true
        });




        var pusherKey = "{{ env('PUSHER_APP_KEY') }}";
        var pusherCluster = "{{ env('PUSHER_APP_CLUSTER') }}";
        var userId = @json(auth()->id());

        var pusher = new Pusher(pusherKey, {
            cluster: pusherCluster,
            forceTLS: true,
            authEndpoint: '/broadcasting/auth', // Laravel default endpoint for auth
            auth: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                withCredentials: true
            }
        });


        let channel = pusher.subscribe('user.' + userId);


        channel.bind("pusher:subscription_succeeded", () => {
            console.log("✅ Subscribed to channel");
        });

        channel.bind("pusher:subscription_error", (status) => {
            console.error("❌ Subscription failed with status", status);
        });


        pusher.connection.bind('connected', function() {
            console.log('Connected to Pusher');


            $.get('{{ route('notifications.get') }}', function(response) {
                console.log("Notification Preferences:");
                console.log("Sound Enabled:", response.sound);
                console.log("Enabled Titles:", response.titles);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Failed to fetch notification preferences:", textStatus, errorThrown);
            });

        });


        channel.bind('Notification', function(data) {

            console.log('Received Pusher notification:', data);

            try {


                let notifyType = '';
                let delay = 3000;

                if (data.type === 'success') {
                    notifyType = 'success';
                    delay = 2000;
                } else if (data.type === 'error') {
                    notifyType = 'danger';
                    delay = 3000;
                } else if (data.type === 'warning') {
                    notifyType = 'warning';
                    delay = 3000;
                }

                $.notify(data.message, {
                    type: notifyType,
                    align: "right",
                    verticalAlign: "top",
                    delay: delay,
                    animationType: "drop"
                });
            } catch (error) {
                console.error('Error in Pusher notification handler:', error);
            }


            let audioId = null;

            switch (data.type) {
                case 'success':
                    audioId = "mysoundclip2";
                    break;
                case 'error':
                    audioId = "mysoundclip3";
                    break;
                case 'warning':
                    audioId = "mysoundclip4";
                    break;
                default:
                    audioId = "mysoundclip2";
            }

            $.get('{{ route('notifications.get') }}', function(response) {
                console.log("Notification sound setting:", response.sound);

                if (!response || response.sound === true || response.sound === 1 || response.sound ===
                    undefined || response.sound === null) {
                    const audio = document.getElementById(audioId);
                    if (audio) {
                        audio.play().catch(function(error) {
                            console.warn("Audio playback failed:", error);
                        });
                    }
                }
            });



            const badge = document.getElementById('notification-count');
            const countBadge = document.getElementById('notif-count-badge');
            const notifList = document.getElementById('notif-list');

            if (!badge) {
                badge = document.createElement('span');
                badge.id = 'notification-count';
                badge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-circle';
                badge.style.marginLeft = '-11px';
                badge.style.padding = '3px 6px';
                badge.style.backgroundColor = '#dc3545';
                badge.style.color = 'white';


                const notifLink = document.getElementById('drop2');
                if (notifLink) {
                    notifLink.appendChild(badge);
                }
            }

            const currentValue = badge.innerText.trim();


            let newValue;
            if (currentValue === '+99') {
                newValue = '+99';
            } else {
                const currentNumber = parseInt(currentValue) || 0;
                newValue = currentNumber + 1 > 99 ? '+99' : currentNumber + 1;
            }


            badge.innerText = newValue;
            badge.style.display = 'inline-block';

            if (countBadge) {
                countBadge.innerText = `${newValue} new`;
            }

            let iconHtml = '';
            console.log(data.payload.source);
            switch (data.payload.source) {
                case 'lightfunnels':
                    iconHtml = `<img src="/plateformes/lightlogo.png" style="width: 24px; height: 24px;">`;
                    break;
                case 'youcan':
                    iconHtml = `<img src="/youcanlogo2.webp" style="width: 24px; height: 24px;">`;
                    break;
                case 'woocommerce':
                    iconHtml =
                        `<img src="/plateformes/woocommerce-logo.png" style="width: 24px; height: 24px;">`;
                    break;
                default:
                    iconHtml = `<iconify-icon icon="solar:widget-3-line-duotone" class="fs-6"></iconify-icon>`;
            }



            const time = new Date(data.time).toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });


            const notificationItem = document.querySelector(`.notification-item[data-index="${index}"]`);
            if (notificationItem) {
                notificationItem.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }

            const unreadCount = document.querySelectorAll('.notification-item[data-is-read="0"]').length;
            if (unreadCount > 0) {
                countBadge.innerText = `${unreadCount} new`;
            } else {
                countBadge.innerText = '';
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            const toggleBtn = document.getElementById("notification-toggle");
            const dropdown = document.getElementById("notification-dropdown");

            toggleBtn.addEventListener("click", function(e) {
                e.stopPropagation();
                const isVisible = dropdown.style.display === "block";
                dropdown.style.display = isVisible ? "none" : "block";
                if (!isVisible) {

                }
            });


            document.addEventListener("click", function() {
                dropdown.style.display = "none";
            });


            dropdown.addEventListener("click", function(e) {
                e.stopPropagation();
            });
        });

        function closeDropdown() {
            document.getElementById("notification-dropdown").style.display = "none";
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#mark-all-read').on('click', function() {
                let unreadNotificationIds = [];

                $('.notification-item').each(function() {
                    if ($(this).data('is-read') == 0) {
                        unreadNotificationIds.push($(this).data('notification-id'));
                    }
                });

                if (unreadNotificationIds.length > 0) {
                    $.ajax({
                        url: '{{ route('notifications.markAllAsRead') }}',
                        method: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            notifications: unreadNotificationIds
                        },
                        success: function(response) {
                            $('#notif-list').html('');
                            $('#notification-count').text('0');
                            $('#notification-count').hide();
                            $('#notif-count-badge').text('0 new');

                        },
                        error: function(xhr, status, error) {
                            alert('Something went wrong, please try again.');
                        }
                    });
                } else {
                    alert('No unread notifications to mark as read.');
                }
            });


        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('notification-toggle');
            const dropdown = document.getElementById('notification-dropdown');


            document.addEventListener('click', function(event) {
                if (!toggle.contains(event.target)) {
                    dropdown.style.display = 'none';
                }
            });

        });
    </script>


    <script>
        $(document).ready(function() {
            $('#notification-toggle > a').on('click', function() {
                $.ajax({
                    url: "{{ route('notifications.fetch') }}",
                    method: "GET",
                    success: function(response) {
                        if (response.count > 0) {
                            console.log('yeeh')
                            $('#mark-all-read').show();
                            $('.notif-not-found').hide();
                        } else {
                            console.log('yeehhhhhh')
                            $('#mark-all-read').hide();
                            $('.notif-not-found').show();
                        }

                        $('#notification-dropdown').show();
                    },
                    error: function() {
                        console.error('Failed to fetch notifications');
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.load-notifications').on('click', function() {
                $('.notif-list').load('{{ route('notifications.list') }}');
            });
        });
    </script>

    @yield('script')
</body>

</html>
