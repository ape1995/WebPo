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
              <h1 class="m-0">Report Bundling Discount</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">{{ trans('menu.report') }}</a></li>
                <li class="breadcrumb-item active">Bundling Discount</li>
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
                            <form action="{{ route('reportSalesOrder.reportBDiscountView') }}" method="post">
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
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-md-2">
                                        <label for="status">{{ trans('report.status') }}</label>
                                    </div>
                                    <div class="col-md-2"> 
                                        <select name="status" id="status" class="form-control select2js" required>
                                            <option value="P">Processed</option>
                                        </select>
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
                                                <th>Order Type</th>
                                                <th>Branch</th>
                                                <th>Order Nbr</th>
                                                <th>Customer ID</th>
                                                <th>Customer Name</th>
                                                <th>Outlet ID</th>
                                                <th>Outlet Name</th>
                                                <th>Rit</th>
                                                <th>Product ID</th>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Delivery Date</th>
                                                <th>Group</th>
                                                <th>WAREHOUSE</th>
                                                <th>Diskon Persen</th>
                                                <th>Description</th>
                                                <th>Type Delivery</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($salesOrders as $salesOrder)
                                                @foreach ($salesOrder->detail as $detail)
                                                    <tr>
                                                    <td>AD</td>
                                                    <td>F01</td>
                                                    <td>{{ $salesOrder->order_nbr_merge }}</td>
                                                    <td>{{ $salesOrder->customer->AcctCD }}</td>
                                                    <td>{{ $salesOrder->customer->AcctName }}</td>
                                                    <td>{{ $salesOrder->customer->outlet == null ? '' : $salesOrder->customer->outlet->OutletID }}</td>
                                                    <td>{{ $salesOrder->customer->outlet == null ? '' : $salesOrder->customer->outlet->OutletName }}</td>
                                                    <td>{{ $salesOrder->customer->outlet == null ? '' : $salesOrder->customer->outlet->RitID }}</td>
                                                    <td>{{ $detail->inventory_id }}</td>
                                                    <td>{{ $detail->inventory_name }}</td>
                                                    <td>{{ $detail->qty }}</td>
                                                    <td>{{ $salesOrder->delivery_date->format('Y-m-d') }}</td>
                                                    <td>{{ $salesOrder->customer->outlet == null ? '' : $salesOrder->customer->outlet->UsrRitNbr }}</td>
                                                    <td>WH03FG</td>
                                                    <td>{{ floor($detail->discount / ($detail->qty * $detail->unit_price) * 100) }}</td>
                                                    <td></td>
                                                    <td>{{ $salesOrder->customer->delivery->Value }}</td>
                                                @endforeach
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