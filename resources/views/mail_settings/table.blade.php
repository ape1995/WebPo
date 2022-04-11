<div class="table-responsive">
    <table class="table table-hover" id="mailSettings-table">
        <thead>
        <tr class="bg-info">
            <th>{{ trans('parameter.name') }}</th>
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
                <td>{{ $mailSetting->name }}</td>
                <td>{{ $mailSetting->type }}</td>
                <td>{{ $mailSetting->sub_type }}</td>
                <td>{{ $mailSetting->email }}</td>
                <td>{{ $mailSetting->status == true ? 'active' : 'inactive' }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['mailSettings.destroy', $mailSetting->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @can('view mail setting')
                        <a href="{{ route('mailSettings.show', [$mailSetting->id]) }}" title="view"
                           class='btn btn-outline-dark btn-xs' title="View">
                            <i class="far fa-eye"></i>
                        </a>
                        @endcan
                        @can('edit mail setting')
                        <a href="{{ route('mailSettings.edit', [$mailSetting->id]) }}" title="edit"
                           class='btn btn-outline-dark btn-xs' title="Edit">
                            <i class="far fa-edit"></i>
                        </a>
                        @endcan
                        @if ($mailSetting->type == 'Receiver')    
                            @if ($mailSetting->status == 1)
                                @can('inactive mail setting')
                                {!! Form::button('<i class="fas fa-ban"></i>', ['title' => 'inactive', 'type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure to inactive?')"]) !!}
                                @endcan
                            @endif
                            @if ($mailSetting->status == 0)
                                @can('active mail setting')
                                <a href="{{ route('mailSettings.active', [$mailSetting->id]) }}" class='btn btn-outline-success btn-xs' title='Active' onclick="return confirm('are you sure to active?')"><i class="fa fa-check-circle"></i></a>
                                @endcan
                            @endif
                        @endif
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
