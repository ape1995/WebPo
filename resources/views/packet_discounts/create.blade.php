@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>{{ trans('packet_discount.create') }} {{ trans('packet_discount.title') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'packetDiscounts.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('packet_discounts.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit(trans('packet_discount.save'), ['class' => 'btn btn-primary', 'id' => 'savePageButton']) !!}
                <a href="{{ route('packetDiscounts.index') }}" class="btn btn-default">{{ trans('packet_discount.cancel') }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
