{!! Form::open(['route' => ['salesOrderPromos.destroy', $salesOrder->id], 'method' => 'delete']) !!}
    <div class='btn-group'>
            <a href="{{ route('salesOrderPromos.show', [$salesOrder->id]) }}" class='btn btn-outline-primary btn-xs text-nowrap'><i class="fa fa-eye"></i> {{ trans('sales_order.btn_view') }}</a>
    </div>
{!! Form::close() !!}