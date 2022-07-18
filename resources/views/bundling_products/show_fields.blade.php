<!-- Start Date Field -->
<div class="col-sm-12">
    {!! Form::label('start_date', 'Start Date:') !!}
    <p>{{ $bundlingProduct->start_date }}</p>
</div>

<!-- End Date Field -->
<div class="col-sm-12">
    {!! Form::label('end_date', 'End Date:') !!}
    <p>{{ $bundlingProduct->end_date }}</p>
</div>

<!-- Product Code Field -->
<div class="col-sm-12">
    {!! Form::label('product_code', 'Product Code:') !!}
    <p>{{ $bundlingProduct->product_code }}</p>
</div>

<!-- Qty Field -->
<div class="col-sm-12">
    {!! Form::label('qty', 'Qty:') !!}
    <p>{{ $bundlingProduct->qty }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $bundlingProduct->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $bundlingProduct->updated_at }}</p>
</div>

