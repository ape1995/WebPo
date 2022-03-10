<!-- Customer Code Field -->
<div class="col-sm-12">
    {!! Form::label('', 'Customer:') !!}
    <p>{{ $customerMinOrder->customer->AcctName }} - {{ $customerMinOrder->customer_code }}</p>
</div>

<!-- Minimum Order Field -->
<div class="col-sm-12">
    {!! Form::label('minimum_order', 'Minimum Order:') !!}
    <p class="text-bold">Rp. {{ number_format($customerMinOrder->minimum_order, 0, ',', '.') }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Date Add:') !!}
    <p>{{ $customerMinOrder->created_at->format('Y-m-d') }}</p>
</div>


