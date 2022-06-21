<!-- Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category', trans('category_min_order.category')) !!}
    <select name="category" id="category" class="form-control select2js" required>
        <option value="">-Choose-</option>
        <option value="DR" {{ $categoryMinOrder->category == 'DR' ? 'selected' : '' }}>Distributor - DR</option>
        <option value="DK" {{ $categoryMinOrder->category == 'DK' ? 'selected' : '' }}>Agen - DK</option>
    </select>
</div>

<!-- Minimum Order Field -->
<div class="form-group col-sm-6">
    {!! Form::label('minimum_order', trans('category_min_order.minimum_order')) !!}
    {!! Form::text('minimum_order', null, ['class' => 'form-control money']) !!}
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', trans('category_min_order.start_date')) !!}
    {!! Form::date('start_date', $categoryMinOrder->start_date , ['class' => 'form-control','id'=>'start_date']) !!}
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', trans('category_min_order.end_date')) !!}
    {!! Form::date('end_date', $categoryMinOrder->end_date , ['class' => 'form-control','id'=>'end_date']) !!}
</div>