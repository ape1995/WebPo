<div class="table-responsive">
    <table class="table" id="dataTable">
        <thead>
        <tr>
            <th></th>
            <th>{{ trans('sales_order.order_type') }}</th>
            <th>{{ trans('sales_order.order_nbr') }}</th>
            <th>{{ trans('sales_order.customer') }}</th>
            <th>{{ trans('sales_order.order_date') }}</th>
            <th>{{ trans('sales_order.delivery_date') }}</th>
            <th>{{ trans('sales_order.qty') }}</th>
            <th @can('hide price sales order') class="hide-component" @endcan>{{ trans('sales_order.order_amount') }}</th>
            <th @can('hide price sales order') class="hide-component" @endcan>{{ trans('sales_order.tax') }}</th>
            <th @can('hide price sales order') class="hide-component" @endcan>{{ trans('sales_order.order_total') }}</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
