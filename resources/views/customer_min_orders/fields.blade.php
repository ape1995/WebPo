<!-- Customer Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_code', 'Customer:') !!}
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
    {!! Form::label('minimum_order', 'Minimum Order:') !!}
    {!! Form::text('minimum_order', null, ['class' => 'form-control money']) !!}
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start Date:') !!}
    {!! Form::date('start_date', null, ['class' => 'form-control']) !!}
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    {!! Form::date('end_date', null, ['class' => 'form-control']) !!}
</div>