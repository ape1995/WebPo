<!-- Packet Code Field -->
<div class="col-sm-3">
    {!! Form::label('packet_code', 'Packet Code:') !!}
    {!! Form::text('packet_code', $packetDiscount->packet_code, ['class' => 'form-control', 'readonly' => true]) !!}
</div>

<!-- Packet Name Field -->
<div class="col-sm-10">
    {!! Form::label('packet_name', 'Packet Name:') !!}
    {!! Form::text('packet_name', $packetDiscount->packet_name, ['class' => 'form-control', 'readonly' => true]) !!}
</div>

<!-- Start Date Field -->
<div class="col-sm-3">
    {!! Form::label('start_date', 'Start Date:') !!}
    {!! Form::text('start_date', $packetDiscount->start_date->format('Y-m-d'), ['class' => 'form-control', 'readonly' => true]) !!}
</div>

<!-- End Date Field -->
<div class="col-sm-3">
    {!! Form::label('end_date', 'End Date:') !!}
    {!! Form::text('end_date', $packetDiscount->end_date == null ? '' : $packetDiscount->end_date->format('Y-m-d'), ['class' => 'form-control', 'readonly' => true]) !!}
</div>

<!-- Rbp Class Field -->
<div class="col-sm-3">
    {!! Form::label('rbp_class', 'Rbp Class:') !!}
    {!! Form::text('rbp_class', $packetDiscount->rbp_class, ['class' => 'form-control', 'readonly' => true]) !!}
</div>

<!-- Released Date Field -->
<div class="col-sm-3">
    {!! Form::label('released_date', 'Released Date:') !!}
    {!! Form::text('released_date', $packetDiscount->released_date == null ? '' : $packetDiscount->released_date->format('Y-m-d'), ['class' => 'form-control', 'readonly' => true]) !!}
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', $packetDiscount->description, ['class' => 'form-control', 'readonly' => true, 'rows' => 3]) !!}
</div>

<!-- Status Field -->
<div class="col-sm-3">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $packetDiscount->status }}</p>
</div>

@include('packet_discounts.show_fields_table')
