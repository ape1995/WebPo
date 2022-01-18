<div class="table-responsive">
    <table class="table table-hover table-sm" id="roles-table">
        <thead>
            <tr>
                <th>{{ trans('group.name') }}</th>
                <th width="20%">{{ trans('group.action') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>
                    {!! Form::open(['route' => ['roles.destroy', $role->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @can('view group permissions')
                            <a href="{{ route('roles.show', [$role->id]) }}" class='btn btn-outline-dark btn-xs'><i class="fa fa-eye"></i></a>
                        @endcan
                        @can('edit group permissions')
                            <a href="{{ route('roles.edit', [$role->id]) }}" class='btn btn-outline-dark btn-xs'><i class="fa fa-edit"></i></a>
                        @endcan
                        @can('delete group permissions')
                            {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        @endcan
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@push('page_scripts')
    <script>
    $(document).ready(function() {
        $('#roles-table').DataTable({
            columnDefs: [
                { orderable: false, targets: 1 }
            ],
        });
    });
    </script>
@endpush

