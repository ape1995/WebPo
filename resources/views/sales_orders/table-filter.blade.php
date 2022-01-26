<div class="table-responsive">
    <table class="table table-hover" id="dataTable">
        <thead>
        <tr>
            <th class="text-nowrap"></th>
            <th class="text-nowrap">{{ trans('sales_order.order_type') }}</th>
            <th class="text-nowrap">{{ trans('sales_order.order_nbr') }}</th>
            <th class="text-nowrap">{{ trans('sales_order.customer') }}</th>
            <th class="text-nowrap">{{ trans('sales_order.order_date') }}</th>
            <th class="text-nowrap">{{ trans('sales_order.delivery_date') }}</th>
            <th class="text-nowrap">{{ trans('sales_order.qty') }}</th>
            <th @can('hide price sales order') class="hide-component text-nowrap" @endcan>{{ trans('sales_order.order_amount') }}</th>
            <th @can('hide price sales order') class="hide-component text-nowrap" @endcan>{{ trans('sales_order.tax') }}</th>
            <th class="text-nowrap">{{ trans('sales_order.order_total') }}</th>
            <th class="text-nowrap">Status</th>
            <th class="text-nowrap"></th>
        </tr>
        </thead>
        <tbody>
            @foreach ($salesOrders as $index => $salesOrder)
                <tr>
                    <td class="text-nowrap">{{ $index+1 }}</td>
                    <td class="text-nowrap">{{ $salesOrder->order_type == 'R' ? 'Regular' : 'Direct Selling' }}</td>
                    <td class="text-nowrap">{{ $salesOrder->order_nbr }}</td>
                    <td class="text-nowrap">{{ $salesOrder->customer->AcctName }}</td>
                    <td class="text-nowrap">{{ $salesOrder->order_date->format('d M Y') }}</td>
                    <td class="text-nowrap">{{ $salesOrder->delivery_date->format('d M Y') }}</td>
                    <td class="text-nowrap">{{ $salesOrder->order_qty }}</td>
                    <td class="text-nowrap">{{ number_format($salesOrder->order_amount,2,',','.') }}</td>
                    <td class="text-nowrap">{{ number_format($salesOrder->tax,2,',','.') }}</td>
                    <td class="text-nowrap">{{ number_format($salesOrder->order_total,2,',','.') }}</td>
                    <td class="text-nowrap">@include('sales_orders.action')</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
