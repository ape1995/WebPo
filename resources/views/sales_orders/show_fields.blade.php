<div class="col-md-6">
    <div class="row">
        <!-- Order Nbr Field -->
        <div class="col-sm-12 mb-1">
            <div class="row">
                <div class="col-3">
                    {!! Form::label('order_nbr', trans('sales_order.order_nbr')) !!}
                </div>
                <div class="col-8">
                    {!! Form::text('order_nbr', $salesOrder->order_nbr, ['class' => 'form-control', 'readonly' => true]) !!}
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
                    {!! Form::text('order_type', $salesOrder->order_type == 'R' ? "Regular" : "Direct Selling", ['class' => 'form-control', 'readonly' => true]) !!}
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
                    {!! Form::date('order_date', $salesOrder->order_date, ['class' => 'form-control','id'=>'order_date', 'readonly' => true, 'min' => date('Y-m-d')]) !!}
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
                    {!! Form::date('delivery_date', $salesOrder->delivery_date, ['class' => 'form-control','id'=>'delivery_date', 'readonly' => true, 'min' => date('Y-m-d')]) !!}
                </div>
            </div>
        </div>
    </div>
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
                    {!! Form::text('order_qty', number_format($salesOrder->order_qty, 0, ',', '.'), ['class' => 'form-control money', 'readonly' => true ]) !!}
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
                    {!! Form::text('order_amount', number_format($salesOrder->order_amount, 2, ',', '.'), ['class' => 'form-control money', 'readonly' => true]) !!}
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
                    {!! Form::text('tax', number_format($salesOrder->tax, 2, ',', '.'), ['class' => 'form-control money', 'readonly' => true]) !!}
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
                    {!! Form::text('order_total', number_format($salesOrder->order_total, 2, ',', '.'), ['class' => 'form-control money', 'readonly' => true]) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', trans('sales_order.description')) !!}
    {!! Form::textarea('description', $salesOrder->description, ['class' => 'form-control', 'rows' => 2, 'readonly' => true ]) !!}
</div>