@extends('layouts.app')

@if (isset($reportName))
    @section('title')
        {{ $reportName }}
    @endsection
@endif

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Report Bundling Gimmick</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">{{ trans('menu.report') }}</a></li>
                <li class="breadcrumb-item active">Bundling Gimmick</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('reportSalesOrder.reportBGimmickView') }}" method="post">
                                @csrf
                                <div class="row mb-1">
                                    <div class="col-md-2">
                                        <label for="order_date">{{ trans('report.order_date') }} </label>
                                    </div>
                                    <div class="col-md-3">
                                        @if (isset($date_1_selected))
                                            <input type="date" class="form-control" name="date_1" id="date_1" value="{{ $date_1_selected }}" required>
                                        @else
                                            <input type="date" class="form-control" name="date_1" id="date_1" required>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-md-2">
                                        <label for="order_date">{{ trans('report.to') }}</label>
                                    </div>
                                    <div class="col-md-3">
                                        @if (isset($date_2_selected))
                                            <input type="date" class="form-control" name="date_2" id="date_2" value="{{ $date_2_selected }}" required>
                                        @else
                                            <input type="date" class="form-control" name="date_2" id="date_2" required>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-md-2">
                                        <label for="order_date">{{ trans('report.customer') }}</label>
                                    </div>
                                    <div class="col-md-5">
                                        @if (\Auth::user()->role == 'Customers' || \Auth::user()->role == 'Staff Customer')
                                            <select name="customer_id" id="customer_id" class="form-control select2js" required>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->BAccountID }}">{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            @if (isset($customer_id_selelcted))
                                                <select name="customer_id" id="customer_id" class="form-control select2js" required>
                                                    <option value="All">All Customers</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->BAccountID }}" {{ $customer->BAccountID == $customer_id_selelcted ? 'selected' : '' }}>{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <select name="customer_id" id="customer_id" class="form-control select2js" required>
                                                    <option value="All">All Customers</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->BAccountID }}">{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-md-2">
                                        <label for="status">{{ trans('report.status') }}</label>
                                    </div>
                                    <div class="col-md-2"> 
                                        @if (isset($status_selected))
                                            <select name="status" id="status" class="form-control select2js" required>
                                                {{-- <option value="All" {{ $status_selected == 'All' ? 'selected' : '' }}>All</option> --}}
                                                {{-- <option value="S" {{ $status_selected == 'S' ? 'selected' : '' }}>Draft</option> --}}
                                                {{-- <option value="R" {{ $status_selected == 'R' ? 'selected' : '' }}>Submitted</option> --}}
                                                <option value="P" {{ $status_selected == 'P' ? 'selected' : '' }}>Processed</option>
                                            </select>
                                        @else
                                            <select name="status" id="status" class="form-control select2js" required>
                                                {{-- <option value="All">All</option> --}}
                                                {{-- <option value="S">Draft</option> --}}
                                                {{-- <option value="R">Submitted</option> --}}
                                                <option value="P">Processed</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-2">
                                        <input type="submit" class="btn btn-primary btn-block" value="View">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @if (isset($salesOrders))
                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-sm" id="sales-order-table">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Order Type</th>
                                                <th>Order Nbr</th>
                                                <th>Customer ID</th>
                                                <th>Customer Name</th>  
                                                <th>Order Date</th>
                                                <th>Delivery Date</th>
                                                <th>Quantity</th>
                                                <th>Amount RBP</th>
                                                <th>Tax RBP</th>
                                                <th>Total Amount RBP</th>
                                                <th>Amount CBP</th>
                                                <th>Tax CBP</th>
                                                <th>Total Amount CBP</th>
                                                <th>Price Gimmick Each</th>
                                                <th>Qty Gimmick</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($salesOrders as $salesOrder)
                                                <tr>
                                                    @php
                                                        if($salesOrder->status == 'S'){
                                                            $statusOrder = 'Draft';
                                                        } else if ($salesOrder->status == 'R') {
                                                            $statusOrder = 'Submitted';
                                                        } else if($salesOrder->status == 'P'){
                                                            $statusOrder = 'Processed';
                                                        } else {
                                                            $statusOrder = 'Canceled';
                                                        }
                                                        
                                                    @endphp
                                                    <td>{{ $statusOrder }}</td>
                                                    <td>Bundling Gimmick</td>
                                                    <td>{{$salesOrder->order_nbr}}</td>
                                                    <td>{{$salesOrder->customer->AcctCD}}</td>
                                                    <td>{{$salesOrder->customer->AcctName}}</td>
                                                    <td>{{ $salesOrder->order_date->format('Y-m-d') }}</td>
                                                    <td>{{ $salesOrder->delivery_date->format('Y-m-d') }}</td>
                                                    <td>{{ $salesOrder->qty }}</td>
                                                    <td>{{ number_format($salesOrder->order_amount, 2) }}</td>
                                                    <td>{{ number_format($salesOrder->tax,2) }}</td>
                                                    <td>{{ number_format($salesOrder->order_total, 2) }}</td>
                                                    <td>{{ number_format($salesOrder->cbp_total, 2) }}</td>
                                                    <td>{{ number_format($salesOrder->cbp_tax, 2) }}</td>
                                                    <td>{{ number_format($salesOrder->cbp_grand_total, 2) }}</td>
                                                    <td>{{ number_format($salesOrder->nominal, 2) }}</td>
                                                    @php
                                                        $totalGimmick = ( $salesOrder->cbp_grand_total / $salesOrder->nominal * $salesOrder->free_qty);
                                                    @endphp
                                                    <td>{{ floor($totalGimmick) }}</td>
                                                    <td>{{ $salesOrder->free_descr }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @section('css')
                            <link rel="stylesheet" href="{{ asset('assets/css/buttons.dataTables.min.css') }}">
                        @endsection
                        @push('page_scripts')
                            <script src="{{ asset('assets/js/dataTables.buttons.min.js') }}"></script>
                            <script src="{{ asset('assets/js/buttons.html5.min.js') }}"></script>
                            <script src="{{ asset('assets/js/jszip.min.js') }}"></script>
                            <script>
                            $(document).ready(function() {
                                $('#sales-order-table').DataTable({
                                    columnDefs: [
                                        { 
                                            orderable: false,
                                            className: "text-nowrap",
                                            targets: "_all" 
                                        }
                                    ],
                                    searching: false,
                                    
                                    dom: 'Bfrtip',
                                    buttons: [
                                        'excelHtml5',
                                        'csvHtml5',
                                    ],
                                    "paging":   false,
                                    "ordering": false,
                                    "info":     false,
                                });
                            });
                            </script>
                        @endpush
                    @endif
                </div>
                <!-- /.col-md-6 -->
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('css')
    <style>
        .table-borderless > tbody > tr > td,
        .table-borderless > tbody > tr > th,
        .table-borderless > tfoot > tr > td,
        .table-borderless > tfoot > tr > th,
        .table-borderless > thead > tr > td,
        .table-borderless > thead > tr > th {
            border: none;
        }
    </style>
@endsection