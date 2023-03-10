<div class="table-responsive">
    <table class="table table-bordered" id="categoryMinOrders-table">
        <thead>
        <tr class="bg-info">
            <th>{{trans('category_min_order.category')}}</th>
            <th>{{ trans('category_min_order.minimum_order') }}</th>
            <th>{{ trans('category_min_order.start_date') }}</th>
            <th>{{ trans('category_min_order.end_date') }}</th>
            <th>{{ trans('category_min_order.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categoryMinOrders as $categoryMinOrder)
            <tr>
                <td>{{ $categoryMinOrder->category == 'DR' ? 'DR - Distributor' : 'DK - Agen' }}</td>
                <td class="money text-bold">Rp. {{ number_format($categoryMinOrder->minimum_order, 0, ',', '.') }}</td>
                <td>{{ $categoryMinOrder->start_date->format('Y-m-d') }}</td>
                <td>{{ $categoryMinOrder->end_date == null ? '' : $categoryMinOrder->end_date->format('Y-m-d') }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['categoryMinOrders.destroy', $categoryMinOrder->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @can('view category minimum orders')
                        <a href="{{ route('categoryMinOrders.show', [$categoryMinOrder->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        @endcan
                        @can('edit category minimum orders')
                        <a href="{{ route('categoryMinOrders.edit', [$categoryMinOrder->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        @endcan
                        @can('delete category minimum orders')
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
@push('page_scripts')
    <script>
    $(document).ready(function() {
        $('#categoryMinOrders-table').DataTable({
            columnDefs: [
                { orderable: false, targets: 4 }
            ],
        });
    });
    </script>
@endpush