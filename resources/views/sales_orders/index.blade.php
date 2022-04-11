@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Sales Order</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('salesOrders.index') }}">Sales Order</a></li>
                <li class="breadcrumb-item active">List</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @include('sales_orders.table')
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    @php
        $permissionPrice = '';
    @endphp
    @can('hide price sales order')
        @php
            $permissionPrice = 'hide price sales order';
        @endphp
    @endcan
@endsection


@push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function() { 
            var permissionPrice = "{{ $permissionPrice }}";
            fetch_data()
            function fetch_data(){                    
                    $('#dataTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ordering: false,
                        "language": {
                            processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw text-danger"></i><span class="sr-only">Loading...</span> '
                        },
                        ajax: {
                            url:"{{route('salesOrders.data')}}",
                            type: "GET"
                                
                        },
                        "rowCallback": function( row, data ) {
                            if ( data.status == "Draft" ) {
                                $('td:eq(10)', row).addClass("bg-secondary");
                            }
                            if ( data.status == "Submitted" ) {
                                $('td:eq(10)', row).addClass("bg-info");
                            }
                            if ( data.status == "Processed" ) {
                                $('td:eq(10)', row).addClass("bg-success");
                            }
                            if ( data.status == "Canceled" ) {
                                $('td:eq(10)', row).addClass("bg-danger");
                            }
                            if ( data.status == "Rejected" ) {
                                $('td:eq(0)', row).addClass("bg-danger");
                                $('td:eq(1)', row).addClass("bg-danger");
                                $('td:eq(2)', row).addClass("bg-danger");
                                $('td:eq(3)', row).addClass("bg-danger");
                                $('td:eq(4)', row).addClass("bg-danger");
                                $('td:eq(5)', row).addClass("bg-danger");
                                $('td:eq(6)', row).addClass("bg-danger");
                                $('td:eq(7)', row).addClass("bg-danger");
                                $('td:eq(8)', row).addClass("bg-danger");
                                $('td:eq(9)', row).addClass("bg-danger");
                                $('td:eq(10)', row).addClass("bg-danger");
                            }
                            if(permissionPrice == 'hide price sales order') {
                                $('td:eq(7)', row).addClass("hide-component");
                                $('td:eq(8)', row).addClass("hide-component");
                                $('td:eq(9)', row).addClass("hide-component");
                            }
                            $('td:eq(6)', row).addClass("money");
                            $('td:eq(7)', row).addClass("money");
                            $('td:eq(8)', row).addClass("money");
                            $('td:eq(9)', row).addClass("money");
                        },
                        columns: [
                            { 
                                data: 'DT_RowIndex',
                                name: 'DT_Row_Index', 
                                "className": "text-center" ,
                                ordering: false, 
                                searchable: false    
                            },
                            {
                                data: 'order_type'                                    
                            }, 
                            {
                                data: 'order_nbr'                                    
                            },                
                            {
                                data: 'customer'      
                            },  
                            {
                                data: 'order_date'
                            },      
                            {
                                data: 'delivery_date'
                            },       
                            {
                                data: 'order_qty'      
                            },      
                            {
                                data: 'order_amount'    
                            },       
                            {
                                data: 'tax'      
                            },       
                            {
                                data: 'order_total'      
                            },       
                            {
                                data: 'status' 
                            },
                            {
                                data: 'action',
                                "className": "text-center",
                                orderable: false, 
                                searchable: false    
                            },    
                        ],
                    });
                }         
        });
    </script>
@endpush