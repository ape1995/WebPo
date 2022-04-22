<div class="table-responsive">
    <table class="table table-hover table-sm" id="permissions-table">
        <thead>
            <tr class="bg-info">
                <th>{{ trans('group.name') }}</th>
                <th width="20%">{{ trans('group.action') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($permissions as $permission)
            <tr>
                <td>{{ $permission->name }}</td>
                <td>
                    {!! Form::open(['route' => ['permissions.destroy', $permission->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @can('delete permissions')
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
        $('#permissions-table').DataTable({
            columnDefs: [
                { orderable: false, targets: 1 }
            ],
        });
    });
    </script>
@endpush

