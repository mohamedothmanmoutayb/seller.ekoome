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
    <title>Ekoome Platform - Billets d&#039;impression</title>
    <!-- Main Fest file -->
    <!-- Argon CSS -->
    <!-- Custom CSS -->
    <link type="text/css" href="{{ asset('public/assets/app.css')}}" rel="stylesheet">
    <style scope="pdf-viewer-shared-style">#content {
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
    <style scope="cr-hidden-style">[hidden], :host([hidden]) {
  display: none !important;
}

</style>
    <style include="pdf-viewer-shared-style cr-hidden-style" scope="pdf-viewer">:host {
  --viewer-pdf-sidenav-width: 300px;
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 100%;
}

viewer-pdf-sidenav, viewer-toolbar {
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
    <?php $counter = 1 ;?>
        @foreach($imports as $leadds)
        <div class="col-12  page" style="margin-top: -32px !important;margin-left:-35px;">
                    <div class="col">
                        <table>
                            <tr>
                                <td style="width:130% !important">
                                    <img width="230" src="{{ asset('public/logo.jpg')}}" />
                                </td>
                                <td style="width:50% !important;margin-left:90px;">
                                    <h4>DECLARATION D'EXPEDITION</h4>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4>Date : <span>{{ $leadds['created_at']}}</span></h4>
                                    <h4 style="margin-top:-20px">Expéditeur : <span>{{ $user->name}} @if(!empty( $user->code)) / [{{ $user->code}}] @endif</span></h4>
                                    <h4 style="margin-top:-20px">Telephone : <span>{{ $user->telephone}}</span></h4>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col">
                        <table class="table table-bordered" style="width:120%">
                            <tr>
                                <td>
                                    Product : 
                                        @foreach($leadds['products'] as $v_product)
                                            {{ $v_product['name']}}
                                        @endforeach
                                </td>
                                <td>
                                    Quantity : <span>{{$leadds['quantity_sent']}}</span>
                                </td>
                                <td>
                                    Warehouse : <span>
                                        @foreach($leadds['countries'] as $v_country)
                                        {{$v_country['name']}}
                                        @endforeach</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Shipping Country : {{ $leadds['shipping_country']}}
                                </td>
                                <td>
                                    NBR Packages : <span>{{$leadds['nbr_packges']}}</span>
                                </td>
                                <td>
                                    Wight : <span>{{ $leadds['weight']}} Kg</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Expidition Mode : {{ $leadds['expidition_mode']}}
                                </td>
                                <td>
                                    Expidition Date : <span>{{$leadds['expidtion_date']}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Name Shipper : {{ $leadds['name_shipper']}}
                                </td>
                                <td>
                                    Phone Shipper : <span>{{$leadds['phone_shipper']}}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
        </div>    
<style>
    
    .order-ticket{
        margin-left: auto;
        margin-right: auto;
        border: solid 0px !important;
    }
</style>
<?php $counter ++; ?>
        @endforeach   
</div>  


<script src="https://cdn.jsdelivr.net/jsbarcode/3.6.0/JsBarcode.all.min.js"></script>


</body>
</html>