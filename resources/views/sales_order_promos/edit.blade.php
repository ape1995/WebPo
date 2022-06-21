@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
<<<<<<< HEAD
<<<<<<< HEAD
                    <h1>Edit {{ trans('sales_order.order') }}</h1>
=======
                    <h1>Edit Sales Order Promo</h1>
>>>>>>> 7af42b6 (update packet discount module)
=======
                    <h1>Edit {{ trans('sales_order.order') }}</h1>
>>>>>>> b1f0485 (update feature packet discount)
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($salesOrderPromo, ['route' => ['salesOrderPromos.update', $salesOrderPromo->id], 'method' => 'patch']) !!}

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> b1f0485 (update feature packet discount)
            <div class="card-header">
                <a href="{{ URL::previous() }}" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-left"></i> Back</a>
            </div>

<<<<<<< HEAD
            <div class="card-body">
                <div class="row mb-3">
                    @include('sales_order_promos.fields-edit')
                </div>
                
                <button class="btn btn-primary text-light mb-2" type="button" id="add_product"  data-toggle="modal" data-target="#modalProduct">
                    {{ trans('sales_order_promo.add') }}
                </button>

                @include('cart_promos.table')

                <!-- Modal -->
                <div class="modal fade" id="modalProduct" role="dialog" aria-labelledby="modalProduct" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <form id="cartsForm" name="cartsForm" class="form-horizontal">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header text-light" style="background-color: #c61325">
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ trans('sales_order_promo.list_promo') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {{-- Product --}}
                                    <div class="col-sm-12 mb-1">
                                        <div class="row">
                                            <div class="col-3">
                                                {!! Form::label('packet_code',  trans('sales_order_promo.packet_code')) !!}
                                            </div>
                                            <div class="col-8">
                                                <select name="packet_code" id="packet_code" class="form-control">
                                                    <option value="">Please Choose</option>
                                                    @foreach ($packetDiscounts as $packet)
                                                        <option value="{{ $packet->packet_code }}">{{ $packet->packet_code }}</option>
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
                                                    {!! Form::label('packet_name',  trans('sales_order_promo.packet_name')) !!}
                                                </div>
                                                <div class="col-9">
                                                    <textarea name="packet_name" id="packet_name" class="form-control" rows="3" readonly></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-1">
                                            <div class="row">
                                                <div class="col-3">
                                                    {!! Form::label('unit_price', trans('sales_order.unit_price')) !!}
                                                </div>
                                                <div class="col-4">
                                                    {!! Form::text('unit_price', null, ['class' => 'form-control', 'readonly' => true ]) !!}
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
                                <h4 class="modal-title" id="modelHeading">{{ trans('sales_order.btn_update') }}</h4>
                            </div>
                            <div class="modal-body">
                                <form id="cartForm" name="cartForm" class="form-horizontal">
                                   <input type="hidden" name="product_id" id="product_id">
                                    <div class="form-group">
                                        <label for="product" class="col-sm-4 control-label">{{  trans('sales_order_promo.packet_name') }}</label>
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

            </div>

            <div class="card-footer">
                {!! Form::submit( trans('sales_order.btn_update'), ['class' => 'btn btn-primary', 'id' => 'savePageButton']) !!}
                {{-- <a href="{{ URL::previous() }}" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-left"></i> Back</a> --}}
=======
=======
>>>>>>> b1f0485 (update feature packet discount)
            <div class="card-body">
                <div class="row mb-3">
                    @include('sales_order_promos.fields-edit')
                </div>
                
                <button class="btn btn-primary text-light mb-2" type="button" id="add_product"  data-toggle="modal" data-target="#modalProduct">
                    {{ trans('sales_order_promo.add') }}
                </button>

                @include('cart_promos.table')

                <!-- Modal -->
                <div class="modal fade" id="modalProduct" role="dialog" aria-labelledby="modalProduct" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <form id="cartsForm" name="cartsForm" class="form-horizontal">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header text-light" style="background-color: #c61325">
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{ trans('sales_order_promo.list_promo') }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    {{-- Product --}}
                                    <div class="col-sm-12 mb-1">
                                        <div class="row">
                                            <div class="col-3">
                                                {!! Form::label('packet_code',  trans('sales_order_promo.packet_code')) !!}
                                            </div>
                                            <div class="col-8">
                                                <select name="packet_code" id="packet_code" class="form-control">
                                                    <option value="">Please Choose</option>
                                                    @foreach ($packetDiscounts as $packet)
                                                        <option value="{{ $packet->packet_code }}">{{ $packet->packet_code }}</option>
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
                                                    {!! Form::label('packet_name',  trans('sales_order_promo.packet_name')) !!}
                                                </div>
                                                <div class="col-9">
                                                    <textarea name="packet_name" id="packet_name" class="form-control" rows="3" readonly></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-1">
                                            <div class="row">
                                                <div class="col-3">
                                                    {!! Form::label('unit_price', trans('sales_order.unit_price')) !!}
                                                </div>
                                                <div class="col-4">
                                                    {!! Form::text('unit_price', null, ['class' => 'form-control', 'readonly' => true ]) !!}
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
                                <h4 class="modal-title" id="modelHeading">{{ trans('sales_order.btn_update') }}</h4>
                            </div>
                            <div class="modal-body">
                                <form id="cartForm" name="cartForm" class="form-horizontal">
                                   <input type="hidden" name="product_id" id="product_id">
                                    <div class="form-group">
                                        <label for="product" class="col-sm-4 control-label">{{  trans('sales_order_promo.packet_name') }}</label>
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

            </div>

            <div class="card-footer">
<<<<<<< HEAD
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('salesOrderPromos.index') }}" class="btn btn-default">Cancel</a>
>>>>>>> 7af42b6 (update packet discount module)
=======
                {!! Form::submit( trans('sales_order.btn_update'), ['class' => 'btn btn-primary', 'id' => 'savePageButton']) !!}
                {{-- <a href="{{ URL::previous() }}" class="btn btn-secondary btn-sm"><i class="fa fa-chevron-left"></i> Back</a> --}}
