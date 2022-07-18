<!-- Bundling Product Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('bundling_product_id', 'Bundling Product Id:') !!}
    {!! Form::number('bundling_product_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Product Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('product_code', 'Product Code:') !!}
    {!! Form::text('product_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Qty Field -->
<div class="form-group col-sm-6">
    {!! Form::label('qty', 'Qty:') !!}
    {!! Form::number('qty', null, ['class' => 'form-control']) !!}
</div>