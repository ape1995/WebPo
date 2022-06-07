<div class="table-responsive">
    <table class="table" id="dsRules-table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Status</th>
            <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($dsRules as $dsRule)
            <tr>
                <td>{{ $dsRule->name }}</td>
            <td>{{ $dsRule->status }}</td>
                <td width="120">
                    {{-- {!! Form::open(['route' => ['dsRules.destroy', $dsRule->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('dsRules.show', [$dsRule->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('dsRules.edit', [$dsRule->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!} --}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
