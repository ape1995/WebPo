<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $user->name }}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $user->email }}</p>
</div>

<!-- Role Field -->
<div class="form-group">
    {!! Form::label('group_permission', 'Group Permission:') !!}
    <p>{{ $user->role }}</p>
</div>


<!-- customer_id Field -->
<div class="form-group">
    {!! Form::label('customer_id', 'Customer Name:') !!}
    <p>{{ $user->customer->AcctName }}</p>
</div>


<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $user->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $user->updated_at }}</p>
</div>

