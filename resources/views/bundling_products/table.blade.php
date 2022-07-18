<div class="table-responsive">
    <table class="table table-sm table-hover table-bordered" id="bundlingProducts-table">
        <thead>
            <tr class="bg-info">
            <th>Start Date</th>
            <th>End Date</th>
            <th>Buy</th>
            <th>Free Items</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($bundlingProducts as $bundlingProduct)
            <tr>
                <td>{{ $bundlingProduct->start_date->format('Y-m-d') }}</td>
                <td>{{ $bundlingProduct->end_date == null ? '' : $bundlingProduct->end_date->format('Y-m-d') }}</td>
                <td>{{ $bundlingProduct->product_code }} - {{ $bundlingProduct->product->Descr }} ( {{ $bundlingProduct->qty }} pcs ) </td>
                <td>
                    <ul>
                        @foreach ($bundlingProduct->detail as $detail)
                        <li>
                            {{ $detail->product_code }} - 
                            {{ $detail->product->Descr }} (
                            {{ $detail->qty }} pcs )
                        </li>
                        @endforeach
                    </ul>
                </td>
                <td width="120">
                    {!! Form::open(['route' => ['bundlingProducts.destroy', $bundlingProduct->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('bundlingProducts.show', [$bundlingProduct->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('bundlingProducts.edit', [$bundlingProduct->id]) }}"
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
        $('#bundlingProducts-table').DataTable({
            // columnDefs: [
            //     { orderable: false, targets: 4 }
            // ],
        });
    });
    </script>
@endpush