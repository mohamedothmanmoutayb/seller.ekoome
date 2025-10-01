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
                <a href="{{ route('invoices.index')}}" class="btn btn-sm btn-primary">Back to the list</a>
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
                <span class="d-block">Number of orders: {{ $colierfact->count() ?? 'not Defined' }}</span>
              </div>
              <div class="col-auto mt-4">
                <h3>Customer information / business</h3>
                <span class="d-block">Full name: {{ $user->name ?? 'not Defined'}}</span>
                <span class="d-block">Company Name: {{ $sellerpara->company_name ?? 'not Defined'}}</span>
                <span class="d-block">VAT: {{ $sellerpara->vat_number ?? 'not Defined'}}</span>
                <span class="d-block">Country: {{ $sellerpara->country ?? 'not Defined'}}</span>
                <span class="d-block">City: {{ $sellerpara->city ?? 'not Defined'}}</span>
                <span class="d-block">Address: {{ $sellerpara->address ?? 'not Defined'}}</span>
                <span class="d-block">Email: {{ $sellerpara->email ?? 'not Defined'}}</span>
                <span class="d-block">Bank Account: {{ $user->bank ?? 'not Defined'}}</span>
                <span class="d-block">Bank RIB: {{ $user->rib ?? 'not Defined'}}</span>
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
                          <h4>Call Center Fees :</h4>
                        </th>
                    </tr>
                    <tr>
                      <th>Fees Entred</th>
                      <th>{{ $invoice->total_entred}}</th>
                      <th>{{ $invoice->lead_entred}} {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Fees Confirmation</th>
                      <th>{{ $invoice->total_delivered + $invoice->total_return}} </th>
                      <th>{{ $invoice->confirmation_fees}} {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Fees Delivered</th>
                      <th>{{ $invoice->total_delivered}} </th>
                      <th>{{ $invoice->shipping_fees}} {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Fees Upsell</th>
                      <th> </th>
                      <th>{{ $invoice->lead_upsell}} {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                        <th colspan="3">
                          <h4>Delivered Fees :</h4>
                        </th>
                    </tr>
                    <tr>
                      <th>Fees Shipping</th>
                      <th>{{ $invoice->total_delivered + $invoice->total_return}} </th>
                      <th>{{ $invoice->order_delivered}} {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Fees Returned</th>
                      <th>{{ $invoice->total_return}}</th>
                      <th>{{ $invoice->order_return}} {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Islnad Shipping</th>
                      <th>{{ $invoice->island_shipping_count}} </th>
                      <th>{{ $invoice->island_shipping}} {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Islnad Returned</th>
                      <th>{{ $invoice->island_return_count}} </th>
                      <th>{{ $invoice->island_return}} {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Fees COD</th>
                      <th>{{ $invoice->total_delivered}} </th>
                      <th>{{ $invoice->codfess}} {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                        <th colspan="3">
                          <h4>Fulfillement :</h4>
                        </th>
                    </tr>
                    <tr>
                      <th>Other Fees</th>
                      <th></th>
                      <th>{{ $invoice->storage}} {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Pick & Pack</th>
                      <th>{{ $invoice->total_delivered + $invoice->total_return}} </th>
                      <th>{{ $invoice->fullfilment}} {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Management Returned</th>
                      <th>{{ $invoice->total_return}} </th>
                      <th>{{ $invoice->management_return}} {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                        <th colspan="3">
                          <h4>Sourcing :</h4>
                        </th>
                    </tr>
                    <tr>
                      <th>Amount Order</th>
                      <th>{{$invoice->total_delivered}}</th>
                      <th>{{$invoice->amount_order}} {{ $currency->currency}}</th>
                    </tr>
                    </thead>
                 
                  </table>
                </div>

                <div class="col-md-6 table-responsive mt-2 float-right p-0">
                  <table class="table align-items-center table-flush" style="border: 1px solid rgba(0, 0, 0, .05);">
                    <tbody>
                    <tr>
                      <td>Total Fees</td>
                      <td class="border-bottom-0 border-left-0 border-right-0">&nbsp</td>
                      <td>{{$invoice->lead_entred + $invoice->confirmation_fees + $invoice->shipping_fees + $invoice->lead_upsell + $invoice->order_delivered + $invoice->order_return + $invoice->island_shipping + $invoice->island_return + $invoice->codfess + $invoice->storage + $invoice->fullfilment + $invoice->management_return}} {{ $currency->currency}}</td>
                    </tr>
                    <tr>
                      <td>Order Amount</td>
                      <td class="border-bottom-0 border-left-0 border-right-0">&nbsp</td>
                      <td>{{number_format((float)$invoice->amount_order , 2)}} {{ $currency->currency}}</td>
                    </tr>
                    <!-- <tr>
                      <td>Total orders amount due</td>
                      <td class="border-bottom-0 border-left-0 border-right-0">&nbsp</td>
                      <td>{{number_format((float)$invoice->amount , 2)}} {{ $currency->currency}}</td>
                    </tr> -->
                    </tbody>
                  </table>
                </div>
              </div>
              @if(!empty($imports))
              <div class="col-12">
                  <h3 class="mb-0">Import Details</h3>
                  <div class="table-responsive mt-2" style="min-height: 30px;">
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
                    <table class="table align-items-center table-flush" style="border: 1px solid rgba(0, 0, 0, .05);">
                      <tbody>
                      <tr>
                        <td>Transport Fees</td>
                        <td> {{ number_format((float)$fees , 2)}} {{ $currency->currency}}</td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-6 table-responsive mt-2 float-right p-0" style="min-height: 30px;">
                  </div>
              </div>
              @endif

              <div class="col-12" >
                  <h3 class="mb-0">Last Invoice Negative</h3>
                  <div class="table-responsive mt-2" style="min-height: 30px;">
                    <table class="table align-items-center table-flush">
                      <thead class="thead-light">
                          <tr>
                              <th>ID</th>
                              <th>Ref</th>
                              <th>Amount</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $counter = 1;
                        $fees = 0;  ?>
                        @foreach($lastinvoices as $v_invoice)
                        <tr>
                          <td>{{ $counter }}</td>
                          <td>
                            {{ $v_invoice['invoic']->ref}}
                          </td>
                          <td>
                            {{ $v_invoice['invoic']->amount}}
                          </td>
                          <?php
                                  $fees = $fees + $v_invoice['invoic']->amount;
                                  ?>
                        </tr>
                        <?php $counter = $counter + 1;  ?>
                        @endforeach
                      </tbody>
                      <tfoot>
                      <td></td>
                      <td></td>
                      <td>{{ $fees , 2}} {{ $currency->currency}}</td>
                      </tfoot>
                    </table>
                    <table class="table align-items-center table-flush" style="border: 1px solid rgba(0, 0, 0, .05);min-height: 30px !important;">
                      <tbody>
                      <tr>
                        <td>Total Last Invoice</td>
                        <td>{{ $fees , 2}} {{ $currency->currency}}</td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md-6 table-responsive mt-2 float-right p-0" style="min-height: 30px !important;">
                    <table class="table align-items-center table-flush" style="border: 1px solid rgba(0, 0, 0, .05);">
                      <tbody>
                      <tr>
                        <td>Total payement du</td>
                        <td> {{ $invoice->amount }} {{ $currency->currency}}</td>
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