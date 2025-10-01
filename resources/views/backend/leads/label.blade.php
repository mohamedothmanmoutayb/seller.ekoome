<!--&&n&&t
    * Created by Youssef Souis
    * For Contact me this is my phone => 0707907648&&n&&t
    * My Facebook account => https://www.facebook.com/youssef-souis
-->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Youssef Souis">
    <meta name="csrf-token" content="wFS6Q5MVKRdP0Frjuxe5nGJXocNIdA2GlzZkVzPz">
    <title>FULFILLEMENT - Billets d&#039;impression</title>
    <!-- Main Fest file -->
    <!-- Argon CSS -->
    <!-- Custom CSS -->
    <link type="text/css" href="{{ asset('public/assets/app.css') }}" rel="stylesheet">
    <style scope="pdf-viewer-shared-style">
        #content {
            height: 100%;
            position: fixed;
            width: 100%;
            z-index: 1;
        }

        #plugin {
            display: block;
            height: 100%;
            position: absolute;
            width: 100%;
        }

        #sizer {
            position: absolute;
            z-index: 0;
        }
    </style>
    <style scope="cr-hidden-style">
        [hidden],
        :host([hidden]) {
            display: none !important;
        }
    </style>
    <style include="pdf-viewer-shared-style cr-hidden-style" scope="pdf-viewer">
        :host {
            --viewer-pdf-sidenav-width: 300px;
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%;
        }

        viewer-pdf-sidenav,
        viewer-toolbar {
            --pdf-toolbar-text-color: rgb(241, 241, 241);
        }

        viewer-toolbar {
            --active-button-bg: rgba(255, 255, 255, 0.24);
            z-index: 1;
        }

        @media(max-width: 200px), (max-height: 250px) {
            viewer-toolbar {
                display: none;
            }

        }

        #sidenav-container {
            overflow: hidden;
            transition: transform 250ms cubic-bezier(.6, 0, 0, 1), visibility 250ms;
            visibility: visible;
            width: var(--viewer-pdf-sidenav-width);
        }

        #sidenav-container.floating {
            bottom: 0;
            position: absolute;
            top: 0;
            z-index: 1;
        }

        #sidenav-container[closed] {
            transform: translateX(-100%);
            transition: transform 200ms cubic-bezier(.6, 0, 0, 1),
                visibility 200ms, width 0ms 200ms;
            visibility: hidden;
            width: 0;
        }

        :host-context([dir='rtl']) #sidenav-container[closed] {
            transform: translateX(100%);
        }

        @media(max-width: 500px), (max-height: 250px) {
            #sidenav-container {
                display: none;
            }

        }

        #content-focus-rectangle {
            border: 2px solid var(--google-grey-500);
            border-radius: 2px;
            box-sizing: border-box;
            height: 100%;
            pointer-events: none;
            position: absolute;
            top: 0;
            width: 100%;
        }

        viewer-ink-host {
            height: 100%;
            position: absolute;
            width: 100%;
        }

        #container {
            display: flex;
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        #plugin {
            position: initial;
        }

        #content {
            height: 100%;
            left: 0;
            position: sticky;
            top: 0;
            z-index: initial;
        }

        #sizer {
            top: 0;
            width: 100%;
            z-index: initial;
        }

        #main {
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        #scroller {
            direction: ltr;
            height: 100%;
            overflow: auto;
            position: relative;
        }

        #scroller:fullscreen {
            overflow: hidden;
        }
    </style>
    <!-- Quickly style from settings -->
    <style>
        @font-face {
            font-family: 'JS-Flat';
        }

        /*body {
            font-family: Poppins, JS-Flat !important;
            font-size: 14px;
            font-weight: 400;
            background: #fff;
        }*/
        * {
            color: #000;
        }

        hr {
            border-color: #000;
            border-style: dashed;
        }
    </style>
    <style media="print">
        body,
        embed,
        html {
            height: auto;
            margin: 0;
            width: 100%;
        }

        embed {
            left: 0;
            position: fixed;
            top: 0;
        }

        /* Hide scrollbars when in Presentation mode. */
        .fullscreen {
            overflow: hidden;
        }

        table {
            border-collapse: collapse !important;
            border: 1px solid !important;
        }
    </style>
