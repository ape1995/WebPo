<div class="table-responsive">
    <table class="table" id="parameterVATs-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Value</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($parameterVATs as $parameterVAT)
            <tr>
                <td>{{ $parameterVAT->name }}</td>
            <td>{{ $parameterVAT->value }}</td>
            <td>{{ $parameterVAT->start_date == null ? '' : $parameterVAT->start_date->format('Y-m-d') }}</td>
            <td>{{ $parameterVAT->end_date == null ? '' : $parameterVAT->end_date->format('Y-m-d') }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['parameterVATs.destroy', $parameterVAT->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        {{-- <a href="{{ route('parameterVATs.show', [$parameterVAT->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a> --}}
                        <a href="{{ route('parameterVATs.edit', [$parameterVAT->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {{-- {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
