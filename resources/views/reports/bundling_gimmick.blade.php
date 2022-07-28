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
                                                <th>Order Nbr</th>
                                                <th>Customer ID</th>
                                                <th>Customer Name</th>  
                                                <th>Order Date</th>
                                                <th>Delivery Date</th>
                                                <th>Quantity</th>
                                                <th>Amount</th>
                                                <th>Tax</th>
                                                <th>Total Amount</th>
                                                <th>Qty Gimmick</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($salesOrders as $salesOrder)
                                                <tr>
                                                    <td>Bundling Gimmick</td>
                                                    <td>{{$salesOrder->order_nbr}}</td>
                                                    <td>{{$salesOrder->customer->AcctCD}}</td>
                                                    <td>{{$salesOrder->customer->AcctName}}</td>
                                                    <td>{{ $salesOrder->order_date->format('Y-m-d') }}</td>
                                                    <td>{{ $salesOrder->delivery_date->format('Y-m-d') }}</td>
                                                    <td>{{ $salesOrder->order_qty }}</td>
                                                    <td>{{ $salesOrder->order_amount }}</td>
                                                    <td>{{ $salesOrder->order_tax }}</td>
                                                    <td>{{ $salesOrder->order_total }}</td>
                                                    @php
                                                        $totalGimmick = $salesOrder->order_total / ($gimmick->nominal * $gimmick->free_qty);
                                                    @endphp
                                                    <td>{{ floor($totalGimmick) }}</td>
                                                    <td>{{ $gimmick->free_descr }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @section('css')
                            <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css"> 
                        @endsection
                        @push('page_scripts')
                            <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
                            <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
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