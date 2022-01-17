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
        <!-- Order Type Field -->
        <div class="col-sm-12 mb-1">
            <div class="row">
                <div class="col-3">
                    {!! Form::label('order_type', 'Order Type:') !!}
                </div>
                <div class="col-8">
                    {!! Form::text('order_type', $salesOrder->order_type == 'R' ? "Regular" : "Direct Selling", ['class' => 'form-control', 'readonly' => true]) !!}
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
                    <select name="customer_id" id="customer_id" class="form-control" readonly>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->BAccountID }}">{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
                        @endforeach
                    </select>
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
        <div class="col-sm-12 mb-1" @can('hide price sales order') style="visibility: collapse" @endcan>
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
        <div class="col-sm-12 mb-1" @can('hide price sales order') style="visibility: collapse" @endcan>
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
        <div class="col-sm-12 mb-1" @can('hide price sales order') style="visibility: collapse" @endcan>
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