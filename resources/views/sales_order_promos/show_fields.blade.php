<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> b1f0485 (update feature packet discount)
<div class="col-md-6">
    <div class="row">
        <!-- Order Nbr Field -->
        <div class="col-sm-12 mb-1">
            <div class="row">
                <div class="col-3">
                    {!! Form::label('order_nbr', trans('sales_order.order_nbr')) !!}
                </div>
                <div class="col-8">
                    {!! Form::text('order_nbr', $salesOrderPromo->order_nbr, ['class' => 'form-control', 'readonly' => true]) !!}
                </div>
            </div>
        </div>
        <!-- Order Type Field -->
        <div class="col-sm-12 mb-1">
            <div class="row">
                <div class="col-3">
                    {!! Form::label('order_type', trans('sales_order.order_type')) !!}
                </div>
                <div class="col-8">
                    {!! Form::text('order_type', $salesOrderPromo->order_type == 'P' ? "Packet Discount" : "", ['class' => 'form-control', 'readonly' => true]) !!}
                </div>
            </div>
        </div>
        <!-- Customer Id Field -->
        <div class="col-sm-12 mb-1">
            <div class="row">
                <div class="col-3">
                    {!! Form::label('customer_id', trans('sales_order.customer')) !!}
                </div>
                <div class="col-8">
                    <select name="customer_id" id="customer_id" class="form-control" readonly>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->BAccountID }}">{{ $customer->AcctName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <!-- Order Date Field -->
        <div class="col-sm-12 mb-1">
            <div class="row">
                <div class="col-3">
                    {!! Form::label('order_date', trans('sales_order.order_date')) !!}
                </div>
                <div class="col-8">
                    {!! Form::date('order_date', $salesOrderPromo->order_date, ['class' => 'form-control','id'=>'order_date', 'readonly' => true, 'min' => date('Y-m-d')]) !!}
                </div>
            </div>
        </div>
        <!-- Delivery Date Field -->
        <div class="col-sm-12 mb-1">
            <div class="row">
                <div class="col-3">
                    {!! Form::label('delivery_date', trans('sales_order.delivery_date')) !!}
                </div>
                <div class="col-8">
                    {!! Form::date('delivery_date', $salesOrderPromo->delivery_date, ['class' => 'form-control','id'=>'delivery_date', 'readonly' => true, 'min' => date('Y-m-d')]) !!}
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
</div>

<div class="col-md-6">
    <div class="row">
        <!-- Order Qty Field -->
        <div class="col-sm-12 mb-1">
            <div class="row">
                <div class="col-3">
                    {!! Form::label('order_qty', trans('sales_order.order_qty')) !!}
                </div>
                <div class="col-8">
                    {!! Form::text('order_qty', number_format($salesOrderPromo->order_qty, 0, ',', '.'), ['class' => 'form-control money', 'readonly' => true ]) !!}
                </div>
            </div>
        </div>
        <!-- Order Amount Field -->
        <div class="col-sm-12 mb-1" @can('hide price sales order') style="visibility: collapse" @endcan>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('order_amount', trans('sales_order.order_amount')) !!}
                </div>
                <div class="col-8">
                    {!! Form::text('order_amount', number_format($salesOrderPromo->order_amount, 2, ',', '.'), ['class' => 'form-control money', 'readonly' => true]) !!}
                </div>
            </div>
        </div>
        <!-- Tax Field -->
        <div class="col-sm-12 mb-1" @can('hide price sales order') style="visibility: collapse" @endcan>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('tax', trans('sales_order.tax')) !!}
                </div>
                <div class="col-8">
                    {!! Form::text('tax', number_format($salesOrderPromo->tax, 2, ',', '.'), ['class' => 'form-control money', 'readonly' => true]) !!}
                </div>
            </div>
        </div>
        <!-- Order Total Field -->
        <div class="col-sm-12 mb-1"  @can('hide price sales order') style="visibility: collapse" @endcan>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('order_total', trans('sales_order.order_total')) !!}
                </div>
                <div class="col-8">
                    {!! Form::text('order_total', number_format($salesOrderPromo->order_total, 2, ',', '.'), ['class' => 'form-control money', 'readonly' => true]) !!}
                </div>
            </div>
        </div>
    </div>
=======
<!-- Order Nbr Field -->
<div class="col-sm-12">
    {!! Form::label('order_nbr', 'Order Nbr:') !!}
    <p>{{ $salesOrderPromo->order_nbr }}</p>
</div>

<!-- Customer Id Field -->
<div class="col-sm-12">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    <p>{{ $salesOrderPromo->customer_id }}</p>
</div>

<!-- Order Date Field -->
<div class="col-sm-12">
    {!! Form::label('order_date', 'Order Date:') !!}
    <p>{{ $salesOrderPromo->order_date }}</p>
</div>

<!-- Delivery Date Field -->
<div class="col-sm-12">
    {!! Form::label('delivery_date', 'Delivery Date:') !!}
    <p>{{ $salesOrderPromo->delivery_date }}</p>
</div>

<!-- Order Qty Field -->
<div class="col-sm-12">
    {!! Form::label('order_qty', 'Order Qty:') !!}
    <p>{{ $salesOrderPromo->order_qty }}</p>
</div>

<!-- Order Amount Field -->
<div class="col-sm-12">
    {!! Form::label('order_amount', 'Order Amount:') !!}
    <p>{{ $salesOrderPromo->order_amount }}</p>
</div>

<!-- Tax Field -->
<div class="col-sm-12">
    {!! Form::label('tax', 'Tax:') !!}
    <p>{{ $salesOrderPromo->tax }}</p>
