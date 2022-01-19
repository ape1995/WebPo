{!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
    <div class='btn-group'>
        @can('view users')
            <a href="{{ route('users.show', [$user->id]) }}" class='btn btn-outline-dark btn-xs'><i class="fa fa-eye"></i></a>
        @endcan
        @can('edit users')
            <a href="{{ route('users.edit', [$user->id]) }}" class='btn btn-outline-dark btn-xs'><i class="fa fa-edit"></i></a>
        @endcan
        @if ($user->status == 1)
            @can('inactive users')
                <a href="{{ route('users.inactive', [$user->id]) }}" class='btn btn-outline-danger btn-xs' title='Inactive' onclick="return confirm('are you sure?')"><i class="fa fa-ban"></i></a>
            @endcan
        @endif
        @if ($user->status == 0)
            @can('active users')
                <a href="{{ route('users.active', [$user->id]) }}" class='btn btn-outline-success btn-xs' title='Active' onclick="return confirm('are you sure?')"><i class="fa fa-check-circle"></i></a>
            @endcan
        @endif
        {{-- @can('delete users')
            {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
        @endcan --}}
    </div>
{!! Form::close() !!}