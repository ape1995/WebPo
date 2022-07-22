@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ trans('packet_gimmick.title') }}</h1>
                </div>
                <div class="col-sm-6">
                    @can('create bundling gimmicks')
                    <a class="btn btn-primary float-right"
                       href="{{ route('bundlingGimmicks.create') }}">
                       {{ trans('packet_gimmick.create') }}
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
                @include('bundling_gimmicks.table')
                
            </div>

        </div>
    </div>

@endsection

