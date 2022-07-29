@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ trans('packet_discount.title') }}</h1>
                </div>
                <div class="col-sm-6">
                    @can('create bundling products')
                    <a class="btn btn-primary float-right"
                       href="{{ route('packetDiscounts.create') }}">
                       {{ trans('packet_discount.create') }}
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
        <div class="card-body p-0 m-3">
                @include('packet_discounts.table')

            </div>

        </div>
    </div>

@endsection

@push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function() { 
            fetch_data()
            function fetch_data(){                    
                    $('#dataTable').DataTable({
                        pageLength: 10,
                        lengthChange: true,
                        bFilter: true,
                        destroy: true,
                        processing: true,
                        serverSide: true,
                        "language": {
                            processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw text-danger"></i><span class="sr-only">Loading...</span> '
                        },
                        ajax: {
                            url:"{{route('packetDiscounts.data')}}",
                            type: "GET"
                                
                        },
                        columns: [
                            // { 
                            //     data: 'DT_RowIndex',
                            //     name: 'DT_Row_Index', 
                            //     "className": "text-center" ,
                            //     orderable: false, 
                            //     searchable: false   
                            // },
                            {
                                data: 'packet_code'                                  
                            },
                            {
                                data: 'packet_name'      
                            },      
                            {
                                data: 'start_date'      
                            },                        
                            {
                                data: 'end_date'      
                            },   
                            {
                                data: 'rbp_class'      
                            }, 
                            {
                                data: 'total'      
                            }, 
                            {
                                data: 'discount'      
                            }, 
                            {
                                data: 'grand_total'      
                            }, 
                            {
                                data: 'status'      
                            }, 
                            {
                                data: 'created_at'      
                            }, 
                            {
                                data: 'released_date'      
                            }, 
                            {
                                data: 'action',
                                "className": "text-center",
                                orderable: false, 
                                searchable: false    
                            },    
                        ]
                    });
                }         
        });
    </script>
@endpush