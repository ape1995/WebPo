@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product Schedulers</h1>
                </div>
                <div class="col-sm-6">
                    @can('create product schedulers')
                    <a class="btn btn-primary float-right"
                       href="{{ route('productSchedulers.create') }}">
                        Add New
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
                @include('product_schedulers.table')

               
            </div>

        </div>
    </div>

@endsection

