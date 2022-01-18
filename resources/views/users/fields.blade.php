<div class="row">
    <div class="col-md-6">
        {!! Form::label('name', trans('user.table_name')) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('email', trans('user.table_email')) !!}
        {!! Form::email('email', null, ['class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('password', trans('user.table_password')) !!}
        {!! Form::password('password', ['class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('customer_id', trans('user.table_customer')) !!}
        <select name="customer_id" id="customer_id" class="form-control select2js" required>
            <option value="">Choose</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->BAccountID }}">{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        {!! Form::label('role', trans('user.table_group')) !!}
        <select name="role" id="role" class="form-control select2js" required>
            <option value="">Choose</option>
            @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    <hr>
    {!! Form::submit( trans('user.btn_save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('users.index') }}" class="btn btn-default">{{ trans('user.btn_cancel') }}</a>
</div>