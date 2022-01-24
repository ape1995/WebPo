<div class="table-responsive mt-3">
    <table class="table table-sm" id="salesOrderDetails-table">
        <thead>
        <tr>
            <th>{{ trans('sales_order.product_code') }}</th>
            <th>{{ trans('sales_order.product_name') }}</th>
            <th>{{ trans('sales_order.qty') }}</th>
            <th>{{ trans('sales_order.uom') }}</th>
            <th @can('hide price sales order') style="visibility: collapse;" @endcan>{{ trans('sales_order.unit_price') }}</th>
            <th @can('hide price sales order') style="visibility: collapse;" @endcan>{{ trans('sales_order.amount') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($salesOrderDetails as $salesOrderDetail)
            <tr>
                <td>{{ $salesOrderDetail->inventory_id }}</td>
                <td>{{ $salesOrderDetail->inventory_name }}</td>
                <td>{{ $salesOrderDetail->qty }}</td>
                <td>{{ $salesOrderDetail->uom }}</td>
                <td class="money" @can('hide price sales order') style="visibility: collapse;" @endcan>{{ number_format($salesOrderDetail->unit_price,2,',','.') }}</td>
                <td class="money" @can('hide price sales order') style="visibility: collapse;" @endcan>{{ number_format($salesOrderDetail->amount,2,',','.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
