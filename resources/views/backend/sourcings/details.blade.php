@extends('backend.layouts.app')
@section('content')
    <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="content-wrapper">

            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="page-breadcrumb">
                    <div class="row">
                        <div class="col-5 align-self-center">
                            <h4 class="page-title">Quotation #{{ $detail->ref}}</h4>
                            <div class="d-flex align-items-center">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Library</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="col-7 align-self-center">
                            <div class="d-flex no-block justify-content-end align-items-center">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <!-- Tabs -->
                                    <ul class="   mt-3 ml-2" id="pills-tab" role="tablist">
                                        <h5>Request No: <span> {{ $detail->ref}}</span></h5>
                                    
                                        <h5 class="">Request At: <span> {{ $detail->created_at}}</span></h5>
                                    </ul>
                                    <hr>
                                    <!-- Tabs -->
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                            <div class="card-body">
                                                <div class="profiletimeline mt-0">
                                                    <div class="sl-item">
                                                        <div class="sl-right">
                                                            <div><a  class="link">If you paid  today you will receive it at : </a> <strong class="sl-date">@if($detail->method_shipping == "AIR FREIGHT")<?php $date = \Carbon\Carbon::now()->addDays(15) ?> {{$date}} @elseif($detail->method_shipping == "RAIL FREIGHT") <?php $date = \Carbon\Carbon::now()->addDays(35) ?> {{$date}} @elseif($detail->method_shipping == "OCEAN FREIGHT") <?php $date = \Carbon\Carbon::now()->addDays(60) ?> {{$date}} @endif</strong>
                                                                <p> <strong>Status : </strong>  <a > {{ $detail->status_confirmation}}</a></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="container">
                                                        <div class="">
                                                            <div class="col-12 hh-grayBox pt45 pb20">
                                                                <div class="row justify-content-between">
                                                                    <div class="order-tracking pend">
                                                                        <span class="is-complete is-pendding mdi mdi-tag"></span>
                                                                        <p>Pending</p>
                                                                    </div>
                                                                    <div class="order-tracking completed pend">
                                                                        <span class="is-complete is-processing mdi mdi-settings"></span>
                                                                        <p>Proccessing<br></p>
                                                                    </div>
                                                                    <div class="order-tracking processing">
                                                                        <span class="is-complete is-packing mdi mdi-webpack"></span>
                                                                        <p>Packing<br></p>
                                                                    </div>
                                                                    <div class="order-tracking packing">
                                                                        <span class="is-complete is-shipped mdi mdi-truck-delivery"></span>
                                                                        <p>Shipped<br></p>
                                                                    </div>
                                                                    <div class="order-tracking shipped">
                                                                        <span class="is-complete is-delivered mdi mdi-home-map-marker"></span>
                                                                        <p>Delivered<br></p>
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
                            </div>
                            @if($detail->image)
                            <div class="col-12">
                                <div class="card">
                                    <!-- Tabs -->
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                            <div class="card-body">
                                                <div class="profiletimeline mt-0">
                                                    <div class="container">
                                                        <div class="">
                                                            <div class="col-12 hh-grayBox pt45 pb20">
                                                                <div class="col-4">
                                                                    <img src="{{$detail->image}}" style="width: 100%;"/>
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
                            @endif
                            @if($detail->document)
                            <div class="col-12">
                                <div class="card">
                                    <!-- Tabs -->
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                            <div class="card-body">
                                                <div class="profiletimeline mt-0">
                                                    <div class="container">
                                                        <div class="">
                                                            <div class="col-12 hh-grayBox pt45 pb20">
                                                                <div class="col-4">
                                                                    <img src="{{$detail->document}}" />
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
                            @endif
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <center class="mt-4">
                                    <div class="row">
                                        <h6 class="col-6">Destination Country : </h6><h6 class="col-6" >{{ $country->name}}</h6>
                                    </div>
                                    <div class="row mt-3">
                                        <h6 class="col-6">Shipping Method : </h6><h6 class="col-6">{{ $detail->method_shipping}}</h6>
                                    </div>
                                    <div class="row mt-3">
                                        <h6 class="col-6">Quantity : </h6><h6 class="col-6">{{ $detail->quantity}}</h6>
                                    </div>
                                    <div class="row mt-3">
                                        <h6 class="col-6">Unite Price : </h6><h6 class="col-6">{{ $detail->unite_price}}</h6>
                                    </div>
                                    
                                </center>
                            </div>
                            <div>
                                <hr> </div>
                            <div class="card-body">
                                <div class="row mt-3">
                                    <h6 class="">Total : </h6><h6 class=" "style="position: inherit;text-align: left;margin-left: 291px;">{{ $detail->total}}</h6>
                                </div>
                                @if($detail->status_payment != "paid")
                                <br/>
                                @if($detail->status_confirmation != "cancel")
                                <button class="col-12 btn btn-success" data-toggle="modal" data-target="#add-payment"> Pay Now</button>
                                @if($detail->status_confirmation != "confirmed" )
                                <a href="{{ route('sourcing.canceled', $detail->id)}}" class="col-12 btn btn-danger mt-2"> Cancel</a>
                                @endif
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
            <!-- create lead manule -->
            <div id="add-payment" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 720px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Paid Your Sourcing</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        </div>
                        <form class="form-horizontal form-material" action="{{ route('sourcing.paid')}}" method="post" enctype="multipart/form-data" novalidate="novalidate">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 m-b-20">
                                            <input type="hidden" value="{{$id}}" name="id" />
                                            <input type="file" class="form-control" name="screen" placeholder="File Payment">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary waves-effect" >Save</button>
                                <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            </div>

            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="content-footer footer bg-footer-theme">
                <div class="container-xxl">
                    <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                        <div>
                            ©
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            , made with ❤️ by <a href="https://Palace Agency.eu" target="_blank" class="fw-semibold">Palace Agency</a>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <style>
        .hh-grayBox {
	background-color: #F8F8F8;
	margin-bottom: 20px;
	padding: 35px;
  margin-top: 20px;
}
.pt45{padding-top:45px;}
.order-tracking{
	text-align: center;
	width: 19.33%;
	position: relative;
	display: block;
}
.order-tracking .is-complete{
	display: block;
	position: relative;
	border-radius: 50%;
	height: 30px;
	width: 30px;
	border: 0px solid #AFAFAF;
	background-color: #f7be16;
	margin: 0 auto;
	transition: background 0.25s linear;
	-webkit-transition: background 0.25s linear;
	z-index: 2;
}
.order-tracking .is-complete:after {
	display: block;
	position: absolute;
	/* content: ''; */
	height: 14px;
	width: 7px;
	top: -2px;
	bottom: 0;
	left: 5px;
	margin: auto 0;
	border: 0px solid #AFAFAF;
	border-width: 0px 2px 2px 0;
	transform: rotate(45deg);
	opacity: 0;
}
.order-tracking.completed .is-complete{
	border-color: #555555;
	border-width: 0px;
	background-color: #555555;
}
.order-tracking.completed .is-processing{
	border-color: #555555;
	border-width: 0px;
	background-color: #555555;
}
.order-tracking.completed .is-pendding{
	border-color: #f7be16;
	border-width: 0px;
	background-color: #f7be16;
}
.order-tracking.completed .is-packing{
	border-color: #555555;
	border-width: 0px;
	background-color: #555555;
}

