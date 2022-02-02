<div class="table-responsive">
    <table class="table table-hover table-sm" id="dataTable">
        <thead>
        <tr>
            <th></th>
            <th>{{ trans('sales_order.order_type') }}</th>
            <th>{{ trans('sales_order.order_nbr') }}</th>
            <th>{{ trans('sales_order.customer') }}</th>
            <th>{{ trans('sales_order.order_date') }}</th>
            <th>{{ trans('sales_order.delivery_date') }}</th>
            <th>{{ trans('sales_order.qty') }}</th>
            <th @can('hide price sales order') class="hide-component text-nowrap" @endcan>{{ trans('sales_order.order_amount') }}</th>
            <th @can('hide price sales order') class="hide-component text-nowrap" @endcan>{{ trans('sales_order.tax') }}</th>
            <th>{{ trans('sales_order.order_total') }}</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach ($salesOrders as $index => $salesOrder)
                <tr>
                    @php
                        if ($salesOrder->status == 'S') {
                            $status = 'Draft';
                        } else if($salesOrder->status == 'R') {
                            $status = 'Submitted';
                        } else if($salesOrder->status == 'P') {
                            $status = 'Processed';
                        } else if($salesOrder->status == 'B') {
                            $status = 'Rejected';
                        } else {
                            $status = 'Canceled';
                        }
                    @endphp
                    <td>{{ $index+1 }}</td>
                    <td>{{ $salesOrder->order_type == 'R' ? 'Regular' : 'Direct Selling' }}</td>
                    <td>{{ $salesOrder->order_nbr }}</td>
                    <td>{{ $salesOrder->customer->AcctName }}</td>
                    <td>{{ $salesOrder->order_date->format('d M Y') }}</td>
                    <td>{{ $salesOrder->delivery_date->format('d M Y') }}</td>
                    <td>{{ $salesOrder->order_qty }}</td>
                    <td>{{ number_format($salesOrder->order_amount,2,',','.') }}</td>
                    <td>{{ number_format($salesOrder->tax,2,',','.') }}</td>
                    <td>{{ number_format($salesOrder->order_total,2,',','.') }}</td>
                    <td>{{ $status }}</td>
                    <td>@include('sales_orders.action')</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
