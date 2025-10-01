<style>
    .shadow {
        box-shadow: 0 3px 12px 1px rgba(43, 55, 72, 0.15) !important;
    }

    .bg-secondar {
        box-shadow: 0 3px 12px 1px rgba(43, 55, 72, 0.15) !important;
    }
</style>
<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('/public/assets/') }}" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard - Palace Agency </title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/public/grafico.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https:/fonts.googleapis.com" />
    <link rel="preconnect" href="https:/fonts.gstatic.com" crossorigin />
    <link
        href="https:/fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    {{-- <link rel="stylesheet" href="{{ asset('/public/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('/public/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('/public/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('/public/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('/public/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/pickr/pickr-themes.css') }}" />

    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Toastr -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('/public/assets/vendor/css/pages/cards-advance.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('/public/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('/public/assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('/public/assets/js/config.js') }}"></script> --}}
    <style>
        /* .table-responsive {
            min-height: 400px;
        }

        .form-select-lg {
            padding-top: 0 !important;
            padding-bottom: 0.594rem !important;
            padding-left: 1rem !important;
            font-size: 0.950rem !important;
            border-radius: 0.5rem;
        }

        .position-relative {
            width: 100%;
        }

        .my-active>.page-link {
            background-color: #ff5749;
            color: #fff;
        }

        .bg-label-noanswer {
            background-color: #ffec8b !important;
            color: #d2af01;
        }

        .bg-label-duplicated {
            background-color: #fbdc17 !important;
            background-color: #fbdc17 !important;
        }

        .bg-label-outofstock {
            background-color: #f6d5ad !important;
            background-color: #fe8d03 !important;
        }

        .bg-label-rejected {
            background-color: #ff8482 !important;
            background-color: #ff1814 !important;
        }

        .bg-label-wrong {
            background-color: #f6d5ad !important;
            background-color: #fc9f2d !important;
        }

        .bg-label-info {
            background-color: #d9f8fc !important;
            color: #00cfe8 !important;
        }

        .bg-label-warning {
            background-color: #fff1e3 !important;
            color: #ff9f43 !important;
        }

        .bg-label-danger {
            background-color: #fce5e6 !important;
            color: #ea5455 !important;
        }

        .video {
            background-color: #ff1500 !important;
            border-color: #feca3f !important;
        }

        .css1 {
            font-size: 20px;
            font-family: century-gothic, sans-serif;
            font-style: italic;
            font-weight: bold;
            color: black;
            text-shadow: 2px 2px 8px #FF0000;
        } */


        .invoice-box {
            max-width: 890px;
            margin: auto;
            padding: 10px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 14px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box .billing {
            width: 100%;
            line-height: inherit;
            border: solid 1px #ccc;
            border-collapse: collapse;
        }
        .billing tr{
          border: 1px solid #ddd;
        }
        .billing th{
          border: 1px solid #ddd;
        }
        /* .billing td{
          border: 1px solid #ddd;
        } */
        .invoice-box .informations {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .invoice-box .informations .invoiceinformations {
            width: 50%;

        }

        .invoice-box .informations .costumerinformations {
            width: 50%;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <!-- Layout wrapper -->

    <div class="invoice-box">
        <div class="informations" style="display: flex; justify-content: space-between;">
            <table style="width: 100%">
                <tr>
                    <td style="width: 50%">
                        
                            <h3>INVOICE</h3>
                            <div class="">
                                <img width="100" src="https://admin.ecomfulfilment.eu/public/logo.png"
                                    alt="logo">
                                <h3>Invoice Information</h3>
                                <span>Transaction date: {{ $invoice->transaction ?? 'not Defined' }}</span><br>
                                <span>No Invoice: #{{ $invoice->ref ?? 'not Defined' }}</span><br>
                                <span>Number of orders: {{ $colierfact->count() ?? 'not Defined' }}</span>
                            </div>
                       
                    </td>

                    <td style="width: 50%">
                    
                            <h3>Customer information / business</h3>
                            <span>Full name: {{ $user->name }}</span><br>
                            <span>Email: {{ $user->email }}</span><br>
                            <span>Bank Account: {{ $user->bank }}</span><br>
                            <span>Bank RIB: {{ $user->rib }}</span><br>
                            <h3>Company information / business</h3>
                            <span>Full name: {{ $parameter->app_name ?? 'not Defined' }}</span><br>
                            <span>Country: {{ $parameter->country ?? 'not Defined' }}</span><br>
                            <span>City: {{ $parameter->city ?? 'not Defined' }}</span><br>
                            <span>Address: {{ $parameter->address ?? 'not Defined' }}</span><br>
                            <span>Email: {{ $parameter->email ?? 'not Defined' }}</span><br>
                            <span>VAT: {{ $parameter->vat_number ?? 'not Defined' }}</span><br>
                       
                    </td>
                </tr>

            </table>


        </div>
        <div class="details">
            <h3>Billing orders</h3><br>
            <table class="billing">
                <tr>
                    <td>#</td>
                    <td>Total</td>
                    <td>Amount</td>
                </tr>
                <tr>
                    <td colspan="3">
                      <h3>Products:</h3>
                    </td>
                  
                </tr>
                @foreach ($products as $product)
                    <tr>
                  <td>{{$product->product_name}}</td>
                  <td>{{ $product->quantity}}</td>
                  <td>{{ $product->quantity * $product->price }} {{ $currency->currency}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>

    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    {{-- <script src="{{ asset('/public/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('/public/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('/public/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('/public/assets/vendor/libs/node-waves/node-waves.js') }}"></script>

    <script src="{{ asset('/public/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('/public/assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('/public/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

    <script src="{{ asset('/public/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Flat Picker -->
    <script src="{{ asset('/public/assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('/public/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('/public/assets/js/main.js') }}"></script>


    <!-- Page JS -->
    <script src="{{ asset('/public/assets/js/forms-pickers.js') }}"></script>


    <!-- Vendors JS -->
   
    <script src="{{ asset('/public/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('/public/assets/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('/public/assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>

    <script src="{{ asset('/public/assets/js/forms-selects.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}

</body>

</html>
