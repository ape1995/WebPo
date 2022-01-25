<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('value', 'Value:') !!}
    {!! Form::number('value', null, ['class' => 'form-control']) !!}
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start Date:') !!}
    @if (isset($parameterVAT))
        <input type="date" class="form-control" name="start_date" id="start_date" value="{{ $parameterVAT->start_date->format('Y-m-d') }}">
    @else 
        {!! Form::date('start_date', null, ['class' => 'form-control','id'=>'start_date']) !!}
    @endif
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    @if (isset($parameterVAT))
        <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $parameterVAT->end_date->format('Y-m-d') }}">
    @else 
        {!! Form::date('end_date', null, ['class' => 'form-control','id'=>'end_date']) !!}
    @endif
</div>