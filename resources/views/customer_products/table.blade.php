<div class="table-responsive">
    <table class="table" id="customerProducts-table">
        <thead>
        <tr class="bg-info">
            <th>Customer</th>
            <th>Inventory Code</th>
            <th>Customer Class</th>
            <th>Date Add</th>
            <th width="1%">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customerProducts as $customerProduct)
            <tr>
                <td>{{ $customerProduct->customer_code }} - {{ $customerProduct->customer->AcctName }}</td>
                <td>{{ $customerProduct->inventory_code }} - {{ $customerProduct->product->Descr }}</td>
                <td>{{ $customerProduct->customer_class }}</td>
                <td>{{ $customerProduct->created_at->format('Y-m-d') }}</td>
                <td>
                    {!! Form::open(['route' => ['customerProducts.destroy', $customerProduct->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        {{-- <a href="{{ route('customerProducts.show', [$customerProduct->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('customerProducts.edit', [$customerProduct->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a> --}}
                        @can('delete customer products')
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
        var table = $('#customerProducts-table').DataTable({
            columnDefs: [
                { orderable: false, targets: 4 }
            ],
        });

        $("#customer_id").change(function() { 
            var val = [];
            val.push($('#customer_id').val());
            table.search(val.join(' ')).draw();   
        });
    });

    
    </script>
@endpush