<!-- Packet Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('packet_type', trans('promo_hold_duration.packet_type')) !!}
    {{-- {!! Form::text('packet_type', null, ['class' => 'form-control']) !!} --}}
    @if (isset($promoHoldDuration))
        <select name="packet_type" id="packet_type" class="form-control" required disabled>
            <option value="BUNDLING GIMMICK" {{ $promoHoldDuration->packet_type == 'BUNDLING GIMMICK' ? 'selected' : '' }}>BUNDLING GIMMICK</option>
            <option value="BUNDLING PRODUCT" {{ $promoHoldDuration->packet_type == 'BUNDLING PRODUCT' ? 'selected' : '' }}>BUNDLING PRODUCT</option>
            <option value="BUNDLING DISCOUNT" {{ $promoHoldDuration->packet_type == 'BUNDLING DISCOUNT' ? 'selected' : '' }}>BUNDLING DISCOUNT</option>
        </select>
    @else
        <select name="packet_type" id="packet_type" class="form-control" required>
            <option value="">-Choose-</option>
            <option value="BUNDLING GIMMICK">BUNDLING GIMMICK</option>
            <option value="BUNDLING PRODUCT">BUNDLING PRODUCT</option>
            <option value="BUNDLING DISCOUNT">BUNDLING DISCOUNT</option>
        </select>
    @endif
    
</div>

<div class="col-md-6"></div>

<!-- Duration In Day Field -->
<div class="form-group col-2">
    {!! Form::label('duration_in_day', trans('promo_hold_duration.duration_in_day') ) !!}
    @if (isset($promoHoldDuration))
        {!! Form::number('duration_in_day', null, ['class' => 'form-control', 'required' => true]) !!}
    @else
        {!! Form::number('duration_in_day', null, ['class' => 'form-control', 'required' => true]) !!}
    @endif
</div>
<div class="col-md-2 p-0 m-0"><br><br>day(s)</div>