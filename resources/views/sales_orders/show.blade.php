@extends('layouts.app')

@section('content')
    {{-- <section class="content-header"> --}}
        <div class="container-fluid p-1 mx-3">
            <h5>Order - {{ $salesOrder->order_nbr }}</h5>
        </div>
    {{-- </section> --}}

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            <div class="card-body">

                <div class="row mb-3">
                    @include('sales_orders.show_fields')
                </div>

                @include('sales_order_details.table')
            
            </div>

            <div class="card-footer">
                {{-- {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!} --}}
                @if ($salesOrder->status == 'S')
                    @can('edit sales order')
                        <a href="{{ route('salesOrders.edit', [$salesOrder->id]) }}" class="btn btn-success" onclick="return confirm('Edit this order?')">Edit</a>
                    @endcan
                    @can('cancel sales order')
                        <a href="{{ route('salesOrders.cancelOrder', [$salesOrder->id]) }}" class="btn btn-danger" onclick="return confirm('Are you sure to cancel this order?')">Cancel Order</a>
                    @endcan
                    @can('submit sales order')
                        <a href="{{ route('salesOrders.submitOrder', [$salesOrder->id]) }}" class="btn btn-info" onclick="return confirm('Submit Order?')">Submit Order</a>
                    @endcan
                @endif
                @if ($salesOrder->status == 'R')
                    @can('process sales order')
                        <a href="{{ route('salesOrders.processOrder', [$salesOrder->id]) }}" class="btn btn-primary"  onclick="return confirm('Process Order?')">Process</a>
                    @endcan
                @endif
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection