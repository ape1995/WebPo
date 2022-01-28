<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', trans('vat.name')) !!}
    <p>{{ $parameterVAT->name }}</p>
</div>

<!-- Value Field -->
<div class="col-sm-12">
    {!! Form::label('value', trans('vat.value')) !!}
    <p>{{ $parameterVAT->value }}</p>
</div>

<!-- Start Date Field -->
<div class="col-sm-12">
    {!! Form::label('start_date', trans('vat.start_date')) !!}
    <p>{{ $parameterVAT->start_date }}</p>
</div>

<!-- End Date Field -->
<div class="col-sm-12">
    {!! Form::label('end_date', trans('vat.end_date')) !!}
    <p>{{ $parameterVAT->end_date }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $parameterVAT->created_at }}</p>
</div>
