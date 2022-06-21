@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ trans('customer_min_order.title') }}</h1>
                </div>
                <div class="col-sm-6">
                    @can('create min orders')
                    <a class="btn btn-primary float-right"
                       href="{{ route('customerMinOrders.create') }}">
                       {{ trans('customer_min_order.create') }}
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-3">
                @include('customer_min_orders.table')

                {{-- <div class="card-footer clearfix">
                    <div class="float-right">
                        
                    </div>
                </div> --}}
            </div>

        </div>
    </div>

@endsection

