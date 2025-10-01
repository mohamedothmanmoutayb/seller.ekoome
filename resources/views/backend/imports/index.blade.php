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
            
        <div class="card card-body py-3">
            <div class="row align-items-center">
              <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                  <h4 class="mb-4 mb-sm-0 card-title">Imports</h4>
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

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="col-xl-12 col-lg-12 col-md-12 box-col-12">
                  <div class="card order-card">
                    <div class="card-header pb-0">
                      <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                          <p class="square-after f-w-600">Our Total Sold<i class="fa fa-circle"></i></p>
                        </div>
                        <div class="setting-list">
                          <ul class="list-unstyled setting-option">
                            <li>
                              <div class="setting-light"><i class="icon-layout-grid2"></i></div>
                            </li>
                            <li><i class="view-html fa fa-code font-white"></i></li>
                            <li><i class="icofont icofont-maximize full-card font-white"></i></li>
                            <li><i class="icofont icofont-minus minimize-card font-white"></i></li>
                            <li><i class="icofont icofont-refresh reload-card font-white"></i></li>
                            <li><i class="icofont icofont-error close-card font-white"> </i></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="card-body pt-0">
                      <div class="table-responsive theme-scrollbar h-200" style="min-height:600px">
                        <table class="table table-bordernone">
                          <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Nbr Packages</th>
                                <th>Shipping country</th>
                                <th>Expedition Phone</th>
                                <th>Expedition Mode</th>
                                <th>Expedition Date</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $counter =  1; ?>
                            @foreach($imports as $v_import)
                            @foreach($v_import['imports'] as $v_imports)
                            <tr>
                                <td>{{ $counter}}</td>
                                <td><img src="{{ $v_import->image }}" alt="user" class="circle" width="45" /></td>
                                <td>{{ $v_import->name}}</td>
                                <td>{{ $v_imports->quantity_sent}}</td>
                                <td>{{ $v_imports->nbr_packages}}</td>
                                <td>
                                    @foreach($v_imports['shipping'] as $v_shipp)
                                    {{ $v_shipp->name}}
                                    @endforeach
                                </td>
                                <td>{{ $v_imports->phone_shipper}}</td>
                                <td>{{ $v_imports->expedition_mode}}</td>
                                <td>{{ $v_imports->expidtion_date}}</td>
                                <td>{{ $v_imports->status}}</td>
                                <td>{{ $v_imports->created_at}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ti ti-settings"></i>
                                        </button>
                                        <div class="dropdown-menu animated slideInUp" x-placement="bottom-start" style="position: absolute; will-change: transform; transform: translate3d(0px, 35px, 0px);margin-left: -60px!important;">
                                            <a class="dropdown-item" href="{{ route('products.importprint',$v_imports->id)}}" ><i class="ti ti-eye"></i> Print Label</a>
                                            <buton class="dropdown-item editimports" id="editimport" data-id="{{ $v_import->id}}" ><i class="ti ti-eye"></i> Update</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                            <?php $counter = $counter + 1; ?>
                          </tbody>
                        </table>
                      </div>
                      <div class="code-box-copy">
                        <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#total-sold"><i class="icofont icofont-copy-alt"></i></button>
                        
                      </div>
                    </div>
                  </div>
                </div>
                <div id="update_import" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Update Import</h4>
                    
                            </div>
                            <form action="{{ route('imports.update')}}" method="post" class="form-horizontal form-material" enctype="multipart/form-data" novalidate="novalidate">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <div class="col-md-12 m-b-20 mt-4">
                                            <input type="text" class="form-control" name="fees" id="import_fees" placeholder="Fees">
                                            <input type="hidden" name="import" id="import_id"/>
                                        </div>
                                        <div class="col-md-12 m-b-20 mt-4">
                                            <input type="text" class="form-control" name="weight" id="import_weight" placeholder="Weight">
                                        </div>
                                        <div class="col-md-12 m-b-20 mt-4">
                                            <input type="text" class="form-control" name="quantity" id="import_quantity" placeholder="Quantity">
                                        </div>
                                        <div class="col-md-12 m-b-20 mt-4">
                                            <input type="text" class="form-control" name="note" id="import_note" placeholder="Note">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary waves-effect">Save</button>
                                     <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- ============================================================== -->
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">

    $(function () {
        $('body').on('click', '.configupsel', function () {
        var product_id = $(this).data('id');
        //console.log(product_id);
                $('#config_upsel').modal('show');
                $('#upsel_product_id').val(product_id);
            
        });
    });
    $(function () {
        $('body').on('click', '.editimports', function () {
        var id = $(this).data('id');
        //console.log(product_id);
            $.get("{{ route('imports.index') }}" +'/' + id +'/edit', function (data) {
                //console.log(product_id);
                $('#update_import').modal('show');
                $('#import_id').val(data.id);
                $('#import_fees').val(data.price);
                $('#import_quantity').val(data.quantity_received);
                $('#import_weight').val(data.weight);
                $('#import_note').val(data.note);
            });
        });
    });
    
</script>
@endsection
@endsection