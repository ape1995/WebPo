<!-- Order Nbr Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_nbr', 'Order Nbr:') !!}
    {!! Form::text('order_nbr', null, ['class' => 'form-control']) !!}
</div>

<!-- Customer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    {!! Form::text('customer_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Order Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_date', 'Order Date:') !!}
    {!! Form::text('order_date', null, ['class' => 'form-control','id'=>'order_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#order_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Delivery Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('delivery_date', 'Delivery Date:') !!}
    {!! Form::text('delivery_date', null, ['class' => 'form-control','id'=>'delivery_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#delivery_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Order Qty Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_qty', 'Order Qty:') !!}
    {!! Form::number('order_qty', null, ['class' => 'form-control']) !!}
</div>

<!-- Order Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_amount', 'Order Amount:') !!}
    {!! Form::number('order_amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Tax Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tax', 'Tax:') !!}
    {!! Form::number('tax', null, ['class' => 'form-control']) !!}
</div>

<!-- Order Total Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_total', 'Order Total:') !!}
    {!! Form::number('order_total', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::text('status', null, ['class' => 'form-control']) !!}
</div>

<!-- Created By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_by', 'Created By:') !!}
    {!! Form::number('created_by', null, ['class' => 'form-control']) !!}
</div>

<!-- Updapted By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('updapted_by', 'Updapted By:') !!}
    {!! Form::number('updapted_by', null, ['class' => 'form-control']) !!}
</div>

<!-- Canceled By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('canceled_by', 'Canceled By:') !!}
    {!! Form::number('canceled_by', null, ['class' => 'form-control']) !!}
</div>

<!-- Canceled At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('canceled_at', 'Canceled At:') !!}
    {!! Form::text('canceled_at', null, ['class' => 'form-control','id'=>'canceled_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#canceled_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Submitted By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('submitted_by', 'Submitted By:') !!}
    {!! Form::number('submitted_by', null, ['class' => 'form-control']) !!}
</div>

<!-- Submitted At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('submitted_at', 'Submitted At:') !!}
    {!! Form::text('submitted_at', null, ['class' => 'form-control','id'=>'submitted_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#submitted_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Rejected By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rejected_by', 'Rejected By:') !!}
    {!! Form::number('rejected_by', null, ['class' => 'form-control']) !!}
</div>

<!-- Rejected At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rejected_at', 'Rejected At:') !!}
    {!! Form::text('rejected_at', null, ['class' => 'form-control','id'=>'rejected_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#rejected_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Rejected Reason Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rejected_reason', 'Rejected Reason:') !!}
    {!! Form::text('rejected_reason', null, ['class' => 'form-control']) !!}
</div>

<!-- Processed By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('processed_by', 'Processed By:') !!}
    {!! Form::number('processed_by', null, ['class' => 'form-control']) !!}
</div>

<!-- Processed At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('processed_at', 'Processed At:') !!}
    {!! Form::text('processed_at', null, ['class' => 'form-control','id'=>'processed_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#processed_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Order Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_type', 'Order Type:') !!}
    {!! Form::text('order_type', null, ['class' => 'form-control']) !!}
</div>