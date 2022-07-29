<!-- Date Field -->
<div class="col-sm-12">
    {!! Form::label('date', 'Date:') !!}
    <p>{{ $productScheduler->date }}</p>
</div>

<!-- Inventory Code Field -->
<div class="col-sm-12">
    {!! Form::label('inventory_code', 'Inventory Code:') !!}
    <p>{{ $productScheduler->inventory_code }}</p>
</div>

<!-- Customer Class Field -->
<div class="col-sm-12">
    {!! Form::label('customer_class', 'Customer Class:') !!}
    <p>{{ $productScheduler->customer_class }}</p>
</div>

<!-- Action Type Field -->
<div class="col-sm-12">
    {!! Form::label('action_type', 'Action Type:') !!}
    <p>{{ $productScheduler->action_type }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $productScheduler->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $productScheduler->updated_at }}</p>
</div>

