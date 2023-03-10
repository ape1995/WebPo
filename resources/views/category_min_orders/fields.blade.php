<!-- Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category', trans('category_min_order.category')) !!}
    <select name="category" id="category" class="form-control select2js" required>
        <option value="">-Choose-</option>
        <option value="DR">Distributor - DR</option>
        <option value="DK">Agen - DK</option>
        <option value="INSTI">Institusi - INSTI</option>
    </select>
</div>

<!-- Minimum Order Field -->
<div class="form-group col-sm-6">
    {!! Form::label('minimum_order', trans('category_min_order.minimum_order')) !!}
    {!! Form::text('minimum_order', null, ['class' => 'form-control money', 'required' => true]) !!}
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', trans('category_min_order.start_date')) !!}
    {!! Form::date('start_date', null, ['class' => 'form-control','id'=>'start_date', 'required' => true]) !!}
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', trans('category_min_order.end_date')) !!}
    {!! Form::date('end_date', null, ['class' => 'form-control','id'=>'end_date']) !!}
</div>