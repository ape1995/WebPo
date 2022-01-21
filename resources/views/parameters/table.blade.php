<div class="table-responsive">
    <table class="table" id="parameters-table">
        <thead>
        <tr>
            <th>{{ trans('parameter.name') }}</th>
            {{-- <th>Parameter String</th>
            <th>Parameter Date</th> --}}
            <th>{{ trans('parameter.parameter_hour') }}</th>
            {{-- <th>Parameter Number</th> --}}
            <th>{{ trans('parameter.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($parameters as $parameter)
            <tr>
                <td>{{ $parameter->name }}</td>
                {{-- <td>{{ $parameter->parameter_string }}</td>
                <td>{{ $parameter->parameter_date }}</td> --}}
                <td>{{ $parameter->parameter_hour }}</td>
                {{-- <td>{{ $parameter->parameter_number }}</td> --}}
                <td width="120">
                    {!! Form::open(['route' => ['parameters.destroy', $parameter->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @can('create parameter')
                        <a href="{{ route('parameters.show', [$parameter->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        @endcan
                        @can('edit parameter')
                        <a href="{{ route('parameters.edit', [$parameter->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        @endcan
                        @can('delete parameter')
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        @endcan
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
