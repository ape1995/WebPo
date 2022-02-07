{!! Form::open(['route' => 'estimasi.store']) !!}
    <div class="d-flex justify-content-start">
        <input type="hidden" name="inventory_id" id="inventory_id_{{$estimasi->id}}" value="{{ $estimasi->InventoryID }}">
        <input type="hidden" name="sales_order_no" id="sales_order_no" value="{{ $estimasi->OrderNbr }}">
        <input type="hidden" name="order_qty" id="order_qty" value="{{ number_format($estimasi->OrderQty, 0) }}">
        <input type="number" name="adjustment" id="adjustment" onkeyup="myFunction(this.value)" class="form-control col-md-5" required>
        <input type="text" name="after_adjustment" id="after_adjustment" class="form-control col-md-5" placeholder="After Adjustment" readonly>
    </div>
    <script>
        function myFunction(val) {
            
            document.getElementById("after_adjustment").value = parseInt(<?php echo $estimasi->OrderQty?>) + parseInt(val);
            
        }
    </script>
{!! Form::close() !!}