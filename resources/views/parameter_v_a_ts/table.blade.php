<div class="table-responsive">
    <table class="table table-hover" id="parameterVATs-table">
        <thead>
        <tr class="bg-info">
            <th>{{ trans('vat.name') }}</th>
            <th>{{ trans('vat.value') }}</th>
            <th>{{ trans('vat.start_date') }}</th>
            <th>{{ trans('vat.end_date') }}</th>
            <th>{{ trans('vat.action') }}</th>
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
                        @can('edit tax')
                        <a href="{{ route('parameterVATs.edit', [$parameterVAT->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        @endcan
                        {{-- {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
