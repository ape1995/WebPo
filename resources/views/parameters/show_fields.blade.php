<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $parameter->name }}</p>
</div>

<!-- Parameter String Field -->
<div class="col-sm-12">
    {!! Form::label('parameter_string', 'Parameter String:') !!}
    <p>{{ $parameter->parameter_string }}</p>
</div>

<!-- Parameter Date Field -->
<div class="col-sm-12">
    {!! Form::label('parameter_date', 'Parameter Date:') !!}
    <p>{{ $parameter->parameter_date }}</p>
</div>

<!-- Parameter Hour Field -->
<div class="col-sm-12">
    {!! Form::label('parameter_hour', 'Parameter Hour:') !!}
    <p>{{ $parameter->parameter_hour }}</p>
</div>

<!-- Parameter Number Field -->
<div class="col-sm-12">
    {!! Form::label('parameter_number', 'Parameter Number:') !!}
    <p>{{ $parameter->parameter_number }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $parameter->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $parameter->updated_at }}</p>
</div>

