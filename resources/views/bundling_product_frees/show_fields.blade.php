<!-- Bundling Product Id Field -->
<div class="col-sm-12">
    {!! Form::label('bundling_product_id', 'Bundling Product Id:') !!}
    <p>{{ $bundlingProductFree->bundling_product_id }}</p>
</div>

<!-- Product Code Field -->
<div class="col-sm-12">
    {!! Form::label('product_code', 'Product Code:') !!}
    <p>{{ $bundlingProductFree->product_code }}</p>
</div>

<!-- Qty Field -->
<div class="col-sm-12">
    {!! Form::label('qty', 'Qty:') !!}
    <p>{{ $bundlingProductFree->qty }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $bundlingProductFree->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $bundlingProductFree->updated_at }}</p>
</div>

