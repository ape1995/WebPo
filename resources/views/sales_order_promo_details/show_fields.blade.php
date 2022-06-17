<!-- Sales Order Promo Id Field -->
<div class="col-sm-12">
    {!! Form::label('sales_order_promo_id', 'Sales Order Promo Id:') !!}
    <p>{{ $salesOrderPromoDetail->sales_order_promo_id }}</p>
</div>

<!-- Packet Code Field -->
<div class="col-sm-12">
    {!! Form::label('packet_code', 'Packet Code:') !!}
    <p>{{ $salesOrderPromoDetail->packet_code }}</p>
</div>

<!-- Qty Field -->
<div class="col-sm-12">
    {!! Form::label('qty', 'Qty:') !!}
    <p>{{ $salesOrderPromoDetail->qty }}</p>
</div>

<!-- Unit Price Field -->
<div class="col-sm-12">
    {!! Form::label('unit_price', 'Unit Price:') !!}
    <p>{{ $salesOrderPromoDetail->unit_price }}</p>
</div>

<!-- Total Field -->
<div class="col-sm-12">
    {!! Form::label('total', 'Total:') !!}
    <p>{{ $salesOrderPromoDetail->total }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $salesOrderPromoDetail->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $salesOrderPromoDetail->updated_at }}</p>
</div>

