<div class="table-responsive" @can('hide price sales order') style="visibility: collapse" @endcan>
    <table class="table table-hover text-center" id="attachments-table">
        {{-- <thead>
        <tr>
            <th>{{ trans('mail.type') }}</th>
            <th>{{ trans('add.image') }}</th>
            <th>{{ trans('add.action') }}</th>
        </tr>
        </thead> --}}
        <tbody>
        @foreach($attachments as $attachment)
            <tr>
                <td>{{ $attachment->type }}</td>
                <td><img src="{{ asset('uploads/attachments/'.$attachment->image) }}" alt="" width="200px"></td>
                @if ($salesOrder->status == 'R')
                <td>
                    {!! Form::open(['route' => ['attachments.destroy', $attachment->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
