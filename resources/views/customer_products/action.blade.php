{!! Form::open(['route' => ['customerProducts.destroy', $customerProduct->id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        @can('delete customer products')
        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
        @endcan
    </div>
{!! Form::close() !!}