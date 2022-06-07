<!-- Start Date Field -->
<div class="col-sm-12">
    {!! Form::label('start_date', 'Start Date:') !!}
    <p>{{ $dsPercentage->start_date }}</p>
</div>

<!-- End Date Field -->
<div class="col-sm-12">
    {!! Form::label('end_date', 'End Date:') !!}
    <p>{{ $dsPercentage->end_date }}</p>
</div>

<!-- Percentage Field -->
<div class="col-sm-12">
    {!! Form::label('percentage', 'Percentage:') !!}
    <p>{{ $dsPercentage->percentage }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $dsPercentage->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $dsPercentage->updated_at }}</p>
</div>

