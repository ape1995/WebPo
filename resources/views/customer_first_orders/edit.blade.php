@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit {{ trans('customer_first_order.title') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($customerFirstOrder, ['route' => ['customerFirstOrders.update', $customerFirstOrder->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('customer_first_orders.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit(trans('customer_first_order.save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('customerFirstOrders.index') }}" class="btn btn-default">{{ trans('customer_first_order.cancel') }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
