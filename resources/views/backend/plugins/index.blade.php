@extends('backend.layouts.app')
@section('content')
    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                 <div class="d-sm-flex align-items-center justify-space-between">
                         <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center me-3">
                        <i class="ti ti-arrow-left fs-5"></i> 
                    </a>
                    <div>
                        <h4 class="mb-4 mb-sm-0 card-title">Plugins</h4>
                        <p class="mb-0 text-muted"> Connect Ekoome with third-party tools.</p> 
                    </div>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex" href="{{ route('home') }}">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="product-wrapper-grid">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="card p-3">
                    <div class="product-box">
                        <div class="product-img"><img class="img-fluid"
                                src="{{ asset('public/plugins/whatsapp-confirmation.png') }}" alt="">
                            <div class="product-hover">
                                <ul>
                                    <li><a data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i
                                                class="icon-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-details text-center"><a href="{{ route('plugins.whatsapp.index') }}">
                                <h4>Whatsapp</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
