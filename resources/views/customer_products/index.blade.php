@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customer Products</h1>
                </div>
                <div class="col-sm-6 mx-auto">
                    @can('create customer products')
                        <a class="btn btn-primary float-right ml-3"
                        href="{{ route('customerProducts.create') }}">
                            {{ trans('customer_product.create') }}
                        </a>
                    @endcan
                    @can('bulk customer products')
                        <a class="btn btn-info float-right ml-3"
                        href="{{ route('customerProducts.createBulk') }}">
                            {{ trans('customer_product.bulk_action') }}
                        </a>
                    @endcan
                    @can('create customer products')
                        <button class="btn btn-success text-light float-right ml-3" id="btn_upload_product" type="button"  data-toggle="modal" data-target="#modalUpload">
                            {{ trans('sales_order.btn_upload_product') }}
                        </button>
                    @endcan
                    <!-- Modal -->
                    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="modalUpload" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form action="{{ route('uploadCustomerProducts') }}" method="post" enctype="multipart/form-data">
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
                                        <div class="col-md-4 m-3">
                                            <input type="submit" id="upload" class="btn btn-success" value="Import">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-3">
                <div class="row">

                    <div class="mb-3 col-md-3 mx-auto">
                        <label for="customer_id">{{ trans('customer_product.customer') }}</label> 
                        <select name="customer_id" id="customer_id" class="form-control select2js">
                            <option value="">- All Customer -</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->AcctCD }}">{{ $customer->AcctName }} - {{ $customer->AcctCD }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @include('customer_products.table')
            </div>

        </div>
    </div>

@endsection


@push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function() {              
            var table = $('#dataTable').DataTable({
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
                    url:"{{route('customerProducts.data')}}",
                    type: "GET"
                        
                },
                columns: [
                    {
                        data: 'customer_code'                                  
                    },
                    {
                        data: 'inventory'      
                    },      
                    {
                        data: 'customer_class'      
                    },                        
                    {
                        data: 'date_add'      
                    },
                    {
                        data: 'action',
                        "className": "text-center",
                        orderable: false, 
                        searchable: false    
                    },    
                ]
            });

            $("#customer_id").change(function() { 
                var val = [];
                val.push($('#customer_id').val());
                table.search(val.join(' ')).draw();   
            });
        });
    </script>
@endpush
