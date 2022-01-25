<!-- Type Field -->
<div class="col-sm-12">
    {!! Form::label('name', trans('parameter.name')) !!}
    <p>{{ $mailSetting->name }}</p>
</div>

<!-- Type Field -->
<div class="col-sm-12">
    {!! Form::label('type', trans('mail.type')) !!}
    <p>{{ $mailSetting->type }}</p>
</div>

<!-- Sub Type Field -->
<div class="col-sm-12">
    {!! Form::label('sub_type', trans('mail.sub_type')) !!}
    <p>{{ $mailSetting->sub_type }}</p>
</div>

<!-- Email Field -->
<div class="col-sm-12">
    {!! Form::label('email', trans('mail.email')) !!}
    <p>{{ $mailSetting->email }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', trans('mail.status')) !!}
    <p>{{ $mailSetting->status == true ? 'Active' : 'Inactive' }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', trans('user.created_at')) !!}
    <p>{{ $mailSetting->created_at }}</p>
</div>

