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
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>
    @hasSection('title')
      @yield('title')
    @else
      {{ config('app.name') }}
    @endif
  </title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>


  {{-- Datatables --}}
  {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/> --}}
  @yield('css')
  <style>
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
  </style>
</head>
<body>

    <div class="container">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <!-- Order Nbr Field -->
                            <div class="col-sm-12 mb-1">
                                <div class="row">
                                    <div class="col-3">
                                        {!! Form::label('order_nbr', 'Order Nbr:') !!}
                                    </div>
                                    <div class="col-8">
                                        {!! Form::text('order_nbr', $salesOrder->order_nbr, ['class' => 'form-control', 'readonly' => true]) !!}
                                    </div>
                                </div>
                            </div>
                            <!-- Customer Id Field -->
                            <div class="col-sm-12 mb-1">
                                <div class="row">
                                    <div class="col-3">
                                        {!! Form::label('customer_id', 'Customer:') !!}
                                    </div>
                                    <div class="col-8">
                                        {!! Form::text('customer_id', $salesOrder->customer->AcctName .'-'. $salesOrder->customer->AcctCD, ['class' => 'form-control', 'readonly' => true]) !!}
                                    </div>
                                </div>
                            </div>
                            <!-- Order Date Field -->
                            <div class="col-sm-12 mb-1">
                                <div class="row">
                                    <div class="col-3">
                                        {!! Form::label('order_date', 'Order Date:') !!}
                                    </div>
                                    <div class="col-8">
                                        {!! Form::date('order_date', $salesOrder->order_date, ['class' => 'form-control','id'=>'order_date', 'readonly' => true, 'min' => date('Y-m-d')]) !!}
                                    </div>
                                </div>
                            </div>
                            <!-- Delivery Date Field -->
                            <div class="col-sm-12 mb-1">
                                <div class="row">
                                    <div class="col-3">
                                        {!! Form::label('delivery_date', 'Delivery Date:') !!}
                                    </div>
                                    <div class="col-8">
                                        {!! Form::date('delivery_date', $salesOrder->delivery_date, ['class' => 'form-control','id'=>'delivery_date', 'readonly' => true, 'min' => date('Y-m-d')]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="row">
                            <!-- Order Qty Field -->
                            <div class="col-sm-12 mb-1">
                                <div class="row">
                                    <div class="col-3">
                                        {!! Form::label('order_qty', 'Order Qty:') !!}
                                    </div>
                                    <div class="col-8">
                                        {!! Form::text('order_qty', $salesOrder->order_qty, ['class' => 'form-control', 'readonly' => true ]) !!}
                                    </div>
                                </div>
                            </div>
                            <!-- Order Amount Field -->
                            <div class="col-sm-12 mb-1">
                                <div class="row">
                                    <div class="col-3">
                                        {!! Form::label('order_amount', 'Order Amount:') !!}
                                    </div>
                                    <div class="col-8">
                                        {!! Form::text('order_amount', number_format($salesOrder->order_amount, 2, ',', '.'), ['class' => 'form-control money', 'readonly' => true]) !!}
                                    </div>
                                </div>
                            </div>
                            <!-- Tax Field -->
                            <div class="col-sm-12 mb-1">
                                <div class="row">
                                    <div class="col-3">
                                        {!! Form::label('tax', 'Tax:') !!}
                                    </div>
                                    <div class="col-8">
                                        {!! Form::text('tax', number_format($salesOrder->tax, 2, ',', '.'), ['class' => 'form-control money', 'readonly' => true]) !!}
                                    </div>
                                </div>
                            </div>
                            <!-- Order Total Field -->
                            <div class="col-sm-12 mb-1">
                                <div class="row">
                                    <div class="col-3">
                                        {!! Form::label('order_total', 'Order Total:') !!}
                                    </div>
                                    <div class="col-8">
                                        {!! Form::text('order_total', number_format($salesOrder->order_total, 2, ',', '.'), ['class' => 'form-control money', 'readonly' => true]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description Field -->
                    <div class="col-sm-12">
                        {!! Form::label('description', 'Description:') !!}
                        {!! Form::textarea('description', $salesOrder->description, ['class' => 'form-control', 'rows' => 2, 'readonly' => true ]) !!}
                    </div>
                </div>

                <div class="table-responsive mt-3">
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
                                <td>{{ $salesOrderDetail->qty }}</td>
                                <td>{{ $salesOrderDetail->uom }}</td>
                                <td>{{ number_format($salesOrderDetail->unit_price,2,',','.') }}</td>
                                <td>{{ number_format($salesOrderDetail->amount,2,',','.') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                
            
            </div>

        </div>
    </div>

</body>
</html>