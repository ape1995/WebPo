<<<<<<< HEAD
<div class="table-responsive mt-3">
    <table class="table table-sm table-bordered" id="salesOrderDetails-table">
        <thead>
        <tr>
            <th>{{ trans('sales_order_promo.packet_name') }}</th>
            <th>{{ trans('sales_order.qty') }}</th>
            <th>{{ trans('sales_order.uom') }}</th>
            <th @can('hide price sales order') class="hide-component" @endcan>{{ trans('sales_order.unit_price') }}</th>
            <th @can('hide price sales order') class="hide-component" @endcan>{{ trans('sales_order.amount') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($salesOrderDetails as $salesOrderDetail)
            <tr>
                <td>{{ $salesOrderDetail->packet->packet_name }}</td>
                <td>{{ number_format($salesOrderDetail->qty,0,',','.') }}</td>
                <td>Packet(s)</td>
                <td class="money" @can('hide price sales order') style="display:none" @endcan>{{ number_format($salesOrderDetail->unit_price,2,',','.') }}</td>
                <td class="money" @can('hide price sales order') style="display:none" @endcan>{{ number_format($salesOrderDetail->total,2,',','.') }}</td>
            </tr>
        @endforeach
=======
<div class="table-responsive">
    <table class="table" id="salesOrderPromoDetails-table">
        <thead>
        <tr>
            <th>Sales Order Promo Id</th>
            <th>Packet Code</th>
            <th>Qty</th>
            <th>Unit Price</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
>>>>>>> 7af42b6 (update packet discount module)
        </tbody>
    </table>
</div>
