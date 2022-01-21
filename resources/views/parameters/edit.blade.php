@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>{{ trans('parameter.edit') }} {{ trans('parameter.title') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($parameter, ['route' => ['parameters.update', $parameter->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('parameters.fields-edit')
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
