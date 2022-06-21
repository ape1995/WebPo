<!-- Packet Code Field -->
<div class="col-sm-12">
    {!! Form::label('packet_code', 'Packet Code:') !!}
    <p>{{ $cartPromo->packet_code }}</p>
</div>

<!-- Qty Field -->
<div class="col-sm-12">
    {!! Form::label('qty', 'Qty:') !!}
    <p>{{ $cartPromo->qty }}</p>
</div>

<!-- Unit Price Field -->
<div class="col-sm-12">
    {!! Form::label('unit_price', 'Unit Price:') !!}
    <p>{{ $cartPromo->unit_price }}</p>
</div>

<!-- Total Field -->
<div class="col-sm-12">
    {!! Form::label('total', 'Total:') !!}
    <p>{{ $cartPromo->total }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $cartPromo->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $cartPromo->updated_at }}</p>
</div>

