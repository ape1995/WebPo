<div class="table-responsive">
    <table class="table table-hover table-bordered table-sm" id="bundlingGimmicks-table">
        <thead>
        <tr class="bg-info">
            <th>{{ trans('packet_gimmick.start_date') }}</th>
            <th>{{ trans('packet_gimmick.end_date') }}</th>
            <th>{{ trans('packet_gimmick.package_type') }}</th>
            <th>{{ trans('packet_gimmick.nominal') }}</th>
            <th>{{ trans('packet_gimmick.free_qty') }}</th>
            <th>{{ trans('packet_gimmick.free_descr') }}</th>
            <th>{{ trans('packet_gimmick.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($bundlingGimmicks as $bundlingGimmick)
            <tr>
                <td>{{ $bundlingGimmick->start_date->format('Y-m-d') }}</td>
                <td>{{ $bundlingGimmick->end_date == null ? '' : $bundlingGimmick->end_date->format('Y-m-d') }}</td>
                <td>{{ $bundlingGimmick->package_type }}</td>
                <td>Rp. {{ number_format($bundlingGimmick->nominal,0,',','.') }}</td>
                <td>{{ $bundlingGimmick->free_qty }} Pcs</td>
                <td>{{ $bundlingGimmick->free_descr }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['bundlingGimmicks.destroy', $bundlingGimmick->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @if ($bundlingGimmick->id == $maxId)
                            @can('edit bundling gimmicks')
                                <a href="{{ route('bundlingGimmicks.edit', [$bundlingGimmick->id]) }}"
                                class='btn btn-default btn-xs'>
                                    <i class="far fa-edit"></i>
                                </a>
                            @endcan
                            @can('delete bundling gimmicks')
                                {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                            @endcan
                        @endif
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
        $('#bundlingGimmicks-table').DataTable({
            "order": [[0, 'desc']],
        });
    });
    </script>
@endpush