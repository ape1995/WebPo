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

<!-- Start Date At Field -->
<div class="col-sm-12">
    {!! Form::label('start_date', 'Start Date:') !!}
    <p>{{ $customerMinOrder->start_date == null ? '' : date('Y-m-d', strtotime($customerMinOrder->start_date)) }}</p>
</div>


<!-- End Date At Field -->
<div class="col-sm-12">
    {!! Form::label('end_date', 'End Date:') !!}
    <p>{{ $customerMinOrder->end_date == null ? '' : date('Y-m-d', strtotime($customerMinOrder->end_date)) }}</p>
</div>


