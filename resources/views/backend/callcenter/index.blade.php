@extends('backend.layouts.app')
@section('content')

    <style>
        .dropdown-menu.show {
            display: block;
        }
    </style>

    <!-- Page wrapper  -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-8 align-self-center ">
                        <h4 class="fw-bold py-3 mb-4 " style="display: -webkit-inline-box;"><span
                                class="text-muted fw-light">Dashboard /</span> Analyses Call Center&nbsp;

                        </h4>
                    </div>

                </div>
            </div>
            <!-- Start Page Content -->
            <div class="row my-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group-1">

                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'callcenter.filter', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'callcenter']) }}
                                @php
                                    $agent_id = isset($agent_id) ? $agent_id : '';
                                @endphp
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="input-group">
                                            <select class="select2 form-control custom-select"
                                                style="width: 100%; height:36px;" name="agent">
                                                <option value='all'>Select All Agent</option>
                                                @foreach ($agents_all->get() as $agent)
                                                    @if ($agent->id == $agent_id)
                                                        <option value="{{ $agent->id }}" selected>{{ $agent->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                                    @endif
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <div class='input-group mb-3'>
                                            @php
                                                $date = isset($date) ? $date : old(date);
                                                $date2 = isset($date2) ? $date2 : old(date2);
                                            @endphp
                                            <input type='date' name="date" value="{{ $date }}"
                                                class="form-control " />
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3">
                                        <div class='input-group mb-3'>
                                            <input type='date' name="date2" value="{{ $date2 }}"
                                                class="form-control " />
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-sm-12">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary"> Submit </button>
                                        </div>
                                    </div>

                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive" style="text-align:center">
                                <table id="demo-foo-addrow"
                                    class="table table-bordered table-striped table-hover contact-list table-fixed"
                                    data-paging="true" data-paging-size="10">
                                    <thead>
                                        <tr>
                                            <th>No (id) </th>
                                            <th>Name</th>
                                            <th>NB.Order Traits</th>
                                            <th>NB. calls</th>
                                            <th>confirmed</th>
                                            <th>canceled</th>
                                            <th>NO answer</th>
                                            <th>call later</th>
                                            <th>Wrong</th>
                                            <th>Duplicated</th>
                                            <th>Delivered</th>
                                            <th>Action</th>
                                            {{--   <th>Action</th>  --}}
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @if (isset($agents_details))
                                            @foreach ($agents_details->get() as $item)
                                                <tr>
                                                    @if ($item->VerifyLeads($item->id, $date, $date2)->count() > 1)
                                                        <td>{{ $item->id }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->CountLeads($item->id, $date, $date2) }}</td>
                                                        <td>{{ $item->CountCalls($item->id, $date, $date2) }}</td>
                                                        <td>{{ $item->Rate($item->id, $date, $date2, 'confirmed') }}
                                                            {{ count($item->CountTypeCall($item->id, $date, $date2, 'confirmed')) }}
                                                        </td>
                                                        <td>{{ $item->Rate($item->id, $date, $date2, 'canceled') }}
                                                            {{ count($item->CountTypeCall($item->id, $date, $date2, 'canceled')) }}
                                                        </td>
                                                        <td>{{ count($item->CountTypeCall($item->id, $date, $date2, 'NO answer')) }}
                                                        </td>
                                                        <td>{{ count($item->CountTypeCall($item->id, $date, $date2, 'call later')) }}
                                                        </td>
                                                        <td>{{ count($item->CountTypeCall($item->id, $date, $date2, 'Wrong')) }}
                                                        </td>
                                                        <td>{{ count($item->CountTypeCall($item->id, $date, $date2, 'Duplicated')) }}
                                                        </td>
                                                        <td>{{ $item->CountDelivered($item->id, $date, $date2) }}</td>
                                                        <td>

                                                            <div class="dropdown">
                                                                <button class="btn p-0" type="button" id="earningReports"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-end"
                                                                    aria-labelledby="earningReports">
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('callcenter.details', $item->id . '&' . $date . '&' . $date2) }}"><i
                                                                            class="mdi mdi-cards-variant"></i> Details</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @else
                                                        @if (Request::segment(2) == 'filter' && $agent_id != 'all')
                                                            <td colspan="12">
                                                                No Record
                                                            </td>
                                                        @endif
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right sidebar -->
            <!-- ============================================================== -->
            <!-- .right-sidebar -->
            <!-- ============================================================== -->
            <!-- End Right sidebar -->
            <!-- ============================================================== -->
        </div>

        <div id="chart"></div>
        <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl">
                <div
                    class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
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

    </div>

    <!-- End Page wrapper  -->
@endsection
