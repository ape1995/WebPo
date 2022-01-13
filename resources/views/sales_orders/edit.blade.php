@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit Order</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($salesOrder, ['route' => ['salesOrders.update', $salesOrder->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row mb-3">
                    @include('sales_orders.fields-edit')
                </div>
                
                <a class="btn btn-primary text-light mb-2" type="button"  data-toggle="modal" data-target="#modalProduct">
                    Add Product
                </a>

                @include('carts.table')

                <!-- Modal -->
                <div class="modal fade" id="modalProduct" role="dialog" aria-labelledby="modalProduct" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <form id="cartsForm" name="cartsForm" class="form-horizontal">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header text-light" style="background-color: #c61325">
                                    <h5 class="modal-title" id="exampleModalLongTitle">List Product</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {{-- Product --}}
                                    <div class="col-sm-12 mb-1">
                                        <div class="row">
                                            <div class="col-3">
                                                {!! Form::label('inventory_id', 'Product:') !!}
                                            </div>
                                            <div class="col-8">
                                                <select name="inventory_id" id="inventory_id" class="form-control select2js">
                                                    <option value="">Please Choose</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->InventoryCD }}">{{ $product->Descr }} - {{ $product->InventoryCD }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Detail Product Field -->
                                    <div id="data_show" style="display: none">
                                        <div class="col-sm-12 mb-1">
                                            <div class="row">
                                                <div class="col-3">
                                                    <input name="inventory_name" id="inventory_name" type="hidden" value="">
                                                    {!! Form::label('unit_price', 'Unit Price:') !!}
                                                </div>
                                                <div class="col-4">
                                                    {!! Form::text('unit_price', null, ['class' => 'form-control', 'readonly' => true ]) !!}
                                                </div>
                                                <div class="col-1">
                                                    {!! Form::label('uom', 'UOM:') !!}
                                                </div>
                                                <div class="col-3">
                                                    {!! Form::text('uom', 'PIECE', ['class' => 'form-control', 'readonly' => true ]) !!}
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Qty Field --}}
                                        <div class="col-sm-12 mb-1">
                                            <div class="row">
                                                <div class="col-3">
                                                    {!! Form::label('qty', 'Quantity:') !!}
                                                </div>
                                                <div class="col-3">
                                                    {!! Form::number('qty', NULL, ['class' => 'form-control', 'min' => 1]) !!}
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Amount Field --}}
                                        <div class="col-sm-12 mb-1">
                                            <div class="row">
                                                <div class="col-3">
                                                    {!! Form::label('amount', 'Amount:') !!}
                                                </div>
                                                <div class="col-6">
                                                    {!! Form::text('amount', null, ['class' => 'form-control', 'readonly', true ]) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="saveBtn" class="btn btn-primary">Add To Cart</button>
                                </div>
                            </div>
                        {{-- </form> --}}
                    </div>
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('salesOrders.show', $salesOrder->id) }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            var order_id =  $("#order_id");
            var order_nbr =  $("#order_nbr");
            var customer_id =  $("select#customer_id");
            var inventory_id =  $("select#inventory_id");
            var inventory_name =  $("#inventory_name");
            var uom =  $("#uom");
            var qty =  $("#qty");
            var unit_price =  $("#unit_price");
            var amount =  $("#amount");
            var customer_id =  $("#customer_id");
            var order_qty =  $("#order_qty");
            var order_amount =  $("#order_amount");
            var tax =  $("#tax");
            var order_total =  $("#order_total");
            var save =  $("#save");
            save.attr("disabled", true);

            getAllCounter();

            inventory_id.on('change', function() {
                $('#data_show').hide();
                qty.val('');
                amount.val('');
                let inventoryCode = inventory_id.val().replace(/^\s+|\s+$/gm,'');
                var url = "{{ url('api/get-inventory-data') }}" + '/' + inventoryCode + '/' + customer_id.val();
                // send data to your endpoint
                $.ajax({
                    url: url,
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        $('#data_show').show();
                        unit_price.val(response['unit_price']);
                        inventory_name.val(response['inventory_name']);
                        uom.val(response['uom']);
                    }
                });
            });

            
            $("#qty").keyup(function() {
                let eachprice = unit_price.val().replace('.','').replace(',','.');
                var total = eachprice * qty.val();
                amount.val(Intl.NumberFormat('id-ID', { minimumFractionDigits: 2 }).format(total));

                if(qty.val() == null || qty.val() == 0){
                    save.attr("disabled", true);
                } else {
                    save.attr("disabled", false);
                }
            });

            $('.money').mask("#,##0.00", {reverse: true});

            function getAllCounter(){
                var url = "{{ url('api/countOrderDetail') }}" + '/' + order_id.val();
                // send data to your endpoint
                $.ajax({
                    url: url,
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        order_qty.val(response['order_qty']);
                        order_amount.val(response['order_amount']);
                        tax.val(response['tax']);
                        order_total.val(response['order_total']);
                    }
                });
            }


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#dataTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                bFilter: true,
                destroy: true,
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url:"{{ url('dataTableSalesOrderDetail') }}" + '/' + order_id.val(),
                    type: "GET"
                        
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
                        data: 'inventory_id',                                    
                    },
                    {
                        data: 'inventory_name'      
                    },      
                    {
                        data: 'qty'      
                    },                        
                    {
                        data: 'uom'      
                    },   
                    {
                        data: 'unit_price'      
                    },   
                    {
                        data: 'amount'      
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
                e.preventDefault();
                // $(this).html('Save');
            
                $.ajax({
                    data: {
                            sales_order_id:$('#order_id').val(),
                            inventory_id:$('#inventory_id').val(),
                            inventory_name:$('#inventory_name').val(),
                            uom:$('#uom').val(),
                            qty:$('#qty').val(),
                            unit_price:$('#unit_price').val(),
                            amount:$('#amount').val(),
                        },
                    url: "{{ route('salesOrderDetails.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        $('#data_show').hide();
                        qty.val('');
                        amount.val('');
                        $('#modalProduct').modal('hide');
                        table.draw();
                        getAllCounter();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        alert('Product Already Listed on Carts');
                        // $('#saveBtn').html('Save Changes');
                    }
                });
            });
            
            $('body').on('click', '.deleteBook', function () {
            
                var product_id = $(this).data("id");

                if (confirm("Are You sure want to delete this product?") == true) {
                    
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('salesOrderDetails.store') }}"+'/'+product_id,
                        success: function (data) {
                            table.draw();
                            getAllCounter();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });
            
        });

    </script>
@endsection