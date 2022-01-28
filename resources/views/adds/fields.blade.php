<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', trans('add.name')) !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('image', trans('add.image')) !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('image', ['class' => 'custom-file-input', 'accept' => 'image/*']) !!}
            {!! Form::label('image', 'Choose file', ['class' => 'custom-file-label']) !!}
            @if (isset($add))
                <small><i class="text-info">*Biarkan kosong bila tidak ingin diubah</i></small>>
            @endif
        </div>
    </div>
</div>
<div class="clearfix"></div>


<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', trans('add.desc')) !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>