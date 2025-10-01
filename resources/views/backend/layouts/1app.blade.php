<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="tivo admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Tivo admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ asset('public/ECOM HUB icon.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('public/ECOM HUB icon.png')}}" type="image/x-icon">
    <title>Ecom Hub Platform - Ecommerce Platform  </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/font-awesome.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/icofont.css')}}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/themify.css')}}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/flag-icon.css')}}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/daterange-picker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/feather-icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/scrollbar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/chartist.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/date-picker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/owlcarousel.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/prism.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/vector-map.css')}}">
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/vendors/bootstrap.css')}}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/style.css')}}">
    <link id="color" rel="stylesheet" href="{{ asset('public/assets/css/color-1.css')}}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/css/responsive.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Toastr -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @yield('css')
    <style>
      .btn {
        font-weight: 600;
        border-radius: 7px !important;
      }
      .sidebar-list:hover{
        background-color: #0055ff;
        border-radius: 7px !important;
      }
      .btn-primary:hover{
        background-color: #013fbd !important;
        border-color: #013fbd !important;
      }
      .simplebar-content{
        padding: 24px 20px;margin: -6px;
      }
    </style>
  </head>
  <body>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"> </div>
      <div class="dot"></div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
      <div class="page-header">
        <div class="header-wrapper row m-0">
          <div class="header-logo-wrapper col-auto p-0">
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
            <div class="logo-header-main"><a href="{{ route('home')}}"><img class="img-fluid for-light img-100" src="{{ asset('public/ECOM HUB whiyte lue.png')}}" alt=""><img class="img-fluid for-dark" src="{{ asset('public/ECOM HUB whiyte lue.png')}}" alt=""></a></div>
          </div>
          <div class="left-header col horizontal-wrapper ps-0">
            <div class="left-menu-header">
            </div>
          </div>
          <div class="nav-right col-1 pull-right right-header p-0">
            <ul class="nav-menus">
              <li>
                <div class="mode"><i class="fa fa-moon-o"></i></div>
              </li>
              <li class="maximize"><a href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize-2"></i></a></li>
              
              <?php
              $country = DB::table('countries')
                  ->where('id', Auth::user()->country_id)
                  ->first();
              $countries = DB::table('countries')->get();
              ?>
              <li class="language-nav">
                <div class="translate_wrapper">
                  <div class="current_lang">
                    <div class="lang"><i data-feather="globe"></i></div>
                  </div>
                  <div class="more_lang">
                    @foreach($countries as $v_country)
                    <div class="lang selected" data-value="en" href="{{ route('countries', $v_country->id) }}"><i class="flag-icon flag-icon-{{ $v_country->flag }}"></i><span class="lang-txt">{{ $v_country->name }}<span> ({{ $v_country->flag }})</span></span></div>
                    @endforeach
                  </div>
                </div>
              </li>
              <li class="profile-nav onhover-dropdown">
                <div class="account-user"><i data-feather="user"></i></div>
                <ul class="profile-dropdown onhover-show-div">
                  <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" aria-expanded="false"><i class="ti ti-logout me-2 ti-sm"></i><form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form> 
                    <i data-feather="log-in"> </i><span>Logout</span></a></li>
                </ul>
              </li>
            </ul>
          </div>
          <script class="result-template" type="text/x-handlebars-template">
            <div class="ProfileCard u-cf">                        
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details">
            <div class="ProfileCard-realName"></div>
            </div>
            </div>
          </script>
          <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
        </div>
      </div>
      <!-- Page Header Ends-->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <div class="sidebar-wrapper">
          <div>
            <div class="logo-wrapper"><a href="{{ route('home')}}"><img class="img-fluid for-light" src="{{ asset('public/ECOM HUB whiyte lue.png')}}" alt=""></a>
              <div class="back-btn"><i data-feather="grid"></i></div>
              {{-- <div class="toggle-sidebar icon-box-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div> --}}
            </div>
            <div class="logo-icon-wrapper"><a href="{{ route('home')}}">
                <div class="icon-box-sidebar"><i data-feather="grid"></i></div></a></div>
            <nav class="sidebar-main">
              <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
              <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                  <li class="back-btn">
                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                  </li>
                  <li class="pin-title sidebar-list">
                    <h6>Pinned</h6>
                  </li>
                  <hr>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('home')}}"><i data-feather="home"> </i><span>Dashboard</span></a></li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('leads.index')}}"><svg viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M687.7 833.8h-76.8c-16.6 0-30-13.4-30-30s13.4-30 30-30h76.8c16.6 0 30 13.4 30 30s-13.4 30-30 30zM480.7 833.8H136.8c-16.6 0-30-13.4-30-30s13.4-30 30-30h343.9c16.6 0 30 13.4 30 30s-13.4 30-30 30z" fill="#ffffff"></path><path d="M880.8 931H207.9c-25.3 0-45.9-20.7-45.9-45.9 0-25.3 20.7-45.9 45.9-45.9h672.9c25.3 0 45.9 20.7 45.9 45.9S906 931 880.8 931z" fill="#ffffff"></path><path d="M703 122.7c20.9 0 40.6 8.2 55.5 23.2 14.9 14.9 23.2 34.7 23.2 55.5v2.8l0.3 2.8 57.7 611.8c-0.6 20-8.8 38.7-23.1 53.1-14.9 14.9-34.7 23.2-55.5 23.2H236c-20.9 0-40.6-8.2-55.5-23.2-14.4-14.4-22.6-33.2-23.1-53.2l54.7-612 0.2-2.7v-2.7c0-20.9 8.2-40.6 23.2-55.5 14.9-14.9 34.7-23.2 55.5-23.2h412m0-59.9H291c-76.3 0-138.7 62.4-138.7 138.7l-55 615c0 76.3 62.4 138.7 138.7 138.7h525c76.3 0 138.7-62.4 138.7-138.7l-58-615c0-76.3-62.4-138.7-138.7-138.7z" fill="#ffffff"></path><path d="M712.6 228.8c0-24.9-20.1-45-45-45s-45 20.1-45 45c0 13.5 6 25.6 15.4 33.9-0.3 1.6-0.4 3.3-0.4 5v95.9c0 23.5-9.2 45.7-26 62.5-16.8 16.8-39 26-62.5 26h-88.5c-23.5 0-45.7-9.2-62.5-26-16.8-16.8-26-39-26-62.5v-95.9c0-1.7-0.1-3.4-0.4-5 9.4-8.2 15.4-20.4 15.4-33.9 0-24.9-20.1-45-45-45s-45 20.1-45 45c0 13.5 6 25.6 15.4 33.9-0.3 1.6-0.4 3.3-0.4 5v95.9c0 81.9 66.6 148.6 148.6 148.6h88.5c81.9 0 148.6-66.6 148.6-148.6v-95.9c0-1.7-0.1-3.4-0.4-5 9.3-8.3 15.2-20.4 15.2-33.9z" fill="#ffffff"></path></g></svg><span>Leads</span></a></li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('orders.index')}}"><svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M2 1C1.44772 1 1 1.44772 1 2C1 2.55228 1.44772 3 2 3H3.21922L6.78345 17.2569C5.73276 17.7236 5 18.7762 5 20C5 21.6569 6.34315 23 8 23C9.65685 23 11 21.6569 11 20C11 19.6494 10.9398 19.3128 10.8293 19H15.1707C15.0602 19.3128 15 19.6494 15 20C15 21.6569 16.3431 23 18 23C19.6569 23 21 21.6569 21 20C21 18.3431 19.6569 17 18 17H8.78078L8.28078 15H18C20.0642 15 21.3019 13.6959 21.9887 12.2559C22.6599 10.8487 22.8935 9.16692 22.975 7.94368C23.0884 6.24014 21.6803 5 20.1211 5H5.78078L5.15951 2.51493C4.93692 1.62459 4.13696 1 3.21922 1H2ZM18 13H7.78078L6.28078 7H20.1211C20.6742 7 21.0063 7.40675 20.9794 7.81078C20.9034 8.9522 20.6906 10.3318 20.1836 11.3949C19.6922 12.4251 19.0201 13 18 13ZM18 20.9938C17.4511 20.9938 17.0062 20.5489 17.0062 20C17.0062 19.4511 17.4511 19.0062 18 19.0062C18.5489 19.0062 18.9938 19.4511 18.9938 20C18.9938 20.5489 18.5489 20.9938 18 20.9938ZM7.00617 20C7.00617 20.5489 7.45112 20.9938 8 20.9938C8.54888 20.9938 8.99383 20.5489 8.99383 20C8.99383 19.4511 8.54888 19.0062 8 19.0062C7.45112 19.0062 7.00617 19.4511 7.00617 20Z" fill="#ffffff"></path> </g></svg><span class="">Orders</span></a></li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('stores.index')}}"><svg viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>product-management</title> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="icon" fill="#ffffff" transform="translate(42.666667, 34.346667)"> <path d="M426.247658,366.986259 C426.477599,368.072636 426.613335,369.17172 426.653805,370.281095 L426.666667,370.986667 L426.666667,392.32 C426.666667,415.884149 383.686003,434.986667 330.666667,434.986667 C278.177524,434.986667 235.527284,416.264289 234.679528,393.025571 L234.666667,392.32 L234.666667,370.986667 L234.679528,370.281095 C234.719905,369.174279 234.855108,368.077708 235.081684,366.992917 C240.961696,371.41162 248.119437,375.487081 256.413327,378.976167 C275.772109,387.120048 301.875889,392.32 330.666667,392.32 C360.599038,392.32 387.623237,386.691188 407.213205,377.984536 C414.535528,374.73017 420.909655,371.002541 426.247658,366.986259 Z M192,7.10542736e-15 L384,106.666667 L384.001134,185.388691 C368.274441,181.351277 350.081492,178.986667 330.666667,178.986667 C301.427978,178.986667 274.9627,184.361969 255.43909,193.039129 C228.705759,204.92061 215.096345,223.091357 213.375754,241.480019 L213.327253,242.037312 L213.449,414.75 L192,426.666667 L-2.13162821e-14,320 L-2.13162821e-14,106.666667 L192,7.10542736e-15 Z M426.247658,302.986259 C426.477599,304.072636 426.613335,305.17172 426.653805,306.281095 L426.666667,306.986667 L426.666667,328.32 C426.666667,351.884149 383.686003,370.986667 330.666667,370.986667 C278.177524,370.986667 235.527284,352.264289 234.679528,329.025571 L234.666667,328.32 L234.666667,306.986667 L234.679528,306.281095 C234.719905,305.174279 234.855108,304.077708 235.081684,302.992917 C240.961696,307.41162 248.119437,311.487081 256.413327,314.976167 C275.772109,323.120048 301.875889,328.32 330.666667,328.32 C360.599038,328.32 387.623237,322.691188 407.213205,313.984536 C414.535528,310.73017 420.909655,307.002541 426.247658,302.986259 Z M127.999,199.108 L128,343.706 L170.666667,367.410315 L170.666667,222.811016 L127.999,199.108 Z M42.6666667,151.701991 L42.6666667,296.296296 L85.333,320.001 L85.333,175.405 L42.6666667,151.701991 Z M330.666667,200.32 C383.155809,200.32 425.80605,219.042377 426.653805,242.281095 L426.666667,242.986667 L426.666667,264.32 C426.666667,287.884149 383.686003,306.986667 330.666667,306.986667 C278.177524,306.986667 235.527284,288.264289 234.679528,265.025571 L234.666667,264.32 L234.666667,242.986667 L234.808715,240.645666 C237.543198,218.170241 279.414642,200.32 330.666667,200.32 Z M275.991,94.069 L150.412,164.155 L192,187.259259 L317.866667,117.333333 L275.991,94.069 Z M192,47.4074074 L66.1333333,117.333333 L107.795,140.479 L233.373,70.393 L192,47.4074074 Z" id="Combined-Shape"> </path> </g> </g> </g></svg><span>Stores</span></a></li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('analytics')}}"><svg fill="#ffffff" viewBox="0 -64 640 640" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M624 352h-16V243.9c0-12.7-5.1-24.9-14.1-33.9L494 110.1c-9-9-21.2-14.1-33.9-14.1H416V48c0-26.5-21.5-48-48-48H112C85.5 0 64 21.5 64 48v48H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h272c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H40c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H8c-4.4 0-8 3.6-8 8v16c0 4.4 3.6 8 8 8h208c4.4 0 8 3.6 8 8v16c0 4.4-3.6 8-8 8H64v128c0 53 43 96 96 96s96-43 96-96h128c0 53 43 96 96 96s96-43 96-96h48c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zM160 464c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm320 0c-26.5 0-48-21.5-48-48s21.5-48 48-48 48 21.5 48 48-21.5 48-48 48zm80-208H416V144h44.1l99.9 99.9V256z"></path></g></svg><span>Statistics</span></a></li>
                  
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('users.index')}}"><svg viewBox="0 -0.5 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M14.875 7.375C14.875 8.68668 13.8117 9.75 12.5 9.75C11.1883 9.75 10.125 8.68668 10.125 7.375C10.125 6.06332 11.1883 5 12.5 5C13.8117 5 14.875 6.06332 14.875 7.375Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M17.25 15.775C17.25 17.575 15.123 19.042 12.5 19.042C9.877 19.042 7.75 17.579 7.75 15.775C7.75 13.971 9.877 12.509 12.5 12.509C15.123 12.509 17.25 13.971 17.25 15.775Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M19.9 9.55301C19.9101 10.1315 19.5695 10.6588 19.0379 10.8872C18.5063 11.1157 17.8893 11 17.4765 10.5945C17.0638 10.189 16.9372 9.57418 17.1562 9.03861C17.3753 8.50305 17.8964 8.1531 18.475 8.15301C19.255 8.14635 19.8928 8.77301 19.9 9.55301V9.55301Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M5.10001 9.55301C5.08986 10.1315 5.43054 10.6588 5.96214 10.8872C6.49375 11.1157 7.11072 11 7.52347 10.5945C7.93621 10.189 8.06278 9.57418 7.84376 9.03861C7.62475 8.50305 7.10363 8.1531 6.52501 8.15301C5.74501 8.14635 5.10716 8.77301 5.10001 9.55301Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M19.2169 17.362C18.8043 17.325 18.4399 17.6295 18.403 18.0421C18.366 18.4547 18.6705 18.8191 19.0831 18.856L19.2169 17.362ZM22 15.775L22.7455 15.8567C22.7515 15.8023 22.7515 15.7474 22.7455 15.693L22 15.775ZM19.0831 12.695C18.6705 12.7319 18.366 13.0963 18.403 13.5089C18.4399 13.9215 18.8044 14.226 19.2169 14.189L19.0831 12.695ZM5.91689 18.856C6.32945 18.8191 6.63395 18.4547 6.59701 18.0421C6.56007 17.6295 6.19567 17.325 5.78311 17.362L5.91689 18.856ZM3 15.775L2.25449 15.693C2.24851 15.7474 2.2485 15.8023 2.25446 15.8567L3 15.775ZM5.78308 14.189C6.19564 14.226 6.56005 13.9215 6.59701 13.5089C6.63397 13.0963 6.32948 12.7319 5.91692 12.695L5.78308 14.189ZM19.0831 18.856C20.9169 19.0202 22.545 17.6869 22.7455 15.8567L21.2545 15.6933C21.1429 16.7115 20.2371 17.4533 19.2169 17.362L19.0831 18.856ZM22.7455 15.693C22.5444 13.8633 20.9165 12.5307 19.0831 12.695L19.2169 14.189C20.2369 14.0976 21.1426 14.839 21.2545 15.8569L22.7455 15.693ZM5.78311 17.362C4.76287 17.4533 3.85709 16.7115 3.74554 15.6933L2.25446 15.8567C2.45496 17.6869 4.08306 19.0202 5.91689 18.856L5.78311 17.362ZM3.74551 15.8569C3.85742 14.839 4.76309 14.0976 5.78308 14.189L5.91692 12.695C4.08354 12.5307 2.45564 13.8633 2.25449 15.693L3.74551 15.8569Z" fill="#ffffff"></path> </g></svg><span>Users</span></a></li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javascript:void(0)"><svg viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path clip-rule="evenodd" d="M10 7.88974C11.1046 7.88974 12 6.98912 12 5.87814C12 4.76716 11.1046 3.86654 10 3.86654C8.89543 3.86654 8 4.76716 8 5.87814C8 6.98912 8.89543 7.88974 10 7.88974ZM10 6.5822C10.3866 6.5822 10.7 6.26698 10.7 5.87814C10.7 5.4893 10.3866 5.17408 10 5.17408C9.6134 5.17408 9.3 5.4893 9.3 5.87814C9.3 6.26698 9.6134 6.5822 10 6.5822Z" fill="#ffffff" fill-rule="evenodd"></path><path clip-rule="evenodd" d="M5.15 5.62669C5.15 3.0203 7.37393 1 10 1C12.6261 1 14.85 3.0203 14.85 5.62669C14.85 6.06012 14.8114 6.53528 14.7269 7.03578L18 7.8588L25.7575 5.90818C26.0562 5.83306 26.3727 5.90057 26.6154 6.09117C26.8581 6.28178 27 6.57423 27 6.88395V23.9826C27 24.4441 26.6877 24.8464 26.2425 24.9584L18.2425 26.97C18.0833 27.01 17.9167 27.01 17.7575 26.97L10 25.0193L2.24254 26.97C1.94379 27.0451 1.6273 26.9776 1.38459 26.787C1.14187 26.5964 1 26.3039 1 25.9942V8.89555C1 8.43402 1.3123 8.03172 1.75746 7.91978L5.2731 7.03578C5.18863 6.53528 5.15 6.06012 5.15 5.62669ZM10 2.70986C8.20779 2.70986 6.85 4.06691 6.85 5.62669C6.85 7.21686 7.5125 9.57287 9.40979 11.3615C9.74241 11.6751 10.2576 11.6751 10.5902 11.3615C12.4875 9.57287 13.15 7.21686 13.15 5.62669C13.15 4.06691 11.7922 2.70986 10 2.70986ZM5.80904 8.97453L3.22684 9.62382C3.09349 9.65735 3 9.77726 3 9.91476V24.3212C3 24.5165 3.18371 24.6598 3.37316 24.6121L8.77316 23.2543C8.90651 23.2208 9 23.1009 9 22.9634V13.2506C7.40353 12.024 6.39235 10.4792 5.80904 8.97453ZM11 13.2506V22.9634C11 23.1009 11.0935 23.2208 11.2268 23.2543L16.6268 24.6121C16.8163 24.6598 17 24.5165 17 24.3212V9.91477C17 9.77726 16.9065 9.65735 16.7732 9.62382L14.191 8.97453C13.6076 10.4792 12.5965 12.024 11 13.2506ZM25 22.9634C25 23.1009 24.9065 23.2208 24.7732 23.2543L19.3732 24.6121C19.1837 24.6598 19 24.5165 19 24.3212V9.91477C19 9.77726 19.0935 9.65736 19.2268 9.62382L24.6268 8.26599C24.8163 8.21835 25 8.36159 25 8.55693V22.9634Z" fill="#ffffff" fill-rule="evenodd"></path></g></svg><span class="lan">Locations</span></a>
                    <ul class="sidebar-submenu">
                        <li><a class="lan" href="{{ route('countries.index') }}">Countries</a></li>
                        <li><a class="lan" href="{{ route('cities.index') }}">Cities</a></li>
                    </ul>
                  </li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javascript:void(0)">
                    <svg fill="#ffffff" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M1581.235 734.118c0 217.976-177.317 395.294-395.294 395.294H960.06c-217.977 0-395.294-177.318-395.294-395.294V564.706h1016.47v169.412Zm225.883-282.353h-338.824V0h-112.941v451.765H790.647V0H677.706v451.765H338.882v112.94h112.942v169.413c0 280.207 228.028 508.235 508.235 508.235h56.47v395.294c0 93.402-76.009 169.412-169.411 169.412-93.403 0-169.412-76.01-169.412-169.412 0-155.633-126.72-282.353-282.353-282.353S113 1482.014 113 1637.647V1920h112.941v-282.353c0-93.402 76.01-169.412 169.412-169.412s169.412 76.01 169.412 169.412c0 155.633 126.72 282.353 282.353 282.353 155.746 0 282.353-126.72 282.353-282.353v-395.294h56.47c280.207 0 508.235-228.028 508.235-508.235V564.706h112.942V451.765Z" fill-rule="evenodd"></path> </g></svg><span class="lan">Integrations</span></a>
                    <ul class="sidebar-submenu">
                        <li><a class="lan" href="{{ route('last-mille.index') }}">Last Mille</a></li>
                        <li><a class="lan" href="{{ route('plateformes.index') }}">Platforme</a></li>
                    </ul>
                  </li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title" href="javascript:void(0)">
                    <svg fill="#ffffff" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M1581.235 734.118c0 217.976-177.317 395.294-395.294 395.294H960.06c-217.977 0-395.294-177.318-395.294-395.294V564.706h1016.47v169.412Zm225.883-282.353h-338.824V0h-112.941v451.765H790.647V0H677.706v451.765H338.882v112.94h112.942v169.413c0 280.207 228.028 508.235 508.235 508.235h56.47v395.294c0 93.402-76.009 169.412-169.411 169.412-93.403 0-169.412-76.01-169.412-169.412 0-155.633-126.72-282.353-282.353-282.353S113 1482.014 113 1637.647V1920h112.941v-282.353c0-93.402 76.01-169.412 169.412-169.412s169.412 76.01 169.412 169.412c0 155.633 126.72 282.353 282.353 282.353 155.746 0 282.353-126.72 282.353-282.353v-395.294h56.47c280.207 0 508.235-228.028 508.235-508.235V564.706h112.942V451.765Z" fill-rule="evenodd"></path> </g></svg><span class="lan">Expensses</span></a>
                    <ul class="sidebar-submenu">
                        <li><a class="lan" href="{{ route('last-mille.index') }}">Category Expensses</a></li>
                        <li><a class="lan" href="{{ route('plateformes.index') }}">List Expensses</a></li>
                    </ul>
                  </li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('reclamations.index')}}"><svg viewBox="0 0 32 32" id="svg5" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <defs id="defs2"></defs> <g id="layer1" transform="translate(-108,-388)"> <path d="m 115,408.01367 c -2.7527,0 -5,2.2473 -5,5 0,2.7527 2.2473,5 5,5 h 14 c 2.7527,0 5,-2.2473 5,-5 0,-2.7527 -2.2473,-5 -5,-5 z m 0,2 h 14 c 1.6793,0 3,1.32071 3,3 0,1.6793 -1.3207,3 -3,3 h -14 c -1.6793,0 -3,-1.3207 -3,-3 0,-1.67929 1.3207,-3 3,-3 z" id="path453585" style="color:#ffffff;fill:#ffffff;fill-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4.1;-inkscape-stroke:none"></path> <path d="m 131,399.01367 a 1,1 0 0 0 -1,1 1,1 0 0 0 1,1 1,1 0 0 0 1,-1 1,1 0 0 0 -1,-1 z" id="path453573" style="color:#ffffff;fill:#ffffff;fill-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4.1;-inkscape-stroke:none"></path> <path d="m 131,393.01367 a 1,1 0 0 0 -1,1 v 3 a 1,1 0 0 0 1,1 1,1 0 0 0 1,-1 v -3 a 1,1 0 0 0 -1,-1 z" id="path453567" style="color:#ffffff;fill:#ffffff;fill-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4.1;-inkscape-stroke:none"></path> <path d="m 131,390.01367 c -2.63036,0 -4.9293,1.46542 -6.125,3.6211 -0.90021,-0.4054 -1.87895,-0.62123 -2.875,-0.6211 -3.85415,0 -7,3.14586 -7,7 0,3.85415 3.14585,7 7,7 a 1.000105,1.000105 0 0 0 0.002,0 c 2.57139,-0.007 4.90293,-1.42397 6.11524,-3.625 0.88031,0.40064 1.85579,0.625 2.88281,0.625 3.85414,0 7,-3.14585 7,-7 0,-3.85413 -3.14586,-7 -7,-7 z m 0,2 c 2.77327,0 5,2.22674 5,5 0,2.77327 -2.22673,5 -5,5 -0.98421,0 -1.89849,-0.28178 -2.66992,-0.76758 a 1.000005,1.000005 0 0 0 -0.2461,-0.16601 C 126.82049,400.17503 126,398.69579 126,397.01367 c 0,-0.5237 0.081,-1.02855 0.22852,-1.50195 a 1.000005,1.000005 0 0 0 0.10546,-0.30078 c 0.71945,-1.87506 2.52941,-3.19727 4.66602,-3.19727 z m -9,3 c 0.75319,-10e-5 1.49281,0.17045 2.16602,0.49414 -0.10719,0.48532 -0.16602,0.98922 -0.16602,1.50586 0,2.1085 0.94381,4.00364 2.42773,5.28906 -0.84495,1.64398 -2.53896,2.70503 -4.42773,2.71094 -2.77326,0 -5,-2.22673 -5,-5 0,-2.77326 2.22674,-5 5,-5 z" id="path453555" style="color:#ffffff;fill:#ffffff;fill-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4.1;-inkscape-stroke:none"></path> </g> </g></svg><span>Reclamations</span></a></li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('invoices.index')}}"><svg fill="#ffffff" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3.677 32l0.885-0.193c0.276-0.057 0.552-0.113 0.828-0.167 0.421-0.083 0.849-0.167 1.271-0.244 0.323-0.057 0.641-0.109 0.964-0.172l0.072-0.021c0.333-0.057 0.663-0.12 0.996-0.156l1.619-0.24v-30.807h-0.057c-0.839 0.005-1.671 0.021-2.509 0.047-0.923 0.027-1.86 0.079-2.781 0.141-0.396 0.025-0.797 0.063-1.199 0.093h-0.057v31.708zM11.88 0.021v30.588c1.151-0.136 2.297-0.245 3.443-0.328 2.828-0.213 5.667-0.281 8.5-0.203 1.5 0.047 3 0.135 4.495 0.26v-28.333c-1.339-0.308-2.681-0.579-4.036-0.812-2.625-0.453-5.271-0.772-7.927-0.975-1.485-0.104-2.98-0.177-4.469-0.197zM26.235 19.749l-0.063-0.004-0.751-0.084c-1.864-0.192-3.739-0.323-5.609-0.385-1.875-0.063-3.749-0.041-5.629 0.021h-0.057c-0.063 0-0.12 0-0.183-0.021-0.136-0.041-0.26-0.099-0.355-0.197-0.172-0.183-0.249-0.423-0.208-0.663 0.011-0.083 0.036-0.14 0.073-0.223 0.036-0.057 0.083-0.136 0.135-0.177 0.057-0.057 0.12-0.099 0.193-0.141 0.083-0.036 0.161-0.057 0.24-0.077h0.119c0.261 0 0.521-0.021 0.761-0.021 1.859-0.041 3.697-0.041 5.557 0.036 1.921 0.084 3.823 0.224 5.719 0.443l0.203 0.021c0.057 0.021 0.115 0.021 0.177 0.036 0.14 0.063 0.26 0.141 0.344 0.245 0.057 0.057 0.093 0.136 0.135 0.219 0.043 0.079 0.063 0.156 0.063 0.24 0.021 0.219-0.063 0.437-0.219 0.599-0.063 0.063-0.125 0.099-0.183 0.14-0.061 0.043-0.14 0.057-0.219 0.079-0.041 0.021-0.063 0.021-0.119 0.021h-0.063zM26.281 16.136c-0.063 0-0.063 0-0.125-0.011l-0.74-0.095c-1.859-0.239-3.733-0.4-5.593-0.479-1.859-0.099-3.74-0.12-5.62-0.079l-0.063-0.020c-0.057-0.021-0.119-0.021-0.176-0.041-0.12-0.037-0.261-0.12-0.339-0.219-0.041-0.063-0.104-0.141-0.12-0.199-0.104-0.224-0.104-0.479 0.016-0.697 0.041-0.084 0.083-0.141 0.14-0.204 0.057-0.057 0.12-0.12 0.199-0.135 0.083-0.041 0.161-0.084 0.239-0.084l0.12-0.020 0.781-0.021c1.864-0.021 3.697 0.021 5.536 0.12 1.923 0.099 3.824 0.281 5.719 0.52l0.204 0.021 0.12 0.021c0.14 0.041 0.26 0.099 0.359 0.219 0.161 0.161 0.24 0.38 0.219 0.599 0 0.083-0.020 0.161-0.057 0.219-0.041 0.084-0.083 0.141-0.12 0.203-0.041 0.057-0.099 0.1-0.181 0.163-0.057 0.036-0.141 0.056-0.219 0.077l-0.12 0.021h-0.057zM26.281 12.521c-0.063 0-0.063 0-0.125-0.011l-0.74-0.104c-1.859-0.256-3.719-0.448-5.593-0.573-1.859-0.12-3.74-0.177-5.62-0.172h-0.063l-0.119-0.021c-0.079-0.020-0.141-0.047-0.219-0.088-0.199-0.125-0.339-0.339-0.381-0.583 0-0.084 0-0.163 0.021-0.24 0.021-0.084 0.041-0.156 0.079-0.229 0.041-0.073 0.104-0.136 0.161-0.193 0.099-0.099 0.239-0.167 0.38-0.197 0.063-0.016 0.12-0.021 0.183-0.021h0.76c1.916 0.011 3.839 0.084 5.735 0.229 1.859 0.141 3.697 0.344 5.541 0.609l0.197 0.027c0.063 0.011 0.084 0.011 0.12 0.025 0.079 0.027 0.161 0.063 0.219 0.109 0.084 0.043 0.141 0.1 0.183 0.163 0.041 0.061 0.079 0.135 0.12 0.213 0.083 0.208 0.057 0.443-0.041 0.635-0.037 0.073-0.079 0.141-0.141 0.199-0.099 0.099-0.219 0.167-0.359 0.197-0.037 0.016-0.057 0.016-0.12 0.021l-0.057 0.005zM26.281 8.907c-0.063 0-0.063 0-0.125-0.011l-0.74-0.12c-1.859-0.303-3.719-0.521-5.593-0.661-1.859-0.161-3.74-0.24-5.62-0.281h-0.063l-0.14-0.016c-0.079-0.020-0.151-0.063-0.219-0.099-0.073-0.041-0.131-0.104-0.188-0.161-0.047-0.063-0.088-0.141-0.124-0.197-0.027-0.084-0.048-0.163-0.057-0.245-0.021-0.24 0.067-0.495 0.239-0.656 0.099-0.099 0.235-0.167 0.376-0.204 0.056-0.015 0.119-0.015 0.176-0.015 0.256 0 0.505 0.005 0.761 0.011 1.916 0.041 3.828 0.151 5.739 0.328 1.849 0.156 3.693 0.395 5.527 0.697l0.183 0.021c0.052 0 0.067 0 0.119 0.015 0.084 0.027 0.147 0.063 0.219 0.104 0.063 0.037 0.12 0.1 0.168 0.157 0.119 0.181 0.176 0.4 0.14 0.62-0.021 0.083-0.041 0.14-0.084 0.223-0.041 0.057-0.099 0.136-0.161 0.177-0.099 0.1-0.219 0.161-0.359 0.204h-0.183zM5.385 8.224c-0.12 0-0.24-0.027-0.359-0.084-0.261-0.124-0.423-0.391-0.443-0.671 0-0.079 0.020-0.152 0.041-0.219 0.020-0.095 0.063-0.177 0.12-0.256 0.061-0.088 0.14-0.161 0.219-0.213 0.104-0.068 0.224-0.104 0.323-0.125l0.64-0.057c0.876-0.077 1.74-0.14 2.6-0.192h0.077c0.141 0.005 0.26 0.031 0.36 0.093 0.26 0.136 0.421 0.407 0.421 0.693 0 0.072-0.021 0.145-0.041 0.213-0.021 0.088-0.057 0.177-0.12 0.249-0.057 0.104-0.141 0.161-0.219 0.224-0.099 0.057-0.203 0.099-0.323 0.12-0.136 0.021-0.276 0.021-0.417 0.036-0.183 0.021-0.38 0.021-0.583 0.043l-1.557 0.119-0.38 0.043c-0.079 0.020-0.161 0.020-0.261 0.020zM26.26 5.292l-0.124-0.016-0.735-0.131c-1.865-0.312-3.745-0.567-5.62-0.755-1.86-0.183-3.74-0.297-5.62-0.36h-0.063l-0.12-0.025c-0.077-0.021-0.135-0.047-0.219-0.093-0.057-0.043-0.12-0.095-0.176-0.163-0.163-0.181-0.224-0.437-0.163-0.671 0.021-0.084 0.057-0.161 0.1-0.24 0.041-0.084 0.099-0.141 0.161-0.203 0.099-0.1 0.239-0.163 0.38-0.199 0.057-0.021 0.12-0.021 0.177-0.021l0.781 0.021c1.859 0.079 3.697 0.199 5.536 0.401 1.921 0.197 3.817 0.479 5.719 0.797l0.197 0.020c0.063 0 0.084 0 0.12 0.021 0.084 0.020 0.161 0.063 0.224 0.099 0.177 0.141 0.297 0.344 0.319 0.563 0.020 0.077 0 0.156-0.021 0.24 0 0.077-0.036 0.161-0.079 0.219-0.041 0.063-0.083 0.12-0.14 0.181-0.099 0.1-0.24 0.157-0.38 0.177l-0.115 0.021h-0.063zM5.364 4.265c-0.113 0-0.228-0.025-0.333-0.072-0.093-0.048-0.181-0.111-0.249-0.183-0.063-0.073-0.115-0.151-0.151-0.245-0.027-0.063-0.043-0.135-0.052-0.208-0.027-0.287 0.104-0.568 0.343-0.729 0.105-0.068 0.219-0.115 0.344-0.131 0.213-0.015 0.423-0.015 0.631-0.036 0.869-0.063 1.735-0.099 2.599-0.14h0.068c0.12 0.020 0.24 0.041 0.339 0.099 0.239 0.14 0.401 0.421 0.401 0.697 0 0.084-0.021 0.161-0.043 0.224-0.041 0.099-0.077 0.177-0.135 0.261-0.063 0.077-0.147 0.156-0.245 0.197-0.099 0.063-0.219 0.099-0.339 0.099-0.14 0.021-0.281 0.021-0.443 0.021l-0.599 0.041c-0.536 0.036-1.057 0.057-1.579 0.099l-0.4 0.021c-0.1 0.021-0.177 0.021-0.261 0.021z"></path> </g></svg><span>Invoices</span></a></li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('speends.index')}}"><svg fill="#ffffff" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3.677 32l0.885-0.193c0.276-0.057 0.552-0.113 0.828-0.167 0.421-0.083 0.849-0.167 1.271-0.244 0.323-0.057 0.641-0.109 0.964-0.172l0.072-0.021c0.333-0.057 0.663-0.12 0.996-0.156l1.619-0.24v-30.807h-0.057c-0.839 0.005-1.671 0.021-2.509 0.047-0.923 0.027-1.86 0.079-2.781 0.141-0.396 0.025-0.797 0.063-1.199 0.093h-0.057v31.708zM11.88 0.021v30.588c1.151-0.136 2.297-0.245 3.443-0.328 2.828-0.213 5.667-0.281 8.5-0.203 1.5 0.047 3 0.135 4.495 0.26v-28.333c-1.339-0.308-2.681-0.579-4.036-0.812-2.625-0.453-5.271-0.772-7.927-0.975-1.485-0.104-2.98-0.177-4.469-0.197zM26.235 19.749l-0.063-0.004-0.751-0.084c-1.864-0.192-3.739-0.323-5.609-0.385-1.875-0.063-3.749-0.041-5.629 0.021h-0.057c-0.063 0-0.12 0-0.183-0.021-0.136-0.041-0.26-0.099-0.355-0.197-0.172-0.183-0.249-0.423-0.208-0.663 0.011-0.083 0.036-0.14 0.073-0.223 0.036-0.057 0.083-0.136 0.135-0.177 0.057-0.057 0.12-0.099 0.193-0.141 0.083-0.036 0.161-0.057 0.24-0.077h0.119c0.261 0 0.521-0.021 0.761-0.021 1.859-0.041 3.697-0.041 5.557 0.036 1.921 0.084 3.823 0.224 5.719 0.443l0.203 0.021c0.057 0.021 0.115 0.021 0.177 0.036 0.14 0.063 0.26 0.141 0.344 0.245 0.057 0.057 0.093 0.136 0.135 0.219 0.043 0.079 0.063 0.156 0.063 0.24 0.021 0.219-0.063 0.437-0.219 0.599-0.063 0.063-0.125 0.099-0.183 0.14-0.061 0.043-0.14 0.057-0.219 0.079-0.041 0.021-0.063 0.021-0.119 0.021h-0.063zM26.281 16.136c-0.063 0-0.063 0-0.125-0.011l-0.74-0.095c-1.859-0.239-3.733-0.4-5.593-0.479-1.859-0.099-3.74-0.12-5.62-0.079l-0.063-0.020c-0.057-0.021-0.119-0.021-0.176-0.041-0.12-0.037-0.261-0.12-0.339-0.219-0.041-0.063-0.104-0.141-0.12-0.199-0.104-0.224-0.104-0.479 0.016-0.697 0.041-0.084 0.083-0.141 0.14-0.204 0.057-0.057 0.12-0.12 0.199-0.135 0.083-0.041 0.161-0.084 0.239-0.084l0.12-0.020 0.781-0.021c1.864-0.021 3.697 0.021 5.536 0.12 1.923 0.099 3.824 0.281 5.719 0.52l0.204 0.021 0.12 0.021c0.14 0.041 0.26 0.099 0.359 0.219 0.161 0.161 0.24 0.38 0.219 0.599 0 0.083-0.020 0.161-0.057 0.219-0.041 0.084-0.083 0.141-0.12 0.203-0.041 0.057-0.099 0.1-0.181 0.163-0.057 0.036-0.141 0.056-0.219 0.077l-0.12 0.021h-0.057zM26.281 12.521c-0.063 0-0.063 0-0.125-0.011l-0.74-0.104c-1.859-0.256-3.719-0.448-5.593-0.573-1.859-0.12-3.74-0.177-5.62-0.172h-0.063l-0.119-0.021c-0.079-0.020-0.141-0.047-0.219-0.088-0.199-0.125-0.339-0.339-0.381-0.583 0-0.084 0-0.163 0.021-0.24 0.021-0.084 0.041-0.156 0.079-0.229 0.041-0.073 0.104-0.136 0.161-0.193 0.099-0.099 0.239-0.167 0.38-0.197 0.063-0.016 0.12-0.021 0.183-0.021h0.76c1.916 0.011 3.839 0.084 5.735 0.229 1.859 0.141 3.697 0.344 5.541 0.609l0.197 0.027c0.063 0.011 0.084 0.011 0.12 0.025 0.079 0.027 0.161 0.063 0.219 0.109 0.084 0.043 0.141 0.1 0.183 0.163 0.041 0.061 0.079 0.135 0.12 0.213 0.083 0.208 0.057 0.443-0.041 0.635-0.037 0.073-0.079 0.141-0.141 0.199-0.099 0.099-0.219 0.167-0.359 0.197-0.037 0.016-0.057 0.016-0.12 0.021l-0.057 0.005zM26.281 8.907c-0.063 0-0.063 0-0.125-0.011l-0.74-0.12c-1.859-0.303-3.719-0.521-5.593-0.661-1.859-0.161-3.74-0.24-5.62-0.281h-0.063l-0.14-0.016c-0.079-0.020-0.151-0.063-0.219-0.099-0.073-0.041-0.131-0.104-0.188-0.161-0.047-0.063-0.088-0.141-0.124-0.197-0.027-0.084-0.048-0.163-0.057-0.245-0.021-0.24 0.067-0.495 0.239-0.656 0.099-0.099 0.235-0.167 0.376-0.204 0.056-0.015 0.119-0.015 0.176-0.015 0.256 0 0.505 0.005 0.761 0.011 1.916 0.041 3.828 0.151 5.739 0.328 1.849 0.156 3.693 0.395 5.527 0.697l0.183 0.021c0.052 0 0.067 0 0.119 0.015 0.084 0.027 0.147 0.063 0.219 0.104 0.063 0.037 0.12 0.1 0.168 0.157 0.119 0.181 0.176 0.4 0.14 0.62-0.021 0.083-0.041 0.14-0.084 0.223-0.041 0.057-0.099 0.136-0.161 0.177-0.099 0.1-0.219 0.161-0.359 0.204h-0.183zM5.385 8.224c-0.12 0-0.24-0.027-0.359-0.084-0.261-0.124-0.423-0.391-0.443-0.671 0-0.079 0.020-0.152 0.041-0.219 0.020-0.095 0.063-0.177 0.12-0.256 0.061-0.088 0.14-0.161 0.219-0.213 0.104-0.068 0.224-0.104 0.323-0.125l0.64-0.057c0.876-0.077 1.74-0.14 2.6-0.192h0.077c0.141 0.005 0.26 0.031 0.36 0.093 0.26 0.136 0.421 0.407 0.421 0.693 0 0.072-0.021 0.145-0.041 0.213-0.021 0.088-0.057 0.177-0.12 0.249-0.057 0.104-0.141 0.161-0.219 0.224-0.099 0.057-0.203 0.099-0.323 0.12-0.136 0.021-0.276 0.021-0.417 0.036-0.183 0.021-0.38 0.021-0.583 0.043l-1.557 0.119-0.38 0.043c-0.079 0.020-0.161 0.020-0.261 0.020zM26.26 5.292l-0.124-0.016-0.735-0.131c-1.865-0.312-3.745-0.567-5.62-0.755-1.86-0.183-3.74-0.297-5.62-0.36h-0.063l-0.12-0.025c-0.077-0.021-0.135-0.047-0.219-0.093-0.057-0.043-0.12-0.095-0.176-0.163-0.163-0.181-0.224-0.437-0.163-0.671 0.021-0.084 0.057-0.161 0.1-0.24 0.041-0.084 0.099-0.141 0.161-0.203 0.099-0.1 0.239-0.163 0.38-0.199 0.057-0.021 0.12-0.021 0.177-0.021l0.781 0.021c1.859 0.079 3.697 0.199 5.536 0.401 1.921 0.197 3.817 0.479 5.719 0.797l0.197 0.020c0.063 0 0.084 0 0.12 0.021 0.084 0.020 0.161 0.063 0.224 0.099 0.177 0.141 0.297 0.344 0.319 0.563 0.020 0.077 0 0.156-0.021 0.24 0 0.077-0.036 0.161-0.079 0.219-0.041 0.063-0.083 0.12-0.14 0.181-0.099 0.1-0.24 0.157-0.38 0.177l-0.115 0.021h-0.063zM5.364 4.265c-0.113 0-0.228-0.025-0.333-0.072-0.093-0.048-0.181-0.111-0.249-0.183-0.063-0.073-0.115-0.151-0.151-0.245-0.027-0.063-0.043-0.135-0.052-0.208-0.027-0.287 0.104-0.568 0.343-0.729 0.105-0.068 0.219-0.115 0.344-0.131 0.213-0.015 0.423-0.015 0.631-0.036 0.869-0.063 1.735-0.099 2.599-0.14h0.068c0.12 0.020 0.24 0.041 0.339 0.099 0.239 0.14 0.401 0.421 0.401 0.697 0 0.084-0.021 0.161-0.043 0.224-0.041 0.099-0.077 0.177-0.135 0.261-0.063 0.077-0.147 0.156-0.245 0.197-0.099 0.063-0.219 0.099-0.339 0.099-0.14 0.021-0.281 0.021-0.443 0.021l-0.599 0.041c-0.536 0.036-1.057 0.057-1.579 0.099l-0.4 0.021c-0.1 0.021-0.177 0.021-0.261 0.021z"></path> </g></svg><span>Speend Ads</span></a></li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="{{ route('guides.index')}}"><svg fill="#ffffff" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3.677 32l0.885-0.193c0.276-0.057 0.552-0.113 0.828-0.167 0.421-0.083 0.849-0.167 1.271-0.244 0.323-0.057 0.641-0.109 0.964-0.172l0.072-0.021c0.333-0.057 0.663-0.12 0.996-0.156l1.619-0.24v-30.807h-0.057c-0.839 0.005-1.671 0.021-2.509 0.047-0.923 0.027-1.86 0.079-2.781 0.141-0.396 0.025-0.797 0.063-1.199 0.093h-0.057v31.708zM11.88 0.021v30.588c1.151-0.136 2.297-0.245 3.443-0.328 2.828-0.213 5.667-0.281 8.5-0.203 1.5 0.047 3 0.135 4.495 0.26v-28.333c-1.339-0.308-2.681-0.579-4.036-0.812-2.625-0.453-5.271-0.772-7.927-0.975-1.485-0.104-2.98-0.177-4.469-0.197zM26.235 19.749l-0.063-0.004-0.751-0.084c-1.864-0.192-3.739-0.323-5.609-0.385-1.875-0.063-3.749-0.041-5.629 0.021h-0.057c-0.063 0-0.12 0-0.183-0.021-0.136-0.041-0.26-0.099-0.355-0.197-0.172-0.183-0.249-0.423-0.208-0.663 0.011-0.083 0.036-0.14 0.073-0.223 0.036-0.057 0.083-0.136 0.135-0.177 0.057-0.057 0.12-0.099 0.193-0.141 0.083-0.036 0.161-0.057 0.24-0.077h0.119c0.261 0 0.521-0.021 0.761-0.021 1.859-0.041 3.697-0.041 5.557 0.036 1.921 0.084 3.823 0.224 5.719 0.443l0.203 0.021c0.057 0.021 0.115 0.021 0.177 0.036 0.14 0.063 0.26 0.141 0.344 0.245 0.057 0.057 0.093 0.136 0.135 0.219 0.043 0.079 0.063 0.156 0.063 0.24 0.021 0.219-0.063 0.437-0.219 0.599-0.063 0.063-0.125 0.099-0.183 0.14-0.061 0.043-0.14 0.057-0.219 0.079-0.041 0.021-0.063 0.021-0.119 0.021h-0.063zM26.281 16.136c-0.063 0-0.063 0-0.125-0.011l-0.74-0.095c-1.859-0.239-3.733-0.4-5.593-0.479-1.859-0.099-3.74-0.12-5.62-0.079l-0.063-0.020c-0.057-0.021-0.119-0.021-0.176-0.041-0.12-0.037-0.261-0.12-0.339-0.219-0.041-0.063-0.104-0.141-0.12-0.199-0.104-0.224-0.104-0.479 0.016-0.697 0.041-0.084 0.083-0.141 0.14-0.204 0.057-0.057 0.12-0.12 0.199-0.135 0.083-0.041 0.161-0.084 0.239-0.084l0.12-0.020 0.781-0.021c1.864-0.021 3.697 0.021 5.536 0.12 1.923 0.099 3.824 0.281 5.719 0.52l0.204 0.021 0.12 0.021c0.14 0.041 0.26 0.099 0.359 0.219 0.161 0.161 0.24 0.38 0.219 0.599 0 0.083-0.020 0.161-0.057 0.219-0.041 0.084-0.083 0.141-0.12 0.203-0.041 0.057-0.099 0.1-0.181 0.163-0.057 0.036-0.141 0.056-0.219 0.077l-0.12 0.021h-0.057zM26.281 12.521c-0.063 0-0.063 0-0.125-0.011l-0.74-0.104c-1.859-0.256-3.719-0.448-5.593-0.573-1.859-0.12-3.74-0.177-5.62-0.172h-0.063l-0.119-0.021c-0.079-0.020-0.141-0.047-0.219-0.088-0.199-0.125-0.339-0.339-0.381-0.583 0-0.084 0-0.163 0.021-0.24 0.021-0.084 0.041-0.156 0.079-0.229 0.041-0.073 0.104-0.136 0.161-0.193 0.099-0.099 0.239-0.167 0.38-0.197 0.063-0.016 0.12-0.021 0.183-0.021h0.76c1.916 0.011 3.839 0.084 5.735 0.229 1.859 0.141 3.697 0.344 5.541 0.609l0.197 0.027c0.063 0.011 0.084 0.011 0.12 0.025 0.079 0.027 0.161 0.063 0.219 0.109 0.084 0.043 0.141 0.1 0.183 0.163 0.041 0.061 0.079 0.135 0.12 0.213 0.083 0.208 0.057 0.443-0.041 0.635-0.037 0.073-0.079 0.141-0.141 0.199-0.099 0.099-0.219 0.167-0.359 0.197-0.037 0.016-0.057 0.016-0.12 0.021l-0.057 0.005zM26.281 8.907c-0.063 0-0.063 0-0.125-0.011l-0.74-0.12c-1.859-0.303-3.719-0.521-5.593-0.661-1.859-0.161-3.74-0.24-5.62-0.281h-0.063l-0.14-0.016c-0.079-0.020-0.151-0.063-0.219-0.099-0.073-0.041-0.131-0.104-0.188-0.161-0.047-0.063-0.088-0.141-0.124-0.197-0.027-0.084-0.048-0.163-0.057-0.245-0.021-0.24 0.067-0.495 0.239-0.656 0.099-0.099 0.235-0.167 0.376-0.204 0.056-0.015 0.119-0.015 0.176-0.015 0.256 0 0.505 0.005 0.761 0.011 1.916 0.041 3.828 0.151 5.739 0.328 1.849 0.156 3.693 0.395 5.527 0.697l0.183 0.021c0.052 0 0.067 0 0.119 0.015 0.084 0.027 0.147 0.063 0.219 0.104 0.063 0.037 0.12 0.1 0.168 0.157 0.119 0.181 0.176 0.4 0.14 0.62-0.021 0.083-0.041 0.14-0.084 0.223-0.041 0.057-0.099 0.136-0.161 0.177-0.099 0.1-0.219 0.161-0.359 0.204h-0.183zM5.385 8.224c-0.12 0-0.24-0.027-0.359-0.084-0.261-0.124-0.423-0.391-0.443-0.671 0-0.079 0.020-0.152 0.041-0.219 0.020-0.095 0.063-0.177 0.12-0.256 0.061-0.088 0.14-0.161 0.219-0.213 0.104-0.068 0.224-0.104 0.323-0.125l0.64-0.057c0.876-0.077 1.74-0.14 2.6-0.192h0.077c0.141 0.005 0.26 0.031 0.36 0.093 0.26 0.136 0.421 0.407 0.421 0.693 0 0.072-0.021 0.145-0.041 0.213-0.021 0.088-0.057 0.177-0.12 0.249-0.057 0.104-0.141 0.161-0.219 0.224-0.099 0.057-0.203 0.099-0.323 0.12-0.136 0.021-0.276 0.021-0.417 0.036-0.183 0.021-0.38 0.021-0.583 0.043l-1.557 0.119-0.38 0.043c-0.079 0.020-0.161 0.020-0.261 0.020zM26.26 5.292l-0.124-0.016-0.735-0.131c-1.865-0.312-3.745-0.567-5.62-0.755-1.86-0.183-3.74-0.297-5.62-0.36h-0.063l-0.12-0.025c-0.077-0.021-0.135-0.047-0.219-0.093-0.057-0.043-0.12-0.095-0.176-0.163-0.163-0.181-0.224-0.437-0.163-0.671 0.021-0.084 0.057-0.161 0.1-0.24 0.041-0.084 0.099-0.141 0.161-0.203 0.099-0.1 0.239-0.163 0.38-0.199 0.057-0.021 0.12-0.021 0.177-0.021l0.781 0.021c1.859 0.079 3.697 0.199 5.536 0.401 1.921 0.197 3.817 0.479 5.719 0.797l0.197 0.020c0.063 0 0.084 0 0.12 0.021 0.084 0.020 0.161 0.063 0.224 0.099 0.177 0.141 0.297 0.344 0.319 0.563 0.020 0.077 0 0.156-0.021 0.24 0 0.077-0.036 0.161-0.079 0.219-0.041 0.063-0.083 0.12-0.14 0.181-0.099 0.1-0.24 0.157-0.38 0.177l-0.115 0.021h-0.063zM5.364 4.265c-0.113 0-0.228-0.025-0.333-0.072-0.093-0.048-0.181-0.111-0.249-0.183-0.063-0.073-0.115-0.151-0.151-0.245-0.027-0.063-0.043-0.135-0.052-0.208-0.027-0.287 0.104-0.568 0.343-0.729 0.105-0.068 0.219-0.115 0.344-0.131 0.213-0.015 0.423-0.015 0.631-0.036 0.869-0.063 1.735-0.099 2.599-0.14h0.068c0.12 0.020 0.24 0.041 0.339 0.099 0.239 0.14 0.401 0.421 0.401 0.697 0 0.084-0.021 0.161-0.043 0.224-0.041 0.099-0.077 0.177-0.135 0.261-0.063 0.077-0.147 0.156-0.245 0.197-0.099 0.063-0.219 0.099-0.339 0.099-0.14 0.021-0.281 0.021-0.443 0.021l-0.599 0.041c-0.536 0.036-1.057 0.057-1.579 0.099l-0.4 0.021c-0.1 0.021-0.177 0.021-0.261 0.021z"></path> </g></svg><span>Documenation</span></a></li>
                </ul>
              </div>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </nav>
          </div>
        </div>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          
          <!-- Container-fluid starts-->
          <div class="container-fluid dashboard-2">
            <div class="row">  
              @yield('content')
            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <footer class="footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 p-0 footer-left">
                <p class="mb-0">Copyright © 2024 Palace Agency. All rights reserved.</p>
              </div>
              <div class="col-md-6 p-0 footer-right">
                <p class="mb-0">Hand-crafted & made with <i class="fa fa-heart font-danger"></i></p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- latest jquery-->
    <script src="{{ asset('public/assets/js/jquery-3.6.0.min.js')}}"></script>
    <!-- Bootstrap js-->
    <script src="{{ asset('public/assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('public/assets/js/icons/feather-icon/feather.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/icons/feather-icon/feather-icon.js')}}"></script>
    <!-- scrollbar js-->
    <script src="{{ asset('public/assets/js/scrollbar/simplebar.js')}}"></script>
    <script src="{{ asset('public/assets/js/scrollbar/custom.js')}}"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('public/assets/js/config.js')}}"></script>
    <script src="{{ asset('public/assets/js/sidebar-menu.js')}}"></script>
    <script src="{{ asset('public/assets/js/chart/knob/knob.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/chart/knob/knob-chart.js')}}"></script>
    <script src="{{ asset('public/assets/js/chart/apex-chart/moment.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/chart/apex-chart/apex-chart.js')}}"></script>
    <script src="{{ asset('public/assets/js/prism/prism.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/clipboard/clipboard.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/counter/jquery.waypoints.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/counter/jquery.counterup.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/counter/counter-custom.js')}}"></script>
    <script src="{{ asset('public/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom-card/custom-card.js')}}"></script>
    <script src="{{ asset('public/assets/js/notify/bootstrap-notify.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/chart-widget.js') }}"></script>
    
    <script src="{{ asset('public/assets/js/vector-map/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/vector-map/map/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{ asset('public/assets/js/datepicker/date-picker/datepicker.js')}}"></script>
    <script src="{{ asset('public/assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
    <script src="{{ asset('public/assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
    <script src="{{ asset('public/assets/js/owlcarousel/owl.carousel.js')}}"></script>
    <script src="{{ asset('public/assets/js/notify/index.js')}}"></script>
    <script src="{{ asset('public/assets/js/typeahead/handlebars.js')}}"></script>
    <script src="{{ asset('public/assets/js/typeahead/typeahead.bundle.js')}}"></script>
    <script src="{{ asset('public/assets/js/typeahead/typeahead.custom.js')}}"></script>
    <script src="{{ asset('public/assets/js/typeahead-search/handlebars.js')}}"></script>
    <script src="{{ asset('public/assets/js/typeahead-search/typeahead-custom.js')}}"></script>
    <script src="{{ asset('public/assets/js/dashboard/dashboard_2.js')}}"></script>
    <script src="{{ asset('public/assets/js/datepicker/daterange-picker/moment.min.js')}}"></script>
    <script src="{{ asset('public/assets/js/datepicker/daterange-picker/daterangepicker.js')}}"></script>
    <script src="{{ asset('public/assets/js/datepicker/daterange-picker/daterange-picker.custom.js')}}"></script>
    <!-- Template js-->
    <script src="{{ asset('public/assets/js/script.js')}}"></script>
    <!-- login js-->
      @yield('script')
  </body>
</html>
