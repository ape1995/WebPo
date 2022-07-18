<div class="table-responsive">
    <table class="table" id="bundlingProducts-table">
        <thead>
        <tr>
            <th>Start Date</th>
        <th>End Date</th>
        <th>Product Code</th>
        <th>Qty</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($bundlingProducts as $bundlingProduct)
            <tr>
                <td>{{ $bundlingProduct->start_date }}</td>
            <td>{{ $bundlingProduct->end_date }}</td>
            <td>{{ $bundlingProduct->product_code }}</td>
            <td>{{ $bundlingProduct->qty }}</td>
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