element.style {
}
.order-tracking .is-packing {
    display: block;
    position: relative;
    border-radius: 50%;
    height: 30px;
    width: 30px;
    border: 0px solid #AFAFAF;
    background-color: #555555;
    margin: 0 auto;
    transition: background 0.25s linear;
    -webkit-transition: background 0.25s linear;
    z-index: 2;
}
.order-tracking .is-shipped {
    display: block;
    position: relative;
    border-radius: 50%;
    height: 30px;
    width: 30px;
    border: 0px solid #AFAFAF;
    background-color: #555555;
    margin: 0 auto;
    transition: background 0.25s linear;
    -webkit-transition: background 0.25s linear;
    z-index: 2;
}
.order-tracking .is-delivered {
    display: block;
    position: relative;
    border-radius: 50%;
    height: 30px;
    width: 30px;
    border: 0px solid #AFAFAF;
    background-color: #555555;
    margin: 0 auto;
    transition: background 0.25s linear;
    -webkit-transition: background 0.25s linear;
    z-index: 2;
}
.order-tracking.completed .is-complete:after {
	border-color: #fff;
	border-width: 0px 3px 3px 0;
	width: 7px;
	left: 11px;
	opacity: 1;
}
.order-tracking p {
	color: #A4A4A4;
	font-size: 16px;
	margin-top: 8px;
	margin-bottom: 0;
	line-height: 20px;
}
.order-tracking p span{font-size: 14px;}
.order-tracking.completed p{color: #000;}
.order-tracking::before {
	content: '';
	display: block;
	height: 3px;
	width: calc(100% - 40px);
	background-color: #f7be16;
	top: 13px;
	position: absolute;
	left: calc(-50% + 20px);
	z-index: 0;
}
.order-tracking:first-child:before{display: none;}
.order-tracking.completed:before{background-color: #555555;}
.order-tracking.pend:before{background-color: #f7be16;}
.order-tracking.processing:before{background-color: #555555;}
.order-tracking.packing:before{background-color: #555555;}
.order-tracking.shipped:before{background-color: #555555;}
.mdi-tag:before {
    content: "\F4F9";
    font-size: 21px;
    color: white;
}
.mdi-settings:before {
    font-size: 21px;
    color: white;
}
.mdi-webpack:before{
    font-size: 21px;
    color: white;
}
.mdi-truck-delivery:before{
    font-size: 21px;
    color: white;
}
.mdi-home-map-marker:before{
    font-size: 21px;
    color: white;
}
    </style>

@if($detail->status_livrison == "proccessing")
<style>
.order-tracking.completed .is-processing{
	border-color: #f76916;
	border-width: 0px;
	background-color: #f76916;
}
.order-tracking.processing:before{background-color: #f76916;}
</style>
@endif
@if($detail->status_livrison == "delivered")
<style>
    .order-tracking.completed .is-processing{
        border-color: #f76916;
        border-width: 0px;
        background-color: #f76916;
    }
    .order-tracking.processing:before{background-color: #f76916;}
    .is-packing{
        background-color: #6fc9fa !important;
    }
    .order-tracking.completed .is-packing{
        border-color: #6fc9fa;
        border-width: 0px;
        background-color: #6fc9fa;
    }
    .order-tracking.packing:before{background-color: #6fc9fa;}
.order-tracking .is-shipped {
    display: block;
    position: relative;
    border-radius: 50%;
    height: 30px;
    width: 30px;
    border: 0px solid #AFAFAF;
    background-color: #bf9aef;
    margin: 0 auto;
    transition: background 0.25s linear;
    -webkit-transition: background 0.25s linear;
    z-index: 2;
}
    .order-tracking.shipped:before{background-color: #bf9aef;}
.order-tracking .is-delivered{
	border-color: #27aa80;
	border-width: 0px;
	background-color: #27aa80;
}
.order-tracking.delivered:before{background-color: #27aa80;}
</style>
@endif
@if($detail->status_livrison == "packing")
<style>
    .order-tracking.completed .is-processing{
        border-color: #f76916;
        border-width: 0px;
        background-color: #f76916;
    }
    .order-tracking.processing:before{background-color: #f76916;}
    .is-packing{
        background-color: #6fc9fa !important;
    }
    .order-tracking.completed .is-packing{
        border-color: #6fc9fa;
        border-width: 0px;
        background-color: #6fc9fa;
    }
    .order-tracking.packing:before{background-color: #6fc9fa;}
    </style>
@endif
@if($detail->status_livrison == "shipped")
<style>
    .order-tracking.completed .is-processing{
        border-color: #f76916;
        border-width: 0px;
        background-color: #f76916;
    }
    .order-tracking.processing:before{background-color: #f76916;}
    .is-packing{
        background-color: #6fc9fa !important;
    }
    .order-tracking.completed .is-packing{
        border-color: #6fc9fa;
        border-width: 0px;
        background-color: #6fc9fa;
    }
    .order-tracking.packing:before{background-color: #6fc9fa;}
.order-tracking .is-shipped {
    display: block;
    position: relative;
    border-radius: 50%;
    height: 30px;
    width: 30px;
    border: 0px solid #AFAFAF;
    background-color: #bf9aef;
    margin: 0 auto;
    transition: background 0.25s linear;
    -webkit-transition: background 0.25s linear;
    z-index: 2;
}
    .order-tracking.shipped:before{background-color: #bf9aef;}
</style>
@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
    
    $(function(e){
        $('#savescreen').click(function(e){
            if($('#screen').val() != ""){
                var id = {{$id}};
                var screen = $('#screen').prop('files')[0];
                $.ajax({
                    type : 'POST',
                    url:'{{ route('sourcing.paid')}}',
                    cache: false,
                    data:{
                        id : id,
                        screen: screen,
                        _token : '{{ csrf_token() }}'
                    },
                    success:function(response){
                        if(response.success == true){
                            toastr.success('Good Job.', 'Paid Sourcing Has been Addess Success!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                        }
                        location.reload();
                }});
            }
            
        });
    });
</script>
@endsection