@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ trans('bundling_product.title') }}</h1>
                </div>
                <div class="col-sm-6">
                    @can('create bundling products')
                        <a class="btn btn-primary float-right"
                        href="{{ route('bundlingProducts.create') }}">
                            {{ trans('bundling_product.create') }}
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
            <div class="card-body">
                @include('bundling_products.table')

                
            </div>

        </div>
    </div>

@endsection

