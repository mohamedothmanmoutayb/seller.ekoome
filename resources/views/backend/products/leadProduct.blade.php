@extends('backend.layouts.app')
@section('content')
    <style>
        #overlay {
            background: #ffffff;
            color: #666666;
            position: fixed;
            height: 100%;
            width: 100%;
            z-index: 5000;
            top: 0;
            left: 0;
            float: left;
            text-align: center;
            padding-top: 25%;
            opacity: .80;
        }

        .spinner {
            margin: 0 auto;
            height: 64px;
            width: 64px;
            animation: rotate 0.8s infinite linear;
            border: 5px solid firebrick;
            border-right-color: transparent;
            border-radius: 50%;
        }
    </style>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        

        <div class="card card-body py-3">
            <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                <h4 class="mb-4 mb-sm-0 card-title">Leads</h4>
                <nav aria-label="breadcrumb" class="ms-auto">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item d-flex align-items-center">
                        <a class="text-muted text-decoration-none d-flex" href="{{ route('home')}}">
                        <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                        </a>
                    </li>
                    </ol>
                </nav>
                </div>
            </div>
            </div>
        </div>
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Bordered Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive border rounded-1" style="margin-top:-20px">
                        <table class="table text-nowrap customize-table mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>                                  
                                    <th>Ref</th>
                                    <th>Products</th>
                                    <th>Name</th>
                                    <th>City</th>
                                    <th>Phone</th>
                                    <th>Lead Value</th>
                                    <th>Confirmation</th>
                                    <th>Shipping</th>
                                    <th>Payment</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                ?>
                                @if(!empty($leads->isempty()))
                                    @foreach ($leads as $v_lead)
                                        <tr class="accordion-toggle data-item" data-id="{{ $v_lead['id'] }}"
                                            @if ($v_lead['ispaidapp'] == 1) style="background: #a7a7a7;color: #000;border: 1px solid;" @endif>
                                        
                                            <td>
                                                <span class="badge bg-success">{{ $v_lead['n_lead'] }}</span><br>
                                                {{ $v_lead['id_order'] }}<br>
                                                @if (!empty($v_lead['leadproduct']))
                                                    <a href="{{ route('leads.edit', $v_lead['id']) }}"
                                                        class="label label-info ">+Upssel{{ $v_lead['leadproduct']->where('isupsell', '1')->count() }}</a>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach ($v_lead['product'] as $v_product)
                                                {{ $v_product['name'] }} 
                                                @endforeach
                                            </td>
                                            <td>{{ $v_lead['name'] }}</td>
                                            <td>
                                                @if (!empty($v_lead['id_city']))
                                                    @if (!empty($v_lead['cities'][0]['name']))
                                                        @foreach ($v_lead['cities'] as $v_city)
                                                            {{ $v_city['name'] }}
                                                        @endforeach
                                                    @else
                                                        {{ $v_lead['city'] }}
                                                    @endif
                                                @else
                                                    {{ $v_lead['city'] }}
                                                @endif
                                                <br>
                                                {{ $v_lead['address'] }}
                                            </td>
                                            <td><a href="tel:{{ $v_lead['phone'] }}">{{ $v_lead['phone'] }}</a></td>
                                            <td>{{ $v_lead['lead_value'] }}</td>
                                            <td>
                                                @if($v_lead['status_confirmation'] == 'confirmed')
                                                    <span
                                                        class="badge bg-success">{{ $v_lead['status_confirmation'] }}</span>
                                                @elseif($v_lead['status_confirmation'] == 'new order' )
                                                    <span
                                                        class="badge bg-info">{{ $v_lead['status_confirmation'] }}</span>
                                                @elseif($v_lead['status_confirmation'] == 'call later')
                                                    <span
                                                        class="badge bg-danger">{{ $v_lead['status_confirmation'] }}</span>
                                                @elseif($v_lead['status_confirmation'] == 'canceled')
                                                    <span
                                                        class="badge bg-warning">{{ $v_lead['status_confirmation'] }}</span>
                                                @elseif($v_lead['status_confirmation'] == 'canceled by system')
                                                    <span
                                                        class="badge bg-inverse">{{ $v_lead['status_confirmation'] }}</span>
                                                @elseif($v_lead['status_confirmation'] == 'out of area')
                                                    <span
                                                        class="badge" style="background-color: #7365f0">{{ $v_lead['status_confirmation'] }}</span>
                                                @elseif($v_lead['status_confirmation'] == 'outofstock')
                                                    <span
                                                        class="badge" style="background-color: #52D3D8">{{ $v_lead['status_confirmation'] }}</span>
                                                @elseif($v_lead['status_confirmation'] == 'duplicated')
                                                    <span
                                                        class="badge bg-primary">{{ $v_lead['status_confirmation'] }}</span>
                                                @elseif($v_lead['status_confirmation'] == 'wrong')
                                                    <span
                                                        class="badge bg-dark">{{ $v_lead['status_confirmation'] }}</span>
                                                @else
                                                    <span
                                                        class="badge" style="background-color: #B31312">{{ $v_lead['status_confirmation'] }}</span>

                                                @endif
                                            </td>
                                            <td>
                                                @if ($v_lead['status_livrison'] == 'unpacked')
                                                    <span class="badge bg-warning">{{ $v_lead['status_livrison'] }}</span>
                                                @elseif($v_lead['status_livrison'] == 'delivered')
                                                    <span class="badge bg-success">{{ $v_lead['status_livrison'] }}</span>
                                                @elseif($v_lead['status_livrison'] == 'returned')
                                                    <span class="badge bg-inverse">{{ $v_lead['status_livrison'] }}</span>
                                                @elseif($v_lead['status_livrison'] == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-danger">{{ $v_lead['status_livrison'] }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-warning">{{ $v_lead['status_payment'] }}</span>
                                            </td>
                                            <td>{{ $v_lead['created_at'] }}</td>
                                            <td>
                                            
                                                <div class="dropdown">
                                                    <button class="btn p-0" type="button" id="earningReports" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">
                                                        <a class="dropdown-item "
                                                            href="{{ route('leads.edit', $v_lead['id']) }}" id="">
                                                            Details <i class="ti ti-edit"></i>
                                                            </a>
                                                        <a class="dropdown-item"
                                                            href="#" data-id="{{$v_lead['id']}}"
                                                            id="delete"> Delete <i class="ti ti-trash"></i>
                                                        </a>
                                                    </div>
                                                </div> 
                                            </td>
                                        </tr>
                                        <?php $counter = $counter + 1; ?>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="12">
                                            <div class="col-12">
                                                <img src="{{ asset('public/Empty-amico.svg') }}"
                                                    style="margin-left: auto ; margin-right: auto; display: block;"
                                                    width="500" />
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{-- <span>Count Order: {{ $count }} / {{ $items }}</span> --}}
                        {{-- {{ $products->withQueryString()->links('vendor.pagination.courier') }} --}}
                    </div>
                </div>
            </div>
            <!--/ Bordered Table -->

        </div>
        <!-- / Content -->

        <div class="content-backdrop fade"></div>
    </div>

    @section('script')
        <!-- Page JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript">


                
                $(document).on('click', '#delete', function(e){
                    e.preventDefault();
                    var id  = $(this).data('id'); // Get the data-id attribute of the clicked element
                    console.log(id);
                    $.ajax({
                        type : 'POST',
                        
                        cache: false,
                        data:{
                            id: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success:function(response){
                            toastr.success('Good Job', 'Lead Has been Deleted!', { "showMethod": "slideDown", "hideMethod": "slideUp", timeOut: 2000 });
                            location.reload();
                        }
                    });
                });
            
        </script>
    @endsection
@endsection
