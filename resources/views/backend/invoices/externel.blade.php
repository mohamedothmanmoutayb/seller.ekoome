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
              <div class="col-2 text-right">
                <a href="{{ route('invoices.index')}}" class="btn btn-sm btn-primary">Back to the list</a>
                {{-- <a href="#" class="btn btn-sm btn-primary" onclick="Calculate()">Calculate</a>
                <a href="#" class="btn btn-sm btn-primary" id="save">Save Invoice</a> --}}
              </div>
            </div>
          </div>
          <div class="card-body row" id="invoice">
            <div class="d-flex col-12 mb-5">
              <div class="col mt-4">
                <img width="200" src="{{ asset('public/ECOM HUB-07.png')}}" alt="logo">
                <h3 class="mt-4">Invoice Information</h3>
                <form action="" method="GET">
                  @csrf
                <span class="d-block" style="display: flex">Transaction date: <input required style="width: 200px" name="date" type="date" class="form-control" id="flatpickr-range"></span>
                {{-- <span class="d-block">Number of orders: </span> --}}
              </div>
              <div class="col-auto mt-4">
                <h3>Customer information / business</h3>
                <span class="d-block">Full name: {{ $user->name}}</span>
                <span class="d-block">Company Name: {{ $sellerpara->company_name ?? 'not Defined'}}</span>
                <span class="d-block">VAT: {{ $sellerpara->vat_number ?? 'not Defined'}}</span>
                <span class="d-block">Country: {{ $sellerpara->country ?? 'not Defined'}}</span>
                <span class="d-block">City: {{ $sellerpara->city ?? 'not Defined'}}</span>
                <span class="d-block">Address: {{ $sellerpara->address ?? 'not Defined'}}</span>
                <span class="d-block">Email: {{ $sellerpara->email ?? 'not Defined'}}</span>
                <span class="d-block">Bank Account: {{ $user->bank }}</span>
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
                <div class="table-responsive mt-2">
                    <table class="table align-items-center table-flush">
                      <thead class="thead-light">
                      <tr>
                        <th>#</th>
                        <th>Total</th>
                        <th>Amount</th>
                      </tr>
                    
                    
                    <input type="hidden" name="user" id="user" value="{{$user->id}}">
                    <tr>
                        <th colspan="3">
                          <h4>Call Center Fees :</h4>
                        </th>
                    </tr>
                    <tr>
                      <th>Fees Entred</th>
                      <th><input required style="width: 200px" type="number" name="total_entred" id="total_entred" class="form-control" min="0" placeholder="Total"></th>
                      <th style="display: flex;font-size:20px;"><input required style="width: 200px" name="lead_entred" id="lead_entred" type="number" placeholder="Total Amount" class="form-control mx-2" min="0"> {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Fees Confirmation</th>
                      <th> <input required style="width: 200px" type="number" class="form-control" min="0" name="total" id="total" placeholder="Total leads confirmed"></th>
                      <th style="display: flex;font-size:20px;"><input required style="width: 200px" name="confirmation_fees" id="confirmation_fees"  type="number" class="form-control mx-2" min="0" placeholder="Fees confirmation"> {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Fees Delivered</th>
                      <th><input required style="width: 200px" type="number" name="total_delivered" id="total_delivered" class="form-control" min="0" placeholder="Total delivered"></th>
                      <th style="display: flex;font-size:20px;"><input required style="width: 200px" type="number" name="shipping_fees" id="shipping_fees" class="form-control mx-2" min="0" placeholder="Fees shipping"> {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Fees Upsell</th>
                      <th> </th>
                      <th style="display: flex;font-size:20px;"><input required style="width: 200px" type="number" name="lead_upsell" id="lead_upsell" min="0" class="form-control mx-2" min="0" placeholder="Fees upsell"> {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                        <th colspan="3">
                          <h4>Delivered Fees :</h4>
                        </th>
                    </tr>
                    <tr>
                      <th>Fees Shipping</th>
                      <th><input required style="width: 200px" type="number" min="0" class="form-control" id="total_order_delivered2" placeholder=" delivered + return "> </th>
                      <th style="display: flex;font-size:20px;"> <input required style="width: 200px" name="order_delivered" id="order_delivered" type="number" min="0" class="form-control  mx-2" placeholder="Orders delivered">  {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Fees Returned</th>
                      <th><input required style="width: 200px" type="number" min="0" name="total_return" id="total_return" class="form-control" placeholder="Total Return"></th>
                      <th style="display: flex;font-size:20px;"><input required style="width: 200px" type="number" name="order_return" id="order_return" min="0" class="form-control  mx-2" placeholder="Orders return">  {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Islnad Shipping</th>
                      <th><input required style="width: 200px" type="number" min="0" name="island_shipping_count" id="island_shipping_count" class="form-control" placeholder="island shipping"> </th>
                      <th style="display: flex;font-size:20px;"><input required style="width: 200px" type="number" name="island_shipping" id="island_shipping" min="0" class="form-control  mx-2" placeholder="Island shipping"> {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Islnad Returned</th>
                      <th><input required style="width: 200px" type="number" min="0" class="form-control" name="island_return_count" id="island_return_count" placeholder="Island return"> </th>
                      <th style="display: flex;font-size:20px;"><input required style="width: 200px" type="number" min="0" name="island_return" id="island_return" class="form-control  mx-2" placeholder="Island return"> {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Fees COD</th>
                      <th> <input required style="width: 200px" type="number" min="0" class="form-control" name="total_delivered2" id="total_deliverd2" placeholder="Total delivered"> </th>
                      <th style="display: flex;font-size:20px;"> <input required style="width: 200px" type="number" name="codfess" id="codfess" min="0" class="form-control  mx-2" placeholder="COD fees"> {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                        <th colspan="3">
                          <h4>Fulfillement :</h4>
                        </th>
                    </tr>
                    <tr>
                      <th>Fees Storage</th>
                      <th></th>
                      <th style="display: flex;font-size:20px;"><input required style="width: 200px" type="number" name="storage" id="storage" min="0" placeholder="Fees Storage" class="form-control mx-2"> {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Pick & Pack</th>
                      <th> <input required style="width: 200px" type="number" min="0" class="form-control" id="fullfilment1" placeholder=" delivered +  return"></th>
                      <th style="display: flex;font-size:20px;"><input required  style="width: 200px" name="fullfilment" id="fullfilment" type="number" min="0" class="form-control mx-2" placeholder="fullfilment"> {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                      <th>Management Returned</th>
                      <th><input required style="width: 200px" type="number" min="0" class="form-control" name="total_return2" id="total_return2" placeholder="Total return"> </th>
                      <th style="display: flex;font-size:20px;"><input required placeholder="Total Amount"  name="management_return" id="management_return" style="width: 200px" type="number" min="0" class="form-control  mx-2"> {{ $currency->currency}}</th>
                    </tr>
                    <tr>
                        <th colspan="3">
                          <h4>Sourcing :</h4>
                        </th>
                    </tr>
                    <tr>
                      <th>Amount Order</th>
                      {{-- <th><input required style="width: 200px" type="number" min="0" class="form-control" name="total_delivered3" id="total_delivered3" placeholder="Total delivred"> </th> --}}
                      <th style="display: flex;font-size:20px;"> <input required style="width: 200px" name="amount_order" id="amount_order" type="number" min="0"  placeholder="Amount" class="form-control mx-2">{{ $currency->currency}} </th>
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
                      <td style="display: flex;font-size:20px;"> <input required readonly  placeholder="Total Fees" id="TotalFees" style="width: 200px" type="number" min="0" class="form-control mx-2"> {{ $currency->currency}}</td>
                    </tr>
                    <tr>
                      <td>Order Amount</td>
                      <td class="border-bottom-0 border-left-0 border-right-0">&nbsp</td>
                      <td style="display: flex;font-size:20px;"> <input required readonly placeholder="Order Amount" id="OrderAmount" style="width: 200px" type="number" min="0" class="form-control mx-2"> {{ $currency->currency}}</td>
                    </tr>
                    <tr>
                      <td>Total orders amount due</td>
                      <td class="border-bottom-0 border-left-0 border-right-0">&nbsp</td>
                      <td style="display: flex;font-size:20px;"> <input required readonly placeholder="Amount Due" name="amount" id="AmountDue" style="width: 200px" type="number" min="0" class="form-control mx-2"> {{ $currency->currency}}</td>
                    </tr>
                    </tbody>
                  </table>
                  
                </div>
              </div>
              
              <div class="col-12 mt-3">
                 @if(!empty($imports[0]))
                    <h3 class="mb-0">Import Details</h3>
                    <div class="table-responsive mt-2">
                      <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>  
                                <th>#</th>                 
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
                            <td>{{ $counter }} <input type="hidden" name="ids[]" value="{{$v_impo->id}}" class="Ids"></td>
                            <td>                         
                              {{ $v_impo->ref}}                           
                            </td>
                            <td>
                              @foreach($v_impo['product'] as $v_pro)
                              {{ $v_pro->name}}
                              @endforeach
                            </td>
                            <td>                          
                              {{ $v_impo->weight}} kg
                            </td>
                            <?php                              
                                $fees = $fees + $v_impo->price;                             
                            ?>
                            <td style="display: flex;font-size:20px;">                          
                              <input required style="width: 200px" type="number" min="0" value="{{ $v_impo->price}}" name="price[]"  class="form-control Prices mx-2" placeholder="Fees Import"> {{ $currency->currency}}
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
                          <td style="display: flex;font-size:20px;"><input required readonly style="width: 200px" type="number" min="0" value="{{$fees}}" id="fees" class="form-control mx-2" placeholder="Fees Import"> {{ $currency->currency}}</td>
                        </tfoot>
                      </table>
                    </div>
                    <div class="col-md-6 table-responsive mt-2 float-right p-0">
                      <table class="table align-items-center table-flush" style="border: 1px solid rgba(0, 0, 0, .05);">
                        <tbody>
                        <tr>
                          <td>Transport Fees</td>
                          <td style="display: flex;font-size:20px;"> <input required  readonly placeholder="Transport Fees" id="TransportFees" style="width: 200px" type="number" min="0" class="form-control mx-2"> {{ $currency->currency}}</td>
                        </tr>
                        <tr>
                          <td>Total orders amount</td>
                          <td style="display: flex;font-size:20px;"> <input required readonly placeholder="Total orders amount" id="orders_amount" style="width: 200px" type="number" min="0" class="form-control  mx-2"> {{ $currency->currency}}</td>
                        </tr>
                        <tr>
                          <td>Total payment du</td>
                          <td style="display: flex;font-size:20px;">  <input required  readonly placeholder="Total payment" id="TotalPayment" style="width: 200px" type="number" min="0" class="form-control mx-2"> {{ $currency->currency}}</td>
                        </tr>
                        </tbody>
                      </table>
                    
                    </div>
                    
                        
                  @else
                     <input type="hidden" name="ids[]" class="Ids" value="0">
                     <input required style="width: 200px" type="hidden" min="0" value="0" name="price[]" class="Prices" class="form-control mx-2">
                     <input required readonly style="width: 200px" type="hidden" min="0" value="0" id="fees" class="form-control mx-2">
                  @endif
                  <table class="table align-items-center table-flush" style="border: 1px solid rgba(0, 0, 0, .05);">
                    <thead>
                    <tr class="text-center"> 
                      <td>        
                         <a href="javascript:void(0)"  class="btn btn-lg btn-primary" onclick="Calculate()">Calculate</a>
                         <a href="#" class="btn btn-lg btn-primary" id="save">Save Invoice</a>
                        </td>

                    </tr>
                    </thead>
                  </table>
              </div>
              </form>
          </div>
        </div>
      </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
      function Calculate()
      {
        var total_entred = document.getElementById('total_entred').value ? document.getElementById('total_entred').value : 0;
        var lead_entred = document.getElementById('lead_entred').value ? document.getElementById('lead_entred').value : 0;
        var confirmation_fees_total = document.getElementById('total').value ? document.getElementById('total').value : 0;
        var confirmation_fees = document.getElementById('confirmation_fees').value ? document.getElementById('confirmation_fees').value : 0;
        var total_delivered = document.getElementById('total_delivered').value ? document.getElementById('total_delivered').value : 0;
        var shipping_fees = document.getElementById('shipping_fees').value ? document.getElementById('shipping_fees').value : 0;
        var lead_upsell = document.getElementById('lead_upsell').value ? document.getElementById('lead_upsell').value : 0;
        var total_order_delivere2 = document.getElementById('total_order_delivered2').value ? document.getElementById('total_order_delivered2').value : 0;
        var order_delivered = document.getElementById('order_delivered').value ? document.getElementById('order_delivered').value : 0;
        var total_return = document.getElementById('total_return').value ? document.getElementById('total_return').value : 0;
        var order_return = document.getElementById('order_return').value ? document.getElementById('order_return').value : 0;
        var island_shipping_count = document.getElementById('island_shipping_count').value ? document.getElementById('island_shipping_count').value : 0;
        var island_shipping = document.getElementById('island_shipping').value ? document.getElementById('island_shipping').value : 0;
        var island_return_count = document.getElementById('island_return_count').value ? document.getElementById('island_return_count').value : 0;
        var island_return = document.getElementById('island_return').value ? document.getElementById('island_return').value : 0;  
        var total_deliverd2 = document.getElementById('total_deliverd2').value ? document.getElementById('total_deliverd2').value : 0;
        var codfess = document.getElementById('codfess').value ? document.getElementById('codfess').value : 0;
        var storage = document.getElementById('storage').value ? document.getElementById('storage').value : 0;
        var total_fullfilment = document.getElementById('fullfilment1').value ? document.getElementById('fullfilment1').value : 0;
        var fullfilment = document.getElementById('fullfilment').value ? document.getElementById('fullfilment').value : 0;
        var total_return2 = document.getElementById('total_return2').value  ? document.getElementById('total_return2').value : 0;
        var management_return = document.getElementById('management_return').value  ? document.getElementById('management_return').value : 0;
        var amount_order = document.getElementById('amount_order').value ? document.getElementById('amount_order').value : 0;
        var TotalFees = (parseFloat(lead_entred) * parseFloat(total_entred) ) + parseFloat(lead_upsell) + (parseFloat(confirmation_fees) * parseFloat(confirmation_fees_total))  + (parseFloat(shipping_fees)* parseFloat(total_delivered)) + (parseFloat(order_delivered) * parseFloat(total_order_delivere2)) +(parseFloat(order_return) * parseFloat(total_return)) + (parseFloat(island_shipping)*parseFloat(island_shipping_count)) + (parseFloat(island_return) * parseFloat(island_return_count)) + (parseFloat(codfess)*parseFloat(total_deliverd2)) + parseFloat(storage) + (parseFloat(fullfilment)*parseFloat(total_fullfilment)) + (parseFloat(management_return)*parseFloat(total_return2));      
        var OrderAmount = parseFloat(amount_order);
        var AmountDue = parseFloat(amount_order) - TotalFees;
        var prices = document.getElementsByClassName('Prices');
        var sum = 0;
        for (var i = 0; i < prices.length; i++){
          sum += parseFloat(prices[i].value);
        }
        document.getElementById('fees').value = sum;

        var TransportFees =  parseFloat(document.getElementById('fees').value);
        var orders_amount = AmountDue;
        var TotalPayment = AmountDue - TransportFees;
        document.getElementById('TotalFees').value = TotalFees;
        document.getElementById('OrderAmount').value = OrderAmount;
        document.getElementById('AmountDue').value = AmountDue;
        document.getElementById('TransportFees').value = TransportFees;
        document.getElementById('orders_amount').value = orders_amount;
        document.getElementById('TotalPayment').value = TotalPayment;     
      }
    </script>
    <script>
        $(document).ready(function(){
            $('#save').click(function(){
              //array of ids
              var AmountDue = document.getElementById('AmountDue').value;
              if(AmountDue  == null)
              {
                alert('Calculate first the invoice.');
                return false;
              }
              var id = $('.Ids');
              var prices = $('.Prices');
              var choice = confirm('Are you sure to save this invoice ?');
              if(choice){
                $.ajax({
                url: "{{ route('invoices.store')}}",
                type: "GET",
                data: {
                  user : $('input[name="user"]').val(),
                  date: $('input[name="date"]').val(),
                  total_entred: $('input[name="total_entred"]').val(),
                  lead_entred: $('input[name="lead_entred"]').val(),
                  confirmation_fees: $('input[name="confirmation_fees"]').val(),
                  total_delivered: $('input[name="total_delivered"]').val(),
                  shipping_fees: $('input[name="shipping_fees"]').val(),
                  lead_upsell: $('input[name="lead_upsell"]').val(),
                  order_delivered: $('input[name="order_delivered"]').val(),
                  total_return: $('input[name="total_return"]').val(),
                  order_return: $('input[name="order_return"]').val(),
                  island_shipping_count: $('input[name="island_shipping_count"]').val(),
                  island_shipping: $('input[name="island_shipping"]').val(),
                  island_return_count: $('input[name="island_return_count"]').val(),
                  island_return: $('input[name="island_return"]').val(),
                  codfess: $('input[name="codfess"]').val(),
                  storage: $('input[name="storage"]').val(),
                  fullfilment: $('input[name="fullfilment"]').val(),
                  management_return: $('input[name="management_return"]').val(),
                  amount_order: $('input[name="amount_order"]').val(),
                  amount: $('input[name="amount"]').val(),   
                  ids: id.map(function() {
                                return $(this).val();
                            }).get(),
                  price: prices.map(function() {
                                return $(this).val();
                        }).get(),
                },
               
                success: function(response) {
                    if (response.status === true) {
                       
                        toastr.success('Good Job.',
                            'Invoice Has been Added Success!', {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 4000
                            });

                    }

                   
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation errors occurred
                        var errors = xhr.responseJSON.errors;

                        // Display each error
                        for (var field in errors) {
                            toastr.error('Good Job.', 'Opps ' + errors[field][0], {
                                "showMethod": "slideDown",
                                "hideMethod": "slideUp",
                                timeOut: 4000
                            });
                        }
                    } else {
                        // Other types of errors
                        toastr.warning('Good Job.', 'Opps Something went wrong!', {
                            "showMethod": "slideDown",
                            "hideMethod": "slideUp",
                            timeOut: 2000
                        });
                    }

                }
              });
              }
             
            });
        });
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