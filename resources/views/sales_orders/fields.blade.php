<div class="col-md-6">
    <div class="row">
        <!-- Order Nbr Field -->
        <div class="col-sm-12 mb-1">
            <div class="row">
                <div class="col-3">
                    {!! Form::label('order_nbr', trans('sales_order.order_nbr')) !!}
                </div>
                <div class="col-8">
                    {!! Form::text('order_nbr', 'AUTOGENERATE', ['class' => 'form-control', 'readonly' => true]) !!}
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
                    @if ($data = Session::get('data'))
                        <select name="order_type" id="order_type" class="form-control select2js" required>
                            <option value="">- Choose -</option>
                            <option value="R" {{ $data['order_type'] == 'R' ? 'selected' : '' }}>REGULAR</option>
                            <option value="G" {{ $data['order_type'] == 'G' ? 'selected' : '' }}>BUNDLING GIMMICK</option>
                            <option value="P" {{ $data['order_type'] == 'P' ? 'selected' : '' }}>BUNDLING PRODUCT</option>
                            <option value="C" {{ $data['order_type'] == 'C' ? 'selected' : '' }}>BUNDLING DISCOUNT</option>
                        </select>
                    @else
                        <select name="order_type" id="order_type" class="form-control select2js" required>
                            <option value="">- Choose -</option>
                            <option value="R">REGULAR</option>
                            <option value="G">BUNDLING GIMMICK</option>
                            <option value="P">BUNDLING PRODUCT</option>
                            <option value="C">BUNDLING DISCOUNT</option>
                        </select>
                    @endif
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
                    <select name="customer_id" id="customer_id" class="form-control select2js" required>
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
                    {!! Form::date('order_date', now(), ['class' => 'form-control','id'=>'order_date', 'readonly' => true, 'min' => date('Y-m-d')]) !!}
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
                    {!! Form::date('delivery_date', null, ['class' => 'form-control','id'=>'delivery_date', 'required' => true, 'min' =>  $minDeliveryDate]) !!}
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
                    {!! Form::text('order_qty', null, ['class' => 'form-control money', 'readonly' => true ]) !!}
                </div>
            </div>
        </div>
        <!-- Order Amount Field -->
        <div class="col-sm-12 mb-1" @can('hide price sales order') style=" visibility: collapse;" @endcan>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('order_amount', trans('sales_order.order_amount')) !!}
                </div>
                <div class="col-8">
                    {!! Form::text('order_amount', null, ['class' => 'form-control money', 'readonly' => true]) !!}
                </div>
            </div>
        </div>
        <!-- Discount Field -->
        <div class="col-sm-12 mb-1" @can('hide price sales order') style=" visibility: collapse;" @endcan>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('discount', trans('sales_order.discount')) !!}
                </div>
                <div class="col-8">
                    {!! Form::text('discount', null, ['class' => 'form-control money', 'readonly' => true]) !!}
                </div>
            </div>
        </div>
        <!-- Tax Field -->
        <div class="col-sm-12 mb-1" @can('hide price sales order') style=" visibility: collapse;" @endcan>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('tax', trans('sales_order.tax')) !!}
                </div>
                <div class="col-8">
                    {!! Form::text('tax', null, ['class' => 'form-control money', 'readonly' => true]) !!}
                </div>
            </div>
        </div>
        <!-- Order Total Field -->
        <div class="col-sm-12 mb-1" @can('hide price sales order') style=" visibility: collapse;" @endcan>
            <div class="row">
                <div class="col-3">
                    {!! Form::label('order_total', trans('sales_order.order_total')) !!}
                </div>
                <div class="col-8">
                    {!! Form::text('order_total', null, ['class' => 'form-control money', 'readonly' => true]) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', trans('sales_order.description')) !!}
    @if ($data = Session::get('data'))
        {!! Form::textarea('description', $data['description'], ['class' => 'form-control', 'rows' => 2, 'required' => true ]) !!}
    @else     
        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 2, 'required' => true ]) !!}
    @endif
</div>