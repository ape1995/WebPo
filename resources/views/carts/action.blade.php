{!! Form::open(['route' => ['carts.destroy', $cart->id], 'method' => 'delete']) !!}
    <div class='btn-group'>
            {{-- <a href="{{ route('carts.edit', [$cart->id]) }}" class='btn btn-outline-dark btn-xs'><i class="fa fa-edit"></i></a> --}}
            {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
    </div>
{!! Form::close() !!}