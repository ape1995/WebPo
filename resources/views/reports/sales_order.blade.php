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
              <h1 class="m-0">{{ trans('report.title_1') }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">{{ trans('menu.report') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('report.title_1') }}</li>
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
                            <form action="{{ route('reportSalesOrder.view') }}" method="post">
                                @csrf
                                <h5>{{ trans('report.order_date') }}</h5>
                                <div class="row mb-1">
                                    <div class="col-md-2">
                                        <label for="order_date">{{ trans('report.from') }}</label>
                                    </div>
                                    <div class="col-md-3">
                                        @if (isset($date1))
                                            <input type="date" class="form-control" name="date_1" id="date_1" value="{{ $date1 }}" required>
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
                                        @if (isset($date2))
                                            <input type="date" class="form-control" name="date_2" id="date_2" value="{{ $date2 }}" required>
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
                                        @if (isset($customer_id))
                                            <select name="customer_id" id="customer_id" class="form-control select2js" required>
                                                <option value="All">All Customers</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->BAccountID }}" {{ $customer->BAccountID == $customer_id ? 'selected' : '' }}>{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
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
                                        <label for="order_date">{{ trans('report.status') }}</label>
                                    </div>
                                    <div class="col-md-2">
                                        @if (isset($status))
                                            <select name="status" id="status" class="form-control select2js" required>
                                                <option value="All">All Status</option>
                                                <option value="R" {{ $status == "R" ? 'selected' : '' }}>Submitted</option>
                                                <option value="P" {{ $status == "P" ? 'selected' : '' }}>Processed</option>
                                                <option value="B" {{ $status == "B" ? 'selected' : '' }}>Rejected</option>
                                                <option value="C" {{ $status == "C" ? 'selected' : '' }}>Canceled</option>
                                            </select>
                                        @else    
                                            <select name="status" id="status" class="form-control select2js" required>
                                                <option value="All">All Status</option>
                                                <option value="R">Submitted</option>
                                                <option value="P">Processed</option>
                                                <option value="B">Rejected</option>
                                                <option value="C">Canceled</option>
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
                                            {{-- <tr class="table-borderless">
                                                <td>Date:</td>
                                                <td>{{ $date1 }} s/d {{ $date2 }}</td>
                                                <td>Customer :</td>
                                                <td>{{ $customer_id }}</td>
                                                <td>Status :</td>
                                                <td>{{ $status }}</td>
                                            </tr> --}}
                                            <tr>
                                                <th>No</th>
                                                <th>Order Date</th>
                                                <th>Delivery Date</th>
                                                <th>Order Nbr</th>
                                                <th>Customer Code</th>
                                                <th>Customer Name</th>
                                                <th>Order Qty</th>
                                                <th>Order Amount</th>
                                                <th>Discount</th>
                                                <th>Tax</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($salesOrders as $index => $salesOrder)
                                                <tr>
                                                    <td>{{ $index+1 }}</td>
                                                    <td>{{ $salesOrder->order_date->format('Y-m-d') }}</td>
                                                    <td>{{ $salesOrder->delivery_date->format('Y-m-d') }}</td>
                                                    <td>{{ $salesOrder->order_nbr }}</td>
                                                    <td>{{ $salesOrder->customer->AcctCD }}</td>
                                                    <td>{{ $salesOrder->customer->AcctName }}</td>
                                                    <td>{{ $salesOrder->order_qty }}</td>
                                                    <td>{{ $salesOrder->order_amount }}</td>
                                                    <td>{{ $salesOrder->discount }}</td>
                                                    <td>{{ $salesOrder->tax }}</td>
                                                    <td>{{ $salesOrder->order_total }}</td>
                                                    <td>{{ $salesOrder->status }}</td>
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