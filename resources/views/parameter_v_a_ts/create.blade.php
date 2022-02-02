@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>{{ trans('vat.create') }} Parameter {{ trans('vat.title') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'parameterVATs.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('parameter_v_a_ts.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit(trans('vat.save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('parameterVATs.index') }}" class="btn btn-default">{{ trans('vat.cancel') }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
