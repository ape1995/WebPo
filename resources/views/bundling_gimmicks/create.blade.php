@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>{{ trans('packet_gimmick.create') }} {{ trans('packet_gimmick.title') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'bundlingGimmicks.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('bundling_gimmicks.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit(trans('packet_gimmick.save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('bundlingGimmicks.index') }}" class="btn btn-default">{{ trans('packet_gimmick.cancel') }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
