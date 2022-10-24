<!-- Customer Code Field -->
<div class="col-sm-12">
    {!! Form::label('customer_code', trans('customer_first_order.customer')) !!}
    <p>{{ $customerFirstOrder->customer_code }}</p>
</div>

<!-- First Order Number Field -->
<div class="col-sm-12">
    {!! Form::label('first_order_number', trans('customer_first_order.first_order_number')) !!}
    <p>{{ $customerFirstOrder->first_order_number }}</p>
</div>

<!-- First Order Date Field -->
<div class="col-sm-12">
    {!! Form::label('first_order_date', trans('customer_first_order.first_order_date')) !!}
    <p>{{ $customerFirstOrder->first_order_date }}</p>
</div>

<!-- Created By Field -->
<div class="col-sm-12">
    {!! Form::label('created_by', 'Created By:') !!}
    <p>{{ $customerFirstOrder->created_by }}</p>
</div>

<!-- Updated By Field -->
<div class="col-sm-12">
    {!! Form::label('updated_by', 'Updated By:') !!}
    <p>{{ $customerFirstOrder->updated_by }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $customerFirstOrder->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $customerFirstOrder->updated_at }}</p>
</div>