</div>

<!-- Order Total Field -->
<div class="col-sm-12">
    {!! Form::label('order_total', 'Order Total:') !!}
    <p>{{ $salesOrderPromo->order_total }}</p>
>>>>>>> 7af42b6 (update packet discount module)
=======
</div>

<div class="col-md-6">
    <div class="row">
        <!-- Order Qty Field -->
        <div class="col-sm-12 mb-1">
            <div class="row">
                <div class="col-3">
                    {!! Form::label('order_qty', trans('sales_order.order_qty')) !!}
                </div>
                <div class="col-8">
                    {!! Form::text('order_qty', number_format($salesOrderPromo->order_qty, 0, ',', '.'), ['class' => 'form-control money', 'readonly' => true ]) !!}
                </div>
            </div>
        </div>
        <!-- Order Amount Field -->
        <div class="col-sm-12 mb-1" @can('hide price sales order') style="visibility: collapse" @endcan>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('order_amount', trans('sales_order.order_amount')) !!}
                </div>
                <div class="col-8">
                    {!! Form::text('order_amount', number_format($salesOrderPromo->order_amount, 2, ',', '.'), ['class' => 'form-control money', 'readonly' => true]) !!}
                </div>
            </div>
        </div>
        <!-- Tax Field -->
        <div class="col-sm-12 mb-1" @can('hide price sales order') style="visibility: collapse" @endcan>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('tax', trans('sales_order.tax')) !!}
                </div>
                <div class="col-8">
                    {!! Form::text('tax', number_format($salesOrderPromo->tax, 2, ',', '.'), ['class' => 'form-control money', 'readonly' => true]) !!}
                </div>
            </div>
        </div>
        <!-- Order Total Field -->
        <div class="col-sm-12 mb-1"  @can('hide price sales order') style="visibility: collapse" @endcan>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('order_total', trans('sales_order.order_total')) !!}
                </div>
                <div class="col-8">
                    {!! Form::text('order_total', number_format($salesOrderPromo->order_total, 2, ',', '.'), ['class' => 'form-control money', 'readonly' => true]) !!}
                </div>
            </div>
        </div>
    </div>
>>>>>>> b1f0485 (update feature packet discount)
</div>

<!-- Description Field -->
<div class="col-sm-12">
<<<<<<< HEAD
<<<<<<< HEAD
    {!! Form::label('description', trans('sales_order.description')) !!}
    {!! Form::textarea('description', $salesOrderPromo->description, ['class' => 'form-control', 'rows' => 2, 'readonly' => true ]) !!}
</div>
=======
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $salesOrderPromo->description }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $salesOrderPromo->status }}</p>
</div>

<!-- Created By Field -->
<div class="col-sm-12">
    {!! Form::label('created_by', 'Created By:') !!}
    <p>{{ $salesOrderPromo->created_by }}</p>
</div>

<!-- Updapted By Field -->
<div class="col-sm-12">
    {!! Form::label('updapted_by', 'Updapted By:') !!}
    <p>{{ $salesOrderPromo->updapted_by }}</p>
</div>

<!-- Canceled By Field -->
<div class="col-sm-12">
    {!! Form::label('canceled_by', 'Canceled By:') !!}
    <p>{{ $salesOrderPromo->canceled_by }}</p>
</div>

<!-- Canceled At Field -->
<div class="col-sm-12">
    {!! Form::label('canceled_at', 'Canceled At:') !!}
    <p>{{ $salesOrderPromo->canceled_at }}</p>
</div>

<!-- Submitted By Field -->
<div class="col-sm-12">
    {!! Form::label('submitted_by', 'Submitted By:') !!}
    <p>{{ $salesOrderPromo->submitted_by }}</p>
</div>

<!-- Submitted At Field -->
<div class="col-sm-12">
    {!! Form::label('submitted_at', 'Submitted At:') !!}
    <p>{{ $salesOrderPromo->submitted_at }}</p>
</div>

<!-- Rejected By Field -->
<div class="col-sm-12">
    {!! Form::label('rejected_by', 'Rejected By:') !!}
    <p>{{ $salesOrderPromo->rejected_by }}</p>
</div>

<!-- Rejected At Field -->
<div class="col-sm-12">
    {!! Form::label('rejected_at', 'Rejected At:') !!}
    <p>{{ $salesOrderPromo->rejected_at }}</p>
</div>

<!-- Rejected Reason Field -->
<div class="col-sm-12">
    {!! Form::label('rejected_reason', 'Rejected Reason:') !!}
    <p>{{ $salesOrderPromo->rejected_reason }}</p>
</div>

<!-- Processed By Field -->
<div class="col-sm-12">
    {!! Form::label('processed_by', 'Processed By:') !!}
    <p>{{ $salesOrderPromo->processed_by }}</p>
</div>

<!-- Processed At Field -->
<div class="col-sm-12">
    {!! Form::label('processed_at', 'Processed At:') !!}
    <p>{{ $salesOrderPromo->processed_at }}</p>
</div>

<!-- Order Type Field -->
<div class="col-sm-12">
    {!! Form::label('order_type', 'Order Type:') !!}
    <p>{{ $salesOrderPromo->order_type }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $salesOrderPromo->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $salesOrderPromo->updated_at }}</p>
</div>

>>>>>>> 7af42b6 (update packet discount module)
=======
    {!! Form::label('description', trans('sales_order.description')) !!}
    {!! Form::textarea('description', $salesOrderPromo->description, ['class' => 'form-control', 'rows' => 2, 'readonly' => true ]) !!}
</div>
>>>>>>> b1f0485 (update feature packet discount)
