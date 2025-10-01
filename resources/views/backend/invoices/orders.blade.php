@extends('backend.layouts.app')
@section('title')
<!-- Page Title  -->
<title>List Facturations | FULFILLEMENT</title>
@endsection
@section('content')
<div class="page-wrapper">
    <div class="container-fluid">
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
                <img width="200" src="{{ asset('public/logo-dark.jpg')}}" alt="logo">
                <h3 class="mt-4">Invoice Information</h3>
                <span class="d-block">Transaction date: {{ $invoice->created_at}}</span>
                <span class="d-block">No Invoice: #{{ $invoice->ref}}</span>
                <span class="d-block">Number of orders: {{ $colierfact->count()}}</span>
              </div>
              <div class="col-auto mt-4">
                <h3>Customer information / business</h3>
                <span class="d-block">Full name: {{ $user->name}}</span>
                <span class="d-block">Address: {{ $user->address}}</span>
                <span class="d-block">Bank Account: {{ $user->bank}}</span>
                <span class="d-block">Bank RIB: {{ $user->rib}}</span>
                              </div>
            </div>

                          <div class="col-12 mt-3">
                <h3 class="mb-0">Billing orders</h3>
                <div class="table-responsive mt-2">

                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                    <tr>
                      <th>ID</th>
                      <th>N° Order</th>
                      <th>Lead Value</th>
                      <th>Fees Confirmation</th>
                      <th>Fees Shipping</th>
                      <th>Fees Service</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pricetot = 0;
                        $tarif = 0;
                        $tarifconf = 0;
                        $tarifshipping = 0;
                        $feesservices = 0;
                        $count = 1;
                        ?>
                      @foreach($colierfact as $v_colierfact)
                      <tr>
                        <td>{{ $count }}</td>
                        <td>
                            @foreach($v_colierfact['lead'] as $v_ref)
                            {{ $v_ref->n_lead}}
                            @endforeach
                        </td>
                        <td>
                            <?php $pricetot = $pricetot + $v_colierfact['lead'][0]['leadproduct']->sum('lead_value') ?>{{ $v_colierfact['lead'][0]['leadproduct']->sum('lead_value')}} CFA
                        </td>
                        <td><?php $tarifconf = $tarifconf + $countrie->fees_confirmation ?>{{ $countrie->fees_confirmation}} CFA</td>
                        <td><?php $tarifshipping = $tarifshipping + $countrie->fess_shipping ?>{{ $countrie->fess_shipping}} CFA</td>
                        <td><?php $feesservices = $feesservices + (($v_colierfact['lead'][0]['leadproduct']->sum('lead_value') * $countrie->percentage) / 100 ) ?>{{ ($v_colierfact['lead'][0]['leadproduct']->sum('lead_value') * $countrie->percentage) / 100  }} CFA</td>
                        <td><a href="{{ route('invoices.lead', $v_colierfact->id )}}">Delete</a></td>
                      </tr>
                      <?php $count = $count + 1; ?>
                      @endforeach
                    </tbody>
                    <tfoot>
                    <td class="border-bottom-0 border-left-0 border-right-0"></td>
                    <td class="border-bottom-0 border-left-0 border-right-0"></td>
                    <td>{{ $pricetot}} CFA</td>
                    <td>{{ $tarifconf}} CFA</td>
                    <td>{{ $tarifshipping }} CFA</td>
                    <td>{{ $feesservices }} CFA</td>
                    </tfoot>
                  </table>
                </div>

                <div class="col-md-6 table-responsive mt-2 float-right p-0">
                  <table class="table align-items-center table-flush" style="border: 1px solid rgba(0, 0, 0, .05);">
                    <tbody>
                    <tr>
                      <td>Order Subtotal Price</td>
                      <td>{{ $pricetot}} CFA</td>
                    </tr>
                    <tr>
                      <td>Total fees</td>
                      <td <?php $feees = $tarifshipping  + $tarifconf + $feesservices ?> >{{ $tarifshipping  + $tarifconf + $feesservices}} CFA</td>
                    </tr>
                    <tr>
                      <td>Total orders amount due</td>
                      <td <?php $tot = $pricetot - $feees ?>> {{$pricetot - $feees}} CFA</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              @if(!empty($imports))
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
                              <th>Action</th>
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
                            {{ $v_import->price}} CFA
                            @endforeach
                          </td>
                          <td><a href="{{ route('invoices.import', $v_impo->id )}}">Delete</a></td>
                        </tr>
                        <?php $counter = $counter + 1;  ?>
                        @endforeach
                      </tbody>
                      <tfoot>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td>{{ $fees}} CFA</td>
                      </tfoot>
                    </table>
                  </div>
              </div>
              @endif
          </div>
        </div>
      </div>
    </div>
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