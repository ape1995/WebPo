<!-- Name Field -->
<div class="col-2">
    {!! Form::label('name', trans('ds_rules.rule_name')) !!}
    <p>{{ $dsRule->name }}</p>
</div>

<!-- Status Field -->
<div class="form-group col-6">
    {!! Form::label('status', trans('ds_rules.active')) !!}
    <!-- Status -->
    <div class="custom-control custom-switch">
        @if (isset($dsRule))
            <input type="checkbox" class="custom-control-input" id="customSwitches" name="status" {{ $dsRule->status == 1 ? 'checked' : '' }} value="active">
            <label class="custom-control-label" for="customSwitches"></label>
        @else
            <input type="checkbox" class="custom-control-input" id="customSwitches" name="status" value="active">
            <label class="custom-control-label" for="customSwitches"></label>
        @endif
    </div>
</div>
