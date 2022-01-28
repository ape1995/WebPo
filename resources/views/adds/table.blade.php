<div class="table-responsive">
    <table class="table" id="adds-table">
        <thead>
        <tr>
            <th>{{ trans('add.name') }}</th>
            <th>{{ trans('add.image') }}</th>
            <th>{{ trans('add.desc') }}</th>
            <th>{{ trans('add.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($adds as $add)
            <tr>
                <td width="20%">{{ $add->name }}</td>
                <td><img src="{{ asset('uploads/adds/'.$add->image) }}" class="img-rounded" width="200px"></td>
                <td>{{ $add->description }}</td>
                <td>
                    {!! Form::open(['route' => ['adds.destroy', $add->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('adds.show', [$add->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('adds.edit', [$add->id]) }}"
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
