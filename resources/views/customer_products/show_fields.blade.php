<!-- Customer Code Field -->
<div class="col-sm-12">
    {!! Form::label('customer_code', 'Customer Code:') !!}
    <p>{{ $customerProduct->customer_code }}</p>
</div>

<!-- Inventory Code Field -->
<div class="col-sm-12">
    {!! Form::label('inventory_code', 'Inventory Code:') !!}
    <p>{{ $customerProduct->inventory_code }}</p>
</div>

<!-- Customer Class Field -->
<div class="col-sm-12">
    {!! Form::label('customer_class', 'Customer Class:') !!}
    <p>{{ $customerProduct->customer_class }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $customerProduct->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $customerProduct->updated_at }}</p>
</div>

