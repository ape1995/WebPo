<div class="table-responsive">
    <table class="table table-hover table-bordered table-sm" id="bundlingGimmicks-table">
        <thead>
        <tr class="bg-info">
            <th>Start Date</th>
            <th>End Date</th>
            <th>Package Type</th>
            <th>Nominal</th>
            <th>Free Qty</th>
            <th>Free Descr</th>
            <th>Action</th>
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
                        {{-- <a href="{{ route('bundlingGimmicks.show', [$bundlingGimmick->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a> --}}
                        <a href="{{ route('bundlingGimmicks.edit', [$bundlingGimmick->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
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
            // columnDefs: [
            //     { orderable: false, targets: 4 }
            // ],
        });
    });
    </script>
@endpush