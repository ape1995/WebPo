<!-- Customer Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_code', 'Customer Code:') !!}
    <select name="customer_code" id="customer_code" class="form-control select2js" required>
        <option value="">- Choose Customer -</option>
        @foreach ($customers as $customer)
            <option value="{{ $customer->AcctCD }}">{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
        @endforeach
    </select>
    {{-- {!! Form::text('customer_code', null, ['class' => 'form-control']) !!} --}}
</div>

<!-- Inventory Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('inventory_code', 'Inventory Code:') !!}
    <select name="inventory_code" id="inventory_code" class="form-control select2js" required>
        <option value="">- Choose Product -</option>
        @foreach ($products as $product)
            <option value="{{ $product->InventoryCD }}">{{ $product->Descr }} - {{ $product->InventoryCD }}</option>
        @endforeach
    </select>
    {{-- {!! Form::text('inventory_code', null, ['class' => 'form-control']) !!} --}}
</div>