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
                {{-- <div class="col-md-12 text-right mb-3">
                    <span class="text-light bg-info rounded p-1">{{ $salesOrder->status }}</span>
                </div> --}}
                <div class="row mb-3">
                    @include('sales_orders.show_fields')
                </div>

                @include('sales_order_details.table')
            
            </div>

            <div class="card-footer">
                {{-- {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!} --}}
                <a href="{{ route('salesOrders.printPdf', [$salesOrder->id]) }}" class="btn btn-outline-danger"><i class="fa fa-file-pdf"></i> Print</a>
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
                    @can('reject sales order')
                        <a href="{{ route('salesOrders.rejectOrder', [$salesOrder->id]) }}" class="btn btn-danger"  onclick="return confirm('Reject Order?')">Reject</a>
                    @endcan
                @endif
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection