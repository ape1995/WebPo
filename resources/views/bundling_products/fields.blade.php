<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start Date:') !!}
    {!! Form::date('start_date', null, ['class' => 'form-control','id'=>'start_date', 'required' => true]) !!}
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    {!! Form::date('end_date', null, ['class' => 'form-control','id'=>'end_date']) !!}
</div>


<!-- Product Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('product_code', 'Product:') !!}
    <select name="product_code" id="product_code" class="form-control select2js" required>
        <option value="">choose</option>
        @foreach ($products as $product)
            <option value="{{ $product->InventoryCD }}">{{ $product->Descr }} - {{ $product->InventoryCD }}</option>
        @endforeach
    </select>
</div>


<!-- Qty Field -->
<div class="form-group col-sm-6">
    {!! Form::label('qty', 'Qty:') !!}
    {!! Form::number('qty_total', null, ['class' => 'form-control', 'required' => true ]) !!}
</div>
