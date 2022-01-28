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
                            <div class="row justify-content-between mx-3">
                                @can('import users')
                                <div class="mb-3">
                                    <button class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#modalImport">Import</button>
                                </div>
                                @endcan
                                @can('create users')
                                <div class="mb-3 text-right">
                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('users.create') }}">{{ trans('user.create')}}</a>
                                </div>
                                @endcan
                            </div>
                            @include('users.table')
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        <!-- Modal -->
        <div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImport" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form action="{{ route('users.import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header text-light" style="background-color: #c61325">
                            <h5 class="modal-title" id="exampleModalLongTitle">Import Data User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="file" name="file" id="file" accept=".xlsx,.xls" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-success" value="Import">
                        </div>
                    </div>
                </form>
            </div>
        </div>
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