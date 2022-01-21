<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('assets/images/yamazaki.ico') }}">
  <meta name="theme-color" content="#c61325"/>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>


  {{-- Datatables --}}
  {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/> --}}
  {{-- @yield('css') --}}
  <style>
    body {
        font-size: 14px;
    }
    label{
      font-size: 12px !important;
    }
    .money{
      text-align: right;
    }
    .carousel-inner img {
      width: 100%;
      height: 100%;
    }
    .table-borderless td,
    .table-borderless th {
        border: 0;
    }
  </style>
</head>
<body>
        <img src="{{ public_path('assets/images/yamazaki.png') }}" width="20%">
        <img src="{{ public_path('assets/images/my-roti.png') }}" width="15%">
    <div class="card">

        <div class="card-body">
            <table class="table table-borderless table-sm">
                <tr>
                    <td>{!! Form::label('order_nbr', 'Order Nbr') !!}</td>
                    <td>: {!! Form::label('order_nbr', $salesOrder->order_nbr) !!}</td>
                    <td>{!! Form::label('order_qty', 'Order Qty') !!}</td>
                    <td>: {!! Form::label('order_qty', $salesOrder->order_qty) !!}</td>
                </tr>
                <tr>
                    <td>{!! Form::label('customer_id', 'Customer') !!}</td>
                    <td>: {!! Form::label('customer_id', $salesOrder->customer->AcctName .'-'. $salesOrder->customer->AcctCD) !!}</td>
                    <td>{!! Form::label('order_amount', 'Order Amount') !!}</td>
                    <td>: {!! Form::label('order_amount', number_format($salesOrder->order_amount, 2, ',', '.')) !!}</td>
                </tr>
                <tr>
                    <td>{!! Form::label('order_date', 'Order Date') !!}</td>
                    <td>: {!! Form::label('order_date', $salesOrder->order_date->format('d F Y')) !!}</td>
                    <td>{!! Form::label('tax', 'Tax:') !!}</td>
                    <td>: {!! Form::label('tax', number_format($salesOrder->tax, 2, ',', '.')) !!}</td>
                </tr>
                <tr>
                    <td>{!! Form::label('delivery_date', 'Delivery Date') !!}</td>
                    <td>: {!! Form::label('delivery_date', $salesOrder->delivery_date->format('d F Y')) !!}</td>
                    <td>{!! Form::label('order_total', 'Order Total:') !!}</td>
                    <td>: {!! Form::label('order_total', number_format($salesOrder->order_total, 2, ',', '.')) !!}</td>
                </tr>
                <tr>
                    <td>{!! Form::label('description', 'Description') !!}</td>
                    <td>: {!! Form::label('description', $salesOrder->description) !!}</td>
                    <td>{!! Form::label('order_type', 'Order Type') !!}</td>
                    <td>: {!! Form::label('description', $salesOrder->order_type == 'R' ? "Regular" : "Direct Selling") !!}</td>
                </tr>
            </table>
            <hr>
            <table class="table table-sm" id="salesOrderDetails-table">
                <thead>
                <tr>
                    <th>Inventory Id</th>
                    <th>Inventory Name</th>
                    <th>Qty</th>
                    <th>Uom</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($salesOrderDetails as $salesOrderDetail)
                    <tr>
                        <td>{{ $salesOrderDetail->inventory_id }}</td>
                        <td>{{ $salesOrderDetail->inventory_name }}</td>
                        <td class="money">{{ $salesOrderDetail->qty }}</td>
                        <td>{{ $salesOrderDetail->uom }}</td>
                        <td class="money">{{ number_format($salesOrderDetail->unit_price,2,',','.') }}</td>
                        <td class="money">{{ number_format($salesOrderDetail->amount,2,',','.') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            
        
        </div>

    </div>

</body>
</html>