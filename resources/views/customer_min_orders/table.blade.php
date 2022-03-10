<div class="table-responsive">
    <table class="table table-bordered" id="customerMinOrders-table">
        <thead>
        <tr class="bg-info">
            <th>Customer</th>
            <th>Minimum Order</th>
            <th>Date Add</th>
            <th width="1%">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customerMinOrders as $customerMinOrder)
            <tr>
                <td>{{ $customerMinOrder->customer->AcctName }} - {{ $customerMinOrder->customer_code }}</td>
                <td class="text-bold money">Rp. {{ number_format($customerMinOrder->minimum_order, 0, ',', '.') }}</td>
                <td>{{ $customerMinOrder->created_at->format('Y-m-d') }}</td>
                <td>
                    {!! Form::open(['route' => ['customerMinOrders.destroy', $customerMinOrder->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('customerMinOrders.show', [$customerMinOrder->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        {{-- <a href="{{ route('customerMinOrders.edit', [$customerMinOrder->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a> --}}
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
        $('#customerMinOrders-table').DataTable({
            columnDefs: [
                { orderable: false, targets: 3 }
            ],
        });
    });
    </script>
@endpush