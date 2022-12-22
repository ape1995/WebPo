<!-- Packet Code Field -->
<div class="form-group col-sm-3">
    {!! Form::label('packet_code', trans('packet_discount.packet_code')) !!}
    {!! Form::text('packet_code', null, ['class' => 'form-control', 'required' => true, 'minlength' => 10, 'maxlength' => 10, 'oninput' => 'this.value = this.value.toUpperCase()']) !!}
    <div id="warning" style="display: none">
        <span id="warning_text" class="text-danger text-sm"></span>
    </div>
</div>

<!-- Packet Name Field -->
<div class="form-group col-sm-10">
    {!! Form::label('packet_name', trans('packet_discount.packet_name')) !!}
    {!! Form::text('packet_name', null, ['class' => 'form-control', 'required' => true]) !!}
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-4">
    {!! Form::label('start_date', trans('packet_discount.start_date')) !!}
    {!! Form::date('start_date', null, ['class' => 'form-control','id'=>'start_date', 'required' => true]) !!}
</div>

<!-- End Date Field -->
<div class="form-group col-sm-4">
    {!! Form::label('end_date', trans('packet_discount.end_date')) !!}
    {!! Form::date('end_date', null, ['class' => 'form-control','id'=>'end_date', 'required' => true]) !!}
</div>

<!-- Rbp Class Field -->
<div class="form-group col-sm-4">
    {!! Form::label('rbp_class', 'Rbp Class:') !!}
    {{-- {!! Form::text('rbp_class', null, ['class' => 'form-control']) !!} --}}
    <select name="rbp_class" id="rbp_class" class="form-control" required>
        <option value="">- Please Choose -</option>
        <option value="RBP38">Distributor - RBP38</option>
        <option value="RBP35">Agen - RBP35</option>
    </select>
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', trans('packet_discount.description')) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => true, 'rows' => 3]) !!}
</div>

{{-- bound --}}
<div class="col-md-12">
    <div class="card card-body bg-light p-3">
        <button class="btn btn-primary text-light col-md-2 mb-2" id="add_product" type="button"  data-toggle="modal" data-target="#modalProduct">
            {{ trans('sales_order.add_product') }}
        </button>
        
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
                                    <div class="col-12" style="">
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
                                            <input pattern="\d*" type="number" class="form-control" name="qty" id="qty" step="1" onKeyPress="if(this.value.length==5) return false;" onkeydown="if(event.key==='.'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');">
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
                                {{-- Discount Field --}}
                                <div class="col-sm-12 mb-1">
                                    <div class="row">
                                        <div class="col-3">
                                            {!! Form::label('discount_percentage', trans('sales_order.discount_percentage')) !!}
                                        </div>
                                        <div class="col-6">
                                            <input pattern="\d*" type="number" class="form-control" name="discount_percentage" id="discount_percentage" max="100" step="1" onKeyPress="if(this.value.length==5) return false;" onkeydown="if(event.key==='.'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');">
                                        </div>
                                    </div>
                                </div>
                                {{-- Amount Field --}}
                                <div class="col-sm-12 mb-1">
                                    <div class="row">
                                        <div class="col-3">
                                            {!! Form::label('total_amount', trans('sales_order.amount')) !!}
                                        </div>
                                        <div class="col-6">
                                            {!! Form::text('total_amount', null, ['class' => 'form-control', 'readonly', true ]) !!}
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
        
                            <label class="col-sm-4">{{ trans('sales_order.unit_price') }}</label>
                            <div class="col-sm-12" >
                                <input type="text" class="form-control" id="unit_price_edit" name="unit_price_edit" readonly>
                            </div>
             
                            <label class="col-sm-4 control-label">{{ trans('sales_order.qty') }}</label>
                            <div class="col-sm-12">
                                <input pattern="\d*" type="number" class="form-control" name="quantity" id="quantity" step="1" onKeyPress="if(this.value.length==5) return false;" onkeydown="if(event.key==='.'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');">
                            </div>
        
                            <div class="form-group">
                                <label class="col-sm-4 control-label">{{ trans('sales_order.amount') }}</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="amount_edit" name="amount_edit" readonly>
                                </div>
                            </div>

                            <label class="col-sm-4 control-label">{{ trans('sales_order.discount_percentage') }}</label>
                            <div class="col-sm-12">
                                <input pattern="\d*" type="number" class="form-control" name="discount_percentage_edit" id="discount_percentage_edit" step="1" onKeyPress="if(this.value.length==5) return false;" onkeydown="if(event.key==='.'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');">
                            </div>
        
                            <div class="form-group">
                                <label class="col-sm-4 control-label">{{ trans('sales_order.amount') }}</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="total_amount_edit" name="total_amount_edit" readonly>
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

        @include('packet_discount_details.table')
    </div>
</div>

{{-- bound --}}

