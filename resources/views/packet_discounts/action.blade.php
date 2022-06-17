{!! Form::open(['route' => ['packetDiscounts.destroy', $packetDiscount->id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        @can('view packet discounts')
            <a href="{{ route('packetDiscounts.show', [$packetDiscount->id]) }}" class='btn btn-outline-dark btn-xs' title="View"><i class="fa fa-eye"></i></a>
        @endcan
        @if ($packetDiscount->status == 'Hold')
            @can('edit packet discounts')
                <a href="{{ route('packetDiscounts.edit', [$packetDiscount->id]) }}" class='btn btn-outline-dark btn-xs' title="Edit"><i class="fa fa-edit"></i></a>
            @endcan
            @can('release packet discounts')
                <a href="{{ route('packetDiscounts.release', [$packetDiscount->id]) }}" class='btn btn-outline-success btn-xs' title='Release' onclick="return confirm('are you sure to Release?')"><i class="fa fa-check"></i></a>
            @endcan
            @can('delete packet discounts')
                {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
            @endcan
        @endif
        
    </div>
{!! Form::close() !!}