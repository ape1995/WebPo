<!-- Customer Code Field -->
<div class="col-sm-12">
    {!! Form::label('customer_code', 'Customer Code:') !!}
    <p>{{ $customerMinOrderHist->customer_code }}</p>
</div>

<!-- Old Price Field -->
<div class="col-sm-12">
    {!! Form::label('old_price', 'Old Price:') !!}
    <p>{{ $customerMinOrderHist->old_price }}</p>
</div>

<!-- New Price Field -->
<div class="col-sm-12">
    {!! Form::label('new_price', 'New Price:') !!}
    <p>{{ $customerMinOrderHist->new_price }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $customerMinOrderHist->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $customerMinOrderHist->updated_at }}</p>
</div>

