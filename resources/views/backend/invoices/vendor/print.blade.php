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
                <a href="{{ route('invoices-vendor.index')}}" class="btn btn-sm btn-primary">Back to the list</a>
                <a href="#" class="btn btn-sm btn-primary" onclick="PrintElem('invoice')">Impression</a>
              </div>
            </div>
          </div>
          <div class="card-body row" id="invoice">
            <div class="d-flex col-12 mb-5">
              <div class="col mt-4">
                <img width="200" src="{{ asset('public/logo.png')}}" alt="logo">
                <h3 class="mt-4">Invoice Information</h3>
                <span class="d-block">Transaction date: {{ $invoice->transaction}}</span>
                <span class="d-block">No Invoice: #{{ $invoice->ref}}</span>
                <span class="d-block">Number of orders: {{ $colierfact->count()}}</span>
              </div>
              <div class="col-auto mt-4">
                <h3>Customer information / business</h3>
                <span class="d-block">Full name: {{ $user->name}}</span>
                <span class="d-block">Company Name: {{ $sellerpara->company_name}}</span>
                <span class="d-block">VAT: {{ $sellerpara->vat_number}}</span>
                <span class="d-block">Country: {{ $sellerpara->country}}</span>
                <span class="d-block">City: {{ $sellerpara->city}}</span>
                <span class="d-block">Address: {{ $sellerpara->address}}</span>
                <span class="d-block">Email: {{ $sellerpara->email}}</span>
                <span class="d-block">Bank Account: {{ $user->bank}}</span>
                <span class="d-block">Bank RIB: {{ $user->rib}}</span>
                <h3>Company information / business</h3>
                <span class="d-block">Full name: {{ $parameter->app_name}}</span>
                <span class="d-block">Country: {{ $parameter->country}}</span>
                <span class="d-block">City: {{ $parameter->city}}</span>
                <span class="d-block">Address: {{ $parameter->address}}</span>
                <span class="d-block">Email: {{ $parameter->email}}</span>
                <span class="d-block">VAT: {{ $parameter->vat_number}}</span>
              </div>
            </div>

              <div class="col-12 mt-3">
                <h3 class="mb-0">Billing orders</h3>
                <div class="table-responsive mt-2">
                    <table class="table align-items-center table-flush">
                      <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Total</th>
                        <th>Amount</th>
                      </tr>
                    <tr>
                        <th colspan="3">
                          <h4>Products:</h4>
                        </th>
                    </tr>
                    @foreach ($products as $product)
                        <tr>
                      <th>{{$product->product_name}}</th>
                      <th>{{ $product->quantity}}</th>
                      <th>{{ $product->quantity * $product->price }} {{ $currency->currency}}</th>
                    </tr>
                    @endforeach
                    
                    
                    
                    
                    
                    
                    
                    </thead>
                    {{-- <tfoot>
                    <td class="border-bottom-0 border-left-0 border-right-0"></td>
                    <td class="border-bottom-0 border-left-0 border-right-0"></td>
                    <td>{{ $currency->currency}}</td>
                    <td>{{ $currency->currency}}</td>
                    <td> {{ $currency->currency}}</td>
                    <td> {{ $currency->currency}}</td>
                    </tfoot> --}}
                  </table>
                </div>

                <div class="col-md-6 table-responsive mt-2 float-right p-0">
                  <table class="table align-items-center table-flush" style="border: 1px solid rgba(0, 0, 0, .05);">
                    <tbody>
                    <tr>
                      <td>Total orders amount due</td>
                      <td class="border-bottom-0 border-left-0 border-right-0">&nbsp</td>
                      <td>{{number_format((float)$invoice->amount , 2)}} {{ $currency->currency}}</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              @if(!empty($imports[0]))
              <div class="col-12 mt-3">
                  <h3 class="mb-0">Import Details</h3>
                  <div class="table-responsive mt-2">
                    <table class="table align-items-center table-flush">
                      <thead class="thead-light">
                          <tr>
                              <th>ID</th>
                              <th>Ref</th>
                              <th>Product</th>
                              <th>Weight</th>
                              <th>Fees Transport</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $counter = 1;
                        $fees = 0;  ?>
                        @foreach($imports as $v_impo)
                        <tr>
                          <td>{{ $counter }}</td>
                          <td>
                            @foreach($v_impo['import'] as $v_import)
                            {{ $v_import->ref}}
                            @endforeach
                          </td>
                          <td>
                            @foreach($v_impo['import'][0]['product'] as $v_pro)
                            {{ $v_pro->name}}
                            @endforeach
                          </td>
                          <td>
                            @foreach($v_impo['import'] as $v_import)
                            {{ $v_import->weight}}
                            @endforeach
                          </td><?php
                                foreach($v_impo['import'] as $v_import){
                                  $fees = $fees + $v_import->price;
                                  }
                                  ?>
                          <td >
                            @foreach($v_impo['import'] as $v_import)
                            {{ $v_import->price}} {{ $currency->currency}}
                            @endforeach
                          </td>
                        </tr>
                        <?php $counter = $counter + 1;  ?>
                        @endforeach
                      </tbody>
                      <tfoot>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>{{ number_format((float)$fees , 2)}} {{ $currency->currency}}</td>
                      </tfoot>
                    </table>
                  </div>
                  <div class="col-md-6 table-responsive mt-2 float-right p-0">
                    <table class="table align-items-center table-flush" style="border: 1px solid rgba(0, 0, 0, .05);">
                      <tbody>
                      <tr>
                        <td>Transport Fees</td>
                        <td> {{ number_format((float)$fees , 2)}} {{ $currency->currency}}</td>
                      </tr>
                      <tr>
                        <td>Total orders amount</td>
                        <td> {{ number_format((float)$invoice->amount , 2)}} {{ $currency->currency}}</td>
                      </tr>
                      <tr>
                        <td>Total payement du</td>
                        <td> {{ number_format((float)($invoice->amount - $fees ) , 2)}} {{ $currency->currency}}</td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
              </div>
              @endif
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