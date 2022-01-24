<div class="table-responsive">
    <table class="table" id="mailSettings-table">
        <thead>
        <tr>
            <th>{{ trans('mail.type') }}</th>
            <th>{{ trans('mail.sub_type') }}</th>
            <th>{{ trans('mail.email') }}</th>
            <th>{{ trans('mail.status') }}</th>
            <th>{{ trans('mail.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($mailSettings as $mailSetting)
            <tr>
                <td>{{ $mailSetting->type }}</td>
                <td>{{ $mailSetting->sub_type }}</td>
                <td>{{ $mailSetting->email }}</td>
                <td>{{ $mailSetting->status == true ? 'active' : 'inactive' }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['mailSettings.destroy', $mailSetting->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('mailSettings.show', [$mailSetting->id]) }}" title="view"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('mailSettings.edit', [$mailSetting->id]) }}" title="edit"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="fas fa-ban"></i>', ['title' => 'inactive', 'type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
