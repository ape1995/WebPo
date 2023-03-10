@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customer Min Order Details</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ route('customerMinOrders.index') }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <a href="{{ URL::previous() }}" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-left"></i> Back</a>
                
                <div class="row">
                    @include('customer_min_orders.show_fields')
                </div>
                {{-- <h5>History</h5> --}}
                {{-- @include('customer_min_order_hists.table') --}}
            </div>
        </div>
    </div>
@endsection
