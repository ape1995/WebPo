<div class="table-responsive">
    <table class="table" id="testImports-table">
        <thead>
        <tr>
            <th>Name</th>
        <th>Email</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($testImports as $testImport)
            <tr>
                <td>{{ $testImport->name }}</td>
            <td>{{ $testImport->email }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['testImports.destroy', $testImport->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('testImports.show', [$testImport->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('testImports.edit', [$testImport->id]) }}"
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
