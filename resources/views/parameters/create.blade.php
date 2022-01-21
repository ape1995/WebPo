@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>{{ trans('parameter.title') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'parameters.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('parameters.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit(trans('parameter.save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('parameters.index') }}" class="btn btn-default">{{ trans('parameter.cancel') }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
