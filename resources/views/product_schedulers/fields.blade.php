@if (isset($productScheduler))

    <!-- Date Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('date', 'Date:') !!}
        {!! Form::date('date', $productScheduler->date, ['class' => 'form-control','id'=>'date']) !!}
    </div>

    <!-- Inventory Code Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('inventory_code', 'Inventory Code:') !!}
        <select name="inventory_code" id="inventory_code" class="form-control select2js" required>
            <option value="">- Choose Product -</option>
            @foreach ($products as $product)
                <option value="{{ $product->InventoryCD }}" {{ $productScheduler->inventory_code == trim($product->InventoryCD) ? 'selected' : '' }}>{{ $product->Descr }} - {{ $product->InventoryCD }}</option>
            @endforeach
        </select>
    </div>

    <!-- Customer Class Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('customer_class', 'Customer Class:') !!}
        <select name="customer_class" id="customer_class" class="form-control select2js" required>
            <option value="">- Choose Class -</option>
            <option value="DISTR" {{ $productScheduler->customer_class == 'DISTR' ? 'selected' : '' }}>DISTR</option>
            <option value="DSJBR" {{ $productScheduler->customer_class == 'DSJBR' ? 'selected' : '' }}>DSJBR</option>
            <option value="DSJTG" {{ $productScheduler->customer_class == 'DSJTG' ? 'selected' : '' }}>DSJTG</option>
            <option value="DSJTM" {{ $productScheduler->customer_class == 'DSJTM' ? 'selected' : '' }}>DSJTM</option>
            <option value="INSTI" {{ $productScheduler->customer_class == 'INSTI' ? 'selected' : '' }}>INSTI</option>
        </select>
    </div>

    <!-- Action Type Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('action_type', 'Action Type:') !!}
        <select name="action_type" id="action_type" class="form-control" required>
            <option value="">-Choose-</option>
            <option value="Create Item" {{ $productScheduler->action_type == 'Create Item' ? 'selected' : '' }}>Create Item</option>
            <option value="Delete Item" {{ $productScheduler->action_type == 'Delete Item' ? 'selected' : '' }}>Delete Item</option>
        </select>
    </div>

@else

    <!-- Date Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('date', 'Date:') !!}
        {!! Form::date('date', null, ['class' => 'form-control','id'=>'date']) !!}
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
    </div>

    <!-- Customer Class Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('customer_class', 'Customer Class:') !!}
        <select name="customer_class" id="customer_class" class="form-control select2js" required>
            <option value="">- Choose Class -</option>
            <option value="DISTR">DISTR</option>
            <option value="DSJBR">DSJBR</option>
            <option value="DSJTG">DSJTG</option>
            <option value="DSJTM">DSJTM</option>
            <option value="INSTI">INSTI</option>
        </select>
    </div>

    <!-- Action Type Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('action_type', 'Action Type:') !!}
        <select name="action_type" id="action_type" class="form-control" required>
            <option value="">-Choose-</option>
            <option value="Create Item">Create Item</option>
            <option value="Delete Item">Delete Item</option>
        </select>
    </div>

@endif