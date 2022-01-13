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
@endsection


@push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function() { 
            fetch_data()
            function fetch_data(){                    
                    $('#dataTable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url:"{{route('salesOrders.data')}}",
                            type: "GET"
                                
                        },
                        "rowCallback": function( row, data ) {
                            if ( data.status == "Draft" ) {
                                $('td:eq(9)', row).addClass("bg-secondary");
                            }
                            if ( data.status == "Submitted" ) {
                                $('td:eq(9)', row).addClass("bg-info");
                            }
                            if ( data.status == "Processed" ) {
                                $('td:eq(9)', row).addClass("bg-success");
                            }
                        },
                        columns: [
                            { 
                                data: 'DT_RowIndex',
                                name: 'DT_Row_Index', 
                                "className": "text-center" ,
                                orderable: false, 
                                searchable: false   
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
                        ]
                    });
                }         
        });
    </script>
@endpush