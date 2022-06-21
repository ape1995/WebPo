<!-- Customer Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_code', trans('customer_min_order.customer')) !!}
    {{-- {!! Form::text('customer_code', null, ['class' => 'form-control']) !!} --}}
    <select name="customer_code" id="customer_code" class="form-control select2js" required>
        <option value="">- Please Choose -</option>
        @if (isset($customerMinOrder))
            @foreach ($customers as $customer)
                <option value="{{ $customer->AcctCD }}" {{ $customerMinOrder->customer_code == $customer->AcctCD ? 'selected' : '' }}>{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
            @endforeach
        @else
            @foreach ($customers as $customer)
                <option value="{{ $customer->AcctCD }}">{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
            @endforeach
        @endif
    </select>
</div>

<!-- Minimum Order Field -->
<div class="form-group col-sm-6">
    {!! Form::label('minimum_order', trans('customer_min_order.minimum_order')) !!}
    {!! Form::text('minimum_order', null, ['class' => 'form-control money', 'required' => true]) !!}
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', trans('customer_min_order.start_date')) !!}
    {!! Form::date('start_date', null, ['class' => 'form-control', 'required' => true]) !!}
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', trans('customer_min_order.end_date')) !!}
    {!! Form::date('end_date', null, ['class' => 'form-control']) !!}
</div>