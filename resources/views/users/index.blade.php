@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">{{ trans('user.title')}}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Users</a></li>
                <li class="breadcrumb-item active">Index</li>
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
                            @can('create users')
                                <div class="text-right mb-3">
                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('users.create') }}">{{ trans('user.create')}}</a>
                                </div>
                            @endcan
                            @include('users.table')
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
                            url:"{{route('users.data')}}",
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
                                data: 'name'                                  
                            },
                            {
                                data: 'email'      
                            },      
                            {
                                data: 'role'      
                            },                        
                            {
                                data: 'customer'      
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