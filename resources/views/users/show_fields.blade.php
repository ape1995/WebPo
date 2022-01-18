<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', trans('user.table_name')) !!}
    <p>{{ $user->name }}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('email', trans('user.table_email')) !!}
    <p>{{ $user->email }}</p>
</div>

<!-- Role Field -->
<div class="form-group">
    {!! Form::label('group_permission', trans('user.table_group')) !!}
    <p>{{ $user->role }}</p>
</div>


<!-- customer_id Field -->
<div class="form-group">
    {!! Form::label('customer_id', trans('user.table_customer')) !!}
    <p>{{ $user->customer->AcctName }}</p>
</div>


<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', trans('user.created_at')) !!}
    <p>{{ $user->created_at }}</p>
</div>

