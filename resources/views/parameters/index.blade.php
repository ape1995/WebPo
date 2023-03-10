@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ trans('parameter.title') }}</h1>
                </div>
                {{-- @can('create parameter')
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('parameters.create') }}">
                        {{ trans('parameter.create') }}
                    </a>
                </div>
                @endcan --}}
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-3">
                @include('parameters.table')
            </div>

        </div>
    </div>

@endsection

