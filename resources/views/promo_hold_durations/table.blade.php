<div class="table-responsive">
    <table class="table table-bordered" id="promoHoldDurations-table">
        <thead>
        <tr class="bg-info">
            <th>{{ trans('promo_hold_duration.packet_type') }}</th>
            <th>{{ trans('promo_hold_duration.duration_in_day') }}</th>
            <th>{{ trans('promo_hold_duration.start_date') }}</th>
            <th>{{ trans('promo_hold_duration.end_date') }}</th>
            <th>{{ trans('promo_hold_duration.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($promoHoldDurations as $promoHoldDuration)
            <tr>
                <td>{{ $promoHoldDuration->packet_type }}</td>
                <td>{{ $promoHoldDuration->duration_in_day }} day(s)</td>
                <td>{{ $promoHoldDuration->start_date }}</td>
                <td>{{ $promoHoldDuration->end_date }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['promoHoldDurations.destroy', $promoHoldDuration->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('promoHoldDurations.show', [$promoHoldDuration->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('promoHoldDurations.edit', [$promoHoldDuration->id]) }}"
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
@push('page_scripts')
    <script>
    $(document).ready(function() {
        $('#promoHoldDurations-table').DataTable({
            columnDefs: [
                { orderable: false, targets: 2 }
            ],
        });
    });
    </script>
@endpush