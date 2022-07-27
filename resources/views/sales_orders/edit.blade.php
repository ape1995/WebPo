@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit {{ trans('sales_order.order') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($salesOrder, ['route' => ['salesOrders.update', $salesOrder->id], 'method' => 'patch']) !!}

            <div class="card-header">
                <a href="{{ URL::previous() }}" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-left"></i> Back</a>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    @include('sales_orders.fields-edit')
                </div>
                
                @if ($salesOrder->order_type == 'C')
                    <button class="btn btn-success text-light mb-2" id="add_promo" type="button"  data-toggle="modal" data-target="#modalPromo">
                        {{ trans('sales_order.add_promo') }}
                    </button>
                @else
                    <button class="btn btn-primary text-light mb-2" type="button" id="add_product"  data-toggle="modal" data-target="#modalProduct">
                        {{ trans('sales_order.add_product') }}
                    </button>
                @endif


                @include('carts.table')

                <!-- Modal -->
                <div class="modal fade" id="modalProduct" role="dialog" aria-labelledby="modalProduct" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <form id="cartsForm" name="cartsForm" class="form-horizontal">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header text-light" style="background-color: #c61325">
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ trans('sales_order.list_product') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {{-- Product --}}
                                    <div class="col-sm-12 mb-1">
                                        <div class="row">
                                            <div class="col-3">
                                                {!! Form::label('inventory_id', trans('sales_order.product')) !!}
                                            </div>
                                            <div class="col-8">
                                                <select name="inventory_id" id="inventory_id" class="form-control select2js">
                                                    <option value="">Please Choose</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->InventoryCD }}">{{ $product->Descr }}</option>
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
                                                    {!! Form::label('unit_price', trans('sales_order.unit_price')) !!}
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
                                                    {!! Form::label('qty', trans('sales_order.qty')) !!}
                                                </div>
                                                <div class="col-3">
                                                    <input pattern="\d*" type="number" class="form-control" name="qty" id="qty" step="1" onKeyPress="if(this.value.length==4) return false;" onkeydown="if(event.key==='.'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Amount Field --}}
                                        <div class="col-sm-12 mb-1">
                                            <div class="row">
                                                <div class="col-3">
                                                    {!! Form::label('amount', trans('sales_order.amount')) !!}
                                                </div>
                                                <div class="col-6">
                                                    {!! Form::text('amount', null, ['class' => 'form-control', 'readonly', true ]) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="saveBtn" class="btn btn-primary">{{ trans('sales_order.btn_add_to_cart') }}</button>
                                </div>
                            </div>
                        {{-- </form> --}}
                    </div>
                </div>

                {{-- Modal edit product --}}
                {{-- Modal Edit --}}
                <div class="modal fade" id="ajaxModel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-light" style="background-color: #c61325">
                                <h4 class="modal-title" id="modelHeading">{{ trans('sales_order.btn_update') }} {{ trans('sales_order.product') }}</h4>
                            </div>
                            <div class="modal-body">
                                <form id="cartForm" name="cartForm" class="form-horizontal">
                                   <input type="hidden" name="product_id" id="product_id">
                                    <div class="form-group">
                                        <label for="product" class="col-sm-4 control-label">{{ trans('sales_order.product') }}</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="product_name" name="product_name" readonly>
                                        </div>
                                    </div>

                                    <label class="col-sm-4" @can('hide price sales order') style=" visibility: collapse;" @endcan>{{ trans('sales_order.unit_price') }}</label>
                                    <div class="col-sm-12" @can('hide price sales order') style=" visibility: collapse;" @endcan>
                                        <input type="text" class="form-control" id="unit_price_edit" name="unit_price_edit" readonly>
                                    </div>
                     
                                    <label class="col-sm-4 control-label">{{ trans('sales_order.qty') }}</label>
                                    <div class="col-sm-12">
                                        <input pattern="\d*" type="number" class="form-control" name="quantity" id="quantity" step="1" onKeyPress="if(this.value.length==4) return false;" onkeydown="if(event.key==='.'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');">
                                    </div>

                                    <div class="form-group" @can('hide price sales order') style=" visibility: collapse;" @endcan>
                                        <label class="col-sm-4 control-label">{{ trans('sales_order.amount') }}</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="amount_edit" name="amount_edit" readonly>
                                        </div>
                                    </div>
                      
                                    <div class="col-md-12 text-right">
                                     <button type="submit" class="btn btn-primary updateBtn" id="updateBtn">{{ trans('sales_order.btn_update') }}</button>
                                    </div>
                                {{-- </form> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modalPromo" tabindex="-1" role="dialog" aria-labelledby="modalPromo" aria-hidden="true">
                    <div class="modal-dialog  modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form id="m_add_promo" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ trans('sales_order.list_promo') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-1">
                                        <div class="col-2">
                                            Promo
                                        </div>
                                        <div class="col-9">
                                            <select name="promo_list" id="promo_list" class="form-control"></select>
                                        </div>
                                    </div>
                                    <div id="hidden_promo" style="display: none">
                                        {{-- Desc Field --}}
                                        <div class="row mb-1">
                                            <div class="col-2">
                                                {!! Form::label('promo_desc', trans('sales_order.description')) !!}
                                            </div>
                                            <div class="col-9">
                                                <textarea name="promo_desc" id="promo_desc" class="form-control" rows="2" readonly></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-2">{{ trans('sales_order.promo_original_price') }}</div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" id="promo_original_price" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-2">{{ trans('sales_order.discount') }}</div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" id="promo_discount" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-2">{{ trans('sales_order.promo_amount') }}</div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" id="promo_amount" readonly>
                                            </div>
                                        </div>
                                        {{-- Qty Field --}}
                                        <div class="row mb-1">
                                            <div class="col-2">
                                                {!! Form::label('qty_promo', trans('sales_order.qty')) !!}
                                            </div>
                                            <div class="col-3">
                                                <input pattern="\d*" type="number" class="form-control" name="qty_promo" id="qty_promo" step="1" onKeyPress="if(this.value.length==4) return false;" onkeydown="if(event.key==='.'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');">
                                            </div>
                                            <div class="col-3">
                                                {{ trans('sales_order.packet') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="col-md-3">
                                        <input type="submit" id="save_promo" class="btn btn-success btn-block" value="{{ trans('sales_order.btn_save') }}">
                                    </div>
                                </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-footer">
                {!! Form::submit('Update', ['class' => 'btn btn-primary', 'id' => 'savePageButton']) !!}
                {{-- <a href="{{ URL::previous() }}" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-left"></i> Back</a> --}}
            </div>

            {!! Form::close() !!}

        </div>
    </div>
    @php
        $permissionPrice = '';
    @endphp
    @can('hide price sales order')
        @php
            $permissionPrice = 'hide price sales order';
        @endphp
    @endcan
@endsection

@section('js')
    <script>
        $(function() {
            var permissionPrice = "{{ $permissionPrice }}";
            var order_id =  $("#order_id");
            var order_nbr =  $("#order_nbr");
            var customer_id =  $("select#customer_id");
            var inventory_id =  $("select#inventory_id");
            var inventory_name =  $("#inventory_name");
            var uom =  $("#uom");
            var qty =  $("#qty");
            var div_promo =  $("#div_promo");
            var hidden_promo =  $("#hidden_promo");
            var promo_desc =  $("#promo_desc");
            var promo_list =  $("#promo_list");
            var save_promo =  $("#save_promo");
            var delivery_date =  $("#delivery_date");
            var add_product =  $("#add_product");
            var add_promo =  $("#add_promo");
            var unit_price =  $("#unit_price");
            var amount =  $("#amount");
            var customer_id =  $("#customer_id");
            var qty_promo =  $("#qty_promo");
            var promo_original_price =  $("#promo_original_price");
            var promo_discount =  $("#promo_discount");
            var promo_amount =  $("#promo_amount");
            var order_qty =  $("#order_qty");
            var order_amount =  $("#order_amount");
            var discount =  $("#discount");
            var tax =  $("#tax");
            var order_total =  $("#order_total");
            var save =  $("#saveBtn");
            save.prop("disabled", true);
            save_promo.prop("disabled", true);
            $("#savePageButton").attr("disabled", true);

            getPromoActive();
            getAllCounter();

            delivery_date.on('change', function() {
                if(delivery_date.val() == null || delivery_date.val() == ''){
                    add_product.prop("disabled", true);
                } else {
                    table.draw();
                    getPromoActive();
                    add_product.prop("disabled", true);
                    $("#savePageButton").prop("disabled", true);

                    var url = "{{ url('salesOrderDetails-reCountDetailProduct') }}" + "/" + "{{ $salesOrder->id }}" + "/" + delivery_date.val();
                    // send data to your endpoint
                    $.ajax({
                        url: url,
                        method: 'get',
                        dataType: 'json',
                        success: function(response) {
                            table.draw();
                            getAllCounter();
                        }
                    });

                    var url2 = "{{ url('resetOrderDetail') }}" + "/" + "{{ $salesOrder->id }}";
                    $.ajax({
                        url: url2,
                        method: 'get',
                        dataType: 'json',
                    });
                }
            });

            inventory_id.on('change', function() {
                $('#data_show').hide();
                qty.val('');
                amount.val('');
                let inventoryCode = inventory_id.val().replace(/^\s+|\s+$/gm,'');
                var url = "{{ url('api/get-inventory-data') }}" + '/' + inventoryCode + '/' + customer_id.val() + '/' + delivery_date.val();
                // send data to your endpoint
                $.ajax({
                    url: url,
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);
                        $('#data_show').show();
                        unit_price.val(response['unit_price']);
                        inventory_name.val(response['inventory_name']);
                        uom.val(response['uom']);
                    }
                });
            });

            promo_list.on('change', function() {
                hidden_promo.hide(); 
                qty.val('');
                var url = "{{ url('api/get-promo-data') }}" + '/' + promo_list.val();
                // send data to your endpoint
                $.ajax({
                    url: url,
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);
                        hidden_promo.show(); 
                        promo_desc.val(response['packet_name']);
                        promo_original_price.val(Intl.NumberFormat('id-ID', { minimumFractionDigits: 2 }).format(response['total']));
                        promo_discount.val(Intl.NumberFormat('id-ID', { minimumFractionDigits: 2 }).format(response['discount']));
                        promo_amount.val(Intl.NumberFormat('id-ID', { minimumFractionDigits: 2 }).format(response['grand_total']));
                    }
                });
            });

            
            $("#qty").on('keyup keydown change click', function() {
                let eachprice = unit_price.val().replace('.','').replace(',','.');
                var total = eachprice * qty.val();
                amount.val(Intl.NumberFormat('id-ID', { minimumFractionDigits: 2 }).format(total));

                if(qty.val() == null || qty.val() == 0){
                    save.attr("disabled", true);
                } else {
                    save.attr("disabled", false);
                }
            });

            $("#quantity").on('keyup keydown change click', function(event) {
                let unitPrice = $("#unit_price_edit").val().replace('.','').replace(',','.');
                var totalPrice = unitPrice * $("#quantity").val();
                $("#amount_edit").val(Intl.NumberFormat('id-ID', { minimumFractionDigits: 2 }).format(totalPrice));

                if($("#quantity").val() == null || $("#quantity").val() == 0){
                    save.attr("disabled", true);
                } else {
                    save.attr("disabled", false);
                }
            });

            $("#qty_promo").on('keyup keydown change click', function() {
                if(qty_promo.val() == null || qty_promo.val() == 0){
                    save_promo.attr("disabled", true);
                } else {
                    save_promo.attr("disabled", false);
                }
            });

            $('.money').mask("#,##0.00", {reverse: true});

            function getAllCounter(){
                var url = "{{ url('api/countOrderDetail') }}" + '/' + "{{ $salesOrder->id }}" + '/' + delivery_date.val();
                // send data to your endpoint
                $.ajax({
                    url: url,
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);
                        order_qty.val(response['order_qty']);
                        order_amount.val(response['order_amount']);
                        discount.val(response['discount']);
                        tax.val(response['tax']);
                        order_total.val(response['order_total']);

                        if(response['order_qty'] == 0 || response['order_qty'] == null || response['order_qty'] == ''){
                            $("#savePageButton").attr("disabled", true);
                        } else {
                            $("#savePageButton").attr("disabled", false);
                        }

                        add_product.prop("disabled", false);

                    }
                });
            }


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#dataTable').DataTable({
                paging: false,
                lengthChange: false,
                bFilter: true,
                destroy: true,
                processing: true,
                serverSide: true,
                searching: false,
                ordering: false,
                bInfo : false,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw text-danger"></i><span class="sr-only">Loading...</span> '
                },
                ajax: {
                    url:"{{ url('dataTableSalesOrderDetail') }}" + '/' + order_id.val(),
                    type: "GET"
                        
                },
                "rowCallback": function( row, data ) {
                    if(permissionPrice == 'hide price sales order') {
                        $('td:eq(4)', row).addClass("hide-component");
                        $('td:eq(5)', row).addClass("hide-component");
                    }
                    $('td:eq(2)', row).addClass("money");
                    $('td:eq(4)', row).addClass("money");
                    $('td:eq(5)', row).addClass("money");
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
                        data: 'discount'      
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
                if($('#qty').val() > 9999){
                    return alert('maksimum kuantitas adalah 9999');
                }
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
                        // console.log(data);
                        $('#data_show').hide();
                        qty.val('');
                        amount.val('');
                        $('#modalProduct').modal('hide');
                        table.draw();
                        getAllCounter();
                    },
                    error: function (data) {
                        // console.log('Error:', data);
                        alert('Produk sudah ada dalam list');
                        // $('#saveBtn').html('Save Changes');
                    }
                });
            });

            save_promo.click(function (e) {
                e.preventDefault();
                // $(this).html('Save');
                if($('#qty').val() > 999){
                    return alert('maksimum kuantitas adalah 999');
                }
                $.ajax({
                    data: {
                        sales_order_id:$('#order_id').val(),
                        packet_code:$('#promo_list').val(),
                        qty:$('#qty_promo').val(),
                        customer_id:$('#customer_id').val(),
                        },
                    url: "{{ route('salesOrderDetails.storePromo') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        hidden_promo.hide();
                        promo_list.select2().select2('val','');
                        qty_promo.val('');
                        $('#modalPromo').modal('hide');
                        table.draw();
                        getAllCounter();
                        save_promo.prop('disabled', true);
                    },
                    error: function (data) {
                        alert('Error !');
                    }
                });
            });

            $('body').on('click', '.editProduct', function () {
                var productId = $(this).data('id');
                $.get("{{ route('salesOrderDetails.index') }}" +'/' + productId +'/edit', function (data) {
                    $('#ajaxModel').modal('show');
                    $('#product_name').val(data.inventory_name);
                    $('#product_id').val(data.id);
                    $('#product_code').val(data.inventory_id);
                    $('#unit_price_edit').val(data.unit_price);
                    $('#amount_edit').val(data.amount);
                    $('#quantity').val(data.qty);
                })
            });

            $('#updateBtn').click(function (e) {
                e.preventDefault();
                // $(this).html('Save');
                if($('#quantity').val() > 9999){
                    return alert('maksimum kuantitas adalah 9999');
                }
                $.ajax({
                    data: {
                        qty:$('#quantity').val(),
                        unit_price:$('#unit_price_edit').val(),
                        amount:$('#amount_edit').val(),
                        },
                    url: "{{ route('salesOrderDetails.index') }}" +'/' + $('#product_id').val(),
                    type: "PATCH",
                    dataType: 'json',
                    success: function (data) {
                        // console.log(data);
                        $('#ajaxModel').modal('hide');
                        table.draw();
                        getAllCounter();
                    },
                    error: function (data) {
                        // console.log('Error:', data);
                        alert('Error Updating data!');
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
                            // console.log('Error:', data);
                        }
                    });
                }
            });

            $('body').on('click', '.deleteBook2', function () {
            
                var product_id = $(this).data("id");

                if (confirm("Are You sure want to delete this product?") == true) {
                    
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('salesOrderDetails.storePromo') }}"+'/'+product_id,
                        success: function (data) {
                            table.draw();
                            getAllCounter();
                        },
                        error: function (data) {
                            // console.log('Error:', data);
                        }
                    });
                }
            });

            function getPromoActive(){
                var url2 = "{{ url('api/get-promo-active') }}" + "/" + delivery_date.val() + "/" + "{{ \Auth::user()->id }}";
                // send data to your endpoint
                $.ajax({
                    url: url2,
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        promo_list.empty();
                        promo_list.html(response)
                    }
                });
            }
            
        });

    </script>
@endsection