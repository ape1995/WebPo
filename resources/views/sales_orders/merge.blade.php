@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0">Sales Order - Merge Order</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('salesOrders.index') }}">Sales Order</a></li>
                <li class="breadcrumb-item active">Merge Order</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            @include('adminlte-templates::common.errors')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <form id="form_submit" action="javascript:void(0)" method="post">
                            <div class="card-header">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        {{ trans('sales_order.delivery_date') }}
                                        <input type="date" class="form-control" name="date" id="date">
                                    </div>
                                    <div class="col-md-4">
                                        {{ trans('sales_order.customer') }}
                                        <select name="customer" id="customer" class="form-control select2js">
                                            <option value="">-Choose-</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->BAccountID }}">{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        {{ trans('sales_order.order_type') }}
                                        <select name="type" id="type" class="form-control select2js">
                                            <option value="">-Choose-</option>
                                            <option value="R">Reguler</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @include('sales_orders.table_submit')
                            </div>
                            <div class="card-footer">
                                <input onclick="return confirm('Are you sure?')" type="submit" name="submit" id="submit" class="btn btn-success btn-sm" value="Merge Order">
                            </div>
                        </form>
                    </div>
                </div>
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
            var date = $('#date');
            var customer = $('#customer');
            var type = $('#type');
            var datecusttype = $('#date, #customer, #type');
            var submit = $('#submit');
            var checkAll = $('#checkAll');
            submit.prop('disabled', true);
            
            datecusttype.on('change', function() {
                submit.prop('disabled', true);
                if (date.val() == '' || customer.val() == '' || type.val() == '') {
                    console.log('Fill All');
                    submit.prop('disabled', true);
                } else {
                    submit.prop('disabled', false);
                    fetch_data();
                    submit.prop('disabled', false);
                }
            });

            $("#checkAll").click(function(){
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $('#form_submit').on('submit', function(){
                $('#submit').attr('disabled', true);
                $('#submit').val('Please Wait...');

                var url = "{{ route('salesOrders.mergeProcess') }}";
                var data = new FormData(this);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: url,
                    method: "POST",
                    data: data,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(data)
                    {
                        swal("Done!", data.success, "success");
                        $('#submit').val("Merge");
                        $('#submit').attr('disabled', false);
                        table.draw();
                        location.reload();
                    },
                    error:function(data)
                    {
                        swal("Failed!", data.responseJSON.message, "error");
                        $('#submit').val("Merge");
                        $('#submit').attr('disabled', false);
                    }
                })
            });
            
            
            function fetch_data(){                    
                table = $('#dataTable').DataTable().clear().destroy();
                table = $('#dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ordering: false,
                    paginate: false,
                    searching: false,
                    bInfo: false,
                    "language": {
                        processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw text-danger"></i><span class="sr-only">Loading...</span> '
                    },
                    ajax: {
                        url:"{{url('dataSalesOrder-dataMerge')}}" + '/' + $('#date').val() + '/' + $('#customer').val() + '/' + $('#type').val(),
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
                        if ( data.status == "Canceled" ) {
                            $('td:eq(9)', row).addClass("bg-danger");
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
                        }
                        if(permissionPrice == 'hide price sales order') {
                            $('td:eq(6)', row).addClass("hide-component");
                            $('td:eq(7)', row).addClass("hide-component");
                            $('td:eq(8)', row).addClass("hide-component");
                        }
                        $('td:eq(5)', row).addClass("money");
                        $('td:eq(6)', row).addClass("money");
                        $('td:eq(7)', row).addClass("money");
                        $('td:eq(8)', row).addClass("money");
                    },
                    columns: [
                        {
                            data: 'checkbox'
                        },
                        {
                            data: 'order_type'                                    
                        }, 
                        {
                            data: 'order_nbr'                                    
                        },                
                        // {
                        //     data: 'customer'      
                        // },  
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