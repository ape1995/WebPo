<div class="table-responsive">
    <table class="table table-hover table-sm" id="roles-table">
        <thead>
            <tr class="bg-info">
                <th>{{ trans('group.name') }}</th>
                <th>Status</th>
                <th width="20%">{{ trans('group.action') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>{{ $role->status == true ? "Active" : "Inactive" }}</td>
                <td>
                    {!! Form::open(['route' => ['roles.destroy', $role->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @can('view group permissions')
                            <a href="{{ route('roles.show', [$role->id]) }}" class='btn btn-outline-dark btn-xs' title="View"><i class="fa fa-eye"></i></a>
                        @endcan
                        @can('edit group permissions')
                            <a href="{{ route('roles.edit', [$role->id]) }}" class='btn btn-outline-dark btn-xs' title="Edit"><i class="fa fa-edit"></i></a>
                        @endcan
                        @if ($role->status == true)
                            @can('inactive group permissions')
                                <a href="{{ route('roles.inactive', [$role->id]) }}" class='btn btn-outline-danger btn-xs' title='Inactive' onclick="return confirm('are you sure to Inactive?')"><i class="fa fa-ban"></i></a>
                            @endcan
                        @endif
                        @if ($role->status == false)
                            @can('active group permissions')
                                <a href="{{ route('roles.active', [$role->id]) }}" class='btn btn-outline-success btn-xs' title='Active' onclick="return confirm('are you sure to active?')"><i class="fa fa-check-circle"></i></a>
                            @endcan
                        @endif
                        {{-- @can('delete group permissions')
                            {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        @endcan --}}
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
                { orderable: false, targets: 2 }
            ],
        });
    });
    </script>
@endpush

