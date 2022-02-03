<div class="table-responsive mt-3">
    <table class="table table-sm table-bordered" id="salesOrderDetails-table">
        <thead>
        <tr>
            <th>{{ trans('sales_order.product_name') }}</th>
            <th>{{ trans('sales_order.qty') }}</th>
            <th>{{ trans('sales_order.uom') }}</th>
            <th @can('hide price sales order') class="hide-component" @endcan>{{ trans('sales_order.unit_price') }}</th>
            <th @can('hide price sales order') class="hide-component" @endcan>{{ trans('sales_order.amount') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($salesOrderDetails as $salesOrderDetail)
            <tr>
                <td>{{ $salesOrderDetail->inventory_name }}</td>
                <td>{{ number_format($salesOrderDetail->qty,0,',','.') }}</td>
                <td>{{ $salesOrderDetail->uom }}</td>
                <td class="money" @can('hide price sales order') style="display:none" @endcan>{{ number_format($salesOrderDetail->unit_price,2,',','.') }}</td>
                <td class="money" @can('hide price sales order') style="display:none" @endcan>{{ number_format($salesOrderDetail->amount,2,',','.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
