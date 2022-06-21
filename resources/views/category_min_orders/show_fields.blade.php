<!-- Category Field -->
<div class="col-sm-12">
    {!! Form::label('category', trans('category_min_order.category')) !!}
    <p>{{ $categoryMinOrder->category }}</p>
</div>

<!-- Minimum Order Field -->
<div class="col-sm-12">
    {!! Form::label('minimum_order', trans('category_min_order.minimum_order')) !!}
    <p>{{ $categoryMinOrder->minimum_order }}</p>
</div>

<!-- Start Date Field -->
<div class="col-sm-12">
    {!! Form::label('start_date', trans('category_min_order.start_date')) !!}
    <p>{{ $categoryMinOrder->start_date }}</p>
</div>

<!-- End Date Field -->
<div class="col-sm-12">
    {!! Form::label('end_date', trans('category_min_order.end_date')) !!}
    <p>{{ $categoryMinOrder->end_date }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', trans('category_min_order.created_at')) !!}
    <p>{{ $categoryMinOrder->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', trans('category_min_order.deleted_at')) !!}
    <p>{{ $categoryMinOrder->updated_at }}</p>
</div>

