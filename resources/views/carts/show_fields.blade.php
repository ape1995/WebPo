<!-- Inventory Id Field -->
<div class="col-sm-12">
    {!! Form::label('inventory_id', 'Inventory Id:') !!}
    <p>{{ $cart->inventory_id }}</p>
</div>

<!-- Inventory Name Field -->
<div class="col-sm-12">
    {!! Form::label('inventory_name', 'Inventory Name:') !!}
    <p>{{ $cart->inventory_name }}</p>
</div>

<!-- Qty Field -->
<div class="col-sm-12">
    {!! Form::label('qty', 'Qty:') !!}
    <p>{{ $cart->qty }}</p>
</div>

<!-- Uom Field -->
<div class="col-sm-12">
    {!! Form::label('uom', 'Uom:') !!}
    <p>{{ $cart->uom }}</p>
</div>

<!-- Unit Price Field -->
<div class="col-sm-12">
    {!! Form::label('unit_price', 'Unit Price:') !!}
    <p>{{ $cart->unit_price }}</p>
</div>

<!-- Amount Field -->
<div class="col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $cart->amount }}</p>
</div>

<!-- Created By Field -->
<div class="col-sm-12">
    {!! Form::label('created_by', 'Created By:') !!}
    <p>{{ $cart->created_by }}</p>
</div>

<!-- Updated By Field -->
<div class="col-sm-12">
    {!! Form::label('updated_by', 'Updated By:') !!}
    <p>{{ $cart->updated_by }}</p>
</div>

<!-- Customer Id Field -->
<div class="col-sm-12">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    <p>{{ $cart->customer_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $cart->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $cart->updated_at }}</p>
</div>

