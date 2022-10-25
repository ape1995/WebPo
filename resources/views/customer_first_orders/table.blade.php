<div class="table-responsive">
    <table class="table table-bordered" id="customerFirstOrders-table">
        <thead>
        <tr class="bg-info">
            <th>{{ trans('customer_first_order.customer') }}</th>
            <th>{{ trans('customer_first_order.first_order_number') }}</th>
            <th>{{ trans('customer_first_order.first_order_date') }}</th>
            <th>{{ trans('customer_first_order.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customerFirstOrders as $customerFirstOrder)
            <tr>
                @php
                    $date1 = new DateTime($customerFirstOrder->first_order_date);
                    $date2 = new DateTime(now());
                    $interval = $date1->diff($date2);
                    $days = $interval->format('%a');
                @endphp
                <td>{{ $customerFirstOrder->customer_code }} - {{ $customerFirstOrder->customer->AcctName }}</td>
                <td>{{ $customerFirstOrder->first_order_number }}</td>
                <td>{{ $customerFirstOrder->first_order_date->format('Y-m-d') }} (  {{$days}} days )</td>
                <td width="120">
                    {!! Form::open(['route' => ['customerFirstOrders.destroy', $customerFirstOrder->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        {{-- <a href="{{ route('customerFirstOrders.show', [$customerFirstOrder->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a> --}}
                        <a href="{{ route('customerFirstOrders.edit', [$customerFirstOrder->id]) }}"
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
@push('page_scripts')
    <script>
    $(document).ready(function() {
        $('#customerFirstOrders-table').DataTable({
            columnDefs: [
                { orderable: false, targets: 3 }
            ],
        });
    });
    </script>
@endpush
