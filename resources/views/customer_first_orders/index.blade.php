@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ trans('customer_first_order.title') }}</h1>
                </div>
                <div class="col-sm-6">
                    {{-- <a class="btn btn-primary float-right"
                       href="{{ route('customerFirstOrders.create') }}">
                       {{ trans('customer_first_order.create') }}
                    </a> --}}
                    
                    <a class="btn btn-success float-right" onclick="return confirm('Are you sure?')"
                       href="{{ route('customerFirstOrders.loadData') }}">
                       <i class="fas fa-spinner"></i> {{ trans('customer_first_order.load_data') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-3">
                @include('customer_first_orders.table')

                {{-- <div class="card-footer clearfix">
                    <div class="float-right">
                        
                    </div>
                </div> --}}
            </div>

        </div>
    </div>

@endsection

