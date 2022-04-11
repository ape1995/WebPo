@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Bulk Action Customer Product</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'customerProducts.storeBulk']) !!}

            <div class="card-body">
                <a href="{{ URL::previous() }}" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-left"></i> Back</a>
                

                <div class="m-1">
                    <div class="form-group col-sm-6">
                        {!! Form::label('inventory_code', 'Inventory Code:') !!}
                        <select name="inventory_code" id="inventory_code" class="form-control select2js" required>
                            <option value="">- Choose Product -</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->InventoryCD }}">{{ $product->Descr }} - {{ $product->InventoryCD }}</option>
                            @endforeach
                        </select>
                    </div>
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
                </div>

            </div>

            <div class="card-footer">
                <input type="submit" class="btn btn-success" name="add_item" value="Add Item" onclick="return confirm('Are You Sure to Create?')">
                <input type="submit" class="btn btn-danger" name="delete_item" value="Delete Item" onclick="return confirm('Are You Sure to Delete?')">
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
