@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>{{ trans('customer_first_order.create') }} {{ trans('customer_first_order.title') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'customerFirstOrders.store']) !!}

            <div class="card-body">

                <div class="row">
                    @include('customer_first_orders.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit(trans('customer_first_order.save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('customerFirstOrders.index') }}" class="btn btn-default">{{ trans('customer_first_order.cancel') }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            var customer_code =  $("select#customer_code");
            var first_order_number =  $("#first_order_number");
            var first_order_date =  $("#first_order_date");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            customer_code.on('change', function() {

                var url = "{{ url('api/get-first-order-data') }}" + "/" + customer_code.val();
                // send data to your endpoint
                $.ajax({
                    url: url,
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        first_order_number.val(response['first_order_number']);
                        first_order_date.val(response['first_order_date']);
                    }
                });


            });
    
        });

    </script>
@endsection
