@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customer Products</h1>
                </div>
                <div class="col-sm-6 mx-auto">
                    <a class="btn btn-primary float-right ml-3"
                       href="{{ route('customerProducts.create') }}">
                        Add New
                    </a>
                    <a class="btn btn-info float-right"
                       href="{{ route('customerProducts.createBulk') }}">
                        Bulk Input
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
                <div class="row">

                    <div class="mb-3 col-md-3 mx-auto">
                        Customer
                        <select name="customer_id" id="customer_id" class="form-control select2js">
                            <option value="">- All Customer -</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->AcctCD }}">{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @include('customer_products.table')
            </div>

        </div>
    </div>

@endsection

