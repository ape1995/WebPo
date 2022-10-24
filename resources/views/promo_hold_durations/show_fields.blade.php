<!-- Packet Type Field -->
<div class="col-sm-12">
    {!! Form::label('packet_type', 'Packet Type:') !!}
    <p>{{ $promoHoldDuration->packet_type }}</p>
</div>

<!-- Duration In Day Field -->
<div class="col-sm-12">
    {!! Form::label('duration_in_day', 'Duration In Day:') !!}
    <p>{{ $promoHoldDuration->duration_in_day }} day(s)</p>
</div>

<!-- Created By Field -->
<div class="col-sm-12">
    {!! Form::label('created_by', 'Created By:') !!}
    <p>{{ $promoHoldDuration->createdBy->name }}</p>
</div>

<!-- Updated By Field -->
<div class="col-sm-12">
    {!! Form::label('updated_by', 'Updated By:') !!}
    <p>{{ $promoHoldDuration->updatedBy == null ? '' : $promoHoldDuration->updatedBy->name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $promoHoldDuration->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $promoHoldDuration->updated_at }}</p>
</div>

