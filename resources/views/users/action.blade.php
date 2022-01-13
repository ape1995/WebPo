{!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        @can('view users')
            <a href="{{ route('users.show', [$user->id]) }}" class='btn btn-outline-dark btn-xs'><i class="fa fa-eye"></i></a>
        @endcan
        @can('edit users')
            <a href="{{ route('users.edit', [$user->id]) }}" class='btn btn-outline-dark btn-xs'><i class="fa fa-edit"></i></a>
        @endcan
        @can('delete users')
            {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
        @endcan
    </div>
{!! Form::close() !!}