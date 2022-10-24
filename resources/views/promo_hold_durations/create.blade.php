@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>{{ trans('promo_hold_duration.create') }} {{ trans('promo_hold_duration.title') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('adminlte-templates::common.errors')
        @include('flash::message');
        <div class="card">

            {!! Form::open(['route' => 'promoHoldDurations.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('promo_hold_durations.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit(trans('promo_hold_duration.save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('promoHoldDurations.index') }}" class="btn btn-default">{{ trans('promo_hold_duration.cancel') }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
