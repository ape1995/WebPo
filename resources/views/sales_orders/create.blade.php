@extends('layouts.app')

@section('content')
    {{-- <section class="content-header"> --}}
        <div class="container-fluid p-1 mx-3">
            <h5>{{ trans('sales_order.create_order') }}</h5>
        </div>
    {{-- </section> --}}

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::open(['route' => 'salesOrders.store']) !!}

            <div class="card-body">

                <div class="row mb-3">
                    @include('sales_orders.fields')
                </div>

                <div class="row" id="div_reguler" style="display: none">
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-block text-light mb-2" id="add_product" type="button"  data-toggle="modal" data-target="#modalProduct">
                            {{ trans('sales_order.add_product') }}
                        </button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-success btn-block text-light mb-2" id="btn_upload_product" type="button"  data-toggle="modal" data-target="#modalUpload">
                            {{ trans('sales_order.btn_upload_product') }}
                        </button>
                    </div>
                </div>
                
                <div class="row" id="div_promo" style="display: none">
                    <div class="col-md-2">
                        <button class="btn btn-success btn-block text-light mb-2" id="add_promo" type="button"  data-toggle="modal" data-target="#modalPromo">
                            {{ trans('sales_order.add_promo') }}
                        </button>
                    </div>
                </div>
                

                   
                {{-- <a class="btn btn-success mb-2" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    {{ trans('sales_order.btn_upload_product') }}
                </a>
                <div class="collapse" id="collapseExample">
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-5 my-2">
                                <input type="file" name="file" id="file" class="form-control" accept=".xlsx, .xls" required>
                            </div>
                            <div class="col-md-2 my-2">
                                <input type="submit" class="btn btn-primary" value="Upload">
                            </div>
                        </div>
                    </form>
                </div> --}}

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
                                            {{-- <div class="col-3">
                                                {!! Form::label('inventory_id', trans('sales_order.product')) !!}
                                            </div> --}}
                                            <div class="col-12">
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
                                                <div class="col-3" @can('hide price sales order') style=" visibility: collapse;" @endcan>
                                                    <input name="inventory_name" id="inventory_name" type="hidden" value="">
                                                    {!! Form::label('unit_price', trans('sales_order.unit_price')) !!}
                                                </div>
                                                <div class="col-4" @can('hide price sales order') style=" visibility: collapse;" @endcan>
                                                    <input type="text" name="unit_price" id="unit_price" class="form-control" readonly>
                                                    {{-- {!! Form::text('unit_price', null, ['class' => 'form-control', 'readonly' => true ]) !!} --}}
                                                </div>
                                                <div class="col-2">
                                                    {!! Form::label('uom', trans('sales_order.uom')) !!}
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
                                                <div class="col-3" @can('hide price sales order') style=" visibility: collapse;" @endcan>
                                                    {!! Form::label('amount', trans('sales_order.amount')) !!}
                                                </div>
                                                <div class="col-6" @can('hide price sales order') style=" visibility: collapse;" @endcan>
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

                {{-- Modal Edit --}}
                <div class="modal fade" id="ajaxModel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-light" style="background-color: #c61325">
                                <h4 class="modal-title" id="modelHeading">{{ trans('sales_order.btn_update') }} {{trans('sales_order.product')}} </h4>
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
            </div>

            <div class="card-footer">
                {{-- {!! Form::submit('Save', ['class' => 'btn btn-primary', 'id' => 'savePageButton']) !!} --}}
                <input type="submit" name="savePageButton" id="savePageButton" class="btn btn-primary" value="{{ trans('sales_order.btn_save') }}">
                <a href="{{ route('salesOrders.resetOrder') }}" onclick="return confirm('{{ trans('sales_order.question_reset') }}')" class="btn btn-default">{{ trans('sales_order.btn_reset') }}</a>
            </div>

            {!! Form::close() !!}

            <!-- Modal -->
            <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="modalUpload" aria-hidden="true">
                <div class="modal-dialog  modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <form id="mupload_product" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">{{ trans('sales_order.btn_upload_product') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12 my-2">
                                    <input type="date" id="date_file" name="date_file" style="visibility: collapse">
                                    <input type="file" name="file" id="file" class="form-control" accept=".xlsx, .xls" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="col-md-4 m-3">
                                    <input type="submit" id="upload_product" class="btn btn-success" value="{{ trans('sales_order.btn_upload_product') }}">
                                </div>
                            </div>
                        </form>
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
                        </form>
                    </div>
                </div>
            </div>

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
            var customer_id =  $("select#customer_id");
            var inventory_id =  $("select#inventory_id");
            var inventory_name =  $("#inventory_name");
            var div_promo =  $("#div_promo");
            var hidden_promo =  $("#hidden_promo");
            var promo_desc =  $("#promo_desc");
            var promo_list =  $("#promo_list");
            var save_promo =  $("#save_promo");
            var div_reguler =  $("#div_reguler");
            var order_type =  $("#order_type");
            var uom =  $("#uom");
            var qty =  $("#qty");
            var qty_promo =  $("#qty_promo");
            var promo_original_price =  $("#promo_original_price");
            var promo_discount =  $("#promo_discount");
            var promo_amount =  $("#promo_amount");
            var delivery_date =  $("#delivery_date");
            var add_product =  $("#add_product");
            var add_promo =  $("#add_promo");
            var unit_price =  $("#unit_price");
            var amount =  $("#amount");
            var customer_id =  $("#customer_id");
            var order_qty =  $("#order_qty");
            var order_amount =  $("#order_amount");
            var tax =  $("#tax");
            var discount =  $("#discount");
            var order_total =  $("#order_total");
            var save =  $("#saveBtn");
            var btn_upload_product =  $("#btn_upload_product");
            // var mupload_product =  $("#mupload_product");
            btn_upload_product.prop("disabled", true);
            save.prop("disabled", true);
            save_promo.prop("disabled", true);
            add_product.prop("disabled", true);
            add_promo.prop("disabled", true);
            $("#savePageButton").prop("disabled", true);

            // getAllCounter();

            $('#mupload_product').on('submit', function(){
                $('#upload_product').attr('disabled', true);
                var url = "{{ route('salesOrders.importProduct') }}";
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
                        $('#upload_product').attr('disabled', false);
                        $('#modalUpload').modal('hide');
                        table.draw();
                        getAllCounter();
                    },
                    error:function(data)
                    {
                        $('#upload_product').attr('disabled', false);
                        alert('Ada Produk yang tidak sesuai, mohon cek kembali');
                    }
                })
            });

            delivery_date.on('change', function() {
                // Send delivery date to date_file
                $('#date_file').val(delivery_date.val());

                if (order_type.val() != '' || order_type.val() != null){
                    if (order_type.val() == 'R'){
                        validateOrder()
                    } else {
                        var url = "{{ url('api/get-promo-hold-duration') }}" + "/" + order_type.val();
                        // send data to your endpoint
                        $.ajax({
                            url: url,
                            method: 'get',
                            dataType: 'json',
                            success: function(response) {
                                // inventory_id.empty();
                                if (response == 1) {
                                    // IF Delivery Date Is Null
                                    if(delivery_date.val() == null || delivery_date.val() == ''){
                                        swal("Gagal!", "Mohon Isi Tanggal Pengiriman Terlebih Dahulu!", "error");
                                        order_type.val('').change();
                                        validateOrder();
                                    } else {
                                        var url2 = "{{ url('api/validate-order-type') }}" + "/" + order_type.val() + "/" + "{{ \Auth::user()->id }}" + "/" + delivery_date.val();
                                        // send data to your endpoint
                                        $.ajax({
                                            url: url2,
                                            method: 'get',
                                            dataType: 'json',
                                            success: function(response2) {
                                                // console.log(response2);
                                                if (response2 == 1) {
                                                    validateOrder();
                                                    loadFromType();
                                                } else {
                                                    swal("Gagal!", "Anda belum memiliki hak untuk promo ini!", "error");
                                                    order_type.val('').change();
                                                    validateOrder();
                                                }
                                            }
                                        });
                                    }
                                    
                                } else {
                                    validateOrder();
                                }
                            }
                        });
                    }
                }
            });

            function validateOrder(){
                var url2 = "{{ url('resetOrder') }}";
                $.ajax({
                    url: url2,
                    method: 'get',
                    dataType: 'json',
                });

                if(delivery_date.val() == null || delivery_date.val() == ''){
                    add_product.prop("disabled", true);
                } else {
                    table.draw();
                    $('#date_file').val(delivery_date.val());
                    add_product.prop("disabled", true);
                    btn_upload_product.prop("disabled", true);
                    $("#savePageButton").prop("disabled", true);

                    var url3 = "{{ url('api/get-promo-product-active') }}" + "/" + delivery_date.val() + "/" + "{{ \Auth::user()->id }}" + "/" + order_type.val();
                    // send data to your endpoint
                    $.ajax({
                        url: url3,
                        method: 'get',
                        dataType: 'json',
                        success: function(response) {
                            // inventory_id.empty();
                            inventory_id.html(response).change();
                        }
                    });


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

                    var url = "{{ url('carts-reCountDetailProduct') }}" + "/" + delivery_date.val();
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

                }
            }

            order_type.on('change', function() {

                if (order_type.val() == 'R'){
                    loadFromType();
                } else {
                    // Cek Data
                    var url = "{{ url('api/get-promo-hold-duration') }}" + "/" + order_type.val();
                    // send data to your endpoint
                    $.ajax({
                        url: url,
                        method: 'get',
                        dataType: 'json',
                        success: function(response) {
                            // inventory_id.empty();
                            if (response == 1) {
                                // IF Delivery Date Is Null
                                if(delivery_date.val() == null || delivery_date.val() == ''){
                                    swal("Gagal!", "Mohon Isi Tanggal Pengiriman Terlebih Dahulu!", "error");
                                    order_type.val('').change();
                                    loadFromType();
                                } else {
                                    var url2 = "{{ url('api/validate-order-type') }}" + "/" + order_type.val() + "/" + "{{ \Auth::user()->id }}" + "/" + delivery_date.val();
                                    // send data to your endpoint
                                    $.ajax({
                                        url: url2,
                                        method: 'get',
                                        dataType: 'json',
                                        success: function(response2) {
                                            // console.log(response2);
                                            if (response2 == 1) {
                                                loadFromType();
                                            } else {
                                                swal("Gagal!", "Anda belum memiliki hak untuk promo ini!", "error");
                                                order_type.val('').change();
                                                loadFromType();
                                            }
                                        }
                                    });
                                }
                                
                            } else {
                                loadFromType();
                            }
                        }
                    });
                }

            });

            function loadFromType(){

                if (order_type.val() == 'C') {
                    div_promo.show();
                    div_reguler.hide();
                } else if(order_type.val() == 'G') {
                    var urlCek = "{{ url('api/get-gimmick-active') }}" + "/" + order_type.val() + "/" + delivery_date.val();
                    // send data to your endpoint
                    $.ajax({
                        url: urlCek,
                        method: 'get',
                        dataType: 'json',
                        success: function(response) {
                            if (response == true) {
                                div_reguler.show();
                                div_promo.hide();
                            } else {
                                swal("Gagal!", "Tidak Ada Promo Gimmick Untuk Tanggal Tersebut!", "error");
                                order_type.val('').change();
                                div_promo.hide();
                                div_reguler.hide();
                            }
                        },
                        error: function(response){
                            div_promo.hide();
                            div_reguler.hide();
                        }
                    });

                } else if (order_type.val() == 'R' || order_type.val() == 'P' || order_type.val() == 'D') {
                    div_reguler.show();
                    div_promo.hide();
                } else {
                    div_promo.hide();
                    div_reguler.hide();
                }

                if (order_type.val() == 'P') {
                    btn_upload_product.hide();
                } else {
                    btn_upload_product.show();
                }

                var url3 = "{{ url('api/get-promo-product-active') }}" + "/" + delivery_date.val() + "/" + "{{ \Auth::user()->id }}" + "/" + order_type.val();
                // send data to your endpoint
                $.ajax({
                    url: url3,
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        // inventory_id.empty();
                        inventory_id.html(response).change();
                    }
                });


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

                var url = "{{ url('carts-reCountDetailProduct') }}" + "/" + delivery_date.val();
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

                var url = "{{ url('resetOrder') }}";
                $.ajax({
                    url: url,
                    method: 'get',
                    dataType: 'json',
                });

                table.draw();
                getAllCounter();

            }

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
                var url = "{{ url('api/getAllCounter') }}" + '/' + customer_id.val() + '/' + delivery_date.val();
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

                        // disable save if qty = 0
                        if(response['order_qty'] == 0 || response['order_qty'] == null || response['order_qty'] == ''){
                            $("#savePageButton").attr("disabled", true);
                        } else {
                            $("#savePageButton").attr("disabled", false);
                        }

                        if($("#delivery_date").val() == null || $("#order_type").val() == null){
                            btn_upload_product.prop("disabled", true);
                            add_product.prop("disabled", true);
                            add_promo.prop("disabled", true);
                        } else {
                            btn_upload_product.prop("disabled", false);
                            add_product.prop("disabled", false);
                            add_promo.prop("disabled", false);
                        }
                        
                    }
                });
            }


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#dataTable').DataTable({
                lengthChange: false,
                bFilter: true,
                destroy: true,
                paging: false,
                processing: true,
                serverSide: true,
                searching: false,
                ordering: false,
                bInfo : false,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw text-danger"></i><span class="sr-only">Loading...</span> '
                },
                ajax: {
                    url:"{{route('carts.data')}}",
                    type: "GET"
                        
                },
                "rowCallback": function( row, data ) {
                    if(permissionPrice == 'hide price sales order') {
                        $('td:eq(4)', row).addClass("hide-component");
                        $('td:eq(5)', row).addClass("hide-component");
                        $('td:eq(6)', row).addClass("hide-component");
                    }
                    $('td:eq(2)', row).addClass("money");
                    $('td:eq(4)', row).addClass("money");
                    $('td:eq(5)', row).addClass("money");
                    $('td:eq(6)', row).addClass("money");
                },
                columns: [
                    { 
                        data: 'DT_RowIndex',
                        name: 'DT_Row_Index', 
                        "className": "text-center" ,
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

            $('body').on('click', '.editBook', function () {
                var productId = $(this).data('id');
                $.get("{{ route('carts.index') }}" +'/' + productId +'/edit', function (data) {
                    $('#ajaxModel').modal('show');
                    $('#product_name').val(data.inventory_name);
                    $('#product_id').val(data.id);
                    $('#product_code').val(data.inventory_id);
                    $('#unit_price_edit').val(data.unit_price);
                    $('#amount_edit').val(data.amount);
                    $('#quantity').val(data.qty);
                })
            });

            $('#saveBtn').click(function (e) {
                e.preventDefault();
                // $(this).html('Save');
                if($('#qty').val() > 9999){
                    return alert('maksimum kuantitas adalah 9999');
                }
                $.ajax({
                    data: {
                        inventory_id:$('#inventory_id').val(),
                        inventory_name:$('#inventory_name').val(),
                        uom:$('#uom').val(),
                        qty:$('#qty').val(),
                        unit_price:$('#unit_price').val(),
                        amount:$('#amount').val(),
                        customer_id:$('#customer_id').val()
                        },
                    url: "{{ route('carts.store') }}",
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
                        // console.log(data);
                        alert('Produk sudah ada dalam list');
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
                        packet_code:$('#promo_list').val(),
                        qty:$('#qty_promo').val(),
                        customer_id:$('#customer_id').val(),
                        },
                    url: "{{ route('carts.storePromo') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        // console.log(data);
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
                    url: "{{ route('carts.index') }}" +'/' + $('#product_id').val(),
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

                if (confirm("Are You sure want to delete ?") == true) {
                    
                    $.ajax({
                        type: "delete",
                        url: "{{ route('carts.store') }}"+'/'+product_id,
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

                if (confirm("Are You sure want to delete ?") == true) {
                    
                    $.ajax({
                        type: "delete",
                        url: "{{ route('carts.storePromo') }}"+'/'+product_id,
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
@endsection