</head>

<body>

    <div class="row  m-0 align-items-start  justify-content-center align-items-center" style="">
        <?php $counter = 1; ?>
        @foreach ($leads as $leadds)
            <div class="col-12  page" style="margin-top: -32px !important;margin-left:-35px;">
                <div class="col">
                    <table style="width:110% !important">

                        <tr style="min-hight:50%">
                            <td>
                                <img width="250" src="{{ asset('public/logo-dark.jpg') }}" />
                                <h3>N° Order : <span>{{ $leadds[0]['n_lead'] }}</span></h3>
                                <h4>Date Shipping : <span>{{ $leadds[0]['date_delivred'] }}</span></h4>
                                <!--<h4 style="margin-top:-20px">Expéditeur : <span>
                                @foreach ($leadds[0]['leadbyvendor'] as $v_user)
                                {{ $v_user['name'] }}
                                @endforeach
                                </span></h4>
                                                                    <h4 style="margin-top:-20px">Telephone : <span>
                                @foreach ($leadds[0]['leadbyvendor'] as $v_user)
                                {{ $v_user['telephone'] }}
                                @endforeach
                                </span></h4>-->
                            </td>
                            <td>
                                <div style="display: block;width: 100%;min-hight:500px">{!! DNS2D::getBarcodeHTML($leadds[0]['n_lead'], 'QRCODE') !!}</div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col">
                    <table class="table" style="width:107%">
                        <tr>
                            <td class="td">
                                Product :
                            </td>
                            <td class="td">
                                &nbsp; @foreach ($leadds[0]['leadproduct'] as $v_pr)
                                    @foreach ($v_pr['product'] as $v_product)
                                        {{ $v_product['name'] }} / QT : {{ $leadds[0]['leadproduct'][0]['quantity'] }}
                                        @if ($leadds[0]['leadproduct']->count() > 1)
                                            /
                                        @endif
                                    @endforeach
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td class="td">
                                Price :
                            </td>
                            <td class="td">
                                &nbsp; @if ($leadds[0]['ispaidapp'] == 1)
                                    0 CFA
                                @else
                                    {{ $leadds[0]['leadproduct']->sum('lead_value') }} CFA
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="td">
                                City:
                            </td>
                            <td class="td">
                                &nbsp;
                                @if (!empty($leadds[0]['cities'][0]['name']))
                                    {{ $leadds[0]['cities'][0]['name'] }}
                                @else
                                    {{ $leadds[0]['city'] }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="td">
                                Address :
                            </td>
                            <td class="td">
                                &nbsp; <a style=" font-size:12px;">{{ Str::limit($leadds[0]['address'], 55) }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="td">
                                Customer:
                            </td>
                            <td class="td">
                                &nbsp; {{ $leadds[0]['name'] }}
                            </td>
                        </tr>
                        <tr>
                            <td class="td">
                                Phone :
                            </td>
                            <td class="td" style="font-size: bold">
                                &nbsp;{{ $leadds[0]['phone'] }} @if (!empty($leadds[0]['phone']))
                                    / {{ $leadds[0]['phone2'] }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="td">
                                Note :
                            </td>
                            <td class="td">
                                &nbsp; <a style=" font-size:12px;">{{ $leadds[0]['note'] }}</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="td">
                                Zone :
                            </td>
                            <td class="td">
                                &nbsp; @foreach ($leadds[0]['zones'] as $v_zone)
                                    {{ $v_zone['name'] }}
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <style>
                .table,
                .th,
                .td {
                    border: 1px solid black;
                    border-collapse: collapse;
                }

                .order-ticket {
                    margin-left: auto;
                    margin-right: auto;
                    border: solid 0px !important;
                }
            </style>
            <?php $counter++; ?>
        @endforeach
    </div>


    <script src="https://cdn.jsdelivr.net/jsbarcode/3.6.0/JsBarcode.all.min.js"></script>


</body>

</html>
