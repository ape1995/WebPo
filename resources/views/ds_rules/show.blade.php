@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Direct Selling Rule Setting</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('ds_rules.show_fields')
                </div>
            </div>
        </div>
        <div class="card card-body">
            <!-- Button trigger modal -->
            <div class="col-md-12 mb-3 mt-3">
                @can('create direct selling rules')
                <button type="button" id="add_item" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addProduct">
                    Add Condition
                </button>
                @endcan
                @can('export direct selling rules')
                <a href="{{ route('dsRules.export') }}" class="btn btn-success btn-sm float-right ml-3">Export All Data</a>
                @endcan
                @can('import direct selling rules')
                <button class="btn btn-info btn-sm text-light float-right ml-3" id="btn_upload_product" type="button"  data-toggle="modal" data-target="#modalUpload">
                    Import Data
                </button>
                @endcan
            </div>
            <!-- Modal -->
            <div class="modal fade" id="addProduct" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        {{-- Start Date --}}
                        <div class="col-sm-12 mb-1">
                            <div class="row">
                                <div class="col-3">
                                    {!! Form::label('start_date', 'Start Date') !!}
                                </div>
                                <div class="col-9" style="">
                                    <input type="date" class="form-control" name="start_date" id="start_date">
                                </div>
                            </div>
                        </div>
                        {{-- End Date --}}
                        <div class="col-sm-12 mb-1">
                            <div class="row">
                                <div class="col-3">
                                    {!! Form::label('end_date', 'End Date') !!}
                                </div>
                                <div class="col-9" style="">
                                    <input type="date" class="form-control" name="end_date" id="end_date">
                                </div>
                            </div>
                        </div>
                        {{-- Customers --}}
                        <div class="col-sm-12 mb-1">
                            <div class="row">
                                <div class="col-3">
                                    {!! Form::label('customer', 'Customer') !!}
                                </div>
                                <div class="col-9">
                                    <select name="customer_code" id="customer_code" class="form-control select2js">
                                        <option value="">-Choose-</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->AcctCD }}">{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- Percentage --}}
                        <div class="col-sm-12 mb-1">
                            <div class="row">
                                <div class="col-3">
                                    {!! Form::label('percentage', 'Percentage') !!}
                                </div>
                                <div class="col-4" style="">
                                    <input type="number" class="form-control" name="percentage" id="percentage">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="saveBtn">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="modalUpload" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form action="{{ route('dsRules.import') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Import</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12 my-2">
                                    <input type="file" name="file" id="file" class="form-control" accept=".xlsx, .xls" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                {{-- <div class="col-md-4"> --}}
                                    <input type="submit" id="upload" class="btn btn-success" value="Import">
                                {{-- </div> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal Edit --}}
            <div class="modal fade" id="ajaxModel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header text-light bg-success">
                            <h4 class="modal-title" id="modelHeading">Edit Item </h4>
                        </div>
                        <div class="modal-body">
                            <form id="cartForm" name="cartForm" class="form-horizontal">
                             {{-- Start Date --}}
                            <div class="col-sm-12 mb-1">
                                <div class="row">
                                    <div class="col-3">
                                        {!! Form::label('start_date', 'Start Date') !!}
                                    </div>
                                    <div class="col-9" style="">
                                        <input type="hidden" id="percentage_id" name="percentage_id">
                                        <input type="date" class="form-control" name="start_date_edit" id="start_date_edit">
                                    </div>
                                </div>
                            </div>
                            {{-- End Date --}}
                            <div class="col-sm-12 mb-1">
                                <div class="row">
                                    <div class="col-3">
                                        {!! Form::label('end_date', 'End Date') !!}
                                    </div>
                                    <div class="col-9" style="">
                                        <input type="date" class="form-control" name="end_date_edit" id="end_date_edit">
                                    </div>
                                </div>
                            </div>
                            {{-- Customer --}}
                            <div class="col-sm-12 mb-1">
                                <div class="row">
                                    <div class="col-3">
                                        {!! Form::label('customer', 'Customer') !!}
                                    </div>
                                    <div class="col-9" style="">
                                        <input type="text" class="form-control" name="customer_edit" id="customer_edit" readonly>
                                    </div>
                                </div>
                            </div>
                            {{-- Percentage --}}
                            <div class="col-sm-12 mb-1">
                                <div class="row">
                                    <div class="col-3">
                                        {!! Form::label('percentage', 'Percentage') !!}
                                    </div>
                                    <div class="col-4" style="">
                                        <input type="number" class="form-control" name="percentage_edit" id="percentage_edit">
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary updateBtn" id="updateBtn">{{ trans('sales_order.btn_update') }}</button>
                                </div>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
            @include('ds_percentages.table')
        </div>
    </div>
