<!-- Name Field -->
<div class="form-group col-sm-12">
    {!! Form::label('name', trans('group.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('permissions.index') }}" class="btn btn-default">Cancel</a>
</div>