@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>{{ trans('bundling_product.edit') }} {{ trans('bundling_product.title') }}</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($bundlingProduct, ['route' => ['bundlingProducts.update', $bundlingProduct->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('bundling_products.fields')

                    <div class="col-md-12">
                        <div class="card card-body">
                            <h5>{{ trans('bundling_product.free_item') }}</h5>
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
                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ trans('bundling_product.free_item') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                {{-- Product --}}
                                                <div class="col-sm-12 mb-1">
                                                    <div class="row">
                                                        <div class="col-3">Product</div>
                                                        <div class="col-9" style="">
                                                            <select name="inventory_id" id="inventory_id" class="form-control select2js">
                                                                <option value="">Please Choose</option>
                                                                @foreach ($products as $product)
                                                                    <option value="{{ $product->InventoryCD }}">{{ $product->Descr }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-1">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            {!! Form::label('qty', trans('sales_order.qty')) !!}
                                                        </div>
                                                        <div class="col-5">
                                                            <input pattern="\d*" type="number" class="form-control" name="qty" id="qty" step="1" onKeyPress="if(this.value.length==4) return false;" onkeydown="if(event.key==='.'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');">
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
                                 
                                                <label class="col-sm-4 control-label">{{ trans('sales_order.qty') }}</label>
                                                <div class="col-sm-12">
                                                    <input pattern="\d*" type="number" class="form-control" name="quantity" id="quantity" step="1" onKeyPress="if(this.value.length==4) return false;" onkeydown="if(event.key==='.'){event.preventDefault();}"  oninput="event.target.value = event.target.value.replace(/[^0-9]*/g,'');">
                                                </div>
                                  
                                                <div class="col-md-12 text-right">
                                                 <button type="submit" class="btn btn-primary updateBtn" id="updateBtn">{{ trans('sales_order.btn_update') }}</button>
                                                </div>
                                            {{-- </form> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @include('bundling_product_frees.table')
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit(trans('bundling_product.save'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('bundlingProducts.index') }}" class="btn btn-default">{{ trans('bundling_product.cancel') }}</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function() {
            var inventory_id =  $("select#inventory_id");
            var packet_code =  $("#packet_code");
            var qty =  $("#qty");
            var start_date =  $("#start_date");
            var end_date =  $("#end_date");
            var add_product =  $("#add_product");
            var save =  $("#saveBtn");
            // $("#savePageButton").prop("disabled", true);

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
                    url:"{{route('bundlingProductFrees.detailData', $bundlingProduct->id)}}",
                    type: "GET"
                        
                },
                columns: [
                    {
                        data: 'product'      
                    },     
                    {
                        data: 'qty'      
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
                $.get("{{ route('bundlingProductFrees.index') }}" +'/' + productId +'/edit', function (data) {
                    $('#ajaxModel').modal('show');
                    $('#product_name').val(data.product_name);
                    $('#product_id').val(data.id);
                    $('#product_code').val(data.product_code);
                    $('#quantity').val(data.qty);
                })
            });

            $('#saveBtn').click(function (e) {
                e.preventDefault();
                // console.log('test');
                // $(this).html('Save');
                if($('#qty').val() > 9999){
                    return alert('maksimum kuantitas adalah 9999');
                }
                $.ajax({
                    data: {
                        bundling_product_id:"{{ $bundlingProduct->id }}",
                        product_code:$('#inventory_id').val(),
                        qty:$('#qty').val(),
                        user_id:"{{ Auth::user()->id }}",
                    },
                    url: "{{ route('bundlingProductFrees.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (response) {
                        console.log(response);
                        $('#data_show').hide();
                        qty.val('');
                        $('#modalProduct').modal('hide');
                        table.draw();
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
                if($('#quantity').val() > 9999){
                    return alert('maksimum kuantitas adalah 9999');
                }
                $.ajax({
                    data: {
                        qty:$('#quantity').val(),
                        },
                    url: "{{ route('bundlingProductFrees.index') }}" +'/' + $('#product_id').val(),
                    type: "PATCH",
                    dataType: 'json',
                    success: function (data) {
                        // console.log(data);
                        $('#ajaxModel').modal('hide');
                        table.draw();
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
                        url: "{{ route('bundlingProductFrees.store') }}"+'/'+product_id,
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
@endsection