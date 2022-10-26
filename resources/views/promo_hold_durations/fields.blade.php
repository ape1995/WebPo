<!-- Packet Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('packet_type', trans('promo_hold_duration.packet_type')) !!}
    {{-- {!! Form::text('packet_type', null, ['class' => 'form-control']) !!} --}}
    @if (isset($promoHoldDuration))
        <select name="packet_type" id="packet_type" class="form-control" required readonly>
            <option value="{{ $promoHoldDuration->packet_type }}">{{ $promoHoldDuration->packet_type }}</option>
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
        <input value="{{ $promoHoldDuration->duration_in_day }}" type="number" name="duration_in_day" id="duration_in_day" class="form-control" min="1" onKeyPress="if(this.value.length==4) return false;" onkeydown="if(event.key==='.'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');" required>
    @else
        <input type="number" name="duration_in_day" id="duration_in_day" class="form-control" min="1" onKeyPress="if(this.value.length==4) return false;" onkeydown="if(event.key==='.'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');" required>
    @endif

</div>
<div class="col-md-2 p-0 m-0"><br><br>day(s)</div>

<div class="col-md-6"></div>

<div class="col-md-3">
    {!! Form::label('start_date', trans('promo_hold_duration.start_date')) !!}
    @if (isset($promoHoldDuration))
        <input type="date" value="{{ $promoHoldDuration->start_date }}" class="form-control" name="start_date" id="start_date" required>
    @else
        <input type="date" class="form-control" name="start_date" id="start_date" required>
    @endif
</div>

<div class="col-md-3">
    {!! Form::label('end_date', trans('promo_hold_duration.end_date')) !!}
    @if (isset($promoHoldDuration))
        <input type="date" value="{{ $promoHoldDuration->end_date }}" class="form-control" name="end_date" id="end_date">
    @else
        <input type="date" class="form-control" name="end_date" id="end_date">
    @endif
</div>