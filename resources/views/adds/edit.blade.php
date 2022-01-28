@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit {{ trans('add.title') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($add, ['route' => ['adds.update', $add->id], 'method' => 'patch', 'files' => true]) !!}

            <div class="card-body">
                <div class="row">
                    @include('adds.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit(trans('add.save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('adds.index') }}" class="btn btn-default">{{ trans('add.cancel') }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
