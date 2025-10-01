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
    <style>
       

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
                    <td>Total orders Delivered</td>

                    <td>{{ $invoice->total_delivered }} </td>
                </tr>
                <tr>
                    <td>Comission Amount</td>

                    <td>{{ number_format((float) $invoice->amount, 2) }} {{ $currency->currency }} </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- / Layout wrapper -->

   

</body>

</html>
