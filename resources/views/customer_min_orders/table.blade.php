<div class="table-responsive">
    <table class="table table-bordered" id="customerMinOrders-table">
        <thead>
        <tr class="bg-info">
            <th>Customer</th>
            <th>Minimum Order</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th width="120">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customerMinOrders as $customerMinOrder)
            <tr>
                <td>{{ $customerMinOrder->customer->AcctName }} - {{ $customerMinOrder->customer_code }}</td>
                <td class="text-bold money">Rp. {{ number_format($customerMinOrder->minimum_order, 0, ',', '.') }}</td>
                <td>{{ $customerMinOrder->start_date == null ? '' : date('Y-m-d', strtotime($customerMinOrder->start_date)) }}</td>
                <td>{{ $customerMinOrder->end_date == null ? '' : date('Y-m-d', strtotime($customerMinOrder->end_date)) }}</td>
                <td>
                    {!! Form::open(['route' => ['customerMinOrders.destroy', $customerMinOrder->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        @can('view min orders')
                        <a href="{{ route('customerMinOrders.show', [$customerMinOrder->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        @endcan
                        @can('edit min orders')
                        <a href="{{ route('customerMinOrders.edit', [$customerMinOrder->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        @endcan
                        @can('delete min orders')
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
        $('#customerMinOrders-table').DataTable({
            columnDefs: [
                { orderable: false, targets: 4 }
            ],
        });
    });
    </script>
@endpush