<div class="row">
    <div class="col-md-6">
        {!! Form::label('name', 'Name:') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::email('email', null, ['class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('password', 'Password:') !!}
        {!! Form::password('password', ['class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="col-md-6">
        {!! Form::label('customer_id', 'Customer Name :') !!}
        <select name="customer_id" id="customer_id" class="form-control select2js" required>
            <option value="">Choose</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->BAccountID }}">{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        {!! Form::label('role', 'Group Permission:') !!}
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
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</a>
</div>