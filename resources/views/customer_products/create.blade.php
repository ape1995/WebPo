@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>{{ trans('customer_product.create') }} {{ trans('customer_product.title') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'customerProducts.store']) !!}

            <div class="card-body">
               
                <div class="row">
                    @include('customer_products.fields')
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit(trans('customer_product.save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('customerProducts.index') }}" class="btn btn-default">{{ trans('customer_product.cancel') }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

@push('page_scripts')
    <script type='text/javascript'>
        $(document).ready(function(){
        // Check or Uncheck All checkboxes
        $("#checkall").change(function(){
            var checked = $(this).is(':checked');
            if(checked){
                $(".checkbox").each(function(){
                    $(this).prop("checked",true);
                });
            }else{
                console.log('tes2');
                $(".checkbox").each(function(){
                    $(this).prop("checked",false);
                });
            }
        });
        
        // Changing state of CheckAll checkbox 
        $(".checkbox").click(function(){
        
            if($(".checkbox").length == $(".checkbox:checked").length) {
                $("#checkall").prop("checked", true);
            } else {
                $("#checkall").prop("checked", false);
            }
    
        });
    });
   </script>
@endpush