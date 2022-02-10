{!! Form::open(['route' => 'estimasi.store']) !!}
    @php
        $order_number = str_replace("/","",$estimasi->OrderNbr);
        $sort = $order_number.$estimasi->InventoryID;
    @endphp
    <div class="row">
        <input type="hidden" name="inventory_id" id="inventory_id_{{ $sort }}" value="{{ $estimasi->InventoryID }}">
        <input type="hidden" name="sales_order_no" id="sales_order_no_{{ $sort }}" value="{{ $estimasi->OrderNbr }}">
        <input type="hidden" name="order_qty" id="order_qty_{{ $sort }}" value="{{ number_format($estimasi->OrderQty, 0) }}">
        <input type="number" name="adjustment" id="adjustment_{{ $sort }}" class="form-control col-md-4 m-1" value="{{ $estimasi->AdjQty == null ? '' : number_format($estimasi->AdjQty, 0) }}" required>
        <input type="text" name="after_adjustment" id="after_adjustment_{{ $sort }}" class="form-control col-md-4 m-1" value="{{ $estimasi->FinalQty == null ? '' : number_format($estimasi->FinalQty, 0) }}" placeholder="After Adjustment" readonly>
    </div>
    <script type="text/javascript">
        var sort = "<?php echo $sort; ?>";
        
        $( "#adjustment_"+sort ).change(function() {
            $('#after_adjustment_'+"<?php echo $sort; ?>").val(parseInt($('#order_qty_'+"<?php echo $sort; ?>").val()) + parseInt($('#adjustment_'+"<?php echo $sort; ?>").val()));
            data = {
                sales_order_no:$('#sales_order_no_'+"{{ $sort }}").val(),
                inventory_id:$('#inventory_id_'+"{{ $sort }}").val(),
                adjustment:$('#adjustment_'+"{{ $sort }}").val(),
                after_adjustment:$('#after_adjustment_'+"{{ $sort }}").val(),
            }
            // console.log(data);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('estimasi.updateData') }}",
                type: "POST",
                data: data,
                dataType: 'JSON',
                success:function(data)
                {
                    console.log(data)
                    // $('#message_'+i).css('display', 'block');
                    // $('#message_'+i).html(data.success);
                }
            });
        });



    </script>
{!! Form::close() !!}