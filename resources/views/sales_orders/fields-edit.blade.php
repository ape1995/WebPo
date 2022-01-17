<div class="col-md-6">
    <div class="row">
        <!-- Order Nbr Field -->
        <div class="col-sm-12 mb-1">
            <div class="row">
                <div class="col-3">
                    {!! Form::label('order_nbr', 'Order Nbr:') !!}
                </div>
                <div class="col-8">
                    <input type="hidden" name="order_id" id="order_id" value="{{ $salesOrder->id }}">
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
                    <select name="order_type" id="order_type" class="form-control select2js" required>
                        <option value="R" {{ $salesOrder->order_type == 'R' ? 'selected' : '' }}>REGULAR</option>
                        <option value="D" {{ $salesOrder->order_type == 'D' ? 'selected' : '' }}>DIRECT SELLING</option>
                    </select>
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
                            <option value="{{ $customer->BAccountID }}" {{ $customer->BAccountID == $salesOrder->customer_id ? 'selected' : '' }}>{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
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
                    {!! Form::date('delivery_date', $salesOrder->delivery_date, ['class' => 'form-control','id'=>'delivery_date', 'required' => true, 'min' => date('Y-m-d')]) !!}
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
                    {!! Form::text('order_qty', null, ['class' => 'form-control money', 'readonly' => true ]) !!}
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
                    {!! Form::text('order_amount', null, ['class' => 'form-control money', 'readonly' => true]) !!}
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
                    {!! Form::text('tax', null, ['class' => 'form-control money', 'readonly' => true]) !!}
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
                    {!! Form::text('order_total', null, ['class' => 'form-control money', 'readonly' => true]) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 2, 'required' => true ]) !!}
</div>