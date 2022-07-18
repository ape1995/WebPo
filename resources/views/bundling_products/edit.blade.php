@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit Bundling Product</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($bundlingProduct, ['route' => ['bundlingProducts.update', $bundlingProduct->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('bundling_products.fields')

                    <div class="col-md-12">
                        <div class="card card-body">
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('bundlingProducts.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
