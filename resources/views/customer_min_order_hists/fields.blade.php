<!-- Customer Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_code', 'Customer Code:') !!}
    {!! Form::text('customer_code', null, ['class' => 'form-control']) !!}
</div>

<!-- Old Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('old_price', 'Old Price:') !!}
    {!! Form::number('old_price', null, ['class' => 'form-control']) !!}
</div>

<!-- New Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('new_price', 'New Price:') !!}
    {!! Form::number('new_price', null, ['class' => 'form-control']) !!}
</div>