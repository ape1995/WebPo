@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>{{trans('category_min_order.create')}} {{ trans('category_min_order.title') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'categoryMinOrders.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('category_min_orders.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit(trans('category_min_order.save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('categoryMinOrders.index') }}" class="btn btn-default">{{ trans('category_min_order.cancel') }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
@push('page_scripts')
    <script>
        $(function() {
            $('.money').mask("#.##0", {reverse: true});
        });
    </script>
@endpush