<!-- Total Field -->
<div class="form-group col-sm-4">
    {!! Form::label('total', 'Total:') !!}
    {!! Form::text('total', null, ['class' => 'form-control money', 'id' => 'total', 'readonly' => true]) !!}
</div>

<!-- Discount Field -->
<div class="form-group col-sm-4">
    {!! Form::label('discount', trans('packet_discount.discount')) !!}
    {!! Form::text('discount', null, ['class' => 'form-control money', 'id' => 'discount', 'readonly' => true]) !!}
</div>

<!-- Grand Total Field -->
<div class="form-group col-sm-4">
    {!! Form::label('grand_total', 'Grand Total:') !!}
    {!! Form::text('grand_total', null, ['class' => 'form-control money', 'id' => 'grand_total', 'readonly' => true]) !!}
</div>

@section('js')
    <script>
        $(function() {
            var inventory_id =  $("select#inventory_id");
            var packet_code =  $("#packet_code");
            var inventory_name =  $("#inventory_name");
            var uom =  $("#uom");
            var qty =  $("#qty");
            var discount_percentage =  $("#discount_percentage");
            var discount_percentage_edit =  $("#discount_percentage_edit");
            var start_date =  $("#start_date");
            var end_date =  $("#end_date");
            var add_product =  $("#add_product");
            var unit_price =  $("#unit_price");
            var total =  $("#total");
            var discount =  $("#discount");
            var grand_total =  $("#grand_total");
            var amount =  $("#amount");
            var total_amount =  $("#total_amount");
            var total_amount_edit =  $("#total_amount_edit");
            var rbp_class =  $("select#rbp_class");
            // var rbp_class_selected =  $("rbp_class_selected");
            var save =  $("#saveBtn");
            save.prop("disabled", true);
            add_product.prop("disabled", true);
            $("#savePageButton").prop("disabled", true);

            getAllCounter();

            start_date.on('change', function() {

                if((start_date.val() == null || start_date.val() == '') || (rbp_class.val() == null || rbp_class.val() == '')){
                    add_product.prop("disabled", true);
                } else {
                    table.draw();
                    add_product.prop("disabled", false);
                    $("#savePageButton").prop("disabled", true);

                    // Reset Detail

                    var url = "{{ url('packetDiscountDetails-reset') }}" + "/" + "{{ \Auth::user()->id }}";
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
                
            });

            rbp_class.on('change', function() {

                if((start_date.val() == null || start_date.val() == '') || (rbp_class.val() == null || rbp_class.val() == '')){
                    add_product.prop("disabled", true);
                } else {
                    table.draw();
                    add_product.prop("disabled", false);
                    $("#savePageButton").prop("disabled", true);

                    // Reset Detail

                    var url = "{{ url('packetDiscountDetails-reset') }}" + "/" + "{{ \Auth::user()->id }}";
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

            });

            inventory_id.on('change', function() {
                $('#data_show').hide();
                qty.val('');
                amount.val('');
                let inventoryCode = inventory_id.val().replace(/^\s+|\s+$/gm,'');
                var url = "{{ url('api/get-inventory-data-2') }}" + '/' + inventoryCode + '/' + rbp_class.val() + '/' + start_date.val();
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

            packet_code.focusout(function() {
                
                var url = "{{ url('api/cek-data-packet-code') }}" + '/' + packet_code.val();
                // send data to your endpoint
                $.ajax({
                    url: url,
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        $('#warning').hide();
                    },
                    error: function(response) {
                        console.log(response);
                        $('#warning').show();
                        $('#warning_text').html(response.responseJSON.message);
                        packet_code.focus();
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

            $("#discount_percentage").on('keyup keydown change click', function() {
                let eachprice = unit_price.val().replace('.','').replace(',','.');
                var total = eachprice * qty.val();
                var totalAfDisc = total - (total * discount_percentage.val() / 100);
                total_amount.val(Intl.NumberFormat('id-ID', { minimumFractionDigits: 2 }).format(totalAfDisc));
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

            $("#discount_percentage_edit").on('keyup keydown change click', function() {
                let unitPrice = $("#unit_price_edit").val().replace('.','').replace(',','.');
                var totalPrice = unitPrice * $("#quantity").val();
                var totalAfDisc2 = totalPrice - (totalPrice * discount_percentage_edit.val() / 100);
                total_amount_edit.val(Intl.NumberFormat('id-ID', { minimumFractionDigits: 2 }).format(totalAfDisc2));
            });

            // $("#discount").on('keyup keydown change click', function(event) {
            //     let total = $("#total").val().replace('.','').replace(',','.');
            //     let discount = $("#discount").val().replace('.','').replace(',','.');
            //     var totalPrice = total - discount;
            //     $("#grand_total").val(Intl.NumberFormat('id-ID', { minimumFractionDigits: 0 }).format(totalPrice));

            //     if($("#discount").val() == null || $("#discount").val() == 0){
            //         $("#savePageButton").attr("disabled", true);
            //     } else {
            //         $("#savePageButton").attr("disabled", false);
            //     }
            // });

            $('.money').mask("#.##0", {reverse: true});

            function getAllCounter(){
                var url = "{{ url('api/getAllCounterDiscount') }}" + '/' + {{ \Auth::user()->id }};
                // send data to your endpoint
                $.ajax({
                    url: url,
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response);
                        total.val(response['total_amount']);
                        discount.val(response['discount']);
                        grand_total.val(response['grand_total']);

                        // disable save if qty = 0
                        if(response['total_amount'] == 0 || response['total_amount'] == null || response['total_amount'] == ''){
                            $("#savePageButton").attr("disabled", true);
                        } else {
                            $("#savePageButton").attr("disabled", false);
                        }

                        if(start_date.val() == null || start_date.val() == ''){
                            add_product.prop("disabled", true);
                        } else {
                            add_product.prop("disabled", false);
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
                    url:"{{route('packetDiscountDetails.cart', \Auth::user()->id)}}",
                    type: "GET"
                        
                },
                columns: [
                    { 
                        data: 'DT_RowIndex',
                        name: 'DT_Row_Index', 
                        "className": "text-center" ,
                        searchable: false   
                    },
                    {
                        data: 'inventory_code'      
                    },
                    {
                        data: 'inventory_name'      
                    },        
                    {
                        data: 'qty'      
                    },     
                    {
                        data: 'unit_price'      
                    },   
                    {
                        data: 'total_amount'      
                    }, 
                    {
                        data: 'discount_percentage'      
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

            // $('#createNewCart').click(function () {
            //     $('#saveBtn').val("create-book");
            //     $('#book_id').val('');
            //     $('#bookForm').trigger("reset");
            //     $('#modelHeading').html("Create New Book");
            //     $('#ajaxModel').modal('show');
            // });

            $('body').on('click', '.editBook', function () {
                var productId = $(this).data('id');
                $.get("{{ route('packetDiscountDetails.index') }}" +'/' + productId +'/edit', function (data) {
                    $('#ajaxModel').modal('show');
                    $('#product_name').val(data.inventory_name);
                    $('#product_id').val(data.id);
                    $('#product_code').val(data.inventory_code);
                    $('#unit_price_edit').val(data.unit_price);
                    $('#amount_edit').val(data.total_amount);
                    $('#quantity').val(data.qty);
                    $('#discount_percentage_edit').val(data.discount_percentage);
                    $('#total_amount_edit').val(data.amount);
                })
            });

            $('#saveBtn').click(function (e) {
                e.preventDefault();
                // $(this).html('Save');
                if($('#qty').val() > 99999){
                    return alert('maksimum kuantitas adalah 99999');
                }
                $.ajax({
                    data: {
                        inventory_code:$('#inventory_id').val(),
                        qty:$('#qty').val(),
                        unit_price:$('#unit_price').val(),
                        total_amount:$('#amount').val(),
                        discount_percentage:$('#discount_percentage').val(),
                        amount:$('#total_amount').val(),
                        user_id:"{{ Auth::user()->id }}",
                    },
                    url: "{{ route('packetDiscountDetails.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (response) {
                        console.log(response);
                        $('#data_show').hide();
                        qty.val('');
                        amount.val('');
                        discount_percentage.val('');
                        total_amount.val('');
                        $('#modalProduct').modal('hide');
                        table.draw();
                        getAllCounter();
                    },
                    error: function (response) {
                        console.log(response);
                        alert('Produk sudah ada dalam list');
                    }
                });
            });

            $('#updateBtn').click(function (e) {
                e.preventDefault();
                // $(this).html('Save');
                if($('#quantity').val() > 99999){
                    return alert('maksimum kuantitas adalah 99999');
                }
                $.ajax({
                    data: {
                        qty:$('#quantity').val(),
                        unit_price:$('#unit_price_edit').val(),
                        total_amount:$('#amount_edit').val(),
                        discount_percentage:$('#discount_percentage_edit').val(),
                        amount:$('#total_amount_edit').val()
                        },
                    url: "{{ route('packetDiscountDetails.index') }}" +'/' + $('#product_id').val(),
                    type: "PATCH",
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        $('#ajaxModel').modal('hide');
                        table.draw();
                        getAllCounter();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        alert('Error Updating data!');
                    }
                });
            });
            
            $('body').on('click', '.deleteBook', function () {
            
                var product_id = $(this).data("id");

                if (confirm("Are You sure want to delete ?") == true) {
                    
                    $.ajax({
                        type: "delete",
                        url: "{{ route('packetDiscountDetails.store') }}"+'/'+product_id,
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