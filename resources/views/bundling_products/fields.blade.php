@if (isset($bundlingProduct))
    <!-- Start Date Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('start_date', trans('bundling_product.start_date')) !!}
        {!! Form::date('start_date', $bundlingProduct->start_date, ['class' => 'form-control','id'=>'start_date', 'required' => true]) !!}
    </div>

    <!-- End Date Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('end_date', trans('bundling_product.end_date')) !!}
        {!! Form::date('end_date', $bundlingProduct->end_date, ['class' => 'form-control','id'=>'end_date', 'required' => true]) !!}
    </div>

<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <h5>{{ trans('bundling_product.buy') }}</h5>
        </div>
        <!-- Product Code Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('product_code', 'Product:') !!}
            <select name="product_code" id="product_code" class="form-control select2js" required>
                <option value="">choose</option>
                @foreach ($products as $product)
                    <option value="{{ $product->InventoryCD }}" {{ trim($product->InventoryCD) == $bundlingProduct->product_code ? 'selected' : '' }}>{{ $product->Descr }} - {{ $product->InventoryCD }}</option>
                @endforeach
            </select>
        </div>
    
    
        <!-- Qty Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('qty', 'Qty:') !!}
            {!! Form::number('qty_total', $bundlingProduct->qty, ['class' => 'form-control', 'required' => true ]) !!}
        </div>
    </div>
</div>
@else
    <!-- Start Date Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('start_date', trans('bundling_product.start_date')) !!}
        {!! Form::date('start_date', null, ['class' => 'form-control','id'=>'start_date', 'required' => true]) !!}
    </div>

    <!-- End Date Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('end_date', trans('bundling_product.end_date')) !!}
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
@endif

