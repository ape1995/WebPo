<!-- Customer Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_code', trans('customer_first_order.customer')) !!}
    @if (isset($customerFirstOrder))
        <select name="customer_code" id="customer_code" class="form-control select2js" required>
            <option value="">- Choose Customer -</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->AcctCD }}" {{ $customerFirstOrder->customer_code == $customer->AcctCD ? 'selected' : '' }}>{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
            @endforeach
        </select>
    @else
        <select name="customer_code" id="customer_code" class="form-control select2js" required>
            <option value="">- Choose Customer -</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->AcctCD }}">{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
            @endforeach
        </select>
    @endif
    
</div>

<!-- First Order Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('first_order_number', trans('customer_first_order.first_order_number')) !!}
    {!! Form::text('first_order_number', null, ['class' => 'form-control', 'id' => 'first_order_number']) !!}
</div>

<!-- First Order Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('first_order_date', trans('customer_first_order.first_order_date')) !!}
    @if (isset($customerFirstOrder))
        {!! Form::date('first_order_date', $customerFirstOrder->first_order_date, ['class' => 'form-control','id'=>'first_order_date']) !!}
    @else
        {!! Form::date('first_order_date', null, ['class' => 'form-control','id'=>'first_order_date']) !!}
    @endif
</div>