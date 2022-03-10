<!-- Customer Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_code', 'Customer Code:') !!}
    {{-- {!! Form::text('customer_code', null, ['class' => 'form-control']) !!} --}}
    <select name="customer_code" id="customer_code" class="form-control select2js" required>
        <option value="">- Please Choose -</option>
        @foreach ($customers as $customer)
            <option value="{{ $customer->AcctCD }}">{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
        @endforeach
    </select>
</div>

<!-- Minimum Order Field -->
<div class="form-group col-sm-6">
    {!! Form::label('minimum_order', 'Minimum Order:') !!}
    {!! Form::text('minimum_order', null, ['class' => 'form-control money']) !!}
</div>