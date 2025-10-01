@extends('backend.layouts.app')
@section('title')
<!-- Page Title  -->
<title>List Facturations | FULFILLEMENT</title>
@endsection
@section('content')
<div class="page-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
      <div class="col-xl-12 order-xl-1">
        <div class="card bg-secondar shadow">
          <div class="card-header bg-white border-0">
            <div class="row align-items-center">
              <div class="col-8">
                <h3 class="mb-0">Invoice</h3>
              </div>
              <div class="col-4 text-right">
                <a href="{{ route('invoicesaffiliate.index')}}" class="btn btn-sm btn-primary">Back to the list</a>
                <a href="#" class="btn btn-sm btn-primary" onclick="PrintElem('invoice')">Impression</a>
              </div>
            </div>
          </div>
          <div class="card-body row" id="invoice">
            <div class="d-flex col-12 mb-5">
              <div class="col mt-4">
                <img width="200" src="{{ asset('public/logo.png')}}" alt="logo">
                <h3 class="mt-4">Invoice Information</h3>
                <span class="d-block">Transaction date: {{ $invoice->transaction ?? 'not Defined'}}</span>
                <span class="d-block">No Invoice: #{{ $invoice->ref ?? 'not Defined'}}</span>
                <span class="d-block">Number of orders: {{ $colierfact->count() ?? 'not Defined'}}</span>
              </div>
              <div class="col-auto mt-4">
                <h3>Customer information / business</h3>
                <span class="d-block">Full name: {{ $user->name}}</span>
                {{-- <span class="d-block">Company Name: {{ $sellerpara->company_name}}</span>
                <span class="d-block">VAT: {{ $sellerpara->vat_number}}</span>
                <span class="d-block">Country: {{ $sellerpara->country}}</span>
                <span class="d-block">City: {{ $sellerpara->city}}</span>
                <span class="d-block">Address: {{ $sellerpara->address}}</span> --}}
                <span class="d-block">Email: {{ $user->email}}</span>
                <span class="d-block">Bank Account: {{ $user->bank}}</span>
                <span class="d-block">Bank RIB: {{ $user->rib}}</span>
                <h3>Company information / business</h3>
                <span class="d-block">Full name: {{ $parameter->app_name ?? 'not Defined'}}</span>
                <span class="d-block">Country: {{ $parameter->country ?? 'not Defined'}}</span>
                <span class="d-block">City: {{ $parameter->city ?? 'not Defined'}}</span>
                <span class="d-block">Address: {{ $parameter->address ?? 'not Defined'}}</span>
                <span class="d-block">Email: {{ $parameter->email ?? 'not Defined'}}</span>
                <span class="d-block">VAT: {{ $parameter->vat_number ?? 'not Defined'}}</span>
              </div>
            </div>

              <div class="col-12 mt-3">
                <h3 class="mb-0">Billing orders</h3>
            

                <div class="col-md-12 table-responsive mt-2 float-right p-0">
                  <table class="table align-items-center table-flush" style="border: 1px solid rgba(0, 0, 0, .05);">
                    <tbody>                    
                 
                    <tr>
                      <td>Total orders Delivered</td>
                      
                      <td>{{$invoice->total_delivered}} </td>
                    </tr>
                    <tr>
                      <td>Comission Amount</td>
                      
                      <td>{{number_format((float)$invoice->amount , 2)}} {{ $currency->currency}} </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
             
          </div>
        </div>
      </div>
    </div>
    <script>
      function PrintElem(elem)
      {

        var bodyInner = document.body.innerHTML;

        document.body.innerHTML = '<div class="card-body row">' + document.getElementById(elem).innerHTML + '<style>*{color: #000!important;}</style> </div>';

        window.print();

        document.body.innerHTML = bodyInner;

        return true;
      }
    </script>
  </div>
</div>
<style>
    .shadow {
        box-shadow: 0 3px 12px 1px rgba(43, 55, 72, 0.15) !important;
    }
    .bg-secondar {
        box-shadow: 0 3px 12px 1px rgba(43, 55, 72, 0.15) !important;
    }
</style>
@endsection