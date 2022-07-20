<div class="table-responsive">
    <table class="table table-bordered table-sm" id="dataTable">
        <thead>
        <tr>
            <th>{{ trans('sales_order.no') }}</th>
            {{-- <th>{{ trans('sales_order.product_code') }}</th> --}}
            <th>{{ trans('sales_order.product_name') }}</th>
            <th>{{ trans('sales_order.qty') }}</th>
            <th>{{ trans('sales_order.uom') }}</th>
            <th @can('hide price sales order') class="hide-component" @endcan>{{ trans('sales_order.unit_price') }}</th>
            <th @can('hide price sales order') class="hide-component" @endcan>{{ trans('sales_order.discount') }}</th>
            <th @can('hide price sales order') class="hide-component" @endcan>{{ trans('sales_order.amount') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>