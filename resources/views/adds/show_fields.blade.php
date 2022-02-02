<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', trans('add.name')) !!}
    <p>{{ $add->name }}</p>
</div>

<!-- Image Field -->
<div class="col-sm-12">
    {!! Form::label('image', trans('add.image')) !!}
    <p>{{ $add->image }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', trans('add.desc')) !!}
    <p>{{ $add->description }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $add->created_at }}</p>
</div>
