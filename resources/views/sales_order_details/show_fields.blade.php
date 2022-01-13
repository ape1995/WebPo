<!-- Sales Order Id Field -->
<div class="col-sm-12">
    {!! Form::label('sales_order_id', 'Sales Order Id:') !!}
    <p>{{ $salesOrderDetail->sales_order_id }}</p>
</div>

<!-- Inventory Id Field -->
<div class="col-sm-12">
    {!! Form::label('inventory_id', 'Inventory Id:') !!}
    <p>{{ $salesOrderDetail->inventory_id }}</p>
</div>

<!-- Inventory Name Field -->
<div class="col-sm-12">
    {!! Form::label('inventory_name', 'Inventory Name:') !!}
    <p>{{ $salesOrderDetail->inventory_name }}</p>
</div>

<!-- Qty Field -->
<div class="col-sm-12">
    {!! Form::label('qty', 'Qty:') !!}
    <p>{{ $salesOrderDetail->qty }}</p>
</div>

<!-- Uom Field -->
<div class="col-sm-12">
    {!! Form::label('uom', 'Uom:') !!}
    <p>{{ $salesOrderDetail->uom }}</p>
</div>

<!-- Unit Price Field -->
<div class="col-sm-12">
    {!! Form::label('unit_price', 'Unit Price:') !!}
    <p>{{ $salesOrderDetail->unit_price }}</p>
</div>

<!-- Amount Field -->
<div class="col-sm-12">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $salesOrderDetail->amount }}</p>
</div>

<!-- Created By Field -->
<div class="col-sm-12">
    {!! Form::label('created_by', 'Created By:') !!}
    <p>{{ $salesOrderDetail->created_by }}</p>
</div>

<!-- Updated By Field -->
<div class="col-sm-12">
    {!! Form::label('updated_by', 'Updated By:') !!}
    <p>{{ $salesOrderDetail->updated_by }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $salesOrderDetail->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $salesOrderDetail->updated_at }}</p>
</div>