>>>>>>> b1f0485 (update feature packet discount)
            </div>

            {!! Form::close() !!}

        </div>
    </div>
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> b1f0485 (update feature packet discount)
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
            var packet_code =  $("select#packet_code");
            var packet_name =  $("#packet_name");
            var uom =  $("#uom");
            var qty =  $("#qty");
            var delivery_date =  $("#delivery_date");
            var add_product =  $("#add_product");
            var unit_price =  $("#unit_price");
            var amount =  $("#amount");
            var customer_id =  $("#customer_id");
            var order_qty =  $("#order_qty");
            var order_amount =  $("#order_amount");
            var tax =  $("#tax");
            var order_total =  $("#order_total");
            var save =  $("#saveBtn");
            save.prop("disabled", true);
            $("#savePageButton").attr("disabled", true);

            getAllCounter();

            delivery_date.on('change', function() {
                if(delivery_date.val() == null || delivery_date.val() == ''){
                    add_product.prop("disabled", true);
                } else {
                    table.draw();
                    add_product.prop("disabled", true);
                    $("#savePageButton").prop("disabled", true);

                    // Reset Data
                    // var url = "{{ url('salesOrderDetails-reCountDetailProduct') }}" + "/" + "{{ $salesOrderPromo->id }}" + "/" + delivery_date.val();
                    // // send data to your endpoint
                    // $.ajax({
                    //     url: url,
                    //     method: 'get',
                    //     dataType: 'json',
                    //     success: function(response) {
                    //         table.draw();
                    //     }
                    // });

                    getAllCounter();
                }
            });

            packet_code.on('change', function() {
                $('#data_show').hide();
                qty.val('');
                amount.val('');
                var url = "{{ url('api/get-pakcet-data') }}" + '/' + packet_code.val();
                // send data to your endpoint
                $.ajax({
                    url: url,
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);
                        $('#data_show').show();
                        unit_price.val(response['unit_price']);
                        packet_name.val(response['packet_name']);
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

            $('.money').mask("#,##0.00", {reverse: true});

            function getAllCounter(){
                var url = "{{ url('api/countOrderPromoDetail') }}" + '/' + order_id.val() + '/' + delivery_date.val();
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
                    url:"{{ url('dataTableSalesOrderPromoDetail') }}" + '/' + order_id.val(),
                    type: "GET"
                        
                },
                "rowCallback": function( row, data ) {
                    if(permissionPrice == 'hide price sales order') {
                        $('td:eq(5)', row).addClass("hide-component");
                        $('td:eq(6)', row).addClass("hide-component");
                    }
                    $('td:eq(3)', row).addClass("money");
                    $('td:eq(5)', row).addClass("money");
                    $('td:eq(6)', row).addClass("money");
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
                        data: 'packet_code'      
                    },  
                    {
                        data: 'packet_name'      
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
                        data: 'total'      
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
                            sales_order_promo_id:$('#order_id').val(),
                            packet_code:$('#packet_code').val(),
                            qty:$('#qty').val(),
                            unit_price:$('#unit_price').val(),
                            total:$('#amount').val(),
                        },
                    url: "{{ route('salesOrderPromoDetails.store') }}",
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
                        console.log(data);
                        // console.log('Error:', data);
                        // alert(data);
                        // $('#saveBtn').html('Save Changes');
                    }
                });
            });

            $('body').on('click', '.editProduct', function () {
                var productId = $(this).data('id');
                $.get("{{ route('salesOrderPromoDetails.index') }}" +'/' + productId +'/edit', function (data) {
                    $('#ajaxModel').modal('show');
                    $('#product_name').val(data.packet_name);
                    $('#product_id').val(data.id);
                    $('#product_code').val(data.packet_code);
                    $('#unit_price_edit').val(data.unit_price);
                    $('#amount_edit').val(data.total);
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
                        total:$('#amount_edit').val(),
                        },
                    url: "{{ route('salesOrderPromoDetails.index') }}" +'/' + $('#product_id').val(),
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

                if (confirm("Are You sure want to delete this item?") == true) {
                    
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('salesOrderPromoDetails.store') }}"+'/'+product_id,
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
            
        });

    </script>
<<<<<<< HEAD
@endsection
=======
@endsection
>>>>>>> 7af42b6 (update packet discount module)
=======
@endsection
>>>>>>> b1f0485 (update feature packet discount)
