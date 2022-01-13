{!! Form::open(['route' => ['salesOrders.destroy', $salesOrder->id], 'method' => 'delete']) !!}
    <div class='btn-group'>
            <a href="{{ route('salesOrders.show', [$salesOrder->id]) }}" class='btn btn-outline-primary btn-xs text-nowrap'><i class="fa fa-eye"></i> View Detail</a>
    </div>
{!! Form::close() !!}