@endsection

@push('page_scripts')
    <script>
        $(function() {
            var status =  $("#customSwitches");
            var save =  $("#save");
            save.prop("disabled", true);

            status.on('change', function() {
                
                if(status.is(":checked")){
                    var the_status = 1;
                } else {
                    var the_status = 0;
                }
                    
                var url = "{{ url('api/update-ds-status') }}" + '/' + the_status;
                $.ajax({
                    url: url,
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        alert('Rule updated successfull');
                    }
                });

            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#dataTable').DataTable({
                lengthChange: false,
                bFilter: true,
                destroy: true,
                paging: true,
                processing: true,
                serverSide: true,
                searching: true,
                ordering: false,
                bInfo : false,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw text-danger"></i><span class="sr-only">Loading...</span> '
                },
                ajax: {
                    url:"{{route('dsPercentagesDataTable.data')}}",
                    type: "GET"
                        
                },
                columns: [
                    {
                        data: 'customer'      
                    }, 
                    {
                        data: 'start_date'      
                    }, 
                    {
                        data: 'end_date'      
                    },
                    {
                        data: 'percentage'      
                    },      
                    {
                        data: 'action',
                        "className": "text-center",
                        orderable: false, 
                        searchable: false    
                    },    
                ]
            });
            
            $('#saveBtn').click(function (e) {
                $.ajax({
                    data: {
                        start_date:$('#start_date').val(),
                        end_date:$('#end_date').val(),
                        customer_code:$('#customer_code').val(),
                        percentage:$('#percentage').val(),
                        created_by:{{ \Auth::user()->id }},
                    },
                    url: "{{ route('dsPercentages.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#addProduct').modal('hide');
                        table.draw();
                    },
                    error: function (data) {
                        alert(data.responseJSON.message);
                    }
                });
            });

            $('body').on('click', '.editBook', function () {
                var item_id = $(this).data('id');
                $.get("{{ route('dsPercentages.index') }}" +'/' + item_id +'/edit', function (data) {
                    // console.log(data);
                    $('#ajaxModel').modal('show');
                    $('#percentage_id').val(data.id);
                    $('#start_date_edit').val(data.start_date);
                    $('#end_date_edit').val(data.end_date);
                    $('#customer_edit').val(data.customer);
                    $('#percentage_edit').val(data.percentage);
                })
            });


            $('#updateBtn').click(function (e) {
                e.preventDefault();
                
                $.ajax({
                    data: {
                            start_date:$('#start_date_edit').val(),
                            end_date:$('#end_date_edit').val(),
                            percentage:$('#percentage_edit').val(),
                            updated_by:{{ \Auth::user()->id }},
                        },
                    url: "{{ route('dsPercentages.index') }}" +'/' + $('#percentage_id').val(),
                    type: "PATCH",
                    dataType: 'json',
                    success: function (data) {
                        $('#ajaxModel').modal('hide');
                        table.draw();
                    },
                    error: function (data) {
                        console.log(data);
                        alert(data.responseJSON.message);
                    }
                });
            });
            
            $('body').on('click', '.deleteBook', function () {
            
                var item_id = $(this).data("id");

                if (confirm("Are You sure want to delete ?") == true) {
                    
                    $.ajax({
                        type: "delete",
                        url: "{{ route('dsPercentages.store') }}"+'/'+item_id,
                        success: function (data) {
                            table.draw();
                        },
                        error: function (data) {
                            // console.log('Error:', data);
                        }
                    });
                }
            });
            
        });

    </script>
@endpush
