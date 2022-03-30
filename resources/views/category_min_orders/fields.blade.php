<!-- Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category', 'Category:') !!}
    <select name="category" id="category" class="form-control select2js" required>
        <option value="">-Choose-</option>
        <option value="DR">Distributor - DR</option>
        <option value="DK">Agen - DK</option>
    </select>
</div>

<!-- Minimum Order Field -->
<div class="form-group col-sm-6">
    {!! Form::label('minimum_order', 'Minimum Order:') !!}
    {!! Form::text('minimum_order', null, ['class' => 'form-control money']) !!}
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start Date:') !!}
    {!! Form::date('start_date', null, ['class' => 'form-control','id'=>'start_date']) !!}
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    {!! Form::date('end_date', null, ['class' => 'form-control','id'=>'end_date']) !!}
</div>